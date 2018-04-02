<?php
/**
 *  usafrtxoebis kitxvebi mogvaqvs bazidan
 *
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

    $sql = "
    SELECT id, DictionaryID, Code, ValueText FROM `DictionariyItems`
      WHERE
      DictionaryID in (SELECT ID FROM `Dictionaries` WHERE CODE LIKE 'AppleIDSequrityQuestion_')
    ";

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();