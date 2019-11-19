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

$order = " ORDER BY im.ID";
$pageN = $_POST['pageN'];

$records_per_page = 20;
$offset = ($pageN - 1) * $records_per_page;
$limit = " Limit $offset, $records_per_page";

function getValueInt($fieldName, $postKey)
{
    if (isset($_POST[$postKey]) && $_POST[$postKey] != "" && $_POST[$postKey] != "0") {
        if (strpos($fieldName, ".") !== false) {
            return " AND $fieldName = " . $_POST[$postKey];
        } else {
            return " AND `$fieldName` = " . $_POST[$postKey];
        }
    }
    return "";
}

function getValuedate($fieldName, $postKey, $oper)
{
    if (isset($_POST[$postKey]) && $_POST[$postKey] != "" && $_POST[$postKey] != "0") {
        return " AND date($fieldName) $oper= '" . $_POST[$postKey] . "' AND `$fieldName` > '1'";
    }
    return "";
}

function getValueStr($fieldName, $postKey)
{
    if (isset($_POST[$postKey]) && $_POST[$postKey] != "" && $_POST[$postKey] != "0") {
        return " AND `$fieldName` like '" . $_POST[$postKey] . "%'";
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


$sql_count = "SELECT count(im.ID) as n ";

$sql_fields = "
SELECT
    im.ID,
    ifnull(cat.name, '') AS category,
    ifnull(scat.name, '') AS subcaegory,
    ifnull(o.OrganizationName, '') AS org,
    `AgrNumber`,
    ifnull(di_st.ValueText, '') AS st,
    ifnull(pmap.UserName, '') AS username,
    DATE(`FactDate`) AS FactDate
";

$sql = " FROM
    `im_request` im
LEFT JOIN im_category cat ON
    cat.ID = im.`CategoryID`
LEFT JOIN im_subcategory scat ON
    scat.ID = im.`SubCategoryID`
LEFT JOIN organizations o ON
    o.ID = im.`OrgID`
LEFT JOIN dictionariyitems di_st ON
    di_st.ID = im.`StatusID`
LEFT JOIN personmapping pmap ON
    pmap.ID = im.`OwnerID` 
WHERE ";

$fullSQL = $sql_fields . $sql . "1" . $order . $limit;

$resultArray['sql'] = $fullSQL;

$result = mysqli_query($conn, $fullSQL);
$result_N = mysqli_query($conn, $sql_count . $sql . "1");

$arr = [];
$nn = [];
foreach ($result as $row) {
    $arr[] = $row;
}
foreach ($result_N as $row) {
    $nn[] = $row;
}
$resultArray['data'] = $arr;
$resultArray['count'] = $nn;

echo(json_encode($resultArray));

// SELECT dateDIFF('2019-10-13', CURRENT_DATE()) AS diff1, unix_timestamp(CURRENT_DATE()), 60*60*24*30 AS dge;