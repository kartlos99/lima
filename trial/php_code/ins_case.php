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

$caseID = $_POST['caseID'];
$ownerID = $_POST['ownerID'];
$get_started_date = $_POST['get_started_date'];
$case_status = $_POST['case_status'];
$case_stage = $_POST['case_stage'];
$instance = $_POST['instance'];
$time_of_begin = $_POST['time_of_begin'];
$time_of_distribution = $_POST['time_of_distribution'];
$time_of_finish = $_POST['time_of_finish'];
$agreement_N = $_POST['agreement_N'];
$date_of_decoration = $_POST['date_of_decoration'];
$organization = $_POST['organization'];
$filial = $_POST['filial'];
$client_name = $_POST['client_name'];
$client_N = $_POST['client_N'];
$client_address = $_POST['client_address'];
$enf_status = $_POST['enf_status'];
$enf_request_time = $_POST['enf_request_time'];
$enf_take_time = $_POST['enf_take_time'];
$enf_start_time = $_POST['enf_start_time'];
$enf_result = $_POST['enf_result'];
$enf_amount = $_POST['enf_amount'];
$baj_status = $_POST['baj_status'];
$baj_request_time = $_POST['baj_request_time'];
$baj_take_time = $_POST['baj_take_time'];
$baj_result = $_POST['baj_result'];
$baj_amount = $_POST['baj_amount'];
$settle_status = $_POST['settle_status'];
$settle_start_time = $_POST['settle_start_time'];
$settle_time = $_POST['settle_time'];
$settle_result = $_POST['settle_result'];
$settle_currency = $_POST['settle_currency'];
$settle_footer = $_POST['settle_footer'];
$settle_percent = $_POST['settle_percent'];
$settle_puncture = $_POST['settle_puncture'];
$settle_costs = $_POST['settle_costs'];

//foreach($_POST as $kay => $dt ){
//    echo($kay . " = \$_POST['" . $kay . "']; </br>");
//}
$index = 'i1_';

