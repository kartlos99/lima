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

echo DrawView::titleRow("ტექნიკის ტიპი ბრენდი და მოდელი/კლასი", "", false, false);
?>


    <table class="table-section">
        <tbody>
        <tr>
            <td><?= DrawView::selectorWithBtn("type_id", "ტიპი", "seltypename") ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "typename", "ტიპი".$new_edit) ?> </td>
            <td><?= DrawView::selector($id_simple, "სტატუსი", "typestatus" ) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "typecomment", $note) ?> </td>
        </tr>
        <tr>
            <td><?= DrawView::selectorWithBtn("brand_id", "ბრენდი", "selbrandname") ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "brandname", "ბრენდი".$new_edit) ?> </td>
            <td><?= DrawView::selector($id_simple, "სტატუსი", "brandstatus" ) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "brandcomment", $note) ?> </td>
        </tr>
        <tr>
            <td><?= DrawView::selectorWithBtn("model_id", "მოდელი / კლასი", "selmodelname") ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "modelname", "მოდელი".$new_edit) ?> </td>
            <td><?= DrawView::selector($id_simple, "სტატუსი", "modeltatus" ) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "modelcomment", $note) ?> </td>
        </tr>
        </tbody>
    </table>

<?= DrawView::titleRow("ტექნიკის შეფასების კრიტერიუმები", "კრიტერიუმები ობიექტზე:", true, false) ?>

    <table class="table-section">
        <tbody>
        <tr>
            <td><?= DrawView::selectorWithBtn("group_id", "კრიტერიუმების ჯგუფი", "selgroupname") ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "groupname", "ჯგუფი".$new_edit) ?> </td>
            <td><?= DrawView::selector($id_simple, "სტატუსი", "groupstatus" ) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "groupcomment", $note) ?> </td>
        </tr>
        <tr>
            <td><?= DrawView::selectorWithBtn("rate_id", "შეფასების კრიტერიუმი", "selratename") ?>  </td>
            <td class="two-btn-width"><?= DrawView::btnsBackCancel() ?> </td>
            <td><?= DrawView::simpleInput($id_simple, "ratename", "კრიტერიუმი".$new_edit) ?> </td>
            <td><?= DrawView::selector($id_simple, "სტატუსი", "ratestatus" ) ?></td>
            <td><?= DrawView::simpleInput($id_simple, "ratecomment", $note) ?> </td>
        </tr>
        </tbody>
    </table>

<?= DrawView::titleRow("ტექნიკის შეფასების კრიტერიუმები ცხრილი", "კრიტერიუმები ობიექტზე:", true, false) ?>


<?php include_once 'footer.php'; ?>