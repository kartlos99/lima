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
    $caseUpdateSql = "
UPDATE
    `pcm_aplication`
SET
    `StatusID` = $case_status,
    `StageID` = $case_stage,
    `InstanceID` = $instance,
    `OwnerID` = $ownerID,
    `OwnDate` = '$get_started_date',
    `ReceiveDate` = '$time_of_begin',
    `DistrDate` = '$time_of_distribution',
    `CloseDate` = '$time_of_finish',
    `AgrNumber` = '$agreement_N',
    `AgrDate` = '$date_of_decoration',
    `AgrLoanType` = $loanType,
    `AgrOrgID` = $organization,
    `AgrOrgBranchID` = $filial,
    `DebFirstName` = '$client_name',
    `DebPrivateNumber` = '$client_N',
    `DebAddress` = '$client_address',
    `ExecStatusID` = $enf_status,
    `ExecReqDate` = '$enf_request_time',
    `ExecGetDate` = '$enf_take_time',
    `ExecProcessDate` = '$enf_start_time',
    `ExecResultID` = '$enf_result',
    `ExecMoney` = '$enf_amount',
    `DutyStatusID` = $baj_status,
    `DutyReqDate` = '$baj_request_time',
    `DutyGetDate` = '$baj_take_time',
    `DutyResultID` = '$baj_result',
    `DutyMoney` = '$baj_amount',
    `SettStatusID` = $settle_status,
    `SettStartDate` = '$settle_start_time',
    `SettResultID` = '$settle_result',
    `SettDate` = '$settle_time',
    `SettCurID` = $settle_currency,
    `Settbase` = '$settle_footer',
    `SettPercent` = '$settle_percent',
    `SettPenalty` = '$settle_puncture',
    `SettCost` = '$settle_costs',
    `caseNote` = '$case_note',
    `UpdateDate` = $currDate,
    `UpdateUserID` = $currUserID,
    `UpdateUser` = '$currUser'
WHERE
    `ID` = $recID
    ";

    $result = mysqli_query($conn, $caseUpdateSql);

    if ($result) {
        $resultArray['caseID'] = $recID;

        $res2 = true;
        for ($i = 1; $i <= 3; $i++) {
            if (isset($_POST['i' . $i . '_judicial_type'])) {
                $resultArray['i' . $i] = saveInstance($i, $recID, $conn);
                if (!$resultArray['i' . $i]) {
                    $res2 = false;
                }
            }
        }

        if ($res2) {
            $resultArray['result'] = "success";
        } else {
            $resultArray['result'] = "error";
            $resultArray['error'] = "can't add case_Instance!";
        }

    } else {
        $resultArray['result'] = "error";
        $resultArray['error'] = "can't add case!";
    }

}

$resultArray['sql'] = $sql;


echo(json_encode($resultArray));

//INSERT INTO `im_guilty_persons` (`ID`, `IM_RequestID`, `IM_PersonsID`, `StatusID`, `CreateDate`, `CreateUser`) VALUES (NULL, '1', '2', '2', '2019-11-17 00:00:00', '1');