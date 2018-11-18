<?php

include_once '../config.php';
session_start();

if (!($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'iCloudGrH')){
    die('rejected');
}

$cvlebi_HH = [];
$cvlebi_TB = [];
$sql_getCvlevi = "SELECT ValueText FROM `DictionariyItems` WHERE `Code` = 'cvlebi'";
$result = mysqli_query($conn, $sql_getCvlevi);
$res = mysqli_fetch_assoc($result);
$cvlebi_HH = explode('|', $res['ValueText']);
$cvlisN = 1;
for ($i = 0; $i < count($cvlebi_HH); $i = $i + 2 ){
    if ($cvlebi_HH[$i] <= $cvlebi_HH[$i+1]){
        array_push($cvlebi_TB, [$cvlebi_HH[$i], $cvlebi_HH[$i+1], $cvlisN]);
    }else{
        array_push($cvlebi_TB, [$cvlebi_HH[$i], 24, $cvlisN]);
        array_push($cvlebi_TB, [0, $cvlebi_HH[$i+1], $cvlisN]);
    }
    $cvlisN++;
}
//  print_r($cvlebi_TB);

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

$cvlebis_dayofa = "(CASE ";
$cvlebis_dayofa1 = "(CASE ";
foreach($cvlebi_TB as $cvla){
    $cvlebis_dayofa .= " WHEN HOUR(ah.`ModifyDate`) >= $cvla[0] AND HOUR(ah.`ModifyDate`) < $cvla[1] THEN $cvla[2]";
    $cvlebis_dayofa1 .= " WHEN HOUR(a.`ModifyDate`) >= $cvla[0] AND HOUR(a.`ModifyDate`) < $cvla[1] THEN $cvla[2]";
}
$cvlebis_dayofa .= " ELSE 0 END) AS cvla";
$cvlebis_dayofa1 .= " ELSE 0 END) AS cvla";


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
LEFT JOIN OrganizationBranches b ON
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
LEFT JOIN OrganizationBranches b ON
	b.ID = a.OrganizationBranchID
    $kreteria1
ORDER BY
    aID,
    sort,
    ModifyDate ";

// echo $sql;
$result = mysqli_query($conn, $sql);

$outdata = [];

if (mysqli_num_rows($result) < 40000 ){

    $arr = array();
    foreach($result as $row){
        $arr[] = $row;
    }

    for ($i = 1; $i < count($arr); $i++){
        if ($arr[$i]['aID'] == $arr[$i - 1]['aID']){
    
            if (($arr[$i]['Code'] == 'Active' || $arr[$i]['Code'] == 'Closed') && $arr[$i]['Code'] != $arr[$i-1]['Code']) {
                
                $operation = $arr[$i]['Code'];
                $fil = $arr[$i]['OrganizationName'] . " : " . $arr[$i]['branch'];
                $key_user = $arr[$i-1]['ModifyUser'];
                $cvla = $arr[$i-1]['cvla'] - 1;
                if($cvla == -1){
                    break;
                }
    
                if ( !isset( $outdata[ $key_user ] )){
                    $outdata += [ "$key_user" => array() ];
                }
    
                if ( !isset( $outdata[ $key_user ][ $operation ] )){
                    $outdata[ $key_user ] += [ "$operation" => array() ]; // useri -> operacia
                }
    
                if ( !isset( $outdata[ $key_user ][ $operation ][ $fil ] )){
                    $outdata[ $key_user ][ $operation ] += [ "$fil" => [0,0] ];
                }
    
                $outdata[ $key_user ][ $operation ][ $fil ][ $cvla ] += 1;
            }
        }
    }    
} else {
    $outdata += [ "error" => "მეხსიერების გადავსება! შეამცირეთ დიაპაზონი!" ];
}

echo(json_encode($outdata));
$conn -> close();
?>