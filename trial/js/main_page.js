/**
 * Created by k.diakonidze on 10/12/19.
 */
var lastQuery, lastQuery2;
var caseTable;
var filterForm;

$(function(){
    caseTable = $('#tb_case_list').find('tbody');
    filterForm = $('#caseFilterForm');

    filterForm.on('submit', function(e){
        e.preventDefault();
        console.log("def_cenceled!!!");
    });
});



$('#btnSearchApp').on('click', function () {

    lastQuery = filterForm.serialize();
    console.log('from:',lastQuery);
    getCaseList(lastQuery);
});

function getCaseList(querys){
    $.ajax({
        url: 'php_code/get_case_list.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            caseTable.empty();

            var itemCount = response.count[0];
            console.log(itemCount.n);
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
                caseTable.append(trow);
            });
        }
    });
}

function onCaseClick(app_id){

    document.cookie = "appID=" + app_id;

    var url = window.location.pathname;
    url = url.replace('index.php','new_case.php');
    window.location.href = window.location = window.location.protocol + "//" + window.location.hostname + url;
}