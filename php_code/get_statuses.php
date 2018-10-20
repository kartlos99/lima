<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}

// id = im obieqts romls statusebic gvainteresebs
$objname = $_GET['objname'];

    $sql = "SELECT id, `code`, `value` as va FROM `States` WHERE ObjectID = getobjid('$objname') order by SortID";

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();