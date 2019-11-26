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
if (!isset($_SESSION['permissionM3']['view_report'])) {
    $resultArray[RESULT] = ERROR;
    $resultArray[ERROR] = "no access to reports!";
    die(json_encode($resultArray));
}
date_default_timezone_set("Asia/Tbilisi");
$dges = date("Y-m-d", time());

$order = " ORDER BY im.ID";
$mode = $_GET['rep_mode'];
$isExport = $_GET['rep_exp_mode'];

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

function getValueCustom($fieldName, $postKey)
{
    if (isset($_GET[$postKey]) && $_GET[$postKey] != "" && $_GET[$postKey] != "0") {
        return " AND $fieldName IN (
        SELECT gp.IM_RequestID from im_guilty_persons gp
        LEFT JOIN DictionariyItems di ON di.ID = gp.StatusID
        WHERE di.Code = 'active' AND gp.IM_PersonsID = " . $_GET[$postKey] . ")";
    }
    return "";
}

$query = "";

$query .= getValueInt('OrgID', 'organization');
$query .= getValueInt('OrgBranchID', 'filial');
$query .= getValueCustom('im.ID', 'guilty_person_id');
$query .= getValueInt('cat.ID', 'CategoryID');
$query .= getValueInt('scat.ID', 'SubCategoryID');

$query .= getValuedate('FactDate', 'fix_date_from', ">");
$query .= getValuedate('FactDate', 'fix_date_to', "<");

$query = trim($query, " AND");
if ($query == "")
    $query = "1";

$sql = '';
if ($mode == 'day') {
    $sql = "SELECT cat.name AS catName, scat.name AS scatName, COUNT(im.ID) AS nn, Date(`FactDate`) AS fdate FROM `im_request` im
LEFT JOIN im_category cat ON cat.ID = im.`CategoryID`
LEFT JOIN im_subcategory scat ON scat.ID = im.`SubCategoryID`
WHERE $query
GROUP BY im.CategoryID, im.SubCategoryID, Date(im.`FactDate`) 
ORDER BY cat.sortID, scat.sortID
";
} else {
    $sql = "SELECT cat.name AS catName, scat.name AS scatName, COUNT(im.ID) AS nn, concat(year(FactDate), '-', month(`FactDate`)) AS fdate FROM `im_request` im
LEFT JOIN im_category cat ON cat.ID = im.`CategoryID`
LEFT JOIN im_subcategory scat ON scat.ID = im.`SubCategoryID`
WHERE $query
GROUP BY im.CategoryID, im.SubCategoryID, month(im.`FactDate`)
ORDER BY cat.sortID, scat.sortID";
}


$resultArray['sql'] = $sql;

$result = mysqli_query($conn, $sql);
//$result_N = mysqli_query($conn, $sql_count . $sql . $query);

//$arr = [];
$arrdateRow = [];
$arrDone = [];
foreach ($result as $row) {
//    $arr[] = $row;
    $arrdateRow[$row['fdate']] = 0;
}

ksort($arrdateRow);

foreach ($result as $row) {
    $arrDone[$row['scatName']] = ['cat' => $row['catName'], 'subcat' => $row['scatName'], 'dt' => $arrdateRow];
}

foreach ($result as $row) {
    $arrDone[$row['scatName']]['dt'][$row['fdate']] += $row['nn'];
}

$expData = [];
foreach ($arrDone as $kay => $item) {
    $t = [];
    $t['category'] = $item['cat'];
    $t['sub_category'] = $kay;
    foreach ($item['dt'] as $k => $sitem) {
        $t[$k] = $sitem;
    }
    $expData[] = $t;
}

$resultArray['data'] = $arrDone;
$resultArray['asTable'] = $expData;
//$resultArray['count'] = $nn;

if ($isExport == 'exp') {
    $output = '<table bordered="3">';
    if (count($expData) > 0) {
        $output .= makeHrow(array_keys($expData[0]));
        foreach ($expData as $row) {
            $output .= makerow($row);
        }
    }
    $output .= '</table>';

    header("Content-Type: application/octet-stream");
    header("Content-Transfer-Encoding: binary");
    header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Content-Disposition: attachment; filename = "Export_' . $mode[0] . '_' . date("Y-m-d") . '.xls"');
    header('Pragma: no-cache');

//these characters will make correct encoding to excel
    echo chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE//IGNORE", $output);
} else {
    echo(json_encode($resultArray));
}

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

// SELECT dateDIFF('2019-10-13', CURRENT_DATE()) AS diff1, unix_timestamp(CURRENT_DATE()), 60*60*24*30 AS dge;