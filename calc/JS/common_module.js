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


function f_show() {
}
function f_hide() {
}

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
                techPosArray[nn] = selEl.val();
                console.log(techPosArray);

                techDataArray[nn] = response;
                console.log(techDataArray);

                if (pos.length > 0){
                    selEl.val(pos);
                }else{
                    selEl.trigger('change');
                }
            }

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