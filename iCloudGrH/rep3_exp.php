<?php

include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}
if ($_SESSION['usertype'] != 'iCloudGrH'){
    die("NO_access");
}

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$kreteria = "";
$linesAtPage = 10;

if (isset($_GET['organization']) && $_GET['organization'] != ''){
    $o = $_GET['organization'];
    $kreteria .= " o.ID = $o ";
}
if (isset($_GET['username']) && $_GET['username'] != ''){
    if (strlen($kreteria) > 0){
        $kreteria .= " AND ";
    }
    $u = $_GET['username'];
    $kreteria .= " userID = $u ";
}
if (isset($_GET['datefrom']) && $_GET['datefrom'] != ''){
    if (strlen($kreteria) > 0){
        $kreteria .= " AND ";
    }
    $d1 = $_GET['datefrom'];
    $kreteria .= " tarigi >= '$d1' ";
}
if (isset($_GET['dateto']) && $_GET['dateto'] != ''){
    if (strlen($kreteria) > 0){
        $kreteria .= " AND ";
    }
    $d2 = $_GET['dateto'];
    $kreteria .= " tarigi <= '$d2' ";
}

if (strlen($kreteria) > 0){
    $kreteria = " WHERE " . $kreteria;
}

// $pageN = $_GET['pageN'];
// $start_row = $pageN * $linesAtPage;
// $Limit=" Limit $start_row, $linesAtPage";

$allFialds = "
SELECT 
    o.OrganizationName as org, 
    b.BranchName as br, 
    p.UserName as uname, 
    a.AplApplID as aid, 
    `whichpass` as wp, 
    `texti` as text,
    ifnull(agr.Number, '-') AS agrNumber,
    ifnull(agr_org.OrganizationName, '-') AS agrOrg,
    `tarigi` as dt
FROM 
    `Applidpasslog` lg ";
$countField = "SELECT count(lg.id) as n FROM `Applidpasslog` lg ";

$sql_body = " 
LEFT JOIN PersonMapping p ON lg.userID = p.ID
LEFT JOIN Organizations o on p.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b on p.OrganizationBranchID = b.ID
LEFT JOIN ApplID a ON lg.applid = a.ID
LEFT JOIN Agreements agr ON
	lg.curr_agrim_ID = agr.ID
LEFT JOIN Organizations agr_org ON
	agr.OrganizationID = agr_org.ID " . $kreteria . " Order by tarigi";

$sql = $allFialds . $sql_body ;//. $Limit;
// $sql_Count = $countField . $sql_body;

$result = mysqli_query($conn, $sql);
// $result1 = mysqli_query($conn, $sql_Count);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

// echo(json_encode($arr));

//------------------------------------------------------------------------------------------
//******************************************************************************************
//------------------------------------------------------------------------------------------

$output = '<table bordered="3">';

date_default_timezone_set("Asia/Tbilisi");
$dges = date("Y-m-d", time());

function makeHrow($columns){
    $newRow = "<tr>";
    foreach($columns as $item){
        $newRow .= "<th>" . $item . "</th>";
    }
    return $newRow . "</tr>";    
}
// 1	1
function makerow($columns){
    $newRow = "<tr>";
    foreach($columns as $key => $val){
        $newRow .= "<td>" . $val . "</td>";
    }
    return $newRow . "</tr>";
}

$tHead = [
    "ორგანიზაცია",
    "ფილიალი",
    "მომხ.სახელი",
    "Apple-ის ანგარიში",
    "რომელი პაროლი",
    "დათვალიერების მიზეზი",
    "ხელშეკრულების#",
    "ხელშეკრულება-ორგ.",
    "დათვალიერების დრო"];

if (count($arr) > 0) {
    $output .= makeHrow($tHead);
    foreach($arr as $row){        
        $output .= makerow($row);
    }
}

$output .= '</table>';
$fileName = "PassShowLog_" . $dges;

//header("Content-Type: application/xls");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fileName.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $output;

mysqli_close($conn);
?>