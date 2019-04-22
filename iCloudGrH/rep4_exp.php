<?php

include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}
if ($_SESSION['usertype'] != 'iCloudGrH'){
    die("NO_access");
}


$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$kreteria = "";
$kreteria1 = "";

if (isset($_GET['datefrom']) && $_GET['datefrom'] != ''){
    $d1 = $_GET['datefrom'];
    $kreteria .= " ah.ModifyDate >= '$d1' ";
    $kreteria1 .= " a.ModifyDate >= '$d1' ";
}
if (isset($_GET['dateto']) && $_GET['dateto'] != ''){
    if (strlen($kreteria) > 0){
        $kreteria .= " AND ";
        $kreteria1 .= " AND ";
    }
    $d2 = $_GET['dateto'];
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
        if ($arr[$i]['StateID'] != $arr[$i - 1]['StateID'] 
            || $arr[$i]['a1'] != $arr[$i - 1]['a1']
            || $arr[$i]['a2'] != $arr[$i - 1]['a2']
            || $arr[$i]['a3'] != $arr[$i - 1]['a3']){

            $key_st_ch = $arr[$i-1]['val'] . "->-" . $arr[$i]['val'];
            $key_user = $arr[$i-1]['ModifyUser'];
            
            $answerN = "";
            if ($arr[$i]['a1'] != $arr[$i - 1]['a1']){
                $answerN .= "1";
            }
            if ($arr[$i]['a2'] != $arr[$i - 1]['a2']){
                $answerN .= "2";
            }
            if ($arr[$i]['a3'] != $arr[$i - 1]['a3']){
                $answerN .= "3";
            }
            if ($answerN != ""){
                $key_st_ch .= "_kitxvebi_" . $answerN;
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
// echo(json_encode($outdata));

// --------------------------------------------------------------------------------------
// **************************************************************************************


$output = '<table bordered="3">';

date_default_timezone_set("Asia/Tbilisi");
$dges = date("Y-m-d", time());

function makerow($columns){
    $newRow = "<tr>";
    foreach($columns as $key => $col){
        $newRow .= "<td>" . $key . "</td>";        
        $newRow .= "<td>" . $col . "</td>";
        $newRow .= "</tr><tr>";
    }
    return $newRow . "</tr>";
}

if (count($outdata) > 0) {
    foreach($outdata as $key_user => $row){
        $output .= "<td>********************</td>";
        $output .= makerow($row);
    }
}

$output .= '</table>';
$fileName = "status_changes_" . $_GET['datefrom'] . "_" . $_GET['dateto'] ;

//header("Content-Type: application/xls");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fileName.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $output;

mysqli_close($conn);
?>