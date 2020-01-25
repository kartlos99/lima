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
$apNumber = Date(time());
$apDate = $currDate;

$event = $_POST['event'];

$techTreeID = $_POST['TechTreeID'];
$record_id = $_POST['record_id'];


$apStatus = isset($_POST['ApStatus']) ? $_POST['ApStatus'] : "getstateid('Project', getobjid('app_states'))";


if ($event == "gen_info") {

    $techModelFix = $_POST['TechModelFix'];
    $techSerial = $_POST['TechSerial'];
    $techIMEI = $_POST['TechIMEI'];
    $note = $_POST['note'];
//$EstimateResult1= $_POST['EstimateResult1'];
//$EstimateResult2= $_POST['EstimateResult2'];
    $sysTechPrice = $_POST['SysTechPrice'];
    $managerAdd = $_POST['ManagerAdd'];
    $clientDec = $_POST['ClientDec'];
    $corTechPrice = $_POST['CorTechPrice'];
    $maxPrice = $_POST['maxPrice'];

    if ($record_id == 0) {

        $sql = "
INSERT INTO `tech_estimate_applications`(
    `ApNumber`,
    `ApDate`,
    `ApStatus`,
    `TechTreeID`,
    `TechModelFix`,
    `TechSerial`,
    `TechIMEI`,
    `Note`,
    `maxPrice`,
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
    '$techTreeID',
    '$techModelFix',
    '$techSerial',
    '$techIMEI',
    '$note',
    $maxPrice,
    '$sysTechPrice',
    '$managerAdd',
    '$clientDec',
    '$corTechPrice',
    $currDate,
    '$currUser',
    $currUserID
)
";

        $resultArray['ApNumber'] = $apNumber;
        $resultArray['ApDate'] = Date("Y-m-d", time());
    } else {


        $sql = "
UPDATE
    `tech_estimate_applications`
SET
    `ApStatus` = $apStatus,
    `TechModelFix` = '$techModelFix',
    `TechSerial` = '$techSerial',
    `TechIMEI` = '$techIMEI',
    `Note` = '$note',
    `maxPrice` = $maxPrice,
    `SysTechPrice` = '$sysTechPrice',
    `ManagerAdd` = $managerAdd,
    `ClientDec` = $clientDec,
    `CorTechPrice` = '$corTechPrice',
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = $currUserID
where
   ID = $record_id
";

        $resultArray['record_id'] = $record_id;
    }

    $resultArray['sql'] = $sql;


    $result = mysqli_query($conn, $sql);

    if ($result) {
        if ($record_id == 0) {
            $record_id = mysqli_insert_id($conn);
            $resultArray['record_id'] = $record_id;
        }

        // save operator choosen Criterias
        $allCriteriaIDs = isset( $_POST['allCriteriaIDs']) ? $_POST['allCriteriaIDs'] : [];
        $selectedCriteriaIDs = isset($_POST['selectedCriteriaIDs']) ? $_POST['selectedCriteriaIDs'] : [];
        $idsString = implode(", ", $allCriteriaIDs);
        $selIDsString = implode(", ", $selectedCriteriaIDs);
        $vers = 0;

        $sql_vers = "SELECT ifnull(MAX(`EstVersion`), 0)+1 AS 'vers' FROM `m2calc_applications_op_choice` WHERE `APPID` = $record_id";
        $rv = mysqli_query($conn, $sql_vers);
        if (mysqli_num_rows($rv) > 0) {
            $v_arr = mysqli_fetch_assoc($rv);
            $vers = $v_arr['vers'];
        }

        $sql_opChoice = "
INSERT INTO `m2calc_applications_op_choice`(    
    `APPID`,
    `TechTreeID`,
    `EstimateCriteriumID`,
    `Impact`,
    `ImpactType`,
    `ImpactValue`,
    `IsMain`,
    `OpChoice`,
    `ISLast`,
    `EstVersion`,
    `EstType`,
    `CreateDate`,
    `CreateUser`,
    `CreateUserID`
)
SELECT $record_id, $techTreeID, `EstimateCriteriumID`, `Impact`, `ImpactType`, `ImpactValue`, `IsMain`, 2, 1, $vers , 93, $currDate, '$currUser', $currUserID FROM `estimate_criterium_values` 
WHERE `EstimateCriteriumID` IN ($idsString)";

        $sql_isLastCorection = "UPDATE `m2calc_applications_op_choice` SET `ISLast` = 0 WHERE `APPID` = $record_id ";
        mysqli_query($conn, $sql_isLastCorection);

        $resultArray['sql_opChoice'] = $sql_opChoice;

        if (mysqli_query($conn, $sql_opChoice)) {
            $resultArray['result_op'] = "half";
            $sql_opChoice_update = "
                UPDATE `m2calc_applications_op_choice` 
                SET `OpChoice` = 1 
                WHERE `APPID` = $record_id AND `EstVersion` = $vers AND `EstimateCriteriumID` IN ($selIDsString)";
            if (mysqli_query($conn, $sql_opChoice_update)) {
                $resultArray['result_op'] = "success";
            }
        }

        $resultArray['result'] = "success";
    } else {
        $resultArray['result'] = "error";
        $resultArray['error'] = "can't done on application table!";
    }
}

