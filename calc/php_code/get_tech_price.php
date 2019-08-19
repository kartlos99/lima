<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/16/19
 * Time: 1:48 PM
 */

session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}

if (isset($_GET['techID']) && $_GET['techID'] != '') {
    $techID = $_GET['techID'];

    $sql = "
SELECT t.*, s.Code AS pcwStatus FROM `tech_price` t
LEFT JOIN states s
ON t.StatusID = s.ID
WHERE t.TechTreeID = $techID";

    $result = mysqli_query($conn, $sql);

    $arr = array();
    foreach ($result as $row) {
        $arr[] = $row;
    }

    echo(json_encode($arr));
}