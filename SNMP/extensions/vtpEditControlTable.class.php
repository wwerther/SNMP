<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Tables
 */
class vtpEditControlTable extends SnmpTable {
    protected $table='.1.3.6.1.4.1.9.9.46.1.4.1';

    protected function _SnmpTableEntry($row,$data=null) {
        return new vtpEditControlEntry($this->Connector,$row,$data);
    }
}
?>
