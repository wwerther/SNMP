<?php
// vi: set ts=4 expandtab nu:
/**
 * @package SnmpTables
 * @subpackage Entries
 */
class ifEntry extends SnmpTableEntry {
    protected $table='.1.3.6.1.2.1.2.2';
    protected $map = array (
        'ifIndex'           => 1,
        'ifDescr'           => 2,
        'ifType'            => 3,
        'ifMtu'             => 4,
        'ifSpeed'           => 5,
        'ifPhysAddress'     => 6,
        'ifAdminStatus'     => 7,
        'ifOperStatus'      => 8,
        'ifLastChange'      => 9,
        'ifInOctets'        => 10,
        'ifInUcastPkts'     => 11,
        'ifInNUcastPkts'    => 12,
        'ifInDiscards'      => 13,
        'ifInErrors'        => 14,
        'ifInUnknownProtos' => 15,
        'ifOutOctets'       => 16,
        'ifOutUcastPkts'    => 17,
        'ifOutNUcastPkts'   => 18,
        'ifOutDiscards'     => 19,
        'ifOutErrors'       => 20,
        'ifOutQLen'         => 21,
        'ifSpecific'        => 22
    );

    public function compare($str) {
        return strcasecmp($this['ifDescr']['value'],$str);
    }
}
?>
