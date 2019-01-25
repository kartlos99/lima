// form3 - xelshekruleba
// mxolod am gverdis scripti

var pan2Active = false;
var pan3Active = false;
var currAgreementID = 0;
var currIphoneID = 0;
var tempIphoneID = 0;
var currApplID = 0;
var tempApplID = 0;
var currOrg = 0;
var causer="", cadate="", ciuser="", cidate="", capuser="", capdate="";
var reasonEdit = false;
var limited = false;
var candidateApplidID = 0;
var organizationObj;

$('button').addClass('btn-sm');

// <!--    organizaciebis chamonatvali -->
$.ajax({
    url: '../php_code/get_organizations.php',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        organizationObj = response;
        response.forEach(function (item) {
            var opt = $('<option />').text(item.OrganizationName).attr('value', item.id);
            if (reasonEdit == false){
                if (item.code == "Active"){
                    opt.appendTo('#sel_organization_f31');        
                }
            }else{
                opt.appendTo('#sel_organization_f31');
            }
        });
        $('#sel_organization_f33').html($('#sel_organization_f31').html());
    }
});

// <!--    statusebi am form31 agreement -->
$('#sel_status_f31').empty();
$.ajax({
    url: '../php_code/get_statuses.php?objname=Agreements',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.va).attr('value', item.id).attr('code', item.code).appendTo('#sel_status_f31');
        });
        $('#sel_status_f31 option:first-child').attr('selected', 'selected');
    }
});

// <!--    statusebi am form32 iphones -->
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

// <!--    statusebi am form33 applid -->
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

// <!--    modelebi form_32 -->
$('#sel_modeli_f322').empty();
$.ajax({
    url: '../php_code/get_dictionaryitems.php?code=iPhoneModels',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        $('<option />').text('აირჩიეთ...').attr('value', '0').appendTo('#sel_modeli_f322');
        response.forEach(function (item) {
            $('<option />').text(item.ValueText).attr('value', item.ID).appendTo('#sel_modeli_f322');
        });
        $('#sel_modeli_f322 option:first-child').attr('selected', 'select');
    }
});

// <!--    ios form_32 -->
$('#ios_f322').empty();
$.ajax({
    url: '../php_code/get_dictionaryitems.php?code=ios',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        $('<option />').text('აირჩიეთ...').attr('value', '0').appendTo('#ios_f322');
        response.forEach(function (item) {
            $('<option />').text(item.ValueText).attr('value', item.ID).appendTo('#ios_f322');
        });
        $('#ios_f322 option:first-child').attr('selected', 'select');
    }
});

// <!--    ScreenLockState form_32 -->
$.ajax({
    url: '../php_code/get_dictionaryitems.php?code=ScreenLockState',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        $('#sel_status_f32').empty();
        $('<option />').text('აირჩიეთ...').attr('value', '0').attr('datacode', '').appendTo('#sel_status_f32');
        // console.log(response);
        response.forEach(function (item) {
            $('<option />').text(item.ValueText).attr('value', item.ID).attr('datacode', item.Code).appendTo('#sel_status_f32');
        });
        $('#sel_status_f32 option:first-child').attr('selected', 'select');
    }
});

$('#pan_f31').on('click', function () {

    //document.cookie = "agreementID=0";

});


