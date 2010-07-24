<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Entries
 */
class vmMembershipEntry extends SnmpTableEntry {
    protected $table='.1.3.6.1.4.1.9.9.68.1.2.2';
    protected $map=array (
        'vmVlanType'        => 1,
        'vmVlan'            => 2,
        'vmPortStatus'      => 3,
        'vmVlans'           => 4,
        'vmVlans2k'         => 5,
        'vmVlans3k'         => 6,
        'vmVlans4k'         => 7
    );
    protected $writemap = array (
        'vmVlan'   => 'i'
    );
}
?>
