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

$applid = $_GET['applid'];
$res2 = "";
$res3 = "";
$resData = array();
//$resData['view'] = 0;
$resData['get'] = 0;
//$resData['add'] = 0;
$resData['AgreementRv'] = ", არ ფიქსირდება სესხი";
$resData['AgreementR'] = 0;   //-------------
$resData['ProblemRv'] = "";  //-----
$resData['ProblemR'] = 0;  //-----
$resData['orgID'] = 0;  //-----
$resData['AgrNumber'] = "";   //-------------
$resData['reservation'] = "";   // reseravion check
$sesxi = false;
$problem = false;

$sql = "
SELECT 
    a.id, a.`AplApplID`, a.OrganizationID, s.code AS st, 
    UNIX_TIMESTAMP() - reservDate - (select valueint from dictionariyitems where CODE = 'reserv_period') AS reservation
FROM `ApplID` a
LEFT JOIN States s
ON a.StateID = s.ID
WHERE `AplApplID` = '$applid'
limit 1
    ";

$result = mysqli_query($conn,$sql);
$count = mysqli_num_rows($result);

if ($count > 0){
    $arr = mysqli_fetch_assoc($result);
    $resData['AppleIDRv'] = "იძებნება AppleID";
    $resData['AppleIDR'] = $count;
    $resData['id'] = $arr['id'];
    //$resData['view'] = 1;
    $resData['orgID'] = $arr['OrganizationID'];


    $sql = "
    SELECT s.Code, agr.Number FROM `Agreements` agr
    LEFT JOIN
    ApplID ap
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

        //$arr = array();
        foreach($result2 as $data){
            //  $arr[] = $data;

            if ($data['Code'] == 'Active'){
                $res2 .= ", ფიქსირდება აქტიური სესხი";
                $sesxi = true;
                $resData['AgrNumber'] = $data['Number'];   //-------------
            }
            if ($data['Code'] == 'Project'){
                $res2 .= ", ფიქსირდება აქტიური ხელშეკრულების პროექტი";
                $sesxi = true;
                $resData['AgrNumber'] = $data['Number'];   //-------------
            }
            if ($data['Code'] == 'Closed'){
                $res2 .= ", ფიქსირდება დასრულებული ხელშეკრულება";

            }
        }
    }else{
        $res2 = ", არ ფიქსირდება სესხი";
        $resData['AgreementR'] = 0;   //-------------
    }
    $resData['AgreementRv'] = $res2;    //-------------

    if ($arr['st'] == 'problem'){
        $resData['ProblemRv'] = ", პრობლემური";
        $resData['ProblemR'] = 1;  //-----------
        $problem = true;
    } elseif ($arr['st'] != 'Active'){
        $problem = true;
        $resData['ProblemRv'] = ", არა აქტიური ApplID";
    }
    
    if ($arr['reservation'] < 0){        
        $resData['reservation'] = ", რეზერვაციის ვადა არ გასულა";
    }

}else {
    $resData['AppleIDRv'] = "არ იძებნება AppleID";
    $resData['AppleIDR'] = 0;    //---------
    //$resData['add'] = 1;
}

if (!($sesxi || $problem) && $count > 0){
    $resData['get'] = 1;
}

echo json_encode($resData);
$conn -> close();
?>