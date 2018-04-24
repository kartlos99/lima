/**
 * Created by k.diakonidze on 4/9/18.
 */
var projectFolder = "/lima"; // serverze carielia ""
var currAgreementID = 0;
var currIphoneID = 0;
var currApplID = 0;
var org_p1 = 0;
var org_p3 = 0;

$('button').addClass('btn-sm');

//<!--    organizaciebis chamonatvali -->
$.ajax({
    url: '../php_code/get_organizations.php',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.OrganizationName).attr('value', item.id).appendTo('#sel_organization');
            $('<option />').text(item.OrganizationName).attr('value', item.id).appendTo('#sel_organization_f13');
        })
    }
});

//<!--    statusebi agreement -->
$('#sel_status_f11').empty();
$.ajax({
    url: '../php_code/get_statuses.php?objname=Agreements',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        $('<option />').text("ყველა").attr('value', 0).appendTo('#sel_status_f11');
        response.forEach(function (item) {
            $('<option />').text(item.va).attr('value', item.id).appendTo('#sel_status_f11');
        });
        $('#sel_status_f11 option:first-child').attr('selected', 'selected');
    }
});

//<!--    statusebi ApplID -->
$('#sel_status_f13').empty();
$.ajax({
    url: '../php_code/get_statuses.php?objname=ApplID',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        $('<option />').text("ყველა").attr('value', 0).appendTo('#sel_status_f13');
        response.forEach(function (item) {
            $('<option />').text(item.va).attr('value', item.id).appendTo('#sel_status_f13');
        });
        $('#sel_status_f13 option:first-child').attr('selected', 'selected');
    }
});

//<!--    modelebi form11 -->
$('#sel_modeli_f11').empty();
$.ajax({
    url: '../php_code/get_dictionaryitems.php?code=iPhoneModels',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        $('<option />').text("ყველა").attr('value', 0).appendTo('#sel_modeli_f11');
        response.forEach(function (item) {
            $('<option />').text(item.ValueText).attr('value', item.ID).appendTo('#sel_modeli_f11');
        });
        $('#sel_modeli_f11 option:first-child').attr('selected', 'selected');
    }
});


$('#sel_organization').on('change', function () {

    org_p1 = $('#sel_organization').val();

    $('#sel_branch').empty().removeAttr('disabled');
    $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#sel_branch');
    <!--        filialebis chamonatvali -->
    $.ajax({
        url: '../php_code/get_branches.php?id=' + org_p1,
        method: 'get',
        dataType: 'json',
        success: function (response) {
            if (response.length != 1){
                $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#sel_branch');
            }
            response.forEach(function (item) {
                $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#sel_branch');
            });
        }
    });
});

$('#sel_organization_f13').on('change', function () {

    org_p3 = $('#sel_organization_f13').val();

    $('#sel_branch_f13').empty().removeAttr('disabled');

    <!--        filialebis chamonatvali -->
    $.ajax({
        url: '../php_code/get_branches.php?id=' + org_p3,
        method: 'get',
        dataType: 'json',
        success: function (response) {
            if (response.length != 1){
                $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#sel_branch_f13');
            }
            response.forEach(function (item) {
                $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#sel_branch_f13');
            });
        }
    });
});


$('#btn_search_f12').on('click',function (){


    //window.location.href = "http://127.0.0.1/lima/administrator/page1.php";
    console.log(window.location.hostname);
    console.log(window.location.pathname);
    console.log(window.location.protocol);
    console.log(window.location.host);
});

$('#form_11').on('submit', function(event){
    event.preventDefault();
    console.log($(this).serialize());
    console.log($('#sel_branch').val());

    // if ($('#agrN_f11').val() == "" && $('#imei_f11').val() == "" && $('#serialN_f11').val() == "" && $('#applID_f11').val() == "" ){
    //     alert("შეავსეთ ძიების პარამეტრები");
    // }else {

        $.ajax({
            url: '../php_code/get_results_f11.php',
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                $('#table_f11').empty().html(table11_hr);
                console.log(response);

                if (response[0].n == 0){
                    alert("არ მოიძებნა ჩანაწერი");
                }
                $('#pan_f11 p.info').text("ძიების შედეგი (მოიძებნა "+ response[0].n +" ჩანაწერი, ეკრანზე MAX 20)")
                response.splice(0,1);
                console.log(response);

                response.forEach(function (item) {

                    var td_number = $('<td />').text(item.Number);
                    var td_date = $('<td />').text(item.Date);
                    var td_status = $('<td />').text(item.status);
                    var td_imei = $('<td />').text(item.IMEI);
                    var td_tel = $('<td />').text(item.Model);
                    var td_applid = $('<td />').text(item.ApplID);
                    var td_org = $('<td />').text(item.OrganizationName + "/" + item.BranchName);

                    var trow = $('<tr></tr>').append(td_number, td_date, td_status, td_imei, td_tel, td_applid, td_org);
                    trow.attr('onclick', "ont11Click(" + item.ID + ")");
                    $('#table_f11').append(trow);
                });
            }
        });
    //}

});


