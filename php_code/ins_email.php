<?php

include_once '../config.php';
session_start();

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$domainName = 'gettere';

$orgID = $_POST['organization'];
$branchID = 1;//$_POST['branch'];
$domainID = $_POST['domain'];
$emEmail = $_POST['email'];
$emailPass = $_POST['password'];
$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
//print_r($_POST);
//print_r($_SESSION);

$sql = "
INSERT
INTO
  `emails`(
    `EntityObjectID`,
    `OrganizationID`,
    `OrganizationBranchID`,
    `DomainID`,
    `EmEmail`,
    `EmEmailPass`,
    `EmEmailDate`,
    `TypeID`,
    `StateID`,
    `Comment`,
    `CreateDate`,
    `CreateUser`,
    `CreateUserID`,
    `ModifyDate`,
    `ModifyUser`,
    `ModifyUserID`
  )
VALUES(
  15,
  $orgID,
  $branchID,
  $domainID,
  '$emEmail',
  '$emailPass',
  $currDate,
  0,
  0,
  '',
  $currDate,
  '$currUser',
  $currUserID,
  '',
  '',
  0
)
";

$result = mysqli_query($conn,$sql);
if ($result){
    echo 'ok';
}else{
    echo $sql;
}

$conn ->close();

?>