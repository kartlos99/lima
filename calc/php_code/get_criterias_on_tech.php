<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/17/19
 * Time: 10:39 AM
 */
session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}

$arr = array();
if (isset($_GET['techID']) && $_GET['techID'] != '') {
    $techID = $_GET['techID'];
    $filterActive = "";
    if (isset($_GET['onlyActive'])){
        $filterActive = " AND s.Code = 'Active' ";
    }

    if (isset($_GET['withValues'])){
        // with criteria Values
        $sql = "
SELECT
    emap.id, egr.Name AS 'gr', ecr.Name AS 'criteria', s.Code, s.Value AS 'st', emap.`Note`, emap.`CreateDate`, emap.`CreateUser`, emap.CriteriumID,
    ecv.ID AS 'crWeightID', ecv.Impact, ecv.ImpactType, ecv.ImpactValue, ecv.IsMain, ecv.RevDay, ecv.RevDate, ecv.CritValuesStatusID
FROM
    `estimate_criteriums_mapping` emap
LEFT JOIN estimate_criteriums egr
ON emap.`ParentID` = egr.ID
LEFT JOIN estimate_criteriums ecr
ON emap.`CriteriumID` = ecr.ID
LEFT JOIN states s
ON emap.`CriteriumStatusID` = s.ID
LEFT JOIN estimate_criterium_values ecv
ON emap.CriteriumID = ecv.EstimateCriteriumID
WHERE
    emap.`TechTreeID` = $techID AND emap.`ParentID` <> 0 " . $filterActive . " ORDER BY egr.Name, ecr.Name";

    }else{

        $sql = "
SELECT
    emap.id, egr.Name AS 'gr', ecr.Name AS 'criteria', s.Code, s.Value AS 'st', emap.`Note`, emap.`CreateDate`, emap.`CreateUser`
FROM
    `estimate_criteriums_mapping` emap
LEFT JOIN estimate_criteriums egr
ON emap.`ParentID` = egr.ID
LEFT JOIN estimate_criteriums ecr
ON emap.`CriteriumID` = ecr.ID
LEFT JOIN states s
ON emap.`CriteriumStatusID` = s.ID
WHERE
    emap.`TechTreeID` = $techID AND emap.`ParentID` <> 0 " . $filterActive . " ORDER BY egr.Name, ecr.Name";
    }


    $result = mysqli_query($conn, $sql);

    foreach ($result as $row) {
        $arr[] = $row;
    }

}

echo(json_encode($arr));