function getAgreement() {
    reasonEdit = true;
    $('#agr_history').attr('href','../php_code/get_agr_history.php?agrID=' + currAgreementID);
    $.ajax({
        url: '../php_code/get_agreement.php?id=' + currAgreementID,
        method: 'get',
        dataType: 'json',
        success: function (response) {
            if (response.length > 0) {
                item = response[0];
                // console.log(item);

                if (response.length > 1) {
                    alert('იძებნება რამდენიმე ხელშეკრულება')
                } else {
                    var d1 = item.Date.split(" ");
                    var d2 = item.EndDate.split(" ");

                    $('#sel_organization_f31').val(item.OrganizationID);
                    currOrg = item.OrganizationID;
                    //$('#sel_branch_f31').attr("disabled", true);

                    getsublists(item.OrganizationBranchID);

                    $('#agrN_f31').val(item.Number);
                    $('#agrFinish_f31').val(d2[0]);
                    $('#sel_status_f31').val(item.StateID);
                    $('#agrStart_f31').val(d1[0]);
                    $('#comment_f31').val(item.Comment);

                    currApplID = item.ApplIDFixID;
                    tempApplID = item.ApplIDFixID;
                    currIphoneID = item.IphoneFixID;
                    tempIphoneID = item.IphoneFixID;

                    if (currIphoneID != 0) {
                        var url_id = '../php_code/get_iphone_data.php?id=' + currIphoneID;
                        getIphoneData(url_id);
                        pan2Active = true;
                        $('#iphone_history').attr('href','../php_code/get_iphone_history.php?phoneID=' + currIphoneID);
                    } else {
                        $('#btn_addiphone_f31').attr("disabled", false);
                    }

                    if (currApplID != 0) {
                        candidateApplidID = currApplID;
                        $('#btn_get_f33').trigger('click');
                        pan3Active = true;
                    } else {
                        $('#btn_addapplid_f32').attr("disabled", false);
                    }

                    if (!limited) {
                        $("#btn_edit_f31").attr('disabled', false);
                    }
                    $("#pan_f31 .panel-body input").attr('readonly', true);
                    $("#pan_f31 .panel-body select").attr('disabled', true);
                    $("#btn_save_f31").attr('disabled', true);

                    //console.log(response.IphoneModelID);
                    $('#pan_f31 span.panel-info').text("შექმნა: "+ item.CreateUser + " "+ item.CreateDate +" / რედაქტირება: " + item.ModifyUser + " " + item.ModifyDate + " ");
                    causer = item.CreateUser;
                    cadate = item.CreateDate ;
                }
            } else {
                alert('ხელშეკრულება არ იძებნება')
            }
        }
    });
}

$(function () {
    //var pg = "agrim.php";

    $('ul.components').find('li').removeClass('active');
    $('ul.components').find("li.newLoanLi").addClass('active');

    if (getCookie("agreementID") != "" && getCookie("agreementID") != 0) {
        // e.i. ganaxlebis rejimshi vart
        currAgreementID = getCookie("agreementID");
        document.cookie = "agreementID=0";

        $("#sel_organization_f31").attr('disabled', true);
        $("#sel_branch_f31").attr('disabled', true);

        getAgreement();

    }


    //alert(document.cookie);
    console.log(document.cookie);

    $("#pan_f32").find('.panel-body').hide();
    $("#pan_f33").find('.panel-body').hide();

//    $("#pan_f31 .panel-body input").css("background-color", "yellow");
//    $("#pan_f31 .panel-body input").attr('readonly',true);
//    $("#pan_f31 .panel-body select").attr('readonly',true);
    $('#btn_edit_f31').attr('disabled', true);
    $('#btn_addiphone_f31').attr('disabled', true);

    var currDate = new Date();

    var strDate = dateformat(currDate);
    $('#agrStart_f31').val(strDate).attr('max', strDate);

    //$(".panel-heading span.glyphicon").trigger('click');


    // <!--    sequrity question chamonatvali -->
    $.ajax({
        url: '../php_code/get_sq.php',
        method: 'get',
        dataType: 'json',
        success: function (response) {
            var sq_num = 0;
            var i = 0;
            response.forEach(function (item) {
                if (sq_num == item.DictionaryID) {
                    $('<option />').text(item.ValueText).attr('value', item.id).appendTo('#sel_q' + i);
                } else {
                    sq_num = item.DictionaryID;
                    i++;
                    $('<option />').text(item.ValueText).attr('value', item.id).appendTo('#sel_q' + i);
                }

            })
        }
    });

}); // ready funqciis dasasruli


$('#sel_status_f32').on('change', function () {
    screenLockChange();
});

function screenLockChange(){
    var v = $('#sel_status_f32').val();
    var c = "";
    if (v != "0") {
        c = $('#sel_status_f32').find('option[value=' + v + ']').attr('datacode');
    }

    $thisRow = $('#tb_scr_lock')
    if (c == 'opened'){
        $thisRow.find('button').attr('disabled', true);
        $thisRow.find('input').attr('readonly',true).val("");

    }
    if (c == 'locked'){
        $thisRow.find('button').attr('disabled', false);
        $thisRow.find('input').attr('readonly',false);
        $('#lock_send_date_f32').attr('readonly',true).val("");
    }
    if (c == 'out'){
        $('#lock_send_date_f32').attr('readonly',false);
        $thisRow.find('button').attr('disabled', false);
        $thisRow.find('input').attr('readonly',false);
    }
}

