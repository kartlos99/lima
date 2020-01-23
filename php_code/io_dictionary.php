<?php

include_once '../config.php';
session_start();

function isAdmin()
{
    if ($_SESSION['usertype'] == 'iCloudGrH' ||
        $_SESSION['M2UT'] == 'administrator' ||
        $_SESSION['M3UT'] == 'admin' ||
        $_SESSION['M4UT'] == 'administrator') {
        return true;
    }
    return false;
}

if (!isAdmin()) {
    die("no_Accses");
}

$resultArray = [];
$sql = "";


if (isset($_POST['io']) && $_POST['io'] == 'get') {
    $sql = " SELECT * FROM `DictionariyItems` WHERE `DictionaryID` = (SELECT ID FROM Dictionaries WHERE Code = 'paramiters')";

    $result = mysqli_query($conn, $sql);

    $arr = array();
    foreach ($result as $row) {
        $arr[] = $row;
    }

    $outdata = [];
    foreach ($arr as $onerow) {
        $currvalue = "";
        if ($onerow['ValueTypeID'] == 1) {
            // $currvalue = $onerow['ValueText'];
            $currvalue = explode('|', $onerow['ValueText']);
        } elseif ($onerow['ValueTypeID'] == 2) {
            $currvalue = $onerow['ValueInt'];
        }
        $outdata[$onerow['Code']] = $currvalue;
    }

    echo(json_encode($outdata));

} else {
    $code = $_POST['code'];
    $val = $_POST['val'];  // userpassduration

    $sql = " UPDATE
            `DictionariyItems`
        SET
            `ValueInt` = '$val'
        WHERE
            Code = '$code' ";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $resultArray[RESULT] = "ok";
    } else {
        $resultArray[RESULT] = ERROR;
        $resultArray[ERROR] = "can't save dictionary value!";
    }

    $resultArray['sql'] = $sql;

    echo(json_encode($resultArray));
}

