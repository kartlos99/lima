<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 3/23/18
 * Time: 5:51 PM
 */

session_start();
$error = ''; // Variable To Store Error Message

if (isset($_POST['submit'])) {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "enter user & password!";
    } else {

        $subName = $_POST['username'];
        $subPass = $_POST['password'];

        // print_r($_POST);
        $conn = mysqli_connect('localhost', 'root', '12312', 'lima');

        $subName = mysqli_real_escape_string($conn, $subName);
        $subPass = mysqli_real_escape_string($conn, $subPass);

        $sql = "SELECT p.LastName, p.FirstName, p.LegalAdress, pmap.UserName, pmap.UserPass, di.ValueText as UserType FROM `personmapping` pmap
              LEFT JOIN persons p ON pmap.PersonID = p.ID
              LEFT JOIN dictionariyitems di ON pmap.UserTypeID = di.ID
               WHERE pmap.UserName = '$subName'";

        $results = $conn->query($sql);
        $rowCount = mysqli_num_rows($results);

        if ($rowCount == 1) {

            $results = mysqli_fetch_assoc($results);

            // print_r($results);

            $storPass = $results['UserPass'];

            //$subpass = $db_f->hash_password($subpass);

            if ($subPass == $storPass) {

                $_SESSION['username'] = $subName;
                $_SESSION['usertype'] = $results['UserType'];
                $_SESSION['firstname'] = $results['FirstName'];
                $_SESSION['lastname'] = $results['LastName'];

                // print_r($_SESSION);

                $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                $url = str_replace('login.php', 'administrator/page1.php', $url);
                $error = $url;
//                header("Location: $url");
            } else {
                $error = "incorect password!";
            }

        }else{
            $error = "no user found!";
        }

        mysqli_close($conn);
    }

}

?>