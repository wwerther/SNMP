<?php
// vi: set ts=4 expandtab nu:

/**
 * @package SNMP
 * @subpackage RealConnector
 * @todo to be implemented
 */
class SnmpV2Connect implements SnmpRealConnect {

    protected $host;
    protected $RoCommunity;
    protected $RwCommunity;
    protected $writeable;

    /**
     * @param string $host Hostname or IP-address of device that should be accessed
     * @param string $RoCommunity Read-Community
     * @param boolean $writeable Can we write to the device
     * @param string $RwCommunity Write-Community
     */
    public function __construct($host,$RoCommunity,$writeable=false,$RwCommunity=null) {
        $this->host = $host;
        $this->RoCommunity = $RoCommunity;

        $this->writeable=$writeable; if ($writeable && is_null($RwCommunity)) $RwCommunity=$RoCommunity; if (! $writeable) $RwCommunity=null;
        $this->RwCommunity=$RwCommunity;
    }

    /**
     * Return all values when doing a walk trough the MIB-tree starting at $oid
     * @param string $oid the OID where we're going to start our walk
     * @return array
     */
    public function snmprealwalk ($oid) {
        return @snmprealwalk($this->host, $this->RoCommunity, $oid);
    }

    /**
     * Return the value of a given OID in MIB-tree
     * @param string $oid the OID of the value we want to get in return
     * @return string
     */
    public function snmpget ($oid) {
        return @snmpget($this->host,$this->RoCommunity,$oid);
    }

    /**
     * Set a OID to a value
     * @param string $oid the OID that we won't to change
     * @param string $type the type of the oid
     * @param string $value the value we want to set the oid to
     */
    public function snmpset ($oid,$type,$value) {
        return @snmpset($this->host,$this->RwCommunity,$oid,$type,$value);
    }

    public function __tostring() {
        $access='ro'; if ($this->writeable) $access='rw';
        return __class__.": $this->host Access: $access RoC: $this->RoCommunity RwC: $this->RwCommunity"; 
    }

}


?>
