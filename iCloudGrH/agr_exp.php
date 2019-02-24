<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 23.04.2018
 * Time: 15:46
 */

include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}
if ($_SESSION['usertype'] != 'iCloudGrH'){
    die("NO_access");
}
$currUserID = $_SESSION['userID'];


$sql = "SELECT
ag.id AS AgrID,
ag.OrganizationID,
o.OrganizationName,
ag.OrganizationBranchID,
b.BranchName,
ag.number AS AgrNumber,
ag.date AS AgrDate,
ag.enddate AS AgrEndDate,
s.Value AS AgrStatus,
ag.`IphoneFixID` AS IphoneID,
PhIMEINumber,
PhSerialNumber,
RestrictionPass,
EncryptionPass,
ScreenLockPass,
ScreenLockDate,
d.valuetext AS ScreenLockState,
ScreenLockSendDate,
ap.id AS AppleID,
AplApplID,
AplPassword
FROM
`Agreements` ag
LEFT JOIN ApplID ap ON
ag.`ApplIDFixID` = ap.ID
LEFT JOIN Iphone i ON
ag.`IphoneFixID` = i.ID
LEFT JOIN Organizations o ON
ag.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b ON
ag.`OrganizationBranchID` = b.ID
LEFT JOIN States s ON
ag.StateID = s.ID
LEFT JOIN DictionariyItems d ON
i.SLstateID = d.ID " ;

$output = '<table bordered="3">';

date_default_timezone_set("Asia/Tbilisi");
$dges = date("Y-m-d", time());

function makeHrow($columns){
    $newRow = "<tr>";
    foreach($columns as $item){
        $newRow .= "<th>" . $item . "</th>";
    }
    return $newRow . "</tr>";    
}
// 1	1
function makerow($columns){
    $newRow = "<tr>";
    foreach($columns as $item){
        if ($item == "0000-00-00 00:00:00"){
            $item = "";
        }
        $newRow .= "<td>" . $item . "</td>";        
    }
    return $newRow . "</tr>";
}

$tHead = [
"AgrID",
"OrganizationID",
"OrganizationName",
"OrganizationBranchID",
"BranchName",
"AgrNumber",
"AgrDate",
"AgrEndDate",
"AgrStatus",
"IphoneID",
"PhIMEINumber",
"PhSerialNumber",
"RestrictionPass",
"EncryptionPass",
"ScreenLockPass",
"ScreenLockDate",
"ScreenLockState",
"ScreenLockSendDate",
"AppleID",
"AplApplID",
"AplPassword"];


$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {

    $output .= makeHrow($tHead);

    foreach($result as $row){
        $output .= makerow($row);
    }
}

$output .= '</table>';
$fileName = "agreements_" . $dges;

//header("Content-Type: application/xls");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fileName.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $output;

mysqli_close($conn);
?>