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

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];

    $sql = "
    SELECT e.id, e.EmEmail FROM `Emails` e JOIN Types t
    ON e.TypeID = t.ID
    WHERE OrganizationID = $id AND t.code = 'Rescue Email'";

    $result = mysqli_query($conn, $sql);

    $arr = array();
    foreach($result as $row){
        $arr[] = $row;
    }

    echo(json_encode($arr));
}

$conn -> close();