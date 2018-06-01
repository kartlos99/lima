<?php
include_once 'header.php';
?>


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

            <button id="btn_newuser" type="submit" class="btn btn-primary btn-sm">ახალი მომხმარებელი</button>
            <a id="btn_search" class="btn btn-primary btn-sm">ძებნა</a>
            <a id="btn_passchange" class="btn btn-primary btn-sm">პაროლის შეცვლა</a>

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
                            <select class="form-control" id="sel_state" name="state">
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
                                <option value="">Choose...</option>
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
                        </td>
                    </tr>
                    <tr>
                        <td>მომხმ.ტიპი</td>
                        <td>
                            <select class="form-control" id="sel_type" name="type">
                                <option value="">აირჩიეთ...</option>
                            </select>
                        </td>
                        <td>პაროლი</td>
                        <td>
                            <input type="text" class="form-control" id="pass1" placeholder="" name="pass1">
                            <input type="text" class="form-control" id="pass2" placeholder="" name="pass2">
                        </td>
                    </tr>

                </table>
                <label>კომენტარი</label>
                <input type="text" class="form-control" id="comment" placeholder="" name="comment">

                <input type="hidden" id="operacia" name="operacia" value="0">

                <button id="btn_f1_done" type="submit" class="btn btn-primary btn-sm">ძებნა</button>
                <a id="btn_f1_reset" class="btn btn-primary btn-sm">გასუფთავება</a>

            </form>

            <p class="info">ძიების შედეგი (იძებნება MAX 20 ჩანაწერი)</p>
            <table id="table_f11" class="datatable"></table>



        </div>
    </div>



<?php
include_once 'footer.php';
?>