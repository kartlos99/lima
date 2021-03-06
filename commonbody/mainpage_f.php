<div id="pan_f11" class="panel panel-primary">
    <div class="panel-heading">
        <table id="table_p1_header" class="pan-header">
            <tr>
                <td class="pan-header-left">ხელშეკრულება და ხელშეკრულების პროექტები</td>
                <td class="pan-header-right"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></td>
            </tr>
        </table>
    </div>

    <div class="panel-body">
        <form id="form_11" method="post">
        <table class="inputs">
            <tr>
                <td>
                    <label for="sel_organization">ორგანიზაცია</label>
                    <select class="form-control" id="sel_organization" name="organization">
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td>
                    <label for="sel_branch">ფილიალი</label>
                    <select class="form-control" id="sel_branch" name="branch">
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td>
                    <label>
                        <input id="onlyme_f11" type="checkbox" name="onlyme" value="1"> მხოლოდ ჩემები
                    </label>                        
                </td>
            </tr>
        </table>
        <table class="inputs">
            <tr>
                <td>
                    <label for="agrN_f11">ხელშეკრულების N</label>
                    <input type="text" class="form-control" id="agrN_f11" placeholder="" name="agrN">
                </td>
                <td>
                    <label for="sel_status_f11">ხელშეკრ. სტატუსი</label>
                    <select class="form-control" id="sel_status_f11" name="status">
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td class="doubleinput">
                    <label for="agrStart1_f11">გაფორმების თარიღი (დან - მდე)</label><br>
                    <input type="date" id="agrStart1_f11" class="form-control" name="agrStart1">
                    <input type="date" id="agrStart2_f11" class="form-control" name="agrStart2">
                </td>
                <td class="doubleinput">
                    <label for="agrFinish1_f11">დახურვის თარიღი (დან - მდე)</label><br>
                    <input type="date" id="agrFinish1_f11" class="form-control" name="agrFinish1">
                    <input type="date" id="agrFinish2_f11" class="form-control" name="agrFinish2">
                </td>
            </tr>
        </table>
        <table class="inputs">
            <tr>
                <td>
                    <label for="imei_f11">IMEI</label>
                    <input type="text" class="form-control" id="imei_f11" placeholder="" name="imei">
                </td>
                <td>
                    <label for="sel_modeli_f11">მოდელი</label>
                    <select class="form-control" id="sel_modeli_f11" name="modeli">
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td>
                    <label for="serialN_f11">სერიული N</label>
                    <input type="text" class="form-control" id="serialN_f11" placeholder="" name="serialN">
                </td>
                <td>
                    <label for="applID_f11">Appl ID</label>
                    <input type="text" class="form-control" id="applID_f11" placeholder="" name="applid">
                </td>
                <td class="albuttom">
                    <button id="btn_search_f11" type="submit" class="btn btn-primary">ძებნა</button>
                    <a id="f11_reset" class="btn btn-primary btn-sm">გასუფთავება</a>
                       <!-- <a href="excel.php?query=1" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-download"></a> -->
                </td>
            </tr>
        </table>
            <input id="f11_pageN" type="hidden" name="pageN" value="0" />
        </form>

        <p class="info">ძიების შედეგი (იძებნება MAX 20 ჩანაწერი)</p>
        <table id="table_f11" class="datatable"></table>

        <nav aria-label="Page navigation">
            <ul id="f11_ul" class="pagination"></ul>
        </nav>

    </div>
</div>

<!-- iPhones panel - f12    ****************   -->

<div id="pan_f12" class="panel panel-primary">
    <div class="panel-heading">
        <table id="table_p1_header" class="pan-header">
            <tr>
                <td class="pan-header-left">iPhones</td>
                <td class="pan-header-right"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></td>
            </tr>
        </table>
    </div>

    <div class="panel-body">

        <table class="inputs">
            <tr>
                <td>
                    <label for="imei_f12">IMEI</label>
                    <input type="text" class="form-control" id="imei_f12" placeholder="" name="imei">
                </td>
                <td>
                    <label for="sel_modeli_f12">მოდელი</label>
                    <select class="form-control" id="sel_modeli_f12" name="modeli">
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td>
                    <label for="serialN_f12">სერიული N</label>
                    <input type="text" class="form-control" id="serialN_f12" placeholder="გვარი" name="serialN">
                </td>
                <td>
                    <label for="ios_f12">iOS</label>
                    <select class="form-control" id="ios_f12" name="ios">
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td>
                    <label for="sel_status_f12">სტატუსი</label>
                    <select class="form-control" id="sel_status_f12" name="status">
                        <option value="">აირჩიეთ...</option>
                    </select>
                </td>
                <td class="albuttom">
                    <button id="btn_search_f12" class="btn btn-primary">ძებნა</button>
                </td>
            </tr>
        </table>

        <p>ძიების შედეგი</p>
        <table id="table_f12" class="datatable"></table>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</div>

<?php
include_once 'mainpage_p3.php';
?>