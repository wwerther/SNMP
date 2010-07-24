<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Entries
 */
class entPhysicalEntry extends SnmpTableEntry {
    protected $table='.1.3.6.1.4.1.9.9.46.1.4.1';
    protected $map=array(
        'entPhysicalIndex'  => 1,
        'entPhysicalDescr' => 2,
        'entPhysicalVendorType' => 3,
        'entPhysicalContainedIn' => 4,
        'entPhysicalClass' => 5,
        'entPhysicalParentRelPos' => 6,
        'entPhysicalName' => 7,
        'entPhysicalHardwareRev' => 8,
        'entPhysicalFirmwareRev' => 9,
        'entPhysicalSoftwareRev' => 10,
        'entPhysicalSerialNum' => 11,
        'entPhysicalMfgName' => 12,
        'entPhysicalModelName' => 13,
        'entPhysicalModelName' => 14,
        'entPhysicalAssetID' => 15,
        'entPhysicalIsFRU' => 16
    ); 
}
?>
