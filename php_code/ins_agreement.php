<?php

include_once '../config.php';
session_start();

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$agrID = $_POST['agrID'];

$agrN = $_POST['agrN'];
$startdate = $_POST['agrStart'];
//if ($_POST['agrFinish'] != ""){
    $finishdate = $_POST['agrFinish'];    
//}

$orgID = $_POST['organization'];
$status = $_POST['status'];
$comment = $_POST['comment'];

$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
//print_r($_POST);
//print_r($_SESSION);
$count = 0;
$backinfo = ['id' => 0, 'error' => "", 'info_cuser' => "", 'info_cdate' => "", 'info_muser' => "", 'info_mdate' => ""];

if (strlen($agrN) > 0 && $agrN != "-") {
    $sql_chek = "SELECT id FROM `Agreements` WHERE Number = '$agrN' AND `OrganizationID` = $orgID";
    $result1 = mysqli_query($conn, $sql_chek);
    $count = mysqli_num_rows($result1);
    if ($count > 0){
        if ($count == 1) {
            $getid = mysqli_fetch_assoc($result1);
            if ($agrID == $getid['id']) {
                $count = 0;
            }
        } else{
            $backinfo['error'] = "ორგანიზაციაზე ფიქსირდება რამდენიმე ხელშეკრულება მითითებული ნომრით!";
        }
    }
}

$rs1 = [];
$sql = "SELECT Code FROM `States` WHERE id = $status";
$rs = mysqli_query($conn, $sql);
$rs1 = mysqli_fetch_assoc($rs);
//print_r($rs1);

$agrChek = true;

$ars1 = [];
if ($rs1['Code'] == 'Active'){
    if ($agrN == "" || $agrN == "-"){
        $backinfo['error'] = "შეცვალეთ ხელშეკრულების ნომერი!";
        echo json_encode($backinfo);
        die();
    }
    if ($startdate == ""){
        $backinfo['error'] = "შეავსეთ გაფორმების თარიღი!";
        echo json_encode($backinfo);
        die();
    }
    $agrChek = false;
    $sql = "SELECT checkAgreement($agrID) AS mychek";
    $ars = mysqli_query($conn, $sql);
    $ars1 = mysqli_fetch_assoc($ars);
    
    if ($ars1['mychek'] == 1){
        $agrChek = true;
    }
}
//echo $rs1['Code'];

if ($count > 0) {
    if ($backinfo['error'] == "") {
        $backinfo['error'] = 'aseti nomrit ukve registrirebulia xelshekruleba!';
    }
} else {
    
    if ($agrChek){
    
        if ($agrN == "") {
            $agrN = "-";
        }
    
        if ($agrID == 0) {
            // axali xelshekruleba

            $branchID = $_POST['branch'];
    
    
            $sql = "
            INSERT
            INTO
              `Agreements`(
                `OrganizationID`,
                `OrganizationBranchID`,
                `Number`,
                `Date`,
                `Startdate`,
                `EndDate`,
                `AgreementPersonMappingID`,
                `TypeID`,
                `StateID`,
                `Comment`,
                `CreateDate`,
                `CreateUser`,
                `CreateUserID`
              )
            VALUES(
              $orgID,
              $branchID,
              '$agrN',
              $currDate,
              '$startdate',
              '$finishdate',
              $currUserID,
              gettypeid('iphone_tarebit', getobjid('Agreements')),
              $status,
              '$comment',
              $currDate,
              '$currUser',
              $currUserID
            )
            ";
    
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $backinfo['id'] = mysqli_insert_id($conn); //'ok';
                $backinfo['info_cuser'] = $currUser;
                $backinfo['info_cdate'] = date("Y-m-d H:i", time());
            } else {
                $backinfo['error'] = 'myerror';
            }
    
        } else {
            // ganaxleba
    
            $iphoneID = $_POST['iphoneID'];
            $applIDID = $_POST['applid_ID'];
    
            $sql = "
            UPDATE
              `Agreements`
            SET
              `Number` = '$agrN',
              `Date` = '$startdate',
              `Startdate` = '$startdate',
              `EndDate` = '$finishdate',
              `IphoneFixID` = '$iphoneID',
              `ApplIDFixID` = '$applIDID',
              `StateID` = $status,
              `Comment` = '$comment',
              `ModifyDate` = $currDate,
              `ModifyUser` = '$currUser',
              `ModifyUserID` = $currUserID
            WHERE
              ID = $agrID
            ";
    
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $backinfo['id'] = $agrID;
                $backinfo['info_muser'] = $currUser;
                $backinfo['info_mdate'] = date("Y-m-d H:i", time());
            } else {
                $backinfo['error'] = 'myerror';
            }
        }
    }else{
        $backinfo['error'] = "გადაამოწმეთ Iphones ან/და AppleID -ს სტატუსები";
    }
}

echo json_encode($backinfo);

$conn->close();

?>