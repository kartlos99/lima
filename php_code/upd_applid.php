<?php

include_once '../config.php';
session_start();

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
//print_r($_POST);
//print_r($_SESSION);
//$VALUE = array();

$saxeli = $_POST['saxeli'];
$gvari = $_POST['gvari'];
$applid = $_POST['applid'];
$applidpass = $_POST['applidpass'];
$bday = $_POST['bday'];
$country = $_POST['country'];
$rmail = $_POST['rmail'];

$q1 = $_POST['q1'];
$ans1 = $_POST['ans1'];
$q2 = $_POST['q2'];
$ans2 = $_POST['ans2'];
$q3 = $_POST['q3'];
$ans3 = $_POST['ans3'];

$statusid = $_POST['status'];
$comment = $_POST['comment'];

$emName = $_POST['emName'];
$emDom = $_POST['emDom'];
$emPass = $_POST['emPass'];

$mailid = $_GET['id'];

$sql = "
UPDATE
    `ApplID`
SET
    `AplFirstName` = '$saxeli',
    `AplLastName` = '$gvari',
    `AplCountry` = '$country',
    `AplBirthDay` = '$bday',
    `AplApplID` = '$applid',
    `AplPassword` = '$applidpass',
    `AplSequrityQuestion1ID` = '$q1',
    `AplSequrityQuestion1Answer` = '$ans1',
    `AplSequrityQuestion2ID` = '$q2',
    `AplSequrityQuestion2Answer` = '$ans2',
    `AplSequrityQuestion3ID` = '$q3',
    `AplSequrityQuestion3Answer` = '$ans3',
    `AplRescueEmailID` = '$rmail',
    `StateID` = $statusid,
    `Comment` = '$comment',
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = $currUserID
WHERE
    AplAccountEmailID = '$mailid' AND StateID = getstateid('Project', getobjid('ApplID'))
";

$result = mysqli_query($conn,$sql);
if ($result){
    echo 'ok';
}else{
    echo mysqli_error($conn);
}

// mailis ganaxleba
$sql = "
UPDATE
  `Emails`
SET
    `DomainID` = $emDom,
    `EmEmail` = '$emName',
    `EmEmailPass` = '$emPass',
    `EmEmailDate` = $currDate,
    `StateID` = status_apltomail($statusid),
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = $currUserID
WHERE
    ID = $mailid
";

$result = mysqli_query($conn,$sql);
if ($result){
    echo 'ok';
}else{
    echo mysqli_error($conn);
}


$conn ->close();
?>