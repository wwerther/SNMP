<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTrees
 */
class SystemTree extends SnmpTree {
    protected $table='.1.3.6.1.2.1.1';
    protected $map=array(
        'sysDescr'  => 1,
        'sysObjectID'  => 2,
        'sysUpTime'  => 3,
        'sysContact'  => 4,
        'sysName'  => 5,
        'sysLocation'  => 6,
        'sysServices'  => 7
    );
    protected $writemap = array (
        'sysLocation'   => 's',
        'sysContact'   => 's'
    );
};
?>
