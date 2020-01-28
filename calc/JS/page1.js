/**
 * Created by k.diakonidze on 7/29/19.
 */
var organizationObj;
var lastQuery, lastQuery2;

$('#btnSearchApp').on('click', function () {
    console.log('from:',$('#appFilterForm').serialize());
    lastQuery = $('#appFilterForm').serialize();
    getAppList(lastQuery);
});

$('#btnClearApp').on('click', function () {
    $('#appFilterForm').trigger('reset');
});

$('#appFilterForm').on('submit',function (event) {
    event.preventDefault();
});

$('#btnSearchCrit').on('click', function () {
    console.log('from:',$('#critListForm').serialize());
    lastQuery2 = $('#critListForm').serialize();
    getCritList(lastQuery2);
});

$('#btnClearCrit').on('click', function () {
    $('#critListForm').trigger('reset');
});

$('#critListForm').on('submit',function (event) {
    event.preventDefault();
});

var critTable = $('#critListTable').find('tbody');

function getCritList(querys){
    $.ajax({
        url: 'php_code/get_techPrAndCr_list.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            critTable.empty();

            var itemCount = response.count[0];
            console.log(itemCount.n);
            var appdata = response.data;
            $('#titleForTechPriceTable').text("მოიძებნა " + itemCount.n + " ჩანაწერი, ლიმიტი 20");

            appdata.forEach(function (item) {

                var td_id = $('<td />').text(item.ID).addClass('equalsimbols');
                var td_type = $('<td />').text(item.techtype);
                var td_brand = $('<td />').text(item.brand);
                var td_model = $('<td />').text(item.model);
                var tpacw_st = $('<td />').text(item.tpacw_st);
                var pr_st = $('<td />').text(item.pr_st);
                var revDate = $('<td />').text(item.RevDate).addClass('equalsimbols datewidth');
                var crgr = $('<td />').text(item.crgr);
                var crit = $('<td />').text(item.crit);
                var crit_st = $('<td />').text(item.crit_st);
                var crit_revDate = $('<td />').text(item.crit_revDate).addClass('equalsimbols datewidth');


                var trow = $('<tr></tr>').append(td_id, td_type, td_brand, td_model, tpacw_st, pr_st, revDate, crgr, crit, crit_st, crit_revDate);
                // trow.attr('onclick', "ont11Click(" + item.ID + ")");
                critTable.append(trow);
            });
        }
    });
}

var appTable = $('#appListTable').find('tbody');

function getAppList(querys){
    $.ajax({
        url: 'php_code/get_app_list.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            appTable.empty();

            var itemCount = response.count[0];
            console.log(itemCount.n);
            var appdata = response.data;
            $('#titleForAppTable').text("მოიძებნა " + itemCount.n + " ჩანაწერი, ლიმიტი 20");

            appdata.forEach(function (item) {

                var td_id = $('<td />').text(item.ID).addClass('equalsimbols');
                var td_type = $('<td />').text(item.techtype);
                var td_brand = $('<td />').text(item.brand);
                var td_model = $('<td />').text(item.model);
                var td_apNumber = $('<td />').text(item.ApNumber).addClass('equalsimbols');
                var td_apDate = $('<td />').text(item.ApDate).addClass('equalsimbols datewidth');
                var td_status = $('<td />').text(item.st);
                var td_operator = $('<td />').text(item.ModifyUser);
                var td_org = $('<td />').text(item.OrganizationName);
                var td_agr = $('<td />').text(item.AgreementNumber).addClass('equalsimbols');
                var td_cst = $('<td />').text(item.control_st);
                var td_fst = $('<td />').text(item.final_st);

                var trow = $('<tr></tr>').append(td_id, td_type, td_brand, td_model, td_apNumber, td_apDate, td_status, td_operator, td_org, td_agr, td_cst, td_fst);
                trow.attr('onclick', "onAppClick(" + item.ID + ")");
                appTable.append(trow);
            });
        }
    });
}

$('#organization_id').on('change', function () {

    org_p1 = $('#organization_id').val();

    loadBranches11(org_p1, 0)
});

function loadBranches11(orgID, brID) {
    $('#filial_id').empty().removeAttr('disabled');

    // <!--    filialebis chamonatvali -->
    if (orgID == "") {
        $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#filial_id');
    } else {
        organizationObj.forEach(function (org) {
            if (org.id == orgID) {
                var branches = org.branches;
                if (branches.length != 1) {
                    $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#filial_id');
                }
                branches.forEach(function (item) {
                    $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#filial_id');
                });
                if (brID > 0) {
                    $('#filial_id').val(brID);
                }
            }
        });
    }
}

