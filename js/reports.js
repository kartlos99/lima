var pgN = 0;
var rowsInPage = 10;

//<!--    organizaciebis chamonatvali -->
$.ajax({
    url: '../php_code/get_organizations.php',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.OrganizationName).attr('value', item.id).appendTo('#sel_organization_vr3');
        })
    }
});

//<!--    momxmareblebis chamonatvali -->
$.ajax({
    url: '../php_code/get_usernames.php',
    method: 'get',
    dataType: 'json',
    success: function (response) {
        response.forEach(function (item) {
            $('<option />').text(item.UserName).attr('value', item.ID).appendTo('#sel_username_vr3');
        })
    }
});

$('#form_viewrep2').on('submit', function(event){
    event.preventDefault();    
    get_rep2_list( $(this).serialize() );    
});

var rep2_down_link = $('#viewrep2 a');
$('#form_viewrep2 input').on('change', function(){
    rep2_down_link.attr('href', 'rep2_exp.php?datefrom=' + $('#datefrom_vr2').val() + '&dateto=' + $('#dateto_vr2').val() );
});

var rep3_down_link = $('#rep3_down_link');
$('#form_viewrep3 input').on('change', function(){
    link_query = 'datefrom=' + $('#datefrom_vr3').val() 
        + '&dateto=' + $('#dateto_vr3').val()
        + '&organization=' + $('#sel_organization_vr3').val()
        + '&username=' + $('#sel_username_vr3').val();
    rep3_down_link.attr('href', 'rep3_exp.php?' + link_query );
});

$('#sel_organization_vr3').on('change', function(){
    link_query = 'datefrom=' + $('#datefrom_vr3').val() 
        + '&dateto=' + $('#dateto_vr3').val()
        + '&organization=' + $('#sel_organization_vr3').val()
        + '&username=' + $('#sel_username_vr3').val();
    rep3_down_link.attr('href', 'rep3_exp.php?' + link_query );
});
$('#sel_username_vr3').on('change', function(){
    link_query = 'datefrom=' + $('#datefrom_vr3').val() 
        + '&dateto=' + $('#dateto_vr3').val()
        + '&organization=' + $('#sel_organization_vr3').val()
        + '&username=' + $('#sel_username_vr3').val();
    rep3_down_link.attr('href', 'rep3_exp.php?' + link_query );
});

var rep4_down_link = $('#rep4_down_link');
$('#form_viewrep4 input').on('change', function(){
    rep4_down_link.attr('href', 'rep4_exp.php?datefrom=' + $('#datefrom_vr4').val() + '&dateto=' + $('#dateto_vr4').val() );
});

$('#form_viewrep3').on('submit', function(event){
    event.preventDefault();
    $('#f11_pageN').val( 0 );
    get_rep3_list( $(this).serialize() );    
});

$('#form_viewrep4').on('submit', function(event){
    event.preventDefault();    
    get_rep4_list( $(this).serialize() );    
});

function get_rep4_list(kriteri){
    $.ajax({
        url: '../php_code/view24.php',
        method: 'post',
        data: kriteri,
        dataType: 'json',
        success: function (response) {
            $('#rep4_table').empty();
            var table_view4_body = $('#rep4_table').append('<tbody />');
            
            console.log(response);

            if (response.length == 0){
                alert("არ მოიძებნა ჩანაწერი");
            }
            // response.splice(0,1);

            for(var i in response){
                var key = i;
                var val = response[i];
                var newRow = $('<tr></tr>');
                // var td_UserHead = $('<td />').text(key);
                // table_view4_body.append(td_UserHead);
                for(var j in val){
                    var sub_key = j;
                    var sub_val = val[j];
                    var newRow = $('<tr />');
                    if (key == sub_key){
                        newRow.css({
                            'font-weight' : 'bold',
                            'background-color':'#ccdddd'
                        });
                    }else{
                        newRow.css('margin-left','50px');
                    }
                           
                    if (sub_key == ""){
                        sub_key = "-"
                    }
                    var td_op = $('<td />').text(sub_key);
                    var td_val = $('<td />').text(sub_val).css("text-align" , 'right');
                    newRow.append(td_op, td_val);
                    
                    table_view4_body.append(newRow);
                }
                
            }
        }
    });    
}

