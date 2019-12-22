<?php
// header('location: login.php');
include_once('login_script.php'); // Includes Login Script
include_once('config.php');

if (!isset($_SESSION['username'])) {
    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $folder . "/login.php";
//    $url = str_replace('administrator/page1.php', 'login.php', $url);
    header("Location: $url");
}

$url = "";
if ($_SESSION['usertype'] != null) {
    $page = 'main';
    if ($_SESSION['usertype'] == 'AppleIDCreator') {
        $page = 'new_apl_ac';
    }

    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $url = str_replace('index.php', $_SESSION['usertype'] . '/' . $page . '.php', $url);
    $m1_URL = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $folder . "/" . $_SESSION['usertype'] . "/main.php";
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
        #dout {
            position: fixed;
            top: 16px;
            right: 16px;
        }
    </style>
</head>
<body>
<div>
    <table style="margin: auto">
        <tr>
            <td>
                <a href="<?php if ($_SESSION['usertype'] != null) {
                    echo $m1_URL;
                } ?>"><img src="img\icloud.png" title="iCloud"/></a>
            </td>
            <td>
                <a href="<?php if ($_SESSION['M2UT'] != null) {
                    echo "calc\\index.php";
                } ?>"><img src="img\calc.png" title="შეფასება"/></a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php if ($_SESSION['M3UT'] != null) {
                    echo "accident\\index.php";
                } ?>"><img src="img\conflict.png" title="ინციდენტების მართვა"></a>
            </td>
            <td>
                <a href="<?php if ($_SESSION['M4UT'] != null) {
                    echo "trial\\index.php";
                } ?>"><img src="img\agreement.png" title="პრობლემური სესხების სასამართლო პროცესების მართვა"></a>
            </td>
        </tr>
    </table>
</div>
<div id="dout">
<?php
function isAdmin(){
    if ($_SESSION['usertype'] == 'iCloudGrH' ||
        $_SESSION['M2UT'] == 'administrator' ||
        $_SESSION['M3UT'] == 'admin' ||
        $_SESSION['M4UT'] == 'administrator' ){
        return true;
    }
    return false;
}
if (isAdmin()){
    echo '<a href="userManagement.php" class="article">მომხმარებლების მართვა</a>';
}
?>
    <span>  |  </span>
    <a href="logout.php" class="article"> გასვლა</a>
</div>
</body>
</html>