$('#type_id').on('change', function () {
    techPosArray = [$('#type_id').val(), "0", "0"];
    $('#brand_id').empty();
    $('#model_id').empty();
    $('#brand_id').trigger('chosen:updated');
    $('#model_id').trigger('chosen:updated');
    if (techPosArray[0] != 0) {
        loadTypesList(techPosArray[0], 'brand_id');
    }
    console.log(techPosArray);
});

$('#brand_id').on('change', function () {
    techPosArray[1] = $('#brand_id').val();
    techPosArray[2] = "0";
    $('#model_id').empty();
    $('#model_id').trigger('chosen:updated');
    if (techPosArray[1] != 0) {
        loadTypesList(techPosArray[1], 'model_id');
    }
    console.log(techPosArray);
});

$('#model_id').on('change', function () {
    techPosArray[2] = $('#model_id').val();
    console.log(techPosArray);
});

$('#type_id2').on('change', function () {
    techPosArray = [$('#type_id2').val(), "0", "0"];
    $('#brand_id2').empty();
    $('#model_id2').empty();
    $('#brand_id2').trigger('chosen:updated');
    $('#model_id2').trigger('chosen:updated');
    if (techPosArray[0] != 0) {
        loadTypesList(techPosArray[0], 'brand_id2');
    }
    console.log(techPosArray);
});

$('#brand_id2').on('change', function () {
    techPosArray[1] = $('#brand_id2').val();
    techPosArray[2] = "0";
    $('#model_id2').empty();
    $('#model_id2').trigger('chosen:updated');
    if (techPosArray[1] != 0) {
        loadTypesList(techPosArray[1], 'model_id2');
    }
    console.log(techPosArray);
});

$('#model_id2').on('change', function () {
    techPosArray[2] = $('#model_id2').val();
    console.log(techPosArray);
});

$('#criteria_group_id2').on('change', function () {
    // criteriaPosArray[0] = $('#criteria_group_id2').val();
    // criteriaPosArray[1] = "0";
    $('#criteria_id2').empty();
    if ($('#criteria_group_id2').val() != 0) {
        loadCriteriaslist("", $('#criteria_group_id2').val(), 'criteria_id2');
    }
    // console.log(criteriaPosArray);
});

$('#criteria_id2').on('change', function () {
    // criteriaPosArray[1] = $('#selratename_id').val();
    // console.log(criteriaPosArray);
});

$(document).ready(function () {
    console.log("ready!");
    loadTypesList(0, 'type_id');
    loadTypesList(0, 'type_id2');
    document.cookie = "appID=0";

    $.ajax({
        url: '../php_code/get_dropdown_lists.php',
        method: 'post',
        data: {
            'org': 'org'
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);

            //<!--    organizaciebis chamonatvali -->
            organizationObj = response.org;
            $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#organization_id');
            organizationObj.forEach(function (item) {
                $('<option />').text(item.OrganizationName).attr('value', item.id).appendTo('#organization_id');
            });

        }
    });

    $('<option />').text('აირჩიეთ...').attr('value', '0').prependTo('#application_status_id');
    $('<option />').text('აირჩიეთ...').attr('value', '0').prependTo('#control_rate_result_id');
    $('<option />').text('აირჩიეთ...').attr('value', '0').prependTo('#detail_rate_result_id');
    $('<option />').text('აირჩიეთ...').attr('value', '0').prependTo('#price_status_id2');
    $('<option />').text('აირჩიეთ...').attr('value', '0').prependTo('#criteria_group_id2');
    $('<option />').text('აირჩიეთ...').attr('value', '0').prependTo('#criteria_status_id2, #price_criteria_status_id2');
    $('#application_status_id, #control_rate_result_id, #detail_rate_result_id, #price_status_id2, #criteria_group_id2, #criteria_status_id2, #price_criteria_status_id2').val(0);
// .trigger('chosen:updated');
    $('#type_id').addClass("chosen").chosen();
    $('#brand_id').addClass("chosen").chosen();
    $('#model_id').addClass("chosen").chosen();
    $('#type_id2').addClass("chosen").chosen();
    $('#brand_id2').addClass("chosen").chosen();
    $('#model_id2').addClass("chosen").chosen();
});


function onAppClick(app_id){

    document.cookie = "appID=" + app_id;

    var url = window.location.pathname;
    url = url.replace('index.php','pricerate.php');
    // console.log(url);
    //alert(url);
    window.location.href = window.location = window.location.protocol + "//" + window.location.hostname + url;
    // console.log(document.cookie);
}