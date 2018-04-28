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
";

//echo $sql;

$result = mysqli_query($conn,$sql);


$tableHead = '<tr>
                <th>ID</th>
                <th>ორგანიზაცია</th>
                <th>ფილიალი</th>
                <th>ხელშეკრ.N</th>
                <th>ხელშეკრ. თარიღი</th>
                <th>დაწყების თარიღი</th>
                <th>დასრულების თარიღი</th>
                <th>შეწყვეტის თარიღი</th>
                <th>მომხმარებელი</th>
                <th>IMEI</th>
                <th>ApplID</th>
                <th>სტატუსი</th>
                <th>კომენტარი</th>
                <th>შექმნის თარიღი</th>
                <th>ვინ შემქმნა</th>
                <th>რედაქტირების თარიღი</th>
                <th>ვინ დაარედაქტირა</th>
            </tr>';

$output = '<table id="tb_agr_hist" class="datatable">'.$tableHead;

$arr = array();

while($row = mysqli_fetch_array($result)) {
    $arr[] = $row;
}

for ($i = 0; $i< count($arr); $i++){
    $lastRow = $arr[$i];
    $row = $arr[$i];
    if ($i>0 && $i < count($arr)-1){
        if (!($arr[$i-1]['OrganizationName'] != $arr[$i]['OrganizationName'] || $arr[$i+1]['OrganizationName'] != $arr[$i]['OrganizationName'])){
            $row['OrganizationName'] = "";
        }
        if (!($arr[$i-1]['BranchName'] != $arr[$i]['BranchName'] || $arr[$i+1]['BranchName'] != $arr[$i]['BranchName'])){
            $row['BranchName'] = "";
        }
        if (!($arr[$i-1]['Number'] != $arr[$i]['Number'] || $arr[$i+1]['Number'] != $arr[$i]['Number'])){
            $row['Number'] = "";
        }
        if (!($arr[$i-1]['Date'] != $arr[$i]['Date'] || $arr[$i+1]['Date'] != $arr[$i]['Date'])){
            $row['Date'] = "";
        }
        if (!($arr[$i-1]['Startdate'] != $arr[$i]['Startdate'] || $arr[$i+1]['Startdate'] != $arr[$i]['Startdate'])){
            $row['Startdate'] = "";
        }
        if (!($arr[$i-1]['EndDate'] != $arr[$i]['EndDate'] || $arr[$i+1]['EndDate'] != $arr[$i]['EndDate'])){
            $row['EndDate'] = "";
        }
        if (!($arr[$i-1]['RevokeDate'] != $arr[$i]['RevokeDate'] || $arr[$i+1]['RevokeDate'] != $arr[$i]['RevokeDate'])){
            $row['RevokeDate'] = "";
        }
        if (!($arr[$i-1]['username'] != $arr[$i]['username'] || $arr[$i+1]['username'] != $arr[$i]['username'])){
            $row['username'] = "";
        }
        if (!($arr[$i-1]['imei'] != $arr[$i]['imei'] || $arr[$i+1]['imei'] != $arr[$i]['imei'])){
            $row['imei'] = "";
        }
        if (!($arr[$i-1]['applid'] != $arr[$i]['applid'] || $arr[$i+1]['applid'] != $arr[$i]['applid'])){
            $row['applid'] = "";
        }
        if (!($arr[$i-1]['va'] != $arr[$i]['va'] || $arr[$i+1]['va'] != $arr[$i]['va'])){
            $row['va'] = "";
        }
        if (!($arr[$i-1]['Comment'] != $arr[$i]['Comment'] || $arr[$i+1]['Comment'] != $arr[$i]['Comment'])){
            $row['Comment'] = "";
        }
        if (!($arr[$i-1]['CreateDate'] != $arr[$i]['CreateDate'] || $arr[$i+1]['CreateDate'] != $arr[$i]['CreateDate'])){
            $row['CreateDate'] = "";
        }
        if (!($arr[$i-1]['CreateUser'] != $arr[$i]['CreateUser'] || $arr[$i+1]['CreateUser'] != $arr[$i]['CreateUser'])){
            $row['CreateUser'] = "";
        }
        if (!($arr[$i-1]['ModifyDate'] != $arr[$i]['ModifyDate'] || $arr[$i+1]['ModifyDate'] != $arr[$i]['ModifyDate'])){
            $row['ModifyDate'] = "";
        }
        if (!($arr[$i-1]['ModifyUser'] != $arr[$i]['ModifyUser'] || $arr[$i+1]['ModifyUser'] != $arr[$i]['ModifyUser'])){
            $row['ModifyUser'] = "";
        }

    }
    $output .= '
                <tr>
                    <td>'.$row["ID"].'</td>
                    <td>'.$row["OrganizationName"].'</td>
                    <td>'.$row["BranchName"].'</td>
                    <td align="right" class="equalsimbols">'.$row["Number"].'</td>
                    <td align="right" class="equalsimbols">'.$row["Date"].'</td>
                    <td align="right" class="equalsimbols">'.$row["Startdate"].'</td>
                    <td align="right" class="equalsimbols">'.$row["EndDate"].'</td>
                    <td align="right" class="equalsimbols">'.$row["RevokeDate"].'</td>
                    <td>'.$row["username"].'</td>
                    <td align="right" class="equalsimbols">'.$row["imei"].'</td>
                    <td align="right" class="ricxvi">'.$row["applid"].'</td>
                    <td>'.$row["va"].'</td>
                    <td>'.$row["Comment"].'</td>
                    <td align="right" class="equalsimbols">'.$row["CreateDate"].'</td>
                    <td>'.$row["CreateUser"].'</td>
                    <td align="right" class="equalsimbols">'.$row["ModifyDate"].'</td>
                    <td>'.$row["ModifyUser"].'</td>                    
                </tr>
                ';
}

$output .= '</table>';

//echo $sql;
//echo(json_encode($arr));
echo $output;

include_once '../administrator/footer.php';
$conn -> close();