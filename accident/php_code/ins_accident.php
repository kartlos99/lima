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

$resultArray['post'] = $_POST;
//die(json_encode($resultArray));

$time1 = round(time() / 3600 / 24) - 18000;

$input = 23;
//echo($time1 . str_pad($input, 5, "0", STR_PAD_LEFT));

$recID = $_POST['recID'];
//$ownerID = $_POST['ownerID'];
$TypeID = $_POST['TypeID'];
$PriorityID = $_POST['PriorityID'];
$StatusID = $_POST['StatusID'];
$OwnerID = $_POST['OwnerID'];
$OrgID = $_POST['organization'];
$OrgBranchID = $_POST['filial'];
$AgrNumber = $_POST['AgrNumber'];
$FactDate = $_POST['FactDate'];
$FactDateTime = $_POST['FactDateTime'];
$DiscovererID = $_POST['DiscovererID'];
$DiscoverDate = $_POST['DiscoveryDate'];
$DiscoverDateTime = $_POST['DiscoveryDateTime'];
$CategoryID = $_POST['CategoryID'];
$SubCategoryID = $_POST['SubCategoryID'];
$CategoryOther = $_POST['CategoryOther'];
$SubCategoryOther = $_POST['SubCategoryOther'];
$RequetsDescription = $_POST['RequetsDescription'];
$SolverID = $_POST['SolverID'];
$DurationDeys = $_POST['DurationDeys'];
$DurationHours = $_POST['DurationHours'];
$SolveDate = $_POST['SolveDate'];
$SolveDateTime = $_POST['SolveDateTime'];
$SolvDescription = $_POST['SolvDescription'];
$NotInStatistics = isset($_POST['NotInStatistics']) ? 0 : 1;

if ($DiscoverDate != "") {
    $DiscoverDate .= " " . $DiscoverDateTime;
}
if ($FactDate != "") {
    $FactDate .= " " . $FactDateTime;
}
if ($SolveDate != "") {
    $SolveDate .= " " . $SolveDateTime;
}

$guiltyPersons = [];
if (isset($_POST['guiltyPersonIDs'])) {
    $guiltyPersons = $_POST['guiltyPersonIDs'];
} else {
    if ($_POST['guiltyPersonID'] != "") {
        $guiltyPersons[] = $_POST['guiltyPersonID'];
    }
}
//die(json_encode($guiltyPersons));

//$case_note = $_POST['case_note'];

//foreach($_POST as $kay => $dt ){
//    echo($kay . " = \$_POST['" . $kay . "']; </br>");
//}

function cancelPrevBinding($connDB, $accidentID)
{
    $canceledStatusID = "(SELECT di.ID FROM `DictionariyItems` di
LEFT JOIN Dictionaries d on d.ID = di.DictionaryID
WHERE d.Code = 'im_guilty_person_map_status' AND di.`Code` = 'canceled')";

    $sql_cancel_prev_persons = "
        UPDATE
            `im_guilty_persons`
        SET
            `StatusID` = $canceledStatusID
        WHERE
            `IM_RequestID` = $accidentID ";
    mysqli_query($connDB, $sql_cancel_prev_persons);
}

function bindGuiltyPerson($connDB, $gPersonID, $accidentID, $mappingID = 0)
{
    global $currDate, $currUser, $currUserID;

    $activeStatusID = "(SELECT di.ID FROM `DictionariyItems` di
LEFT JOIN Dictionaries d on d.ID = di.DictionaryID
WHERE d.Code = 'im_guilty_person_map_status' AND di.`Code` = 'active')";

    if ($mappingID == 0) {

        $sql_inst = "
        INSERT INTO `im_guilty_persons` 
        (`IM_RequestID`, `IM_PersonsID`, `StatusID`, `CreateDate`, `CreateUser`) 
        VALUES 
        ('$accidentID', '$gPersonID', $activeStatusID, $currDate, $currUserID)  ";

//        echo $sql_inst;
        return mysqli_query($connDB, $sql_inst);

    } else {
        // redaqtireba, $mappingID > 0
        // am etapze bmebis redaqtirebis magivrad kavshirs vauqmeb da tavidan vamateb axal kavshirebs
        $sqlInstUpdate = "
        UPDATE
        `UpdateUserID` = $currUserID,
        `UpdateUser` = '$currUser'
        WHERE
        `ID` = $mappingID ";
        return mysqli_query($connDB, $sqlInstUpdate);
    }
}

