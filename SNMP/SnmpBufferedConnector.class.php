<?php
// vi: set ts=4 expandtab nu:

/**
 * @package SNMP
 * @subpackage BufferedConnector
 */
class SnmpBufferedConnector implements SnmpBufferedConnect {
    /**
     *
     */
    public function __construct(SnmpRealConnect $connect) {
        $this->Connector=$connect;
    }

    public function snmprealwalk ($oid) {
        return $this->Connector->snmprealwalk($oid);
    }

    public function snmpget ($oid) {
        return $this->Connector->snmpget($oid);
    }

    public function snmpset ($oid,$type,$value) {
        return $this->Connector->snmpset($oid,$type,$value);
    }

    public function __tostring () {
        return __class__." ".$this->Connector;
    }

}


?>
