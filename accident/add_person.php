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

if (!isset($_SESSION['username']) || !isset($_SESSION['permissionM3']['add_person'])) {
    die("login / no access");
}

$id_simple = "id";
$note = "შენიშვნა";
$caseForm = "caseform";
$required = "required";
?>

<?= DrawView::titleRow("პერსონების მართვა") ?>

    <p id="currOpInfo">მიმდინარე ოპერაცია: <span></span></p>
    <button id="btnStateAdd" class="btn btn-info">დამატება</button>
    <button id="btnStateSearch" class="btn ">ძებნა</button>
    <p></p>

    <form id="person_form" action="">
        <input type="hidden" id="userID" name="userID" value="<?= $_SESSION['userID'] ?>">


        <table class="table-section">
            <tbody>
            <tr>
                <td>
                    <?= DrawView::simpleInput($id_simple, "firstName", "პირის სახელი") ?>
                </td>
                <td>
                    <?= DrawView::simpleInput($id_simple, "lastName", "პირის გვარი") ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "ორგანიზაცა", "organization", [], $required) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "ფილიალი", "filial", [], $required) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= DrawView::selector($id_simple, "ტიპი", "personType", getDictionariyItems($conn, 'im_person_type'), $required) ?>
                </td>
                <td>
                    <?= DrawView::selector($id_simple, "სტატუსი", "status", getDictionariyItems($conn, 'im_person_status'), $required) ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding: 4px" class="toright">
                    <button id="btnDone" class="btn btn-default">ჩაწერა</button>
                </td>
            </tr>
            </tbody>
        </table>
        <input id="personsFormPageN" type="hidden" name="pageN" value="1"/>
        <input id="personsFormPersonID" type="hidden" name="personID" value="0"/>
    </form>

<?= DrawView::subTitle("ძებნის შედეგი") ?>

    <table id="tb_persons" class="table-section table">
        <thead>
        <tr>
            <?= headerRow(["ID", "სახელი გვარი", "ორგანიზაცია", "ტიპი", "სტატუსი", ""], 0, 1) ?>
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

<?php
include_once 'userChangeModal.php';
include_once 'userHistModal.php';
include_once 'footer.php';
?>