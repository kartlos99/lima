<?php include_once 'header.php'; ?>

<!-- <?php 
    $error = "";
    // print_r($_POST);
    // print_r($_SERVER);
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if ($_POST['ch_password'] == $_SESSION['userpass']){
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
                            $error = "პაროლი შეიცვალა!";
                        }else {
                            $error = "DB Error!";
                        }
                    }
            
                }
            
            }
        } else{
            $error = "მიმდინარე პაროლი არასწორია!";
        }
    }
    
?> -->

<p>პაროლის შეცვლა</p>

<form id="changePassForm" action="" method="post" class="paraminput">

    <h4></h4>
    <div class="input-group">
        <span class="input-group-addon">მიმდინარე პაროლი:</span>
        <input id="pass" type="password" class="form-control" aria-describedby="sizing-addon2">
    </div>
    <input id="passHiden" type="hidden" name="ch_password" value="">
    
    <h4></h4>
    <div class="input-group" title='პაროლი უნდა შედგებოდეს მინ. 8 სიმბოლოსგან, უნდა შეიცავდეს დიდ და პატარა სიმბოლოებს, ციფრებს და სპეცსიმბოლოებს (!@#$%^&*...)'>
        <span class="input-group-addon">ახალი პაროლი:</span>
        <input id="pass1" type="password" class="form-control" aria-describedby="sizing-addon2" >
    </div>
    <input id="passHiden1" type="hidden" name="ch_password1" value="">

    <h4></h4>
    <div class="input-group">
        <span class="input-group-addon">გაიმეორეთ პაროლი:</span>
        <input id="pass2" type="password" class="form-control" aria-describedby="sizing-addon2">
    </div>
    <input id="passHiden2" type="hidden" name="ch_password2" value="">
    
    <h4></h4>
    <?php
        if ($error != ""){
            echo "<div class=\"alert alert-warning\" role=\"alert\">" . $error . "</div>";
        }
    ?>
    <div id="msgdiv" class="alert alert-warning" role="alert">
        არ აკმაყოფილებს პაროლის კრიტერიუმებს!
    </div>
    <div>
        <input id="passsubmit" type="submit" name="submit" class="btn btn-default centered" value="დადასტურება"/>
    </div>    
</form>

<?php
if ($_SESSION['usertype'] == 'iCloudGrH'){
    include_once 'ghparam.php';
}
?>


<?php include_once 'footer.php'; ?>