if ($event == "btn_save") {
    $organizationID = isset($_POST['OrganizationID']) && $_POST['OrganizationID'] != "" ? $_POST['OrganizationID'] : 0;
    $branchID = isset($_POST['BranchID']) && $_POST['BranchID'] != "" ? $_POST['BranchID'] : 0;
    $agreementNumber = isset($_POST['agreement_app']) ? $_POST['agreement_app'] : "";
//    $status_app = $_POST['status_app'];
    $note_app = $_POST['note_app'];
    $estimateResult1 = $_POST['EstimateResult1'];

    $control_rate_result_id_control = $_POST['control_rate_result_id_control'];
    $adjusted_amount_id_control = $_POST['adjusted_amount_id_control'];
    $note_id_control = $_POST['note_id_control'];

    $is_control = "";
    if ($adjusted_amount_id_control != "" || $note_id_control != "" || $control_rate_result_id_control != "0") {
        $is_control = "
    `CEstPerson` = '$currUser',
    `CEstDate` = $currDate,
    `CEstStatus` = $control_rate_result_id_control,
    `CEstPrice` = '$adjusted_amount_id_control',
    `CEstNote` = '$note_id_control',
    ";
    }

//    die($is_control . $adjusted_amount_id_control.  $control_rate_result_id_control);

    $detail_rate_result_id_market = $_POST['detail_rate_result_id_market'];
    $adjusted_amount_id_market = $_POST['adjusted_amount_id_market'];
    $note_id_market = $_POST['note_id_market'];

    $is_market = "";
    if ($adjusted_amount_id_market != "" || $note_id_market != "" || $detail_rate_result_id_market != 0) {
        $is_market = "
    `FEstPerson` = '$currUser',
    `FEstDate` = $currDate,
    `FEstStatus` = $detail_rate_result_id_market,
    `FEstPrice` = '$adjusted_amount_id_market',
    `FEstNote` = '$note_id_market',
    ";
    }

    $sql_appUpdate = "
UPDATE
    `tech_estimate_applications`
SET
    `OrganizationID` = $organizationID,
    `BranchID` = $branchID,
    `ApStatus` = $apStatus,
    `AgreementNumber` = '$agreementNumber',
    `TechTreeID` = $techTreeID,
    `appNote` = '$note_app',
    `EstimateResult1` = '$estimateResult1',

    $is_control

    $is_market
    
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = $currUserID
WHERE
    ID = $record_id";

    $resultArray['sql_appUpdate'] = $sql_appUpdate;

    $update_result = mysqli_query($conn, $sql_appUpdate);

    if ($update_result) {
        $resultArray['result'] = "success";
    }else{
        $resultArray['error'] = "ver ganaaxla application";
    }

}

echo(json_encode($resultArray));

