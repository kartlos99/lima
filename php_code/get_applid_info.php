<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

$applid = $_GET['applid'];
$res2 = "";
$res3 = "";
$resData = array();
//$resData['view'] = 0;
$resData['get'] = 0;
//$resData['add'] = 0;
$resData['AgreementRv'] = ", არ ფიქსირდება აქტიური სესხი";
$resData['AgreementR'] = 0;   //-------------
$resData['ProblemRv'] = "";  //-----
$resData['ProblemR'] = 0;  //-----
$sesxi = false;
$problem = false;

    $sql = "
SELECT a.id, a.`AplApplID`, s.code AS st FROM `ApplID` a
LEFT JOIN States s
ON a.StateID = s.ID
WHERE `AplApplID` = '$applid'
    ";

$result = mysqli_query($conn,$sql);
$count = mysqli_num_rows($result);

if ($count > 0){
    $arr = mysqli_fetch_assoc($result);
    $resData['AppleIDRv'] = "იძებნება AppleID";
    $resData['AppleIDR'] = $count;
    $resData['id'] = $arr['id'];
    //$resData['view'] = 1;


    $sql = "
    SELECT s.Code FROM `Agreements` agr
    LEFT JOIN
    ApplIDFix ap
    ON agr.`ApplIDFixID` = ap.ID
    LEFT JOIN
    States s
    ON agr.`StateID` = s.ID
    WHERE ap.`AplApplID` = '$applid'
            ";

    $result2 = mysqli_query($conn,$sql);
    $count2 = mysqli_num_rows($result2);

    if ($count2 > 0){
        $resData['AgreementR'] = $count2;   //-------------

        $data = mysqli_fetch_assoc($result2);

        if ($data['Code'] == 'Active'){
            $res2 = ", ფიქსირდება აქტიური სესხი";
            $sesxi = true;
        }
        if ($data['Code'] == 'Project'){
            $res2 = ", ფიქსირდება აქტიური ხელშეკრულების პროექტი";
        }
    }else{
        $res2 = ", არ ფიქსირდება აქტიური სესხი";
        $resData['AgreementR'] = 0;   //-------------
    }
    $resData['AgreementRv'] = $res2;    //-------------

    if ($arr['st'] == 'problem'){
        $resData['ProblemRv'] = ", პრობლემური";
        $resData['ProblemR'] = 1;  //-----------
        $problem = true;
    }

}else {
    $resData['AppleIDRv'] = "არ იძებნება AppleID";
    $resData['AppleIDR'] = 0;    //---------
    //$resData['add'] = 1;
}

if ($sesxi || $problem){
    $resData['get'] = 0;
}else{
    $resData['get'] = 1;
}

echo json_encode($resData);
$conn -> close();
?>