<?php

include_once '../config.php';
session_start();

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());

$orgID = $_POST['organization'];
$branchID = 1; //$_POST['branch'];
$agrN = $_POST['agrN'];
$startdate = $_POST['agrStart'];
//$finishdate = $_POST['agrFinish'];
$status = $_POST['status'];
$comment = $_POST['comment'];

$currDate = 'CURRENT_TIMESTAMP';
$currUser = $_SESSION['username'];
$currUserID = $_SESSION['userID'];
//print_r($_POST);
//print_r($_SESSION);

if (strlen($agrN) > 0){
    $sql_chek = "SELECT * FROM `Agreements` WHERE Number = '$agrN'";
    $result1 = mysqli_query($conn, $sql_chek);
    $count = mysqli_num_rows($result1);
}


if ($count > 0) {
    echo('aseti nomrit ukve registrirebulia xelshekruleba!');
} else {

    $sql = "
    INSERT
    INTO
      `Agreements`(
        `OrganizationID`,
        `OrganizationBranchID`,
        `Number`,
        `Date`,
        `Startdate`,
        `AgreementPersonMappingID`,
        `TypeID`,
        `StateID`,
        `Comment`,
        `CreateDate`,
        `CreateUser`,
        `CreateUserID`
      )
    VALUES(
      $orgID,
      $branchID,
      '$agrN',
      $currDate,
      '$startdate',
      $currUserID,
      gettypeid('iphone_tarebit', getobjid('Agreements')),
      $status,
      '$comment',
      $currDate,
      '$currUser',
      $currUserID
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