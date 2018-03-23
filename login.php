<?php
include('login_script.php'); // Includes Login Script

// print_r($_SESSION);
// print_r($_POST);

if (isset($_SESSION['username'])) {
    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $url = str_replace('login.php', 'administrator/page1.php', $url);
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

    <title>login</title>
</head>
<body>


<div style="width: 560px; background: #fff; border: 1px solid #e4e4e4; padding: 20px; margin: 10px auto;">
    <h3>login</h3>

    <p>
        <?php
        echo $error;
        ?>
    </p>

    <form action="" method="post">

        <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-user"
                                                                     aria-hidden="true"></span></span>
            <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon2"
                   name="username">
        </div>

        <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-asterisk"
                                                                     aria-hidden="true"></span></span>
            <input type="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon2"
                   name="password">
        </div>

        <input type="hidden" name="regdate" value="54545454">

        <div>
            <input type="submit" name="submit" class="btn btn-default centered" value="login"/>
        </div>

    </form>

</div>

<button type="button" class="btn btn-success " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    login
</button>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
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
</body>
</html>