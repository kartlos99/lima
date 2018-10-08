<?php

include_once '../config.php';
session_start();

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());
$emEmail = 'ttt';

$sql_chek = "SELECT checkmail('".$emEmail."',4) AS num ";
$result1 = mysqli_query($conn, $sql_chek);
$arr = mysqli_fetch_assoc($result1);
$count = $arr['num'];


echo($count);

print_r ($_SESSION);

?>