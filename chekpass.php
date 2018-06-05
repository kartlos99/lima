<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/23/18
 * Time: 5:51 PM
 */

session_start();
$error = ''; // Variable To Store Error Message
require_once 'config.php';

if (isset($_POST['ch_password1'])) {

    if (empty($_POST['ch_password1']) || empty($_POST['ch_password2'])) {
        $error = "შეავსეთ ორივე ველი!";
    } else {
        if ($_POST['ch_password1'] != $_POST['ch_password2']){
            $error = "გაიმეორეთ იგივე პაროლი!";
        }else{
            $newpass = $_POST['ch_password2'];
            $newdate = time();
            $userID = $_SESSION['userID'];
            $sql = "UPDATE PersonMapping SET `UserPass` = '$newpass', `PassDate` = $newdate WHERE ID = $userID";

            if (mysqli_query($conn, $sql)){
                $_SESSION['username'] = $_SESSION['username_exp'];
            }else {
                $error = "DB Error!";
            }
        }

    }

}

?>