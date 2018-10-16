<?php

include_once '../config.php';
session_start();

if (!($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'iCloudGrH')){
    die('rejected');
}

$cvlebi_HH = [];
$sql_getCvlevi = "SELECT ValueText FROM `dictionariyitems` WHERE `Code` = 'cvlebi'";
$result = mysqli_query($conn, $sql_getCvlevi);
$res = mysqli_fetch_assoc($result);
$cvlebi_HH = explode('|', $res['ValueText']);
// print_r($cvlebi_HH);

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

$cvlebis_dayofa = "(CASE  
WHEN HOUR(ah.`ModifyDate`) >= $cvlebi_HH[0] AND HOUR(ah.`ModifyDate`) < $cvlebi_HH[1] THEN 1
WHEN HOUR(ah.`ModifyDate`) >= $cvlebi_HH[1] AND HOUR(ah.`ModifyDate`) < $cvlebi_HH[2] THEN 2
WHEN HOUR(ah.`ModifyDate`) >= $cvlebi_HH[2] AND HOUR(ah.`ModifyDate`) < $cvlebi_HH[3] THEN 3
WHEN HOUR(ah.`ModifyDate`) >= $cvlebi_HH[3] OR HOUR(ah.`ModifyDate`) < $cvlebi_HH[0] THEN 4
END) AS cvla";
$cvlebis_dayofa1 = "(CASE  
WHEN HOUR(a.`ModifyDate`) >= $cvlebi_HH[0] AND HOUR(a.`ModifyDate`) < $cvlebi_HH[1] THEN 1
WHEN HOUR(a.`ModifyDate`) >= $cvlebi_HH[1] AND HOUR(a.`ModifyDate`) < $cvlebi_HH[2] THEN 2
WHEN HOUR(a.`ModifyDate`) >= $cvlebi_HH[2] AND HOUR(a.`ModifyDate`) < $cvlebi_HH[3] THEN 3
WHEN HOUR(a.`ModifyDate`) >= $cvlebi_HH[3] OR HOUR(a.`ModifyDate`) < $cvlebi_HH[0] THEN 4
END) AS cvla";

$sql = "
SELECT
    `AgreementID` AS aID,
    o.OrganizationName,
    IFNULL( b.BranchName, 'fil') as branch,
    `Date`,
    ah.`StateID`,
    ah.`ModifyDate`,
    $cvlebis_dayofa,
    ah.`ModifyUser`,
    s.Code,
    1 AS sort
FROM
    `AgreementsHistory` ah
LEFT JOIN States s ON
    s.ID = ah.StateID
LEFT JOIN Organizations o ON
	o.ID = ah.OrganizationID
LEFT JOIN organizationbranches b ON
	b.ID = ah.OrganizationBranchID
    $kreteria
UNION
SELECT
    a.`ID` AS aID,
    o.OrganizationName,
    IFNULL( b.BranchName, 'fil') as branch,
    `Date`,
    a.`StateID`,
    a.`ModifyDate`,
    $cvlebis_dayofa1,
    a.`ModifyUser`,
    s.Code,
    2 AS sort
FROM
    `Agreements` a
LEFT JOIN States s ON
    s.ID = a.StateID
LEFT JOIN Organizations o ON
	o.ID = a.OrganizationID
LEFT JOIN organizationbranches b ON
	b.ID = a.OrganizationBranchID
    $kreteria1
ORDER BY
    aID,
    sort,
    ModifyDate ";

// echo $sql;
$result = mysqli_query($conn, $sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

// 2.2 view-s damushaveba, mzadaa
$outdata = [];

for ($i = 1; $i < count($arr); $i++){
    if ($arr[$i]['aID'] == $arr[$i - 1]['aID']){

        if (($arr[$i]['Code'] == 'Active' || $arr[$i]['Code'] == 'Closed') && $arr[$i]['Code'] != $arr[$i-1]['Code']) {
            
            $operation = $arr[$i]['Code'];
            $fil = $arr[$i]['OrganizationName'] . " : " . $arr[$i]['branch'];
            $key_user = $arr[$i-1]['ModifyUser'];
            $cvla = $arr[$i-1]['cvla'] - 1;

            if ( !isset( $outdata[ $key_user ] )){
                $outdata += [ "$key_user" => array() ];                
            }

            if ( !isset( $outdata[ $key_user ][ $operation ] )){
                $outdata[ $key_user ] += [ "$operation" => array() ]; // useri -> operacia
            }

            if ( !isset( $outdata[ $key_user ][ $operation ][ $fil ] )){
                $outdata[ $key_user ][ $operation ] += [ "$fil" => [0,0,0,0] ];
            }

            $outdata[ $key_user ][ $operation ][ $fil ][ $cvla ] += 1;

            // if ($arr[$i]['a1'] != $arr[$i - 1]['a1']){
            //     $key_st_ch .= "_+kitxvebi";
            // }
            
            // if ( !isset( $outdata[ $key_user ][ $key_st_ch ] )){
            //     $outdata[ $key_user ] += ["$key_st_ch" => "0"];
            // }
            
            // $outdata[ $key_user ][ $key_st_ch ] += 1;
            // $outdata[ $key_user ][ $key_user ] += 1;
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