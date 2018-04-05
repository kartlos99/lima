<?php
include_once 'header.php';
?>

    <!--    aqedan viwyeb chemi gverdis shigtavsis awyobas    -->

    <!--<div class="line"></div>-->

    <div class="panel panel-primary">
    <div class="panel-heading">
        <table class="pan-header">
            <tr>
                <td class="pan-header-left"
                ">ახალი Apple ID</td>
                <td class="pan-header-right"><span>Date</span></td>
            </tr>
        </table>
    </div>
    <div class="panel-body">

    <form action="../php_code/ins_appleid.php" method="post" id="form1">
        <p>ფილიალის და ელ.ფოსტის მონაცემები</p>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="country">ორგანიზაცია</label>
                <select class="custom-select form-control" id="sel_organization" name="organization"
                        required>
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

                    <p><input type="text" class="form-control" id="email" placeholder="" name="email"
                              required> @</p>
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
                            <button id="btneye1" class="btn btn-default eye" type="button"><span
                                    class="glyphicon glyphicon-eye-open"
                                    aria-hidden="true"></span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-1 mb-3">
                <div>
                    <label for="btn_addid"></label>
                    <button id="btn_addid" class="btn btn-primary btn-block">New Apple ID</button>
                </div>
            </div>
        </div>
    </form>


    <br>

    <!--    -------------   2 bloki ------- ----------------------------------------------    -->
    <div id="block2">
        <form action="" method="post" id="form2">

            <p id="p2">Appl ID</p>

            <div class="row">
                <div class="col-lg-2">
                    <label for="firstname">სახელი</label>
                    <input type="text" class="form-control" id="firstname" placeholder="სახელი"
                           name="saxeli">
                </div>
                <div class="col-lg-2">
                    <label for="lastname">გვარი</label>
                    <input type="text" class="form-control" id="lastname" placeholder="გვარი" name="gvari">
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-3">
                    <label for="appl_id">Appl ID</label>
                    <input type="text" class="form-control" id="appl_id" placeholder="appl mail"
                           name="applid" disabled>
                </div>
                <div class="col-lg-3">
                    <label for="appl_id_pass">appl id pass</label>

                    <div class="input-group">
                        <input type="text" class="form-control" id="appl_id_pass" placeholder="appl id pass"
                               name="applidpass">

                        <div class="input-group-btn">
                            <button class="btn btn-default passgen" type="button"><span
                                    class="glyphicon glyphicon-refresh"
                                    aria-hidden="true"></span></button>
                            <button class="btn btn-default eye" type="button"><span
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
                    <input type="text" id="country" class="form-control" placeholder="ქვეყანა"
                           name="country"
                           value="საქართველო">
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-3">
                    <label for="sel_rmail">Appl ID Rescue Email</label>
                    <select class="custom-select form-control" id="sel_rmail" name="rmail">
                        <option value="">აირჩიეთ...</option>
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
                        <input type="text" class="form-control" id="ans1" placeholder="" name="ans1">

                        <div class="input-group-btn">
                            <button class="btn btn-default passgen" type="button"><span
                                    class="glyphicon glyphicon-refresh"
                                    aria-hidden="true"></span></button>
                            <button class="btn btn-default eye" type="button"><span
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
                            <button class="btn btn-default passgen" type="button"><span
                                    class="glyphicon glyphicon-refresh"
                                    aria-hidden="true"></span></button>
                            <button class="btn btn-default eye" type="button"><span
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
                            <button class="btn btn-default passgen" type="button"><span
                                    class="glyphicon glyphicon-refresh"
                                    aria-hidden="true"></span></button>
                            <button class="btn btn-default eye" type="button"><span
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
                    </select>
                </div>
                <div class="col-lg-5">
                    <label for="comment">შენიშვნა</label>
                    <input type="text" class="form-control" id="comment" placeholder="" name="comment">
                </div>
            </div>
            <br>


        </form>

        <div class="row">
            <div class="col-md-6 mb-4">

                <button id="btn_f2submit" class="btn btn-primary">შენახვა</button>
                <button id="btn_f2reset" class="btn btn-primary">გაუქმება</button>
            </div>
        </div>
    </div>

    </div>
    <!--პანელის ტანი-->
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Apple ID-ს პროექტები</div>
        <div class="panel-body">
            <table id="table_block3"></table>
        </div>
    </div>

<?php
include_once 'footer.php';
?>