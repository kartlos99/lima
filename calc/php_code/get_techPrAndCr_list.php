<?php

session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}
$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
$resultArray = [];
$limit = " limit 20";

$query = "";
$query .= isset($_POST['type']) && $_POST['type'] != "" && $_POST['type'] != "0" ? " AND ttp.ID = " . $_POST['type'] : "";
$query .= isset($_POST['brand']) && $_POST['brand'] != "" && $_POST['brand'] != "0" ? " AND tbr.ID = " . $_POST['brand'] : "";
$query .= isset($_POST['model']) && $_POST['model'] != "" && $_POST['model'] != "0" ? " AND tm.ID = " . $_POST['model'] : "";
$query .= isset($_POST['price_criteria_status']) && $_POST['price_criteria_status'] != "" && $_POST['price_criteria_status'] != "0" ? " AND tp.StatusID = " . $_POST['price_criteria_status'] : "";

$query .= isset($_POST['price_status']) && $_POST['price_status'] != "" && $_POST['price_status'] != "0" ? " AND tp.MaxPriceStatusID = " . $_POST['price_status'] : "";
$query .= isset($_POST['price_date_from']) && $_POST['price_date_from'] != "" ? " AND tp.RevDate >= '" . $_POST['price_date_from'] . "'" : "";
$query .= isset($_POST['price_date_till']) && $_POST['price_date_till'] != "" ? " AND tp.RevDate <= '" . $_POST['price_date_till'] . "'" : "";

$query .= isset($_POST['criteria_group']) && $_POST['criteria_group'] != "" && $_POST['criteria_group'] != "0" ? " AND ecm.ParentID = " . $_POST['criteria_group'] : "";
$query .= isset($_POST['criteria']) && $_POST['criteria'] != "" && $_POST['criteria'] != "0" ? " AND ecm.CriteriumID = " . $_POST['criteria'] : "";
$query .= isset($_POST['criteria_status']) && $_POST['criteria_status'] != "" && $_POST['criteria_status'] != "0" ? " AND ecm.CriteriumStatusID = " . $_POST['criteria_status'] : "";
$query .= isset($_POST['krit_date_from']) && $_POST['krit_date_from'] != "" ? " AND ecv.RevDate >= '" . $_POST['krit_date_from'] . "'" : "";
$query .= isset($_POST['krit_date_till']) && $_POST['krit_date_till'] != "" ? " AND ecv.RevDate <= '" . $_POST['krit_date_till'] . "'" : "";



$sql_count = "SELECT count(tp.ID) AS n ";
$sql_fields = "SELECT tp.ID, tm.Name AS model, tbr.Name AS brand, ttp.Name AS 'techtype', s.Value AS 'tpacw_st', spr.Value AS 'pr_st', Date(tp.RevDate) AS RevDate, ecm.CriteriumID, ecv.ImpactValue, ec.Name AS 'crit', ec2.Name AS 'crgr', scrit.Value AS crit_st, Date(ecv.RevDate) AS crit_revDate ";

$sql = "
FROM techniques_tree tm 
LEFT JOIN techniques_tree tbr ON tm.ParentID = tbr.ID
LEFT JOIN techniques_tree ttp ON tbr.ParentID = ttp.ID
LEFT JOIN estimate_criteriums_mapping ecm ON ecm.TechTreeID = tm.ID
LEFT JOIN estimate_criterium_values ecv ON ecv.EstimateCriteriumID = ecm.ID
LEFT JOIN estimate_criteriums ec ON ecm.CriteriumID = ec.ID
LEFT JOIN estimate_criteriums ec2 ON ecm.ParentID = ec2.ID
LEFT JOIN tech_price tp ON tm.ID = tp.TechTreeID
LEFT JOIN States s ON s.ID = tp.`StatusID`
LEFT JOIN States spr ON spr.ID = tp.`MaxPriceStatusID`
LEFT JOIN States scrit ON scrit.ID = ecm.CriteriumStatusID
WHERE
ttp.Name <> 'null' AND ec2.Name <> 'null' AND tp.ID <> 'null' ";

$orderby = " ORDER BY tp.ID, ec2.Name, ec.Name ";

$resultArray['sql'] = $sql_fields . $sql . $query . $orderby . $limit;

$result = mysqli_query($conn,  $sql_fields . $sql . $query . $orderby . $limit);
$result_N = mysqli_query($conn, $sql_count . $sql . $query);

$arr = [];
$nn = [];
foreach($result as $row){
    $arr[] = $row;
}
foreach($result_N as $row){
    $nn[] = $row;
}
$resultArray['data'] = $arr;
$resultArray['count'] = $nn;

echo(json_encode($resultArray));