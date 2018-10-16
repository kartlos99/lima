/**
 * Created by k.diakonidze on 4/9/18.
 */
var projectFolder = "/lima"; // serverze carielia ""
var currAgreementID = 0;
var currIphoneID = 0;
var currApplID = 0;
var org_p1 = 0;
var org_p3 = 0;
var lastQuery = "";

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

    loadBranches11(org_p1, 0)
});

function loadBranches11(orgID, brID){
    $('#sel_branch').empty().removeAttr('disabled');
    if (orgID == "") {
        $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#sel_branch');
    }
    // <!--    filialebis chamonatvali -->
    $.ajax({
        url: '../php_code/get_branches.php?id=' + orgID,
        method: 'get',
        dataType: 'json',
        success: function (response) {
            if (response.length != 1){
                $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#sel_branch');
            }
            response.forEach(function (item) {
                $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#sel_branch');
            });
            if (brID > 0){
                $('#sel_branch').val(brID);
            }
        }
    });
}

$('#sel_organization_f13').on('change', function () {

    org_p3 = $('#sel_organization_f13').val();

    $('#sel_branch_f13').empty().removeAttr('disabled');

    // <!--        filialebis chamonatvali -->
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
    $('#f11_pageN').val( 0 );
    console.log($(this).serialize());
    console.log($('#sel_branch').val());

    // if ($('#agrN_f11').val() == "" && $('#imei_f11').val() == "" && $('#serialN_f11').val() == "" && $('#applID_f11').val() == "" ){
    //     alert("შეავსეთ ძიების პარამეტრები");
    // }else {
        lastQuery = $(this).serialize();
        requestAgreementList(lastQuery);
    //}

});

$('#f11_ul').on("click", "a", function(e){
    e.preventDefault();
    var pgN = $(this).text();    
    $('#f11_pageN').val( pgN - 1 );
    lastQuery = $('#form_11').serialize();
    requestAgreementList(lastQuery);
});

$('#f13_ul').on("click", "a", function(e){
    e.preventDefault();
    var pgN = $(this).text();
    $('#f13_pageN').val( pgN - 1 );
    getApplidList( $('#form_13').serialize() );    
});

function makePaginationButtons(holderItem, btnCount){
    var pages1 = $(holderItem);
    pages1.empty();

    for (var i = 1 ; i < btnCount + 1 ; i++){
        var aa = $('<a />').text(i).attr('href',"#");
        var lii = $('<li />');
        lii.append(aa);
        pages1.append(lii);
    }
}

function requestAgreementList(querys) {

    $.ajax({
        url: '../php_code/get_results_f11.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {
            $('#table_f11').empty().html(table11_hr);
            // console.log(response);

            var itemCount = response[0].n;
            var itemShowLimit = response[0].limit_by_user;
            if (response[0].n == 0){
                alert("არ მოიძებნა ჩანაწერი");
            }
            $('#pan_f11 p.info').text("ძიების შედეგი (მოიძებნა "+ response[0].n +" ჩანაწერი, ეკრანზე MAX " + response[0].limit_by_user + ")");
            
            var pageCount = 0;
            
            if (parseInt(itemCount) < parseInt(itemShowLimit)) {
                pageCount = itemCount / 10;
            } else {
                pageCount = itemShowLimit / 10;
            }
            
            makePaginationButtons('#f11_ul', pageCount);            

            var pgN = parseInt($('#f11_pageN').val()) + 1;
            $( "#f11_ul li:nth-child("+pgN+")" ).addClass('active');
            console.log("pgN = "+pgN);
            response.splice(0,1);

            response.forEach(function (item) {

                var td_number = $('<td />').text(item.Number).addClass('equalsimbols');
                var td_date = $('<td />').text(item.Date).addClass('equalsimbols');
                var td_status = $('<td />').text(item.status);
                var td_imei = $('<td />').text(item.IMEI).addClass('equalsimbols');
                var td_tel = $('<td />').text(item.Model);
                var td_applid = $('<td />').text(item.ApplID);
                var td_org = $('<td />').text(item.OrganizationName + "/" + item.BranchName);

                var trow = $('<tr></tr>').append(td_number, td_date, td_status, td_imei, td_tel, td_applid, td_org);
                trow.attr('onclick', "ont11Click(" + item.ID + ")");
                $('#table_f11').append(trow);
            });
        }
    });
}

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
    $('#f13_pageN').val( 0 );
    getApplidList( $(this).serialize() );
});

