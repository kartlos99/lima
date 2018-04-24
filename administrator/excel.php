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
$currUserID = $_SESSION['userID'];

$allFields = "SELECT a.ID, a.Number, Date(a.Date) AS Date, s.Value AS status, IFNULL(i.PhIMEINumber, '-') AS IMEI, IFNULL(d.ValueText, '-') AS Model, IFNULL(apl.AplApplID, '-') AS ApplID, o.OrganizationName, b.BranchName ";
$sql = "FROM `Agreements` a
LEFT JOIN States s ON a.`StateID` = s.ID
LEFT JOIN Iphone i ON a.`IphoneFixID` = i.ID
LEFT JOIN DictionariyItems d ON i.IphoneModelID = d.ID
LEFT JOIN ApplID apl ON a.`ApplIDFixID` = apl.ID
LEFT JOIN Organizations o ON a.OrganizationID = o.ID
LEFT JOIN OrganizationBranches b ON a.OrganizationBranchID = b.ID

limit 25";
$sql = $allFields . $sql;

$output = '';
$dges = date("Y-m-d", time());
$myobj = "a";

if (isset($_GET["query"])) {

        $result = $conn->query($sql);

        if (mysqli_num_rows($result) > 0) {

            $output .= '<table bordered="3">
                <tr>
                    <th>ხელშეკრ.N</th>
                    <th>ხელშეკრ. თარიღი</th>
                    <th>ხელშეკრ. სტატუსი</th>
                    <th>IMEI</th>
                    <th>ტელეფონი</th>
                    <th>ApplID</th>
                    <th>ორგანიზაცია/ფილიალი</th>
                </tr>
            ';

            while ($row = mysqli_fetch_array($result)) {
                $output .= '
                <tr>
                    <td>' . $row["Number"] . '</td>
                    <td>' . $row["Date"] . '</td>
                    <td>' . $row["status"] . '</td>
                    <td>' . $row["IMEI"] . '</td>
                    <td>' . $row["Model"] . '</td>
                    <td>' . $row["ApplID"] . '</td>
                    <td>' . $row["OrganizationName"] . '</td>
                    <td>' . $row["BranchName"] . '</td>
                </tr>
                ';
            }

            $output .= '</table>';
            $fileName = "agreements";
        }

    //header("Content-Type: application/xls");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$fileName.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $output;

}

//echo json_encode($arr);
mysqli_close($conn);
?>