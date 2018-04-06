// form3 - xelshekruleba
// mxolod am gverdis scripti

var pan2Active = false;
var pan3Active = false;
var currAgreementID = 0;
var currIphoneID = 0;
var currApplID = 0;
var currOrg = 0;

<!--    organizaciebis chamonatvali -->
$.ajax({
    url: '../php_code/get_organizations.php',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.OrganizationName).attr('value', item.id).appendTo('#sel_organization_f31');
            $('<option />').text(item.OrganizationName).attr('value', item.id).appendTo('#sel_organization_f33');
        })
    }
});

<!--    statusebi am form31 agreement -->
$('#sel_status_f31').empty();
$.ajax({
    url: '../php_code/get_statuses.php?objname=Agreements',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.va).attr('value', item.id).appendTo('#sel_status_f31');
        });
        $('#sel_status_f31 option:first-child').attr('selected', 'selected');
    }
});

<!--    statusebi am form32 iphones -->
$('#sel_status_f324').empty();
$.ajax({
    url: '../php_code/get_statuses.php?objname=Iphone',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.va).attr('value', item.id).attr('datacode', item.code).appendTo('#sel_status_f324');
        });
        $('#sel_status_f324 option:first-child').attr('selected', 'select');
    }
});

<!--    statusebi am form33 applid -->
$('#sel_status_f33').empty();
$.ajax({
    url: '../php_code/get_statuses.php?objname=ApplID',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.va).attr('value', item.id).attr('datacode', item.code).appendTo('#sel_status_f33');
        });
        $('#sel_status_f33 option:first-child').attr('selected', 'select');
    }
});

<!--    modelebi form_32 -->
$('#sel_modeli_f322').empty();
$.ajax({
    url: '../php_code/get_dictionaryitems.php?code=iPhoneModels',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.ValueText).attr('value', item.ID).appendTo('#sel_modeli_f322');
        });
        //$('#sel_modeli_f322 option:first-child').attr('selected', 'selected');
    }
});

<!--    ios form_32 -->
$('#ios_f322').empty();
$.ajax({
    url: '../php_code/get_dictionaryitems.php?code=ios',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.ValueText).attr('value', item.ID).appendTo('#ios_f322');
        });
        //$('#ios_f322 option:first-child').attr('selected', 'selected');
    }
});

<!--    ScreenLockState form_32 -->
$('#sel_status_f32').empty();
$.ajax({
    url: '../php_code/get_dictionaryitems.php?code=ScreenLockState',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.ValueText).attr('value', item.ID).appendTo('#sel_status_f32');
        });
        //$('#sel_status_f32 option:first-child').attr('selected', 'selected');
    }
});

$('#pan_f31').on('click', function(){

    console.log("ccc21");
    console.log(getCookie("agreementID"));
    document.cookie = "agreementID=0";

});


$(function() {
    //var pg = "agrim.php";

    $('ul.components').find('li').removeClass('active');
    $('ul.components').find("li.midle").addClass('active');


    //alert(document.cookie);
    console.log(document.cookie);

    $("#pan_f32").find('.panel-body').hide();
    $("#pan_f33").find('.panel-body').hide();

//    $("#pan_f31 .panel-body input").css("background-color", "yellow");
//    $("#pan_f31 .panel-body input").attr('readonly',true);
//    $("#pan_f31 .panel-body select").attr('readonly',true);
    $('#btn_edit_f31').attr('disabled',true);
    $('#btn_addiphone_f31').attr('disabled',true);

    var currDate = new Date();

    var strDate = dateformat(currDate);
    $('#agrStart_f31').val(strDate);

   //$(".panel-heading span.glyphicon").trigger('click');



    <!--    sequrity question chamonatvali -->
    $.ajax({
        url: '../php_code/get_sq.php',
        method: 'get',
        dataType: 'json',
        success: function (response) {
            var sq_num = 0;
            var i = 0;
            response.forEach(function (item) {
                if (sq_num == item.DictionaryID){
                    $('<option />').text(item.ValueText).attr('value', item.id).appendTo('#sel_q'+i);
                } else {
                    sq_num = item.DictionaryID;
                    i++;
                    $('<option />').text(item.ValueText).attr('value', item.id).appendTo('#sel_q'+i);
                }

            })
        }
    });

}); // ready funqciis dasasruli



