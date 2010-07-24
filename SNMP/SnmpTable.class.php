<?php
// vi: set ts=4 expandtab nu:
/**
 * File-level Doc-Block
 * @package SNMP
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version $Id: tags.version.pkg,v 1.2 2006-04-29 04:08:27 cellog Exp $;
 */

abstract class SnmpTable implements ArrayAccess, Iterator {

    private $data;
    private $position;
    protected $RoCommunity;
    protected $RwCommunity;
    protected $writeable;
    protected $host;
    private $loaded;

    public $headerfields;
 
    public function __construct(SnmpConnect $connector) {
        $this->Connector = $connector;

        $entry=$this->_SnmpTableEntry(0);
        if (! is_null($entry)) $this->headerfields=$this->_SnmpTableEntry(0)->getheader();
      }

    public function offsetExists($offset) {
    }
 
    public function offsetGet($offset) {

        $offset=$this->maptoindex($offset);

        if (is_null($offset)) return null;
        if (is_null($this->data[$offset])) $this->data[$offset]=$this->_SnmpTableEntry($offset);

        return $this->data[$offset];

    }

    public function maptoindex($offset) {
        if (is_numeric($offset)) return $offset;
        if (! $this->loaded) $this->_load();
        foreach ($this->data as $key=>$elem) {
            if ($elem->compare($offset)==0) return $key;
        }
        return null;
    }   

    public function offsetSet($offset, $value) {
        throw new SnmpAccessException("SnmpTable is not writeable. Please select a single element to change");
    }
 
    public function offsetUnset($offset) {
        throw new SnmpAccessException("It's not possible to delete data-rows from a SnmpTable-Objet");
    }

 
    public function rewind() {
        rewind($this->data);
        $this->position = 1;
    }
 
    public function valid() {
        if (is_null($this->data)) $this->_load();
        return $this->position <= sizeof($this->data);
    }
 
    public function key() {
        return $this->position;
    }
 
    public function current() {
        if (is_null($this->data)) $this->_load();
        return $this->data[$this->position];
    }
 
    public function next() {
        $this->position++;
    }

    protected function _SnmpTableEntry($row,$data=null) {
        return null;
    }

    protected function _load() {

        $retval = array();
        $raw = $this->Connector->snmprealwalk($this->table);

        if (count($raw) == 0) return ($retval); // no data
   
        $prefix_length = 0;
        $largest = 0;
        $elcount=count(explode('.',$this->table))+1;
        foreach ($raw as $key => $value) {
            $keyn=array_slice(explode('.',$key),$elcount);
            $index=array_pop($keyn);
            $retval[$index][$key] = $value;
        }

        foreach($retval as $k => $x) {
            $retval[$k]=$this->_SnmpTableEntry($k,$x);
        }

        $this->data=$retval;
        $this->loaded=true;
    }

    public function __tostring() {
        if (! $this->loaded) $this->_load();
        $access='ro'; if ($writeable) $access='rw';
        $result='Class: '.get_class($this)." Access:".$access." RoC:".$this->RoCommunity." RwC:".$this->RwCommunity." Host:".$this->host." Table:".$this->table."\n";
        $result.=str_repeat('=',strlen($result)-1)."\n";
        $result.="Index ".implode(' ',$this->headerfields)."\n";
        foreach ($this->data as $key=>$elem) {
            $result.="$key: ".$elem."\n";
        }
        $result.="\n";
        return $result;
    }
}
?>
