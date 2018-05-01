<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
//include_once '../config.php';
include_once '../administrator/header_1.php';
//session_start();
//$currUserID = $_SESSION['userID'];

//$agrN =  $_POST['agrN'];
if (!isset($_GET['agrID'])){
    die('ხელშეკრულება არაა არჩეული');
}
$agrID =  $_GET['agrID'];
$output = "";


// Fix -ebi amoviget xmarebidan, droebit. da igive velshi vwert dziritadi cxrilis ID-s
    $sql = "
SELECT a.ID, o.OrganizationName, b.`BranchName`, a.Number, a.`Date`, a.`Startdate`, a.EndDate, RevokeDate, p.username, IFNULL(i.PhIMEINumber, '-') AS imei, IFNULL(apl.AplApplID, '-') AS applid, s.value AS va, a.Comment, a.CreateDate, a.CreateUser, a.ModifyDate, a.ModifyUser FROM `AgreementsHistory` a
LEFT JOIN States s ON a.`StateID` = s.ID
LEFT JOIN Iphone i ON a.`IphoneFixID` = i.ID
LEFT JOIN DictionariyItems d ON i.IphoneModelID = d.ID
LEFT JOIN ApplID apl ON a.`ApplIDFixID` = apl.ID
LEFT JOIN Organizations o ON a.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b ON a.OrganizationBranchID = b.ID
LEFT JOIN PersonMapping p ON a.`AgreementPersonMappingID` = p.ID
WHERE `AgreementID` = $agrID
UNION
SELECT a.ID, o.OrganizationName, b.`BranchName`, a.Number, a.`Date`, a.`Startdate`, a.EndDate, RevokeDate, p.username, IFNULL(i.PhIMEINumber, '-') AS imei, IFNULL(apl.AplApplID, '-') AS applid, s.value AS va, a.Comment, a.CreateDate, a.CreateUser, a.ModifyDate, a.ModifyUser FROM `Agreements` a
LEFT JOIN States s ON a.`StateID` = s.ID
LEFT JOIN Iphone i ON a.`IphoneFixID` = i.ID
LEFT JOIN DictionariyItems d ON i.IphoneModelID = d.ID
LEFT JOIN ApplID apl ON a.`ApplIDFixID` = apl.ID
LEFT JOIN Organizations o ON a.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b ON a.OrganizationBranchID = b.ID
LEFT JOIN PersonMapping p ON a.`AgreementPersonMappingID` = p.ID
WHERE a.ID = $agrID
";

//echo $sql;

$result = mysqli_query($conn,$sql);


$tableHead = '<tr>
                <th>ID</th>
                <th>ორგანიზაცია</th>
                <th>ფილიალი</th>
                <th>ხელშეკრ.N</th>
                <th>გაფორმების თარიღი</th>
                <th>დასრულების თარიღი</th>
                <th>IMEI</th>
                <th>ApplID</th>
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

    $tdOrg = '<td>';
    $tdBr = '<td>';
    $tdnumb = '<td align="right" class="equalsimbols">';
    $tddate = '<td align="right" class="equalsimbols">';
    $tdenddate = '<td align="right" class="equalsimbols">';
    $tdimei = '<td align="right" class="equalsimbols">';
    $tdapplid = '<td align="right" class="equalsimbols">';
    $tdval = '<td>';
    $tdcomm = '<td>';
    $tdmoddate = '<td align="right" class="equalsimbols">';
    $tdmoduser = '<td>';

    if ($i>0){
        if ($arr[$i-1]['OrganizationName'] != $arr[$i]['OrganizationName'] ){
            $tdOrg = '<td class="changed">';
        }
        if ($arr[$i-1]['BranchName'] != $arr[$i]['BranchName'] ){
            $tdBr = '<td class="changed">';
        }
        if ($arr[$i-1]['Number'] != $arr[$i]['Number']){
            $tdnumb = '<td align="right" class="equalsimbols changed">';
        }
        if ($arr[$i-1]['Date'] != $arr[$i]['Date'] ){
            $tddate = '<td align="right" class="equalsimbols changed">';
        }
        if ($arr[$i-1]['EndDate'] != $arr[$i]['EndDate'] ){
            $tdenddate = '<td align="right" class="equalsimbols changed">';
        }
        if ($arr[$i-1]['imei'] != $arr[$i]['imei'] ){
            $tdimei = '<td align="right" class="equalsimbols changed">';
        }
        if ($arr[$i-1]['applid'] != $arr[$i]['applid'] ){
            $tdapplid = '<td align="right" class="equalsimbols changed">';
        }
        if ($arr[$i-1]['va'] != $arr[$i]['va']){
            $tdval = '<td class="changed">';
        }
        if ($arr[$i-1]['Comment'] != $arr[$i]['Comment'] ){
            $tdcomm = '<td class="changed">';
        }
        if ($arr[$i-1]['ModifyDate'] != $arr[$i]['ModifyDate'] ){
            $tdmoddate = '<td align="right" class="equalsimbols changed">';
        }
        if ($arr[$i-1]['ModifyUser'] != $arr[$i]['ModifyUser'] ){
            $tdmoduser = '<td class="changed">';
        }

    }
    $output .= '
                <tr>
                    '.$tdID.$row["ID"].'</td>
                    '.$tdOrg.$row["OrganizationName"].'</td>
                    '.$tdBr.$row["BranchName"].'</td>
                    '.$tdnumb.$row["Number"].'</td>
                    '.$tddate.$row["Date"].'</td>
                    '.$tdenddate.$row["EndDate"].'</td>
                    '.$tdimei.$row["imei"].'</td>
                    '.$tdapplid.$row["applid"].'</td>
                    '.$tdval.$row["va"].'</td>
                    '.$tdcomm.$row["Comment"].'</td>
                    '.$tdmoddate.$row["ModifyDate"].'</td>
                    '.$tdmoduser.$row["ModifyUser"].'</td>                    
                </tr>
                ';
}

$output .= '</table>';

//echo $sql;
//echo(json_encode($arr));
echo $output;

include_once '../administrator/footer.php';
$conn -> close();