$('#sel_organization_f31').on('change', function () {
    currOrg = $('#sel_organization_f31').val();
    getsublists(0);
});


$('#btn_addiphone_f31').on('click', function () {
    pan2Active = true;
    $('#pan_f32').find(".panel-body").slideDown();
    $("#pan_f32 span.glyphicon-chevron-down").removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
    //$("#pan_f32 span.glyphicon").trigger('click');
    $('#d_f322').find('input').attr('readonly', true);
    $("#d_f322 select").attr('disabled', true);

    $('#d_f323').find('input').attr('readonly', true).val("");
    $("#d_f323 select").attr('disabled', true);

    $('#d_f324').find('input').attr('readonly', true).val("");
    $("#d_f324 select").attr('disabled', true);
    $("#d_f324 button").attr('disabled', true);

    $("#btn_view_f32").attr('disabled', true);
    $("#btn_get_f32").attr('disabled', true);
    $("#btn_add_f32").attr('disabled', true);
    $("#sel_status_f324").attr('disabled', true);

});

$('#btn_edit_f31').on('click', function () {

    $('#form_31').find('input').attr('readonly', false);
    $('#sel_status_f31').attr('disabled', false);
    $('#sel_branch_f31').attr('disabled', false);
    $('#btn_save_f31').attr('disabled', false);

});

$('#btn_go_f32').on('click', function () {

    var imei = $('#imei_f32').val();
    $(this).closest('tr').find('button').attr('disabled', true);
    $(this).removeAttr('disabled');

    if (imei != "") {

        $.ajax({
            url: '../php_code/get_imei_info.php?imei=' + imei,
            method: 'get',
            dataType: 'json',
            success: function (response) {

                if (response.PhoneR > 1) {
                    alert("იძებნება რამდენიმე ტელეფონი მითითებულ IMEI-ზე!");
                }

                if (response.view == 1) {
                    $('#btn_view_f32').attr('disabled', false);
                }
                if (response.get == 1) {
                    $('#btn_get_f32').attr('disabled', false);
                }
                if (response.add == 1) {
                    $('#btn_add_f32').attr('disabled', false);
                }

                $('#result_f32').val(response.PhoneRv + response.AgreementRv + response.BlackListRv);
            }
        });
    } else {
        $('#imei_f32').attr('placeholder', 'შეიყვანეთ IMEI');
    }

});

function getIphoneData(url) {
    $.ajax({
        url: url,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            console.log(response[0]);
            item = response[0];

            if (response.length > 1) {
                alert('იძებნება რამდენიმე ტელეფონი')
            } else {
                var d1 = item.ScreenLockDate.split(" ");
                var d2 = item.ScreenLockSendDate.split(" ");

                $('#imei_f322').val(item.PhIMEINumber);
                $('#sel_modeli_f322').val(item.IphoneModelID);
                $('#serialN_f322').val(item.PhSerialNumber);
                $('#ios_f322').val(item.IphoneiOSID);

                if (item.PhSIMFREE == 0) {
                    $('#simfree_f322').prop("checked", false);
                } else {
                    $('#simfree_f322').prop("checked", true);
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
                $('#pan_f32 span.panel-info').text("შექმნა: "+ item.CreateUser + " "+ item.CreateDate +" / რედაქტირება: " + item.ModifyUser + " " + item.ModifyDate + " ");
                ciuser = item.CreateUser;
                cidate = item.CreateDate ;
            }

            $('#form_32 input').attr('readonly', true);
            $('#form_32 select').attr('disabled', true);
            $('#simfree_f322').attr('disabled', true);
            $('#d_f323 button.passgen4').attr('disabled',true);
            $('#d_f323 button.passgen6').attr('disabled',true);

            if (reasonEdit){
                $('#btn_edit_f32').attr('disabled', false);
                $('#btn_save_f32').attr('disabled', true);
            }

        }
    });
}

