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
$applset = "";

if (isset($_POST['saxeli'])){
    $applset .= "`AplFirstName` = '" . $_POST['saxeli'] . "', ";
}
if (isset($_POST['gvari'])){
    $applset .= "`AplLastName` = '" . $_POST['gvari'] . "', ";
}
if (isset($_POST['applid'])){
    $applset .= "`AplApplID` = '" . $_POST['applid'] . "', ";
}
if (isset($_POST['applidpass'])){
    $applset .= "`AplPassword` = '" . $_POST['applidpass'] . "', ";
}
if (isset($_POST['bday'])){
    $applset .= "`AplBirthDay` = '" . $_POST['bday'] . "', ";
}
if (isset($_POST['country'])){
    $applset .= "`AplCountry` = '" . $_POST['country'] . "', ";
}
if (isset($_POST['rmail'])){
    $applset .= "`AplRescueEmailID` = " . $_POST['rmail'] . ", ";
}


if (isset($_POST['q1']) && $_POST['q1'] != "" ){
    $applset .= "`AplSequrityQuestion1ID` = " . $_POST['q1'] . ", ";
}
if (isset($_POST['ans1'])){
    $applset .= "`AplSequrityQuestion1Answer` = '" . $_POST['ans1'] . "', ";
}
if (isset($_POST['q2']) && $_POST['q3'] != "" ){
    $applset .= "`AplSequrityQuestion2ID` = " . $_POST['q2'] . ", ";
}
if (isset($_POST['ans2'])){
    $applset .= "`AplSequrityQuestion2Answer` = '" . $_POST['ans2'] . "', ";
}
if (isset($_POST['q3']) && $_POST['q3'] != "" ){
    $applset .= "`AplSequrityQuestion3ID` = " . $_POST['q3'] . ", ";
}
if (isset($_POST['ans3'])){
    $applset .= "`AplSequrityQuestion3Answer` = '" . $_POST['ans3'] . "', ";
}


if (isset($_POST['status'])){
    $applset .= "`StateID` = " . $_POST['status'] . ", ";
}
if (isset($_POST['comment'])){
    $applset .= "`Comment` = '" . $_POST['comment'] . "', ";
}

$applset .= "   `ModifyDate` = $currDate,
                `ModifyUser` = '$currUser',
                `ModifyUserID` = $currUserID";


$emailset = "";

if (isset($_POST['emName'])){
    $emailset .= "`EmEmail` = '" . $_POST['emName'] . "', ";
}
if (isset($_POST['emDom'])){
    $emailset .= "`DomainID` = " . $_POST['emDom'] . ", ";
}
if (isset($_POST['emPass'])){
    $emailset .= "`EmEmailPass` = '" . $_POST['emPass'] . "', ";
}

$mailid = $_GET['id'];

$sql = "UPDATE `ApplID` SET " . $applset . " WHERE AplAccountEmailID = '$mailid' ";

if ($_SESSION['usertype'] != "iCloudGrH"){
    $sql .= " AND (StateID = getstateid('Project', getobjid('ApplID')) OR StateID = getstateid('Restore', getobjid('ApplID')))";
}
// echo $sql;
$result = mysqli_query($conn, $sql);
if ($result){
    echo 'ok';
    // echo $sql;
}else{
    echo mysqli_error($conn);
}

// mailis ganaxleba
$statusid = $_POST['status'];
$sql = "
UPDATE
  `Emails`
SET " . $emailset . "
    `EmEmailDate` = $currDate,
    `StateID` = status_apltomail($statusid),
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = $currUserID
WHERE
    ID = $mailid ";

$result = mysqli_query($conn, $sql);
if ($result){
    echo 'ok';
}else{
    echo mysqli_error($conn);
}

$conn ->close();
?>