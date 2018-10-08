<?php include_once 'header.php'; ?>

<?php 
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
    
?>

<p>პაროლის შეცვლა</p>

<form id="changePassForm" action="" method="post">

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

<table class="table table-hover">
    <caption>List of users</caption>
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th >2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">პაროლის ნახვის მიზეზი</h5>
        
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="btndone" type="button" class="btn btn-primary" data-dismiss="modal">Send message</button>
      </div>
    </div>
  </div>
</div>


<?php include_once 'footer.php'; ?>