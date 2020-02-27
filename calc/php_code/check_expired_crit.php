<?php

session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}

function changeCriteriaStatus($critID, $db){
    $sql = "UPDATE `estimate_criterium_values` 
SET `CritValuesStatusID` = getstateid('Revision', getobjid('price_calc_item_states'))
WHERE `EstimateCriteriumID` = " . $critID;

    return mysqli_query($db, $sql);
}

$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
$resultArray = [];

$filterByTech = "";
if (isset($_GET['techID'])){
    $appID = $_GET['techID'];
    $filterByTech = "ecm.TechTreeID = $appID AND ";
}

// თუ ტექნიკის ღირებულება არაა შევსებული, მაშინ ცრიერიუმებს ვიკიდებთ, tp
$sql = "
SELECT
    ecm.ID AS critMapID, ecm.CriteriumID, ecv.ImpactValue, ecv.`RevDate`, ecv.`CritValuesStatusID` AS cvStatus, 
    ifnull(TIMESTAMPDIFF(DAY, CURRENT_DATE, ecv.`RevDate`), -1) as df2, st2.Code AS critValState
FROM
    estimate_criteriums_mapping ecm
LEFT JOIN `estimate_criterium_values` ecv ON
    ecm.ID = ecv.`EstimateCriteriumID`
LEFT JOIN States st ON
    st.ID = ecm.CriteriumStatusID
LEFT JOIN States st2 ON
    st2.ID = ecv.CritValuesStatusID 
LEFT JOIN tech_price tp ON 
    ecm.TechTreeID = tp.TechTreeID       
WHERE
    $filterByTech ecm.ParentID <> 0 AND st.Code = 'Active' AND ecv.ID <> 'null' AND tp.ID <> 'null'
";

$resultArray['sql'] = $sql;

$period = 0;
$sqlPeriod = "SELECT `ValueInt` FROM `DictionariyItems` WHERE `Code` = 'criteria_exp_notify_period'";
$resP = mysqli_query($conn, $sqlPeriod);
if ($resP) {
    $periodArr = $resP->fetch_array(MYSQLI_ASSOC);
    $period = $periodArr['ValueInt'];
}

$result = mysqli_query($conn, $sql);

$arr = [];
foreach ($result as $row) {
    $arr[] = $row;
    $resultArray[RESULT] = SUCCESS;
}
$resultArray['in_trouble'] = 0;
$resultArray['expired'] = 0;
foreach ($arr as $row) {
    if ($row['df2'] <= $period) {
        if ($row['df2'] < 0) {
            // critMapID ამ იდ-ზე სტატუსი შეიცვალოს 'გადასახედზე'
            $resultArray['expired']++;
            if ($row['critValState'] != 'Revision'){
                changeCriteriaStatus($row['critMapID'], $conn);
            }
        } else {
            $resultArray['in_trouble']++;
        }
    }
}

echo(json_encode($resultArray));