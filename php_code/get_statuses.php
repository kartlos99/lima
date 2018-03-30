<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

// id = im obieqts romls statusebic gvainteresebs
$id = $_GET['id'];

    $sql = "SELECT id, code, value FROM `states` WHERE IsActive = 1 AND ObjectID = $id";

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();