function saveInstance($instance, $caseID, $connDB)
{
    global $currDate, $currUser, $currUserID;

    $index = 'i' . $instance . '_';

    $instID = $_POST[$index . 'instID'];

    $judicial_type = $_POST[$index . 'judicial_type'];
    $judicial_name = $_POST[$index . 'judicial_name'];
    $currency = $_POST[$index . 'currency'];
    $footer = $_POST[$index . 'footer'];
    $percent = $_POST[$index . 'percent'];
    $puncture = $_POST[$index . 'puncture'];
    $costs = $_POST[$index . 'costs'];
    $baj = $_POST[$index . 'baj'];
    $request_add_info = $_POST[$index . 'request_add_info'];
    $put_suit = $_POST[$index . 'put_suit'];
    $suit_put_date = $_POST[$index . 'suit_put_date'];
    $el_code_user = $_POST[$index . 'el_code_user'];
    $el_code_pass = $_POST[$index . 'el_code_pass'];
    $take_suit = $_POST[$index . 'take_suit'];
    $suit_take_date = $_POST[$index . 'suit_take_date'];
    $judge_name = $_POST[$index . 'judge_name'];
    $assistant_name = $_POST[$index . 'assistant_name'];
    $contact_info = $_POST[$index . 'contact_info'];
    $client_put_suit = $_POST[$index . 'client_put_suit'];
    $suit_put_type = $_POST[$index . 'suit_put_type'];
    $suit_client_put_date = $_POST[$index . 'suit_client_put_date'];
    $suit_send_time1 = $_POST[$index . 'suit_send_time1'];
    $suit_send_result1 = $_POST[$index . 'suit_send_result1'];
    $suit_send_time2 = $_POST[$index . 'suit_send_time2'];
    $suit_send_result2 = $_POST[$index . 'suit_send_result2'];
    $suit_put_result = $_POST[$index . 'suit_put_result'];
    $judge_notice_date = $_POST[$index . 'judge_notice_date'];
    $public_put_date = $_POST[$index . 'public_put_date'];
    $response_status = $_POST[$index . 'response_status'];
    $response_date = $_POST[$index . 'response_date'];
    $court_status = $_POST[$index . 'court_status'];
    $court_mark_date = $_POST[$index . 'court_mark_date'];
    $court_mark_comment = $_POST[$index . 'court_mark_comment'];
    $court_date = $_POST[$index . 'court_date'];
    $decision_type = $_POST[$index . 'decision_type'];
    $decision_take_date = $_POST[$index . 'decision_take_date'];
    $decision_take_effect_date = $_POST[$index . 'decision_take_effect_date'];
    $decision_currency = $_POST[$index . 'decision_currency'];
    $decision_footer = $_POST[$index . 'decision_footer'];
    $decision_percent = $_POST[$index . 'decision_percent'];
    $decision_puncture = $_POST[$index . 'decision_puncture'];
    $decision_costs = $_POST[$index . 'decision_costs'];
    $additional_info = $_POST[$index . 'additional_info'];

    $cltoPerPublicRemainderStartDate = $_POST[$index . 'cltoPerPublicRemainderStartDate'];;
    $cltoPerPublicRemainderEndDate = $_POST[$index . 'cltoPerPublicRemainderEndDate'];;
    $public_put_reminder = isset($_POST[$index . 'public_put_reminder']);
    if ($public_put_reminder && $cltoPerPublicRemainderStartDate == "0") {
        $cltoPerPublicRemainderStartDate = time();
        $cltoPerPublicRemainderEndDate = 0;
    }
    if (!$public_put_reminder && $cltoPerPublicRemainderStartDate != "0") {
        $cltoPerPublicRemainderStartDate = 0;
        $cltoPerPublicRemainderEndDate = time();
    }

    $courtProcessRemainderStartDate = $_POST[$index . 'CourtProcessRemainderStartDate'];;
    $courtProcessRemainderEndDate = $_POST[$index . 'CourtProcessRemainderEndDate'];;
    $court_hearing_reminder = isset($_POST[$index . 'court_hearing_reminder']);
    if ($court_hearing_reminder && $courtProcessRemainderStartDate == "0") {
        $courtProcessRemainderStartDate = time();
        $courtProcessRemainderEndDate = 0;
    }
    if (!$court_hearing_reminder && $courtProcessRemainderStartDate != "0") {
        $courtProcessRemainderStartDate = 0;
        $courtProcessRemainderEndDate = time();
    }

    $courtDecRemainderStartDate = $_POST[$index . 'CourtDecRemainderStartDate'];;
    $courtDecRemainderEndDate = $_POST[$index . 'CourtDecRemainderEndDate'];;
    $court_decision_reminder = isset($_POST[$index . 'court_decision_reminder']);
    if ($court_decision_reminder && $courtDecRemainderStartDate == "0") {
        $courtDecRemainderStartDate = time();
        $courtDecRemainderEndDate = 0;
    }
    if (!$court_decision_reminder && $courtDecRemainderStartDate != "0") {
        $courtDecRemainderStartDate = 0;
        $courtDecRemainderEndDate = time();
    }

    if ($instID == 0) {
        $sql_inst = "
INSERT INTO `pcm_aplication_instances`(
    `caseID`,
    `TypesID`,
    `JudicialentityTypeID`,
    `JudicialentityD`,
    `ClaimCurID`,
    `Claimbase`,
    `ClaimPercent`,
    `ClaimPenalty`,
    `ClaimCost`,
    `ClaimDuty`,
    `ClaimNotice`,
    `ClaimdeliveryStatus`,
    `ClaimdeliveryDate`,
    `ClaimSysUserName`,
    `ClaimSysPassword`,
    `ClaimProceeedID`,
    `ClaimProceeedDate`,
    `ClaimJudgeName`,
    `ClaimJudgeAssistant`,
    `ClaimJudgePhone`,
    `CltoPerDeliveryStatus`,
    `CltoPerDeliveryMethod`,
    `CltoPerDeliveryDate`,
    `CltoPerFirstSentDate`,
    `CltoPerFirstSentResult`,
    `CltoPerSecondSentDate`,
    `CltoPerSecondSentResult`,
    `CltoPerStandardSentResult`,
    `CltoPerDeliveryToCourtDate`,
    `CltoPerPublicDeliveryReqDate`,
    `CltoPerPublicRemainderStartDate`,
    `CltoPerPublicRemainderEndDate`,
    `CltoPerPublicRemainder`,
    `ClaimContStatusID`,
    `ClaimContPresDate`,
    `CourtProcessStatusID`,
    `CourtProcessPreDate`,
    `CourtProcessComment`,
    `CourtProcessDate`,
    `CourtProcessRemainderStartDate`,
    `CourtProcessRemainderEndDate`,
    `CourtProcessRemainder`,
    `CourtDecRemainderStartDate`,
    `CourtDecRemainderEndDate`,
    `CourtDecRemainder`,
    `CourtDecTypeID`,
    `CourtDecDate`,
    `CourtDecActDate`,
    `CourtDecResCurID`,
    `CourtDecResBase`,
    `CourtDecResPercent`,
    `CourtDecResPenalty`,
    `CourtDecResCost`,
    `Notice`,
    `CreateDate`,
    `CreateUserID`,
    `CreateUser`
)
VALUES(
    $caseID,
    $instance,
    $judicial_type,
    $judicial_name,
    $currency,
    '$footer',
    '$percent',
    '$puncture',
    '$costs',
    '$baj',
    '$request_add_info',
    '$put_suit',
    '$suit_put_date',
    '$el_code_user',
    '$el_code_pass',
    '$take_suit',
    '$suit_take_date',
    '$judge_name',
    '$assistant_name',
    '$contact_info',
    '$client_put_suit',
    '$suit_put_type',
    '$suit_client_put_date',
    '$suit_send_time1',
    '$suit_send_result1',
    '$suit_send_time2',
    '$suit_send_result2',
    '$suit_put_result',
    '$judge_notice_date',
    '$public_put_date',
    '$cltoPerPublicRemainderStartDate',
    '$cltoPerPublicRemainderEndDate',
    '$public_put_reminder',
    '$response_status',
    '$response_date',
    '$court_status',
    '$court_mark_date',
    '$court_mark_comment',
    '$court_date',
    '$courtProcessRemainderStartDate',
    '$courtProcessRemainderEndDate',
    '$court_hearing_reminder',
    '$courtDecRemainderStartDate',
    '$courtDecRemainderEndDate',
    '$court_decision_reminder',
    '$decision_type',
    '$decision_take_date',
    '$decision_take_effect_date',
    '$decision_currency',
    '$decision_footer',
    '$decision_percent',
    '$decision_puncture',
    '$decision_costs',
    '$additional_info',
    $currDate,
    $currUserID,
    '$currUser'
    )
    ";

        if (mysqli_query($connDB, $sql_inst)) {
            return mysqli_insert_id($connDB);
        }

    }else{
        // redaqtireba, instID > 0
        $sqlInstUpdate = "
        UPDATE
    `pcm_aplication_instances`
SET
    `JudicialentityTypeID` = $judicial_type,
    `JudicialentityD` = $judicial_name,
    `ClaimCurID` = $currency,
    `Claimbase` = '$footer',
    `ClaimPercent` = '$percent',
    `ClaimPenalty` = '$puncture',
    `ClaimCost` = '$costs',
    `ClaimDuty` = '$baj',
    `ClaimNotice` = '$request_add_info',
    `ClaimdeliveryStatus` = '$put_suit',
    `ClaimdeliveryDate` = '$suit_put_date',
    `ClaimSysUserName` = '$el_code_user',
    `ClaimSysPassword` = '$el_code_pass',
    `ClaimProceeedID` = '$take_suit',
    `ClaimProceeedDate` = '$suit_take_date',
    `ClaimJudgeName` = '$judge_name',
    `ClaimJudgeAssistant` = '$assistant_name',
    `ClaimJudgePhone` = '$contact_info',
    `CltoPerDeliveryStatus` = '$client_put_suit',
    `CltoPerDeliveryMethod` = '$suit_put_type',
    `CltoPerDeliveryDate` = '$suit_client_put_date',
    `CltoPerFirstSentDate` = '$suit_send_time1',
    `CltoPerFirstSentResult` = '$suit_send_result1',
    `CltoPerSecondSentDate` = '$suit_send_time2',
    `CltoPerSecondSentResult` = '$suit_send_result2',
    `CltoPerStandardSentResult` = '$suit_put_result',
    `CltoPerDeliveryToCourtDate` = '$judge_notice_date',
    `CltoPerPublicDeliveryReqDate` = '$public_put_date',
    `CltoPerPublicRemainderStartDate` = '$cltoPerPublicRemainderStartDate',
    `CltoPerPublicRemainderEndDate` = '$cltoPerPublicRemainderEndDate',
    `CltoPerPublicRemainder` = '$public_put_reminder',
    `ClaimContStatusID` = '$response_status',
    `ClaimContPresDate` = '$response_date',
    `CourtProcessStatusID` = '$court_status',
    `CourtProcessPreDate` = '$court_mark_date',
    `CourtProcessComment` = '$court_mark_comment',
    `CourtProcessDate` = '$court_date',
    `CourtProcessRemainderStartDate` = '$courtProcessRemainderStartDate',
    `CourtProcessRemainderEndDate` = '$courtProcessRemainderEndDate',
    `CourtProcessRemainder` = '$court_hearing_reminder',
    `CourtDecRemainderStartDate` = '$courtDecRemainderStartDate',
    `CourtDecRemainderEndDate` = '$courtDecRemainderEndDate',
    `CourtDecRemainder` = '$court_decision_reminder',
    `CourtDecTypeID` = '$decision_type',
    `CourtDecDate` = '$decision_take_date',
    `CourtDecActDate` = '$decision_take_effect_date',
    `CourtDecResCurID` = '$decision_currency',
    `CourtDecResBase` = '$decision_footer',
    `CourtDecResPercent` = '$decision_percent',
    `CourtDecResPenalty` = '$decision_puncture',
    `CourtDecResCost` = '$decision_costs',
    `Notice` = '$additional_info',
    `UpdateDate` = $currDate,
    `UpdateUserID` = $currUserID,
    `UpdateUser` = '$currUser'
WHERE
    `ID` = $instID
    ";

//        return $sqlInstUpdate;
        if (mysqli_query($connDB, $sqlInstUpdate)) {
            return $instID;
        }
    }
    return 0;
}

