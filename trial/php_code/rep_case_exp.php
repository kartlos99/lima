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

$sql = " 
SELECT
    `AgrNumber`,
    `DebFirstName`,
    di.ValueText AS loanType,
    di_st.ValueText AS statusi,
    di_stage.ValueText AS stage,
    CONCAT(p.FirstName, ' ', p.LastName) AS OWNER
FROM
    `pcm_aplication` a
LEFT JOIN DictionariyItems di ON
    a.`AgrLoanType` = di.ID
LEFT JOIN DictionariyItems di_st ON
    a.`StatusID` = di_st.ID
LEFT JOIN DictionariyItems di_stage ON
    a.`StageID` = di_stage.ID
LEFT JOIN personmapping pmap ON
    OwnerID = pmap.ID
LEFT JOIN persons p ON
    pmap.PersonID = p.ID
WHERE 
";

function getValueInt($fieldName, $postKey){
    if (isset($_GET[$postKey]) && $_GET[$postKey] != "" && $_GET[$postKey] != "0"){
        if (strpos($fieldName, ".") !== false){
            return " AND $fieldName = " . $_GET[$postKey];
        }else{
            return " AND `$fieldName` = " . $_GET[$postKey];
        }
    }
    return "";
}

function getValuedate($fieldName, $postKey, $oper){
    if (isset($_GET[$postKey]) && $_GET[$postKey] != "" && $_GET[$postKey] != "0"){
        return " AND date($fieldName) $oper= '" . $_GET[$postKey] . "' AND `$fieldName` > '1'";
    }
    return "";
}

function getValueStr($fieldName, $postKey){
    if (isset($_GET[$postKey]) && $_GET[$postKey] != "" && $_GET[$postKey] != "0"){
        return " AND `$fieldName` like '" . $_GET[$postKey] . "%'";
    }
    return "";
}

$query = "";
$query .= getValueInt('a.ID', 'case_N');
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
//die($sql . $query);
$result = mysqli_query($conn, $sql . $query);

$arr = array();
foreach ($result as $row) {
    $arr[] = $row;
}

//$outdata = [];
//$all_states = [];


$output = '<table bordered="3">';

date_default_timezone_set("Asia/Tbilisi");
$dges = date("Y-m-d", time());

function makeHrow($columns)
{
    $newRow = "<tr>";
    foreach ($columns as $item) {
        $newRow .= "<th>" . $item . "</th>";
    }
    return $newRow . "</tr>";
}

function makerow($columns)
{
    $newRow = "<tr>";
    foreach ($columns as $key => $val) {
        $newRow .= "<td>" . $val . "</td>";
    }
    return $newRow . "</tr>";
}

$tHead = [
    "ხელშეკრულების ნომერი",
    "მოპასუხის სახელი და გვარი ",
    "სესხის ტიპი",
    "განსჯადი უწყების ტიპი",
    "განსჯადი უწყება",
    "სტატუსი",
    "ეტაპი",
    "სასარჩელო მოთხოვნა",
    "დაკმაყოფილებული მოთხოვნა",
    "გადაწყვეტილების მიღების თარიღი",
    "აღსრულების დაწყების თარიღი",
    "საქმის მფლობელის სახელი და გვარი"
];

$output .= makeHrow($tHead);

foreach ($arr as $row) {
    $output .= makerow($row);
}

$output .= '</table>';
$fileName = "case_list_" . $dges;

//header("Content-Type: application/xls");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fileName.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $output;

mysqli_close($conn);