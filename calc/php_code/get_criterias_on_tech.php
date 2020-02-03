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
    if (isset($_GET['onlyActive'])) {
        $filterActive = " AND s.Code = 'Active' ";
    }
    $filterActiveValue = "";
    if (isset($_GET['onlyActiveValue'])) {
        $filterActiveValue = " AND s2.Code = 'Active' ";
    }

    if (isset($_GET['withValues'])) {
        // with criteria Values
        $sql = "
SELECT
    emap.id, egr.Name AS 'gr', ecr.Name AS 'criteria', s.Code, s.Value AS 'st', emap.`Note`, emap.`CreateDate`, emap.`CreateUser`, emap.CriteriumID,
    ecv.ID AS 'crWeightID', ecv.Impact, di1.Code AS 'impactCode', ecv.ImpactType, di2.Code AS 'impactTypeCode', ecv.ImpactValue, ecv.IsMain, 
    ecv.RevDay, ecv.RevDate, ecv.CritValuesStatusID, ecv.CritValuesStatusID, s2.Code AS 's2code',
    ifnull(emap.chainID, 0) AS chainID,
    ifnull(di_ch.Code, '') AS chainType
FROM
    `estimate_criteriums_mapping` emap
LEFT JOIN estimate_criteriums egr
ON emap.`ParentID` = egr.ID
LEFT JOIN estimate_criteriums ecr
ON emap.`CriteriumID` = ecr.ID
LEFT JOIN States s
ON emap.`CriteriumStatusID` = s.ID
LEFT JOIN estimate_criterium_values ecv
ON emap.ID = ecv.EstimateCriteriumID
LEFT JOIN States s2
ON ecv.CritValuesStatusID = s2.ID
LEFT JOIN DictionariyItems di1
ON ecv.Impact = di1.ID
LEFT JOIN DictionariyItems di2
ON ecv.ImpactType = di2.ID
LEFT JOIN chain_map chmap ON chmap.ID = emap.chainID
LEFT JOIN DictionariyItems di_ch ON di_ch.ID = chmap.chainTypeID
WHERE
    emap.`TechTreeID` = $techID AND emap.`ParentID` <> 0 " . $filterActive . $filterActiveValue . " 
    AND `CriteriumID` NOT IN (
            SELECT DISTINCT `CriteriumID` FROM estimate_criteriums_mapping e
        LEFT JOIN States s ON s.ID = e.CriteriumStatusID
        WHERE
            `TechTreeID` IN (
            SELECT $techID AS ParentID
        UNION
        SELECT ParentID FROM `techniques_tree` WHERE ID = $techID
        UNION ALL
        SELECT ParentID FROM `techniques_tree` WHERE ID IN (SELECT ParentID FROM `techniques_tree` WHERE ID = $techID)
        )
        AND
            CriteriumID in (SELECT `CriteriumID` FROM estimate_criteriums_mapping WHERE `TechTreeID` = $techID)
        AND s.code <> 'Active')
	AND  emap.`ParentID` NOT IN (
            SELECT DISTINCT `CriteriumID` FROM estimate_criteriums_mapping e
        LEFT JOIN States s ON s.ID = e.CriteriumStatusID
        WHERE
            `TechTreeID` IN (
            SELECT $techID AS ParentID
        UNION
        SELECT ParentID FROM `techniques_tree` WHERE ID = $techID
        UNION ALL
        SELECT ParentID FROM `techniques_tree` WHERE ID IN (SELECT ParentID FROM `techniques_tree` WHERE ID = $techID)
        )
        AND
            CriteriumID in (SELECT `CriteriumID` FROM estimate_criteriums_mapping WHERE `TechTreeID` = $techID)
        AND s.code <> 'Active')
    
    ORDER BY egr.Name, ecr.Name";

    } else {

//        $sql = "
//SELECT
//    emap.id, egr.Name AS 'gr', ecr.Name AS 'criteria', s.Code, s.Value AS 'st', emap.`Note`, emap.`CreateDate`, emap.`CreateUser`
//FROM
//    `estimate_criteriums_mapping` emap
//LEFT JOIN estimate_criteriums egr
//ON emap.`ParentID` = egr.ID
//LEFT JOIN estimate_criteriums ecr
//ON emap.`CriteriumID` = ecr.ID
//LEFT JOIN states s
//ON emap.`CriteriumStatusID` = s.ID
//WHERE
//    emap.`TechTreeID` = $techID AND emap.`ParentID` <> 0 " . $filterActive . " ORDER BY egr.Name, ecr.Name";

        $sql = "
        SELECT em1.*, ss.Code AS grcode, ss.value AS grstatus FROM
(
SELECT
  emap.id, egr.Name AS 'gr', ecr.Name AS 'criteria', s.Code, s.Value AS 'st', emap.`Note`, emap.`CreateDate`, emap.`CreateUser`, emap.`parentID`
FROM
    `estimate_criteriums_mapping` emap
LEFT JOIN estimate_criteriums egr
ON emap.`ParentID` = egr.ID
LEFT JOIN estimate_criteriums ecr
ON emap.`CriteriumID` = ecr.ID
LEFT JOIN States s
ON emap.`CriteriumStatusID` = s.ID
WHERE
    emap.`TechTreeID` = $techID 
    $filterActive
ORDER BY egr.Name, ecr.Name
) as em1
LEFT JOIN estimate_criteriums_mapping em2
    ON em2.CriteriumID = em1.`ParentID`
LEFT JOIN States ss
ON em2.`CriteriumStatusID` = ss.ID    
WHERE em2.`TechTreeID` = $techID ";
    }


    $result = mysqli_query($conn, $sql);

    foreach ($result as $row) {
        $arr[] = $row;
    }

}

