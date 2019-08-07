<?php
// header('location: login.php');
include_once('login_script.php'); // Includes Login Script

$url = "";
if ($_SESSION['usertype'] != null){
    $page = 'main';
    if ($_SESSION['usertype'] == 'AppleIDCreator'){
        $page = 'new_apl_ac';
    }

    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $url = str_replace('index.php', $_SESSION['usertype'] . '/' . $page . '.php', $url);
}

// header("Location: $url");
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        img {
            padding: 8px;
            width: 200px;
            height: 200px;
        }
        img:hover {
            border: 1px solid rosybrown;
            border-radius: 20px;
            padding: 8px;
        }

        td {
            padding: 30px;
        }
    </style>
</head>
<body>
<div>
    <table style="margin: auto">
        <tr>
            <td>
                <a href="<?php if ($_SESSION['usertype'] != null){echo $url;} ?>"><img src="img\icloud.png" title="iCloud"/></a>
            </td>
            <td >
                <a href="<?php if ($_SESSION['M2UT'] != null){echo "calc\\index.php";} ?>"><img src="img\calc.png" title="შეფასება"/></a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php if ($_SESSION['M3UT'] != null){echo "#";} ?>"><img src="img\conflict.png" title="conflict" ></a>
            </td>
            <td>
                <a href="<?php if ($_SESSION['M4UT'] != null){echo "#";} ?>"><img src="img\agreement.png" title="agreem" ></a>
            </td>
        </tr>
    </table>
</div>
</body>
</html>