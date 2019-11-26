<?php
/**
 * Created by PhpStorm.
 * User: natub
 * Date: 7/14/2019
 * Time: 10:54 PM
 */

if (!isset($_SESSION['username']) || !isset($_SESSION['permissionM3']['view_report'])) {
    die("login / no access");
}
include_once 'DrawView.php';
include_once 'common_functions.php';
include_once 'header.php';
$id_simple = "id";
$note = "შენიშვნა";
$currDay = date("Y-m-d", time());
?>

<?= DrawView::titleRow("რეპორტები") ?>

    <form id="reportFilterForm">
        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "ორგანიზაცა", "organization") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ფილიალი", "filial") ?>
                </td>
                <td>
                    <label class="required">დაფიქსირების თარიღი (დან - მდე)</label>
                    <table class="table-section">
                        <tr>
                            <td>
                                <input type="date" class="form-control" id="fix_date_from_id" name="fix_date_from" required value="<?= $currDay ?>">
                            </td>
                            <td>
                                <input type="date" class="form-control" id="fix_date_to_id" name="fix_date_to" required value="<?= $currDay ?>">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "დამრღვევი პირი", "guilty_person_id", getPersons($conn, PERSON_GUILTY)) ?>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "კატეგორია", "CategoryID") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ქვე კატეგორია", "SubCategoryID") ?>
                </td>
                <td class="toright">
                    <button id="btnClearApp" class="btn"><b>გასუფთავება</b></button>
                </td>
            </tr>
            </tbody>
        </table>
        <input id="repMode" type="hidden" name="rep_mode" value="day"/>
        <input id="repExpMode" type="hidden" name="rep_exp_mode" value="show"/>
    </form>

    <br/><button id="btnRep1" class="btn" style="margin: 4px"><b>რეპორტი 1</b></button>  <label>თვის განმავლობაში ინციდენტების რაოდენობა კატეგორიის და ქვე კატეგორიის მიხედვით (Max 31 დღე).</label>
    <br/><button id="btnRep2" class="btn" style="margin: 4px"><b>რეპორტი 2</b></button>  <label>წლის განმავლობაში ინციდენტების რაოდენობა კატეგორიის და ქვე კატეგორიის მიხედვით (Max 12 თვე).</label>

    <!--    <div class="toright panel-footer">-->
    <!--        <button id="btnSearchApp" class="btn"><b>ძებნა</b></button>-->
    <!--        <button id="btnClearApp" class="btn"><b>გასუფთავება</b></button>-->
    <!--        <button id="btnCaseExp" class="btn">EXP<i class="fas fa-arrow-alt-circle-down"></i></button>-->
    <!--    </div>-->

<?= DrawView::subTitle("რეპორტი 1") ?>
    <p id="rep1FilterQuery" class="filter-text">ფილტრაცია: <span></span></p>

    <table id="tbRep1" class="table-bordered">
        <thead>
        <tr>
<!--            --><?//= headerRow(["ID", "კატეგორია", "ქვეკატეგორია", "ორგანიზაცია", "ხელშეკრ.", "სტატუსი", "მფლობელი", "დაფიქსირება"], 0, 1) ?>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

    <button id="btnExpRep1" class="btn">Export to Excel <i class="fas fa-arrow-alt-circle-down"></i></button>

<?= DrawView::subTitle("რეპორტი 2") ?>
    <p id="rep2FilterQuery" class="filter-text">ფილტრაცია: <span></span></p>

    <table id="tbRep2" class="table-bordered">
        <thead>
        <tr>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

    <button id="btnExpRep2" class="btn">Export to Excel <i class="fas fa-arrow-alt-circle-down"></i></button>


<?php include_once 'footer.php'; ?>