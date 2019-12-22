<?php
session_start();
include_once 'config.php';
function isAdmin(){
    if ($_SESSION['usertype'] == 'iCloudGrH' ||
        $_SESSION['M2UT'] == 'administrator' ||
        $_SESSION['M3UT'] == 'admin' ||
        $_SESSION['M4UT'] == 'administrator' ){
        return true;
    }
    return false;
}

if (!isset($_SESSION['username']) || !isAdmin()) {
    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $folder . "/login.php";
//    $url = str_replace('administrator/page1.php', 'login.php', $url);
    header("Location: $url");
}

?>

<!DOCTYPE html>
<html lang="ge">
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
    <link rel="stylesheet" href="style/sidebar-style.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <link rel="stylesheet" href="style/form2.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
</head>
<body onpageshow="f_show()" onpagehide="f_hide()">

<input type="hidden" id="currusertype" data-ut="<?php echo $_SESSION['M3UT'] ?>"
       data-org="<?= $_SESSION['OrganizationID'] ?>" data-userID="<?= $_SESSION['userID'] ?>"/>
<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3 id="loged_username"><?= $_SESSION['username'] ?></h3>
<!--            <h5>--><?//= $_SESSION['M3UT'] ?><!--</h5>-->
        </div>

        <ul class="list-unstyled components">
        </ul>

        <ul class="list-unstyled CTAs">
            <!-- <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li> -->
            <li><a href="logout.php" class="article">გასვლა</a></li>
        </ul>
        <div class="onbuttom">v 0.01</div>
    </nav>
    <!--sidebar-->

    <!-- Page Content Holder -->
    <div id="content">

        <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
            <i class="glyphicon glyphicon-menu-hamburger"></i>
            <span></span>
        </button>
<!-- END OF Header-->


        <div id="pan_1" class="panel panel-primary">
            <div class="panel-heading">
                <table id="table_p1_header" class="pan-header">
                    <tr>
                        <td class="pan-header-left">მომხმარებლების რედაქტირება</td>
                        <td class="pan-header-right"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="panel-body">

                <p id="currOpInfo">მიმდინარე ოპერაცია: <span></span></p>

                <ul class="nav nav-pills">
                    <li id="btn_newuser" role="presentation"><a href="#">ახალი მომხმარებელი</a></li>
                    <li id="btn_search" role="presentation"><a href="#">ძებნა</a></li>
                    <li id="btn_passchange" role="presentation" disabled='true'><a href="#">პაროლის შეცვლა</a></li>
                </ul>
                <div class="switch">
                    <hr>
                </div>

                <form id="form_1" method="post">
                    <table class="inputs">
                        <tr>
                            <td>სახელი</td>
                            <td>
                                <input type="text" class="form-control" id="u_firstname" placeholder="" name="firstname">
                            </td>
                            <td>გვარი</td>
                            <td>
                                <input type="text" class="form-control" id="u_lastname" placeholder="" name="lastname">
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>პირ.ნომერი</td>
                            <td>
                                <input type="text" class="form-control" id="u_pnumber" placeholder="" name="pnumber">
                            </td>
                            <td>დაბ.თარიღი</td>
                            <td>
                                <input type="date" class="form-control" id="u_bday" name="bday">
                            </td>
                        </tr>
                        <tr>
                            <td>მისამართი</td>
                            <td>
                                <input type="text" class="form-control" id="u_adress" placeholder="" name="adress">
                            </td>
                            <td>სტატუსი</td>
                            <td>
                                <select class="form-control" id="sel_state" name="state" required>
                                    <option value="">აირჩიეთ...</option>
                                </select>
                            </td>
                        </tr>

                        <div class="nav-divider"></div>

                        <tr>
                            <td>ორგანიზაცია</td>
                            <td>
                                <select class="form-control" id="sel_organization" name="organization">
                                    <option value="">აირჩიეთ...</option>
                                </select>
                            </td>
                            <td>ფილიალი</td>
                            <td>
                                <select class="form-control" id="sel_branch" name="branch">
                                    <option value="">აირჩიეთ...</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>ტელ:</td>
                            <td>
                                <input type="text" class="form-control" id="u_tel" placeholder="" name="tel">
                            </td>
                            <td>მომხმ.სახელი</td>
                            <td>
                                <input type="text" class="form-control" id="u_username" placeholder="" name="username">
                                <input type="hidden" id="h_username" name="h_username" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>პაროლი</td>
                            <td title='<?= $pass_make_info ?>'>
                                <input type="password" class="form-control" id="pass1" placeholder="პაროლი" name="pass1">
                                <input type="password" class="form-control" id="pass2" placeholder="გაიმეორეთ პაროლი" name="pass2">
                                <input type="hidden" id="hashpass" name="pass" value="">
                                <div id="msgdiv" class="alert alert-warning" role="alert" hidden><?= $pass_not_valid_text ?></div>
                            </td>
                        </tr>
                    </table>

                    <table id="userRolesTable">
                        <thead>
                        <tr>
                            <th>დაშვება მოდულზე</th>
                            <th>მომხმ.-ის ტიპი მოდულში</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($_SESSION['usertype'] != null && $_SESSION['usertype'] == 'iCloudGrH') : ?>
                        <tr>
                            <td>
                                <label for="ck_icloud"><input id="ck_icloud" type="checkbox" name="ck1"> iCloud</label>
                            </td>
                            <td>
                                <select class="form-control" id="sel_type" name="type"></select>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($_SESSION['M2UT'] != null && $_SESSION['M2UT'] == 'administrator') : ?>
                        <tr>
                            <td>
                                <label for="ck_m2"><input id="ck_m2" type="checkbox" name="ck2"> შეფასება</label>
                            </td>
                            <td>
                                <select class="form-control" id="sel_m2_type" name="m2_type"></select>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($_SESSION['M3UT'] != null && $_SESSION['M3UT'] == 'admin') : ?>
                        <tr>
                            <td>
                                <label for="ck_m3"><input id="ck_m3" type="checkbox" name="ck3"> ინციდენტების მართვა</label>
                            </td>
                            <td>
                                <select class="form-control" id="sel_m3_type" name="m3_type"></select>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($_SESSION['M4UT'] != null && $_SESSION['M4UT'] == 'administrator') : ?>
                        <tr>
                            <td>
                                <label for="ck_m4"><input id="ck_m4" type="checkbox" name="ck4"> სასამართლო პროცესების მართვა</label>
                            </td>
                            <td>
                                <select class="form-control" id="sel_m4_type" name="m4_type"></select>
                            </td>
                        </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>

                    <label for="comment">კომენტარი</label>
                    <input type="text" class="form-control" id="comment" placeholder="" name="comment">

                    <input type="hidden" id="operacia" name="operacia" value="0">
                    <input type="hidden" id="personid" name="personid" value="0">

                    <button id="btn_f1_done" type="submit" class="btn btn-primary btn-sm">ძებნა</button>
                    <a id="btn_f1_reset" class="btn btn-primary btn-sm">გასუფთავება</a>

                </form>

                <p class="info">ძიების შედეგი (იძებნება MAX 20 ჩანაწერი)</p>
                <table id="table_f11" class="datatable"></table>

            </div>
        </div>


<!--START OF Footer-->
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

<script type="text/javascript" src="js/sha256.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3/jquery.twbsPagination.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

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

<script type="text/javascript" src="js/userform.js"></script>
<!--<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>-->

</body>
</html>