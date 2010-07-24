<?php
// vi: set ts=4 expandtab nu:
/*
 * Generic SNMP class
 *
 * Usage: 
 * <code>
 * include_once('SNMP.class.php');
 * SNMP::register();
 * </code>
 * @package SNMP
 * {@example example1.php 1 10}
 * @author Walter Werther <walter@wwerther.de>
 * @copyright Copyright (c) 2010, Walter Werther
 * @version $Id: $;
 */
class SNMP {

    /**
     * Autoloading functionality for SNMP-classes
     * @param string $name The name of the class that needs to be loaded
     */
    public static function autoload($name) {
        $d=dirname(__FILE__);
        $DIR=$d.DIRECTORY_SEPARATOR.__CLASS__.DIRECTORY_SEPARATOR;
        $file=$DIR.$name.".class.php";
        if (is_readable($file)) {
            require_once ($file);
        }
        $file=$DIR.$name.".interface.php";
        if (is_readable($file)) {
            require_once ($file);
        }
        $file=$DIR.$name.".exception.php";
        if (is_readable($file)) {
            require_once ($file);
        }
        $file=$DIR.'extensions'.DIRECTORY_SEPARATOR.$name.".class.php";
        if (is_readable($file)) {
            require_once ($file);
        }
        # require_once('snmp.php');
        # print "Autoload: $name ".__NAMESPACE__." ".DIRECTORY_SEPARATOR."<br/>\n";

        # Taken from http://www.slideshare.net/bennsen/php-53-3688435
        # $dirname=__DIR__;
        # $namespaceDir=str_replace('\\',DIRECTORY_SEPARATOR,__NAMESPACE__);
        # $loadingDir=substr($dirname,0,strpos($dirname,$namespaceDir));
        # $filename=str_replace('\\',DIRECTORY_SEPARATOR,$name).'.php';
        # $file=$loadingDir.DIRECTORY_SEPARATOR.$filename;
        # if (is_readable($file)) {
        #     require_once ($file);
        # }
    }

    /**
     * Provide a register function for that class
     * 
     * will add the autoloader of this class so all other classes will be loaded automatically
     */
    public static function register() {
        spl_autoload_register (array(__CLASS__,'autoload'));
    }

}
?>