function get_rep3_list(kriteri){
    $.ajax({
        url: '../php_code/view23.php',
        method: 'post',
        data: kriteri,
        dataType: 'json',
        success: function (response) {
            var itemCount = response[0].n;
            capt.text(capt_text + "   -   მოიძებნა " + itemCount + " ჩანაწერი");
            $('#rep3_table').empty().append(capt);
            var table_view3_body = $('#rep3_table').append('<tbody />');
            table_view3_body.append(array_to_th(v3_columns));
            console.log(response);

            if (itemCount == 0){
                alert("არ მოიძებნა ჩანაწერი");
            }
                        
            var pageCount = Math.floor(itemCount / rowsInPage) + 1 ;
            pgN = parseInt($('#f11_pageN').val()) + 1;

            makePaginationButtons(pageCount);            

            response.splice(0,1);

            response.forEach(function (item) {
                var td_org = $('<td />').text(item.org); //OrganizationName);
                var td_branch = $('<td />').text(item.br);
                var td_user = $('<td />').text(item.uname);
                var td_applid = $('<td />').text(item.aid);
                var td_whichpass = $('<td />').text(item.wp).addClass("equalsimbols"); //whichpass);
                var td_date = $('<td />').text(item.dt).addClass("equalsimbols"); //tarigi);
                var td_reason = $('<td />').text(item.text);  
                var td_agreement = $('<td />');
                if (item.agrID != "-"){
                    td_agreement.text(item.agrNumber + " / " + item.agrOrg)
                    .attr('onClick', "gotoagr(" + item.agrID + ")")
                    .addClass("myLink");
                }else{
                    td_agreement.text("-");
                }

                var trow = $('<tr></tr>').append(td_org, td_branch, td_user, td_applid, td_whichpass, td_reason, td_agreement, td_date);
                // trow.attr('onclick', "ont11Click(" + item.ID + ")");
                table_view3_body.append(trow);
            });
        }
    });    
}

$('#viewrep3').trigger('click');

function gotoagr(agrID){
    document.cookie = "agreementID=" + agrID;
    var url = window.location.pathname;
    url = url.replace('reports.php','agrim.php');
    window.open(url);
}

get_rep1_list();

function get_rep1_list(kriteri){
    $.ajax({
        url: '../php_code/view21.php',
        method: 'post',
        data: kriteri,
        dataType: 'json',
        success: function (response) {

            var organizacions = Object.keys(response);
            var states = [];
            var mydata = [];
            var head1 = Object.keys(response);
            head1.unshift("რაოდენობა/ფილიალი");
            var table_view1_body = $('#rep1_table').empty().append('<tbody />');
            table_view1_body.append(array_to_th(head1));

            for(var i in response){
                var key = i;
                var val = response[i];
                for(var j in val){
                    var sub_key = j;
                    var sub_val = val[j];
                    if (!states.includes(sub_key)){
                        states.push(sub_key);
                    }                    
                }
                if (response[i]['Active_A'] == undefined){
                    response[i]['Active_A'] = 0;
                }
                if (response[i]['Active'] == undefined){
                    response[i]['Active'] = 0;
                }
                response[i]['Active_Free'] = response[i]['Active'] - response[i]['Active_A'];
            }

            for (var i = 0; i < states.length; i++){
                mydata[i] = new Array();
                if (states[i] == "Active"){
                    states[i] = "Active_Free";
                }
                var newRow = $('<tr></tr>');
                var rowhead = $('<th />').text(states[i]);
                newRow.append(rowhead);
                for (var j = 0; j < organizacions.length; j++){

                    if (response[organizacions[j]][states[i]] == undefined){
                        mydata[i][j] = " - ";    
                    }else {
                        mydata[i][j] = response[organizacions[j]][states[i]];
                    }                   

                    var new_td = $('<td />').text(mydata[i][j]).addClass('equalsimbols').css("text-align" , 'right');
                    newRow.append(new_td); 
                }
                table_view1_body.append(newRow);
            }
        }
    });    
}

function get_rep2_list(kriteri){
    $.ajax({
        url: '../php_code/view22.php',
        method: 'post',
        data: kriteri,
        dataType: 'json',
        success: function (response) {

            var users = Object.keys(response);
            if (users.includes('error')){
                alert(response.error);
            } else {
                var branchs = [];
                var states = [ "Active", "Closed" ];
                var states_toshow = [ "გახსნა", "დახურვა" ];
                var table_view2_body = $('#rep2_table').empty().append('<tbody />');
    
                for(var i in response){
                    var val = response[i];
                    for(var j in val){
                        var sub_val = val[j];
                        for(var br in sub_val){
                            if (!branchs.includes(br)){
                                branchs.push(br);
                            }
                        }                    
                    }                
                }
    
                branchs.sort();
                var cvlebisRaodenoba = 2;
    
                var head1 = branchs.slice();
                head1.unshift("", "");
                var rowh1 = array_to_th(head1);
                rowh1.find('th:not(:empty)').attr('colspan', cvlebisRaodenoba);
                table_view2_body.append(rowh1);
    
                var rowh2 = $('<tr />');
                var t1 = $('<td />').text('ოპერაცია');
                var t2 = $('<td />').text('ოპერატორი');
                t2.css("border-right" , '1px solid #aaaaaa');
                rowh2.append(t1, t2);
                for (var b in branchs){
                    for (var i = 1; i <= cvlebisRaodenoba; i++){
                        var td = $('<td />').text(i).css("text-align" , 'center');
                        if (i == cvlebisRaodenoba){
                            td.css("border-right" , '1px solid #aaaaaa');
                        }
                        rowh2.append(td);
                    }
                }
                rowh2.css("background-color" , '#ddffff');
                table_view2_body.append(rowh2);
    
                for (var si in states){
                    for (var i = 0; i < users.length; i++){
                        if (response[users[i]][states[si]] == undefined){
                            response[users[i]][states[si]] = {};
                        }
                        var newRow = $('<tr></tr>');
                        var rowhead = $('<th />').text(states_toshow[si]);
                        var rowheaduser = $('<th />').text(users[i]).css("border-right" , '1px solid #aaaaaa');
                        newRow.append(rowhead, rowheaduser);
                        for (var j = 0; j < branchs.length; j++){
                            var dataA;
                            if (response[users[i]][states[si]][branchs[j]] == undefined){
                                dataA = [0,0];
                            }else {
                                dataA = response[users[i]][states[si]][branchs[j]];
                            }
    
                            for (var ci in dataA){
                                var new_td = $('<td />').text(dataA[ci]).addClass('equalsimbols').css("text-align" , 'right');
                                if (ci == cvlebisRaodenoba-1){
                                    new_td.css("border-right" , '1px solid #aaaaaa');
                                }
                                if (dataA[ci] == 0){
                                    new_td.text("-");
                                }
                                newRow.append(new_td); 
                            }
                            
                        }
                        table_view2_body.append(newRow);
                    }
                }
            }
            
        }
    });    
}

