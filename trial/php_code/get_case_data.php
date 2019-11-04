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

$caseID = $_GET['id'];

$sql_inst = "SELECT
    `ID`,
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
    DATE(`ClaimdeliveryDate`) AS `ClaimdeliveryDate`,
    `ClaimSysUserName`,
    `ClaimSysPassword`,
    `ClaimProceeedID`,
    DATE(`ClaimProceeedDate`) AS `ClaimProceeedDate`,
    `ClaimJudgeName`,
    `ClaimJudgeAssistant`,
    `ClaimJudgePhone`,
    `CltoPerDeliveryStatus`,
    `CltoPerDeliveryMethod`,
    DATE(`CltoPerDeliveryDate`) AS `CltoPerDeliveryDate`,
    DATE(`CltoPerFirstSentDate`) AS `CltoPerFirstSentDate`,
    `CltoPerFirstSentResult`,
    DATE(`CltoPerSecondSentDate`) AS `CltoPerSecondSentDate`,
    `CltoPerSecondSentResult`,
    `CltoPerStandardSentResult`,
    DATE(`CltoPerDeliveryToCourtDate`) AS `CltoPerDeliveryToCourtDate`,
    DATE(`CltoPerPublicDeliveryReqDate`) AS `CltoPerPublicDeliveryReqDate`,
    `CltoPerPublicRemainderStartDate`,
    `CltoPerPublicRemainderEndDate`,
    `CltoPerPublicRemainder`,
    `ClaimContStatusID`,
    DATE(`ClaimContPresDate`) AS `ClaimContPresDate`,
    `CourtProcessStatusID`,
    DATE(`CourtProcessPreDate`) AS `CourtProcessPreDate`,
    `CourtProcessComment`,
    DATE(`CourtProcessDate`) AS `CourtProcessDate`,
    `CourtProcessRemainderStartDate`,
    `CourtProcessRemainderEndDate`,
    `CourtProcessRemainder`,
    `CourtDecRemainderStartDate`,
    `CourtDecRemainderEndDate`,
    `CourtDecRemainder`,
    `CourtDecTypeID`,
    DATE(`CourtDecDate`) AS `CourtDecDate`,
    DATE(`CourtDecActDate`) AS `CourtDecActDate`,
    `CourtDecResCurID`,
    `CourtDecResBase`,
    `CourtDecResPercent`,
    `CourtDecResPenalty`,
    `CourtDecResCost`,
    `Notice`,
    `CreateDate`,
    `CreateUserID`,
    `CreateUser`,
    `UpdateDate`,
    `UpdateUserID`,
    `UpdateUser`
FROM
    `pcm_aplication_instances`
WHERE
    `caseID` = $caseID";


$sql_case = "SELECT
    cs.`ID`,
    `StatusID`,
    `StageID`,
    `InstanceID`,
    `OwnerID`,
    DATE(`OwnDate`) AS OwnDate,
    DATE(`ReceiveDate`) AS `ReceiveDate`,
    DATE(`DistrDate`) AS `DistrDate`,
    DATE(`CloseDate`) AS `CloseDate`,
    `AgrNumber`,
    DATE(`AgrDate`) AS `AgrDate`,
    `AgrLoanType`,
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
    DATE(`ExecReqDate`) AS `ExecReqDate`,
    DATE(`ExecGetDate`) AS `ExecGetDate`,
    DATE(`ExecProcessDate`) AS `ExecProcessDate`,
    `ExecResultID`,
    `ExecMoney`,
    `DutyStatusID`,
    DATE(`DutyReqDate`) AS `DutyReqDate`,
    DATE(`DutyGetDate`) AS `DutyGetDate`,
    `DutyResultID`,
    `DutyMoney`,
    `SettStatusID`,
    DATE(`SettStartDate`) AS `SettStartDate`,
    `SettResultID`,
    DATE(`SettDate`) AS `SettDate`,
    `SettCurID`,
    `Settbase`,
    `SettPercent`,
    `SettPenalty`,
    `SettCost`,
    cs.`caseNote`,
    date(cs.`CreateDate`) as CreateDate,
    cs.`CreateUserID`,
    cs.`CreateUser`,
    cs.`UpdateDate`,
    cs.`UpdateUserID`,
    cs.`UpdateUser`,
    per.UserName AS ownerName
FROM
    `pcm_aplication` cs
LEFT JOIN PersonMapping per
ON cs.OwnerID = per.ID
WHERE
    cs.ID = $caseID";

$resultArray['sql'] = $sql_case;

$result1 = mysqli_query($conn,  $sql_case);
$result2 = mysqli_query($conn, $sql_inst);

$instances = [];
foreach($result1 as $row){
    $resultArray['case'] = $row;
}
foreach($result2 as $row){
    $instances[] = $row;
}

$resultArray['instances'] = $instances;

echo(json_encode($resultArray));