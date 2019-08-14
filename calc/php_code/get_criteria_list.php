<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/9/19
 * Time: 3:22 PM
 */

session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}

if (isset($_GET['parentID']) && $_GET['parentID'] != '') {
    $parentID = $_GET['parentID'];
    $techID = $_GET['techID'];

    $sql = "
SELECT em.`TechTreeID`, em.`CriteriumID`, e.Name, em.`Note`, em.`id`, em.CriteriumStatusID FROM `estimate_criteriums_mapping` em
LEFT JOIN estimate_criteriums e
	ON em.`CriteriumID` = e.ID
WHERE e.`ParentID` = $parentID AND em.`TechTreeID` = $techID";

    $result = mysqli_query($conn, $sql);

    $arr = array();
    foreach ($result as $row) {
        $arr[] = $row;
    }

    echo(json_encode($arr));
}
