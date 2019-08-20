<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/8/19
 * Time: 4:13 PM
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

$techName = $_POST['techName'];
$techNote = $_POST['techNote'];
$statusID = $_POST['status'];
$parentID = $_POST['parentID'];
$typeID = $_POST['typeID'];


if ($_POST['action'] == "new") {

    $sql_check = "SELECT `ID` FROM `techniques_tree` WHERE `Name` = '$techName' AND `ParentID` = $parentID";
    if (mysqli_num_rows(mysqli_query($conn, $sql_check)) >= 1) {
        $resultArray['result'] = "error";
        $resultArray['error'] = "Dublicated Tech Name!";
        die(json_encode($resultArray));
    }

    $sql = "
INSERT INTO `techniques_tree`(
    `ParentID`,
    `TypeID`,
    `Name`,
    `FullName`,
    `Note`,
    `StatusID`,
    `CreateDate`,
    `CreateUser`,
    `CreateUserID`
)
VALUES(
    $parentID,
    $typeID,
    '$techName',
    '',
    '$techNote',
    '$statusID',
    $currDate,
    '$currUser',
    $currUserID
)
";

    $resultArray['sql'] = $sql;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $insID = mysqli_insert_id($conn);
        $resultArray['insID'] = $insID;

        $sql_ins_mapping = "
    INSERT INTO `estimate_criteriums_mapping`(
    `TechTreeID`,
    `CriteriumID`,
    `ParentID`,
    `Note`,
    `MappingStatus`,
    `MappingDate`,
    `CriteriumStatusID`,
    `CreateDate`,
    `CreateUser`,
    `CreateUserID`
)
SELECT
    $insID,
    `CriteriumID`,
    `ParentID`,
    '',
    1,
    $currDate,
    getstateid('Active', getobjid('estimate_criteriums')),
    $currDate,
    '$currUser',
    $currUserID
    FROM estimate_criteriums_mapping
    WHERE TechTreeID = $parentID";

        $resultArray['sql_ins_mapping'] = $sql_ins_mapping;

        if (mysqli_query($conn, $sql_ins_mapping)) {
            $resultArray['result'] = "success";
        } else {
            $resultArray['error'] = "can't ins subTechMapping!";
        }

    }
}

if ($_POST['action'] == "edit") {

    $editingID = $_POST['editingID'];

    $sql = "UPDATE
    `techniques_tree`
SET
    `Name` = '$techName',
    `Note`= '$techNote',
    `StatusID` = $statusID
WHERE
    `techniques_tree`.`ID` = $editingID";

    $resultArray['sql'] = $sql;

    if (mysqli_query($conn, $sql)) {
        $resultArray['result'] = "success";
    } else {
        $resultArray['error'] = "can't update tech!";
    }

}


echo(json_encode($resultArray));