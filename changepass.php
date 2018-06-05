<?php
include('chekpass.php'); // Includes Login Script
// print_r($_SESSION);
// print_r($_POST);

if (isset($_SESSION['username'])) {

    $page = 'main';
    if ($_SESSION['usertype'] == 'AppleIDCreator'){
        $page = 'page1';
    }

    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $url = str_replace('changepass.php', 'administrator/'.$page.'.php', $url);
    header("Location: $url");
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!--      <link rel="stylesheet" href="style/bootstrap.min.css" >    -->
    <!--      <link rel="stylesheet" href="style/bootstrap-theme.min.css" >-->

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="style/main.css" rel="stylesheet">

    <title>Lima iCloud - Change Pass</title>
</head>
<body>


<div style="width: 560px; background: #fff; border: 1px solid #e4e4e4; padding: 20px; margin: 10px auto; border-radius: 5px;">

    <h4>პაროლს გაუვიდა ვადა, გთხოვთ შეცვალოთ</h4>

    <form id="loginform" action="" method="post">

        <h4></h4>
        <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-asterisk"
                                                                     aria-hidden="true"></span></span>
            <input id="pass1" type="password" class="form-control" placeholder="ახალი პაროლი" aria-describedby="sizing-addon2">
            <input id="passHiden1" type="hidden" name="ch_password1" value="">
        </div>

        <h4></h4>
        <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-asterisk"
                                                                     aria-hidden="true"></span></span>
            <input id="pass2" type="password" class="form-control" placeholder="გაიმეორეთ პაროლი" aria-describedby="sizing-addon2">
            <input id="passHiden2" type="hidden" name="ch_password2" value="">
        </div>

        <div>
            <input type="submit" name="submit" class="btn btn-default centered" value="დადასტურება"/>
        </div>

    </form>

    <p class="error-msg"><?php        echo $error;        ?></p>

</div>



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<!-- jQuery Custom Scroller CDN -->
<!--
      <script src="js/jquery-3.2.1.slim.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
-->
<script type="text/javascript" src="js/sha256.js"></script>
<!--<script type="text/javascript" src="js/form1.js"></script>-->

<script>
    $('#pass1').on('keyup',function (value) {
       var ps = $(this).val();
       var pass = sha256_digest(ps);
        $('#passHiden1').val(pass);
    });
    $('#pass2').on('keyup',function (value) {
        var ps = $(this).val();
        var pass = sha256_digest(ps);
        $('#passHiden2').val(pass);
    });

</script>

</body>
</html>