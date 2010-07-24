<?php
// vi: set ts=4 expandtab nu:

/**
 * @package Devices
 * @subpackage Cisco
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version $Id: $;
 */
class CiscoDevice extends SnmpDevice {

    /**
     * @todo to be filled with life. First determine the equipment-type and then auto-load the best matching device-class.
     */
    public static function factory(SnmpConnect $connector) {
        # -- Query for the type of device
        # if found than we will return an object using the given connector (e.g. Switch or Router)

        return null;
    }

};

?>
