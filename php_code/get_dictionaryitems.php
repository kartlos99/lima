<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}

// am dictionary Code-ze ra itemebi gvaqvs
$code = $_GET['code'];

    $sql = "
SELECT di.ID, di.Code, di.`ValueText` FROM `DictionariyItems` di
LEFT JOIN Dictionaries d
ON di.`DictionaryID` = d.ID
WHERE d.Code = '$code'
order by `SortID`
";

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();