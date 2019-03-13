<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
//include_once '../config.php';
include_once '../commonbody/header_1.php';
//session_start();
//$currUserID = $_SESSION['userID'];

if (!($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'iCloudGrH' || $_SESSION['usertype'] == 'iCloudOper')){
    die('არაგაქვთ ისტორიის ნახვის უფლება.');
}

//$agrN =  $_POST['agrN'];
if (!isset($_GET['phoneID'])){
    die('Iphone არაა არჩეული');
}
$ID =  $_GET['phoneID'];
$output = "";


// Fix -ebi amoviget xmarebidan, droebit. da igive velshi vwert dziritadi cxrilis ID-s
    $sql = "
SELECT i.ID, iFNULL(d1.ValueText,'-') AS model, `PhIMEINumber`, `PhSerialNumber`, iFNULL(d2.ValueText,'-') AS ios, `PhSIMFREE`, `RestrictionPass`, `EncryptionPass`, `ScreenLockPass`, `ScreenLockDate`, `ScreenLockSendDate`, iFNULL(s.Value,'-') AS va, i.`Comment`, i.CreateDate, i.CreateUser, i.ModifyDate, i.ModifyUser FROM `IphoneHistory` i
LEFT JOIN DictionariyItems d1 ON i.`IphoneModelID` = d1.ID
LEFT JOIN DictionariyItems d2 ON i.`IphoneiOSID` = d2.ID
LEFT JOIN States s ON i.`StateID` = s.ID
WHERE IphoneID = $ID
UNION
SELECT i.ID, iFNULL(d1.ValueText,'-') AS model, `PhIMEINumber`, `PhSerialNumber`, iFNULL(d2.ValueText,'-') AS ios, `PhSIMFREE`, `RestrictionPass`, `EncryptionPass`, `ScreenLockPass`, `ScreenLockDate`, `ScreenLockSendDate`, iFNULL(s.Value,'-') AS va, i.`Comment`, i.CreateDate, i.CreateUser, i.ModifyDate, i.ModifyUser FROM `Iphone` i
LEFT JOIN DictionariyItems d1 ON i.`IphoneModelID` = d1.ID
LEFT JOIN DictionariyItems d2 ON i.`IphoneiOSID` = d2.ID
LEFT JOIN States s ON i.`StateID` = s.ID
WHERE i.ID = $ID
";

//echo $sql;

$result = mysqli_query($conn,$sql);

$normTag = '<td class="changed">';
$numbTag = '<td align="right" class="equalsimbols changed">';

$tableHead = '<tr>
                <th>ID</th>
                <th>მოდელი</th>
                <th>IMEI</th>
                <th>სერიული ნომ.</th>
                <th>iOS</th>
                <th>SimFree</th>
                <th>RestrictionPass</th>
                <th>EncryptionPass</th>
                <th>ScreenLockPass</th>
                <th>ScreenLockDate</th>
                <th>ScreenLockSendDate</th>
                <th>სტატუსი</th>
                <th>კომენტარი</th>
                <th>ოპ.თარიღი</th>
                <th>ოპერატორი</th>
            </tr>';

