<?php
// vi: set ts=4 expandtab nu:

/**
 * @package SnmpTables
 * @subpackage Entries
 */
class vtpEditControlEntry extends SnmpTableEntry {
    protected $table='.1.3.6.1.4.1.9.9.46.1.4.1';
    protected $map=array(
        'vtpVlanEditOperation' => 1,
        'vtpVlanApplyStatus' => 2,
        'vtpVlanEditBufferOwner' => 3,
        'vtpVlanEditConfigRevNumber' => 4,
        'vtpVlanEditModifiedVlan' => 5
    );

    protected $writemap=array(
        'vtpVlanEditBufferOwner' => 's',
        'vtpVlanEditOperation' => 'i',
    );

}
?>
