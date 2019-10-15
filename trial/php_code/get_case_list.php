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

function getValueInt($fieldName, $postKey){
    if (isset($_POST[$postKey]) && $_POST[$postKey] != "" && $_POST[$postKey] != "0"){
        return " AND $fieldName = " . $_POST[$postKey];
    }
    return "";
}

function getValuedate($fieldName, $postKey, $oper){
    if (isset($_POST[$postKey]) && $_POST[$postKey] != "" && $_POST[$postKey] != "0"){
        return " AND date($fieldName) $oper= '" . $_POST[$postKey] . "' AND $fieldName > '1'";
    }
    return "";
}

function getValueStr($fieldName, $postKey){
    if (isset($_POST[$postKey]) && $_POST[$postKey] != "" && $_POST[$postKey] != "0"){
        return " AND $fieldName like '" . $_POST[$postKey] . "%'";
    }
    return "";
}

$query = "";
$query .= getValueInt('cs.ID', 'case_N');
$query .= getValueInt('StatusID', 'case_status');
$query .= getValueInt('StageID', 'case_stage');
$query .= getValueInt('InstanceID', 'instance');
$query .= getValuedate('CreateDate', 'create_date_from', ">");
$query .= getValuedate('CreateDate', 'create_date_to', "<");
$query .= getValuedate('ReceiveDate', 'receive_date_from', ">");
$query .= getValuedate('ReceiveDate', 'receive_date_to', "<");
$query .= getValuedate('DistrDate', 'distr_date_from', ">");
$query .= getValuedate('DistrDate', 'distr_date_to', "<");
$query .= getValuedate('CloseDate', 'close_date_from', ">");
$query .= getValuedate('CloseDate', 'close_date_to', "<");
$query .= getValuedate('OwnDate', 'own_date_from', ">");
$query .= getValuedate('OwnDate', 'own_date_to', "<");
$query .= getValueInt('OwnerID', 'case_owner');
$query .= getValueStr('AgrNumber', 'agreement_N');
$query .= getValuedate('AgrDate', 'agreem_date', "");
$query .= getValueInt('AgrOrgID', 'organization');
$query .= getValueInt('AgrOrgBranchID', 'filial');
$query .= getValueStr('DebFirstName', 'borrower');
$query .= getValueStr('DebPrivateNumber', 'borrower_PN');


$query = trim($query, " AND");
if ($query == "")
    $query = "1";

$sql_count = "SELECT count(cs.ID) as n FROM `pcm_aplication` cs
LEFT JOIN dictionariyitems di1 ON di1.ID = cs.StatusID
LEFT JOIN dictionariyitems di2 ON di2.ID = cs.StageID
LEFT JOIN organizations o on o.ID = cs.AgrOrgID";

$sql_fields = "
SELECT cs.ID, LPAD(cs.ID, 5, '0') AS caseN, StatusID, di1.ValueText AS case_st, StageID, di2.ValueText AS case_stage, `AgrOrgID`, o.OrganizationName, `AgrNumber`, `DebFirstName` FROM `pcm_aplication` cs
LEFT JOIN dictionariyitems di1 ON di1.ID = cs.StatusID
LEFT JOIN dictionariyitems di2 ON di2.ID = cs.StageID
LEFT JOIN organizations o on o.ID = cs.AgrOrgID
";

$sql = " WHERE ";

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