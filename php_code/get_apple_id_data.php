<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

$id = $_GET['id'];

    $sql = "
SELECT a.*, e.EmEmailPass FROM `ApplID` a JOIN Emails e
ON a.`AplAccountEmailID` = e.ID
WHERE a.ID = $id
    ";

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();
?>