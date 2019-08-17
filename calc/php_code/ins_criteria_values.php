<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/17/19
 * Time: 5:17 PM
 */

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
$criteriumID = $_POST['criteriumID'];
$impact = $_POST['impact'];
$impact_type = $_POST['impact_type'];
$size = $_POST['size'];
$is_main = $_POST['is_main'];
$rev_day = $_POST['rev_day'];
$rev_date = $_POST['rev_date'];
$status = $_POST['status'];
$record_id = $_POST['record_id'];

if ($record_id == 0) {
    $sql = "
INSERT INTO `estimate_criterium_values`(
  `EstimateCriteriumID`,
    `Impact`,
    `ImpactType`,
    `ImpactValue`,
    `IsMain`,
    `RevDay`,
    `RevDate`,
    `CritValuesStatusID`,
    `CreateDate`,
    `CreateUser`,
    `CreateUserID`
)
VALUES(
    '$criteriumID',
    '$impact',
    '$impact_type',
    '$size',
    '$is_main',
    '$rev_day',
    '$rev_date',
    '$status',
    $currDate,
    '$currUser',
    $currUserID
)";
} else {

    $sql = "
UPDATE
    `estimate_criterium_values`
SET
    `Impact` = $impact,
    `ImpactType` = $impact_type,
    `ImpactValue` = '$size',
    `IsMain` = $is_main,
    `RevDay` = $rev_day,
    `RevDate` = '$rev_date',
    `CritValuesStatusID` = $status,
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = $currUserID
WHERE
    `ID` = $record_id";

    $resultArray['record_id'] = $record_id;
}

$resultArray['sql'] = $sql;
$result = mysqli_query($conn, $sql);

if ($result) {
    if ($record_id == 0){
        $insID = mysqli_insert_id($conn);
        $resultArray['record_id'] = $insID;
    }
    $resultArray['result'] = "success";
} else {
    $resultArray['result'] = "error";
    $resultArray['error'] = "can't done on estmate_criteriums_value table!";
}

echo(json_encode($resultArray));