<?php
// vi: set ts=4 expandtab nu:

/**
 * @package SnmpTables
 * @subpackage Tables
 */
class vmMembershipTable extends SnmpTable {
    protected $table='.1.3.6.1.4.1.9.9.68.1.2.2';

    protected function _SnmpTableEntry($row,$data=null) {
        return new vmMembershipEntry($this->Connector,$row,$data);
    }

}
?>
