</div>
<!--page content-->
</div>
<!-- wrapper -->

<!--my script-->


<!-- jQuery CDN -->
<!-- <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script> -->
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
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript" src="../js/sha256.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });

</script>
<!--<script type="text/javascript" src="../js/sha256.js"></script>-->

<script type="text/javascript"  <?php
    $pos = strpos($_SERVER['PHP_SELF'], "agrim.php");
if ($pos !== false ){
    echo "src=\"../js/form3.js\"";
    $thisPage = 'agrim';
}
    $pos = strpos($_SERVER['PHP_SELF'], "new_apl_ac.php");
if ($pos !== false ){
    echo "src=\"../js/form2.js\"";
    $thisPage = 'page1';
}
    $pos = strpos($_SERVER['PHP_SELF'], "main.php");
if ($pos !== false ){
    echo "src=\"../js/form1.js\"";
    $thisPage = 'main';
}
    $pos = strpos($_SERVER['PHP_SELF'], "userman.php");
if ($pos !== false ){
    echo "src=\"../js/userform.js\"";
    $thisPage = 'userman';
}
    $pos = strpos($_SERVER['PHP_SELF'], "parametrebi.php");
if ($pos !== false ){
    echo "src=\"../js/paramPage.js\"";
    $thisPage = 'param';
}
    $pos = strpos($_SERVER['PHP_SELF'], "reports.php");
if ($pos !== false ){
    echo "src=\"../js/reports.js\"";
    $thisPage = 'reports';
}
?> ></script>

<?php

if ($_SESSION['usertype'] == 'AppleIDCreator'){
    echo '<script type="text/javascript" src="../js/form2a.js" ></script>';
}
if ($_SESSION['usertype'] == 'CallCenterOper'){
    echo '<script type="text/javascript" src="../js/form1a.js" ></script>';
    if ($thisPage == 'agrim') {
        echo '<script type="text/javascript" src="../js/form3a.js" ></script>';
    }
}
?>

</body>
</html>