$('#sel_organization_f31').on('change', function () {
    currOrg = $('#sel_organization_f31').val();
    getsublists();
});


$('#btn_addiphone_f31').on('click', function(){
    pan2Active = true;
    $("#pan_f32 span.glyphicon").trigger('click');
    $('#d_f322').find('input').attr('readonly',true);
    $("#d_f322 select").attr('disabled',true);
    $('#d_f323').find('input').attr('readonly',true);
    $("#d_f323 select").attr('disabled',true);
    $('#d_f324').find('input').attr('readonly',true);
    $("#d_f324 select").attr('disabled',true);
    $("#d_f324 button").attr('disabled',true);
    $("#btn_view_f32").attr('disabled',true);
    $("#btn_get_f32").attr('disabled',true);
    $("#btn_add_f32").attr('disabled',true);

});

$('#btn_edit_f31').on('click',function (){



});

$('#btn_go_f32').on('click',function (){

    var imei = $('#imei_f32').val();
    $(this).closest('tr').find('button').attr('disabled',true);
    $(this).removeAttr('disabled');

    $.ajax({
        url: '../php_code/get_imei_info.php?imei=' + imei,
        method: 'get',
        dataType: 'json',
        success: function (response) {


            if (response.view == 1){
                $('#btn_view_f32').attr('disabled',false);
            }
            if (response.get == 1){
                $('#btn_get_f32').attr('disabled',false);
            }
            if (response.add == 1){
                $('#btn_add_f32').attr('disabled',false);
            }

            $('#result_f32').val(response.PhoneRv + response.AgreementRv + response.BlackListRv);
        }
    });

});

$('#btn_view_f32').on('click',function (){
    // mogvaqvs da vachvenebt telefonis monacemebs
    var imei = $('#imei_f32').val();
    $.ajax({
        url: '../php_code/get_iphone_data.php?imei=' + imei,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            console.log(response[0]);
            item = response[0];

            if(response.length > 1){
                alert('იძებნება რამდენიმე ტელეფონი')
            }else{
                var d1 = item.ScreenLockDate.split(" ");
                var d2 = item.ScreenLockSendDate.split(" ");

                $('#imei_f322').val(item.PhIMEINumber);
                $('#sel_modeli_f322').val(item.IphoneModelID);
                $('#serialN_f322').val(item.PhSerialNumber);
                $('#ios_f322').val(item.IphoneiOSID);

                if (item.PhSIMFREE == 0){
                    $('#simfree_f322').prop("checked",false);
                }else{
                    $('#simfree_f322').prop("checked",true);
                }


                $('#pass_res_f32').val(item.RestrictionPass);
                $('#pass_enc_f32').val(item.EncryptionPass);
                $('#pass_lock_f32').val(item.ScreenLockPass);
                $('#lock_date_f32').val(d1[0]);
                $('#lock_send_date_f32').val(d2[0]);
                $('#sel_status_f32').val(item.SLstateID);

                $('#sel_status_f324').val(item.StateID);
                $('#comment_f324').val(item.Comment);

                //console.log(response.IphoneModelID);
            }

        }
    });
});

$('#btn_get_f32').on('click',function (){

    var imei = $('#imei_f32').val();
    $.ajax({
        url: '../php_code/get_iphone_data.php?imei=' + imei,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            console.log(response[0]);
            item = response[0];

            if(response.length > 1){
                alert('იძებნება რამდენიმე ტელეფონი')
            }else{
                var d1 = item.ScreenLockDate.split(" ");
                var d2 = item.ScreenLockSendDate.split(" ");

                $('#imei_f322').val(item.PhIMEINumber);
                $('#sel_modeli_f322').val(item.IphoneModelID);
                $('#serialN_f322').val(item.PhSerialNumber);
                $('#ios_f322').val(item.IphoneiOSID);
                if (item.PhSIMFREE == 0){
                    $('#simfree_f322').prop("checked",false);
                }else{
                    $('#simfree_f322').prop("checked",true);
                }

                $('#sel_status_f324').val(item.StateID);
                $('#comment_f324').val(item.Comment);

                currIphoneID = item.ID;

                //console.log(response.IphoneModelID);
            }

        }
    });

    $('#btn_save_f32').removeAttr('disabled');
    $('#d_f322').find('input').attr('readonly',false);
    $("#d_f322 select").attr('disabled',false);
    $('#d_f323').find('input').attr('readonly',false);
    $("#d_f323 select").attr('disabled',false);
    $('#d_f324').find('input').attr('readonly',false);
    $("#d_f324 select").attr('disabled',false);

});

