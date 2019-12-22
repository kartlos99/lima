<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/28/18
 * Time: 1:36 PM
 */
include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])) {
    die("login");
}
$currUserID = $_SESSION['userID'];
$currUser = $_SESSION['username'];
$currDate = date("Y-m-d H:i", time());
$query = "";
$Limit = " 
Limit 20
";

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$pnumber = $_POST['pnumber'];
$username = $_POST['username'];

$digitalTime = time();

$operacia = $_POST['operacia'];

if ($operacia == 2) {
    // ძებნა
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

    $myModules = [];
    if ($_SESSION['usertype'] != null && $_SESSION['usertype'] == 'iCloudGrH'){
      $myModules[] = "userTypeID <> 'null'";
    }
    if ($_SESSION['M2UT'] != null && $_SESSION['M2UT'] == 'administrator'){
        $myModules[] = "userTypeM2 <> 'null'";
    }
    if ($_SESSION['M3UT'] != null && $_SESSION['M3UT'] == 'admin'){
        $myModules[] = "userTypeM3 <> 'null'";
    }
    if ($_SESSION['M4UT'] != null && $_SESSION['M4UT'] == 'administrator'){
        $myModules[] = "userTypeM4 <> 'null'";
    }
    $query .= " AND (" . implode(" OR ", $myModules) . ")";

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
    pmap.UserTypeID,
    `UserTypeM2`, `UserTypeM3`, `UserTypeM4`,
    dim2.Code AS M2UT, dim3.Code AS M3UT, dim4.Code AS M4UT,
    pmap.ID,
    s.value as va,
    pmap.StateID,
    pmap.PersonID
FROM
    `PersonMapping` pmap
LEFT JOIN Persons p ON
    pmap.PersonID = p.ID
LEFT JOIN DictionariyItems di ON
    pmap.UserTypeID = di.ID
LEFT JOIN DictionariyItems dim2 ON
    pmap.UserTypeM2 = dim2.ID
LEFT JOIN DictionariyItems dim3 ON
    pmap.UserTypeM3 = dim3.ID
LEFT JOIN DictionariyItems dim4 ON
    pmap.UserTypeM4 = dim4.ID    
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
    // ახალი მომხმარებელი
    $sql_chek = "SELECT * FROM `PersonMapping` WHERE `UserName` = '$username' ";
    $result1 = mysqli_query($conn, $sql_chek);
    $count = mysqli_num_rows($result1);
    if ($count > 0) {
        die(json_encode('exist'));
    }

    $bday = $_POST['bday'];
    $adress = $_POST['adress'];
    $state = $_POST['state'];
    $organization = $_POST['organization'];
    $branch = $_POST['branch'];
    $pass = $_POST['pass'];
    $comment = $_POST['comment'];
    $tel = $_POST['tel'];
    $personID = $_POST['personid'];

    $type = isset($_POST['ck1']) ? $_POST['type'] : 'null';
    $typeM2 = isset($_POST['ck2']) ? $_POST['m2_type'] : 'null';
    $typeM3 = isset($_POST['ck3']) ? $_POST['m3_type'] : 'null';
    $typeM4 = isset($_POST['ck4']) ? $_POST['m4_type'] : 'null';

    $sql = "
    INSERT
    INTO
      `Persons`(
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
    //echo $sql;
    if (mysqli_query($conn, $sql)) {
        $newuserid = mysqli_insert_id($conn);

        $sql = "
        INSERT INTO
          `PersonMapping`(
            `PersonID`,
            `OrganizationID`,
            `OrganizationBranchID`,
            `Phone`,
            `UserName`,
            `UserPass`,
            `UserTypeID`,
            `UserTypeM2`,
            `UserTypeM3`,
            `UserTypeM4`,
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
        $typeM2,
        $typeM3,
        $typeM4,
        $state,
        '$comment',
        $digitalTime,
        '$currDate',
        '$currUser',
        '$currUserID'
        )
        ";
    }

    if (mysqli_query($conn, $sql)) {
        echo json_encode('ok');
    } else {
        echo mysqli_error($conn);
    }

    //echo $sql;
}

if ($operacia == 3 || $operacia == 4) {

    if ($username != $_POST['h_username']) {
        $sql_chek = "SELECT * FROM `PersonMapping` WHERE `UserName` = '$username' ";
        $result1 = mysqli_query($conn, $sql_chek);
        $count = mysqli_num_rows($result1);
        if ($count > 0) {
            die(json_encode('exist'));
        }
    }

    $bday = $_POST['bday'];
    $adress = $_POST['adress'];
    $state = $_POST['state'];
    $organization = $_POST['organization'];
    $branch = $_POST['branch'];
    $type = isset($_POST['ck1']) ? $_POST['type'] : 'null';
    $typeM2 = isset($_POST['ck2']) ? $_POST['m2_type'] : 'null';
    $typeM3 = isset($_POST['ck3']) ? $_POST['m3_type'] : 'null';
    $typeM4 = isset($_POST['ck4']) ? $_POST['m4_type'] : 'null';
    $pass = $_POST['pass'];
    $comment = $_POST['comment'];
    $tel = $_POST['tel'];
    $personID = $_POST['personid'];

    $sql = "
    UPDATE
      `PersonMapping`
    SET
      `OrganizationID` = $organization,
      `OrganizationBranchID` = $branch,
      `Phone` = '$tel',
      `UserName` = '$username',
      `UserTypeID` = $type,
      `UserTypeM2` = $typeM2,
      `UserTypeM3` = $typeM3,
      `UserTypeM4` = $typeM4,
      `StateID` = $state,
      `Comment` = '$comment',      
      `ModifyDate` = '$currDate',
      `ModifyUser` = '$currUser',
      `ModifyUserID` = '$currUserID'
    WHERE
      `PersonID` = $personID  
    ";

    if ($operacia == 4) {
        $sql = "
        UPDATE
          `PersonMapping`
        SET
          `OrganizationID` = $organization,
          `OrganizationBranchID` = $branch,
          `Phone` = '$tel',
          `UserName` = '$username',
          `UserPass` = '$pass',
          `UserTypeID` = $type,
          `UserTypeM2` = $typeM2,
          `UserTypeM3` = $typeM3,
          `UserTypeM4` = $typeM4,
          `StateID` = $state,
          `Comment` = '$comment',
          `PassDate` = $digitalTime,  
          `ModifyDate` = '$currDate',
          `ModifyUser` = '$currUser',
          `ModifyUserID` = '$currUserID'
        WHERE
          `PersonID` = $personID  
        ";
    }

    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
        echo $sql;
    }

    $sql = "
    UPDATE
      `Persons`
    SET
      `PrivateNumber` = '$pnumber',
      `LastName` = '$lastname',
      `FirstName` = '$firstname',
      `BirthDate` = '$bday',
      `LegalAdress` = '$adress',
      `Comment` = '$comment',
      `ModifyDate` = '$currDate',
      `ModifyUser` = '$currUser',
      `ModifyUserID` = '$currUserID'
    WHERE
      ID = $personID  
    ";

    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
    }
    echo json_encode('ok');
}

$conn->close();