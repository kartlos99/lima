/**
 * Created by k.diakonidze on 10/12/19.
 */
var lastQuery, lastQuery2;
var caseTable;
var filterForm;
var pageNav = $('#my-pagination');
var searchFormState = "searchFormState";

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

function pageIsReady(){
    lastQuery = getCookie(searchFormState);
    if (lastQuery != ''){
        fillsSearchForm(lastQuery)
    }
}

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
    document.cookie = searchFormState + "=" + lastQuery;
    console.log('from:', lastQuery);
    getAccidentsList(lastQuery);
}

$('#btnListExp').on('click', function (event) {
    event.preventDefault();
    window.location.href = "php_code/rep_list_exp.php?" + lastQuery;
});

$('#btnClearApp').on('click', function (event) {
    event.preventDefault();
    filterForm.trigger('reset');
    $('select').val(0);
    $('#reminder_id').bootstrapToggle('off');

    $('#DiscovererID_id').trigger('chosen:updated');
    $('#guiltyUserID_id').trigger('chosen:updated');
    document.cookie = searchFormState + "=" ;
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

function fillsSearchForm(state){
    var queryData = serialDataToObj(state);

    $('#accident_N_id').val(queryData.accident_N);
    $('#TypeID_id').val(queryData.TypeID);
    $('#PriorityID_id').val(queryData.PriorityID);
    $('#StatusID_id').val(queryData.StatusID);
    $('#OwnerID_id').val(queryData.OwnerID);
    $('#create_date_from_id').val(queryData.create_date_from);
    $('#create_date_to_id').val(queryData.create_date_to);
    $('#organization_id').val(queryData.organization);
    loadBranches(queryData.organization, queryData.filial, 'filial_id');
    $('#AgrNumber_id').val(queryData.AgrNumber);
    $('#guiltyUserID_id').val(queryData.guiltyUserID).trigger('chosen:updated');
    $('#fix_date_from_id').val(queryData.fix_date_from);
    $('#fix_date_to_id').val(queryData.fix_date_to);
    $('#CategoryID_id').val(queryData.CategoryID);
    loadSubCategory(queryData.CategoryID, queryData.SubCategoryID, 'SubCategoryID_id');
    $('#DiscovererID_id').val(queryData.DiscovererID).trigger('chosen:updated');
    $('#discover_date_from_id').val(queryData.discover_date_from);
    $('#discover_date_to_id').val(queryData.discover_date_to);
    $('#not_in_statistic_id').prop("checked", queryData.NotInStatistics != undefined);
    $('#dublicas_id').prop("checked", queryData.duplicates != undefined);
    $('#SolverID_id').val(queryData.SolverID);
    $('#SolveDate_from_id').val(queryData.SolveDate_from);
    $('#SolveDate_to_id').val(queryData.SolveDate_to);
    $('#casePageN').val(queryData.pageN);

    getAccidentsList(state);
}