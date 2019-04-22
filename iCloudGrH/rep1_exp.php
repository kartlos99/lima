<?php

include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}
if ($_SESSION['usertype'] != 'iCloudGrH'){
    die("NO_access");
}

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
$all_states = [];

for ($i = 0; $i < count($arr); $i++){
        
    $key_st =  $arr[$i]['st'];
    $key_org = $arr[$i]['org'];
    $raod = $arr[$i]['raod'];
    if (!isset( $all_states[ $key_st ] )){
        $all_states[$key_st] = $key_st;
    }
    if ( !isset( $outdata[ $key_org ] )){
        $outdata += ["$key_org" => array() ];
        //$outdata[ $key_user ] += ["$key_user" => "0"];
    }
    if ( !isset( $outdata[ $key_org ][ $key_st ] )){
        $outdata[ $key_org ] += ["$key_st" => $raod];
    }
    // $outdata[ $key_org ][ $key_st ] += 1;
}


$output = '<table bordered="3">';

date_default_timezone_set("Asia/Tbilisi");
$dges = date("Y-m-d", time());

function makeHrow($columns){
    $newRow = "<tr>";
    $newRow .= "<th>" . "რაოდენ./ფილ." . "</th>";
    foreach($columns as $item){
        $newRow .= "<th>" . $item . "</th>";
    }
    return $newRow . "</tr>";    
}

function makerow($columns, $sst, $curr_org){
    $newRow = "<tr>";
    $newRow .= "<td>" . $curr_org . "</td>";
    foreach($sst as $st){
        if (isset($columns[$st])){
            $newRow .= "<td>" . $columns[$st] . "</td>";
        }else{
            $newRow .= "<td>0</td>";
        }
    }
    return $newRow . "</tr>";
}

$tHead = [];


if (count($outdata) > 0) {

    foreach($outdata as $k => $row){
        $tHead[] = $k;
        $outdata[$k]["Active"] = $row["Active"] - $row["Active_A"];
    }

    $output .= makeHrow($all_states);

    foreach($outdata as $k => $row){        
        $output .= makerow($row, $all_states, $k);
    }
}

$output .= '</table>';
$fileName = "ApplID_statistic_" . $dges;

//header("Content-Type: application/xls");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fileName.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $output;

mysqli_close($conn);
?>