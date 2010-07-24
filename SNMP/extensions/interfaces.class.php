<?php

/**
 * @package SnmpTables
 * @subpackage SnmpMergeTable
 */
class interfaces extends SnmpMergeTable {
    public function __construct(SnmpConnect $connector) {
        $this->tables['ifTable']=new ifTable($connector);
        $this->tables['ifXTable']=new ifXTable($connector);
        $this->tables['vmMembershipTable']=new vmMembershipTable($connector);

        parent::__construct($connector);
    }

};
?>
