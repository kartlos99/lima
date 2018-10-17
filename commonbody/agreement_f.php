<div id="pan_f31" class="panel panel-primary">
    <div class="panel-heading">
        <table id="table_p1_header" class="pan-header">
            <tr>
                <td class="pan-header-left">ხელშეკრულება  </td>
                <td class="pan-header-right"><span class="panel-info"></span><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></td>
            </tr>
        </table>
    </div>

    <div class="panel-body">

        <table class="blokinfo"> <tr >
            <td>ხელშეკრულების მონაცემები </td>
            <td class="pan-header-right"><a id="agr_history" href="../php_code/get_agr_history.php" target="_blank" class="btn btn-default btn-sm">H</a></td>
        </tr></table>

        <form id="form_31" method="post">
            <input id="agrID_f31" type="hidden" name="agrID" value="">
            <input id="iphoneID_f31" type="hidden" name="iphoneID" value="">
            <input id="applid_ID_f31" type="hidden" name="applid_ID" value="">
        <table class="inputs">
            <tr>
                <td>
                    <label for="sel_organization_f31">ორგანიზაცია</label>
                    <select class="form-control" id="sel_organization_f31" name="organization" required>
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td>
                    <label for="agrN_f31">ხელშეკრულების N</label>
                    <input type="text" class="form-control" id="agrN_f31" placeholder="" name="agrN">
                </td>
                <td>
                    <label for="agrStart_f31">გაფორმების თარიღი</label>
                    <input type="date" id="agrStart_f31" class="form-control" name="agrStart">
                </td>
                <td>
                    <label for="agrFinish_f31">დახურვის თარიღი</label>
                    <input type="date" id="agrFinish_f31" class="form-control" name="agrFinish">
                </td>
                <td>
                    <label for="sel_status_f31">სტატუსი</label>
                    <select class="form-control" id="sel_status_f31" name="status">
                        <option value="">Choose...</option>
                    </select>
                </td>
            </tr>
        </table>
        <table class="inputs">
            <tr>
                <td>
                    <label for="sel_branch_f31">ფილიალი</label>
                    <select class="form-control" id="sel_branch_f31" name="branch" required>
                        <option value="">Choose...</option>
                    </select>
                </td>

                <td style="width: 50%">
                    <label for="comment_f31">შენიშვნა</label>
                    <input type="text" class="form-control" id="comment_f31" placeholder="" name="comment">
                </td>
                <td class="albuttom">
                    <button id="btn_edit_f31" type="button" class="btn btn-primary">რედაქტირება</button>
                    <button id="btn_save_f31" type="submit" class="btn btn-primary">შენახვა</button>
                    <button id="btn_addiphone_f31" type="button" class="btn btn-primary">Add iPhone</button>
                </td>
            </tr>
        </table>
        </form>

    </div>
</div>

<!-- iPhones panel - f32    ****************   -->

