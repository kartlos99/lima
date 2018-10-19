<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];

    $sql = "SELECT id, BranchName FROM OrganizationBranches WHERE OrganizationID = $id";

    $result = mysqli_query($conn, $sql);
    
    $arr = array();
    foreach ($result as $row) {
        $arr[] = $row;
    }

    echo(json_encode($arr));
}

$conn->close();