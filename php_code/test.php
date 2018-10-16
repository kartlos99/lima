<?php
include_once '../administrator/header.php';
?>

<?php


include_once '../config.php';
session_start();

$tarigiSt = date("Y-m-d", time());
$tarigiDt = date("Y-m-d H:i", time() - 2*30*24*3600);
$emEmail = 'ttt';

$sql_chek = "SELECT checkmail('".$emEmail."',4) AS num ";
$result1 = mysqli_query($conn, $sql_chek);
$arr = mysqli_fetch_assoc($result1);
$count = $arr['num'];

$newdate = time($tarigiDt);
// echo($tarigiDt);
// echo '<br>';
// echo time();
// echo '<br>';
// echo date("Y-m-d H:i Z", time());
// echo '<br>';
// echo gmdate("Y-m-d H:i Z", time());
// echo '<br>';


// print_r ($_SESSION);

?>

<div >
    <ul>
        <li>1</li>
        <li>2</li>
    </ul>
</div>

<script>
    var x = 212;
    var y = 50;
    if (x < y){
        alert('naklebia')
    }else{
        alert('metia!')
    }
</script>

<?php
include_once '../administrator/footer.php';
?>