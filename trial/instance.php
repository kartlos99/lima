<form action="" id="<?= $namePref ?>form">

<input type="hidden" id="<?= $namePref ?>ID" name="<?= $namePref ?>instID" value="0">
<?= DrawView::subTitle("განსჯადი უწყება") ?>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::selector($id_simple, "განსჯადი უწყების ტიპი", $namePref . "judicial_type", getDictionariyItems($conn, 'judicial_type')) ?>
        </td>
        <td>
            <?= DrawView::selector($id_simple, "განსჯადი უწყების დასახელება", $namePref . "judicial_name", getDictionariyItems($conn, 'judicial_name')) ?>
        </td>
    </tr>
</table>

<?= DrawView::subTitle("სასარჩელო მოთხოვნა") ?>
<table class="table-section calculate-row">
    <tr>
        <td>
            <?= DrawView::selector($id_simple, "ვალუტა", $namePref . "currency", getDictionariyItems($conn, 'currency')) ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "footer", "ძირი", "ziri", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "percent", "%", "proc", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "puncture", "პირგასამტეხლო", "pir", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "costs", "ხარჯები", "xarj", "number") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "baj", "ბაჟი", "", "number") ?>
        </td>
        <td >
            <label for="">თანხა ჯამურად</label>
            <p class="request-sum"><b>0</b></p>
        </td>
    </tr>
</table>
<table class="table-section hidden">
    <tbody>
    <tr>
        <td>
            <div>
                <label for="<?= $namePref ?>request_add_info_<?= $id_simple ?>">დამატებითი ინფორმაცია</label>
            </div>
            <div>
                <textarea name="<?= $namePref ?>request_add_info" id="<?= $namePref ?>request_add_info_<?= $id_simple ?>" rows="4"></textarea>
            </div>
        </td>
    </tr>
    </tbody>
</table>

<div class="subtitle">
    <span>სასამართლოსთვის სარჩელის ჩაბარება</span>
<!--    --><?//= DrawView::selector($id_simple . "SelPutSuit", "", $namePref . "put_suit", getDictionariyItems($conn, 'claim_delivery_status')) ?>
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
<!--    --><?//= DrawView::selector($id_simple . "SelTakeSuit", "", $namePref . "take_suit", getDictionariyItems($conn, 'claim_proceeed')) ?>
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
<!--    --><?//= DrawView::selector($id_simple . "SelClientPutSuit", "", $namePref . "client_put_suit", getDictionariyItems($conn, 'clto_delivery_status')) ?>
</div>
<table class="">
    <tr>
        <td class="hidden">
            <?= DrawView::selector($id_simple, "ჩაბარების მეთოდი", $namePref . "suit_put_type", getDictionariyItems($conn, 'clto_delivery_method')) ?>
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
            <?= DrawView::selector($id_simple, "I გაგზავნის შედეგი", $namePref . "suit_send_result1", getDictionariyItems($conn, 'clto_standard_sent_result')) ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "suit_send_time2", "II გაგზავნის თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::selector($id_simple, "II გაგზავნის შედეგი", $namePref . "suit_send_result2", getDictionariyItems($conn, 'clto_standard_sent_result')) ?>
        </td>
        <td class="hidden">
            <?= DrawView::selector($id_simple, "შედეგი", $namePref . "suit_put_result", getDictionariyItems($conn, 'clto_standard_sent_result')) ?>
        </td>
    </tr>
</table>
<table class="">
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
        <td style="width: 340px">
            <?= DrawView::simpleInput($id_simple, $namePref . "public_put_date", "საჯარო წესით ჩაბარების შუამდგომლობის თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleCheckbox($id_simple, $namePref . "public_put_reminder", "შემახსენებელი", "", "checkbox") ?>
            <input id="<?= $id_simple ?>cltoPerPublicRemainderStartDate" type="hidden"
                   name="<?= $namePref ?>cltoPerPublicRemainderStartDate" value="0"/>
            <input id="<?= $id_simple ?>cltoPerPublicRemainderEndDate" type="hidden"
                   name="<?= $namePref ?>cltoPerPublicRemainderEndDate" value="0"/>
        </td>
    </tr>
</table>

<div class="subtitle">
    <span>მხარის შესაგებელის მონაცემები</span>
</div>
<table class="">
    <tr>
        <td class="hidden">
            <?= DrawView::selector($id_simple, "შესაგებლის სტატუსი", $namePref . "response_status", getDictionariyItems($conn, 'claim_cont_status')) ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "response_date", "შესაგებლის წარმოდგენის თარიღი", "", "date") ?>
        </td>
    </tr>
</table>

<div class="subtitle">
    <span>სასამართლოს სხდომის მონაცემები</span>
<!--    --><?//= DrawView::selector($id_simple . "CourtStatus", "", $namePref . "court_status", getDictionariyItems($conn, 'court_process_status')) ?>
</div>
<table class="table-section">
    <tr>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "court_mark_date", "სხდომის ჩანიშვნის თარიღი", "", "date") ?>
        </td>
        <td class="hidden">
            <?= DrawView::simpleInput($id_simple, $namePref . "court_mark_comment", "სხდომის ჩანიშვნის კომენტარი") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "court_date", "სხდომის თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleCheckbox($id_simple, $namePref . "court_hearing_reminder", "შემახსენებელი", "", "checkbox") ?>
            <input id="<?= $id_simple ?>CourtProcessRemainderStartDate" type="hidden"
                   name="<?= $namePref ?>CourtProcessRemainderStartDate" value="0"/>
            <input id="<?= $id_simple ?>CourtProcessRemainderEndDate" type="hidden"
                   name="<?= $namePref ?>CourtProcessRemainderEndDate" value="0"/>
        </td>
    </tr>
</table>

<div class="subtitle">
    <span>სასამართლო გადაწყვეტილება</span>
    <?= DrawView::simpleCheckbox($id_simple, $namePref . "court_decision_reminder", "შემახსენებელი", "", "checkbox") ?>
    <input id="<?= $id_simple ?>CourtDecRemainderStartDate" type="hidden"
           name="<?= $namePref ?>CourtDecRemainderStartDate" value="0"/>
    <input id="<?= $id_simple ?>CourtDecRemainderEndDate" type="hidden" name="<?= $namePref ?>CourtDecRemainderEndDate"
           value="0"/>
</div>
<table class="table-section">
    <tbody>
    <tr>
        <td>
            <?= DrawView::selector($id_simple, "გადაწყვეტილების ტიპი", $namePref . "decision_type", getDictionariyItems($conn, 'court_dec_type')) ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "decision_take_date", "გადაწყ. მიღების თარიღი", "", "date") ?>
        </td>
        <td>
            <?= DrawView::simpleInput($id_simple, $namePref . "decision_take_effect_date", "გადაწყ. ძალაში შესვლის თარიღი", "", "date") ?>
        </td>
        <td style="padding-bottom: 10px; padding-left: 10px">
            გადაწყვეტილება:
        </td>
        <td>
            <?= DrawView::selector($id_simple, "ვალუტა", $namePref . "decision_currency", getDictionariyItems($conn, 'currency')) ?>
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
            <div>
                <label for="<?= $namePref ?>additional_info_<?= $id_simple ?>">დამატებითი ინფორმაცია</label>
            </div>
            <div>
                <textarea name="<?= $namePref ?>additional_info" id="<?= $namePref ?>additional_info_<?= $id_simple ?>" rows="4"></textarea>
            </div>
        </td>
    </tr>
    </tbody>
</table>

</form>