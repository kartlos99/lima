<?php
include_once '../config.php';
session_start();

if (!($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'iCloudGrH')){
    die('rejected');
}

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$sql = " 
SELECT `userID`, o.OrganizationName, b.BranchName, p.UserName, a.AplApplID, `whichpass`, `tarigi`, `texti` FROM `applidpasslog` log
LEFT JOIN PersonMapping p ON log.userID = p.ID
LEFT JOIN Organizations o on p.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b on p.OrganizationBranchID = b.ID
LEFT JOIN Applid a ON log.applid = a.ID
WHERE 1";

$result = mysqli_query($conn, $sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();

?>