$('#btn_add_f32').on('click',function (){

    $('#btn_save_f32').removeAttr('disabled');
    $('#d_f322').find('input').attr('readonly',false).val("");
    $("#d_f322 select").attr('disabled',false).val("");
    $('#d_f323').find('input').attr('readonly',false).val("");
    $("#d_f323 select").attr('disabled',false).val("");
    $('#d_f324').find('input').attr('readonly',false).val("");
    $("#d_f324 select").attr('disabled',false).val("");

    $('#imei_f322').val($('#imei_f32').val());
    $('#sel_status_f324 option').removeAttr('selected');
    var sel = "new";
    $("#sel_status_f324 option[datacode=" + sel + "]").attr('selected', 'select');
    //$('#d_f324').find('button').attr('disabled',false);

    currIphoneID = 0;
});


$('#form_32').on('submit', function(event){
    event.preventDefault();
    $('#agrID_f32').val(currAgreementID);
    $('#iphoneID_f32').val(currIphoneID);

    console.log($(this).serialize());

    $.ajax({
        url: '../php_code/ins_iphone.php?op='+"new",
        method: 'post',
        data: $(this).serialize(),
        success: function (response) {
            if (response != 'myerror') {
                $('#d_f324').find('button').attr('disabled',false);
            } else {
                alert(response);
            }
            console.log(response);
        }
    });
});

$('#btn_addapplid_f32').on('click',function (){
    pan3Active = true;
    $("#pan_f33 span.glyphicon").trigger('click');

    $('#form33').find('*').attr('disabled',true);

    $('#form33').find('button').attr('disabled',true);
    $('#form33').find('input').attr('readonly',true);
    $("#form33 select").attr('disabled',true);

    $("#btn_f3edit").attr('disabled',true);
    $("#btn_f3submit").attr('disabled',true);

});


$(".panel-heading span.glyphicon").on('click', function(el){
    var showPermission = true;
    if ($(this).closest('.panel').attr('id') == 'pan_f32'){
        showPermission = pan2Active;
    }
    if ($(this).closest('.panel').attr('id') == 'pan_f33'){
        showPermission = pan3Active;
    }
    if (showPermission){
        if ($(this).hasClass('glyphicon-chevron-up')){
            $(this).removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            $(this).closest('.panel').find(".panel-body").slideUp();
        } else {
            $(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            $(this).closest('.panel').find(".panel-body").slideDown();
        }
    }
});

$('#btn_go_f33').on('click',function (){

    var applid = $('#applid_f33').val();
    $('#btn_get_f33').attr('disabled',true);

    $.ajax({
        url: '../php_code/get_applid_info.php?applid=' + applid,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            console.log(response);
            if (response.get == 1){
                $('#btn_get_f33').attr('disabled',false);
            }

            currApplID = response.id;
            $('#result_f33').val(response.AppleIDRv + response.AgreementRv + response.ProblemRv);
        }
    });
});

