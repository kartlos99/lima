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
        return " AND date($fieldName) $oper= '" . $_POST[$postKey] . "' AND $fieldName > '1'";
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


$query = isset($_POST['guiltyUserID']) ? "gp.StatusID = (
        SELECT di.ID FROM `DictionariyItems` di
		LEFT JOIN Dictionaries d on d.ID = di.DictionaryID
		WHERE d.Code = 'im_guilty_person_map_status' AND di.`Code` = 'active'
    )" : "";

if ($_SESSION['M3UT'] == 'im_owner'){
    $query .= " AND OrgID = " . $_SESSION['OrganizationID'];
}
if ($_SESSION['M3UT'] == 'performer'){
    $query .= " AND SolverID = " . $currUserID;
}

$query .= getValueInt('im.ID', 'accident_N');
$query .= getValueInt('im.TypeID', 'TypeID');
$query .= getValueInt('PriorityID', 'PriorityID');
$query .= getValueInt('im.StatusID', 'StatusID');
$query .= getValueInt('OwnerID', 'OwnerID');
$query .= getValueInt('OrgID', 'organization');
$query .= getValueInt('OrgBranchID', 'filial');

$query .= getValueStr('AgrNumber', 'AgrNumber');

$query .= getValueInt('gp.IM_PersonsID', 'guiltyUserID');
$query .= getValueInt('im.CategoryID', 'CategoryID');
$query .= getValueInt('im.SubCategoryID', 'SubCategoryID');
$query .= getValueInt('DiscovererID', 'DiscovererID');
$query .= getValueInt('SolverID', 'SolverID');
$query .= getValueInt('NotInStatistics', 'NotInStatistics');

$query .= getValuedate('im.CreateDate', 'create_date_from', ">");
$query .= getValuedate('im.CreateDate', 'create_date_to', "<");
$query .= getValuedate('FactDate', 'fix_date_from', ">");
$query .= getValuedate('FactDate', 'fix_date_to', "<");
$query .= getValuedate('DiscoverDate', 'discover_date_from', ">");
$query .= getValuedate('DiscoverDate', 'discover_date_to', "<");
$query .= getValuedate('SolveDate', 'SolveDate_from', ">");
$query .= getValuedate('SolveDate', 'SolveDate_to', "<");


$query = trim($query, " AND");
if ($query == "")
    $query = "1";


$sql_count = "SELECT count(DISTINCT im.ID) as n ";

$sql_fields = "
SELECT DISTINCT
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
LEFT JOIN Organizations o ON
    o.ID = im.`OrgID`
LEFT JOIN DictionariyItems di_st ON
    di_st.ID = im.`StatusID`
LEFT JOIN PersonMapping pmap ON
    pmap.ID = im.`OwnerID` 
LEFT JOIN im_guilty_persons gp ON
    gp.IM_RequestID = im.ID    
WHERE ";

$fullSQL = $sql_fields . $sql . $query . $order . $limit;

$resultArray['sql'] = $fullSQL;

$result = mysqli_query($conn, $fullSQL);
$result_N = mysqli_query($conn, $sql_count . $sql . $query);

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