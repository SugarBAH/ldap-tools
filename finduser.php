<?php

/* 
 This dumps all the data
 */
echo "#1: $argv[1] #2: $argv[2] ";
$search = "($argv[1]=$argv[2]*)"; 
echo "search:  $search \n" ;
include("ldap_config.php");

    $ds = ldap_connect($url) or die(ldap_error($ds));
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die(ldap_error($ds));
    ldap_bind($ds, $admin, $pass) or die(ldap_error($ds));

    $output = "";
#    $sr = ldap_search($ds, $groupdn, '(cn=*)') or die(ldap_error($ds));  
    $sr = ldap_search($ds, $userdn, $search) or die(ldap_error($ds)); 
        $entries = array();
        echo "a";
	$data = ldap_get_entries($ds, $sr) ;
        echo ' Dump all data /n';
        print_r($data)
         
    
?>