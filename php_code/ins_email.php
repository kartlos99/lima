<?php

include_once '../config.php';
session_start();

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$domainName = 'gettere';

$orgID = $_POST['organization'];
$branchID = $_POST['branch'];
$domainID = $_POST['domain'];
$emEmail = $_POST['email'];
$emailPass = $_POST['password'];
$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
//print_r($_POST);
//print_r($_SESSION);

$sql_chek = "SELECT checkmail('".$emEmail."',$domainID) AS num ";
$result1 = mysqli_query($conn, $sql_chek);
$arr = mysqli_fetch_assoc($result1);
$count = $arr['num'];

if ($count > 0) {
    echo('mail alredy exists!');
} else {

    $sql = "
        INSERT
        INTO
          `Emails`(
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
          0,
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

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo mysqli_insert_id($conn); //'ok';
    } else {
        echo $sql;//'myerror';
    }
}

$conn->close();

?>