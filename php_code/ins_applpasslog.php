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

function findAgrByApplID(){

}

    $sql = "
    INSERT INTO `Applidpasslog`(
        `userID`,
        `applid`,
        `texti`,
        `whichpass`,
        `curr_agrim_ID`
    )
    VALUES(
        $iserID,
        $applID,
        '$text',
        '$whichpass',
        ifnull((SELECT
            max(a.`ID`)
        FROM
            Agreements a
        LEFT JOIN States s ON
            a.StateID = s.ID
        WHERE
            `ApplIDFixID` = $applID AND (s.Code = 'active' or s.Code = 'project')
                ), 0 )
    )";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo mysqli_insert_id($conn); //'ok';
    } else {
        echo $sql;//'myerror';
    }

$conn->close();

?>