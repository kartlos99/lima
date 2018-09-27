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

// momxmareblis tipebi
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

function loadBranches11(orgID, brID) {
    $('#sel_branch').empty().removeAttr('disabled');
    if (orgID == "") {
        $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#sel_branch');
    }
    // <!--        filialebis chamonatvali -->
    $.ajax({
        url: '../php_code/get_branches.php?id=' + orgID,
        method: 'get',
        dataType: 'json',
        success: function (response) {
            if (response.length != 1) {
                $('<option />').text('აირჩიეთ...').attr('value', '0').appendTo('#sel_branch');
            }
            response.forEach(function (item) {
                $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#sel_branch');
            });
            if (brID > 0) {
                $('#sel_branch').val(brID);
            }
        }
    });
}


function getusers(querys) {

    $.ajax({
        url: '../php_code/get_users.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {
            console.log(response);

            if ($('#operacia').val() == '2') {
                $('#table_f11').empty().html(table11_hr);

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
                if (response == 'ok') {
                    alert("ჩაიწერა!");
                }
            }

            if ($('#operacia').val() == '3' || $('#operacia').val() == '4') {
                if (response == 'ok') {
                    alert("განახლებულია!");
                }
            }

            if (response == 'exist'){
                alert("მომხმარებლის სახელი დაკავებულია!");
                $('#btn_f1_done').attr('disabled',false);
            }
        }
    });
}

function ont11Click(userID) {

    $('#form_1 input').attr('readonly', false);
    $('#form_1 select').attr('disabled', false);
    $('#form_1 button').attr('disabled', false);
    $('#btn_f1_reset').attr('disabled', false);
    $('#u_state').attr('disabled', false);

    userdata.forEach(function (item) {
        if (item.ID == userID) {
            loadBranches11(item.OrganizationID, item.OrganizationBranchID);
            var bdt = item.BirthDate.split(" ");
            $('#u_firstname').val(item.FirstName);
            $('#u_lastname').val(item.LastName);
            $('#u_pnumber').val(item.PrivateNumber);
            $('#u_bday').val(bdt[0]);
            $('#u_adress').val(item.LegalAdress);
            $('#sel_state').val(item.StateID);
            $('#sel_organization').val(item.OrganizationID);
            $('#u_tel').val(item.Phone);
            $('#u_username').val(item.UserName);
            $('#h_username').val(item.UserName);
            $('#sel_type').val(item.UserTypeID);
            $('#comment').val(item.Comment);
            $('#personid').val(item.PersonID);
        }
    });

    $('#btn_f1_done').text('ჩაწერა');
    $('#operacia').val('3');
    $('#pass1').val('').attr('disabled', true);
    $('#pass2').val('').attr('disabled', true);
    $('#btn_passchange').attr('disabled', false);
    $('ul.nav li').removeClass('active');
    $('#msgdiv').hide();
}

$('#btn_passchange').on('click', function () {
    $('#operacia').val('4');
});

$(function () {

    $('ul.components').find('li').removeClass('active');
    $('ul.components').find('li.userManLi').addClass('active');


    $('#form_1 input').attr('readonly', true);
    $('#form_1 select').attr('disabled', true);
    $('#form_1 button').attr('disabled', true);
    $('#btn_f1_reset').attr('disabled', true);
    $('#u_state').attr('disabled', true);

    $('#btn_passchange').attr('disabled', true);
    $('ul.nav-pills').css({
        'background' : '#dddddd',
        'border-radius' : '6px',
        'margin' : '6px'
    })
});


$('#btn_newuser').on('click', function () {
    $('ul.nav li').removeClass('active');
    $('#btn_newuser').addClass('active');
    
    $('#form_1 input').attr('readonly', false);
    $('#form_1 input').attr('disabled', false);
    $('#form_1 select').attr('disabled', false);
    $('#form_1 button').attr('disabled', false);
    $('#btn_f1_reset').attr('disabled', false);
    $('#u_state').attr('disabled', false);

    $('#btn_passchange').attr('disabled', true);

    $('#btn_f1_done').text('ჩაწერა');
    $('#operacia').val('1');
    $('#pass1').trigger('blur');
});

$('#btn_search').on('click', function () {
    $('ul.nav li').removeClass('active');
    $('#btn_search').addClass('active');

    $('#form_1 input').attr('readonly', true);
    $('#form_1 select').attr('disabled', true);
    $('#form_1 button').attr('disabled', true);
    $('#btn_f1_reset').attr('disabled', true);
    $('#u_state').attr('disabled', true);

    $('#u_username').attr('readonly', false);
    $('#u_firstname').attr('readonly', false);
    $('#u_lastname').attr('readonly', false);
    $('#u_pnumber').attr('readonly', false);
    $('#form_1 button').attr('disabled', false);
    $('#btn_f1_reset').attr('disabled', false);

    $('#btn_passchange').attr('disabled', true);
    // $('#btn_passchange').addClass('disabled');

    $('#btn_f1_done').text('ძებნა');
    $('#operacia').val('2');
    $('#msgdiv').hide();
});

