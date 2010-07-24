<?php
// vi: set ts=4 expandtab nu:

/**
 * @package SnmpTables
 * @subpackage Tables
 */
class vLanTable extends SnmpTable {
    protected $table='.1.3.6.1.4.1.207.8.9.2.5.2.1.1';

    protected function _SnmpTableEntry($row,$data=null) {
        return new vlanEntry($this->Connector,$row,$data);
    }

}
?>