$('#btn_get_f33').on('click',function (){
    var applid = $('#applid_f33').val();

    console.log(currApplID)
    $.ajax({
        url: '../php_code/get_apple_id_data.php?id=' + currApplID,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            item = response[0];
            console.log(item);

            if(response.length > 1){
                alert('იძებნება რამდენიმე ApplID')
            }else{
                var d1 = item.CreateDate.split(" ");
                var d2 = item.AplBirthDay.split(" ");

                $('#sel_organization_f33').val(item.OrganizationID);
                $('#email_f33').val(item.AplApplID);
                $('#emailpass_f33').val(item.EmEmailPass);
                $('#firstname').val(item.AplFirstName);
                $('#lastname').val(item.AplLastName);
                $('#appl_id_f33').val(item.AplApplID);
                $('#appl_id_pass_f33').val(item.AplPassword);
                $('#bday').val(d2[0]);
                $('#country').val(item.AplCountry);
                $('#sel_rmail').val(item.AplRescueEmailID);
                $('#sel_q1').val(item.AplSequrityQuestion1ID);
                $('#ans1').val(item.AplSequrityQuestion1Answer);
                $('#sel_q2').val(item.AplSequrityQuestion2ID);
                $('#ans2').val(item.AplSequrityQuestion2Answer);
                $('#sel_q3').val(item.AplSequrityQuestion3ID);
                $('#ans3').val(item.AplSequrityQuestion3Answer);
                $('#sel_status_f33').val(item.StateID);
                $('#date_f33').val(d1[0]);
                $('#comment_f33').val(item.Comment);

                $("#btn_f3submit").attr('disabled',false);

                //console.log(response.IphoneModelID);
            }

        }
    });
});

$('#btn_addApplid_f33').on('click',function (){

    console.log(currOrg);
    $.ajax({
        url: '../php_code/get_apple_id_data.php?id=0&orgid=' + currOrg,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            item = response[0];
            console.log(item);
            console.log(response.length);

            if(response.length != 1 ){
                alert('მოიძებნა '+ response.length+' ApplID')
            }else{
                var d1 = item.CreateDate.split(" ");
                var d2 = item.AplBirthDay.split(" ");

                $('#sel_organization_f33').val(item.OrganizationID);
                $('#email_f33').val(item.AplApplID);
                $('#emailpass_f33').val(item.EmEmailPass);
                $('#firstname').val(item.AplFirstName);
                $('#lastname').val(item.AplLastName);
                $('#appl_id_f33').val(item.AplApplID);
                $('#appl_id_pass_f33').val(item.AplPassword);
                $('#bday').val(d2[0]);
                $('#country').val(item.AplCountry);
                $('#sel_rmail').val(item.AplRescueEmailID);
                $('#sel_q1').val(item.AplSequrityQuestion1ID);
                $('#ans1').val(item.AplSequrityQuestion1Answer);
                $('#sel_q2').val(item.AplSequrityQuestion2ID);
                $('#ans2').val(item.AplSequrityQuestion2Answer);
                $('#sel_q3').val(item.AplSequrityQuestion3ID);
                $('#ans3').val(item.AplSequrityQuestion3Answer);
                $('#sel_status_f33').val(item.StateID);
                $('#date_f33').val(d1[0]);
                $('#comment_f33').val(item.Comment);

                currApplID = item.ID;
                $("#btn_f3submit").attr('disabled',false);
                //console.log(response.IphoneModelID);
            }

        }
    });

});


$('#btn_f3submit').on('click',function (){

    $('#form_33').trigger('submit');
});

$('#form_33').on('submit', function(event){
    event.preventDefault();
    $('#agrID_f33').val(currAgreementID);
    $('#applid_ID_f33').val(currApplID);

    console.log($(this).serialize());

    $.ajax({
        url: '../php_code/upd_applid_agr.php',
        method: 'post',
        data: $(this).serialize(),
        success: function (response) {
            if (response != 'myerror') {
                $("#btn_f3edit").attr('disabled',false);
            } else {
                alert(response);
            }
            console.log(response);
        }
    });
});





function getsublists(reason, rid) {
    // organizaciis archevs mere shesabamisad vanaxlebt masze mibmul siebs
    $('#sel_branch_f31').empty().removeAttr('disabled');

    var sel_org_id = $('#sel_organization_f31').val();

    <!--        filialebis chamonatvali -->
    $.ajax({
        url: '../php_code/get_branches.php?id=' + sel_org_id,
        method: 'get',
        dataType: 'json',
        success: function (response) {
            if (response.length != 1){
                $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#sel_branch_f31');
            }
            response.forEach(function (item) {
                $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#sel_branch_f31');
            });
        }
    });

    <!--        domainebis  chamonatvali -->
    $.ajax({
        url: '../php_code/get_domains.php?id=' + sel_org_id,
        method: 'get',
        dataType: 'json',
        success: function (response) {
            response.forEach(function (item) {
                $('<option />').text(item.DomainName).attr('value', item.id).appendTo('#sel_domain');
            })
        }
    });

    <!--    usafrtxoebis damatebiti maili -->
    $.ajax({
        url: '../php_code/get_rmail.php?id=' + sel_org_id,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            response.forEach(function (item) {
                console.log(item);
                $('<option />').text(item.EmEmail).attr('value', item.id).appendTo('#sel_rmail');

            });
            if (reason == 'fill') {
                $("#sel_rmail option[value=" + rid + "]").attr('selected', 'select');
            }

        }
    });

} // end get sublists











