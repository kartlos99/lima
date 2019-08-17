<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/2/19
 * Time: 12:32 PM
 */

include_once 'header.php';
include_once 'common_functions.php';
include_once 'DrawView.php';
$new_edit = " - ახალი/რედაქტირება";
$id_simple = "id";
$note = "შენიშვნა";

function getStatusItems($dbConn, $sCode)
{
    $list = [];
    $sql = "SELECT id as vv, `code`, `value` as tt
            FROM `States`
            WHERE ObjectID = getobjid('$sCode')
            ORDER BY SortID";
    $result = mysqli_query($dbConn, $sql);
    foreach ($result as $row) {
        $list[] = $row;
    }
    return $list;
}

$tech_and_crit_weight_states = getStatusItems($conn, 'tech_and_crit_weight_states');
$price_calc_item_states = getStatusItems($conn, 'price_calc_item_states');

function getDictionariyItems($dbConn, $dCode)
{
    $list = [];
    $sql = "SELECT di.id as vv, di.ValueText as tt, di.code
            FROM `dictionariyitems` di
            LEFT JOIN dictionaries d
                ON di.`DictionaryID` = d.ID
            WHERE d.Code = '$dCode'
            ORDER BY SortID";
    $result = mysqli_query($dbConn, $sql);
    foreach ($result as $row) {
        $list[] = $row;
    }
    return $list;
}


?>

    <div class="title1"><?= DrawView::titleRow("ტექნიკის ტიპი ბრენდი და მოდელი/კლასი", "", false, true) ?></div>

    <table class="table-section ">

        <tbody>

        <tr class="equal-size">

            <td><?= DrawView::selector($id_simple, "ტიპი", "typename") ?></td>
            <td><?= DrawView::selector($id_simple, "ბრენდი", "brandname") ?></td>
            <td><?= DrawView::selector($id_simple, "მოდელი / კლასი", "modelname") ?></td>
            <td><?= DrawView::selector($id_simple, "ღირებულებისა და კრიტერიუმების წონების სტატუსი", "price_crit_weight_status", $tech_and_crit_weight_states) ?></td>

        </tr>
        </tbody>
    </table>

    <table style="margin: 15px 0 10px 0" class="custom-title">
        <tbody>
        <tr>
            <td style="width: 1%">
                <i class="fas fa-sync-alt fa-2x btn">
            </td>
            <td style="padding: 5px; font-size: 1.2em; background-color: #cdcdcd">
                <label>კრიტერიუმები ობიექტზე: <span class="red-in-title"></span></label>
            </td>
        </tr>
        </tbody>
    </table>

    <form id="tech_price" action="">

        <?= DrawView::titleRow("ტექნიკის ღირებულება", "", false, true) ?>


        <input id="techID" type="hidden" value="0" name="tech_id"/>
        <input id="techPriceRecordID" type="hidden" value="0" name="record_id"/>

        <table id="tb_teknic_price" class="table-section">
            <tbody>

            <tr>
                <?= DrawView::horizontalInput("ახალის საფასური", "price_new", "number") ?>
                <?= DrawView::horizontalInput("სამიზნე ფასი", "price_goal", "select", getDictionariyItems($conn, 'target_price')) ?>
                <?= DrawView::horizontalInput("გაანგარიშების ტიპი", "calc_type", "select", getDictionariyItems($conn, 'CalculateType')) ?>
            </tr>
            <tr>
                <?= DrawView::horizontalInput("საბაზრო ფასი", "price_market", "number") ?>
                <?= DrawView::horizontalInput("ფასზე ზემოქმედება", "price_impact", "select", getDictionariyItems($conn, 'Impact')) ?>
                <?= DrawView::horizontalInput("მაქსიმუმ გასაცემი თანხა", "max_amount", "number") ?>
            </tr>
            <tr>
                <?= DrawView::horizontalInput("კონკურენტის ფასი", "price_competitor", "number") ?>
                <?= DrawView::horizontalInput("ზემოქმედების სახეობა", "impact_type", "select", getDictionariyItems($conn, 'ImpactType')) ?>
                <?= DrawView::horizontalInput("სტატუსი", "status", "select", $price_calc_item_states) ?>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <?= DrawView::horizontalInput("ზემოქმედების მნიშვნელობა", "impact_size", "number") ?>
                <?= DrawView::horizontalInput("გადახედვის ვადა (დღე)", "revision_period", "number", [], "") ?>
            </tr>
            <tr>
                <td colspan="4">
                    <?= DrawView::simpleInput($id_simple, "price_note", $note) ?>
                </td>
                <?= DrawView::horizontalInput("გადახედვის თარიღი", "revision_date", "date") ?>
            </tr>
            </tbody>
        </table>

    </form>


<?= DrawView::titleRow("ტექნიკის შეფასების კრიტერიუმები", "", false, false) ?>

    <table id="tb_technic_criteria" class="" style="width: 100%">
        <thead>
        <tr>
            <?= headerRow(["", "ზემოქმედება", "სახეობა", "მნიშვნელობა", "ძირითადი", "გადახედვის ვადა და თარიღი", "სტატუსი", ""], 5, 2) ?>
        </tr>
        </thead>
        <tbody id="criteriaValueTableBody">

        </tbody>
    </table>

<table class="hidden">
    <tr class="top-line" data-recID="0">
        <?= DrawView::criteriaEditRow(getDictionariyItems($conn, 'ImpactV2'), getDictionariyItems($conn, 'ImpactType'), $price_calc_item_states) ?>
    </tr>
</table>




<?php include_once 'footer.php'; ?>