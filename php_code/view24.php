<?php

include_once '../config.php';
session_start();

if (!($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'iCloudGrH')){
    die('rejected');
}

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$kreteria = "";
$kreteria1 = "";

if (isset($_POST['datefrom']) && $_POST['datefrom'] != ''){
    $d1 = $_POST['datefrom'];
    $kreteria .= " ah.ModifyDate >= '$d1' ";
    $kreteria1 .= " a.ModifyDate >= '$d1' ";
}
if (isset($_POST['dateto']) && $_POST['dateto'] != ''){
    if (strlen($kreteria) > 0){
        $kreteria .= " AND ";
        $kreteria1 .= " AND ";
    }
    $d2 = $_POST['dateto'];
    $kreteria .= " ah.ModifyDate <= '$d2' ";
    $kreteria1 .= " a.ModifyDate <= '$d2' ";
}

if (strlen($kreteria) > 0){
    $kreteria = " WHERE " . $kreteria;
    $kreteria1 = " WHERE " . $kreteria1;
}


$sql = "
SELECT
    `ApplIDID` AS aID,
    `AplSequrityQuestion1ID` AS q1,
    `AplSequrityQuestion1Answer` AS a1,
    `AplSequrityQuestion2ID` AS q2,
    `AplSequrityQuestion2Answer` AS a2,
    `AplSequrityQuestion3ID` AS q3,
    `AplSequrityQuestion3Answer` AS a3,
    `StateID`,
    ah.`ModifyDate`,
    ah.`ModifyUser`,
    ah.`ModifyUserID`,
    s.Value AS val,
    1 AS sort
FROM
    `ApplIDHistory` ah
LEFT JOIN States s ON
    s.ID = ah.stateID
$kreteria
UNION
SELECT
    a.`ID` AS aID,
    `AplSequrityQuestion1ID` AS q1,
    `AplSequrityQuestion1Answer` AS a1,
    `AplSequrityQuestion2ID` AS q2,
    `AplSequrityQuestion2Answer` AS a2,
    `AplSequrityQuestion3ID` AS q3,
    `AplSequrityQuestion3Answer` AS a3,
    `StateID`,
    a.`ModifyDate`,
    a.`ModifyUser`,
    a.`ModifyUserID`,
    s.Value AS val,
    2 AS sort
FROM
    `ApplID` a
LEFT JOIN States s ON
    s.ID = a.stateID
$kreteria1
ORDER BY
    aID,
    sort,
    ModifyDate ";

// echo $sql;
$result = mysqli_query($conn, $sql);

$arr = array();

$rowCount = mysqli_num_rows($result);
// echo $rowCount;
if ( $rowCount > 0 ){
    foreach($result as $row){
        $arr[] = $row;
    }
    
}

// 2.4 view-s damushaveba, mzadaa
$outdata = [];

for ($i = 1; $i < count($arr); $i++){
    if ($arr[$i]['aID'] == $arr[$i - 1]['aID']){
        if ($arr[$i]['StateID'] != $arr[$i - 1]['StateID']){
            $key_st_ch = $arr[$i-1]['val'] . "->-" . $arr[$i]['val'];
            $key_user = $arr[$i-1]['ModifyUser'];
            if ($arr[$i]['a1'] != $arr[$i - 1]['a1']){
                $key_st_ch .= "_+kitxvebi";
            }
            if ( !isset( $outdata[ $key_user ] )){
                $outdata += ["$key_user" => array() ];
                $outdata[ $key_user ] += ["$key_user" => "0"];
            }
            if ( !isset( $outdata[ $key_user ][ $key_st_ch ] )){
                $outdata[ $key_user ] += ["$key_st_ch" => "0"];
            }
            
            $outdata[ $key_user ][ $key_st_ch ] += 1;
            $outdata[ $key_user ][ $key_user ] += 1;
            // $outdata += ["$key_user" => "0"];
            // array_push($outdata, "dd" );
        }

    }
}

// print_r ($outdata);

echo(json_encode($outdata));

$conn -> close();

// $sql_chek = "SELECT checkmail('".$emEmail."',4) AS num ";
// $result1 = mysqli_query($conn, $sql_chek);
// $arr = mysqli_fetch_assoc($result1);
// $count = $arr['num'];



?>