var currmailid = '0';

$('#form_31').on('submit', function (event) {
    event.preventDefault();

    console.log($(this).serialize());

    $.ajax({
        url: '../php_code/ins_agreement.php',
        method: 'post',
        data: $(this).serialize(),
        success: function (response) {
            if (response != 'myerror') {
                if (response == 'aseti nomrit ukve registrirebulia xelshekruleba!'){
                    alert(response);
                }else{

                    currAgreementID = response;
                    $('#btn_edit_f31').attr('disabled',false);
                    $('#btn_addiphone_f31').attr('disabled',false);
                    $('#btn_save_f31').attr('disabled',true);
                    $("#pan_f31 .panel-body input").attr('readonly',true);
                    $("#pan_f31 .panel-body select").attr('disabled',true);


//                    $('#block2').show();
//
//                    $('#appl_id').val($('#email').val() + '@' + $('#sel_domain option:selected').text());
//                    currmailid = response;
//                    $('#btn_addid').hide();
//                    $('#sel_organization').attr('disabled',true);
//                    var d = new Date();
//                    $('#appl_id_info').text('ID: '+ response + ' CreateDate: '  + d.getFullYear()  + "-" + (d.getMonth()+1) + "-" + d.getDate() + " " +
//                        d.getHours() + ":" + d.getMinutes());
                }
            } else {
                alert(response);
            }
            console.log(response);
        }
    });
});


$('#form2').on('submit', function (event) {

//    $('#emName').val($('#email').val());
//    $('#emDom').val($('#sel_domain').val());
//    $('#emPass').val($('#password').val());
//
//    event.preventDefault();
//
//    console.log($(this).serialize());
//
//    console.log('form2_submit');
//    var v = $(event.target).validationMessage;
//    console.log(v);
//
//    $.ajax({
//        url: '../php_code/upd_applid.php?id=' + currmailid,
//        method: 'post',
//        data: $(this).serialize(),
//        success: function (response) {
//
//            loadProjects();
////                if ($('#sel_status').text() == 'აქტიური') {
////                    $('#block2').hide();
////                }
//            console.log(response);
//
//            localRefresh();
//            //location.reload();
//        }
//    });
});

$('#btn_addid').on('click', function(){

    //$('#btn_addid').text('mdaa');
    //  $('#form1').trigger('submit');
});

$('#btn_f2submit').on('click', function(){
    $('#form2').trigger('submit');
});

$('#btn_f2reset').on('click', function(){
    localRefresh();
    $('#form2').trigger('reset');

});

function localRefresh(){
    // on form2 submit or reset/gauqmeba

    $('#btn_addid').show();
    $('#sel_organization').removeAttr('disabled');
    $('#block2').slideUp(600);
    $('#appl_id_info').text('');
    //location.reload();
}

setTimeout(function () {
    // $('#p2').text($('#p1').text());

}, 500);


//loadProjects();

function loadProjects() {
    // me3 blokis shevseba

    var rr = "<tr>\n" +
        "        <th>ID</th>\n" +
        "        <th>ორგანიზაცია</th>\n" +
        "        <th>ფილიალი</th>\n" +
        "        <th>ელ ფოსტა</th>\n" +
        "        <th>შექმნის თარიღი</th>\n" +
        "        <th>მომხმარებელი</th>\n" +
        "        <th>სტატუსი</th>\n" +
        "        </tr>";

    $('#table_block3').empty().html(rr);
    //$('#table_block3').html(rr);

    $.ajax({
        url: '../php_code/get_apple_projects.php',
        method: 'get',
        dataType: 'json',
        success: function (response) {
            response.forEach(function (item) {

                var td_id = $('<td />').text(item.id);
                var td_org = $('<td />').text(item.OrganizationName);
                var td_fil = $('<td />').text(item.BranchName);
                var td_email = $('<td />').text(item.EmEmail);
                var td_date = $('<td />').text(item.CreateDate);
                var td_user = $('<td />').text(item.CreateUser);
                var td_st = $('<td />').text(item.va);

                var trow = $('<tr></tr>').append(td_id, td_org, td_fil, td_email, td_date, td_user, td_st);
                trow.attr('onclick', "onRowClick(" + item.id + ")");
                $('#table_block3').append(trow);
            });
        }
    });
}

