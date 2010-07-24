<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Entries
 */
class ifXEntry extends SnmpTableEntry {
    protected $table='.1.3.6.1.2.1.31.1.1';
    protected $map = array (
        'ifName'                    => 1,
        'ifInMulticastPkts'         => 2,
        'ifInBroadcastPkts'         => 3,
        'ifOutMulticastPkts'        => 4,
        'ifOutBroadcastPkts'        => 5,
        'ifHCInOctets'              => 6,
        'ifHCInUcastPkts'           => 7,
        'ifHCInMulticastPkts'       => 8,
        'ifHCInBroadcastPkts'       => 9,
        'ifHCOutOctets'             => 10,
        'ifHCOutUcastPkts'          => 11,
        'ifHCOutMulticastPkts'      => 12,
        'ifHCOutBroadcastPkts'      => 13,
        'ifLinkUpDownTrapEnable'    => 14,
        'ifHighSpeed'               => 15,
        'ifPromiscuousMode'         => 16,
        'ifConnectorPresent'        => 17,
        'ifAlias'                   => 18,
        'ifCounterDiscontinuityTime'=> 19
    );

    protected $writemap = array (
        'ifAlias'   => 's'
    );

    public function compare($str) {
        if (strcasecmp($this['ifName']['value'],$str)==0) return 0;
        if (strcasecmp($this['ifAlias']['value'],$str)==0) return 0;
        return 1;
    }

}
?>
