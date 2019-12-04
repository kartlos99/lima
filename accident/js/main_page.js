/**
 * Created by k.diakonidze on 10/12/19.
 */
var lastQuery, lastQuery2;
var caseTable;
var filterForm;
var pageNav = $('#my-pagination');

$(function () {
    caseTable = $('#tb_case_list').find('tbody');
    filterForm = $('#filterForm');
    getOrganizations('organization_id');
    loadBranches(0, 0, 'filial_id');
    getCategory('CategoryID_id');
    loadSubCategory(0, 0, 'SubCategoryID_id');
    $('select').val(0);
    if($('#currusertype').data('ut') == 'performer')
        blockSolverSelector($('#currusertype').data('userid'));

    $('#DiscovererID_id').addClass("chosen").chosen();
    $('#guiltyUserID_id').addClass("chosen").chosen();
});

$('#CategoryID_id').on('change', function () {
    loadSubCategory($('#CategoryID_id').val(), 0, 'SubCategoryID_id');
});

orgSelector.on('change', function () {
    loadBranches($('#organization_id').val(), 0, 'filial_id');
});

$('#btnSearchApp').on('click', function (event) {
    event.preventDefault();
    pageNav.empty();
    pageNav.removeData("twbs-pagination");
    pageNav.unbind("page");
    prepareSerch();
});

function prepareSerch() {
    lastQuery = filterForm.serialize();
    console.log('from:', lastQuery);
    getAccidentsList(lastQuery);
}

$('#btnCaseExp').on('click', function () {
    window.location.href = "php_code/rep_case_exp.php?" + lastQuery;
});

$('#btnClearApp').on('click', function (event) {
    event.preventDefault();
    filterForm.trigger('reset');
    $('select').val(0);
    $('#reminder_id').bootstrapToggle('off');

    $('#DiscovererID_id').trigger('chosen:updated');
    $('#guiltyUserID_id').trigger('chosen:updated');
});

function getAccidentsList(querys) {
    $.ajax({
        url: 'php_code/get_accident_list.php',
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
                var td_cat = $('<td />').text(item.category);
                var td_scat = $('<td />').text(item.subcaegory);
                var td_st = $('<td />').text(item.st);
                var td_org = $('<td />').text(item.org);
                var td_AgrNumber = $('<td />').text(item.AgrNumber);
                var td_owner = $('<td />').text(item.username);
                var td_datefix = $('<td />').text(item.FactDate);

                var trow = $('<tr></tr>').append(td_id, td_cat, td_scat, td_org, td_AgrNumber, td_st, td_owner, td_datefix);
                trow.attr('ondblclick', "onRowClick(" + item.ID + ")");
                if (item.rem == 0) {
                    trow.addClass("reminder-tr");
                }
                caseTable.append(trow);
            });

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
    });
}

function onRowClick(app_id) {

    document.cookie = "appID=" + app_id;

    var url = window.location.pathname;
    url = url.replace('index.php', 'new_accident.php');
    window.location.href = window.location = window.location.protocol + "//" + window.location.hostname + url;
}