$('#btn_view_f32').on('click', function () {
    // mogvaqvs da vachvenebt telefonis monacemebs
    var imei = $('#imei_f32').val();
    var url_im = '../php_code/get_iphone_data.php?imei=' + imei;

    getIphoneData(url_im);
});

$('#btn_get_f32').on('click', function () {

    var imei = $('#imei_f32').val();
    $.ajax({
        url: '../php_code/get_iphone_data.php?imei=' + imei,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            console.log(response[0]);
            item = response[0];

            if (response.length > 1) {
                alert('იძებნება რამდენიმე ტელეფონი')
            } else {
                var d1 = item.ScreenLockDate.split(" ");
                var d2 = item.ScreenLockSendDate.split(" ");

                $('#imei_f322').val(item.PhIMEINumber);
                $('#sel_modeli_f322').val(item.IphoneModelID);
                $('#serialN_f322').val(item.PhSerialNumber);
                $('#ios_f322').val(item.IphoneiOSID);
                if (item.PhSIMFREE == 0) {
                    $('#simfree_f322').prop("checked", false);
                } else {
                    $('#simfree_f322').prop("checked", true);
                }

                $('#sel_status_f324').val(item.StateID);
                $('#comment_f324').val(item.Comment);

                tempIphoneID = item.ID;
                $('#iphone_history').attr('href','../php_code/get_iphone_history.php?phoneID=' + tempIphoneID);
                //console.log(response.IphoneModelID);
            }

        }
    });

    $('#btn_save_f32').removeAttr('disabled');
    $('#d_f322').find('input').attr('readonly', false);
    $("#d_f322 select").attr('disabled', false);
    $('#d_f323').find('input').attr('readonly', false);
    $("#d_f323 select").attr('disabled', false);
    $('#d_f324').find('input').attr('readonly', false);
    $("#d_f324 select").attr('disabled', false);

});

$('#btn_add_f32').on('click', function () {

    $('#btn_save_f32').removeAttr('disabled');
    $('#d_f322').find('input').attr('readonly', false).val("");
    $("#d_f322 select").attr('disabled', false).val("0");
    $('#d_f323').find('input').attr('readonly', false).val("");
    $("#d_f323 select").attr('disabled', false).val("");
    $('#d_f324').find('input').attr('readonly', false).val("");
    $("#d_f324 select").attr('disabled', false).val("");

    $('#imei_f322').val($('#imei_f32').val());
    $('#sel_status_f324 option').removeAttr('selected');
    var sel = "new";
    var st_val = $("#sel_status_f324 option[datacode=" + sel + "]").val();
    $("#sel_status_f324").val(st_val);
    // $("#sel_status_f324 option[datacode=" + sel + "]").attr('selected', 'select');
    //$('#d_f324').find('button').attr('disabled',false);
    //$("#sel_status_f324").attr('disabled', 'true');

    sel = "opened";

    $("#sel_status_f32 option[datacode=" + sel + "]").attr('selected', 'select');
    $("#sel_status_f32").trigger('change');

    tempIphoneID = 0;
    $('#iphone_history').attr('href','../php_code/get_iphone_history.php');
});


$('#form_32').on('submit', function (event) {
    event.preventDefault();
    $('#agrID_f32').val(currAgreementID);
    $('#iphoneID_f32').val(tempIphoneID);
    var im = $('#imei_f322').val();
    var ep = $('#pass_enc_f32').val();
    var chek = true;

    //console.log($(this).serialize());
    if (im.length != 15){
        alert("შეავსეთ IMEI გრაფა!");
        chek = false;
    }else {
        if (!(ep.length == 6 || ep.length == 4 || ep.length == 0)) {
            alert("Encryption Password უნდა იყოს 4 ან 6 ციფრი!");
            chek = false;
        }
    }

    if (chek) {
        $('#form_32 select').attr('disabled', false);
        $.ajax({
            url: '../php_code/ins_iphone.php',
            method: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.error == '') {

                    currIphoneID = response.id;
                    tempIphoneID = response.id;
                    $('#iphone_history').attr('href','../php_code/get_iphone_history.php?phoneID=' + currIphoneID);

                    if (ciuser == ''){
                        ciuser = response.info_cuser;
                        cidate = response.info_cdate;
                    }
                    $('#pan_f32 span.panel-info').text("შექმნა: "+ ciuser + " "+ cidate +" / რედაქტირება: " + response.info_muser + " " + response.info_mdate + " ");
                    alert("წარმატებით განხორციელდა ტელეფონის მონაცემების შენახვა");

                    $('#form_32 input').attr('readonly', true);
                    $('#form_32 select').attr('disabled', true);
                    $('#simfree_f322').attr('disabled', true);
                    $('#d_f323 button.passgen4').attr('disabled',true);
                    $('#d_f323 button.passgen6').attr('disabled',true);

                    $('#d_f324').find('button').attr('disabled', false);
                    $('#btn_save_f32').attr('disabled', true);
                } else {

                    alert(response.error);
                }
                console.log(response);
            }
        });
    }
});

