<?php
session_start();

//print_r($_SESSION);

if (!isset($_SESSION['username'])) {
    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $url = str_replace('administrator/page1.php', 'login.php', $url);
    header("Location: $url");
}

if (isset($_POST['submit'])) {
    print_r($_POST);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>admin_page1</title>
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

    <style>
        #email {
            display: inline;
            width: 80%;
        }
        #table_block3 {
            background-color: #f5f5f5;
            width: 100%;
        }

        table, th, td {
            border: 1px solid #29a1ed;
            border-collapse: collapse;
            padding: 3px;
        }
        th {
            background-color: #ccccbb;
        }
    </style>

</head>
<body>

<div class="wrapper">
<!-- Sidebar Holder -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3><?php echo($_SESSION['username']) ?></h3>
        <h5><?php echo($_SESSION['usertype']) ?></h5>
    </div>

    <ul class="list-unstyled components">
        <p>Dummy Heading</p>
        <li class="active">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Home</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li><a href="#">Home 1</a></li>
                <li><a href="#">Home 2</a></li>
                <li><a href="#">Home 3</a></li>
            </ul>
        </li>
        <li>
            <a href="#">About</a>
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
                <li><a href="#">Page 3</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Portfolio</a>
        </li>
        <li>
            <a href="#">Contact</a>
        </li>
    </ul>

    <ul class="list-unstyled CTAs">
        <!-- <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li> -->
        <li><a href="../logout.php" class="article">logout</a></li>

    </ul>
</nav>
<!--sidebar-->

<!-- Page Content Holder -->
<div id="content">

<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="glyphicon glyphicon-align-left"></i>
                <span>Toggle Sidebar</span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Page</a></li>
            </ul>
        </div>
    </div>
</nav>

<!--    aqedan viwyeb chemi gverdis shigtavsis awyobas    -->

<!--<div class="line"></div>-->

<div class="panel panel-primary">
    <div class="panel-heading">ახალი Apple ID<span style="">Date</span></div>
    <div class="panel-body">

        <form action="../php_code/ins_appleid.php" method="post">
            <p>ფილიალის და ელ.ფოსტის მონაცემები</p>

            <div class="row">
                <div class="col-md-2 mb-3">
                    <label for="country">ორგანიზაცია</label>
                    <select class="custom-select form-control" id="sel_organization" name="organization" required>
                        <option value="">აირჩიეთ...</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="sel_branch">ფილიალი</label>
                    <select class="custom-select form-control" id="sel_branch" name="branch" disabled>
                        <option value="">Choose...</option>
                    </select>

                </div>
                <div class="col-md-2 mb-3">
                    <div>
                        <label for="email">ელ.ფოსტა</label>

                        <p><input type="text" class="form-control" id="email" placeholder=""
                                  name="email" required> @</p>
                    </div>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="sel_domain">დომეინი</label>
                    <select class="custom-select form-control" id="sel_domain" name="domain" required>

                    </select>

                </div>

                <div class="col-md-2 mb-3">
                    <div>
                        <label for="password">პაროლი</label>

                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="პაროლი"
                                   name="password" required>

                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-eye-open"
                                        aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-1 mb-3">
                    <div>
                        <label for="btn_addid"></label>
                        <button id="btn_addid" class="btn btn-primary">New Apple ID</button>
                    </div>
                </div>
            </div>

            <br>

            <!--                -------------------- ----------------------------------------------    -->
            <div id="block2">
                <p id="p2">Appl ID</p>

                <div class="row">
                    <div class="col-lg-2">
                        <label for="firstname">სახელი</label>
                        <input type="text" class="form-control" id="firstname" placeholder="სახელი" name="saxeli">
                    </div>

                    <div class="col-lg-2">
                        <label for="lastname">გვარი</label>
                        <input type="text" class="form-control" id="lastname" placeholder="გვარი" name="gvari">
                    </div>

                    <div class="col-lg-1"></div>

                    <div class="col-lg-3">
                        <label for="appl_id">Appl ID</label>
                        <input type="text" class="form-control" id="appl_id" placeholder="appl mail" name="applid">
                    </div>

                    <div class="col-lg-3">
                        <label for="appl_id_pass">appl id pass</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="appl_id_pass" placeholder="appl id pass" name="applidpass">

                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-refresh"
                                        aria-hidden="true"></span></button>
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-eye-close"
                                        aria-hidden="true"></span></button>
                            </div>
                        </div>

                    </div>

                </div>

                <!--                    blok2 line2 -->
                <div class="row">
                    <div class="col-lg-2">

                        <label for="bday">დაბ.თარიღი</label>
                        <input type="date" id="bday" class="form-control" name="bday">

                    </div>

                    <div class="col-lg-2">
                        <label for="country">ქვეყანა</label>
                        <input type="text" id="country" class="form-control" placeholder="ქვეყანა" name="country" value="საქართველო">
                    </div>

                    <div class="col-lg-1"></div>

                    <div class="col-lg-3">
                        <label for="sel_rmail">Appl ID Rescue Email</label>
                        <select class="custom-select form-control" id="sel_rmail" name="rmail" required>
                            <option value="">აირჩიეთ...</option>
                            <option value="1">ტექნო1</option>
                            <option value="2">ტექნო2</option>
                        </select>
                    </div>

                </div>

                <!--                    blok2 line3 -->
                <div class="row">

                    <div class="col-lg-5">
                        <label for="sel_q1">SequrityQuestion 1</label>
                        <select class="custom-select form-control" id="sel_q1" name="q1">
                            <option value="">აირჩიეთ...</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label for="ans1">Answer 1</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="ans1" placeholder="" name="ans1" >

                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-refresh"
                                        aria-hidden="true"></span></button>
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-eye-close"
                                        aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--                    blok2 line4 -->
                <div class="row">

                    <div class="col-lg-5">
                        <label for="sel_q2">SequrityQuestion 2</label>
                        <select class="custom-select form-control" id="sel_q2" name="q2">
                            <option value="">აირჩიეთ...</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label for="ans2">Answer 2</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="ans2" placeholder="" name="ans2">

                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-refresh"
                                        aria-hidden="true"></span></button>
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-eye-close"
                                        aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--                    blok2 line5 -->
                <div class="row">

                    <div class="col-lg-5">
                        <label for="sel_q3">SequrityQuestion 3</label>
                        <select class="custom-select form-control" id="sel_q3" name="q3">
                            <option value="">აირჩიეთ...</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label for="ans3">Answer 3</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="ans3" placeholder="" name="ans3">

                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-refresh"
                                        aria-hidden="true"></span></button>
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-eye-close"
                                        aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <p>სტატუსი და დამატებითი ინფორმაცია</p>
                <!--                    blok2 line6 -->
                <div class="row">

                    <div class="col-lg-2">
                        <label for="sel_status">სტატუსი</label>
                        <select class="custom-select form-control" id="sel_status" name="status">
                            <option value="">აირჩიეთ...</option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <label for="comment">შენიშვნა</label>
                        <input type="text" class="form-control" id="comment" placeholder="" name="comment">
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <span><input type="submit" class="btn btn-primary" value="შენახვა"></span>
                        <input type="reset" class="btn btn-primary" value="გაუქმება">
                    </div>

                </div>

            </div>
        </form>
    </div>
    <!--პანელის ტანი-->