function ont11Click(agr_id){

    document.cookie = "agreementID=" + agr_id;

    var url = "/administrator/agrim.php";
    console.log(url);
    //alert(url);
    window.location.href = window.location = window.location.protocol + "//" + window.location.hostname + projectFolder + url;
    console.log(document.cookie);
}

$('#form_13').on('submit', function(event){
    event.preventDefault();
    console.log($(this).serialize());

    $.ajax({
        url: '../php_code/get_results_f13.php',
        method: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            $('#table_f13').empty().html(table13_hr);
            console.log(response);

            if (response[0].n == 0){
                alert("არ მოიძებნა ჩანაწერი");
            }
            $('#pan_f13 p.info').text("ძიების შედეგი (მოიძებნა "+ response[0].n +" ჩანაწერი, ეკრანზე MAX 20)")
            response.splice(0,1);

            response.forEach(function (item) {

                var td_number = $('<td />').text(item.ID);
                var td_status = $('<td />').text(item.st);
                var td_applid = $('<td />').text(item.AplApplID);
                var td_org = $('<td />').text(item.OrganizationName + "/" + item.BranchName);

                var trow = $('<tr></tr>').append(td_number, td_applid, td_org, td_status);
                trow.attr('onclick', "ont13Click(" + item.ID + ")");
                $('#table_f13').append(trow);
            });
        }
    });

});

function ont13Click(apl_id){

    document.cookie = "ApplIDID=" + apl_id;

    var url = "/administrator/page1.php";
    console.log(url);
    //alert(url);
    window.location.href = window.location = window.location.protocol + "//" + window.location.hostname + projectFolder + url;
    console.log(document.cookie);
}


$(function(){

    $('ul.components').find('li').removeClass('active');
    $('ul.components').find('li:first').addClass('active');

    $('#table_f11').empty().html(table11_hr);
    $('#table_f13').empty().html(table13_hr);
});

function f_show(){
    console.log(getCookie('f11_pos'));
    if (getCookie('f11_pos') != "0" && getCookie('f11_pos') != "organization=&branch=&agrN=&status=0&agrStart1=&agrStart2=&agrFinish1=&agrFinish2=&imei=&modeli=0&serialN=&applid="){
        $('#form_11').trigger('submit');
        document.cookie = "f11_pos=0";
    }
    console.log(getCookie('f11_pos'));
}

function f_hide(){
    console.log("hide");
    document.cookie = "f11_pos=" + $('#form_11').serialize();
}

$(".panel-heading").on('click', function (el) {
    var gilaki = $(this).find("span.glyphicon");
        if (gilaki.hasClass('glyphicon-chevron-up')) {
            gilaki.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            $(this).closest('.panel').find(".panel-body").slideUp();
        } else {
            gilaki.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            $(this).closest('.panel').find(".panel-body").slideDown();
        }
});


var table11_hr = "<tr>\n" +
    "        <th>ხელშეკრ.N</th>\n" +
    "        <th>ხელშეკრ. თარიღი</th>\n" +
    "        <th>ხელშეკრ. სტატუსი</th>\n" +
    "        <th>IMEI</th>\n" +
    "        <th>ტელეფონი</th>\n" +
    "        <th>ApplID</th>\n" +
    "        <th>ორგანიზაცია/ფილიალი</th>\n" +
    "        </tr>";



var table13_hr = "<tr>\n" +
    "        <th>ID</th>\n" +
    "        <th>ApplID</th>\n" +
    "        <th>ორგანიზაცია/ფილიალი</th>\n" +
    "        <th>სტატუსი</th>\n" +
    "        </tr>";

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}