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
//$pageN = $_GET['pageN'];

//$records_per_page = 20;
//$offset = ($pageN - 1) * $records_per_page;
//$limit = " Limit $offset, $records_per_page";

$max = "";
$grouping = "";
$dublicatesFilter = "";


function getValueInt($fieldName, $postKey)
{
    if (isset($_GET[$postKey]) && $_GET[$postKey] != "" && $_GET[$postKey] != "0") {
        if (strpos($fieldName, ".") !== false) {
            return " AND $fieldName = " . $_GET[$postKey];
        } else {
            return " AND `$fieldName` = " . $_GET[$postKey];
        }
    }
    return "";
}

function getValuedate($fieldName, $postKey, $oper)
{
    if (isset($_GET[$postKey]) && $_GET[$postKey] != "" && $_GET[$postKey] != "0") {
        return " AND date($fieldName) $oper= '" . $_GET[$postKey] . "' AND $fieldName > '1'";
    }
    return "";
}

function getValueStr($fieldName, $postKey)
{
    if (isset($_GET[$postKey]) && $_GET[$postKey] != "" && $_GET[$postKey] != "0") {
        return " AND `$fieldName` like '" . $_GET[$postKey] . "%'";
    }
    return "";
}


$query = isset($_GET['guiltyUserID']) ? "gp.StatusID = (
        SELECT di.ID FROM `DictionariyItems` di
		LEFT JOIN Dictionaries d on d.ID = di.DictionaryID
		WHERE d.Code = 'im_guilty_person_map_status' AND di.`Code` = 'active'
    )" : "";

if ($_SESSION['M3UT'] == 'im_owner') {
    $query .= " AND OrgID = " . $_SESSION['OrganizationID'];
    $query .= " AND OrgBranchID = " . $_SESSION['filiali'];
}
if ($_SESSION['M3UT'] == 'performer') {
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

$query .= getValuedate('im.CreateDate', 'create_date_from', ">");
$query .= getValuedate('im.CreateDate', 'create_date_to', "<");
$query .= getValuedate('FactDate', 'fix_date_from', ">");
$query .= getValuedate('FactDate', 'fix_date_to', "<");
$query .= getValuedate('DiscoverDate', 'discover_date_from', ">");
$query .= getValuedate('DiscoverDate', 'discover_date_to', "<");
$query .= getValuedate('SolveDate', 'SolveDate_from', ">");
$query .= getValuedate('SolveDate', 'SolveDate_to', "<");

if (isset($_GET['NotInStatistics'])) {
    $query .= " AND `NotInStatistics` = 0 ";
}

$query = trim($query, " AND");
if ($query == "")
    $query = "1";

if (isset($_GET['duplicates'])) {
    $dublicatesFilter = " 
     AND im.id not in (
        SELECT id FROM `im_request`
        WHERE $query
		GROUP BY `AgrNumber`, `CategoryID`, `SubCategoryID`
		HAVING COUNT(id) = 1
        )";
    $order = " ORDER BY  `AgrNumber`, category, subcaegory, im.ID";
}

$sql_count = "SELECT count(DISTINCT im.ID) as n ";

$sql_fields = "
SELECT 
    im.ID,
    ifnull(cat.name, '') AS category,
    ifnull(scat.name, '') AS subcaegory,
    ifnull(o.OrganizationName, '') AS org,
    ifnull(br.BranchName, '') AS fil,
    `AgrNumber`,
    ifnull(di_st.ValueText, '') AS st,
    ifnull(pmap.UserName, '') AS owner_username,
    
    concat(LPAD(im.ID, 5, '0'), ' ', Date(im.`CreateDate`)) AS case_N,
    ifnull(di_type.ValueText, '') AS `Type`,
    ifnull(di_priority.ValueText, '') AS `Priority`,
    `FactDate`,
    concat(per_d.LastName, ' ', per_d.FirstName) AS `Discoverer`,
    `DiscoverDate`,
    `CategoryOther`,
    `SubCategoryOther`,
    `RequetsDescription`,
    ifnull(pmap_s.UserName, '') AS `Solver`,
    `DurationDeys`,
    `DurationHours`,
    IF (Date(im.`SolveDate`) = '0000-00-00', '', im.`SolveDate`) AS `SolveDate`,
    `SolvDescription`,
    IF (`NotInStatistics` = 1, 'კი', 'არა') AS statistic,
    Date(im.`CreateDate`) AS CreateDate,
    cr_us.UserName AS `CreateUser`,
    IF (Date(im.`UpdateDate`) = '0000-00-00', '', im.`UpdateDate`) AS `UpdateDate`,
    ifnull(md_us.UserName, '') AS `UpdateUser`,
    gps.gpNames
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
    LEFT JOIN OrganizationBranches br ON
    	br.ID = im.`OrgBranchID`
	LEFT JOIN DictionariyItems di_priority ON
        di_priority.ID = im.`PriorityID`
    LEFT JOIN DictionariyItems di_type ON
        di_type.ID = im.`TypeID`
    LEFT JOIN im_persons per_d ON
    	per_d.ID = im.`DiscovererID`
	LEFT JOIN PersonMapping pmap_s ON
        pmap_s.ID = im.`SolverID`
    LEFT JOIN PersonMapping cr_us ON
        cr_us.ID = im.`CreateUser`
	LEFT JOIN PersonMapping md_us ON
        md_us.ID = im.`UpdateUser`                
    LEFT JOIN (SELECT gp.`IM_RequestID`, GROUP_CONCAT(' ',concat(im_p.LastName, ' ', im_p.FirstName)) AS gpNames FROM `im_guilty_persons` gp
LEFT JOIN im_persons im_p ON gp.`IM_PersonsID` = im_p.ID
LEFT JOIN DictionariyItems di ON gp.`StatusID` = di.ID
WHERE di.Code = 'active'
GROUP BY gp.`IM_RequestID`) gps ON
	gps.IM_RequestID = im.ID
        
    WHERE im.ID in (
        SELECT (im.ID) FROM
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
    WHERE $query
   $dublicatesFilter
)  
 ";

$fullSQL = $sql_fields . $sql . $order ;

$resultArray['sql'] = $fullSQL;

$result = mysqli_query($conn, $fullSQL);

// eqsportireba

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
    "კატეგორია",
    "ქვეკატეგორია",
    "ორგანიზაცია",
    "ფილიალი",
    "ხელშეკრულების_N",
    "სტატუსი",
    "მფლობელი",
    "case_N",
    "ტიპი",
    "პრიორიტეტი",
    "დაფიქსირების დრო",
    "აღმომჩენი",
    "აღმოჩენის დრო",
    "სხვა კატეგორია",
    "სხვა ქვეკატეგორია",
    "აღწერა",
    "შემსრულებელი",
    "ხანგრძლივობა დღე",
    "ხანგრძლივობა საათი",
    "შესრულების დრო",
    "შესრულების აღწერა",
    "სტატისტიკაში",
    "შექმნის დრო",
    "შემქმნელი მომხმარებელი",
    "რედაქტირების დრო",
    "რადაქტორი",
    "დამრღვევი პირები"
];

$output .= makeHrow($tHead);

foreach ($result as $row) {
    $output .= makerow($row);
}
//foreach ($arr as $row) {
//    $output .= makerow($row);
//}

$output .= '</table>';
$fileName = "accident_list_" . $dges;

//header("Content-Type: application/xls");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fileName.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $output;

mysqli_close($conn);
