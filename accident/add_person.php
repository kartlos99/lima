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

<?= DrawView::titleRow("პერსონის დამატება") ?>


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
                    <button id="btnSave" class="btn"><b>დამახსოვრება</b></button>
                </td>
            </tr>
            </tbody>
        </table>

    </form>


    <table id="tb_comment_list" class="table-section table">
        <thead>
        <tr>
            <!--            --><? //= headerRow(["ID", "შენიშვნა", "მომხმარებელი", "თარიღი"], 0, 1) ?>
        </tr>
        </thead>
        <tbody></tbody>
    </table>


<?php
include_once 'userChangeModal.php';
include_once 'userHistModal.php';
include_once 'footer.php';
?>