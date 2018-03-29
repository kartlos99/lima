<?php

include_once '../config.php';

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time());
$name = $_POST['name'];
$lastName = $_POST['lv1'];

print_r($_POST);

$sql = "INSERT
INTO
  `persons`(
    `ID`,
    `EntityObjectID`,
    `PrivateNumber`,
    `LastName`,
    `FirstName`,
    `BirthDate`,
    `LegalAdress`,
    `IsUser`,
    `IsEmployee`,
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
  '',
  2,
  '60002007000',
  '$lastName',
  '$name',
  '2018-01-01',
  'misamarti',
  1,
  0,
  0,
  'comentari',
  '$tarigiSt',
  'me',
  1,
  '$tarigiDt',
  '',
  0
)";

//$result = mysqli_query($conn,$sql);

$conn ->close();

?>