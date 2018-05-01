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
if (!isset($_GET['aplID'])){
    die('ApplID არაა არჩეული');
}
$ID =  $_GET['aplID'];
$output = "";


// Fix -ebi amoviget xmarebidan, droebit. da igive velshi vwert dziritadi cxrilis ID-s
    $sql = "
SELECT a.ID, o.OrganizationName, AplFirstName, AplLastName, AplCountry, AplBirthDay, AplApplID, AplPassword, IFNULL(d1.ValueText, '-') AS q1, AplSequrityQuestion1Answer AS ans1, IFNULL(d2.ValueText,'-') AS q2, AplSequrityQuestion2Answer AS ans2, IFNULL(d3.ValueText,'-') AS q3, AplSequrityQuestion3Answer AS ans3, IFNULL(e.EmEmail,'-') AS Rmail, s.value AS va, a.Comment, a.CreateDate, a.CreateUser, a.ModifyDate, a.ModifyUser FROM `ApplIDHistory` a 
LEFT JOIN Organizations o ON a.OrganizationID = o.ID
LEFT JOIN Emails e ON a.`AplRescueEmailID` = e.ID
LEFT JOIN DictionariyItems d1 ON a.AplSequrityQuestion1ID = d1.ID
LEFT JOIN DictionariyItems d2 ON a.AplSequrityQuestion2ID = d2.ID
LEFT JOIN DictionariyItems d3 ON a.AplSequrityQuestion3ID = d3.ID
LEFT JOIN States s ON a.`StateID` = s.ID
WHERE ApplIDID = $ID
UNION
SELECT a.ID, o.OrganizationName, AplFirstName, AplLastName, AplCountry, AplBirthDay, AplApplID, AplPassword, IFNULL(d1.ValueText, '-') AS q1, AplSequrityQuestion1Answer AS ans1, IFNULL(d2.ValueText,'-') AS q2, AplSequrityQuestion2Answer AS ans2, IFNULL(d3.ValueText,'-') AS q3, AplSequrityQuestion3Answer AS ans3, IFNULL(e.EmEmail,'-') AS Rmail, s.value AS va, a.Comment, a.CreateDate, a.CreateUser, a.ModifyDate, a.ModifyUser FROM `ApplID` a 
LEFT JOIN Organizations o ON a.OrganizationID = o.ID
LEFT JOIN Emails e ON a.`AplRescueEmailID` = e.ID
LEFT JOIN DictionariyItems d1 ON a.AplSequrityQuestion1ID = d1.ID
LEFT JOIN DictionariyItems d2 ON a.AplSequrityQuestion2ID = d2.ID
LEFT JOIN DictionariyItems d3 ON a.AplSequrityQuestion3ID = d3.ID
LEFT JOIN States s ON a.`StateID` = s.ID
WHERE a.ID = $ID
";

//echo $sql;

$result = mysqli_query($conn,$sql);

$normTag = '<td class="changed">';
$numbTag = '<td align="right" class="equalsimbols changed">';

$tableHead = '<tr>
                <th>ID</th>
                <th>ორგანიზაცია</th>
                <th>სახელი</th>
                <th>გვარი</th>
                <th>ქვეყანა</th>
                <th>დაბადების თარიღი</th>
                <th>ApplID</th>
                <th>პაროლი</th>
                <th>კითხვა1</th>
                <th>პასუხი1</th>
                <th>კითხვა2</th>
                <th>პასუხი2</th>
                <th>კითხვა3</th>
                <th>პასუხი3</th>
                <th>დამ.მაილი</th>
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
    $tdname = '<td>';
    $tdlastname = '<td>';
    $tdbdate = '<td align="right" class="equalsimbols">';
    $tdcontry = '<td>';
    $tdapplid = '<td align="right" class="equalsimbols">';
    $tdpass = '<td align="right" class="equalsimbols">';
    $tdq1 = '<td>';
    $tda1 = '<td>';
    $tdq2 = '<td>';
    $tda2 = '<td>';
    $tdq3 = '<td>';
    $tda3 = '<td>';
    $tdrmail = '<td>';
    $tdst = '<td>';
    $tdcomm = '<td>';
    $tdmoddate = '<td align="right" class="equalsimbols">';
    $tdmoduser = '<td>';

    if ($i>0){
        if ($arr[$i-1]['OrganizationName'] != $arr[$i]['OrganizationName'] ){
            $tdOrg = $normTag;
        }
        if ($arr[$i-1]['AplFirstName'] != $arr[$i]['AplFirstName'] ){
            $tdBr = $normTag;
        }
        if ($arr[$i-1]['AplLastName'] != $arr[$i]['AplLastName']){
            $tdnumb = $normTag;
        }
        if ($arr[$i-1]['AplCountry'] != $arr[$i]['AplCountry'] ){
            $tdcontry = $normTag;
        }
        if ($arr[$i-1]['AplBirthDay'] != $arr[$i]['AplBirthDay'] ){
            $tdbdate = $numbTag;
        }
        if ($arr[$i-1]['AplApplID'] != $arr[$i]['AplApplID'] ){
            $tdapplid = $normTag;
        }
        if ($arr[$i-1]['AplPassword'] != $arr[$i]['AplPassword'] ){
            $tdpass = $numbTag;
        }
        if ($arr[$i-1]['q1'] != $arr[$i]['q1']){
            $tdq1 = $normTag;
        }
        if ($arr[$i-1]['ans1'] != $arr[$i]['ans1']){
            $tda1 = $normTag;
        }
        if ($arr[$i-1]['q2'] != $arr[$i]['q2']){
            $tdq2 = $normTag;
        }
        if ($arr[$i-1]['ans2'] != $arr[$i]['ans2']){
            $tda2 = $normTag;
        }
        if ($arr[$i-1]['q3'] != $arr[$i]['q3']){
            $tdq3 = $normTag;
        }
        if ($arr[$i-1]['ans3'] != $arr[$i]['ans3']){
            $tda3 = $normTag;
        }
        if ($arr[$i-1]['Rmail'] != $arr[$i]['Rmail']){
            $tdrmail = $normTag;
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
                    '.$tdname.$row["OrganizationName"].'</td>
                    '.$tdlastname.$row["AplFirstName"].'</td>
                    '.$tdlastname.$row["AplLastName"].'</td>
                    '.$tdcontry.$row["AplCountry"].'</td>
                    '.$tdbdate.$row["AplBirthDay"].'</td>
                    '.$tdapplid.$row["AplApplID"].'</td>
                    '.$tdpass.$row["AplPassword"].'</td>
                    '.$tdq1.$row["q1"].'</td>
                    '.$tda1.$row["ans1"].'</td>
                    '.$tdq2.$row["q2"].'</td>
                    '.$tda2.$row["ans2"].'</td>
                    '.$tdq3.$row["q3"].'</td>
                    '.$tda3.$row["ans3"].'</td>
                    '.$tdrmail.$row["Rmail"].'</td>
                    '.$tdst.$row["va"].'</td>
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