<div id="pan_f32" class="panel panel-primary">
    <div class="panel-heading">
        <table id="table_p1_header" class="pan-header">
            <tr>
                <td class="pan-header-left">iPhone</td>
                <td class="pan-header-right"><span class="panel-info"></span><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></td>
            </tr>
        </table>
    </div>

    <div class="panel-body">

        <table id="f32_h1" class="blokinfo"> <tr >
                <td>მობილური ტელეფონის ძებნა/გადმოტანა</td>
                <td class="pan-header-right"><a id="iphone_history" href="../php_code/get_iphone_history.php" target="_blank" class="btn btn-default btn-sm">H</a></td>
            </tr>
        </table>

        <table id="f32_h2" class="inputs" style="width: 100%">
            <tr style="width: 100%">
                <td style="width: 25%">
                    <label for="imei_f32">IMEI</label>
                    <div class="input-group">
                        <input class="form-control" id="imei_f32" placeholder=""  name="imei">
                        <div class="input-group-btn">
                            <button id="btn_go_f32" class="btn btn-default" type="button">Go!</button>
                        </div>
                    </div>
                </td>

                <td style="width: 50%">
                    <label for="result_f32">ძებნის შედეგი</label>
                    <input type="text" class="form-control" id="result_f32" placeholder="" name="result">
                </td>
                <td class="albuttom" style="width: 25%">
                    <button id="btn_view_f32" class="btn btn-primary">View</button>
                    <button id="btn_get_f32" class="btn btn-primary">GET</button>
                    <button id="btn_add_f32" class="btn btn-primary">Add</button>
                </td>
            </tr>
        </table>

        <p>მობილური ტელეფონის მონაცემები</p>
        <form id="form_32">
            <input id="agrID_f32" type="hidden" name="agrID" value="">
            <input id="iphoneID_f32" type="hidden" name="iphoneID" value="">
        <div id="d_f322">
        <table class="inputs">
            <tr>
                <td>
                    <label for="imei_f322">IMEI</label>
                    <input type="text" class="form-control" id="imei_f322" maxlength="15" minlength="15" name="imei" required>
                </td>
                <td>
                    <label for="sel_modeli_f322">მოდელი</label>
                    <select class="form-control" id="sel_modeli_f322" name="modeli">
                        <option value="">Choose...</option>
                    </select>
                </td>
                <td>
                    <label for="serialN_f322">სერიული N</label>
                    <input type="text" class="form-control" id="serialN_f322" placeholder="" name="serialN">
                </td>
                <td>
                    <label for="ios_f322">iOS</label>
                    <select class="form-control" id="ios_f322" name="ios">
                        <option value="">Choose...</option>
                    </select>
                </td>
                <td>
                    <label>
                        <input id="simfree_f322" type="checkbox" name="simfree" value="1"> SIM Free
                    </label>
                </td>
            </tr>
        </table>
        </div>

        <p>მობილურ ტელეფონზე დადებული პაროლები</p>

        <div id="d_f323">
        <table class="inputs">
            <tr>
                <td>
                    <label for="pass_res_f32">Restriction Password</label>

                    <div class="input-group">
                        <input type="text" class="form-control" id="pass_res_f32" name="passRes" maxlength="4" minlength="4">

                        <div class="input-group-btn">
                            <button id="RP_gen" class="btn btn-default passgen4" type="button"><span
                                    class="glyphicon glyphicon-refresh"
                                    aria-hidden="true"></span></button>
                            <button class="btn btn-default eye" type="button"><span
                                    class="glyphicon glyphicon-eye-close"
                                    aria-hidden="true"></span></button>
                        </div>
                    </div>
                </td>

                <td>
                    <label for="pass_enc_f32">Encryption Password</label>

                    <div class="input-group">
                        <input type="text" class="form-control" id="pass_enc_f32" name="passEnc" maxlength="6" minlength="4">

                        <div class="input-group-btn">
                            <button class="btn btn-default passgen4" type="button"><span
                                    class="glyphicon glyphicon-refresh"
                                    aria-hidden="true"></span></button>
                            <button class="btn btn-default eye" type="button"><span
                                    class="glyphicon glyphicon-eye-close"
                                    aria-hidden="true"></span></button>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table id="tb_scr_lock" class="inputs">
            <tr>
                <td>
                    <label for="sel_status_f32">Screen Lock Status</label>
                    <select class="form-control" id="sel_status_f32" name="SLstatus" required="true">
                    </select>
                </td>
                <td>
                    <label for="pass_lock_f32">Screen Lock Password</label>

                    <div class="input-group">
                        <input type="text" class="form-control" id="pass_lock_f32" placeholder="" name="passLock" maxlength="6" minlength="4">

                        <div class="input-group-btn">
                            <button class="btn btn-default passgen6" type="button"><span
                                    class="glyphicon glyphicon-refresh"
                                    aria-hidden="true"></span></button>
                            <button class="btn btn-default eye" type="button"><span
                                    class="glyphicon glyphicon-eye-close"
                                    aria-hidden="true"></span></button>
                        </div>
                    </div>
                </td>
                <td>
                    <label for="lock_date_f32">Screen Lock Date</label>
                    <input type="date" id="lock_date_f32" class="form-control" name="lockDate">
                </td>
                <td>
                    <label for="lock_send_date_f32">Screen Lock Send Date</label>
                    <input type="date" id="lock_send_date_f32" class="form-control" name="lockSendDate">
                </td>
            </tr>
        </table>
        </div>


        <p>სტატუსი და დამატებითი ინფორმაცია</p>
        <div id="d_f324">
        <table class="inputs">
            <tr>
                <td>
                    <label for="sel_status_f324">სტატუსი</label>
                    <select class="form-control" id="sel_status_f324" name="status">
                    </select>
                </td>
                <td>
                    <label for="comment_f324">შენიშვნა</label>
                    <input type="text" class="form-control" id="comment_f324" placeholder="" name="comment">
                </td>
            </tr>
        </table>
        <table class="inputs">
            <tr>
                <td></td>
                <td style="text-align: right; width: 100%">
                    <button type="button" id="btn_edit_f32" class="btn btn-primary">რედაქტირება</button>
                    <button type="submit" id="btn_save_f32" class="btn btn-primary">შენახვა</button>
                    <button type="button" id="btn_addapplid_f32" class="btn btn-primary">Add Appl ID</button>
                </td>
            </tr>
        </table>
        </form>

        </div>
    </div>
