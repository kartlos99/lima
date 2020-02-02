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

$resultArray['post'] = $_POST;
//die(json_encode($resultArray));

$chainID = $_POST['chainID'];
$chainType = $_POST['chainType'];
$criterias = isset($_POST['criterias']) ? $_POST['criterias'] : [];
$changeType = $_POST['changeType'];

if ($chainID == 0) {
    $insNewChainSql = "INSERT INTO `chain_map`(`chainTypeID`) VALUES ($chainType)";
    $result = mysqli_query($conn, $insNewChainSql);
    if ($result) {
        $chainID = mysqli_insert_id($conn);
    }
} elseif ($chainID > 0 && $changeType == true) {
    $updateChainSql = "UPDATE `chain_map` SET `chainTypeID` = $chainType WHERE ID = $chainID";
    $result = mysqli_query($conn, $updateChainSql);
    $resultArray['sqlchainUPD'] = $updateChainSql;
}

$sqlclearChain = "UPDATE `estimate_criteriums_mapping` SET `chainID` = null WHERE `chainID` = $chainID";

mysqli_query($conn, $sqlclearChain);

$criteriaids = implode(",", $criterias);

$sqlUpdateChain = "UPDATE `estimate_criteriums_mapping` SET `chainID` = $chainID WHERE `ID` IN ($criteriaids) ";

mysqli_query($conn, $sqlUpdateChain);

$resultArray['chainID'] = $chainID;
$resultArray['sql'] = $sqlUpdateChain;

echo(json_encode($resultArray));