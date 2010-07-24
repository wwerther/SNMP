<?php
// vi: set ts=4 expandtab nu:
/**
 * File-level Doc-Block
 * @package SNMP
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version $Id: $;
 */

/**
 * The SnmpConnect-interface provides a common access to snmp-devices
 *
 * this interface is used to abstract the snmp-connection from it's version e.g. v1, v2c, v3...
 * @package SNMP
 */
interface SnmpConnect {

    /**
     * Return all values when doing a walk trough the MIB-tree starting at $oid
     * @param string $oid the OID where we're going to start our walk
     * @return array
     */
    public function snmprealwalk ($oid);

    /**
     * Return the value of a given OID in MIB-tree
     * @param string $oid the OID of the value we want to get in return
     * @return string
     */
    public function snmpget ($oid);

    /**
     * Set a OID to a value
     *
     * Taken from {@link http://de.php.net/manual/de/function.snmpset.php#1192 Php Manual SnmpSet}:
     * The "type" parameter must be one of the following, depending on the type of variable to set on the SNMP host:
     *  - i    INTEGER
     *  - u    unsigned INTEGER
     *  - t    TIMETICKS
     *  - a    IPADDRESS
     *  - o    OBJID
     *  - s    STRING
     *  - x    HEX STRING
     *  - d    DECIMAL STRING
     *  - n    NULLOBJ
     *  - b    BITS
     * If OPAQUE_SPECIAL_TYPES was defined while compiling the SNMP library, the following are also valid:
     *  - U    unsigned int64
     *  - I    signed int64
     *  - F    float
     *  - D    double
    * As an example, using "i" would set an integer, and "s" would set a string.  If the SNMP host rejects the data type, you might get the following message: "Warning: Error in packet. Reason: (badValue) The value given has the wrong type or length."
    *
    * If you specify an unknown or invalid OID, you might get a "Could not add variable" message.  When specifying an absolute OID (one that is already resolved) that is completely numeric, prepend it with a period.  For example, an OID that could enable/disable Ethernet ports on an Asante hub might be "1.3.6.1.2.1.22.1.3.1.1.3.6.4.0", but you would need to use ".1.3.6.1.2.1.22.1.3.1.1.3.6.4.0" in the OID parameter so that the SNMP library won't try to resolve an already resolved OID.  Friendly, unresolved OIDs do not need the period prepended, such as "system.SysContact.0"
     * @param string $oid the OID that we won't to change
     * @param string $type the type of the oid
     * @param string $value the value we want to set the oid to
     */
    public function snmpset ($oid,$type,$value);

    /**
     * Returns string representation of object
     */
    public function __tostring();
}

?>
