<?php
//INSERT INTO `im_persons` (`ID`, `FirstName`, `LastName`, `OrgID`, `OrgBranchID`, `TypeID`, `StatusID`, `CreateDate`, `CreateUser`) VALUES (NULL, 'ირაკლი', 'მანჯგალაძე', '8', '4', '5', '1', '2019-11-17 00:00:00', '1');
session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}
$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
$resultArray = [];
if (!isset($_SESSION['permissionM3']['add_person'])) {
    $resultArray[RESULT] = ERROR;
    $resultArray[ERROR] = "no person insert permission!";
    die(json_encode($resultArray));
}
$resultArray['post'] = $_POST;
//die(json_encode($resultArray));

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$organization = $_POST['organization'];
$filial = $_POST['filial'];
$personType = $_POST['personType'];
$status = $_POST['status'];


$sql = "
    INSERT INTO `im_persons`
    (`FirstName`, `LastName`, `OrgID`, `OrgBranchID`, `TypeID`, `StatusID`, `CreateDate`, `CreateUser`) 
    VALUES 
    ('$firstName', '$lastName', '$organization', '$filial', '$personType', '$status', $currDate, $currUserID)
";

$sql_updateCase = "";

$result = mysqli_query($conn, $sql);

if ($result) {
    $resultArray['result'] = "success";
} else {
    $resultArray['result'] = "error";
    $resultArray['error'] = "can't add person!";
    $resultArray['sql'] = $sql;
}

echo(json_encode($resultArray));