$('#btn_edit_f32').on('click', function () {
    f32edit();
});

function f32edit(){
    $('#form_32 input').attr('readonly', false);
    $('#form_32 select').attr('disabled', false);
    $('#simfree_f322').attr('disabled', false);
    $('#d_f323 button.passgen4').attr('disabled',false);
    $('#d_f323 button.passgen6').attr('disabled',false);

    $('#d_f324').find('button').attr('disabled', false);
    $('#btn_edit_f32').attr('disabled', true);
    console.log('f3');
    screenLockChange();
}

$('#btn_addapplid_f32').on('click', function () {
    pan3Active = true;
    $('#pan_f33').find(".panel-body").slideDown();
    $("#pan_f33 span.glyphicon-chevron-down").removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');

    $('#form_33 input').attr('readonly', true);
    $('#form_33 select').attr('disabled', true);
    $('#form_33 button.passgen').attr('disabled', true);

    $("#btn_f3edit").attr('disabled', true);
    $("#btn_f3submit").attr('disabled', true);

});


$(".panel-heading").on('click', function (el) {
    var showPermission = true;
    var gilaki = $(this).find("span.glyphicon");
    if ($(this).closest('.panel').attr('id') == 'pan_f32') {
        showPermission = pan2Active;
    }
    if ($(this).closest('.panel').attr('id') == 'pan_f33') {
        showPermission = pan3Active;
    }
    if (showPermission) {
        if (gilaki.hasClass('glyphicon-chevron-up')) {
            gilaki.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            $(this).closest('.panel').find(".panel-body").slideUp();
        } else {
            gilaki.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            $(this).closest('.panel').find(".panel-body").slideDown();
        }
    }
});

//     ***********************************************  Appl ID dzebna  *************
$('#btn_go_f33').on('click', function () {

    var applid = $('#applid_f33').val();
    $('#btn_get_f33').attr('disabled', true);

    if (applid != "") {

        $.ajax({
            url: '../php_code/get_applid_info.php?applid=' + applid,
            method: 'get',
            dataType: 'json',
            success: function (response) {

                console.log(response);

                if (response.get == 1) {
                    $('#btn_get_f33').attr('disabled', false);
                }

                if (response.orgID != currOrg && response.orgID != 0){
                    alert("Appl ID სხვა ორგანიზაციაზეა რეგისტრირებული!");
                    $('#btn_get_f33').attr('disabled', true);
                }

                if (response.AppleIDR > 1) {
                    alert("იძებნება რამდენიმე Appl ID !!!");
                    $('#btn_get_f33').attr('disabled', true);
                }

                candidateApplidID = response.id;
                var showText = response.AppleIDRv + response.AgreementRv + response.ProblemRv;
                if (response.reservation != ""){
                    showText += response.reservation;
                }
                $('#result_f33').val(showText);
                $('#result_f33').attr('title', showText);
            }
        });
    } else {
        $('#applid_f33').attr('placeholder', 'შეიყვანეთ ApplID');
    }
});

