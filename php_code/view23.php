<?php
include_once '../config.php';
session_start();

if (!($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'iCloudGrH')){
    die('rejected');
}

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$kreteria = "";

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

$sql = " 
SELECT `userID`, o.ID as orgID, o.OrganizationName, b.BranchName, p.UserName, a.AplApplID, `whichpass`, `tarigi`, `texti` FROM `Applidpasslog` log
LEFT JOIN PersonMapping p ON log.userID = p.ID
LEFT JOIN Organizations o on p.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b on p.OrganizationBranchID = b.ID
LEFT JOIN ApplID a ON log.applid = a.ID " . $kreteria . " Order by tarigi";

$result = mysqli_query($conn, $sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));
// echo $sql;
$conn -> close();

?>