<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';
session_start();
$currUserID = $_SESSION['userID'];
$currUser = $_SESSION['username'];
$currDate = date("Y-m-d H:i", time());
$query = "";
$Limit=" 
Limit 20
";

$operacia = $_POST['operacia'];

if ($operacia == 2) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $pnumber = $_POST['pnumber'];
    $username = $_POST['username'];


    if ($firstname != "") {
        $query = $query . " and p.FirstName like ('$firstname%')";
    }
    if ($lastname != "") {
        $query = $query . " and p.LastName like ('$lastname%') ";
    }
    if ($pnumber != "") {
        $query = $query . " and p.PrivateNumber like ('$pnumber%')";
    }
    if ($username != "") {
        $query = $query . " and pmap.UserName like ('$username%')";
    }

    $sql = "
    SELECT
    p.LastName,
    p.FirstName,
    p.LegalAdress,
    p.PrivateNumber,
    p.BirthDate,
    p.Comment,
    pmap.UserName,
    pmap.`OrganizationID`,
    pmap.`OrganizationBranchID`,
    pmap.`Phone`,
    di.Code AS UserType,
    pmap.ID,
    s.value as va,
    pmap.StateID
FROM
    `PersonMapping` pmap
LEFT JOIN Persons p ON
    pmap.PersonID = p.ID
LEFT JOIN DictionariyItems di ON
    pmap.UserTypeID = di.ID
LEFT JOIN States s ON
	pmap.StateID = s.ID
WHERE
    pmap.ID > 0
";

    $sql = $sql . $query . $Limit;

//echo $sql;

    $result = mysqli_query($conn, $sql);

    $arr = array();
    foreach ($result as $row) {
        $arr[] = $row;
    }

//echo $sql;
    echo(json_encode($arr));

}

if ($operacia == 1) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $pnumber = $_POST['pnumber'];
    $username = $_POST['username'];
    $bday = $_POST['bday'];
    $adress = $_POST['adress'];
    $state = $_POST['state'];
    $organization = $_POST['organization'];
    $branch = $_POST['branch'];
    $type = $_POST['type'];
    $pass = $_POST['pass'];
    $comment = $_POST['comment'];
    $tel = $_POST['tel'];

    $sql = "
    INSERT
    INTO
      `persons`(
        `PrivateNumber`,
        `LastName`,
        `FirstName`,
        `BirthDate`,
        `LegalAdress`,
        `StateID`,
        `Comment`,
        `CreateDate`,
        `CreateUser`,
        `CreateUserID`    
      )
    VALUES(
    '$pnumber',
    '$lastname',
    '$firstname',
    '$bday',
    '$adress',
    getstateid('Active',getobjid('Persons')),
    '$comment',
    '$currDate',
    '$currUser',
    '$currUserID'
    )
    ";

    $digital_time = time();

    if (mysqli_query($conn, $sql)){
        $newuserid = mysqli_insert_id($conn);

        $sql = "
        INSERT INTO
          `personmapping`(
            `PersonID`,
            `OrganizationID`,
            `OrganizationBranchID`,
            `Phone`,
            `UserName`,
            `UserPass`,
            `UserTypeID`,
            `StateID`,
            `Comment`,
            `PassDate`,
            `CreateDate`,
            `CreateUser`,
            `CreateUserID`
          )
        VALUES(
        $newuserid,
        $organization,
        $branch,
        '$tel',
        '$username',
        '$pass',
        $type,
        $state,
        '$comment',
        '$digital_time',
        '$currDate',
        '$currUser',
        '$currUserID'
        )
        ";
    }

    if (mysqli_query($conn, $sql)){
        echo 'ok';
    }else {
        echo mysqli_error($conn);
    }

    echo $sql;
}

$conn -> close();