$('#btn_get_f33').on('click', function () {
    var applid = $('#applid_f33').val();
    tempApplID = candidateApplidID;
    console.log(candidateApplidID);
    $.ajax({
        url: '../php_code/get_apple_id_data.php?id=' + tempApplID,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            item = response[0];
            console.log(item);

            if (response.length > 1) {
                alert('იძებნება რამდენიმე ApplID')
            } else {
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

                $('#email_ID_f33').val(item.AplAccountEmailID);

                $("#btn_f3submit").attr('disabled', false);
                $("#btn_f3edit").attr('disabled', false);

                //console.log(response.IphoneModelID);
                $('#pan_f33 span.panel-info').text("შექმნა: "+ item.CreateUser + " "+ item.CreateDate +" / რედაქტირება: " + item.ModifyUser + " " + item.ModifyDate + " ");
                capuser = item.CreateUser;
                capdate = item.CreateDate ;
                
                $('#apl_history').attr('href','../php_code/get_applid_history.php?aplID=' + tempApplID);
                $('#btn_get_f33').attr('disabled', true);
            }

        }
    });
});

$('#btn_addApplid_f33').on('click', function () {

    console.log(currOrg);
    $.ajax({
        url: '../php_code/get_apple_id_data.php?id=0&orgid=' + currOrg,
        method: 'get',
        dataType: 'json',
        success: function (response) {

            item = response[0];
            //console.log(item);
            //console.log(response.length);

            if (response.length != 1) {
                alert('მოიძებნა ' + response.length + ' ApplID')
            } else {
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

                $('#email_ID_f33').val(item.AplAccountEmailID);

                tempApplID = item.ID;
                $("#btn_f3submit").attr('disabled', false);
                $("#btn_f3edit").attr('disabled', false);

                $('#pan_f33 span.panel-info').text("შექმნა: "+ item.CreateUser + " "+ item.CreateDate +" / რედაქტირება: " + item.ModifyUser + " " + item.ModifyDate + " ");
                capuser = item.CreateUser;
                capdate = item.CreateDate ;
                console.log(tempApplID);
                $('#apl_history').attr('href','../php_code/get_applid_history.php?aplID=' + tempApplID);
            }

        }
    });

});

$('#btn_f3edit').on('click', function () {
    $('#form_33 input').attr('readonly', false);
    $('#form_33 select').attr('disabled', false);
    $('#form_33 button.passgen').attr('disabled', false);

    $('#email_f33').attr('readonly', true);
    $('#emailpass_f33').attr('readonly', true);
    $("#sel_organization_f33").attr('disabled', true);
    $("#btn_f3edit").attr('disabled', true);
    $("#btn_f3submit").attr('disabled', false);

    $('#appl_id_pass_f33').attr('readonly', true);
    $('#appl_id_f33').attr('readonly', true);
});

$('#btn_f3submit').on('click', function () {

    $('#form_33').trigger('submit');
});

$('#form_33').on('submit', function (event) {
    event.preventDefault();
    $('#agrID_f33').val(currAgreementID);
    $('#applid_ID_f33').val(tempApplID);
    $('#form_33 select').attr('disabled', false);

    console.log($(this).serialize());

    $.ajax({
        url: '../php_code/upd_applid_agr.php',
        method: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.error == '') {
                $("#btn_f3edit").attr('disabled', false);
                $("#btn_f3submit").attr('disabled', true);
                $('#form_33 input').attr('readonly', true);
                $('#form_33 select').attr('disabled', true);
                $('#form_33 button.passgen').attr('disabled', true);
                currApplID = tempApplID;
                $('#pan_f33 span.panel-info').text("შექმნა: "+ capuser + " "+ capdate +" / რედაქტირება: " + response.info_muser + " " + response.info_mdate);
                alert("წარმატებით განხორციელდა AppleID-ის მონაცემების შენახვა");
                $('#appl_id_pass_f33').css('backgroundColor','#ececec');
            } else {
                alert(response.error);
            }
            console.log(response);
        }
    });
});


