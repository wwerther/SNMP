<?php
// vi: set ts=4 expandtab nu:
/**
 * @package Examples
 */

# snmp_set_oid_output_format(SNMP_OID_OUTPUT_FULL);

include_once('../SNMP.class.php');
SNMP::register();

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

/**
 * @package Devices
 * @subpackage Cisco
 */
class CSWITCH extends CiscoDevice {

    private $OIDMAP=array (
        'interfacecount'        => '.1.3.6.1.2.1.2.1.0',
    );

    public function __construct(SnmpConnect $connector) {
        parent::__construct($connector);

        $this->interfaces = new interfaces ($connector);

        $this->ifTable = new ifTable($connector);
        $this->ifXTable = new ifXTable($connector);
        $this->Vlans = new vtpVlanTable($connector);
        $this->Membership = new vmMembershipTable($connector);
        $this->Physical = new entPhysicalTable($connector);
    }

    public function __tostring() {
        $result=parent::__tostring();
        $result.=$this->interfaces;
/*      $result.=$this->ifTable;
        $result.=$this->ifXTable;
        $result.=$this->Vlans;
        $result.=$this->Membership;
        $result.=$this->Physical;
*/
        return $result;
    }

    public function setvlan($interface,$value) {
            $this->interfaces[$interface]['vmVlan']=$value;
#           $this->Membership[$interface]['vmVlan']=$value;
    }

    public function addVlan($vlan,$name) {
        $control=new vtpEditControlTable($this->host,$this->RoCommunity,$this->writeable,$this->RwCommunity);
        $vlanEdit=new vtpVlanEditTable($this->host,$this->RoCommunity,$this->writeable,$this->RwCommunity);

        $control[1]['vtpVlanEditOperation']=4;
        # Wait a second
        sleep(1);

        # And aquire the write-lock for our self
        $control[1]['vtpVlanEditOperation']=2;
        $control[1]['vtpVlanEditBufferOwner']='Walter';

        # Choose - Create and Go
        $vlanEdit[$vlan]['vtpVlanEditRowStatus']=4; 
        $vlanEdit[$vlan]['vtpVlanEditType']=1; 
        $vlanEdit[$vlan]['vtpVlanEditName']=$name; 

        sleep(1);
        $control[1]['vtpVlanEditOperation']=3;

    }

    public function renameVlan($vlan,$name) {
        $control=new vtpEditControlTable($this->host,$this->RoCommunity,$this->writeable,$this->RwCommunity);
        $vlanEdit=new vtpVlanEditTable($this->host,$this->RoCommunity,$this->writeable,$this->RwCommunity);

        $control[1]['vtpVlanEditOperation']=4;
        # Wait a second
        sleep(1);
        $control[1]['vtpVlanEditOperation']=2;
        $control[1]['vtpVlanEditBufferOwner']='Walter';

        $vlanEdit[$vlan]['vtpVlanEditName']=$name; 

        sleep(1);
        $control[1]['vtpVlanEditOperation']=3;

    } 

    public function delVlan($vlan) {
        $control=new vtpEditControlTable($this->host,$this->RoCommunity,$this->writeable,$this->RwCommunity);
        $vlanEdit=new vtpVlanEditTable($this->host,$this->RoCommunity,$this->writeable,$this->RwCommunity);

        # Release all changes someone else may made
        $control[1]['vtpVlanEditOperation']=4;

        # Wait a second
        sleep(1);

        # And aquire the write-lock for our self
        $control[1]['vtpVlanEditOperation']=2;
        $control[1]['vtpVlanEditBufferOwner']='Walter';

        $vlanEdit[$vlan]['vtpVlanEditRowStatus']=6; 

        # Wait a second and then commit the change
        sleep(1);
        $control[1]['vtpVlanEditOperation']=3;

#        print $control;
#        print $vlanEdit;
    } 

}


?>
<html>
    <head>
        <title>SNMP TEST</title>
    </head>
    <body>
<pre>
<?php

    $con=new SnmpBufferedConnector(new SnmpV2Connect('10.16.1.18','public',true,'public'));
#    print_r($con);

    $switch=new CSWITCH($con);

#    $switch->setvlan('Fa0/5',240);
/*
    $switch->setvlan(1,240);
#    $switch->delVlan(48);
#    $switch->addVlan(48,'Walter_ss');
    $switch->renameVlan(220,'Wars');
    $switch->renameVlan(420,'ssss');
*/
#    $tab=new SnmpTable('10.16.1.18','public',true,'public');

    print ($switch);


   print "\n\n\n";
?>

</pre>
    </body>
</html>
