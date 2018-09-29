<?php
include_once '../config.php';
session_start();

if (!($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'iCloudGrH')){
    die('rejected');
}

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$sql = " 
SELECT o.OrganizationName as org, s.Code as st, COUNT(a.ID) as raod FROM `ApplID` a 
LEFT JOIN Organizations o on o.ID = a.`OrganizationID`
LEFT JOIN States s on s.ID = a.StateID
GROUP by org, st
UNION
SELECT o.OrganizationName AS org, 'Active_A' AS st, COUNT(agr.id) as raod FROM `Agreements` agr 
LEFT JOIN States s ON agr.stateID = s.ID
LEFT JOIN Organizations o ON o.ID = agr.`OrganizationID`  
LEFT JOIN ApplID apl ON apl.ID = agr.`ApplIDFixID`
LEFT JOIN States s2 ON apl.stateID = s2.ID
WHERE (s.Code = 'Active' or s.Code = 'Project') AND s2.Code = 'Active'
GROUP BY o.OrganizationName
ORDER by org, st";

$result = mysqli_query($conn, $sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

// 2.1 view-s damushaveba, mzadaa
$outdata = [];

for ($i = 0; $i < count($arr); $i++){
        
    $key_st =  $arr[$i]['st'];
    $key_org = $arr[$i]['org'];
    $raod = $arr[$i]['raod'];
    if ( !isset( $outdata[ $key_org ] )){
        $outdata += ["$key_org" => array() ];
        //$outdata[ $key_user ] += ["$key_user" => "0"];
    }
    if ( !isset( $outdata[ $key_org ][ $key_st ] )){
        $outdata[ $key_org ] += ["$key_st" => $raod];
    }
    // $outdata[ $key_org ][ $key_st ] += 1;
}

echo(json_encode($outdata));

$conn -> close();

?>