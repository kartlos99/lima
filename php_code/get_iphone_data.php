<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

if (isset($_GET['imei'])){
    $imei = $_GET['imei'];

    $sql = "
SELECT * FROM `Iphone` WHERE `PhIMEINumber` = '$imei'
    ";
} else {
    if (isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "
        SELECT * FROM `Iphone` WHERE `ID` = $id
        ";
    } else {
        $sql = "
        SELECT 0
        ";
    }
}


$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();
?>