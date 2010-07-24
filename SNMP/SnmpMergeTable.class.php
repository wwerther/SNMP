<?php
// vi: set ts=4 expandtab nu:
/**
 * File-level Doc-Block
 * @package SNMP
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version $Id: tags.version.pkg,v 1.2 2006-04-29 04:08:27 cellog Exp $;
 */


abstract class SnmpMergeTable implements ArrayAccess, Iterator {

    protected $header=array();

    public function __construct(SnmpConnect $connector) {
        $this->Connector = $connector;

        # print get_class($this)." Access:".$access." RO:".$this->RoCommunity." RW:".$this->RwCommunity." Host:".$this->host." Table:".$this->table."\n";
        $this->loaded=false;

        foreach ($this->tables as $name=>$table) {
            foreach ($table->headerfields as $field) {
                if ($this->header['map'][$field]) throw new SnmpException("Fieldname '$field' is not unique. It exists in '$name' and '".$this->headermap[$field]."'");
                $this->header['map'][$field]=$name;
            }
#            print "$name: ".implode('--',$table->headerfields)."\n";
        }
        $this->header['index']=array_keys($this->header['map']);
    }

    public function offsetGet($offset) {
        $offset=$this->maptoindex($offset);

        foreach ($this->tables as $name=>$table) {
            $data[$name]=$table[$offset];
        }

        return new SnmpMergeEntry($this->header,$data);
    }

    public function offsetExists($offset) {
    }

    public function maptoindex($offset) {
        if (is_numeric($offset)) return $offset;
        if (! $this->loaded) $this->_load();
        foreach ($this->tables as $name=>$elem) {
            $key=$elem->maptoindex($offset);
            if (! is_null($key)) return $key;
        }
        return null;
    }   

    protected function _load() {
        foreach ($this->tables as $name=>$elem) {
            $elem->maptoindex('nil');
        }
        $this->loaded=true;
    }

    public function offsetSet($offset, $value) {
        throw new SnmpAccessException("SnmpMergeTable is not writeable. Please select a single element to change");
    }
 
    public function offsetUnset($offset) {
        throw new SnmpAccessException("It's not possible to delete data-rows from a SnmpMergeTable-Objet");
    }

    public function current() {
        return $this[$this->position];
    }

    public function next() {
        $this->position++;
    }

    public function valid() {
        if (is_null($this->data)) $this->_load();
        return $this->position <= sizeof($this->data);
    }

    public function rewind() {
        $this->position = 1;
    }

    public function key() {
        return $this->position;
    }

    public function __tostring() {
        if (! $this->loaded) $this->_load();
#        print_r ($this);
        $access='ro'; if ($writeable) $access='rw';
        $result='Class: '.get_class($this)." Access:".$access." RoC:".$this->RoCommunity." RwC:".$this->RwCommunity." Host:".$this->host." Table:".$this->table."\n";
        $result.="Index ".implode(' ',array_keys($this->header['map']))."\n";
        for ($i=1;$i<13;$i++) {
            $result.=$this->offsetGet($i)."\n";
#            $result.=implode(' ',elem)."\n";
        }
        $result.="\n";
        return $result;
    }

}

?>
