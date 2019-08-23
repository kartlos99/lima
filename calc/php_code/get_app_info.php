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

$appID =  $_GET['appID'];

$sql = "
SELECT app.*, tm.ParentID AS brand, tbr.ParentID AS techtype FROM `tech_estimate_applications` app
LEFT JOIN techniques_tree tm ON app.`TechTreeID` = tm.ID
LEFT JOIN techniques_tree tbr ON tm.ParentID = tbr.ID
WHERE app.ID = $appID";

$resultArray['sql'] = $sql;

$result = mysqli_query($conn,  $sql);

$arr = [];
foreach($result as $row){
    $arr[] = $row;
}

$resultArray['app_data'] = $arr[0];

echo(json_encode($resultArray));