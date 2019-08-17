<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/16/19
 * Time: 12:55 PM
 */

session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}

$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
$resultArray = [];

$tech_id = $_POST['tech_id'];
$record_id = $_POST['record_id'];

if (!isset($_POST['price_crit_weight_status'])) {
    $price_new = $_POST['price_new'];
    $price_goal = $_POST['price_goal'];
    $calc_type = $_POST['calc_type'];
    $price_market = $_POST['price_market'];
    $price_impact = $_POST['price_impact'];
    $max_amount = $_POST['max_amount'];
    $price_competitor = $_POST['price_competitor'];
    $impact_type = $_POST['impact_type'];
    $status = $_POST['status'];
    $impact_size = $_POST['impact_size'];
    $revision_period = $_POST['revision_period'];
    $price_note = $_POST['price_note'];
    $revision_date = $_POST['revision_date'];
}


if ($record_id == 0) {
    // axali wanawweri

    $sql_insert = "
INSERT INTO `tech_price`(
    `TechTreeID`,
    `StatusID`,
    `NewPrice`,
    `MarketPrice`,
    `CompetitorPrice`,
    `GoalPrice`,
    `Impact`,
    `ImpactType`,
    `ImpactValue`,
    `CalculateType`,
    `MaxPrice`,
    `MaxPriceStatusID`,
    `RevDay`,
    `RevDate`,
    `Note`,
    `CreateDate`,
    `CreateUser`,
    `CreateUserID`
)
VALUES(
    '$tech_id',
    getstateid('Project', getobjid('tech_and_crit_weight_states')),
    '$price_new',
    '$price_market',
    '$price_competitor',
    '$price_goal',
    '$price_impact',
    '$impact_type',
    '$impact_size',
    '$calc_type',
    '$max_amount',
    '$status',
    '$revision_period',
    '$revision_date',
    '$price_note',
    $currDate,
    '$currUser',
    $currUserID
)
";

    $resultArray['sql_ins'] = $sql_insert;

    if (mysqli_query($conn, $sql_insert)) {
        $resultArray['workingID'] = mysqli_insert_id($conn);
        $resultArray['result'] = "success";
    } else {
        $resultArray['error'] = "can't ins Tech_Price!";
    }

} else {
    // ganaxleba

    if (isset($_POST['price_crit_weight_status'])) {
        // mxolod ღირებულებისა და კრიტერიუმების წონების სტატუსი -s ganaxleba
        $status_id = $_POST['price_crit_weight_status'];
        $sql_update = "
    UPDATE
    `tech_price`
SET
    `StatusID` = '$status_id',
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = '$currUserID'
WHERE
    ID = $record_id
    ";
    } else {
        $sql_update = "
    UPDATE
    `tech_price`
SET
    `NewPrice` = '$price_new',
    `MarketPrice` = '$price_market',
    `CompetitorPrice` = '$price_competitor',
    `GoalPrice` = '$price_goal',
    `Impact` = '$price_impact',
    `ImpactType` = '$impact_type',
    `ImpactValue` = '$impact_size',
    `CalculateType` = '$calc_type',
    `MaxPrice` = '$max_amount',
    `MaxPriceStatusID` = '$status',
    `RevDay` = '$revision_period',
    `RevDate` = '$revision_date',
    `Note` = '$price_note',
    `ModifyDate` = $currDate,
    `ModifyUser` = '$currUser',
    `ModifyUserID` = '$currUserID'
WHERE
    ID = $record_id
    ";
    }


    $resultArray['sql_update'] = $sql_update;

    if (mysqli_query($conn, $sql_update)) {
        $resultArray['result'] = "success";
        $resultArray['workingID'] = $record_id;
    } else {
        $resultArray['error'] = "can't update Tech_Price!";
    }

}


echo(json_encode($resultArray));