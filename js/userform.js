/**
 * Created by k.diakonidze on 4/9/18.
 */

var userdata;

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
$('#sel_state').empty();
$.ajax({
    url: '../php_code/get_statuses.php?objname=Personmapping',
    method: 'get',
    dataType: 'json',
    success: function (response) {

        response.forEach(function (item) {
            $('<option />').text(item.va).attr('value', item.id).appendTo('#sel_state');
        });
        $('#sel_state option:first-child').attr('selected', 'selected');
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
$('#sel_type').empty();
$.ajax({
    url: '../php_code/get_dictionaryitems.php?code=iCloud_UserType',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        $('<option />').text("აირჩიეთ...").attr('value', 0).appendTo('#sel_type');
        response.forEach(function (item) {
            $('<option />').text(item.ValueText).attr('value', item.ID).appendTo('#sel_type');
        });
        $('#sel_type option:first-child').attr('selected', 'selected');
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
    <!--        filialebis chamonatvali -->
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


function getusers(querys) {

    $.ajax({
        url: '../php_code/get_users.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {

            if ($('#operacia').val() == '2') {
                $('#table_f11').empty().html(table11_hr);
                console.log(response);

                userdata = response;
                response.forEach(function (item) {

                    var td_fname = $('<td />').text(item.FirstName);
                    var td_lname = $('<td />').text(item.LastName);
                    var td_username = $('<td />').text(item.UserName);
                    var td_status = $('<td />').text(item.va);
                    var td_tel = $('<td />').text(item.Phone);

//                var td_org = $('<td />').text(item.OrganizationName + "/" + item.BranchName);

                    var trow = $('<tr></tr>').append(td_fname, td_lname, td_username, td_status, td_tel);
                    trow.attr('onclick', "ont11Click(" + item.ID + ")");
                    $('#table_f11').append(trow);
                });
            }

            if ($('#operacia').val() == '1') {
                if (response == 'ok'){
                    alert("ჩაიწერა!");
                }
            }
        }
    });
}

function ont11Click(userID){

    $('#form_1 input').attr('readonly',false);
    $('#form_1 select').attr('disabled',false);
    $('#form_1 button').attr('disabled',false);
    $('#btn_f1_reset').attr('disabled',false);
    $('#u_state').attr('disabled',false);

    console.log(userdata);
    userdata.forEach(function (item) {
       if (item.ID == userID) {
           $('#u_firstname').val(item.FirstName);
           $('#u_lastname').val(item.LastName);
           $('#u_pnumber').val(item.PrivateNumber);
           $('#u_bday').val(item.BirthDate);
           $('#u_adress').val(item.LegalAdress);
           $('#sel_state').val(item.StateID);
           $('#sel_organization').val(item.OrganizationID);
           $('#sel_branch').val(item.OrganizationBranchID);
           $('#u_tel').val(item.Phone);
           $('#u_username').val(item.UserName);
           $('#sel_type').val(item.UserType);
           $('#comment').val(item.Comment);
       }
    });


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

    console.log('fun33c0');
    $('ul.components').find('li').removeClass('active');
    $('ul.components').find('li:first').addClass('active');


    $('#form_1 input').attr('readonly',true);
    $('#form_1 select').attr('disabled',true);
    $('#form_1 button').attr('disabled',true);
    $('#btn_f1_reset').attr('disabled',true);
    $('#u_state').attr('disabled',true);

    $('#btn_passchange').attr('disabled',true);
});


$('#btn_newuser').on('click', function () {
    $('#form_1 input').attr('readonly',false);
    $('#form_1 select').attr('disabled',false);
    $('#form_1 button').attr('disabled',false);
    $('#btn_f1_reset').attr('disabled',false);
    $('#u_state').attr('disabled',false);

    $('#btn_f1_done').text('ჩაწერა');
    $('#operacia').val('1');
});

$('#btn_search').on('click', function () {
    $('#form_1 input').attr('readonly',true);
    $('#form_1 select').attr('disabled',true);
    $('#form_1 button').attr('disabled',true);
    $('#btn_f1_reset').attr('disabled',true);
    $('#u_state').attr('disabled',true);

    $('#u_username').attr('readonly',false);
    $('#u_firstname').attr('readonly',false);
    $('#u_lastname').attr('readonly',false);
    $('#u_pnumber').attr('readonly',false);
    $('#form_1 button').attr('disabled',false);
    $('#btn_f1_reset').attr('disabled',false);

    $('#btn_f1_done').text('ძებნა');
    $('#operacia').val('2');
});

$('#btn_passchange').on('click', function () {
    $('#form_1 input').attr('readonly',true);
    $('#form_1 select').attr('disabled',true);
    $('#form_1 button').attr('disabled',true);
    $('#btn_f1_reset').attr('disabled',true);
    $('#u_state').attr('disabled',true);

    $('#u_username').attr('readonly',false);
    $('#u_firstname').attr('readonly',false);
    $('#u_lastname').attr('readonly',false);
    $('#u_pnumber').attr('readonly',false);
    $('#form_1 button').attr('disabled',false);
    $('#btn_f1_reset').attr('disabled',false);

    $('#btn_f1_done').text('ძებნა');
    $('#operacia').val('2');
});


$("#btn_f1_reset").on('click', function () {
    $('#form_1').trigger('reset');
});


$('#form_1').on('submit', function(event){
    event.preventDefault();
    var chek = true;
    console.log($(this).serialize());
    console.log($('#sel_branch').val());


    if ($('#operacia').val() == '1' && $('#pass1').val() != $('#pass2').val()){
        alert("შეავსეთ პაროლის გრაფები");
        chek = false;
    }

    if (chek) {

        lastQuery = $(this).serialize();
        getusers(lastQuery);
    }

});

$('#pass1').on('keyup',function (value) {
    var ps = $(this).val();
    var pass = sha256_digest(ps);
    $('#hashpass').val(pass);
    console.log(pass);
});


//-------------------------------------------------------------------------------------------------------------------

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

        //$('#form_11').trigger('submit');
        //getusers(savedCoocieData);
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


var table11_hr = "<tr>\n" +
    "        <th>სახელი</th>\n" +
    "        <th>გვარი</th>\n" +
    "        <th>მომხ.სახელი</th>\n" +
    "        <th>სტატუსი</th>\n" +
    "        <th>ტელეფონი</th>\n" +
    "        </tr>";

$(".panel-heading").on('click', function (el) {
    var criterias = $('#form_11').serialize();

    console.log(serialDataToObj(criterias));


    var gilaki = $(this).find("span.glyphicon");
        if (gilaki.hasClass('glyphicon-chevron-up')) {
            gilaki.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            $(this).closest('.panel').find(".panel-body").slideUp();
        } else {
            gilaki.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            $(this).closest('.panel').find(".panel-body").slideDown();
        }
});



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

