<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/9/19
 * Time: 3:39 PM
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
$Name = $_POST['Name'];
$Note = $_POST['Note'];
$statusID = $_POST['status'];
$parentID = $_POST['parentID'];
$typeID = $_POST['typeID'];
$techID = $_POST['techID'];
$techArr = $_POST['techArr'];
$RealParentID = $_POST['parentID'];

if ($_POST['action'] == "new") {

    $sql = "
INSERT INTO `estimate_criteriums`(
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
    '$Name',
    '',
    '$Note',
    $statusID,
    $currDate,
    '$currUser',
    $currUserID
)";
    $resultArray['sql1'] = $sql;
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $insID = mysqli_insert_id($conn);
        $resultArray['id'] = $insID;

        $subTechIDs = [];
        // tecnikis yvela shvilis ID-s gvadzlevs
        $sqlSubTechIDs = "
SELECT ID FROM `techniques_tree` WHERE ParentID = $techID
UNION ALL
SELECT ID FROM `techniques_tree` WHERE ParentID IN (SELECT ID FROM `techniques_tree` WHERE ParentID = $techID)
";
        $resultArray['sqlSubTechIDs'] = $sqlSubTechIDs;

        $resSubIDs = mysqli_query($conn, $sqlSubTechIDs);
        foreach ($resSubIDs as $row) {
            $subTechIDs[] = $row['ID'];
        }
//die(var_dump($subTechIDs));

        $sqlInsMapping = "
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
VALUES";

        if ($parentID == 0) {
            // emateba kriteriumebis jgufi


//    $techIDArr = array();
            foreach ($subTechIDs as $sID) {
                $attechedTechID = $sID;

                $values = "(
            $attechedTechID,
            $insID,
            '0',
            '$Note',
            '1',
            $currDate,
            $statusID,
            $currDate,
            '$currUser',
            $currUserID
            )";

                $sqlInsMapping .= $values . ",";
            }

            $values = "(
            $techID,
            $insID,
            '0',
            '$Note',
            '1',
            $currDate,
            $statusID,
            $currDate,
            '$currUser',
            $currUserID
            )";
            $sqlInsMapping .= $values;
        } else {
            // emateba shefasebis kriteriumi


            // gvadzlevs vela teqnikis ID-s romelsac mititebuli criteriumebis jgufi aqvs (parentID)
            $sqlx = "SELECT `TechTreeID` FROM estimate_criteriums_mapping WHERE `CriteriumID` = $parentID ";
            $resultArray['sql2'] = $sqlx;

            $res1 = mysqli_query($conn, $sqlx);

            foreach ($res1 as $row) {
                $attechedTechID = $row['TechTreeID'];

                if (in_array($attechedTechID, $techArr) or in_array($attechedTechID, $subTechIDs)) {
                    $checkedStatus = $statusID;
                } else {
                    // kriteriumis jgufshi damatebisas, tu es jgufi sxva teqnikazec vrceldeba iq eqneba shecherebuli statusi
                    $checkedStatus = "getstateid('Suspended', getobjid('estimate_criteriums'))";
                }

                $values = "(
            $attechedTechID,
            $insID,
            $RealParentID,
            '$Note',
            '1',
            $currDate,
            $checkedStatus,
            $currDate,
            '$currUser',
            $currUserID
            )";

                $sqlInsMapping .= $values . ",";
            }

            $sqlInsMapping = trim($sqlInsMapping, ",");
        }

        $resultArray['mappingsql'] = $sqlInsMapping;

        if (mysqli_query($conn, $sqlInsMapping)) {
            $resultArray['result'] = "success";
        } else {
            $resultArray['error'] = "can't ins subTechMapping!";
        }

    }
}

//


if ($_POST['action'] == "edit") {

    $editingID = $_POST['editingID'];
    $editingMappingID = $_POST['editingMappingID'];

    $sql = "UPDATE
    `estimate_criteriums`
SET
    `Name` = '$Name',
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = $currUserID
WHERE
    id = $editingID";

//    komentars da statuss vcvlit mappingis cxrilshi
//    `Note` = '$Note',
//    `StatusID` = $statusID,

    $resultArray['sql'] = $sql;

    if (mysqli_query($conn, $sql)) {

        $sqlMappingUpdate = "UPDATE
    `estimate_criteriums_mapping`
SET
	`CriteriumStatusID` = $statusID,
    `Note` = '$Note'
WHERE ID = $editingMappingID";

        if (mysqli_query($conn, $sqlMappingUpdate)) {
            $resultArray['result'] = "success";
        }else{
            $resultArray['error'] = "can't update estmate_criteriums_Mapping!";
        }

    } else {
        $resultArray['error'] = "can't update estmate_criteriums!";
    }
}

echo(json_encode($resultArray));