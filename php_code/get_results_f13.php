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

$organization =  $_POST['organization'];
$branch =  $_POST['branch'];
$applid =  $_POST['applid'];
$status =  $_POST['status'];


if ($status != 0){
    $query = $query." and a.StateID = $status";
}
if ($organization != ""){
    $query = $query." and a.OrganizationID = $organization";
}
if ($branch != ""){
    $query = $query." and a.OrganizationBranchID = $branch";
}


    $sql = "
SELECT a.ID, a.AplApplID, o.OrganizationName, b.BranchName, s.Value AS st FROM `ApplID` a
LEFT JOIN Organizations o ON a.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b ON a.OrganizationBranchID = b.ID
LEFT JOIN States s ON a.StateID = s.ID

WHERE AplApplID LIKE ('$applid%')
";

$sql = $sql.$query;

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}
//echo $sql;
echo(json_encode($arr));

$conn -> close();