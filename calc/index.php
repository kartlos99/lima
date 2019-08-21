<?php
/**
 * Created by PhpStorm.
 * User: natub
 * Date: 7/14/2019
 * Time: 10:54 PM
 */
include_once 'DrawView.php';
include_once 'common_functions.php';
include_once 'header.php';
$id_simple = "id";
$note = "შენიშვნა";

?>

<?= DrawView::titleRow("ტექნიკის შეფასების განაცხადები") ?>
    <form id="appFilterForm" action="">
        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "ტიპი", "type") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ბრენდი", "brand") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "მოდელი / კლასი", "model") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "modelbyhand", "მოდელი (ხელოვნური განსაზღვრა)") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "serial_N", "სერიული_N") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "imei", "IMEI კოდი") ?>
                </td>
            </tr>
            </tbody>
        </table>
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
                    <?= DrawView::simpleInput($id_simple, "operator", "ოპერატორი") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "application_N", "განაცხადის_N") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "date_from", "განაცხადის თარიღი (დან)", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "date_till", "განაცხადის თარიღი (მდე)", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "agreement_N", "ხელშეკრულება_N") ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table-section">
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "განაცხადის სტატუსი", "application_status", getStatusItems($conn, "app_states")) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "საკონტროლო შეფასების შედეგი", "control_rate_result", getStatusItems($conn, "control_estimate_states")) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "დეტალური შეფასების შედეგი", "detail_rate_result", getStatusItems($conn, "control_estimate_states")) ?>
                </td>
                <td>
                    <button id="btnSearchApp" class="btn"><b>ძებნა</b></button>
                </td>
                <td>
                    <button id="btnClearApp" class="btn"><b>გასუფთავება</b></button>
                </td>
            </tr>
        </table>
    </form>

    <p id="titleForAppTable" class="mytbtitle"></p>
    <table id="appListTable" class="table-bordered table">
        <thead>
        <tr>
            <?= headerRow(["ID", "ტიპი", "ბრენდი", "მოდელი", "განცხადება", "თარიღი", "განცხ. სტატუსი", "ოპერატორი", "ორგანიზ.", "ხელშეკრ.", "საკონტრ.", "დეტალური"], 0, 1) ?>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

<?= DrawView::titleRow("ტექნიკის ღირებულებისა და შეფასების კრიტერიუმები") ?>
<?php $id_simple = "id2" ?>

    <form id="critListForm" action="">

    <table class="table-section">
        <tbody>
        <tr>
            <td>
                <?= DrawView::selector($id_simple, "ტიპი", "type") ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "ბრენდი", "brand") ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "მოდელი / კლასი", "model") ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "ღირებულებისა და კრიტერიუმების წონების სტატუსი", "price_criteria_status", getStatusItems($conn, 'tech_and_crit_weight_states')) ?>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="table-section">
        <tbody>
        <tr>
            <td>
                <?= DrawView::selector($id_simple, "ღირებულების სტატუსი", "price_status", getStatusItems($conn, 'price_calc_item_states')) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "price_date_from", "ღირებ. გადახედვის თარიღი (დან-მდე)", "", "date") ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "price_date_till", "", "", "date") ?>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="table-section">
        <tr>
            <td>
                <?= DrawView::selector($id_simple, "კრიტერიუმების ჯგუფი", "criteria_group", getCriteriumItems($conn)) ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "შეფასების კრიტერიუმი", "criteria") ?>
            </td>
            <td>
                <?= DrawView::selector($id_simple, "კრიტ. სტატუსი", "criteria_status", getStatusItems($conn, 'estimate_criteriums')) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "krit_date_from", "კრიტ. გადახედვის თარიღი (დან-მდე)", "", "date") ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "krit_date_till", "", "", "date") ?>
            </td>
            <td>
                <button id="btnSearchCrit" class="btn"><b>ძებნა</b></button>
            </td>
            <td>
                <button id="btnClearCrit" class="btn"><b>გასუფთავება</b></button>
            </td>
        </tr>
    </table>

    </form>

    <p id="titleForTechPriceTable" class="mytbtitle"></p>
    <table id="critListTable" class="table-bordered table">
        <thead>
        <tr>
            <?= headerRow(["ID", "ტიპი", "ბრენდი", "მოდელი", "ღირ.კრიტ. წონის სტატუსი", "ღირ. სტატუსი", "ღირ. გადახ. თარიღი", "მახას. ჯგუფი", "მახას. კრიტერიუმი", "კრიტ. სტატუსი", "კრიტ. გადახ. თარიღი"], 0, 1) ?>
        </tr>
        </thead>
        <tbody></tbody>
    </table>


<?php include_once 'footer.php'; ?>