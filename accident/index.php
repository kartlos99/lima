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

<?= DrawView::titleRow("მიმდინარე და მოგვარებული ინციდენტები") ?>

    <form id="caseFilterForm" action="">
        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::simpleInput($id_simple, "accident_N", "ინციდენტის N", "", "text") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ტიპი", "TypeID", getDictionariyItems($conn, 'im_type')) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "კრიტიკულობა", "PriorityID", getDictionariyItems($conn, 'im_priority')) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "სტატუსი", "StatusID", getDictionariyItems($conn, 'im_status')) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "მფლობელი პირი", "OwnerID", getOwners($conn, 3)) ?>
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
                    <?= DrawView::selector($id_simple, "ორგანიზაცა", "organization") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ფილიალი", "filial") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "AgrNumber", "ხელშეკრულება N", "", "text") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "დამრღვევი პირი", "guiltyUserID", getOwners($conn, 3)) ?>
                </td>
                <td>
                    <?= DrawView::doubleDateInput($id_simple, "fix_date", "დაფიქსირების თარიღი (დან - მდე)", "", "date") ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "კატეგორია", "CategoryID") ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ქვე კატეგორია", "SubCategoryID") ?>
                </td>
                <td>

                </td>
                <td>
                    <?= DrawView::selector($id_simple, "აღმომჩენი პირი", "DiscovererID", getOwners($conn, 3)) ?>
                </td>
                <td>
                    <?= DrawView::doubleDateInput($id_simple, "discover_date", "აღმოჩენის თარიღი (დან - მდე)", "", "date") ?>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <button id="btnSearchApp" class="btn"><b>ძებნა</b></button>
                    <button id="btnClearApp" class="btn"><b>გასუფთავება</b></button>
                </td>
                <td>
                    <label for="not_in_statistic_id">
                        <input id="not_in_statistic_id" name="NotInStatistics" type="checkbox"/> არ მონაწილეობს სტატისტიკაში</label>
                    <br><label for="dublicas_id">
                        <input id="dublicas_id" name="duplicates" type="checkbox"/> დუბლიკატები</label>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "შემსრულებელი პირი", "SolverID", getOwners($conn, 3)) ?>
                </td>
                <td>
                    <?= DrawView::doubleDateInput($id_simple, "SolveDate", "მოგვარების თარიღი (დან - მდე)", "", "date") ?>
                </td>
            </tr>
            </tbody>
        </table>
        <input id="casePageN" type="hidden" name="pageN" value="1"/>
    </form>
    <!--    <div class="toright panel-footer">-->
    <!--        <button id="btnSearchApp" class="btn"><b>ძებნა</b></button>-->
    <!--        <button id="btnClearApp" class="btn"><b>გასუფთავება</b></button>-->
    <!--        <button id="btnCaseExp" class="btn">EXP<i class="fas fa-arrow-alt-circle-down"></i></button>-->
    <!--    </div>-->

<?= DrawView::subTitle("ფილტრაციის შედეგი") ?>

    <table id="tb_case_list" class="table-section table">
        <thead>
        <tr>
            <?= headerRow(["ID", "კატეგორია", "ქვეკატეგორია", "ორგანიზაცია", "ხელშეკრ.", "სტატუსი", "მფლობელი", "დაფიქსირება"], 0, 1) ?>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div class="pg_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul id="my-pagination" class="pagination-sm"></ul>
                </div>
            </div>
        </div>
    </div>


<?php include_once 'footer.php'; ?>