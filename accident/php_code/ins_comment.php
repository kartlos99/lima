<?php
//INSERT INTO `im_persons` (`ID`, `FirstName`, `LastName`, `OrgID`, `OrgBranchID`, `TypeID`, `StatusID`, `CreateDate`, `CreateUser`) VALUES (NULL, 'ირაკლი', 'მანჯგალაძე', '8', '4', '5', '1', '2019-11-17 00:00:00', '1');
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

$recID = $_POST['recID'];
$comment = $_POST['comment'];

if ($recID == 0){
    $resultArray['result'] = "error";
    $resultArray['error'] = "no accident ID specifaied!";
    die(json_encode($resultArray));
}

$sql = "
INSERT INTO `im_comments` 
(`IM_RequestID`, `Comment`, `CreateDate`, `CreateUser`) 
VALUES 
('$recID', '$comment', $currDate, $currUserID)
";

$result = mysqli_query($conn, $sql);

if ($result) {
    $resultArray['result'] = "success";
} else {
    $resultArray['result'] = "error";
    $resultArray['error'] = "can't add comment!";
    $resultArray['sql'] = $sql;
}

echo(json_encode($resultArray));