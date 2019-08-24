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

$appID =  $_GET['appID'];

$sql = "
SELECT app.`ID`, `ApNumber`, Date(`ApDate`) AS ApDate, `OrganizationID`, `BranchID`, `ApStatus`, `AgreementNumber`, `TechTreeID`, `TechModelFix`, `TechSerial`, `TechIMEI`, app.`Note`, `EstimateResult1`, `EstimateResult2`, `maxPrice`, `SysTechPrice`, `ManagerAdd`, `ClientDec`, `CorTechPrice`, `appNote`, `CEstPerson`, Date(`CEstDate`) AS CEstDate, `CEstStatus`, `CEstPrice`, `CEstNote`, `FEstPerson`, Date(`FEstDate`) AS FEstDate, `FEstStatus`, `FEstPrice`, `FEstNote`, app.`CreateDate`, app.`CreateUser`, app.`CreateUserID`, app.`ModifyDate`, app.`ModifyUser`, app.`ModifyUserID`, tm.ParentID AS brand, tbr.ParentID AS techtype 
FROM `tech_estimate_applications` app
LEFT JOIN techniques_tree tm ON app.`TechTreeID` = tm.ID
LEFT JOIN techniques_tree tbr ON tm.ParentID = tbr.ID
WHERE app.ID =$appID";

$resultArray['sql'] = $sql;

// ganacxadi ra mnishvnelobebitac iyo shenaxuli im mdgmareobashi unda vachvenot
$sql_saved_crit = "
SELECT
    ec.Name AS criteria,
    ecp.Name AS gr,
    `APPID`,
    op.`TechTreeID`,
    `EstimateCriteriumID` AS id,
    `Impact`,
    di1.Code AS impactCode,
    `ImpactType`,
    di2.Code AS impactTypeCode,
    `ImpactValue`,
    `IsMain`,
    `OpChoice`,
    `ISLast`,
    `EstVersion`,
    `EstType`,
    op.`CreateDate`,
    op.`CreateUser`,
    op.`CreateUserID`,
    op.`ModifyDate`,
    op.`ModifyUser`,
    op.`ModifyUserID`
FROM
    `m2calc_applications_op_choice` op
LEFT JOIN estimate_criteriums_mapping ecm ON
    op.`EstimateCriteriumID` = ecm.ID
LEFT JOIN estimate_criteriums ec ON
    ecm.CriteriumID = ec.ID
LEFT JOIN estimate_criteriums ecp ON
    ecm.ParentID = ecp.ID
LEFT JOIN DictionariyItems di1 ON
	di1.ID = op.`Impact`
LEFT JOIN DictionariyItems di2 ON
	di2.ID = op.`ImpactType`
WHERE
    `APPID` = $appID AND ISLast = 1 
ORDER BY
    ecp.Name, ec.Name        
    ";

$resultArray['sql_saved_crit'] = $sql_saved_crit;

$result = mysqli_query($conn,  $sql);
$result_crit = mysqli_query($conn,  $sql_saved_crit);

$arr = [];
foreach($result as $row){
    $arr[] = $row;
}
$arrCr = [];
foreach($result_crit as $row){
    $arrCr[] = $row;
}

$resultArray['app_data'] = $arr[0];
$resultArray['app_crit_data'] = $arrCr;

echo(json_encode($resultArray));