function getsublists(br_id) {
    // organizaciis archevs mere shesabamisad vanaxlebt masze mibmul siebs
    $('#sel_branch_f31').empty();

    var sel_org_id = $('#sel_organization_f31').val();

    // <!--        filialebis chamonatvali -->
    organizationObj.forEach(function (org){
        if (org.id == sel_org_id){
            var branches = org.branches;
            if (branches.length != 1) {
                $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#sel_branch_f31');
            }
            branches.forEach(function (item) {
                $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#sel_branch_f31');
            });
            if (br_id != 0) {
                $('#sel_branch_f31').val(br_id);
            }

            // <!--    usafrtxoebis damatebiti maili -->
            var rmails = org.rmails;
            $('#sel_rmail').empty();
            rmails.forEach(function (item) {                
                $('<option />').text(item.EmEmail).attr('value', item.id).appendTo('#sel_rmail');
            });
        }
    });

} // end get sublists


var currmailid = '0';

$('#form_31').on('submit', function (event) {
    event.preventDefault();
    $('#sel_organization_f31').attr('disabled', false);
    $('#agrID_f31').val(currAgreementID);
    $('#iphoneID_f31').val(currIphoneID);
    $('#applid_ID_f31').val(currApplID);
    console.log($(this).serialize());

    $.ajax({
        url: '../php_code/ins_agreement.php',
        method: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            $('#sel_organization_f31').attr('disabled', true);
            if (response.error == "") {

                    currAgreementID = response.id;
                    $('#agr_history').attr('href','../php_code/get_agr_history.php?agrID=' + currAgreementID);

                    $('#btn_edit_f31').attr('disabled', false);
                    $('#btn_addiphone_f31').attr('disabled', false);
                    $('#btn_save_f31').attr('disabled', true).text("განახლება");
                    $("#pan_f31 .panel-body input").attr('readonly', true);
                    $("#pan_f31 .panel-body select").attr('disabled', true);

                    if (causer == ''){
                        causer = response.info_cuser;
                        cadate = response.info_cdate;
                    }
                    $('#pan_f31 span.panel-info').text("შექმნა: "+ causer + " "+ cadate +" / რედაქტირება: " + response.info_muser + " " + response.info_mdate + " ");

                    alert("წარმატებით განხორციელდა ხელშკრულების შენახვა");
//                    $('#block2').show();
//
//                    $('#appl_id').val($('#email').val() + '@' + $('#sel_domain option:selected').text());
//                    currmailid = response;
//                    $('#btn_addid').hide();
//                    $('#sel_organization').attr('disabled',true);
//                    var d = new Date();
//                    $('#appl_id_info').text('ID: '+ response + ' CreateDate: '  + d.getFullYear()  + "-" + (d.getMonth()+1) + "-" + d.getDate() + " " +
//                        d.getHours() + ":" + d.getMinutes());

            } else {
                alert(response.error);
            }
            console.log(response);
        }
    });
});


$('#btn_addid').on('click', function () {

    //$('#btn_addid').text('mdaa');
    //  $('#form1').trigger('submit');
});

$('#btn_f2submit').on('click', function () {
    $('#form2').trigger('submit');
});

$('#btn_f2reset').on('click', function () {
    localRefresh();
    $('#form2').trigger('reset');

});

