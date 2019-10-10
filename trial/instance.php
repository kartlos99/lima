
<form action="" id="<?= $namePref ?>form">

    <?= DrawView::subTitle("განსჯადი უწყება") ?>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::selector($id_simple, "განსჯადი უწყების ტიპი", $namePref . "judicial_type") ?>
        </td>
        <td>
            <?= DrawView::selector($id_simple, "განსჯადი უწყების დასახელება", $namePref . "judicial_name") ?>
        </td>
    </tr>
</table>

<?= DrawView::subTitle("სასარჩელო მოთხოვნა") ?>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::selector($id_simple, "ვალუტა", $namePref . "settle_currency") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "footer", "ძირი", "", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "percent", "%", "", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "puncture", "პირგასამტეხლო", "", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "costs", "ხარჯები", "", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "baj", "ბაჟი", "", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "request_add_info", "დამატებითი ინფორმაცია") ?>
        </td>
    </tr>
</table>

<div class="subtitle">
    <span>სასამართლოსთვის სარჩელის ჩაბარება</span>
    <select class="_form-control" id="<?= $id_simple ?>SelPutSuit" name="<?= $namePref ?>put_suit"></select>
</div>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "suit_put_date", "ჩაბარების თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "el_code_user", "ელექტრონული კოდები (მომხმარებლის სახელი და პაროლი)") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "el_code_pass", "") ?>
        </td>
    </tr>
</table>

<div class="subtitle">
    <span>სარჩელის წარმოებაში მიღება</span>
    <select class="_form-control" id="<?= $id_simple ?>SelTakeSuit" name="<?= $namePref ?>take_suit"></select>
</div>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "suit_take_date", "მიღების თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "judge_name", "მოსამართლე (სახ. გვარი)") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "assistant_name", "თანაშემწე (სახ. გვარი)") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "contact_info", "საკონტაქტო ინფორმაცია") ?>
        </td>
    </tr>
</table>

<div class="subtitle">
    <span>მხარისათვის სარჩელის ჩაბარება</span>
    <select class="_form-control" id="<?= $id_simple ?>SelClientPutSuit"
            name="<?= $namePref ?>client_put_suit"></select>
</div>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::selector($id_simple, "ჩაბარების მეთოდი", $namePref . "suit_put_type") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "suit_client_put_date", "ჩაბარების თარიღი", "", "date") ?>
        </td>
    </tr>
</table>

<div class="subtitle2">
    <span>სტანდარტული წესით ჩაბარება</span>
</div>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "suit_send_time1", "I გაგზავნის თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "suit_send_result1", "I გაგზავნის შედეგი", "", "text") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "suit_send_time2", "II გაგზავნის თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "suit_send_result2", "II გაგზავნის შედეგი", "", "text") ?>
        </td>
        <td>
            <?= DrawView::selector($id_simple, "შედეგი", $namePref . "suit_put_result") ?>
        </td>
    </tr>
</table>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "judge_notice_date", "ჩაბარების შესახებ სასამართლოსთვის შეტყობინების თარიღი", "", "date") ?>
        </td>
    </tr>
</table>

<div class="subtitle2">
    <span>საჯარო წესით ჩაბარება</span>
</div>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "public_put_date", "საჯარო წესით ჩაბარების შუამდგომლობის თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleCheckbox($id_simple, $namePref . "public_put_reminder", "შემახსენებელი", "", "checkbox") ?>
        </td>
    </tr>
</table>

<div class="subtitle">
    <span>მხარის შესაგებელის მონაცემები</span>
</div>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::selector($id_simple, "შესაგებლის სტატუსი", $namePref . "response_status") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "response_date", "შესაგებლის წარმოდგენის თარიღი", "", "date") ?>
        </td>
    </tr>
</table>

<div class="subtitle">
    <span>სასამართლოს სხდომის მონაცემები</span>
    <select class="_form-control" id="<?= $id_simple ?>CourtStatus" name="<?= $namePref ?>court_status"></select>
</div>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "court_mark_date", "სხდომის ჩანიშვნის თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "court_mark_comment", "სხდომის ჩანიშვნის კომენტარი") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "court_date", "სხდომის თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleCheckbox($id_simple, $namePref . "court_hearing_reminder", "შემახსენებელი", "", "checkbox") ?>
        </td>
    </tr>
</table>

<div class="subtitle">
    <span>სასამართლო გადაწყვეტილება</span>
    <?= DrawView::simpleCheckbox($id_simple, $namePref . "court_decision_reminder", "შემახსენებელი", "", "checkbox") ?>
</div>
<table class="table-section">
    <tbody>
    <tr>
        <td>
            <?= DrawView::selector($id_simple, "გადაწყვეტილების ტიპი", $namePref . "decision_type") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "decision_take_date", "გადაწყ. მიღების თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "decision_take_effect_date", "გადაწყ. ძალაში შესვლის თარიღი", "", "date") ?>
        </td>
        <td>
            გადაწყვეტილება:
        </td>
        <td>
            <?= DrawView::selector($id_simple, "ვალუტა", $namePref . "decision_currency") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "decision_footer", "ძირი", "", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "decision_percent", "%", "", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "decision_puncture", "პირგასამტეხლო", "", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "decision_costs", "ხარჯები", "", "number") ?>
        </td>
    </tr>
    </tbody>
</table>
<table class="table-section">
    <tbody>
    <tr>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "additional_info", "დამატებითი ინფორმაცია", "", "text") ?>
        </td>
    </tr>
    </tbody>
</table>

</form>