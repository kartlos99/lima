<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/17/19
 * Time: 10:54 AM
 */

function headerRow($items = [], $pos = 0, $margeN = 1)
{
    $h_row = "";
    for ($i = 0; $i < count($items); $i++) {
        $colspan = ($pos == $i ? " colspan=\"$margeN\"" : "");
        $h_row .= "<th$colspan>$items[$i]</th>";
    }
//    foreach ($items as $item) {
//        $h_row .= "<hd>$item</hd>";
//    }
    return $h_row;
}

function getStatusItems($dbConn, $sCode)
{
    $list = [];
    $sql = "SELECT id as vv, `code`, `value` as tt
            FROM `States`
            WHERE ObjectID = getobjid('$sCode')
            ORDER BY SortID";
    $result = mysqli_query($dbConn, $sql);
    foreach ($result as $row) {
        $list[] = $row;
    }
    return $list;
}

function getCriteriumItems($dbConn, $parentID = 0)
{
    $list = [];
$sql = "
SELECT e.id AS vv, e.Name as tt FROM estimate_criteriums e
WHERE e.`ParentID` = $parentID ";
    $result = mysqli_query($dbConn, $sql);
    foreach ($result as $row) {
        $list[] = $row;
    }
    return $list;
}