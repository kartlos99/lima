<?php
include_once '../config.php';
session_start();

if (!($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'iCloudGrH')){
    die('rejected');
}

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$kreteria = "";
$linesAtPage = 10;

if (isset($_POST['organization']) && $_POST['organization'] != ''){
    $o = $_POST['organization'];
    $kreteria .= " o.ID = $o ";
}
if (isset($_POST['username']) && $_POST['username'] != ''){
    if (strlen($kreteria) > 0){
        $kreteria .= " AND ";
    }
    $u = $_POST['username'];
    $kreteria .= " userID = $u ";
}
if (isset($_POST['datefrom']) && $_POST['datefrom'] != ''){
    if (strlen($kreteria) > 0){
        $kreteria .= " AND ";
    }
    $d1 = $_POST['datefrom'];
    $kreteria .= " tarigi >= '$d1' ";
}
if (isset($_POST['dateto']) && $_POST['dateto'] != ''){
    if (strlen($kreteria) > 0){
        $kreteria .= " AND ";
    }
    $d2 = $_POST['dateto'];
    $kreteria .= " tarigi <= '$d2' ";
}

if (strlen($kreteria) > 0){
    $kreteria = " WHERE " . $kreteria;
}

$pageN = $_POST['pageN'];
$start_row = $pageN * $linesAtPage;
$Limit=" Limit $start_row, $linesAtPage";

$allFialds = "
SELECT 
    `userID` as uid,
    o.ID as oID,
    o.OrganizationName as org, 
    b.BranchName as br, 
    p.UserName as uname, 
    a.AplApplID as aid, 
    `whichpass` as wp, 
    `tarigi` as dt, 
    `texti` as text,
    ifnull(agr.Number, '-') AS agrNumber,
    ifnull(agr_org.OrganizationName, '-') AS agrOrg,
    ifnull(agr.ID, '-') AS agrID
FROM 
    `Applidpasslog` log ";
$countField = "SELECT count(log.id) as n FROM `Applidpasslog` log ";

$sql_body = " 
LEFT JOIN PersonMapping p ON log.userID = p.ID
LEFT JOIN Organizations o on p.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b on p.OrganizationBranchID = b.ID
LEFT JOIN ApplID a ON log.applid = a.ID
LEFT JOIN Agreements agr ON
	LOG.`curr_agrim_ID` = agr.ID
LEFT JOIN Organizations agr_org ON
	agr.OrganizationID = agr_org.ID " . $kreteria . " Order by tarigi";

$sql = $allFialds . $sql_body . $Limit;
$sql_Count = $countField . $sql_body;

$result = mysqli_query($conn, $sql);
$result1 = mysqli_query($conn, $sql_Count);

$arr = array();
foreach($result1 as $row){
    $arr[] = $row;
}
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));
// echo $sql;
$conn -> close();

?>