function localRefresh() {
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


$('.eye').on('click', function () {

    var atag = $(this).closest('.input-group').find('input');
    var aicon = $(this).find('span');

    if (atag.attr('type') == "text") {
        atag.attr('type', 'password');
        aicon.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
    } else {
        atag.attr('type', 'text');
        aicon.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
    }
});

var clicked_eye;
var atag;
var aicon;
var browseMode = true;

$('.eye0').on('click', function () {
    atag = $(this).closest('.input-group').find('input');
    aicon = $(this).find('span');
    clicked_eye = $(this).data('whatever');
    
    if (atag.attr('type') == "text"){
        atag.attr('type','password');
        aicon.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
    } else {
        if (browseMode == false){
            atag.attr('type','text');
            aicon.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
        } else{
            $('#dialog1').modal('show');
        }
    }
});

$('#send_reason_from input').on('click',function(event){
    if ($(this).val() == ""){
        $('#message-text').attr('readonly', false);
        var textdata = $('#message-text').val();        
        if (textdata.length <= 10){
            $('#btndone').attr('disabled',true);
        }        
    }else{
        $('#message-text').attr('readonly', true);
        $('#btndone').attr('disabled',false);
    }
});

$('#btndone').on('click',function(event){
    // clicked_eye.attr('data-target','');
    atag.attr('type','text');
    aicon.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');

    // aq vagzavnit logebs serverze
    var dataObj = {
        'applID': tempApplID,
        'text': $('#message-text').val(),
        'whichpass': clicked_eye
    };
    // tempApplID -shi aris mimdinare da chawerili ID

    var inputs = $('#send_reason_from').serializeArray();
    
    inputs.forEach( function(item) {
        dataObj[item.name] = item.value;
    });

    if (dataObj.answer != ""){
        dataObj.text = dataObj.answer;
    }

    $.ajax({
        url: '../php_code/ins_applpasslog.php',
        method: 'post',
        data: dataObj,
        success: function (response) {
            console.log(response);
        }
    });

    $('#dialog1').modal('hide');
    $('#message-text').val('');
    $('#btndone').attr('disabled',true);
})

$('#message-text').on('keyup',function(){
    var textdata = $('#message-text').val();
    if ($('#message-text').attr('readonly') != "readonly"){
        if (textdata.length > 10){
            $('#btndone').attr('disabled',false);
        }else{
            $('#btndone').attr('disabled',true);
        }
    }    
})

$('#dialog1').on('shown.bs.modal', function () {
    $('#message-text').trigger('focus')
})

$('.passgen').on('click', function (event) {

    if (confirm("გსურთ პაროლის შეცვლა?")) {

        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    
        for (var i = 0; i < 12; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
    
        $(this).closest('.input-group').find('input').val(text);
    }
});

$('.passgen4').on('click', function (event) {
    if (confirm("გსურთ პაროლის შეცვლა?")) {

        var text = "";
        var possible = "0123456789";

        for (var i = 0; i < 4; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        $(this).closest('.input-group').find('input').val(text);
    }
});

$('.passgen6').on('click', function (event) {
    if (confirm("გსურთ პაროლის შეცვლა?")) {

        var text = "";
        var possible = "0123456789";

        for (var i = 0; i < 6; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        $(this).closest('.input-group').find('input').val(text);
    }
});

$('.passgen_apl').on('click', function (event) {
    if (confirm("გსურთ პაროლის შეცვლა?")) {

        var text = "";
        var possible = "0123456789";
        var symbolBIG = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var symbolSmail = "abcdefghijklmnopqrstuvwxyz";
        var symbolSpec = "!@#$%";

        text += symbolBIG.charAt(Math.floor(Math.random() * symbolBIG.length));
        text += ".";
        text += symbolSmail.charAt(Math.floor(Math.random() * symbolSmail.length));
        text += "-";

        for (var i = 0; i < 4; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        text += symbolSpec.charAt(Math.floor(Math.random() * symbolSpec.length));

        $(this).closest('.input-group').find('input').val(text).attr('readonly',true);
        $(this).attr('disabled',true);
        $('#appl_id_pass_f33').attr('readonly',false).css('backgroundColor','#ff9e97');
        $('#appl_id_pass_f33').attr('readonly',true);
    }
});

// $('#btn_f33ApplPassGen').on('click', function (event) {
//     $(this).attr('disabled',true);
//     $(this).closest('.input-group').find('input').attr('readonly',true);
// });

//
//$('#email').on('keyup', function() {
//    $('#appl_id').val($(this).val()+"@"+$('#sel_domain').text());
//});
//
//$('#sel_domain').on('change',function(){
//    $('#appl_id').val($('#email').val()+"@"+$('#sel_domain').text());
//});

$('#appl_id_info').text('');
$('#sel_status_f31').on('focus',function () {
    if (currApplID == 0 || currIphoneID == 0){
        $(this).find('option[code=Active]').attr('disabled', true);
    }else {
        $(this).find('option[code=Active]').attr('disabled', false);
    }
});

$('#form_31').on('blur',function () {
    alert("sad midixar");
});

function dateformat(d) {
    var mm, dd;
    if (d.getMonth() < 9) {
        mm = "0" + (d.getMonth() + 1);
    } else {
        mm = d.getMonth() + 1;
    }
    if (d.getDate() < 10) {
        dd = "0" + d.getDate();
    } else {
        dd = d.getDate();
    }
    return d.getFullYear() + "-" + mm + "-" + dd;
}

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

function f_show(){}
function f_hide(){}