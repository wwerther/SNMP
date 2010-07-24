<?php
// vi: set ts=4 expandtab nu:

/**
 * @package SNMP
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version $Id: $;
 */
abstract class SnmpDevice {
    protected $Connector;

    protected $systeminfo;


    public function __construct(SnmpConnect $connector) {
        $this->Connector = $connector;

        $this->systeminfo=new SystemTree($this->Connector);
    }

    public function __tostring() {
        $result.="Connector: ".$this->Connector."\n";
        $result.="Location: ".$this->systeminfo['sysLocation']['value']."\n";
        $result.="Name: ".$this->systeminfo['sysName']['value']."\n";
        $result.="Contact: ".$this->systeminfo['sysContact']['value']."\n";
        return $result;
    }

}
?>
