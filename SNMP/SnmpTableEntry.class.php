<?php
// vi: set ts=4 expandtab nu:
/**
 * File-level Doc-Block
 * @package SNMP
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version $Id: $;
 */

/**
 * SnmpTableEntry
 *
 * This class represents the basic class for a table entry within the SNMP-MIB-Tree
 *
 * It carries the column information for one row in a SNMP-table and is responsible for mapping
 * from the OID to a 'common-name' and back. It also give's write access to the OID.
 *
 * Since it implements ArrayAccess and Iterator it can be accessed like an Array or within an foreach-statement.
 *
 * Depending on the way an instance of this class was created the data for the row may already be loaded to the instance or not.
 * If a column is queried from the table the class check's wether or not the OID was loaded. If not this will be done at run-time, else 
 * the information will be parsed back from the internal-data buffer.
 *
 * This class can't be used directly. It needs child-classes, that define the real column-layout
 * @package SNMP
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version 0.1
 * @abstract
*/
abstract class SnmpTableEntry implements ArrayAccess, Iterator {

    /**
     * Table
     *
     * The SNMP-Table OID for this class. This has to be set within the childclass.
     *
     * e.g. {@link http://www.oidview.com/mibs/0/RFC1213-MIB.html .1.3.6.1.2.1.2.2} for the interface-table of a device.
     *
     * The OID has to be prepended with a dot at the moment and should be numeric. It's not tested with the SNMP-MIB-Name. 
     * I also would recommend to keep it numeric, since the MIB loading within PHP is not very well documented in my opinion.
     *
     * @var string
     */
    protected $table='.0.0';
    /**
     * @var string
     */
    protected $extend;
    /**
     * @var array
     */
    protected $map = array ();
    /**
     * @var array
     */
    protected $writemap = array ();

    /**#@+
     * @var string
     * @access private
     */
    private $row=0;
    private $position=0;
    private $data;
    private $RoCommunity;
    private $RwCommunity;
    /*#@-*/
    private $writeable;

    /**
     *
     */
    const IfEntry=1;

    /**
     * @param string $host The Hostname or the IP-address of the device that will be handled
     * @param string $RoCommunity The community string for read access to the device
     * @param integer $row The row number within the SNMP-table
     * @param array $data In case we already preloaded the data in the table object we can directly set it. This will reduce the amount of snmp-queries that need to be done
     * @param boolean $writeable define wether or not a write-access might be allowed to this entry. Nevertheless only fields that are listed in the writemap variable can be changed
     * @param string $RwCommunity The community string for write access to the device. If this is null and writeable is true the $RoCommunity-string will be taken
     * @todo improve documentation
     */ 
    public function __construct(SnmpConnect $connector,$row,$data=null) {
        $this->row = $row;
        $this->Connector = $connector;

        if (! $this->writemap) $writeable=false;

        if ($this->writemap) {
            $nmap=array();
            foreach ($this->writemap as $key=>$elem) {
                $nmap[strtolower($key)]=$elem;
                $nmap[$this->map[$key]]=$elem;
            }
            $this->writemap=$nmap;
        }
        if (! is_null($data)) $this->_parsedata($data);

    }

    /**
     * @todo improve documentation
     */ 
    protected function maptoindex($offset) {
        $val=$offset;
        if (is_numeric($offset)) {
            $val=$offset;
        } else {
            $val=$this->map[$offset];
        }
        if (! is_null($this->extend)) $val=$val.$this->extend;

        $oid=join('.',array($this->table,self::IfEntry,$val,$this->row));

        # print "Mapping $offset to $val\n";
        return $oid;
    }

    /**
     * @todo improve documentation
     */ 
    public function compare($str) {
        return null;
    }

    /**
     * @todo improve documentation
     */ 
    protected function _get($oid) {
        snmp_set_enum_print(TRUE);
        snmp_set_quick_print(FALSE);
        snmp_set_oid_numeric_print(TRUE);
        snmp_set_oid_output_format(SNMP_OID_OUTPUT_NUMERIC);
        $this->data[$oid]=null;
        if (! $erg=$this->Connector->snmpget($oid)) {
            # print "Error: OF: $offset Ty: $type ".$this->host." ".$this->RwCommunity." $oid -> $type -> $value \n";
            $erg=null;
        };
        $this->data[$oid]=$this->_parsevalue($erg);
    }

    /**
     * @todo improve documentation
     */ 
    protected function _set($offset,$oid,$value) {
        if ($this->readonly) throw new SnmpAccessException('Readonly');
        $type=$this->writemap[strtolower($offset)];
        if (is_null ($type)) throw new SnmpAccessException("Invalid write access to element '$offset' when setting to value '$value'");

        $this->data[$oid]=null;
        # Using @ in front of snmpset suppresses warnings
        # print "Set: $offset,$oid,$value\n";
        if (! $this->Connector->snmpset($oid,$type,$value)) {
            print "Error: OF: $offset Ty: $type ".$this->host." ".$this->RwCommunity." $oid -> $type -> $value \n";
        };
        $erg=$this->Connector->snmpget($this->host,$this->RoCommunity,$oid);
        $this->data[$oid]=$this->_parsevalue($erg);
    }

