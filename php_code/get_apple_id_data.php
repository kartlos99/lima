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

$orgID = 0;

$id = $_GET['id'];
if ($id == 0){
    $orgID = $_GET['orgid'];
    $branchID = $_GET['branchID'];

    $sql = "
    SELECT
            ap.ID
        FROM
            `ApplID` ap
        LEFT JOIN States st ON
            ap.StateID = st.ID
        
        WHERE
            st.Code = 'Active' 
            AND SUBSTRING_INDEX(AplApplID, '@', -1) = ANY 
        		(SELECT `DomainName` FROM `Domains` WHERE `OrganizationBranchID` = $branchID)
            AND ap.`OrganizationID` = $orgID 
            AND UNIX_TIMESTAMP() - ap.reservDate > (select valueint from DictionariyItems where CODE = 'reserv_period')
            AND 'Active' <> ALL(
            SELECT
                agst.Code
            FROM
                Agreements ag    
            LEFT JOIN States agst ON
                ag.StateID = agst.ID
            WHERE ag.ApplIDFixID = ap.ID
        	) AND 'Project' <> ALL(
            SELECT
                agst.Code
            FROM
                Agreements ag    
            LEFT JOIN States agst ON
                ag.StateID = agst.ID
            WHERE ag.ApplIDFixID = ap.ID
        	)
        ORDER BY
            RAND()
        LIMIT 1
    ";

    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    $arr = [];
    if ($count > 0){
        foreach($result as $row){
            $arr[] = $row;
        }
        //$num = rand(1,$count);
        $id = $arr[0]['ID'];
    }else{
       // echo "ar moidzebna tavisufali applID!";
    }
}

if ($id != 0){

        $sql = "
    SELECT a.*, e.EmEmailPass FROM `ApplID` a JOIN Emails e
    ON a.`AplAccountEmailID` = e.ID
    WHERE a.ID = $id
        ";

    $result = mysqli_query($conn,$sql);

    $arr = array();
    foreach($result as $row){
        $arr[] = $row;
    }

    echo(json_encode($arr));
}

$conn -> close();
?>