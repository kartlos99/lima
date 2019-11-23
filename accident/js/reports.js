var tableRep1 = $('#tbRep1').find('tbody');
var tableRep2 = $('#tbRep2').find('tbody');
filterForm = $('#reportFilterForm');

$(function () {

    getOrganizations('organization_id');
    loadBranches(0, 0, 'filial_id');
    getCategory('CategoryID_id');
    loadSubCategory(0, 0, 'SubCategoryID_id');
    $('select').val('');

});

$('#CategoryID_id').on('change', function () {
    loadSubCategory($('#CategoryID_id').val(), 0, 'SubCategoryID_id');
});

$('#organization_id').on('change', function () {
    loadBranches($('#organization_id').val(), 0, 'filial_id');
});

$('#btnClearApp').on('click', function (event) {
    event.preventDefault();
    filterForm.trigger('reset');
});

$('#btnRep1').on('click', function (event) {
    $('#repMode').val('day');
    $('#repExpMode').val('show');
    $('#rep1FilterQuery').text("ფილტრაცია: " + formToText());
    formCheck();
});

$('#btnRep2').on('click', function (event) {
    $('#repMode').val('month');
    $('#repExpMode').val('show');
    $('#rep2FilterQuery').text("ფილტრაცია: " + formToText());
    formCheck();
});

$('#btnExpRep1').on('click', function (event) {
    $('#repMode').val('day');
    $('#repExpMode').val('exp');
    formCheck();
});
$('#btnExpRep2').on('click', function (event) {
    $('#repMode').val('month');
    $('#repExpMode').val('exp');
    formCheck();
});

function formCheck() {
    var formIsValid = true;

    var recEl = filterForm.find('input:required');

    recEl.each(function (el) {
        console.log($(this));
        if (($(this).val() == null || $(this).val() === "") && formIsValid) {
            console.log($(this).val());
            formIsValid = false;
            $(this).focus();
        }
    });

    if (formIsValid) {
        var fromDate = new Date($('#fix_date_from_id').val());
        var toDate = new Date($('#fix_date_to_id').val());
        var diff = new Date(toDate - fromDate );
        var daysCount = Math.floor(diff / 1000 / 60 / 60 / 24) + 1;
        console.log("--DIFF:" + daysCount);
        if ($('#repMode').val() == 'day' && daysCount > 31) {
            alert('შეამცირეთ დიაპაზონი 31 დღემდე!');
        } else if ($('#repMode').val() == 'month' && daysCount > 365){
            alert('შეამცირეთ დიაპაზონი 365 დღემდე!');
        }else {
            if ($('#repExpMode').val() == 'show'){
                console.log("SHOW");
                getRep1(filterForm.serialize());
            }else {
                console.log("EXP");
                window.location.href = "php_code/rep_by_day.php?" + filterForm.serialize();
            }
        }
    } else {
        alert('შეავსეთაუცილებელი ველები!');
    }

}

function getRep1(querys) {
    console.log(querys);

    $.ajax({
        url: 'php_code/rep_by_day.php',
        method: 'get',
        data: querys,
        dataType: 'json',
        success: function (response) {
            console.log(response);

            if ($('#repMode').val() == 'day') {
                tableRep1.empty();
                fillTable(tableRep1, response.data);
            } else {
                tableRep2.empty();
                fillTable(tableRep2, response.data);
            }
        }
    });
}

function fillTable(table, data) {
    var firstRow = true;

    $.each(data, function (key, item) {
        console.log(key + ": ");
        var td_cat = $('<td />').text(item.cat);
        var td_scat = $('<td />').text(item.subcat);
        var trow = $('<tr></tr>').append(td_cat, td_scat);
        if (firstRow) {
            var td_cat_H = $('<td />').text("კატეგორია");
            var td_scat_H = $('<td />').text("ქვეკატეგორია");
            var trow_H = $('<tr></tr>').append(td_cat_H, td_scat_H);
        }

        $.each(item.dt, function (keyDate, value) {
            var td_dt_val = $('<td />').text(value).addClass('rep-data');
            if (value == 0)
                td_dt_val.addClass('gray-text-color');
            trow.append(td_dt_val);
            if (firstRow) {
                var td_H = $('<td />').text(keyDate).addClass("r90");
                trow_H.append(td_H);
            }
        });

        if (firstRow) {
            trow_H.addClass("first-row");
            table.append(trow_H);
            firstRow = false;
        }
        // trow.attr('ondblclick', "onRowClick(" + item.ID + ")");
        table.append(trow);
    });

    // $('.r90').css('height', $('.r90').width());
}

function formToText() {
    var queryText = "";
    if ($('#organization_id').val() != "" && $('#organization_id').val() != null ){
        queryText = queryText + "ორგანიზაცა - " + $('#organization_id').find('option:selected').text() + "; ";
    }
    if ($('#filial_id').val() != "0" && $('#filial_id').val() != "" && $('#filial_id').val() != null ){
        queryText = queryText + "ფილიალი - " + $('#filial_id').find('option:selected').text() + "; ";
    }
    if ($('#guilty_person_id_id').val() != "0" && $('#guilty_person_id_id').val() != "" && $('#guilty_person_id_id').val() != null ){
        queryText = queryText + "დამრღვევი პირი - " + $('#guilty_person_id_id').find('option:selected').text() + "; ";
    }
    if ($('#CategoryID_id').val() != "0" && $('#CategoryID_id').val() != "" && $('#CategoryID_id').val() != null ){
        queryText = queryText + "კატეგორია - " + $('#CategoryID_id').find('option:selected').text() + "; ";
    }
    if ($('#SubCategoryID_id').val() != "0" && $('#SubCategoryID_id').val() != "" && $('#SubCategoryID_id').val() != null ){
        queryText = queryText + "ქვე კატეგორია - " + $('#SubCategoryID_id').find('option:selected').text() + "; ";
    }
    if ($('#fix_date_from_id').val() != "0" && $('#fix_date_from_id').val() != "" && $('#fix_date_from_id').val() != null ){
        queryText = queryText + "პერიოდი - " + $('#fix_date_from_id').val() + " დან ";
    }
    if ($('#fix_date_to_id').val() != "0" && $('#fix_date_to_id').val() != "" && $('#fix_date_to_id').val() != null ){
        queryText = queryText + " - " + $('#fix_date_to_id').val() + " მდე(ჩათვლით); ";
    }

    console.log(queryText);
    return queryText;
}