$output = '<table id="tb_agr_hist" class="datatable">'.$tableHead;
$arr = array();
while($row = mysqli_fetch_array($result)) {
    $arr[] = $row;
}
for ($i = count($arr)-2; $i > 0; $i--){
    $arr[$i]['ModifyDate'] = $arr[$i-1]['ModifyDate'];
    $arr[$i]['ModifyUser'] = $arr[$i-1]['ModifyUser'];
}
for ($i = 0; $i< count($arr); $i++){
    $lastRow = $arr[$i];

    if ($i == 0 && $i < count($arr)-1){
        $arr[$i]['ModifyDate'] = $arr[$i]['CreateDate'];
        $arr[$i]['ModifyUser'] = $arr[$i]['CreateUser'];
    }
    $row = $arr[$i];

    if ($i != count($arr)-1){
        $tdID = '<td>';
    }else{
        $tdID = '<td class="mimdinare">';
    }

    $tdmodeli = '<td>';
    $tdimei = '<td>';
    $tdserial = '<td>';
    $tdios = '<td align="right" class="equalsimbols">';
    $tdsimfree = '<td>';
    $tdrPass = '<td align="right" class="equalsimbols">';
    $tdePass = '<td align="right" class="equalsimbols">';
    $tdsPass = '<td align="right" class="equalsimbols">';
    $tdlockdate = '<td align="right" class="equalsimbols">';
    $tdlockdatesend = '<td align="right" class="equalsimbols">';
    $tdst = '<td>';
    $tdcomm = '<td>';
    $tdmoddate = '<td align="right" class="equalsimbols">';
    $tdmoduser = '<td>';

    if ($i>0){
        if ($arr[$i-1]['model'] != $arr[$i]['model'] ){
            $tdmodeli = $normTag;
        }
        if ($arr[$i-1]['PhIMEINumber'] != $arr[$i]['PhIMEINumber'] ){
            $tdimei = $numbTag;
        }
        if ($arr[$i-1]['PhSerialNumber'] != $arr[$i]['PhSerialNumber']){
            $tdserial = $normTag;
        }
        if ($arr[$i-1]['ios'] != $arr[$i]['ios'] ){
            $tdios = $numbTag;
        }
        if ($arr[$i-1]['PhSIMFREE'] != $arr[$i]['PhSIMFREE'] ){
            $tdsimfree = $normTag;
        }
        if ($arr[$i-1]['RestrictionPass'] != $arr[$i]['RestrictionPass'] ){
            $tdrPass = $numbTag;
        }
        if ($arr[$i-1]['EncryptionPass'] != $arr[$i]['EncryptionPass'] ){
            $tdePass = $numbTag;
        }
        if ($arr[$i-1]['ScreenLockPass'] != $arr[$i]['ScreenLockPass']){
            $tdsPass = $numbTag;
        }
        if ($arr[$i-1]['ScreenLockDate'] != $arr[$i]['ScreenLockDate']){
            $tdlockdate = $numbTag;
        }
        if ($arr[$i-1]['ScreenLockSendDate'] != $arr[$i]['ScreenLockSendDate']){
            $tdlockdatesend = $numbTag;
        }
        if ($arr[$i-1]['va'] != $arr[$i]['va']){
            $tdst = $normTag;
        }
        if ($arr[$i-1]['Comment'] != $arr[$i]['Comment'] ){
            $tdcomm = $normTag;
        }
        if ($arr[$i-1]['ModifyDate'] != $arr[$i]['ModifyDate'] ){
            $tdmoddate = $numbTag;
        }
        if ($arr[$i-1]['ModifyUser'] != $arr[$i]['ModifyUser'] ){
            $tdmoduser = $normTag;
        }

    }
    $output .= '
                <tr>
                    '.$tdID.$row["ID"].'</td>
                    '.$tdmodeli.$row["model"].'</td>
                    '.$tdimei.$row["PhIMEINumber"].'</td>
                    '.$tdserial.$row["PhSerialNumber"].'</td>
                    '.$tdios.$row["ios"].'</td>
                    '.$tdsimfree.$row["PhSIMFREE"].'</td>
                    '.$tdrPass.$row["RestrictionPass"].'</td>
                    '.$tdePass.$row["EncryptionPass"].'</td>
                    '.$tdsPass.$row["ScreenLockPass"].'</td>
                    '.$tdlockdate.$row["ScreenLockDate"].'</td>
                    '.$tdlockdatesend.$row["ScreenLockSendDate"].'</td>
                    '.$tdst.$row["va"].'</td>
                    '.$tdcomm.$row["Comment"].'</td>
                    '.$tdmoddate.$row["ModifyDate"].'</td>
                    '.$tdmoduser.$row["ModifyUser"].'</td>                    
                </tr>
                ';
}

$output .= '</table>';

echo '<h3>ტელეფონის ისტორია</h3><br>';
echo $output;

include_once '../footer.php';
$conn -> close();