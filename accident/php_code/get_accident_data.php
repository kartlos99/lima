<?php

session_start();
include_once '../../config.php';

if (!isset($_SESSION['username'])) {
    die("login");
}
$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
$resultArray = [];

$recID = $_GET['id'];

$sql_select_accident = "SELECT
    im.`ID`,
    LPAD(im.ID, 5, '0') AS accidentN,
    `TypeID`,
    `PriorityID`,
    `StatusID`,
    `OwnerID`,
    `OrgID`,
    `OrgBranchID`,
    `AgrNumber`,
    Date(`FactDate`) AS FactDate,
    Time(`FactDate`) AS FactDateTime,
    `DiscovererID`,
    Date(`DiscoverDate`) AS DiscoverDate,
    Time(`DiscoverDate`) AS DiscoverDateTime,
    `CategoryID`,
    `SubCategoryID`,
    `CategoryOther`,
    `SubCategoryOther`,
    `RequetsDescription`,
    `SolverID`,
    `DurationDeys`,
    `DurationHours`,
    Date(`SolveDate`) AS SolveDate,
    Time(`SolveDate`) AS SolveDateTime,
    `SolvDescription`,
    `NotInStatistics`,
    Date(im.`CreateDate`) AS CreateDate,
    im.`CreateUser`,
    im.`UpdateDate`,
    im.`UpdateUser`,
    per.UserName AS ownerName
FROM
    `im_request` im
LEFT JOIN PersonMapping per
ON im.OwnerID = per.ID

WHERE
    im.ID = $recID";


$sql_select_gPersons = "SELECT
    gp.`ID`,
    `IM_RequestID`,
    `IM_PersonsID`,
    concat(p.FirstName, ' ', p.LastName) AS gPersonName,
    gp.`StatusID`,
    di.ValueText,
    gp.`CreateDate`,
    gp.`CreateUser`    
FROM
    `im_guilty_persons` gp
LEFT JOIN dictionariyitems di 
ON di.ID = gp.`StatusID`
LEFT JOIN im_persons p 
ON p.ID = gp.`IM_PersonsID`

WHERE
    di.Code = 'active' AND gp.`IM_RequestID` = $recID";

$resultArray['sql'] = $sql_select_accident;

$result1 = mysqli_query($conn, $sql_select_accident);
$result2 = mysqli_query($conn, $sql_select_gPersons);

$gPersons = [];
foreach($result1 as $row){
    $resultArray['accident'] = $row;
}
foreach($result2 as $row){
    $gPersons[] = $row;
}

$resultArray['gPersons'] = $gPersons;

echo(json_encode($resultArray));