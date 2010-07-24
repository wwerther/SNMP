<?php
// vi: set ts=4 expandtab nu:
/**
 * File-level Doc-Block
 * @package SNMP
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version $Id: tags.version.pkg,v 1.2 2006-04-29 04:08:27 cellog Exp $;
 */

class SnmpMergeEntry implements ArrayAccess {#, Iterator {
    public function __construct($header,$data) {
        $this->header=$header;
        $this->data=$data;
    }

    public function offsetGet($offset) {
        if (is_numeric($offset)) {
            $offset=$this->header['index'][$offset];
        };
        $table=$this->header['map'][$offset];
        if (is_null($table)) return; 
        return $this->data[$table][$offset];
    }

    public function offsetExists($offset) {
    }

    public function offsetSet($offset, $value) {
        if (is_numeric($offset)) {
            $offset=$this->header['index'][$offset];
        };
        $table=$this->header['map'][$offset];
        if (is_null($table)) return; 
        $this->data[$table][$offset]=$value;
    }
 
    public function offsetUnset($offset) {
        throw new SnmpAccessException("It's not possible to delete data-rows from a SnmpMergeEntry-Objet");
    }

    public function __tostring() {
        $result='';
        foreach ($this->header['map'] as $key=>$table) {
            $arr=$this->offsetGet($key);
            if (is_null($arr['value'])) $arr['value']='--NULL--';
            $result.=$arr['value']." ";
        }
        return $result;
    }
}
?>
