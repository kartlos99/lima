<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/2/19
 * Time: 12:32 PM
 */

include_once 'header.php';

include_once 'DrawView.php';
$new_edit = " - ახალი/რედაქტირება";
$id_simple = "id";
$note = "შენიშვნა";

$tech_and_crit_weight_states = [];
$sql = "SELECT id as vv, `code`, `value` as tt FROM `States` WHERE ObjectID = getobjid('tech_and_crit_weight_states') order by SortID";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $tech_and_crit_weight_states[] = $row;
}

$price_calc_item_states = [];
$sql = "SELECT id as vv, `code`, `value` as tt FROM `States` WHERE ObjectID = getobjid('price_calc_item_states') order by SortID";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $price_calc_item_states[] = $row;
}

$goal_price_list = [];
$sql = "SELECT di.id as vv, di.ValueText as tt FROM `dictionariyitems` di LEFT JOIN dictionaries d ON di.`DictionaryID` = d.ID WHERE d.Code = 'target_price'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $goal_price_list[] = $row;
}

$impact_list = [];
$sql = "SELECT di.id as vv, di.ValueText as tt FROM `dictionariyitems` di LEFT JOIN dictionaries d ON di.`DictionaryID` = d.ID WHERE d.Code = 'Impact' order by SortID";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $impact_list[] = $row;
}

$impact_type_list = [];
$sql = "SELECT di.id as vv, di.ValueText as tt FROM `dictionariyitems` di LEFT JOIN dictionaries d ON di.`DictionaryID` = d.ID WHERE d.Code = 'ImpactType'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $impact_type_list[] = $row;
}

$calculate_Type_list = [];
$sql = "SELECT di.id as vv, di.ValueText as tt FROM `dictionariyitems` di LEFT JOIN dictionaries d ON di.`DictionaryID` = d.ID WHERE d.Code = 'CalculateType'";
$result = mysqli_query($conn, $sql);
foreach ($result as $row) {
    $calculate_Type_list[] = $row;
}


function headerRow($items = [], $pos = 0, $margeN = 1)
{
    $h_row = "";
    for ($i = 0; $i < count($items); $i++) {
        $colspan = ($pos == $i ? " colspan=\"$margeN\"" : "");
        $h_row .= "<th$colspan>$items[$i]</th>";
    }
//    foreach ($items as $item) {
//        $h_row .= "<hd>$item</hd>";
//    }
    return $h_row;
}

echo DrawView::titleRow("ტექნიკის ტიპი ბრენდი და მოდელი/კლასი", "", false, true);
?>

    <table class="table-section ">

        <tbody>

        <tr>

            <td><?= DrawView::selector($id_simple, "ტიპი", "typename") ?></td>
            <td><?= DrawView::selector($id_simple, "ბრენდი", "brandname") ?></td>
            <td><?= DrawView::selector($id_simple, "მოდელი / კლასი", "modelname") ?></td>
            <td><?= DrawView::selector($id_simple, "ღირებულებისა და კრიტერიუმების წონების სტატუსი", "price_crit_weight_status", $tech_and_crit_weight_states) ?></td>

        </tr>
        </tbody>
    </table>


    <table style="margin: 15px 0 10px 0">
        <tbody>
        <tr>
            <td style="width: 1%">
                <i class="fas fa-sync-alt fa-2x btn">
            </td>
            <td style="padding: 5px; font-size: 1.2em; background-color: #cdcdcd">
                <label>კრიტერიუმები ობიექტზე: <span class="red-in-title">uytuytuy</span></label>
            </td>
        </tr>
        </tbody>
    </table>

<?= DrawView::titleRow("ტექნიკის ღირებულება", "", false, true) ?>


    <table id="tb_teknic_price" class="table-section">
        <tbody>

        <tr>
            <?= DrawView::horizontalInput("ახალის საფასური", "price_new", "number") ?>
            <?= DrawView::horizontalInput("სამიზნე ფასი", "price_goal", "select", $goal_price_list) ?>
            <?= DrawView::horizontalInput("გაანგარიშების ტიპი", "calc_type", "select", $calculate_Type_list) ?>
        </tr>
        <tr>
            <?= DrawView::horizontalInput("საბაზრო ფასი", "price_market", "number") ?>
            <?= DrawView::horizontalInput("ფასზე ზემოქმედება", "price_impact", "select", $impact_list) ?>
            <?= DrawView::horizontalInput("მაქსიმუმ გასაცემი თანხა", "max_amount", "number") ?>
        </tr>
        <tr>
            <?= DrawView::horizontalInput("კონკურენტის ფასი", "price_competitor", "number") ?>
            <?= DrawView::horizontalInput("ზემოქმედების სახეობა", "impact_type", "select", $impact_type_list) ?>
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


<?= DrawView::titleRow("ტექნიკის შეფასების კრიტერიუმები", "", false, false) ?>

    <table id="tb_technic_criteria" class="table-section">
        <thead>
        <tr>
            <?= headerRow(["", "ზემოქმედება", "სახეობა", "მნიშვნელობა", "ძირითადი", "გადახედვის ვადა და თარიღი", "სტატუსი", ""], 5, 2) ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td>
        </tr>
        <tr>
            <?= DrawView::criteriaEditRow() ?>
        </tr>
        <tr>
            <?= DrawView::criteriaEditRow() ?>
        </tr>
        </tbody>
    </table>




<?php include_once 'footer.php'; ?>