function getApplidList(querys){
    $.ajax({
        url: '../php_code/get_results_f13.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {
            $('#table_f13').empty().html(table13_hr);
            console.log(response);

            if (response[0].n == 0){
                alert("არ მოიძებნა ჩანაწერი");
            }
            $('#pan_f13 p.info').text("ძიების შედეგი (მოიძებნა "+ response[0].n +" ჩანაწერი, ეკრანზე MAX 20)");
            var pageCount = 0;
            
            if ( parseInt(response[0].n) <= 10 ) {
                pageCount = 1;
            } else {
                pageCount = 2;
            }
            
            makePaginationButtons('#f13_ul', pageCount);            
            var pgN = parseInt($('#f13_pageN').val()) + 1;
            $( "#f13_ul li:nth-child("+pgN+")" ).addClass('active');
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
}

function ont13Click(apl_id){

    document.cookie = "ApplIDID=" + apl_id;

    var url = "/administrator/page1.php";
    console.log(url);
    //alert(url);
    window.location.href = window.location = window.location.protocol + "//" + window.location.hostname + projectFolder + url;
    console.log(document.cookie);
}

$(function(){

    console.log('func0');
    $('ul.components').find('li').removeClass('active');
    $('ul.components').find('li.mainLi').addClass('active');

    $('#table_f11').empty().html(table11_hr);
    $('#table_f13').empty().html(table13_hr);

    $('#pan_f12 .panel-heading').trigger('click');
});

function f_show(){
    lastQuery = getCookie('f11_pos');
    console.log(getCookie('f11_pos'));
    var savedCoocieData = getCookie('f11_pos');
    if (savedCoocieData != "0" && savedCoocieData != ""){
        var queryData = serialDataToObj(savedCoocieData);

        $('#sel_organization').val(queryData.organization);
            loadBranches11(queryData.organization, queryData.branch);
        $('#agrN_f11').val(queryData.agrN);
        $('#sel_status_f11').val(queryData.status);
        $('#agrStart1_f11').val(queryData.agrStart1);
        $('#agrStart2_f11').val(queryData.agrStart2);
        $('#agrFinish1_f11').val(queryData.agrFinish1);
        $('#agrFinish2_f11').val(queryData.agrFinish2);
        $('#imei_f11').val(queryData.imei);
        $('#sel_modeli_f11').val(queryData.modeli);
        $('#serialN_f11').val(queryData.serialN);
        $('#applID_f11').val(queryData.applid);
        if (queryData.onlyme == 1) {
            $('#onlyme_f11').prop("checked", true);
        } else {
            $('#onlyme_f11').prop("checked", false);
        }
        $('#f11_pageN').val( queryData.pageN );

        //$('#form_11').trigger('submit');
        requestAgreementList(savedCoocieData);
        //document.cookie = "f11_pos=0";
    }
    console.log('show');

}

function f_hide(){

    if (lastQuery != "organization=&branch=&agrN=&status=0&agrStart1=&agrStart2=&agrFinish1=&agrFinish2=&imei=&modeli=0&serialN=&applid=") {
        document.cookie = "f11_pos=" + lastQuery;
    }else {
        document.cookie = "f11_pos=0";
    }
}

function serialDataToObj(data){
    var obj={};
    var spData = data.split("&");
    for(var key in spData)
    {
        //console.log(spData[key]);
        obj[spData[key].split("=")[0]] = spData[key].split("=")[1];
    }
    return obj;
}

$("#f11_reset").on('click', function () {
    $('#form_11').trigger('reset');
});

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

