<?php
// vi: set ts=4 expandtab nu:
/**
 * File-level Doc-Block
 * @package SNMP
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version $Id: tags.version.pkg,v 1.2 2006-04-29 04:08:27 cellog Exp $;
 */

/**
 *
*/
abstract class SnmpTree extends SnmpTableEntry {

    public function __construct(SnmpConnect $connector,$data=null) {
        parent::__construct($connector,0,$data);
    }

    protected function maptoindex($offset) {
        $val=$offset;
        if (is_numeric($offset)) {
            $val=$offset;
        } else {
            $val=$this->map[$offset];
        }
        if (! is_null($this->extend)) $val=$val.$this->extend;

        $oid=join('.',array($this->table,$val,0));

        # print "Mapping $offset to $val\n";
        return $oid;
    }

}

?>
