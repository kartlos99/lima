<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 7/30/19
 * Time: 4:17 PM
 */
include_once 'header.php';

include_once 'DrawView.php';
$new_edit = " - ახალი/რედაქტირება";
$id_simple = "id";
$note = "შენიშვნა";

$tech_statuses = [];
$sql = "SELECT id as vv, `code`, `value` as tt FROM `States` WHERE ObjectID = getobjid('techniques_tree') order by SortID";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $tech_statuses[] = $row;
}

$criteria_statuses = [];
$sql = "SELECT id as vv, `code`, `value` as tt FROM `States` WHERE ObjectID = getobjid('estimate_criteriums') order by SortID";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $criteria_statuses[] = $row;
}

$tech_types = [];
$sql = "SELECT di.id, di.code FROM `dictionariyitems` di LEFT JOIN dictionaries d ON di.`DictionaryID` = d.ID WHERE d.Code = 'techniques_tree_type'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $tech_types[$row['code']] = $row['id'];
}

$criteria_types = [];
$sql = "SELECT di.id, di.code FROM `dictionariyitems` di LEFT JOIN dictionaries d ON di.`DictionaryID` = d.ID WHERE d.Code = 'estimate_criteriums_type'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $criteria_types[$row['code']] = $row['id'];
}

echo DrawView::titleRow("ტექნიკის ტიპი ბრენდი და მოდელი/კლასი", "", false, false);
?>


    <table id="techManage" class="table-section">
        <tbody>
        <tr id="typeRow" data-nn="0" data-type="<?= $tech_types['tech_type'] ?>">
            <td class="selobject"><?= DrawView::selectorWithBtn($id_simple, "ტიპი", "seltypename", 0) ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "typename", "ტიპი" . $new_edit, "name") ?> </td>
            <td class="selstatus"><?= DrawView::selector($id_simple, "სტატუსი", "typestatus", $tech_statuses) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "typecomment", $note, "note") ?> </td>

        </tr>
        <tr id="brandRow" data-nn="1" data-type="<?= $tech_types['brand'] ?>">
            <td class="selobject"><?= DrawView::selectorWithBtn($id_simple, "ბრენდი", "selbrandname", 1) ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "brandname", "ბრენდი" . $new_edit, "name") ?> </td>
            <td class="selstatus"><?= DrawView::selector($id_simple, "სტატუსი", "brandstatus", $tech_statuses) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "brandcomment", $note, "note") ?> </td>
        </tr>
        <tr id="modelRow" data-nn="2" data-type="<?= $tech_types['model'] ?>">
            <td class="selobject"><?= DrawView::selectorWithBtn($id_simple, "მოდელი / კლასი", "selmodelname", 2) ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "modelname", "მოდელი" . $new_edit, "name") ?> </td>
            <td class="selstatus"><?= DrawView::selector($id_simple, "სტატუსი", "modeltatus", $tech_statuses) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "modelcomment", $note, "note") ?> </td>
        </tr>
        </tbody>
    </table>
    <div id="section2">
        <?= DrawView::titleRow("ტექნიკის შეფასების კრიტერიუმები", "კრიტერიუმები ობიექტზე:", true, false) ?>
    </div>

    <table id="critManage" class="table-section">
        <tbody>
        <tr id="critGrRow" data-nn="0" data-type="<?= $criteria_types['criterium_group'] ?>">
            <td class="selobject"><?= DrawView::selectorWithBtn($id_simple, "კრიტერიუმების ჯგუფი", "selgroupname", 0) ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "groupname", "ჯგუფი" . $new_edit, "name") ?> </td>
            <td class="selstatus"><?= DrawView::selector($id_simple, "სტატუსი", "groupstatus", $criteria_statuses) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "groupcomment", $note, "note") ?> </td>
        </tr>
        <tr id="critRow" data-nn="1" data-type="<?= $criteria_types['criterium'] ?>">
            <td class="selobject"><?= DrawView::selectorWithBtn($id_simple, "შეფასების კრიტერიუმი", "selratename", 1) ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "ratename", "კრიტერიუმი" . $new_edit, "name") ?> </td>
            <td class="selstatus"><?= DrawView::selector($id_simple, "სტატუსი", "ratestatus", $criteria_statuses) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "ratecomment", $note, "note") ?> </td>
        </tr>
        </tbody>
    </table>

    <div id="section3">
        <?= DrawView::titleRow("ტექნიკის შეფასების კრიტერიუმები ცხრილი", "კრიტერიუმები ობიექტზე:", true, false) ?>
    </div>

<?php include_once 'footer.php'; ?>