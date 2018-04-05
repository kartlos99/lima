<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

$imei = $_GET['imei'];
$res2 = "";
$res3 = "";
$resData = array();
$resData['view'] = 0;
$resData['get'] = 0;
$resData['add'] = 0;
$resData['AgreementRv'] = ", არ ფიქსირდება აქტიური სესხი";
$resData['AgreementR'] = 0;   //-------------
$resData['BlackListRv'] = ", არ ფიქსირდება პრობლემა";  //-----
$resData['BlackListR'] = 0;  //-----
$sesxi = false;
$problem = false;

    $sql = "
SELECT d.Code AS model , s.Code AS st FROM `Iphone` p
LEFT JOIN DictionariyItems d
ON p.`IphoneModelID` = d.ID
LEFT JOIN States s
ON p.`StateID` = s.ID
WHERE `PhIMEINumber` = '$imei'
    ";

$result = mysqli_query($conn,$sql);
$count = mysqli_num_rows($result);

if ($count > 0){
    $arr = mysqli_fetch_assoc($result);
    $resData['PhoneR'] = $count;    //---------
    $resData['PhoneRv'] = $arr['model'];    //-----------
    $resData['view'] = 1;


$sql = "
SELECT s.Code FROM `Agreements` a
LEFT JOIN
IphoneFix p
ON a.`IphoneFixID` = p.ID
LEFT JOIN
States s
ON a.`StateID` = s.ID
WHERE p.PhIMEINumber = '$imei'
        ";

    $result2 = mysqli_query($conn,$sql);
    $count2 = mysqli_num_rows($result2);

    $resData['AgreementR'] = $count2;   //-------------
    if ($count2 > 0){
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
    }
    $resData['AgreementRv'] = $res2;    //-------------

    if ($arr['st'] == 'problem'){
        $resData['BlackListRv'] = ", პრობლემური";
        $resData['BlackListR'] = 1;  //-----------
        $problem = true;
    }

}else {
    $resData['PhoneRv'] = "არ იძებნება ტელეფონი";
    $resData['PhoneR'] = 0;    //---------
    $resData['add'] = 1;
}

if ($sesxi || $problem){
    $resData['get'] = 0;
}else{
    $resData['get'] = $resData['view'];
}

echo json_encode($resData);
$conn -> close();
?>