<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}

// organizaciebi
$sql = "SELECT
o.id,
OrganizationName,
OrganizationNameEng,
s.code
FROM
`Organizations` o
LEFT JOIN `States` s 
ON s.ID = o.stateID
WHERE
s.code <> 'disabled'
ORDER BY o.SortID
";

$result = mysqli_query($conn,$sql);

$arr_org = array();
foreach($result as $row){
    $row += ['domains' => [] ];
    $row += ['branches' => [] ];
    $row += ['rmails' => [] ];
    $arr_org[] = $row;    
}

// filialebi
$sql = "SELECT OrganizationID, o.id, BranchName FROM OrganizationBranches o LEFT JOIN States s ON o.StateID = s.ID WHERE s.Code = 'Active' ORDER BY o.SortID";

$result = mysqli_query($conn,$sql);

$arr_br = array();
foreach($result as $row){
    $arr_br[] = $row;    
}

// domainebi
$sql = "SELECT OrganizationID, o.id, DomainName FROM Domains o LEFT JOIN States s ON o.StateID = s.ID WHERE s.Code = 'Active' ORDER BY o.SortID";

$result = mysqli_query($conn,$sql);

$arr_dom = array();
foreach($result as $row){
    $arr_dom[] = $row;    
}

// recovery Emails
$sql = "SELECT OrganizationID, e.id, e.EmEmail FROM `Emails` e JOIN Types t ON e.TypeID = t.ID WHERE t.code = 'Rescue Email'";

$result = mysqli_query($conn,$sql);

$arr_Rmail = array();
foreach($result as $row){
    $arr_Rmail[] = $row;    
}

for ($i = 0 ; $i < count($arr_org) ; $i++){
    foreach($arr_br as $br){
        if ($arr_org[$i]['id'] == $br['OrganizationID']){
            $arr_org[$i]['branches'][] = $br;
        }
    }
    foreach($arr_dom as $dom){
        if ($arr_org[$i]['id'] == $dom['OrganizationID']){
            $arr_org[$i]['domains'][] = $dom;
        }
    }
    foreach($arr_Rmail as $rm){
        if ($arr_Rmail[$i]['id'] == $rm['OrganizationID']){
            $arr_org[$i]['rmails'][] = $rm;
        }
    }
}


echo(json_encode($arr_org));

$conn -> close();