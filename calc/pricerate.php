<?php
/**
 * Created by PhpStorm.
 * User: k.diakonidze
 * Date: 8/6/19
 * Time: 3:44 PM
 */
include_once 'header.php';
include_once 'common_functions.php';
include_once 'DrawView.php';
if (!isset($_SESSION['permissionM2']['submod22'])) {
    $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $folder . "/index.php";
    header("Location: $url");
}
$new_edit = " - ახალი/რედაქტირება";
$id_simple = "id";
$note = "შენიშვნა";

$btnHistory = isset($_SESSION['permissionM2']['m2history']) ? "<i id=\"btnHist\" class=\"fas fa-history btn\"></i>" : "";

?>

<?= DrawView::titleRow($btnHistory, "შესაფასებელი ტექნიკა:") ?>

    <table class="table" id="tbPriceRate1">
        <tbody>
        <tr>
            <td class="half-width">
                <?= DrawView::titleRow("ტექნიკა და ტექნიკის მონაცემები", "") ?>
                <table class="table-section">
                    <tr>
                        <td>
                            <div class="in-form" style="padding-bottom: 2px"><?= DrawView::selector($id_simple, "ტიპი", "type") ?></div>
                            <div class="in-form" style="padding-bottom: 1px"><?= DrawView::selector($id_simple, "ბრენდი", "brand") ?></div>
                            <div class="in-form" style="padding-bottom: 2px"><?= DrawView::selector($id_simple, "მოდელი / კლასი", "model") ?></div>
                        </td>
                        <td>
                            <div class="in-form"><?= DrawView::simpleInput($id_simple, "modelbyhand", "მოდელი (ხელოვნური განსაზღვრა)") ?></div>
                            <div class="in-form"><?= DrawView::simpleInput($id_simple, "serial_N", "სერიული N") ?></div>
                            <div class="in-form"><?= DrawView::simpleInput($id_simple, "imei", "IMEI კოდი") ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?= DrawView::simpleInput($id_simple, "note", $note, "text") ?>
                        </td>
                    </tr>
                </table>

                <button id="btnStartPriceRate" class="btn">1. კრიტერიუმების გენერაცია</button>
                <button id="btnRate" class="btn">2. შეფასება</button>

                <?= DrawView::titleRow("შეფასების შედეგი და გასაცემი თანხა", "") ?>

                <h4>შეფასების შედეგი</h4>

                <p id="reteResultText" class="alert"></p>

                <p>
                    სისტემის მიერ გენერირებული გასაცემი თანხა: <span id="rateResultNumber" class="resNumber">0</span> ₾
                </p>

                <table id="tbPriceCorection">
                    <tr>
                        <td>
                            <?= DrawView::simpleInput($id_simple, "corection", "თანხის კორექტირება", "", "number") ?>
                        </td>
                        <td>
                            <div><label><input type="checkbox" name="inc_by_manager" value="1"/> დამატება მენეჯერის დასტურით</label></div>
                            <div><label><input type="checkbox" name="dec_by_client" value="1"/> შემცირება კლიენტის მოთხოვნით</label></div>
                        </td>
                    </tr>
                </table>

                <p>გასაცემი თანხა (კორექტირებული): <span id="rateResultNumberCorected" class="resNumber">0</span> ₾</p>

            </td>
            <td class="half-width">
                <?= DrawView::titleRow("ტექნიკის შეფასების კრიტერიუმები", "", false, true) ?>
                <form>
                    <div class="kriterias-box">
                        <table>
                            <tbody>
                            <?php
                            //                            for ($i = 0; $i < 33; $i++) {
                            //                                echo(DrawView::radioGroupRow("KR_$i", "krit_$i"));
                            //                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <button id="btnAllCriteriaSetNegative" class="btn btn-default">უარი ყველას</button>
            </td>
        </tr>
        </tbody>
    </table>

<?= DrawView::titleRow("შეჯამებული ინფორმაცია შეფასების შესახებ") ?>

    <button id="btnInfoGen" class="btn btn-info"><b>3. ინფორმაციის გენერირება</b></button>
    <button class="btn" onclick="mycopy()">Copy</button>
<!--    <input type="hidden" id="atext" value="ertyy7"/>-->
<p></p>
    <textarea readonly="true" name="suminfo" id="finalInfo" cols="30" rows="10"></textarea>
<!--    <p id="finalInfo"> INFO </p>-->

<?php $id_simple = "id_app" ?>

    <table class="table" id="tbPriceRate2">
        <tr>
            <td class="half-width">
                <?= DrawView::titleRow("განაცხადი და ხელშეკრულება") ?>
                <p id="localInfo1">განაცხადი N: <span></span></p>
                <table class="table">
                    <tr>
                        <td>
                            <?= DrawView::selector($id_simple, "ორგანიზაცა", "organization") ?>
                        </td>
                        <td>
                            <?= DrawView::selector($id_simple, "ფილიალი", "filial") ?>
                        </td>
                        <td>
                            <?= DrawView::simpleInput($id_simple, "agreement", "ხელშეკრულება") ?>
                        </td>
                        <td>
                            <?= DrawView::selector($id_simple, "სტატუსი", "status", getStatusItems($conn, "app_states")) ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <?= DrawView::simpleInput($id_simple, "note", "შენიშვნა განაცხადზე") ?>
                        </td>
                    </tr>
                </table>

            </td>
            <?php $id_simple = "id_control" ?>
            <td class="half-width">
                <?= DrawView::titleRow("საკონტროლო შეფასება") ?>
                <p id="localInfo2">თარიღი: <span></span></p>
                <table class="table">
                    <tr>
                        <td>
                            <?= DrawView::selector($id_simple, "საკონტროლო შეფასების შედეგი", "control_rate_result", getStatusItems($conn, "control_estimate_states")) ?>
                        </td>
                        <td>
                            <?= DrawView::simpleInput($id_simple, "adjusted_amount", "კორექტირებული თანხა") ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <?= DrawView::simpleInput($id_simple, "note", "შენიშვნა / კორექტირების მიზეზი") ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

<?php $id_simple = "id_market" ?>
<?= DrawView::titleRow("მაღაზიაში გადატანა") ?>
    <p id="localInfo3">თარიღი: <span></span></p>
    <table class="table">
        <tr>
            <td>
                <?= DrawView::selector($id_simple, "დეტალური შეფასების შედეგი", "detail_rate_result", getStatusItems($conn, "control_estimate_states")) ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "adjusted_amount", "კორექტირებული თანხა") ?>
            </td>
            <td>
                <?= DrawView::simpleInput($id_simple, "note", "შენიშვნა / კორექტირების მიზეზი") ?>
            </td>
        </tr>
    </table>

    <button id="btnSave" class="btn"><b>შენახვა</b></button>

    <table class="hidden">
        <?= DrawView::radioGroupRow("_", "aname") ?>
    </table>



<?php include_once 'footer.php'; ?>