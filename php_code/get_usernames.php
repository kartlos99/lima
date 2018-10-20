<?php

include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}

    $sql = "
    SELECT
    pmap.UserName,
    pmap.`OrganizationID`,
    pmap.`OrganizationBranchID`,
    pmap.UserTypeID,
    pmap.ID,
    ifnull(s.Code, 'unnoun') as code    
FROM
    `PersonMapping` pmap
LEFT JOIN States s ON
	pmap.StateID = s.ID
WHERE
    code = 'Active'
ORDER BY
    UserName    
    ";

$result = mysqli_query($conn,$sql);

$arr = array();
foreach($result as $row){
    $arr[] = $row;
}

echo(json_encode($arr));

$conn -> close();