echo(json_encode($arr));

// working on
//SELECT
//    map.id,
//    `TechTreeID`,
//    `CriteriumID`,
//    map.`ParentID` AS crParent,
//    `CriteriumStatusID`,
//    t1.ID,
//    t1.Name,
//    t1.StatusID,
//    t2.ID,
//    t2.Name,
//    t2.StatusID,
//    t3.ID,
//    t3.Name,
//    t3.StatusID
//FROM
//    `estimate_criteriums_mapping` map
//LEFT JOIN techniques_tree t1 ON
//    map.`TechTreeID` = t1.ID
//LEFT JOIN techniques_tree t2 ON
//    t1.ParentID = t2.ID
//LEFT JOIN techniques_tree t3 ON
//    t2.ParentID = t3.ID
//WHERE
//    `TechTreeID` = 50 AND `CriteriumID` NOT IN (
//    SELECT DISTINCT `CriteriumID` FROM estimate_criteriums_mapping e
//LEFT JOIN states s ON s.ID = e.CriteriumStatusID
//WHERE
//	`TechTreeID` IN (
//    SELECT 50 AS ParentID
//UNION
//SELECT ParentID FROM `techniques_tree` WHERE ID = 50
//UNION ALL
//SELECT ParentID FROM `techniques_tree` WHERE ID IN (SELECT ParentID FROM `techniques_tree` WHERE ID = 50)
//)
//AND
//	CriteriumID in (SELECT `CriteriumID` FROM estimate_criteriums_mapping WHERE `TechTreeID` = 50)
//AND s.code <> 'Active')
//


//SELECT DISTINCT `CriteriumID` FROM estimate_criteriums_mapping e
//LEFT JOIN states s ON
//	s.ID = e.CriteriumStatusID
//WHERE
//`TechTreeID` IN(
//    SELECT 50 AS ParentID
//    UNION
//    	SELECT ParentID FROM `techniques_tree`
//    	WHERE ID = 50
//    UNION
//		SELECT ParentID FROM `techniques_tree`
//		WHERE ID IN(
//    SELECT ParentID FROM `techniques_tree`
//    		WHERE ID = 50
//		)
//) AND CriteriumID IN(
//    SELECT `CriteriumID` FROM estimate_criteriums_mapping
//    WHERE `TechTreeID` = 50
//) AND s.code <> 'Active'