if ($caseID == 0) {


    $sql = "
INSERT INTO `pcm_aplication`(
    `StatusID`,
    `StageID`,
    `InstanceID`,
    `OwnerID`,
    `OwnDate`,
    `ReceiveDate`,
    `DistrDate`,
    `CloseDate`,
    `AgrNumber`,
    `AgrDate`,
    `AgrOrgID`,
    `AgrOrgBranchID`,
    `DebLastName`,
    `DebFirstName`,
    `DebPrivateNumber`,
    `DebAddress`,
    `FirstInstanceID`,
    `SecondInstanceID`,
    `ThirdInstanceID`,
    `ExecStatusID`,
    `ExecReqDate`,
    `ExecGetDate`,
    `ExecProcessDate`,
    `ExecResultID`,
    `ExecMoney`,
    `DutyStatusID`,
    `DutyReqDate`,
    `DutyGetDate`,
    `DutyResultID`,
    `DutyMoney`,
    `SettStatusID`,
    `SettStartDate`,
    `SettResultID`,
    `SettDate`,
    `SettCurID`,
    `Settbase`,
    `SettPercent`,
    `SettPenalty`,
    `SettCost`,
    `CreateDate`,
    `CreateUserID`,
    `CreateUser`
)
VALUES(
    $case_status,
    $case_stage,
    $instance,
    $ownerID,
    '$get_started_date',
    '$time_of_begin',
    '$time_of_distribution',
    '$time_of_finish',
    '$agreement_N',
    '$date_of_decoration',
    $organization,
    $filial,
    '',
    '$client_name',
    '$client_N',
    '$client_address',
    0,
    0,
    0,
    $enf_status,
    '$enf_request_time',
    '$enf_take_time',
    '$enf_start_time',
    '$enf_result',
    '$enf_amount',
    $baj_status,
    '$baj_request_time',
    '$baj_take_time',
    '$baj_result',
    '$baj_amount',
    $settle_status,
    '$settle_start_time',
    '$settle_result',
    '$settle_time',
    $settle_currency,
    '$settle_footer',
    '$settle_percent',
    '$settle_puncture',
    '$settle_costs',
    $currDate,
    $currUserID,
    '$currUser'
)
";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $caseID = mysqli_insert_id($conn);
        $resultArray['caseID'] = $caseID;

        $res2 = true;
        for ($i = 1; $i <= 3; $i++) {
            if (isset($_POST['i' . $i . '_judicial_type'])) {
                $resultArray['i' . $i] = saveInstance($i, $caseID, $conn);
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

} else {
    // redaqtireba! caseID > 0
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
    `UpdateDate` = $currDate,
    `UpdateUserID` = $currUserID,
    `UpdateUser` = '$currUser'
WHERE
    `ID` = $caseID
    ";

    $result = mysqli_query($conn, $caseUpdateSql);

    if ($result) {
        $resultArray['caseID'] = $caseID;

        $res2 = true;
        for ($i = 1; $i <= 3; $i++) {
            if (isset($_POST['i' . $i . '_judicial_type'])) {
                $resultArray['i' . $i] = saveInstance($i, $caseID, $conn);
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

//$resultArray['sql'] = $sql;


echo(json_encode($resultArray));