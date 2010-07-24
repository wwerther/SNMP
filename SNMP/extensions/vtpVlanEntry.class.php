<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Entries
 */
class vtpVlanEntry extends SnmpTableEntry {
    protected $table='.1.3.6.1.4.1.9.9.46.1.3.1';
    protected $extend='.1';
    protected $map=array(
        'vtpVlanIndex'      => 1,
        'vtpVlanState' => 2,
        'vtpVlanType' => 3,
        'vtpVlanName' => 4,
        'vtpVlanMtu' => 5,
        'vtpVlanDot10Said' => 6,
        'vtpVlanRingNumber' => 7,
        'vtpVlanBridgeNumber' => 8,
        'vtpVlanStpType' => 9,
        'vtpVlanParentVlan' => 10,
        'vtpVlanTranslationalVlan1' => 11,
        'vtpVlanTranslationalVlan2' => 12,
        'vtpVlanBridgeType' => 13,
        'vtpVlanAreHopCount' => 14,
        'vtpVlanSteHopCount' => 15,
        'vtpVlanIsCRFBackup' => 16,
        'vtpVlanTypeExt' => 17,
        'vtpVlanIfIndex' => 18
    );

    public function compare($str) {
        return strcasecmp($this['vtpVlanName']['value'],$str);
    }
}
?>
