<?php

include_once '../config.php';
session_start();
if (!isset($_SESSION['username'])){
    die("login");
}

$iserID = $_SESSION['userID'];
$applID = $_POST['applID'];
$text = $_POST['text'];
$whichpass = $_POST['whichpass'];
//print_r($_POST);
//print_r($_SESSION);


    $sql = "
    INSERT INTO `Applidpasslog`(
        `userID`,
        `applid`,
        `texti`,
        `whichpass`
    )
    VALUES(
        $iserID,
        $applID,
        '$text',
        '$whichpass'
    )";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo mysqli_insert_id($conn); //'ok';
    } else {
        echo $sql;//'myerror';
    }

$conn->close();

?>