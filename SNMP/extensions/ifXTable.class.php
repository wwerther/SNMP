<?php
// vi: set ts=4 expandtab nu:

/**
 * @package SnmpTables
 * @subpackage Tables
 */
class ifXTable extends SnmpTable {
    protected $table='.1.3.6.1.2.1.31.1.1';
    protected function _SnmpTableEntry($row,$data=null) {
        return new ifXEntry($this->Connector,$row,$data);
    }
}
?>
