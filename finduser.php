<?php

/* 
 This dumps all the data
 */

include("config.php");

    $ds = ldap_connect($url) or die(ldap_error($ds));
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die(ldap_error($ds));
    ldap_bind($ds, $admin, $pass) or die(ldap_error($ds));

    $output = "";
/*    $sr = ldap_search($ds, $groupdn, '(cn=*)') or die(ldap_error($ds));  */ 
   $sr = ldap_search($ds, $userdn, '(sn=*hart*)') or die(ldap_error($ds)); 
        $entries = array();
        echo "a";
	$data = ldap_get_entries($ds, $sr) ;
        echo ' Dump all data /n';
        print_r($data)
         
    
?>