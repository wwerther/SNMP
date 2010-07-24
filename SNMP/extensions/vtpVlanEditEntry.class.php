<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Entries
 */
class vtpVlanEditEntry extends SnmpTableEntry {
    protected $table='1.3.6.1.4.1.9.9.46.1.4.2';
    protected $extend='.1';
    protected $map=array(
        'vtpVlanEditIndex'  => 1,
        'vtpVlanEditState' => 2,
        'vtpVlanEditType' => 3,
        'vtpVlanEditName' => 4,
        'vtpVlanEditMtu' => 5,
        'vtpVlanEditDot10Said' => 6,
        'vtpVlanEditRingNumber' => 7,
        'vtpVlanEditBridgeNumber' => 8,
        'vtpVlanEditStpType' => 9,
        'vtpVlanEditParentVlan' => 10,
        'vtpVlanEditRowStatus' => 11,
        'vtpVlanEditTranslationalVlan1' => 12,
        'vtpVlanEditTranslationalVlan2' => 13,
        'vtpVlanEditBridgeType' => 14,
        'vtpVlanEditAreHopCount' => 15,
        'vtpVlanEditSteHopCount' => 16,
        'vtpVlanEditIsCRFBackup' => 17,
        'vtpVlanEditTypeExt' => 18,
        'vtpVlanEditTypeExt2' => 19
    );

    protected $writemap=array(
        'vtpVlanEditRowStatus' => 'i',
        'vtpVlanEditType' => 'i',
        'vtpVlanEditName' => 's'
    );
    
}
?>
