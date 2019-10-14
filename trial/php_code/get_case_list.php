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
$limit = " limit 20";

$query = "";
//$query .= isset($_POST['type']) && $_POST['type'] != "" && $_POST['type'] != "0" ? " AND ttp.ID = " . $_POST['type'] : "";
//$query .= isset($_POST['brand']) && $_POST['brand'] != "" && $_POST['brand'] != "0" ? " AND tbr.ID = " . $_POST['brand'] : "";
//$query .= isset($_POST['model']) && $_POST['model'] != "" && $_POST['model'] != "0" ? " AND tm.ID = " . $_POST['model'] : "";
//$query .= isset($_POST['modelbyhand']) && $_POST['modelbyhand'] != "" ? " AND `TechModelFix` like '" . $_POST['modelbyhand'] . "%'" : "";
//$query .= isset($_POST['serial_N']) && $_POST['serial_N'] != "" ? " AND `TechSerial` like '" . $_POST['serial_N'] . "%'" : "";
//$query .= isset($_POST['imei']) && $_POST['imei'] != "" ? " AND `TechIMEI` like '" . $_POST['imei'] . "%'" : "";
//$query .= isset($_POST['organization']) && $_POST['organization'] != "" && $_POST['organization'] != "0" ? " AND OrganizationID = " . $_POST['organization'] : "";
//$query .= isset($_POST['filial']) && $_POST['filial'] != "" && $_POST['filial'] != "0" ? " AND BranchID = " . $_POST['filial'] : "";
//$query .= isset($_POST['operator']) && $_POST['operator'] != "" ? " AND app.`ModifyUser` like '" . $_POST['operator'] . "%'" : "";
//$query .= isset($_POST['application_N']) && $_POST['application_N'] != "" ? " AND app.`ApNumber` like '" . $_POST['application_N'] . "%'" : "";
//$query .= isset($_POST['date_from']) && $_POST['date_from'] != "" ? " AND app.`ApDate` >= '" . $_POST['date_from'] . "'" : "";
//$query .= isset($_POST['date_till']) && $_POST['date_till'] != "" ? " AND app.`ApDate` <= '" . $_POST['date_till'] . "'" : "";
//$query .= isset($_POST['agreement_N']) && $_POST['agreement_N'] != "" ? " AND app.`AgreementNumber` like '" . $_POST['agreement_N'] . "%'" : "";
//$query .= isset($_POST['application_status']) && $_POST['application_status'] != "" && $_POST['application_status'] != "0" ? " AND app.`ApStatus` = " . $_POST['application_status'] : "";
//$query .= isset($_POST['control_rate_result']) && $_POST['control_rate_result'] != "" && $_POST['control_rate_result'] != "0" ? " AND `CEstStatus` = " . $_POST['control_rate_result'] : "";
//$query .= isset($_POST['detail_rate_result']) && $_POST['detail_rate_result'] != "" && $_POST['detail_rate_result'] != "0" ? " AND `FEstStatus` = " . $_POST['detail_rate_result'] : "";

$query = trim($query, " AND");
if ($query == "")
    $query = "1";

$sql_count = "SELECT count(ID) AS n FROM `pcm_aplication`";

$sql_fields = "SELECT cs.ID, LPAD(cs.ID, 5, '0') AS caseN, StatusID, di1.ValueText AS case_st, StageID, di2.ValueText AS case_stage, `AgrOrgID`, o.OrganizationName, `AgrNumber`, `DebFirstName` FROM `pcm_aplication` cs
LEFT JOIN dictionariyitems di1 ON di1.ID = cs.StatusID
LEFT JOIN dictionariyitems di2 ON di2.ID = cs.StageID
LEFT JOIN organizations o on o.ID = cs.AgrOrgID
";

$sql = " WHERE ";
//FROM `tech_estimate_applications` app
//LEFT JOIN States s ON s.ID = app.`ApStatus`
//LEFT JOIN Organizations o ON o.ID = app.`OrganizationID`
//LEFT JOIN States sc ON sc.ID = app.`CEstStatus`
//LEFT JOIN States sf ON sf.ID = app.`FEstStatus`
//LEFT JOIN techniques_tree tm ON app.`TechTreeID` = tm.ID
//LEFT JOIN techniques_tree tbr ON tm.ParentID = tbr.ID
//LEFT JOIN techniques_tree ttp ON tbr.ParentID = ttp.ID



$resultArray['sql'] = $sql_fields . $sql . $query . $limit;

$result = mysqli_query($conn,  $sql_fields . $sql . $query . $limit);
$result_N = mysqli_query($conn, $sql_count . $sql . $query);

$arr = [];
$nn = [];
foreach($result as $row){
    $arr[] = $row;
}
foreach($result_N as $row){
    $nn[] = $row;
}
$resultArray['data'] = $arr;
$resultArray['count'] = $nn;

echo(json_encode($resultArray));