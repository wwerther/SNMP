<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Tables
 */
class entPhysicalTable extends SnmpTable {
    protected $table='.1.3.6.1.2.1.47.1.1.1';

    protected function _SnmpTableEntry($row,$data=null) {
        return new entPhysicalEntry($this->Connector,$row,$data);
    }
}

?>
