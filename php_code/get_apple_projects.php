<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';

    $sql = "
SELECT a.id, o.OrganizationName, br.BranchName, e.EmEmail, a.CreateDate, a.CreateUser, s.Value AS va FROM `ApplID` a
LEFT JOIN Organizations o ON a.OrganizationID = o.ID
LEFT JOIN OrganizationBranches br ON a.OrganizationBranchID = br.ID
LEFT JOIN Emails e ON a.AplAccountEmailID = e.ID
LEFT JOIN States s ON a.StateID = s.ID
WHERE s.Code = 'Project'
    ";

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();