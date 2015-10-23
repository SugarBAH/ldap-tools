<?php

/* 
  Find the user and print the requested data.  
 */
if ($argv[4] === "debug") {$dbg = (bool)true;}  else {$dbg = (bool)false;}
if ($dbg) {echo "#1: $argv[1] #2: $argv[2] #3 $argv[3] \n"; }
$outp = $argv[3];

$search = "($argv[1]=$argv[2]*)"; 
echo "search:  $search  output: $outp \n" ;
include("ldap_config.php");

    $ds = ldap_connect($url) or die(ldap_error($ds));
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3) or die(ldap_error($ds));
    ldap_bind($ds, $admin, $pass) or die(ldap_error($ds));

    $output = "";
#    $sr = ldap_search($ds, $groupdn, '(cn=*)') or die(ldap_error($ds));  
    $sr = ldap_search($ds, $userdn, $search) or die(ldap_error($ds)); 
        $entries = array();
	$data = ldap_get_entries($ds, $sr) ;
    switch ($outp) {
        case "dump":
            if ($dbg) {echo ' Dump all data for the entry \n'; }
            print_r($data) ;
            break;
        case "all";
            for ($i=0; $i<=$data["count"];$i++) {
                for ($j=0;$j<=$data[$i]["count"];$j++){
                    echo $data[$i][$j].": ".$data[$i][$data[$i][$j]][0]."\n";
                    if ($data[$i][$data[$i][$j]]["count"] > 1) {
                       for ($k=1;$k<=$data[$i][$data[$i][$j]]["count"];$k++){
                            echo $data[$i][$data[$i][$j]][$k]."\n" ;
                       }
                        if ($dbg) {echo "count true \n" ; }
                    }
                    if ($dbg)  {echo "$i $j \n" ;} 
                }
            }
            break; 
        case "term";
            echo " Information for a term   \n";
            print  $data[1][11] ;   
            break; 
        case "uid";
            echo " uid   \n";
            for ($i=0; $i<=$data["count"];$i++) {
                echo $data[$i][3].": ".$data[$i][$data[$i][3]][0]."\n"; 
#                echo $data[$i]["uid"].": ".$data[$i][$data[$i]["uid"]][0]."\n"; 
            }
            break; 
        case "host";
            echo " Hosts:  \n";
            if  ($data[0][$data[0][11]]["count"] > 1) { echo "hosts \n" ; }
            for ($k=0;$k<=$data[0][$data[0][11]]["count"];$k++){
                echo $data[0][$data[0][11]][$k]."\n" ;
            }
            break;         
        default:
            echo " $outp is not a valid print request \n";
}
       
         
    
?>