$(function () {
    $('ul.components').find('li').removeClass('active');
    $('ul.components').find('li.reportsPage').addClass('active');
    var currdate = new Date();
    var nextday = new Date();
    nextday.setDate(nextday.getDate() + 1);
    $('input.d1').val(firstday(currdate));
    $('input.d2').val(dateformat(nextday));
    rep2_down_link.attr('href', 'rep2_exp.php?datefrom='+firstday(currdate)+'&dateto='+dateformat(nextday));
    link_query3 = 'datefrom=' + firstday(currdate)
        + '&dateto=' + dateformat(nextday)
        + '&organization='
        + '&username=' ;
    rep3_down_link.attr('href', 'rep3_exp.php?' + link_query3 );
    rep4_down_link.attr('href', 'rep4_exp.php?datefrom='+firstday(currdate)+'&dateto='+dateformat(nextday));
});

function f_show(){};
function f_hide(){};

function array_to_th(columns){
    var headrow = $('<tr></tr>');
    columns.forEach(function (item) {
        var new_th = $('<th />').text(item).attr('scope','col');
        headrow.append(new_th);
    });
    return headrow;
};

var capt_text = "დათვალიერებული პაროლები";
var capt = $('<caption />').text(capt_text);
var v3_columns = ["ორგანიზაცია", "ფილიალი", "მომხ.სახელი", "Apple-ის ანგარიში", "რომელი პაროლი", "დათვალიერების მიზეზი", "ხელშეკრულება", "დათვალიერების დრო" ];

$('#rep3_table').empty().append(capt, array_to_th(v3_columns)); 

function makePaginationButtons(pgCount){
    var pages1 = $('ul.pagination');
    pages1.empty();
    
    var aa = $('<a />').text("1").attr('href',"#");
    var li_first = $('<li />').attr('data','1');
    li_first.append(aa);
    pages1.append(li_first);
//«»
    var aa = $('<a />').text("<<").attr('href',"#");
    var li_left = $('<li />').attr('data',pgN-1);
    li_left.append(aa);
    if (pgN == 1){
        li_left.attr('data',pgN);        
    }
    pages1.append(li_left);
    
    for (var i = pgN - 2 ; i <= pgN + 2 ; i++){
        if (1 <= i && i <= pgCount){
            var aa = $('<a />').text(i).attr('href',"#");
            var lii = $('<li />').attr('data',i);
            if (i == pgN){
                lii.addClass("active");
            }
            lii.append(aa);
            pages1.append(lii);
        }        
    }
    
    var aa = $('<a />').text(">>").attr('href',"#");
    var li_next = $('<li />').attr('data',pgN+1);
    li_next.append(aa);
    if (pgN == pgCount){
        li_next.attr('data',pgCount);        
    }
    pages1.append(li_next);

    var aa = $('<a />').text(pgCount).attr('href',"#");
    var li_last = $('<li />').attr('data',pgCount);
    li_last.append(aa);
    pages1.append(li_last);
    
}

$('ul.pagination').on("click", "li", function(e){
    e.preventDefault();
    var newPageN = $(this).attr("data");
    $('#f11_pageN').val( newPageN - 1 );
    lastQuery = $('#form_viewrep3').serialize();
    get_rep3_list(lastQuery);
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

function firstday(d) {
    // gvibrunebs "d" tarigidan tvis 1 ricxvs
    var mm;
    if (d.getMonth() < 9) {
        mm = "0" + (d.getMonth() + 1);
    } else {
        mm = d.getMonth() + 1;
    }    
    return d.getFullYear() + "-" + mm + "-01";
}