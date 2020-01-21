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

function getPermission($roleID, $moduleN, $dbcon)
{
    $permissions = [];
    $sql_perm = "
SELECT p.code FROM `permissionmapping` pm
LEFT JOIN permission p
	ON p.id = pm.`permissionID`
WHERE `roleID` = $$roleID AND p.module = '$moduleN'";

    $res = mysqli_query($dbcon, $sql_perm);

    foreach ($res as $row) {
        $permissions[] = $row;
    }
return [mysqli_num_rows($res)];
    return $permissions;

}

if (isset($_POST['submit'])) {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "enter user & password!";
    } else {

        $subName = $_POST['username'];
        $subPass = $_POST['password'];

        // print_r($_POST);
        $conn = mysqli_connect(HOST, DB_user, DB_pass, DB_name);

        $subName = mysqli_real_escape_string($conn, $subName);
        $subPass = mysqli_real_escape_string($conn, $subPass);

        $sql = "
SELECT
    p.LastName,
    p.FirstName,
    p.LegalAdress,
    pmap.UserName,
    pmap.UserPass,
    UNIX_TIMESTAMP() - pmap.PassDate - (SELECT valueInt from DictionariyItems WHERE `Code` = 'userpassduration') AS passExp,
    di.Code AS UserType,
    dim2.Code AS M2UT,
    dim3.Code AS M3UT,
    dim4.Code AS M4UT,
    pmap.UserTypeM2,
    pmap.UserTypeM3,
    pmap.OrganizationID,
    pmap.OrganizationBranchID AS filiali,
    pmap.ID
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
    pmap.UserName = '$subName' AND s.Code = 'Active'
    ";

        $results = $conn->query($sql);
        $rowCount = mysqli_num_rows($results);

        if ($rowCount == 1) {

            $results = mysqli_fetch_assoc($results);

            // print_r($results);

            $storPass = $results['UserPass'];

            //$subpass = $db_f->hash_password($subpass);

            if ($subPass == $storPass) {

                $_SESSION['firstname'] = $results['FirstName'];
                $_SESSION['lastname'] = $results['LastName'];
                $_SESSION['userID'] = $results['ID'];
                $_SESSION['usertype'] = $results['UserType'];
                $_SESSION['M2UT'] = $results['M2UT'];
                $_SESSION['M3UT'] = $results['M3UT'];
                $_SESSION['M4UT'] = $results['M4UT'];
                $_SESSION['username_exp'] = $subName;
                $_SESSION['userpass'] = $storPass;
                $_SESSION['OrganizationID'] = $results['OrganizationID'];
                $_SESSION['filiali'] = $results['filiali'];

                if ($results['M2UT'] != null) {
                    $permissions = [];
                    $roleID = $results['UserTypeM2'];
                    $sql_perm = "
SELECT p.code FROM `permissionmapping` pm
LEFT JOIN permission p
	ON p.id = pm.`permissionID`
WHERE `roleID` = $roleID AND p.module = 'm2'";

                    $res = mysqli_query($conn, $sql_perm);

                    foreach ($res as $row) {
                        $permissions[$row['code']] = 1;
                    }

                    $_SESSION['permissionM2'] = $permissions;
                }

                if ($results['M3UT'] != null) {
                    $permissions = [];
                    $roleID = $results['UserTypeM3'];
                    $sql_perm = "
                        SELECT p.code FROM `permissionmapping` pm
                        LEFT JOIN permission p
                            ON p.id = pm.`permissionID`
                        WHERE `roleID` = $roleID AND p.module = 'm3'";

                    $res = mysqli_query($conn, $sql_perm);

                    foreach ($res as $row) {
                        $permissions[$row['code']] = 1;
                    }

                    $_SESSION['permissionM3'] = $permissions;
                }

                $currDate = time();
                if ($results['passExp'] < 0) {

                    $_SESSION['username'] = $subName;

                } else {
                    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                    $url = str_replace('login.php', 'changepass.php', $url);
                    header("Location: $url");
                }

                // print_r($_SESSION);

                // $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                // $url = str_replace('login.php', 'administrator/page1.php', $url);
                // $error = $url;
                // header("Location: $url");
            } else {
                $error = "incorect password!";
            }

        } else {
            $error = "no user found!";
        }

        mysqli_close($conn);
    }

}

?>