    /**
     * @todo improve documentation
     */ 
    protected function _parsedata($data) {
        $map=0;
        foreach ($data as $oid=>$elem) {
            $this->data[$oid]=$this->_parsevalue($elem);
        }
    }

    /**
     * @todo improve documentation
     */ 
    protected function _parsevalue($input) {
        if (is_null($input)) return array ('type'=>null,'value'=>null);

        list($type,$value)=explode(': ',$input,2);

        if ($type=='INTEGER') {

            if (preg_match('/(.+)\((\d+)\)/',$value,$matches)) {
                $value=$matches[2];
                $mapping=$matches[1];
            }

        } elseif ($type=='Timeticks') {

            if (preg_match('/\((\d+)\)\s(.+)/',$value,$matches)) {
                $value=$matches[1];
                $mapping=$matches[2];
            }

        } elseif ($type=='STRING') {
            $value=preg_replace('/"/','',$value);
#            if (preg_match('/([0-9a-f]{1-2}:){5}[0-9a-f]{1-2}/',$this->value)) {
#                $this->subtype='MAC';
#            }
        }

        $result=array('type' => $type, 'value' => $value);
        if ($mapping) $result['mapping']=$mapping;
        return $result;
    }


    /**
     * @todo improve documentation
     */ 
    public function getheader() {
        return array_keys($this->map);
    }

    /**
     * @todo improve documentation
     */ 
    protected function _load() {
        foreach ($this->map as $key=>$elem) {
            $this->offsetGet($key);
        }
    }

    /**
     * @param string|integer $offset Offset to retrieve
     * @returns mixed The value for the given offset within the array
     * @throws SnmpInvalidAttributeException
     */
    public function offsetGet($offset) { # Implements ArrayAccess::offsetGet
        $oid=$this->maptoindex($offset);
        if (is_null($oid)) throw new SnmpInvalidAttributeException();

        # print "Getting data for offset: $this->table:".self::IfEntry.":$map:$this->row $offset => $oid \n";

        if (is_null($this->data[$oid])) $this->_get($oid);
        return $this->data[$oid];
    }

    /**
     * @param string|integer $offset Offset to retrieve
     * @param mixed $value The value that should be set
     * @throws UnexpectedValueException
     * @throws OutOfBoundsException
     */
    public function offsetSet($offset, $value) { # Implements ArrayAccess:offsetSet
        if (is_null($offset)) {
            throw new OutOfBoundsException();
        } else {
            $oid=$this->maptoindex($offset);
            if (is_null($oid)) throw new UnexpectedValueException();
            $this->_set($offset,$oid,$value);
        }
    }

    /**
     * remove an entry from the 'array'
     *
     * this function always throws a BadFunctionCallException, since it is not allowed to delete
     * a OID from the MIB-tree. So if you try an exception will be raised.
     * @param string|integer $offset offset that should be deleted
     * @throws BadFunctionCallException
     */
    public function offsetUnset($offset) {  # Implements ArrayAccess:offsetUnset
        throw new BadFunctionCallException();
    }

    /**
     * @param string|integer $offset Offset to retrieve
     * @param mixed $value The value that should be set
     * @throws UnexpectedValueException
     * @throws OutOfBoundsException
     */
    public function offsetExists($offset) { # Implements ArrayAccess:offsetExists
        print "Searching for offset: $offset\n";
        if (is_null($this->data)) $this->_load();
        return array_key_exists($this->data, $offset);
    }
 
    /**
     * @todo improve documentation
     */ 
    public function rewind() { # Implements Iterator::rewind
        $this->position = 0;
    }

    /**
     * @todo improve documentation
     */ 
    public function valid() { # Implements Iterator::valid
        return $this->position < sizeof(array_keys($this->map));
    }
 
    /**
     * @todo improve documentation
     */ 
    public function key() { # Implements Iterator::key
        $keys=array_keys($this->map);
        return $keys[$this->position];
    }
 
    /**
     * @todo improve documentation
     */ 
    public function current() { # Implements Iterator::current
        $keys=array_keys($this->map);
        $key=$keys[$this->position];
        $oid=$this->maptoindex($key);
        if (is_null($this->data[$oid])) $this->_get($oid);
        return $this->data[$oid];
    }
 
    /**
     * @todo improve documentation
     */ 
    public function next() { # Implements Iterator::next
        $this->position++;
    }

    /**
     * @return string The string representation of this object
     */
    public function __tostring() {
        $result='';
        if (is_null($this->data)) $this->_load();
        foreach ($this->data as $key=>$elem) {
            if (is_null($elem['value'])) $elem['value']='--NULL--';
            $result.=$elem['value']." ";
        }
        return $result;
    }
}

?>
