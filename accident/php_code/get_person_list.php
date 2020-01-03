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

$order = " ORDER BY p.ID";
$pageN = $_POST['pageN'];

$records_per_page = 20;
$offset = ($pageN - 1) * $records_per_page;
$limit = " Limit $offset, $records_per_page";

$max = "";

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

$query .= getValueStr('firstName', 'firstName');
$query .= getValueStr('lastName', 'lastName');
$query .= getValueInt('orgID', 'organization');
$query .= getValueInt('orgBranchID', 'filial');
$query .= getValueInt('p.typeID', 'personType');
$query .= getValueInt('p.statusID', 'status');

if (isset($_POST['NotInStatistics'])){
    $query .= " AND `NotInStatistics` = 0 ";
}

$query = trim($query, " AND");
if ($query == "")
    $query = "1";


$sql_count = "SELECT count(DISTINCT p.ID) as n ";

$sql_fields = "
SELECT p.*, di_st.ValueText AS statusi, di_tp.ValueText AS tipi, o.OrganizationName, b.BranchName 
";

$sql = " FROM `im_persons` p 
LEFT JOIN DictionarIyitems di_st ON p.StatusID = di_st.ID
LEFT JOIN DictionarIyitems di_tp ON p.TypeID = di_tp.ID
LEFT JOIN Organizations o ON `OrgID` = o.ID
LEFT JOIN OrganizationBranches b ON `OrgBranchID` = b.ID
    WHERE $query
 ";

$fullSQL = $sql_fields . $sql . $order . $limit;

$resultArray['sql'] = $fullSQL;
//die(json_encode($resultArray));
$result = mysqli_query($conn, $fullSQL);
$result_N = mysqli_query($conn, $sql_count . $sql);

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

//SELECT  im.ID, ifnull(cat.name, '') AS category, ifnull(scat.name, '') AS subcaegory, ifnull(o.OrganizationName, '') AS org, `AgrNumber`, ifnull(di_st.ValueText, '') AS st, ifnull(pmap.UserName, '') AS username, DATE(`FactDate`) AS FactDate FROM `im_request` imLEFT JOIN im_category cat ON cat.ID = im.`CategoryID`LEFT JOIN im_subcategory scat ON scat.ID = im.`SubCategoryID`LEFT JOIN Organizations o ON o.ID = im.`OrgID`LEFT JOIN DictionariyItems di_st ON di_st.ID = im.`StatusID`LEFT JOIN PersonMapping pmap ON pmap.ID = im.`OwnerID` WHERE im.ID in (\tSELECT max(im.ID) FROM `im_request` imLEFT JOIN im_category cat ON cat.ID = im.`CategoryID`LEFT JOIN im_subcategory scat ON scat.ID = im.`SubCategoryID`LEFT JOIN Organizations o ON o.ID = im.`OrgID`LEFT JOIN DictionariyItems di_st ON di_st.ID = im.`StatusID`LEFT JOIN PersonMapping pmap ON pmap.ID = im.`OwnerID` LEFT JOIN im_guilty_persons gp ON gp.IM_RequestID = im.ID WHERE 1 GROUP by im.categoryID, im.subcategoryID, im.AgrNumber) WHERE ORDER BY im.ID Limit 20