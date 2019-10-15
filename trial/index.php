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

<?= DrawView::titleRow("მიმდინარე და დასრულებული საქმეები") ?>

<?= DrawView::subTitle("საქმის რეკვიზიტები") ?>
    <form id="caseFilterForm" action="">
        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::simpleInput($id_simple, "case_N", "საქმის N", "", "text") ?>
                </td>
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
                    <?= DrawView::doubleDateInput($id_simple, "create_date", "შექმნის თარიღი (დან - მდე)", "", "date") ?>
                </td>
            </tr>
            </tbody>
        </table>


        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::doubleDateInput($id_simple, "receive_date", "მიღების თარიღი (დან - მდე)", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::doubleDateInput($id_simple, "distr_date", "განაწილების თარიღი (დან - მდე)", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "მფლობელი", "case_owner", getOwners($conn, 4)) ?>
                </td>

            </tr>
            <tr>
                <td>
                    <?= DrawView::doubleDateInput($id_simple, "close_date", "დასრულების თარიღი (დან - მდე)", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::doubleDateInput($id_simple, "own_date", "დაწერის თარიღი (დან - მდე)", "", "date") ?>
                </td>
            </tr>
            </tbody>
        </table>

        <?= DrawView::subTitle("პრობლემური სესხის ხელშეკრულების მონაცემები") ?>
        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::simpleInput($id_simple, "agreement_N", "ხელშეკრულება N", "", "text") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "agreem_date", "გაფორმების თარიღი", "", "date") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ორგანიზაცა", "organization") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ფილიალი", "filial") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "borrower", "მსესხებელი") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "borrower_PN", "მსესხებლის პირადი N") ?>
                </td>
                <td>
                    <label for="reminder_id">შემახსენებელი</label>
                    <input id="reminder_id" name="reminder" type="checkbox" data-toggle="toggle"
                           data-on="ჩართულია" data-off="გათიშულია">
                </td>

            </tr>
            </tbody>
        </table>
    </form>
    <div class="toright panel-footer">
        <button id="btnSearchApp" class="btn"><b>ძებნა</b></button>
        <button id="btnClearApp" class="btn"><b>გასუფთავება</b></button>
    </div>

<?= DrawView::subTitle("ფილტრაციის შედეგი") ?>

    <table id="tb_case_list" class="table-section table">
        <thead>
        <tr>
            <?= headerRow(["ID", "საქმის N", "სტატუსი", "ეტაპი", "ორგანიზაცია", "ხელშეკრულება N", "მსესხებელი"], 0, 1) ?>
        </tr>
        </thead>
        <tbody></tbody>
    </table>


<?php include_once 'footer.php'; ?>