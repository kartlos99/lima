<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/17/19
 * Time: 10:54 AM
 */
define('PERSON_DISCOVERER', 'founder');
define('PERSON_GUILTY', 'violator');

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

function getDictionariyItems($dbConn, $dCode, $exeptions = [])
{
    $list = [];
    $sql = "SELECT di.id as vv, di.ValueText as tt, di.code
            FROM `DictionariyItems` di
            LEFT JOIN Dictionaries d
                ON di.`DictionaryID` = d.ID
            WHERE d.Code = '$dCode'
            ORDER BY SortID";
    $result = mysqli_query($dbConn, $sql);
    foreach ($result as $row) {
        if (!in_array($row['code'], $exeptions))
            $list[] = $row;
    }
    return $list;
}

function getOwners($dbConn, $module_N)
{
    $list = [];
    $list[] = ["vv" => "", "tt" => "აირჩიეთ"];
    // org. systemis administratori arid id=5 ze da siebSi ar gamogvaqvs
    $sql = "SELECT ID as vv, UserName as tt FROM `PersonMapping` WHERE ifnull(`UserTypeM" . $module_N . "`, 0) <> 0 AND OrganizationID <> 5";

    $result = mysqli_query($dbConn, $sql);
    foreach ($result as $row) {
        $list[] = $row;
    }
    return $list;
}

function getPersons($dbConn, $personType)
{
    $list = [];
    $list[] = ["vv" => "", "tt" => "აირჩიეთ", "Code" => "none"];
    $sql = "
SELECT p.id AS vv, concat(FirstName, ' ', LastName) AS tt, ditype.Code FROM `im_persons` p
LEFT JOIN DictionariyItems ditype
ON ditype.ID = p.`TypeID`
LEFT JOIN DictionariyItems di_st
ON di_st.ID = p.`StatusID`
WHERE (ditype.Code = 'both' or ditype.Code = '$personType') AND di_st.Code = 'active'
ORDER BY tt ";
    $result = mysqli_query($dbConn, $sql);
    foreach ($result as $row) {
        $list[] = $row;
    }
    return $list;
}