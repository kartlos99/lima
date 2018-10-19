<?php
session_start();
include_once '../config.php';

if (!isset($_SESSION['username'])){
    die("login");
}

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$imei =  $_POST['imei'];
if ($_POST['modeli'] == ""){
    $modeli = 0;
}else {
    $modeli = $_POST['modeli'];
}

$serial = $_POST['serialN'];
if ($_POST['ios'] == ""){
    $ios = 0;
}else {
    $ios = $_POST['ios'];
}
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
$backinfo = ['id' => 0, 'error' => "", 'info_cuser' => "", 'info_cdate' => "", 'info_muser' => "", 'info_mdate' => ""];

if ( ($iphoneID == 0 && $_SESSION['usertype'] == 'CallCenterOper') || $_SESSION['usertype'] == 'CallCenterOper'){
    $backinfo['error'] = 'No Access!';
    echo (json_encode($backinfo));
    die();
}

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
        ) ";
}else{
    $sql = "
        UPDATE
        `Iphone`
        SET
        `ScreenLockPass` = '$passLock',
        `ScreenLockDate` = '$lockDate',
        `ScreenLockSendDate` = '$lockSendDate',
        `SLstateID` = $SLstatus,
        `Comment` = '$comment'        
    ";

    if ($_SESSION['usertype'] != 'CallCenterOper'){
        $sql .= ",
        `IphoneModelID` = '$modeli',
        `PhIMEINumber` = '$imei',
        `PhSerialNumber` = '$serial',
        `IphoneiOSID` = $ios,
        `PhSIMFREE` = '$simfree',
        `RestrictionPass` = '$passRes',
        `EncryptionPass` = '$passEnc',
        `StateID` = $status,
        `ModifyDate` = $currDate,
        `ModifyUser` = '$currUser',
        `ModifyUserID` = $currUserID        
        ";
    }

    $sql .= " WHERE ID = $iphoneID";
}

    $result = mysqli_query($conn, $sql);
    if ($result) {
        if ($iphoneID == 0){
            $iphoneID = mysqli_insert_id($conn); //'ok';
            $backinfo['info_cuser'] = $currUser;
            $backinfo['info_cdate'] = date("Y-m-d H:i", time());

            $sql_upd = "UPDATE `Agreements` SET `IphoneFixID` = $iphoneID WHERE id = $agrID ";

            if (!mysqli_query($conn, $sql_upd)){
                $backinfo['error'] = "can't update Agreements! (at ins_iphone)";
            }

        } else{
            $backinfo['info_muser'] = $currUser;
            $backinfo['info_mdate'] = date("Y-m-d H:i", time());
        }
        $backinfo['id'] = $iphoneID;
    } else {
        $backinfo['error'] = 'myerror';
    }
//echo $sql;

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


echo json_encode($backinfo);
$conn->close();

?>