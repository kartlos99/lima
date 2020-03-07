/**
 * Created by k.diakonidze on 8/15/19.
 */

var optionChoose = "...აირჩიეთ";
var techPosArray = [0, 0, 0];
var techDataArray = ["0", "0", "0"];
var criteriasOnTechPosArray = [];
var criteriaPosArray = [];
var criteriaDataArray = [];


var text_chooseModel = "აირჩიეთ მოდელი!";
var text_PriceAndCriteriaWeightStatusAlert = "ღირებულებისა და კრიტერიუმების წონების სტატუსი არააქტიურია!";
var text_NotFound = "ჩანაწერი ვერ მოიძებნა!";

var resultType = {
    SUCCSES: "success",
    ERROR: "error"
};

var message = {
    saveOK: "მონაცემები შენახვა განხორციელდა წარმატებით!",
    saveERROR: "მონაცემების შენახვა ვერ მოხერხდა!",
    notsaved: "მონაცემები არაა შენახული!"
};

function f_show() {
}
function f_hide() {
}
var pageJS = $('#currusertype').attr("data-page");
$('ul.components').find('li').removeClass('active');
$('ul.components').find('li.'+pageJS).addClass('active');

function printout(x) {
    console.log("printed:", x);
}

function loadTypesList(parentID, selector, pos = 0) {
    var data = {
        'parentID': parentID
    };

    $.ajax({
        url: 'php_code/get_tech_list.php',
        method: 'get',
        data: data,
        dataType: 'json',
        success: function (response) {

            var selEl = $('#' + selector);
            selEl.empty();

            if (response.length > 0) {
                $('<option />').text(optionChoose).val(0).appendTo(selEl);
                response.forEach(function (item) {
                    $('<option />').text(item.Name).val(item.id).appendTo(selEl);
                });

                var nn = selEl.data("nn");

                techDataArray[nn] = response;
                console.log(techDataArray);

                if (pos.length > 0){
                    selEl.val(pos);
                }else{
                    selEl.trigger('change');
                }
                techPosArray[nn] = selEl.val();
                console.log(techPosArray);
            }
            selEl.trigger('chosen:updated');
        }
    });
}

function loadCriteriaslist(techID, parentID, selector) {
    console.log("selector", selector);
    var data = {
        'techID': techID,
        'parentID': parentID
    };

    $.ajax({
        url: 'php_code/get_criteria_list.php',
        method: 'get',
        data: data,
        dataType: 'json',
        success: function (response) {

            var selEl = $('#' + selector);
            selEl.empty();

            if (response.length > 0) {
                $('<option />').text(optionChoose).val(0).appendTo('#' + selector);
                response.forEach(function (item) {
                    console.log(item);
                    $('<option />').text(item.Name).val(item.CriteriumID).attr("data-mID", item.id).appendTo('#' + selector);
                });

                var nn = selEl.data("nn");
                criteriaPosArray[nn] = selEl.val();
                console.log(criteriaPosArray);

                criteriaDataArray[nn] = response;
                console.log('techDataArray:', criteriaDataArray);

                selEl.trigger('change');
            }
        }
    });

    $('#' + selector).empty();
}

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

function loadBranches(orgID, brID, sel_ID) {
    var branches_el_ID = '#' + sel_ID;
    $(branches_el_ID).empty().removeAttr('disabled');

    if (orgID == "" || orgID == "0") {
        $('<option />').text('აირჩიეთ...').attr('value', '0').appendTo(branches_el_ID);
    } else {
        organizationObj.forEach(function (org) {
            if (org.id == orgID) {
                var branches = org.branches;
                if (branches.length != 1) {
                    $('<option />').text('აირჩიეთ...').attr('value', '').appendTo(branches_el_ID);
                }
                branches.forEach(function (item) {
                    $('<option />').text(item.BranchName).attr('value', item.id).appendTo(branches_el_ID);
                });
                if (brID > 0) {
                    $('#filial_id').val(brID);
                }
            }
        });
    }
}