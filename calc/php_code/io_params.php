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

if (isset($_POST['update'])) {
    $newVal = $_POST['update'];
    $sql = "
    UPDATE `DictionariyItems` 
SET 
	`ValueInt` = $newVal,
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = $currUserID
WHERE `Code` = 'criteria_exp_notify_period'
";
    if (mysqli_query($conn, $sql))
        $resultArray[RESULT] = SUCCESS;
    else
        $resultArray[RESULT] = ERROR;
//    $resultArray['sql'] = $sql;
}

if (isset($_POST['read'])) {
    $sql = "SELECT `ValueInt` FROM `DictionariyItems` WHERE `Code` = 'criteria_exp_notify_period'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $resultArray['data'] = $res->fetch_array(MYSQLI_ASSOC);
        $resultArray[RESULT] = SUCCESS;
    } else {
        $resultArray[RESULT] = ERROR;
    }
}


echo json_encode($resultArray);