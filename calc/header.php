<?php
session_start();
include_once '../config.php';

if (!isset($_SESSION['username'])) {
    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $folder . "/login.php";
//    $url = str_replace('administrator/page1.php', 'login.php', $url);
    header("Location: $url");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Lima iCloud</title>
    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../style/sidebar-style.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <link rel="stylesheet" href="style/local.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body onpageshow="f_show()" onpagehide="f_hide()">
<input type="hidden" id="currusertype" data-ut="<?php echo $_SESSION['usertype'] ?>"/>
<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><?= $_SESSION['username'] ?></h3>
            <h5><?= $_SESSION['M2UT'] ?></h5>
        </div>

        <ul class="list-unstyled components">
            <li class="main">
                <a href="index.php">მთავარი</a>
            </li>
            <li class="pricerate">
                <a href="pricerate.php">ტექნიკის შეფასება</a>
            </li>
            <li class="typemanager">
                <a href="typemanager.php">ტიპები და მახასიათებლები</a>
            </li>
            <li class="critratemanager">
                <a href="critratemanager.php">შეფასების კრიტერიუმები</a>
            </li>
        </ul>

        <ul class="list-unstyled CTAs">
            <!-- <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li> -->
            <li><a href="../logout.php" class="article">გასვლა</a></li>
        </ul>
        <div class="onbuttom">v 0.3</div>
    </nav>
    <!--sidebar-->

    <!-- Page Content Holder -->
    <div id="content">

        <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
            <i class="glyphicon glyphicon-menu-hamburger"></i>
            <span></span>
        </button>

<!--        <nav class="navbar navbar-default">-->
<!--            <div class="container-fluid">-->
<!---->
<!--                <div class="navbar-header">-->
<!---->
<!--                </div>-->
<!---->
<!--                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">-->
<!--                    <ul class="nav navbar-nav navbar-right">-->
<!--                        <li id="paramLi" class="alert-light" style="border-radius: 8px"><a href="parametrebi.php">პარამეტრები</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--        </nav>-->