/**
 * Created by k.diakonidze on 10/12/19.
 */
var lastQuery, lastQuery2;
var caseTable;
var filterForm;
var pageNav = $('#my-pagination');

$(function () {
    caseTable = $('#tb_case_list').find('tbody');
    filterForm = $('#caseFilterForm');
    getOrganizations('organization_id');
    loadBranches(0, 0, 'filial_id');
    $('select').val(0);
    resetDateInputs()
});

$('#organization_id').on('change', function () {
    loadBranches($('#organization_id').val(), 0, 'filial_id');
});

$('#btnSearchApp').on('click', function () {
    pageNav.empty();
    pageNav.removeData("twbs-pagination");
    pageNav.unbind("page");
    prepareSerch();
});

function prepareSerch() {
    lastQuery = filterForm.serialize();
    console.log('from:', lastQuery);
    getCaseList(lastQuery);
}

$('#btnCaseExp').on('click', function () {
    window.location.href = "php_code/rep_case_exp.php?" + lastQuery;
});

$('#btnClearApp').on('click', function () {
    filterForm.trigger('reset');
    $('select').val(0);
    $('#reminder_id').bootstrapToggle('off');
    resetDateInputs();
});

function getCaseList(querys) {
    $.ajax({
        url: 'php_code/get_case_list.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            caseTable.empty();

            var itemCount = response.count[0];
            var pageCount = Math.ceil(itemCount.n / 20);
            var appdata = response.data;
//            $('#titleForAppTable').text("მოიძებნა " + itemCount.n + " ჩანაწერი, ლიმიტი 20");

            appdata.forEach(function (item) {
                var td_id = $('<td />').text(item.ID).addClass('equalsimbols');
                var td_caseN = $('<td />').text(item.caseN);
                var td_case_st = $('<td />').text(item.case_st);
                var td_case_stage = $('<td />').text(item.case_stage);
                var td_org = $('<td />').text(item.OrganizationName);
                var td_AgrNumber = $('<td />').text(item.AgrNumber);
                var td_DebFirstName = $('<td />').text(item.DebFirstName);

                var trow = $('<tr></tr>').append(td_id, td_caseN, td_case_st, td_case_stage, td_org, td_AgrNumber, td_DebFirstName);
                trow.attr('ondblclick', "onCaseClick(" + item.ID + ")");
                if (item.rem == 0) {
                    trow.addClass("reminder-tr");
                }
                caseTable.append(trow);
            });

            if (pageCount > 0) {
                pageNav.twbsPagination({
                    totalPages: pageCount,
                    visiblePages: 5,
                    first: 'პირველი',
                    last: 'ბოლო',
                    next: '>>',
                    prev: '<<',
                    onPageClick: function (event, page) {
                        $('#casePageN').val(page);
                        prepareSerch();
                    }
                });
            }
        }
    });
}

function onCaseClick(app_id) {

    document.cookie = "appID=" + app_id;

    var url = window.location.pathname;
    url = url.replace('index.php', 'new_case.php');
    window.location.href = window.location = window.location.protocol + "//" + window.location.hostname + url;
}