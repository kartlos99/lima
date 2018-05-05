<?php

include_once '../config.php';
session_start();

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$saxeli = $_POST['saxeli'];
$gvari = $_POST['gvari'];
$applid = $_POST['applid'];
$applidpass = $_POST['applidpass'];
$bday = $_POST['bday'];
$country = $_POST['country'];
if (isset($_POST['rmail'])) {
    $rmail = $_POST['rmail'];
}else {
    $rmail = 0;
}

if (isset($_POST['q1'])) {
    $q1 = $_POST['q1'];
}else {
    $q1 = 0;
}
$ans1 = $_POST['ans1'];
if (isset($_POST['q2'])) {
    $q2 = $_POST['q2'];
}else {
    $q2 = 0;
}
$ans2 = $_POST['ans2'];
if (isset($_POST['q3'])) {
    $q3 = $_POST['q3'];
}else {
    $q3 = 0;
}
$ans3 = $_POST['ans3'];

$statusid = $_POST['status'];
$comment = $_POST['comment'];

$emailPass = $_POST['emailpass'];
$emailID = $_POST['email_ID'];

$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];

$agrID = $_POST['agrID'];
$applid_ID = $_POST['applid_ID'];
//print_r($_POST);
//print_r($_SESSION);
$backinfo = ['id' => 0, 'error' => "", 'info_cuser' => "", 'info_cdate' => "", 'info_muser' => "", 'info_mdate' => ""];

if ($emailID != "" && $emailID != "0"){

    $sql = "
    UPDATE
      `Emails`
    SET
      `EmEmailPass` = '$emailPass',
      `ModifyDate` = $currDate,
      `ModifyUser` = '$currUser',
      `ModifyUserID` = $currUserID
    WHERE
      id = $emailID
    ";
    if (!mysqli_query($conn, $sql)){
        $backinfo['error'] = "mail update error!";
    }

}


$sql = "
UPDATE
    `ApplID`
SET
    `AplFirstName` = '$saxeli',
    `AplLastName` = '$gvari',
    `AplCountry` = '$country',
    `;AplBirthDay` = '$bday',
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
    ID = $applid_ID
";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        //echo 'ok';
        $backinfo['info_muser'] = $currUser;
        $backinfo['info_mdate'] = date("Y-m-d H:i", time());
    } else {
        $backinfo['error'] = $sql;//'myerror';
    }


// add in iphone FIX

//$sql = "
//INSERT  INTO ApplidFix (
//    `ApplIDID`,
//    `OrganizationID`,
//    `OrganizationBranchID`,
//    `AplAccountEmailID`,
//    `AplFirstName`,
//    `AplLastName`,
//    `AplCountry`,
//    `AplBirthDay`,
//    `AplApplID`,
//    `AplPassword`,
//    `AplSequrityQuestion1ID`,
//    `AplSequrityQuestion1Answer`,
//    `AplSequrityQuestion2ID`,
//    `AplSequrityQuestion2Answer`,
//    `AplSequrityQuestion3ID`,
//    `AplSequrityQuestion3Answer`,
//    `AplRescueEmailID`,
//    `TypeID`,
//    `StateID`,
//    `Comment`,
//    `CreateDate`,
//    `CreateUser`,
//    `CreateUserID`,
//    `ModifyDate`,
//    `ModifyUser`,
//    `ModifyUserID`)
//SELECT
//    $applid_ID,
//    `OrganizationID`,
//    `OrganizationBranchID`,
//    `AplAccountEmailID`,
//    `AplFirstName`,
//    `AplLastName`,
//    `AplCountry`,
//    `AplBirthDay`,
//    `AplApplID`,
//    `AplPassword`,
//    `AplSequrityQuestion1ID`,
//    `AplSequrityQuestion1Answer`,
//    `AplSequrityQuestion2ID`,
//    `AplSequrityQuestion2Answer`,
//    `AplSequrityQuestion3ID`,
//    `AplSequrityQuestion3Answer`,
//    `AplRescueEmailID`,
//    `TypeID`,
//    `StateID`,
//    `Comment`,
//    `CreateDate`,
//    `CreateUser`,
//    `CreateUserID`,
//    `ModifyDate`,
//    `ModifyUser`,
//    `ModifyUserID`
//FROM `ApplID` WHERE ID = $applid_ID
//    ";
//
//$fixID = 0;
//
//$result = mysqli_query($conn, $sql);
//if ($result) {
//    $fixID = mysqli_insert_id($conn); //'ok';
//} else {
//    echo 'myerror: '. $sql;
//}

$sql = "
UPDATE
  `Agreements`
SET
    `ApplIDFixID` = $applid_ID,
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = $currUserID
WHERE
  id = $agrID
  ";

$backinfo['id'] = $applid_ID;

if (!mysqli_query($conn, $sql)){
    $backinfo['error'] = "update error!";
}

echo json_encode($backinfo);
$conn->close();

?>