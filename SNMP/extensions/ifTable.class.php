<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Tables
 */
class ifTable extends SnmpTable {
    protected $table='.1.3.6.1.2.1.2.2';
    protected function _SnmpTableEntry($row,$data=null) {
        return new ifEntry($this->Connector,$row,$data);
    }
}
?>