$('#btn_passchange').on('click', function () {
    if ($('#btn_passchange').attr('disabled') != 'disabled' ){
        $('ul.nav li').removeClass('active');
        $('#btn_passchange').addClass('active');
        
        $('#pass1').val('').attr('disabled', false);
        $('#pass2').val('').attr('disabled', false);
        $('#operacia').val('4');
    }

    // $('#form_1 input').attr('readonly', true);
    // $('#form_1 select').attr('disabled', true);
    // $('#form_1 button').attr('disabled', true);
    // $('#btn_f1_reset').attr('disabled', true);
    // $('#u_state').attr('disabled', true);
    //
    // $('#u_username').attr('readonly', false);
    // $('#u_firstname').attr('readonly', false);
    // $('#u_lastname').attr('readonly', false);
    // $('#u_pnumber').attr('readonly', false);
    // $('#form_1 button').attr('disabled', false);
    // $('#btn_f1_reset').attr('disabled', false);

});


$("#btn_f1_reset").on('click', function () {
    $('#form_1').trigger('reset');
});


$('#form_1').on('submit', function (event) {
    event.preventDefault();
    var chek = true;
    // console.log($(this).serialize());
    // console.log($('#sel_branch').val());

    if ($('#operacia').val() != '2') {

        if (($('#operacia').val() == '1' || $('#operacia').val() == '4') && $('#pass1').val() == '') {
            alert("შეავსეთ პაროლის გრაფები");
            chek = false;
        }else {
            if (($('#operacia').val() == '1' || $('#operacia').val() == '4') && $('#pass1').val() != $('#pass2').val()) {
                alert("პაროლები არ ემთხვევა");
                chek = false;
            }
        }

        if ($('#sel_organization').val() == '0' || $('#sel_organization').val() == '') {
            alert("შეავსეთ ორგანიზაცია");
            chek = false;
        }else {
            if ($('#sel_branch').val() == '0' || $('#sel_branch').val() == '') {
                alert("შეავსეთ ფილიალი");
                chek = false;
            }
        }

        if ($('#sel_type').val() == '0' || $('#sel_type').val() == '') {
            alert("აირჩიეთ მომხმარებლის ტიპი");
            chek = false;
        }

        if ($('#u_username').val() == ''){
            alert("შეიყვანეთ მომხმარებლის სახელი");
            chek = false;
        }
    }


    if ($('#operacia').val() != '2' && chek) {
        // 2 - dzebna, tu dzebnis rejimze aravart mashin Senaxvis Rilaks vtishavt
        $('#btn_f1_done').attr('disabled', true);
    }

    if (chek) {
        lastQuery = $(this).serialize();
        getusers(lastQuery);
    }


});

$('#pass1').on('keyup', function (value) {
    var ps = $(this).val();
    var pass = sha256_digest(ps);
    $('#hashpass').val(pass);
});


//-------------------------------------------------------------------------------------------------------------------

function f_show() {
}

function f_hide() {
}

function serialDataToObj(data) {
    var obj = {};
    var spData = data.split("&");
    for (var key in spData) {
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

    var gilaki = $(this).find("span.glyphicon");
    if (gilaki.hasClass('glyphicon-chevron-up')) {
        gilaki.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        $(this).closest('.panel').find(".panel-body").slideUp();
    } else {
        gilaki.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        $(this).closest('.panel').find(".panel-body").slideDown();
    }
});


$('#pass1').on('blur', function(){
    var ps = $(this).val();
    if (validatepass(ps) != 0){
        $('#msgdiv').show();
        $('#btn_f1_done').attr('disabled',true);
    }else{
        $('#msgdiv').hide();
        $('#btn_f1_done').attr('disabled',false);
    }
 })

 function validatepass(pass){    
    if (!pass)
        return 1;

    if (pass.length < 8)
        return 8;

    var variations = {
        digits: /\d/.test(pass),
        lower: /[a-z]/.test(pass),
        upper: /[A-Z]/.test(pass),
        nonWords: /\W/.test(pass),
    }

    var cc = 0;
    for (var check in variations) {
        cc += (variations[check] == true) ? 0 : 1;
    }
    return cc;
 }