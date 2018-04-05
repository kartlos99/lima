
$('#block2').hide();

<!--    organizaciebis chamonatvali -->
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

    <!--        filialebis chamonatvali -->
    $.ajax({
        url: '../php_code/get_branches.php?id=' + sel_org_id,
        method: 'get',
        dataType: 'json',
        success: function (response) {
            response.forEach(function (item) {
                $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#sel_branch');
            })
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


}

<!--    statusebi am ApplID cxrilistvis -->
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
    }
});

var currmailid = '0';

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
    var v = $(event.target).validationMessage;
    console.log(v);

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
    location.reload();
}

setTimeout(function () {
    // $('#p2').text($('#p1').text());

}, 500);


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
                $("#sel_status option[value=" + row.StateID + "]").attr('selected', 'selected');
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

$(function() {

//    $("#form1").find("input").val('');

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

});

$('#email').on('keyup', function() {
    $('#appl_id').val($(this).val()+"@"+$('#sel_domain').text());
});

$('#sel_domain').on('change',function(){
    $('#appl_id').val($('#email').val()+"@"+$('#sel_domain').text());
});

$('#appl_id_info').text('');