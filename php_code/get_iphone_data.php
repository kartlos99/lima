<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

$imei = $_GET['imei'];

    $sql = "
SELECT * FROM `Iphone` WHERE `PhIMEINumber` = '$imei'
    ";

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();
?>