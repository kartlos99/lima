var currApplID = 0;
var orgDane = false;
var filDane = false;
var domDane = false;
var rmailDane = false;
var stDane = false;
var questionDane = false;
var currmailid = '0';
var browseMode = false;
///var orgDane = false;
var orgObj = {};

$('#block2').hide();
$('button').addClass('btn-sm');

// <!--    organizaciebis chamonatvali -->
$.ajax({
    url: '../php_code/get_organizations.php',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        //console.log(response);
        Object.assign(orgObj, response);
        response.forEach(function (item) {
            $('<option />').text(item.OrganizationName).attr('value', item.id).appendTo('#sel_organization');
        });
        orgDane = true;
    }
});

// <!--    sequrity question chamonatvali -->
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
        });
        questionDane = true;
    }
});

$('#sel_organization').on('change', function () {
    document.getElementById("email").removeAttribute('readonly');
    getsublists();
});

function getsublists(reason, rid) {
    // organizaciis archevs mere shesabamisad vanaxlebt masze mibmul siebs
    $('#sel_branch').empty();
    $('#sel_domain').empty();
    $('#sel_rmail').empty();

    var sel_org_id = $('#sel_organization').val();

    // <!--   filialebis / domanebis / rmailebis chamonatvali -->
    
    for (i = 0; i < Object.keys(orgObj).length; i++) {
        if (orgObj[i]['id'] == sel_org_id){

            orgObj[i]['branches'].forEach(function (br) {
                $('<option />').text(br.BranchName).val(br.id).appendTo('#sel_branch');
            });
            filDane = true;
            
            orgObj[i]['domains'].forEach(function (dom) {
                $('<option />').text(dom.DomainName).val(dom.id).appendTo('#sel_domain');
            });
            domDane = true; 
            
            orgObj[i]['rmails'].forEach(function (rm) {
                $('<option />').text(rm.EmEmail).val(rm.id).appendTo('#sel_rmail');
            });
            if (reason == 'fill') {
                // $("#sel_rmail option[value=" + rid + "]").attr('selected', 'select');
                $("#sel_rmail").val(rid);
            };
            rmailDane = true;
        }
    };

}

// <!--    statusebi am ApplID cxrilistvis -->
$('#sel_status').empty();
$.ajax({
    url: '../php_code/get_statuses.php?objname=ApplID',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.va).attr('value', item.id).appendTo('#sel_status');
        });
        $('#sel_status option:first-child').attr('selected', 'selected');
        stDane =true;
    }
});

$('#form1').on('submit', function (event) {
    event.preventDefault();

    console.log($(this).serialize());

    $.ajax({
        url: '../php_code/ins_email.php',
        method: 'post',
        data: $(this).serialize(),
        success: function (response) {
            if (response != 'myerror') {
                if (response == 'mail alredy exists!'){
                    alert(response);
                }else{

                    $('#block2').show();

                    $('#appl_id').val($('#email').val() + '@' + $('#sel_domain option:selected').text());
                    currmailid = response;
                    $('#btn_addid').hide();
                    $('#sel_organization').attr('disabled',true);
                    var d = new Date();
                    $('#appl_id_info').text('ID: '+ response + ' CreateDate: '  + d.getFullYear()  + "-" + (d.getMonth()+1) + "-" + d.getDate() + " " +
                        d.getHours() + ":" + d.getMinutes());
                }
            } else {
                alert(response);
            }
            console.log(response);
        }
    });
});

$('#form2').on('submit', function (event) {

    $('#emName').val($('#email').val());
    $('#emDom').val($('#sel_domain').val());
    $('#emPass').val($('#password').val());

    event.preventDefault();

    console.log($(this).serialize());

    console.log('form2_submit');

    $.ajax({
        url: '../php_code/upd_applid.php?id=' + currmailid,
        method: 'post',
        data: $(this).serialize(),
        success: function (response) {

            loadProjects();
//                if ($('#sel_status').text() == 'აქტიური') {
//                    $('#block2').hide();
//                }
            console.log(response);

            localRefresh();
            //location.reload();
        }
    });
});

$('#btn_addid').on('click', function(){

    //$('#btn_addid').text('mdaa');
  //  $('#form1').trigger('submit');
});

