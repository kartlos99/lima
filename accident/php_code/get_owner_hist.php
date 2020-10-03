<?php

session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}
$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
$resultArray = [];

$caseID = $_POST['caseid'];

$sql = "
SELECT h.`ID`, pnew.UserName AS owner, date(`OwnChangeDate`) AS tarigi, `OwnChangeReason`, pop.UserName AS op FROM `pcm_aplication_ownerchangehistory` h
LEFT JOIN PersonMapping pnew ON pnew.ID = h.`OwnerNewID`
LEFT JOIN PersonMapping pop ON pop.ID = h.`OwnerChangeUserID`
WHERE caseID = $caseID";

$resultArray['sql'] = $sql;

$result1 = mysqli_query($conn,  $sql);

$arr = [];
foreach($result1 as $row){
    $arr[] = $row;
}

$resultArray['data'] = $arr;

echo(json_encode($resultArray));