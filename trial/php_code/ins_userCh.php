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

$resultArray['post'] = $_POST;
//die(json_encode($resultArray));

$old_owner_id = $_POST['old_owner_id'];
$new_owner = $_POST['new_owner'];
$comment_D1 = $_POST['comment_D1'];
$caseID = $_POST['caseID'];


    $sql = "
INSERT INTO `pcm_aplication_ownerchangehistory`(
    `OwnerOldID`,
    `OwnerNewID`,
    `OwnChangeDate`,
    `OwnChangeReason`,
    `OwnerChangeUserID`,
    `caseID`
)
VALUES(
    $old_owner_id,
    $new_owner,
    $currDate,
    '$comment_D1',
    $currUserID,
    $caseID
)
";

$sql_updateCase = "
UPDATE
    `pcm_aplication`
SET
    `OwnerID` = $new_owner,
    `OwnDate` = $currDate
where
    ID = $caseID
    ";

    $result = mysqli_query($conn, $sql);
    $result_upd = mysqli_query($conn, $sql_updateCase);

    if ($result && $result_upd) {
            $resultArray['result'] = "success";
    } else {
        $resultArray['result'] = "error";
        $resultArray['error'] = "can't change owner!";
    }

$resultArray['sql'] = $sql;

echo(json_encode($resultArray));