if ($recID == 0) {

    $sql = "
INSERT INTO `im_request`(
    `TypeID`,
    `PriorityID`,
    `StatusID`,
    `OwnerID`,
    `OrgID`,
    `OrgBranchID`,
    `AgrNumber`,
    `FactDate`,
    `DiscovererID`,
    `DiscoverDate`,
    `CategoryID`,
    `SubCategoryID`,
    `CategoryOther`,
    `SubCategoryOther`,
    `RequetsDescription`,
    `SolverID`,
    `DurationDeys`,
    `DurationHours`,
    `SolveDate`,
    `SolvDescription`,
    `NotInStatistics`,
    `CreateDate`,
    `CreateUser`    
)
VALUES(
    $TypeID,
    $PriorityID,
    $StatusID,
    '$OwnerID',
    '$OrgID',
    '$OrgBranchID',
    '$AgrNumber',
    '$FactDate',
    '$DiscovererID',
    '$DiscoverDate',
    '$CategoryID',
    '$SubCategoryID',
    '$CategoryOther',
    '$SubCategoryOther',
    '$RequetsDescription',
    '$SolverID',
    '$DurationDeys',
    '$DurationHours',
    '$SolveDate',
    '$SolvDescription',
    '$NotInStatistics',
    $currDate,
    $currUserID
)
";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $recID = mysqli_insert_id($conn);
        $resultArray['recID'] = $recID;

        $resultArray[RESULT] = SUCCESS;

        foreach ($guiltyPersons as $gPerson) {
            if (!bindGuiltyPerson($conn, $gPerson, $recID)) {
                $resultArray[RESULT] = ERROR;
                $resultArray[ERROR] = "can't map guilty Persons";
            }
        }

    } else {
        $resultArray[RESULT] = ERROR;
        $resultArray[ERROR] = "can't add Accident!";
    }

} else {
    // redaqtireba! recID > 0
    $updateSql = "
UPDATE
    `im_request`
SET
    `TypeID` = 	 $TypeID,
    `PriorityID` = 	    $PriorityID,
    `StatusID` = 	    $StatusID,
    `OwnerID` = 	    '$OwnerID',
    `OrgID` = 	    '$OrgID',
    `OrgBranchID` = 	    '$OrgBranchID',
    `AgrNumber` = 	    '$AgrNumber',
    `FactDate` = 	    '$FactDate',
    `DiscovererID` = 	    '$DiscovererID',
    `DiscoverDate` = 	    '$DiscoverDate',
    `CategoryID` = 	    '$CategoryID',
    `SubCategoryID` = 	    '$SubCategoryID',
    `CategoryOther` = 	    '$CategoryOther',
    `SubCategoryOther` = 	    '$SubCategoryOther',
    `RequetsDescription` = 	    '$RequetsDescription',
    `SolverID` = 	    '$SolverID',
    `DurationDeys` = 	    '$DurationDeys',
    `DurationHours` = 	    '$DurationHours',
    `SolveDate` = 	    '$SolveDate',
    `SolvDescription` =     '$SolvDescription',
    `NotInStatistics` =     '$NotInStatistics',
    `UpdateDate` = 	    $currDate,
    `UpdateUser` = 	    $currUserID
WHERE
    `ID` = $recID
    ";

    $result = mysqli_query($conn, $updateSql);

    if ($result) {
        $resultArray['recID'] = $recID;

        $resultArray[RESULT] = SUCCESS;
        cancelPrevBinding($conn, $recID);

        foreach ($guiltyPersons as $gPerson) {
            if (!bindGuiltyPerson($conn, $gPerson, $recID)) {
                $resultArray[RESULT] = ERROR;
                $resultArray[ERROR] = "can't map guilty Persons";
            }
        }

    } else {
        $resultArray[RESULT] = ERROR;
        $resultArray[ERROR] = "can't update Accident!";
    }
}

$resultArray['sql'] = $sql;


echo(json_encode($resultArray));

//INSERT INTO `im_guilty_persons` (`ID`, `IM_RequestID`, `IM_PersonsID`, `StatusID`, `CreateDate`, `CreateUser`) VALUES (NULL, '1', '2', '2', '2019-11-17 00:00:00', '1');