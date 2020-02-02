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

$resultArray['get'] = $_GET;
//die(json_encode($resultArray));
$techID = $_GET['techID'];


$sql = "
SELECT GROUP_CONCAT(ecmap.`ID`) AS crIDs, ecmap.`TechTreeID`, ecmap.`chainID`, chmap.chainTypeID, GROUP_CONCAT(ec.Name) AS crNames 
FROM `estimate_criteriums_mapping` ecmap
LEFT JOIN chain_map chmap ON chmap.ID = ecmap.chainID
LEFT JOIN estimate_criteriums ec ON ec.ID = ecmap.`CriteriumID`
WHERE ifnull(`chainID`, 0) <> 0 AND `TechTreeID` = $techID
GROUP BY ecmap.`chainID`, chmap.chainTypeID
ORDER BY ecmap.`chainID`, chmap.chainTypeID";

$result = mysqli_query($conn, $sql);
$chainsArr = [];
foreach ($result as $row) {
    $chainsArr[] = $row;
}

$resultArray['chains'] = $chainsArr;
$resultArray['sql'] = $sql;

echo(json_encode($resultArray));