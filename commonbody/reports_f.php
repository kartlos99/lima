<div>
<div class="toright">
    <a href="agr_exp.php" class="btn btn-default btn-sm">ხელშეკრულებების სრული ჩამონათვლის ექსპორტი <span class="glyphicon glyphicon-download"></a>
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-justified" role="tablist">
  <li role="presentation" class="active"><a href="#viewrep1" aria-controls="home" role="tab" data-toggle="tab">ApplID stat</a></li>
  <li role="presentation"><a href="#viewrep2" aria-controls="profile" role="tab" data-toggle="tab">მომხმ.ნამუშევარი</a></li>
  <li role="presentation"><a href="#viewrep3" aria-controls="messages" role="tab" data-toggle="tab">ნანახი პაროლები</a></li>
  <li role="presentation"><a href="#viewrep4" aria-controls="settings" role="tab" data-toggle="tab">ApplID სტ.ცვლილება</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="viewrep1">
        <p><a href="rep1_exp.php" >ჩამოტვირთვა <span class="glyphicon glyphicon-download"></a></p>
        <!-- <a href="rep1_exp.php" class="btn btn-default btn-sm">ჩამოტვირთვა<span class="glyphicon glyphicon-download"></a> -->
        <div>
            <table id="rep1_table" class="table justhover"></table>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="viewrep2">
        <p><a href="rep2_exp.php" >ჩამოტვირთვა <span class="glyphicon glyphicon-download"></a></p>
        <form id="form_viewrep2" method="post">
            <table class="inputs">
                <tr>
                    <td>
                        <label for="datefrom_vr2">თარიღი-დან</label>
                        <input type="date" id="datefrom_vr2" class="form-control d1" name="datefrom">
                    </td>
                    <td>
                        <label for="dateto_vr2">თარიღი-მდე</label>
                        <input type="date" id="dateto_vr2" class="form-control d2" name="dateto">
                    </td>
                    <td class="albuttom">
                        <button id="btn_vr2_done" type="submit" class="btn btn-primary">Go</button>
                    </td>
                </tr>
            </table>
        </form>
        <div class="table-responsive">
            <table id="rep2_table" class="table justhover"></table>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="viewrep3">
        <p><a id="rep3_down_link" href="rep3_exp.php" >ჩამოტვირთვა <span class="glyphicon glyphicon-download"></a></p>
        <form id="form_viewrep3" method="post">
            <table class="inputs">
                <tr>
                    <td>
                        <label for="sel_organization_vr3">ორგანიზაცია</label>
                        <select class="form-control" id="sel_organization_vr3" name="organization">
                            <option value="">აირჩიეთ...</option>
                        </select>
                    </td>
                    <td>
                        <label for="sel_username_vr3">მომხმარებელი</label>
                        <select class="form-control" id="sel_username_vr3" name="username">
                            <option value="">აირჩიეთ...</option>
                        </select>
                    </td>
                    <td>
                        <label for="datefrom_vr3">თარიღი-დან</label>
                        <input type="date" id="datefrom_vr3" class="form-control d1" name="datefrom">
                    </td>
                    <td>
                        <label for="dateto_vr3">თარიღი-მდე</label>
                        <input type="date" id="dateto_vr3" class="form-control d2" name="dateto">
                    </td>
                    <td class="albuttom">
                        <button id="btn_vr3_done" type="submit" class="btn btn-primary">Go</button>
                    </td>
                </tr>
            </table>
            <input id="f11_pageN" type="hidden" name="pageN" value="0" />
        </form>
        <div>
            <table id="rep3_table" class="table justhover"></table>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                </ul>
            </nav>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="viewrep4">
        <p><a id="rep4_down_link" href="rep4_exp.php" >ჩამოტვირთვა <span class="glyphicon glyphicon-download"></a></p>
        <form id="form_viewrep4" method="post">
            <table class="inputs">
                <tr>
                    <td>
                        <label for="datefrom_vr4">თარიღი-დან</label>
                        <input type="date" id="datefrom_vr4" class="form-control d1" name="datefrom">
                    </td>
                    <td>
                        <label for="dateto_vr4">თარიღი-მდე</label>
                        <input type="date" id="dateto_vr4" class="form-control d2" name="dateto">
                    </td>
                    <td class="albuttom">
                        <button id="btn_vr4_done" type="submit" class="btn btn-primary">Go</button>
                    </td>
                </tr>
            </table>
        </form>
        <div>
            <table id="rep4_table" class="table justhover"></table>
        </div>
    </div>
</div>

</div>