</div>

<!-- Appl ID panel - f33       ******************88******************************************************     -->

<div id="pan_f33" class="panel panel-primary">
    <div class="panel-heading">
        <table id="table_p1_header" class="pan-header">
            <tr>
                <td class="pan-header-left">Apple ID</td>
                <td class="pan-header-right"><span class="panel-info"></span><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></td>
            </tr>
        </table>
    </div>

    <div class="panel-body">

        <table class="blokinfo"> <tr >
                <td>Appl ID -ის ძებნა/გადმოტანა/დამატება</td>
                <td class="pan-header-right"><a id="apl_history" href="../php_code/get_applid_history.php" target="_blank" class="btn btn-default btn-sm">H</a></td>
            </tr>
        </table>

        <table class="inputs">
            <tr style="width: 100%">
                <td style="width: 30%">
                    <label for="applid_f33">ApplID</label>
                    <div class="input-group">
                        <input class="form-control" id="applid_f33" placeholder="" name="applID">
                        <div class="input-group-btn">
                            <button id="btn_go_f33" class="btn btn-default" type="button">Go!</button>
                        </div>
                    </div>
                </td>

                <td style="width: 50%">
                    <label for="result_f33">ძებნის შედეგი</label>
                    <input type="text" class="form-control" id="result_f33" placeholder="" name="result">
                </td>
                <td class="albuttom" style="width: 20%">
                    <button type="button" id="btn_get_f33" class="btn btn-primary">GET</button>
                    <button type="button" id="btn_addApplid_f33" class="btn btn-primary">Free Appl ID</button>
                </td>
            </tr>
        </table>

        <p>ფილიალის და ელ.ფოსტის მონაცემები</p>

        <form action="" method="post" id="form_33">
            <input id="agrID_f33" type="hidden" name="agrID" value="">
            <input id="applid_ID_f33" type="hidden" name="applid_ID" value="">
            <input id="email_ID_f33" type="hidden" name="email_ID" value="0">

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="sel_organization_f33">ორგანიზაცია</label>
                    <select class="custom-select form-control" id="sel_organization_f33" name="organization"
                            required>
                        <option value="">აირჩიეთ...</option>
                    </select>
                </div>

                <div class="col-lg-3 mb-3">
                    <div>
                        <label for="email_f33">ელ. ფოსტა</label>
                        <input type="text" class="form-control" id="email_f33" placeholder="" name="e_mail">
                    </div>
                </div>

                <div class="col-lg-4">
                    <label for="emailpass_f33">პაროლი</label>

                    <div class="input-group">
                        <input type="password" class="form-control" id="emailpass_f33" placeholder="" name="emailpass">

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



                <p>Appl ID</p>

                <div class="row">
                    <div class="col-lg-3">
                        <label for="firstname">სახელი</label>
                        <input type="text" class="form-control" id="firstname" placeholder="სახელი" name="saxeli" required>
                    </div>
                    <div class="col-lg-2">
                        <label for="lastname">გვარი</label>
                        <input type="text" class="form-control" id="lastname" placeholder="გვარი" name="gvari">
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3">
                        <label for="appl_id_f33">Appl ID</label>
                        <input type="text" class="form-control" id="appl_id_f33" placeholder="appl mail" name="applid" readonly>
                    </div>
                    <div class="col-lg-3">
                        <label for="appl_id_pass_f33">appl id pass</label>

                        <div class="input-group">
                            <input type="password" class="form-control equalsimbols" id="appl_id_pass_f33" name="applidpass" readonly>

                            <div class="input-group-btn">
                                <button id="btn_f33ApplPassGen" class="btn btn-default passgen_apl" type="button"><span
                                        class="glyphicon glyphicon-refresh"
                                        aria-hidden="true"></span></button>
                                <button class="btn btn-default eye0" type="button" data-whatever="applidpass"><span
                                        class="glyphicon glyphicon-eye-open"
                                        aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                    blok2 line2 -->
                <div class="row">
                    <div class="col-lg-3">
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
                        <select class="form-control" id="sel_rmail" name="rmail">
                            <option value="x">აირჩიეთ...</option>
                        </select>
                    </div>
                </div>
                <!--                    blok2 line3 -->
                <div class="row">
                    <div class="col-lg-5">
                        <label for="sel_q1">SequrityQuestion 1</label>
                        <select class="form-control" id="sel_q1" name="q1">
                            <option value="">აირჩიეთ...</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="ans1">Answer 1</label>

                        <div class="input-group">
                            <input type="password" class="form-control" id="ans1" placeholder="" name="ans1">

                            <div class="input-group-btn">
                                <button class="btn btn-default passgen" type="button"><span
                                        class="glyphicon glyphicon-refresh"
                                        aria-hidden="true"></span></button>
                                <button class="btn btn-default eye0" type="button" data-whatever="sq1"><span
                                        class="glyphicon glyphicon-eye-open"
                                        aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                    blok2 line4 -->
                <div class="row">
                    <div class="col-lg-5">
                        <label for="sel_q2">SequrityQuestion 2</label>
                        <select class="form-control" id="sel_q2" name="q2">
                            <option value="">აირჩიეთ...</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="ans2">Answer 2</label>

                        <div class="input-group">
                            <input type="password" class="form-control" id="ans2" placeholder="" name="ans2">

                            <div class="input-group-btn">
                                <button class="btn btn-default passgen" type="button"><span
                                        class="glyphicon glyphicon-refresh"
                                        aria-hidden="true"></span></button>
                                <button class="btn btn-default eye0" type="button" data-whatever="sq2"><span
                                        class="glyphicon glyphicon-eye-open"
                                        aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                    blok2 line5 -->
                <div class="row">
                    <div class="col-lg-5">
                        <label for="sel_q3">SequrityQuestion 3</label>
                        <select class="form-control" id="sel_q3" name="q3">
                            <option value="">აირჩიეთ...</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="ans3">Answer 3</label>

                        <div class="input-group">
                            <input type="password" class="form-control" id="ans3" placeholder="" name="ans3">

                            <div class="input-group-btn">
                                <button class="btn btn-default passgen" type="button"><span
                                        class="glyphicon glyphicon-refresh"
                                        aria-hidden="true"></span></button>
                                <button class="btn btn-default eye0" type="button" data-whatever="sq3"><span
                                        class="glyphicon glyphicon-eye-open"
                                        aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <p>სტატუსი და დამატებითი ინფორმაცია</p>
                <!--                    blok2 line6 -->
                <div class="row">
                    <div class="col-lg-2">
                        <label for="sel_status_f33">სტატუსი</label>
                        <select class="form-control" id="sel_status_f33" name="status">
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="date_f33">შექმნის თარიღი</label>
                        <input type="date" class="form-control" id="date_f33" name="createDate">
                    </div>
                    <div class="col-lg-7">
                        <label for="comment_f33">შენიშვნა</label>
                        <input type="text" class="form-control" id="comment_f33" placeholder="" name="comment">
                    </div>
                </div>
                <br>

            </form>

            <div class="row">
                <div class="col-md-12 mb-4">
                    <button id="btn_f3edit" class="btn btn-primary">რედაქტირება</button>
                    <button id="btn_f3submit" class="btn btn-primary">შენახვა</button>
                </div>
            </div>

    </div>
</div>