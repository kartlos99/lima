<?php

include_once '../config.php';
session_start();
if ($_SESSION['usertype'] != 'iCloudGrH' ){
    die("no_Accses");
}

if (isset($_POST['io']) && $_POST['io'] == 'get'){
    $sql = " SELECT * FROM `DictionariyItems` WHERE `DictionaryID` = (SELECT ID FROM Dictionaries WHERE Code = 'paramiters')";

    $result = mysqli_query($conn, $sql);
    
    $arr = array();
    foreach($result as $row){
        $arr[] = $row;
    }
    
    $outdata = [];
    foreach ($arr as $onerow){
        $currvalue = "";
        if ($onerow['ValueTypeID'] == 1){
            // $currvalue = $onerow['ValueText'];
            $currvalue = explode('|', $onerow['ValueText']);
        }elseif ($onerow['ValueTypeID'] == 2){
            $currvalue = $onerow['ValueInt'];
        }
        $outdata[$onerow['Code']] = $currvalue;
    }
    
    echo(json_encode($outdata));  

} else {
    if (isset($_POST['userpassduration'])){
        $val = $_POST['userpassduration'];
        $sql = " UPDATE
            `DictionariyItems`
        SET
            `ValueInt` = '$val'
        WHERE
            Code = 'userpassduration' ";
    }
    
    if (isset($_POST['reserv_period'])){
        $val = $_POST['reserv_period'];
        $sql = " UPDATE
            `DictionariyItems`
        SET
            `ValueInt` = '$val'
        WHERE
            Code = 'reserv_period' ";
    }
    
    if (isset($_POST['cvlebi'])){
        $val = $_POST['cvlebi'];
        $sql = " UPDATE
            `DictionariyItems`
        SET
            `ValueText` = '$val'
        WHERE
            Code = 'cvlebi' ";
    }

    $result = mysqli_query($conn, $sql);
    if (!$result){
        echo "save error!";
    } else{
        echo json_encode("ok");
    }
}



$conn -> close();

?>