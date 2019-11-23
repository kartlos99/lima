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

$recID = $_POST['recID'];
$pageN = $_POST['pageN'];
$order = " ORDER BY imc.ID DESC";

$records_per_page = 10;
$offset = ($pageN - 1) * $records_per_page;
$limit = " Limit $offset, $records_per_page";

$sql = "
SELECT imc.ID, imc.Comment, DATE_FORMAT(imc.CreateDate, '%Y-%m-%d %H:%i') AS dro, pmap.UserName FROM `im_comments` imc
LEFT JOIN personmapping pmap ON imc.CreateUser = pmap.ID
WHERE imc.`IM_RequestID` = $recID" . $order . $limit;

$sqlCount = "SELECT COUNT(imc.ID) as nn FROM `im_comments` imc
WHERE imc.`IM_RequestID` = $recID";


$resultArray['sql'] = $sql;

$result1 = mysqli_query($conn, $sql);
$result_N = mysqli_query($conn, $sqlCount);

$arr = [];
foreach ($result1 as $row) {
    $arr[] = $row;
}
$nn = [];
foreach ($result_N as $row) {
    $nn = $row;
}

$resultArray['data'] = $arr;
$resultArray['count'] = $nn['nn'];

echo(json_encode($resultArray));