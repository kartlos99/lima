<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/8/19
 * Time: 8:31 PM
 */

session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}

if (isset($_GET['parentID']) && $_GET['parentID'] != '') {
    $id = $_GET['parentID'];

    $sql = "SELECT id, `Name`, `StatusID`, `Note` FROM `techniques_tree` WHERE `ParentID` = $id";

    $result = mysqli_query($conn, $sql);

    $arr = array();
    foreach ($result as $row) {
        $arr[] = $row;
    }

    echo(json_encode($arr));
}