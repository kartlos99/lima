<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';
$minDate = "2000-01-01";
$maxDate = "2100-01-01";
$query = "";
$applid = 0;
$status = 0;

$organization =  $_POST['organization'];
//$branch =  $_POST['branch'];

if (isset($_POST['applid']) && $_POST['applid'] != ""){
    $applid = $_POST['applid'];    
}

if (isset($_POST['status']) && $_POST['status'] != ""){
    $status = $_POST['status'];    
}


if ($status != 0){
     if (strlen($query) > 0){
        $query = $query." AND";
    }
    $query = $query." a.StateID = $status";
}
if ($organization != ""){
     if (strlen($query) > 0){
        $query = $query." AND";
    }
    $query = $query." a.OrganizationID = $organization";
}
// if ($branch != ""){
//     $query = $query." and a.OrganizationBranchID = $branch";
// }
if ($applid != ""){
    if (strlen($query) > 0){
        $query = $query." AND";
    }
    $query = $query." AplApplID LIKE ('$applid%')";
}


if ($query != ""){
    
        $sql = "
    SELECT a.ID, a.AplApplID, o.OrganizationName, b.BranchName, s.Value AS st FROM `ApplID` a
    LEFT JOIN Organizations o ON a.OrganizationID = o.ID
    LEFT JOIN OrganizationBranches b ON a.OrganizationBranchID = b.ID
    LEFT JOIN States s ON a.StateID = s.ID
    
    WHERE 
    ";
    
    $sql = $sql.$query." limit 0, 50";
    
    
    $result = mysqli_query($conn,$sql);
    
    $arr = array();
    foreach($result as $row){
        $arr[] = $row;
    }
    //echo $sql;
    echo(json_encode($arr));
}

$conn -> close();