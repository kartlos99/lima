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

//
//$apNumber= $_POST['ApNumber'];
$apNumber = Date( time());
$apDate= $currDate;
//$organizationID= $_POST['OrganizationID'];
//$branchID= $_POST['BranchID'];
//$apStatus= $_POST['ApStatus'];
$apStatus= "getstateid('Project', 37)";
$agreementNumber= "";//$_POST['AgreementNumber'];
$techTreeID= $_POST['TechTreeID'];
$techModelFix= $_POST['TechModelFix'];
$techSerial= $_POST['TechSerial'];
$techIMEI= $_POST['TechIMEI'];
$note= $_POST['note'];
//$EstimateResult1= $_POST['EstimateResult1'];
//$EstimateResult2= $_POST['EstimateResult2'];
$sysTechPrice= $_POST['SysTechPrice'];
$managerAdd= $_POST['ManagerAdd'];
$clientDec= $_POST['ClientDec'];
$corTechPrice= $_POST['CorTechPrice'];

$record_id = $_POST['record_id'];

if ($record_id == 0) {
    $sql = "
INSERT INTO `tech_estimate_applications`(
    `ApNumber`,
    `ApDate`,
    `ApStatus`,
    `AgreementNumber`,
    `TechTreeID`,
    `TechModelFix`,
    `TechSerial`,
    `TechIMEI`,
    `Note`,
    `SysTechPrice`,
    `ManagerAdd`,
    `ClientDec`,
    `CorTechPrice`,
    `CreateDate`,
    `CreateUser`,
    `CreateUserID`    
)
VALUES(
    '$apNumber',
    $apDate,
    $apStatus,
    '$agreementNumber',
    '$techTreeID',
    '$techModelFix',
    '$techSerial',
    '$techIMEI',
    '$note',
    '$sysTechPrice',
    '$managerAdd',
    '$clientDec',
    '$corTechPrice',
    $currDate,
    '$currUser',
    $currUserID
)
";
} else {

    $sql = "
UPDATE
    `ID` = $record_id";

    $resultArray['record_id'] = $record_id;
}

$resultArray['sql'] = $sql;
$result = mysqli_query($conn, $sql);

if ($result) {
    if ($record_id == 0) {
        $insID = mysqli_insert_id($conn);
        $resultArray['record_id'] = $insID;
    }
    $resultArray['result'] = "success";
} else {
    $resultArray['result'] = "error";
    $resultArray['error'] = "can't done on application table!";
}

echo(json_encode($resultArray));