$('#btn_f2submit').on('click', function(){
    hideAllPass();
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

function hideAllPass(){    
    $('.eye0 .glyphicon-eye-close').closest('.eye0').trigger('click');
}

loadProjects();

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
        hideAllPass();
        browseMode = true;
        currApplID = num;
        var thetr = "tr[onclick=\"onRowClick("+num+")\"]";
        $('#table_block3 tr').css({
            'background-color': 'white'
        });
        $('#table_block3').find(thetr).css({
            'background-color': '#b5dcff'
        });
        // $('#sel_organization').attr('disabled',true);
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
                $("#sel_q1").val(row.AplSequrityQuestion1ID);
                $("#sel_q2").val(row.AplSequrityQuestion2ID);
                $("#sel_q3").val(row.AplSequrityQuestion3ID);

                // $('#sel_q1 option').removeAttr('selected');
                // $("#sel_q1 option[value=" + row.AplSequrityQuestion1ID + "]").attr('selected', 'selected');
                // $('#sel_q2 option').removeAttr('selected');
                // $("#sel_q2 option[value=" + row.AplSequrityQuestion2ID + "]").attr('selected', 'selected');
                // $('#sel_q3 option').removeAttr('selected');
                // $("#sel_q3 option[value=" + row.AplSequrityQuestion3ID + "]").attr('selected', 'selected');                

                $('#sel_status').val(row.StateID);
                // $('#sel_status option').removeAttr('selected');
                // $("#sel_status option[value=" + row.StateID + "]").attr('selected', 'selected');
                $("#comment").val(row.Comment);

                var em = row.AplApplID.split("@");
                $('#email').val(em[0]);
                $('#password').val(row.EmEmailPass);

                $('#appl_id_info').text('ID: '+ row.ID + ' CreateDate: ' + row.CreateDate);

                $.ajax({
                    url: '../php_code/get_applid_info.php?applid=' + row.AplApplID,
                    method: 'get',
                    dataType: 'json',
                    success: function (r) {

                        if (r.get == 0 && r.AgrNumber != "") {
                            alert("Appl ID დაკავებულია, რედაქტირებისთვის იხილეთ ხელშეკრულება N: " + r.AgrNumber);
                            $('#block2 *').attr('disabled',true);
                        }
                        
                        if ($('#currusertype').data('ut') == "iCloudGrH"){
                            $("#sel_status").attr('disabled',false);
                            $("#sel_status *").attr('disabled',false);
                            $("#comment").attr('disabled',false);
                            $("#btn_f2submit").attr('disabled',false);
                        }
                    }
                });

            }
        });
    }


}

$('.eye').on('click', function () {
    atag = $(this).closest('.input-group').find('input');
    aicon = $(this).find('span');
    
    if (atag.attr('type') == "text"){
        atag.attr('type','password');
        aicon.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
    } else {
        atag.attr('type','text');
        aicon.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
    }
});

var clicked_eye;
var atag;
var aicon;

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
        'applID': currApplID,
        'text': $('#message-text').val(),
        'whichpass': clicked_eye
    };

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
    
    if (textdata.length > 10){
        $('#btndone').attr('disabled',false);
    }else{
        $('#btndone').attr('disabled',true);
    }
})

$('#dialog1').on('shown.bs.modal', function () {
    $('#message-text').trigger('focus')
})

$('.passgen').on('click', function () {

    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 12; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    $(this).closest('.input-group').find('input').val(text);
});

$('.passgen_apl').on('click', function (event) {
    var doit = false;
    if ($(this).closest('.input-group').find('input').val() != ""){
        if (confirm("გსურთ პაროლის შეცვლა?")) {
            doit = true;
        }
    } else{
        doit = true;
    }
    if (doit) {

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
        // $('#appl_id_pass').attr('readonly',false).css('backgroundColor','#ff9e97');
        // $('#appl_id_pass').attr('readonly',true);
    }
});

$(function() {

    $('ul.components').find('li').removeClass('active');
    $('ul.components').find('li.newiCloudLi').addClass('active');
    
    if (getCookie("ApplIDID") != "" && getCookie("ApplIDID") != 0) {
        // e.i. ganaxlebis rejimshi vart
        currApplID = getCookie("ApplIDID");
        document.cookie = "ApplIDID=0";
        

        $("#sel_organization").attr('disabled', true);
        $("#sel_branch").attr('disabled', true);

        onRowClick(currApplID);

    }

//    $("#form1").find("input").val('');

});

$('#email').on('keyup', function() {
    $('#appl_id').val($(this).val()+"@"+$('#sel_domain option:selected').text());
});

$('#sel_domain').on('change',function(){
    $('#appl_id').val($('#email').val()+"@"+$('#sel_domain option:selected').text());
});

$('#appl_id_info').text('');

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