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

    <table class="title-table">
        <tbody>
        <tr>

            <td>
                <label>საქმის რეკვიზიტები</label>
            </td>
            <td>
                <div class="toright">
                    <div class="inline-div">
                        <span id="caseN" class="red-in-title">case N</span>
                    </div>
                    <div class="inline-div">
                        <span>მფლობელი</span> <br/>
                        <span id="currOwner">user</span>
                    </div>
                    <div class="inline-div">
                        <span>დაწერის თარიღი</span> <br/>
                        <input type="date" id="get_started_date_id" name="get_started_date" form="caseform" class="ge-date-format in-title" data-date="" data-date-format="DD/MM/YYYY" value="">
                    </div>
                    <div class="inline-div">
                        <i id="btnUserCh" class="fas fa-users btn"></i>
                        <i id="btnUserHist" class="fas fa-history btn"></i>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <form id="caseform" action="">
        <input type="hidden" id="caseID" name="caseID" value="0">
        <input type="hidden" id="ownerID" name="ownerID" value="0">
        <input type="hidden" id="userID" name="userID" value="<?= $_SESSION['userID'] ?>">


        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "სტატუსი", "case_status", getDictionariyItems($conn, 'PCM_aplication_status')) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ეტაპი", "case_stage", getDictionariyItems($conn, 'pcm_stage')) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ინსტანცია", "instance", getDictionariyItems($conn, 'instance')) ?>
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
<!--                <td>-->
<!--                    <button class="btn"><i class="fas fa-history"></i></button>-->
<!--                </td>-->
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
                    <?= DrawView::selector($id_simple, "სესხის ტიპი", "loan_type", getDictionariyItems($conn, 'loan_type')) ?>
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
                    <td class="toright"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></td>
                </tr>
            </table>
        </div>
        <div class="panel-body">
            <?php include 'instance.php'; ?>
        </div>
    </div>

<?php
$id_simple = "i2_id";
$namePref = "i2_";
?>
    <div id="Instance1" class="panel panel-primary">
        <div class="panel-heading">
            <table id="table_instance1_header" class="table-section">
                <tr>
                    <td>სააპელაციო სარჩელი</td>
                    <td class="toright"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></td>
                </tr>
            </table>
        </div>
        <div class="panel-body">
            <?php include 'instance.php'; ?>
        </div>
    </div>

<?php
$id_simple = "i3_id";
$namePref = "i3_";
?>
    <div id="Instance1" class="panel panel-primary">
        <div class="panel-heading">
            <table id="table_instance1_header" class="table-section">
                <tr>
                    <td>უზენაესის სარჩელი</td>
                    <td class="toright"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></td>
                </tr>
            </table>
        </div>
        <div class="panel-body">
            <?php include 'instance.php'; ?>
        </div>
    </div>


<?= DrawView::titleRow("სააღსრულებლო პროცესი") ?>
<?php $id_simple = "enf_id" ?>
    <table class="table-section">
        <tbody>
        <tr>
            <td>
                <?= DrawView::selector($id_simple, "სტატუსი", "enf_status", getDictionariyItems($conn, 'exec_status'), $caseForm) ?>
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
                <?= DrawView::selector($id_simple, "შედეგი", "enf_result", getDictionariyItems($conn, 'exec_result'), $caseForm) ?>
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
                <?= DrawView::selector($id_simple, "სტატუსი", "baj_status", getDictionariyItems($conn, 'duty_status'), $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "baj_request_time", "მოთხოვნა", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "baj_take_time", "მიღება", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "შედეგი", "baj_result", getDictionariyItems($conn, 'duty_result'), $caseForm) ?>
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
                <?= DrawView::selector($id_simple, "სტატუსი", "settle_status", getDictionariyItems($conn, 'sett_status'), $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "settle_start_time", "დაწყება", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "settle_time", "მორიგების თარიღი", "", "date", $caseForm) ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "შედეგი", "settle_result", getDictionariyItems($conn, 'sett_result'), $caseForm) ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "ვალუტა", "settle_currency", getDictionariyItems($conn, 'currency'), $caseForm) ?>
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

    <?php $id_simple = "id" ?>
    <table class="table-section">
    <tbody>
    <tr>
        <td>
            <div>
                <label for="case_note_<?= $id_simple ?>">დამატებითი ინფორმაცია</label>
            </div>
            <div>
                <textarea name="case_note" id="case_note_<?= $id_simple ?>" rows="4" form="caseform"></textarea>
            </div>
        </td>
    </tr>
    </tbody>
</table>

<div class="panel-footer">
    <button id="btnSaveCase" class="btn"><b>დამახსოვრება</b></button>
</div>


<?php
include_once 'userChangeModal.php';
include_once 'userHistModal.php';
include_once 'footer.php';
?>