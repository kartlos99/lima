/**
 * Created by k.diakonidze on 8/15/19.
 */

var optionChoose = "...აირჩიეთ";
var techPosArray = [0, 0, 0];
var techDataArray = ["0", "0", "0"];

function f_show() {
}

function printout(x) {
    console.log("printed:", x);
}

function loadTypesList(parentID, selector) {
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

                selEl.trigger('change');
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

