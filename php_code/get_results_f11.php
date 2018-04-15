<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';
$minDate = "2000-01-01";
$maxDate = "2100-01-01";
$query = "";

$organization =  $_POST['organization'];
if (isset($_POST['branch'])){
    $branch =  $_POST['branch'];
}

$agrN =  $_POST['agrN'];
$status =  $_POST['status'];

$agrStart1 =  $_POST['agrStart1'];
$agrStart2 =  $_POST['agrStart2'];
$agrFinish1 =  $_POST['agrFinish1'];
$agrFinish2 =  $_POST['agrFinish2'];
if ($agrStart1  == ""){
    $agrStart1 = $minDate;
}
if ($agrFinish1  == ""){
    $agrFinish1 = $minDate;
}
if ($agrStart2  == ""){
    $agrStart2 = $maxDate;
}
if ($agrFinish2  == ""){
    $agrFinish2 = $maxDate;
}
$imei =  $_POST['imei'];
$modeli =  $_POST['modeli'];
$serialN =  $_POST['serialN'];
$applid =  $_POST['applid'];

if ($modeli != 0){
    $query = $query." and i.IphoneModelID = $modeli";
}
if ($status != 0){
    $query = $query." and a.StateID = $status";
}
if ($organization != ""){
    $query = $query." and a.OrganizationID = $organization";
}
if ($branch != ""){
    $query = $query." and a.OrganizationBranchID = $branch";
}
if ($imei != ""){
    $query = $query." and i.PhIMEINumber like ('$imei%')";
}
if ($serialN != ""){
    $query = $query." and i.PhSerialNumber like ('$serialN%')";
}
if ($applid != ""){
    $query = $query." and apl.AplApplID like ('$applid%')";
}

// Fix -ebi amoviget xmarebidan, droebit. da igive velshi vwert dziritadi cxrilis ID-s
    $sql = "
SELECT a.ID, a.Number, Date(a.Date) AS Date, s.Value AS status, IFNULL(i.PhIMEINumber, '-') AS IMEI, IFNULL(d.ValueText, '-') AS Model, IFNULL(apl.AplApplID, '-') AS ApplID, o.OrganizationName, b.BranchName FROM `Agreements` a
LEFT JOIN States s ON a.`StateID` = s.ID
LEFT JOIN Iphone i ON a.`IphoneFixID` = i.ID
LEFT JOIN DictionariyItems d ON i.IphoneModelID = d.ID
LEFT JOIN ApplID apl ON a.`ApplIDFixID` = apl.ID
LEFT JOIN Organizations o ON a.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b ON a.OrganizationBranchID = b.ID

WHERE a.Number like ('$agrN%')
 AND DATE(a.date) BETWEEN '$agrStart1' AND '$agrStart2'
 AND DATE(a.EndDate) BETWEEN '$agrFinish1' AND '$agrFinish2'
";

$sql = $sql.$query;

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}
//echo $sql;
echo(json_encode($arr));

$conn -> close();