</div>

<div class="panel panel-primary">
    <div class="panel-heading">Apple ID-ს პროექტები</div>
    <div class="panel-body">
        <table id="table_block3">
            <tr>
                <th>ID</th>
                <th>ორგანიზაცია</th>
                <th>ფილიალი</th>
                <th>ელ ფოსტა</th>
                <th>შექმნის თარიღი</th>
                <th>მომხმარებელი</th>
                <th>სტატუსი</th>
            </tr>
        </table>
    </div>

</div>

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

<script>

    $('#block2').hide();

<!--    organizaciebis chamonatvali -->
    $.ajax({
        url: '../php_code/get_organizations.php',
        method: 'get',
        dataType: 'json',
        success: function (response) {
            response.forEach(function (item) {
                $('<option />').text(item.OrganizationName).attr('value', item.id).appendTo('#sel_organization');
                console.log(item);
            })
        }
    });

    $('#sel_organization').on('change', function () {
        $('#sel_branch').empty();
        $('#sel_domain').empty();
        var sel_org_id = $('#sel_organization').val();

<!--        filialebis chamonatvali -->
        $.ajax({
            url: '../php_code/get_branches.php?id=' + sel_org_id,
            method: 'get',
            dataType: 'json',
            success: function (response) {
                response.forEach(function (item) {
                    $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#sel_branch');
                    console.log(item);
                })
            }
        });

        <!--        domainebis  chamonatvali -->
        $.ajax({
            url: '../php_code/get_domains.php?id=' + sel_org_id,
            method: 'get',
            dataType: 'json',
            success: function (response) {
                response.forEach(function (item) {
                    $('<option />').text(item.DomainName).attr('value', item.id).appendTo('#sel_domain');
                    console.log(item);
                })
            }
        });

    });



    $('#btn_addid').click(function(){
        if ($('#block2').css('display') == 'none' ){
            $('#block2').show();
        }


    })

    setTimeout(function () {
        // $('#p2').text($('#p1').text());
    }, 3000);

    var td_1 = $('<td />').text('sawetet');
    var td_2 = $('<td />').text('sawe3tet');
    var td_3 = $('<td />').text('sawet4et');
    var td_4 = $('<td />').text('sawete5t');
    var td_5 = $('<td />').text('sawete5t');
    var td_6 = $('<td />').text('sawete5t');
    var td_7 = $('<td />').text('sawete5t');

    console.log(td_1);

    $('<tr></tr>').append(td_1, td_2, td_3, td_4, td_5, td_6, td_7).appendTo('#table_block3');


</script>

<script>

    // Wait until the window finishes loaded before executing any script
    window.onload = function () {

//        // Initialize the activityNumber
//        var activityNumber = 3;
//
//        // Select the add_activity button
//        var addButton = document.getElementById("mybtn");
//
//        // Select the table element
//        var tracklistTable = document.getElementById("sel_filiani");
//
//        // Attach handler to the button click event
//        addButton.onclick = function () {
//
//
//            var newrow = '<option>sdsdsdsds</option>';
//            // Add a new row to the table using the correct activityNumber
//            tracklistTable.innerHTML += '<tr><td>' + activityNumber + '</td><td><label>Activity Log: </label><br/><input type="text" name="actlog' + activityNumber + '" class="required"></td><td><label>Time: </label><br/><input type="time" name="time' + activityNumber + '" class="required"></td></tr>';
//            tracklistTable.innerHTML += newrow;
//
//            console.log(newrow);
//            // Increment the activityNumber
//            activityNumber += 1;
//        }
//
    }

</script>

</body>
</html>