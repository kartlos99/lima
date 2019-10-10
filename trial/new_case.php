<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 10/3/19
 * Time: 3:43 PM
 */
include_once 'DrawView.php';
include_once 'common_functions.php';
include_once 'header.php';
$id_simple = "id";
$note = "შენიშვნა";
$caseForm = "caseform";
?>
    <i class="fas fa-history"></i>
    <i class="fas fa-users"></i>

    <table class="title-table">
        <tbody>
        <tr>

            <td>
                <label>საქმის რეკვიზიტები</label>
            </td>
            <td>
                <div>
                    <table id="tb_in_title" class="pos-right">
                        <tr>
                            <td>
                                <span id="caseN" class="red-in-title">case N</span>
                            </td>
                            <td>
                                <span>მფლობელი</span> <br/>

                                <p id="currOwner">user</p>
                            </td>
                            <td>
                                <span>დაწერის თარიღი</span> <br/>
                                <input type="date" id="get_started_date_id" name="get_started_date">
                            </td>
                            <td>
                                <i class="fas fa-users btn"></i>
                                <i class="fas fa-history btn"></i>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <form id="caseform" action="">
        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "სტატუსი", "case_status") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ეტაპი", "case_stage") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ინსტანცია", "instance") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "time_of_begin", "მიღება", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "time_of_distribution", "განაწილება", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "time_of_finish", "დასრულება", "", "date") ?>
                </td>
                <td>
                    <button class="btn"><i class="fas fa-history"></i></button>
                </td>
            </tr>
            </tbody>
        </table>

        <?= DrawView::titleRow("პრობლემური სესხის ხელშეკრულების მონაცემები") ?>

        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::simpleInput($id_simple, "agreement_N", "ხელშეკრულება N") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "date_of_decoration", "გაფორმების თარიღი", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ორგანიზაცა", "organization") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ფილიალი", "filial") ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table-section">
            <tr>
                <td>
                    <?= DrawView::simpleInput($id_simple, "client_name", "მსესხებლის სახელი და გვარი") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "client_N", "მსესხებლის პირადი N") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "client_address", "მსესხებლის მისამართი") ?>
                </td>

            </tr>
        </table>
    </form>
    <br/>



<?php
$id_simple = "i1_id";
$namePref = "i1_";
?>
    <div id="Instance1" class="panel panel-primary">
        <div class="panel-heading">
            <table id="table_instance1_header" class="table-section">
                <tr>
                    <td>პირველი ინსტანციის სარჩელი</td>
                    <td class="toright"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></td>
                </tr>
            </table>
        </div>
        <div class="panel-body">
            <?php include 'instance.php'; ?>
        </div>
    </div>

    <br/>

<?php
$id_simple = "i2_id";
$namePref = "i2_";
?>
    <div id="Instance1" class="panel panel-primary">
        <div class="panel-heading">
            <table id="table_instance1_header" class="table-section">
                <tr>
                    <td>სააპელაციო სარჩელი</td>
                    <td class="toright"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></td>
                </tr>
            </table>
        </div>
        <div class="panel-body">
            <?php include 'instance.php'; ?>
        </div>
    </div>

    <br/>

<?php
$id_simple = "i3_id";
$namePref = "i3_";
?>
    <div id="Instance1" class="panel panel-primary">
        <div class="panel-heading">
            <table id="table_instance1_header" class="table-section">
                <tr>
                    <td>უზენაესის სარჩელი</td>
                    <td class="toright"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></td>
                </tr>
            </table>
        </div>
        <div class="panel-body">
            <?php include 'instance.php'; ?>
        </div>
    </div>

    <br/>


<?= DrawView::titleRow("სააღსრულებლო პროცესი") ?>
<?php $id_simple = "enf_id" ?>
    <table class="table-section">
        <tbody>
        <tr>
            <td>
                <?= DrawView::selector($id_simple, "სტატუსი", "enf_status", [], $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "enf_request_time", "მოთხოვნა", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "enf_take_time", "მიღება", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "enf_start_time", "იძ. აღსრულების დაწყება", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "შედეგი", "enf_result", [], $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "enf_amount", "ჩამორიცხული თანხა", "", "number", $caseForm) ?>
            </td>
        </tr>
        </tbody>
    </table>

<?= DrawView::titleRow("ბაჟის დაბრუნების პროცესი") ?>
<?php $id_simple = "baj_id" ?>
    <table class="table-section">
        <tbody>
        <tr>
            <td>
                <?= DrawView::selector($id_simple, "სტატუსი", "baj_status", [], $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "baj_request_time", "მოთხოვნა", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "baj_take_time", "მიღება", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "შედეგი", "baj_result", [], $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "baj_amount", "დაბრუნებული ბაჟი", "", "number", $caseForm) ?>
            </td>
        </tr>
        </tbody>
    </table>

<?= DrawView::titleRow("მორიგება საქმეზე") ?>
<?php $id_simple = "settle_id" ?>
    <table class="table-section">
        <tbody>
        <tr>
            <td>
                <?= DrawView::selector($id_simple, "სტატუსი", "settle_status", [], $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "settle_start_time", "დაწყება", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "settle_time", "მორიგების თარიღი", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "შედეგი", "settle_result", [], $caseForm) ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "ვალუტა", "settle_currency", [], $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "settle_footer", "ძირი", "", "number", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "settle_percent", "%", "", "number", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "settle_puncture", "პირგასამტეხლო", "", "number", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "settle_costs", "ხარჯები", "", "number", $caseForm) ?>
            </td>
        </tr>
        </tbody>
    </table>


    <button id="btnSaveCase" class="btn"><b>დამახსოვრება</b></button>


<?php include_once 'footer.php'; ?>