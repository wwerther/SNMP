<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Entries
 */
class vLanEntry extends SnmpTableEntry {
    protected $table='.1.3.6.1.4.1.207.8.9.2.5.2.1.1';
    protected $map=array (
        'vLanNumber'        => 1,
        'vLanMembers'       => 2,
        'vLanDescription'   => 3,
        'vLanAdminStatus'   => 4,
        'vLanOperStatus'    => 5,
        'vLanMode'          => 6,
        'vLanRowStatus'     => 7
    );
}
?>
