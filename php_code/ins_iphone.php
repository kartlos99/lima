<?php

include_once '../config.php';
session_start();

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$imei =  $_POST['imei'];
$modeli = $_POST['modeli'];
$serial = $_POST['serialN'];
$ios = $_POST['ios'];
$passRes = $_POST['passRes'];
$passEnc = $_POST['passEnc'];
$passLock = $_POST['passLock'];

$lockDate = $_POST['lockDate'];
$lockSendDate = $_POST['lockSendDate'];

$SLstatus = $_POST['SLstatus'];
$status = $_POST['status'];
$comment = $_POST['comment'];
if (isset($_POST['simfree'])){
    $simfree = 1;
}else{
    $simfree = 0;
}

$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];

$agrID = $_POST['agrID'];
$iphoneID = $_POST['iphoneID'];
//print_r($_POST);
//print_r($_SESSION);


    $sql_chek = "SELECT code FROM `States` WHERE id = '$status'";
    $result1 = mysqli_query($conn, $sql_chek);
    $code = mysqli_fetch_assoc($result1);



if ($iphoneID == 0) {

    $sql = "
INSERT
INTO
  `Iphone`(
    `IphoneModelID`,
    `PhIMEINumber`,
    `PhSerialNumber`,
    `IphoneiOSID`,
    `PhSIMFREE`,
    `RestrictionPass`,
    `EncryptionPass`,
    `ScreenLockPass`,
    `ScreenLockDate`,
    `ScreenLockSendDate`,
    `TypeID`,
    `StateID`,
    `SLstateID`,
    `Comment`,
    `CreateDate`,
    `CreateUser`,
    `CreateUserID`
  )
VALUES(
  '$modeli',
  '$imei',
  '$serial',
  $ios,
  '$simfree',
  '$passRes',
  '$passEnc',
  '$passLock',
  '$lockDate',
  '$lockSendDate',
  gettypeid('iphone_tarebit',getobjid('Iphone')),
  $status,
  $SLstatus,
  '$comment',
  $currDate,
  '$currUser',
  $currUserID
)
    ";
}else{
    $sql = "
    UPDATE
  `Iphone`
SET
  `IphoneModelID` = '$modeli',
  `PhSerialNumber` = '$serial',
  `IphoneiOSID` = $ios,
  `PhSIMFREE` = '$simfree',
  `RestrictionPass` = '$passRes',
  `EncryptionPass` = '$passEnc',
  `ScreenLockPass` = '$passLock',
  `ScreenLockDate` = '$lockDate',
  `ScreenLockSendDate` = '$lockSendDate',
  `StateID` = $status,
  `SLstateID` = $SLstatus,
  `Comment` = '$comment',
  `ModifyDate` = $currDate,
  `ModifyUser` = '$currUser',
  `ModifyUserID` = $currUserID
WHERE
  PhIMEINumber = '$imei'
    ";
}

    $result = mysqli_query($conn, $sql);
    if ($result) {
        if ($iphoneID == 0){
            $iphoneID = mysqli_insert_id($conn); //'ok';
        }
        //echo mysqli_insert_id($conn); //'ok';
    } else {
        echo 'myerror';
    }


// add in iphone FIX

//$sql = "
//INSERT
//INTO
//  `IphoneFix`(
//    `IphoneID`,
//    `IphoneModelID`,
//    `PhIMEINumber`,
//    `PhSerialNumber`,
//    `IphoneiOSID`,
//    `PhSIMFREE`,
//    `RestrictionPass`,
//    `EncryptionPass`,
//    `ScreenLockPass`,
//    `ScreenLockDate`,
//    `ScreenLockSendDate`,
//    `TypeID`,
//    `StateID`,
//    `SLstateID`,
//    `Comment`,
//    `CreateDate`,
//    `CreateUser`,
//    `CreateUserID`
//  )
//VALUES(
//  $iphoneID,
//  '$modeli',
//  '$imei',
//  '$serial',
//  $ios,
//  '$simfree',
//  '$passRes',
//  '$passEnc',
//  '$passLock',
//  '$lockDate',
//  '$lockSendDate',
//  gettypeid('iphone_tarebit',getobjid('Iphone')),
//  $status,
//  $SLstatus,
//  '$comment',
//  $currDate,
//  '$currUser',
//  $currUserID
//)
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
  `IphoneFixID` = $iphoneID
WHERE
  id = $agrID
  ";

if (!mysqli_query($conn, $sql)){
    echo "myerror!";
}

echo $iphoneID;
$conn->close();

?>