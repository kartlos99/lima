<?php
session_start();

if (is_null($logged)) {
    $logged = "no";
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="style/bootstrap.min.css" >    
      <link rel="stylesheet" href="style/bootstrap-theme.min.css" >
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="style/main.css" rel="stylesheet">

    <title>login</title>
</head>
<body>
      
      
<div style="width: 560px; background: #fff; border: 1px solid #e4e4e4; padding: 20px; margin: 10px auto;">
  <h3>login</h3>
  <p>
    <?php 
      if ($logged == 'invalid') { echo "araswori paroli!";}
      
      if ($_GET["action"] == 'login') {echo "gaiaret avtorizacia!";} else {
        if ($logged == 'empty') { echo "sheavseT velebi!";} 
      }
    ?>
  </p>

    <form action="" method="post">
      
      <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
        <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon2" name="username">
      </div>

      <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></span>
        <input type="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon2" name="password">
      </div>
  
      <input type="hidden" name="regdate" value="54545454">
  
      <div>
        <input type="submit" class="btn btn-default centered" value="login"/>
      </div>

    </form>

</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!--    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>-->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
      <script src="js/jquery-3.2.1.slim.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      
</body>
</html>