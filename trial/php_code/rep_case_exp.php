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
	a.ID,
    `AgrNumber`,
    concat(`DebFirstName`, ' ', `DebLastName`) AS DebFirstName,
    di.ValueText AS loanType,
    di_st.ValueText AS statusi,
    di_stage.ValueText AS stage,
    CONCAT(p.FirstName, ' ', p.LastName) AS OWNER,
    if (a.ExecProcessDate = '0000-00-00 00:00:00', '', a.ExecProcessDate) AS ExecProcessDate,
    ifnull(di_jt.ValueText, '') AS JudicialentityType,
    ifnull(di_jn.ValueText, '') AS Judicialentity,
    ifnull(di_cur1.ValueText, '') AS ClaimCur,
    ifnull(ai.Claimbase, '') AS Claimbase,
    ifnull(ai.ClaimPercent, '') AS ClaimPercent,
    ifnull(ai.ClaimCost, '') AS ClaimCost,
    if (ai.CourtDecDate = '0000-00-00 00:00:00', '', ifnull(ai.CourtDecDate, '')) AS CourtDecDate,
    ifnull(di_cur2.ValueText, '') AS CourtDecResCurID,
    ifnull(ai.CourtDecResBase, '') AS CourtDecResBase,
    ifnull(ai.CourtDecResPercent, '') AS CourtDecResPercent,
    ifnull(ai.CourtDecResCost, '') AS CourtDecResCost
FROM
    `pcm_aplication` a
LEFT JOIN pcm_aplication_instances ai ON
	a.ID = ai.caseID
LEFT JOIN DictionariyItems di ON
    a.`AgrLoanType` = di.ID
LEFT JOIN DictionariyItems di_st ON
    a.`StatusID` = di_st.ID
LEFT JOIN DictionariyItems di_stage ON
    a.`StageID` = di_stage.ID
LEFT JOIN PersonMapping pmap ON
    OwnerID = pmap.ID
LEFT JOIN Persons p ON
    pmap.PersonID = p.ID
LEFT JOIN DictionariyItems di_jt ON
    ai.JudicialentityTypeID = di_jt.ID
LEFT JOIN DictionariyItems di_jn ON
    ai.JudicialentityD = di_jn.ID
LEFT JOIN DictionariyItems di_cur1 ON
    ai.ClaimCurID = di_cur1.ID    
LEFT JOIN DictionariyItems di_cur2 ON
    ai.CourtDecResCurID = di_cur2.ID  
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
$query .= getValueInt('AgrLoanType', 'loan_type');
$query .= getValueInt('JudicialentityTypeID', 'judicial_type');


$query = trim($query, " AND");
if ($query == "")
    $query = "1";
//die($sql . $query);
$order = " ORDER BY a.ID, ai.JudicialentityTypeID";
$result = mysqli_query($conn, $sql . $query . $order);

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
    "ID",
    "ხელშეკრულების ნომერი",
    "მოპასუხის სახელი და გვარი ",
    "სესხის ტიპი",
    "სტატუსი",
    "ეტაპი",
    "საქმის მფლობელის სახელი და გვარი",
    "აღსრულების დაწყების თარიღი",
    "განსჯადი უწყების ტიპი",
    "განსჯადი უწყება",
    "სასარჩელო მოთხოვნა ვალუტა",
    "მოთხოვნა ძირი",
    "მოთხოვნა პროცენტი",
    "მოთხოვნა ხარჯი",
    "გადაწყვ. მიღების თარიღი",
    "გადაწყვ. შედეგი ვალუტა",
    "შედეგი ძირი",
    "შედეგი პროცენტი",
    "შედეგი ხარჯი"
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