function onRowClick(num) {

    if ($('#block2').css('display') != 'none' ){
        alert("შეინახეთ ან გააუქმეთ მიმდინარე მონაცემები!");
    }else{
        var thetr = "tr[onclick=\"onRowClick("+num+")\"]";
        $('#table_block3 tr').css({
            'background-color': 'white'
        });
        $('#table_block3').find(thetr).css({
            'background-color': '#b5dcff'
        });
        $('#sel_organization').attr('disabled',true);
        $('#btn_addid').hide();

        $.ajax({
            url: '../php_code/get_apple_id_data.php?id=' + num,
            method: 'get',
            dataType: 'json',
            success: function (response) {
                $('#block2').slideDown();
                var row = response[0];
                currmailid = row.AplAccountEmailID;

                $('#sel_organization option').removeAttr('selected');
                $("#sel_organization option[value=" + row.OrganizationID + "]").attr('selected', 'selected');

                getsublists('fill', row.AplRescueEmailID);

                $('#firstname').val(row.AplFirstName);
                $('#lastname').val(row.AplLastName);
                $("#appl_id").val(row.AplApplID);
                $("#appl_id_pass").val(row.AplPassword);
                $("#bday").val(row.AplBirthDay);
                $("#country").val(row.AplCountry);

                $("#ans1").val(row.AplSequrityQuestion1Answer);
                $("#ans2").val(row.AplSequrityQuestion2Answer);
                $("#ans3").val(row.AplSequrityQuestion3Answer);
                $('#sel_q1 option').removeAttr('selected');
                $("#sel_q1 option[value=" + row.AplSequrityQuestion1ID + "]").attr('selected', 'selected');
                $('#sel_q2 option').removeAttr('selected');
                $("#sel_q2 option[value=" + row.AplSequrityQuestion2ID + "]").attr('selected', 'selected');
                $('#sel_q3 option').removeAttr('selected');
                $("#sel_q3 option[value=" + row.AplSequrityQuestion3ID + "]").attr('selected', 'selected');

                $('#sel_status option').removeAttr('selected');
                $("#sel_status option[value=" + row.StateID + "]").attr('selected', 'select');
                $("#comment").val(row.Comment);

                var em = row.AplApplID.split("@");
                $('#email').val(em[0]);
                $('#password').val(row.EmEmailPass);

                $('#appl_id_info').text('ID: '+ row.ID + ' CreateDate: ' + row.CreateDate);

            }
        });
    }


}

$('.eye').on('click', function () {

    var atag = $(this).closest('.input-group').find('input');
    var aicon = $(this).find('span');

    if (atag.attr('type') == "text"){
        atag.attr('type','password');
        aicon.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
    } else {
        atag.attr('type','text');
        aicon.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
    }
});

$('.passgen').on('click', function () {

    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 12; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    $(this).closest('.input-group').find('input').val(text);
});


//
//$('#email').on('keyup', function() {
//    $('#appl_id').val($(this).val()+"@"+$('#sel_domain').text());
//});
//
//$('#sel_domain').on('change',function(){
//    $('#appl_id').val($('#email').val()+"@"+$('#sel_domain').text());
//});

$('#appl_id_info').text('');


function dateformat(d){
    var mm, dd;
    if (d.getMonth() < 9) {
        mm = "0"+ (d.getMonth()+1);
    }else{
        mm = d.getMonth()+1;
    }
    if (d.getDate() < 10) {
        dd = "0" + d.getDate();
    }else{
        dd = d.getDate();
    }
    return d.getFullYear()  + "-" + mm + "-" + dd;
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
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