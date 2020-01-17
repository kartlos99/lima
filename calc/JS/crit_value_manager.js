var existingTechPriceRecordID = 0;

var techPriceRow = [];
var price_and_crit_weight_STATE = 0;

var techPriceForm = $('#tech_price');
var divTitle1 = $('div.title1');
var priceAndCritWeightStatusSelector = $('#price_crit_weight_status_id');

var criteriasData;
var groupsHavingMainCrit = [];
var waitingForResponse = false;
var isCriteriaInEditMode = false;


$('#typename_id').on('change', function () {
    techPosArray = [$('#typename_id').val(), "0", "0"];
    $('#brandname_id').empty();
    $('#modelname_id').empty();
    if (techPosArray[0] != 0) {
        loadTypesList(techPosArray[0], 'brandname_id');
    }
    console.log(techPosArray);
});

$('#brandname_id').on('change', function () {
    techPosArray[1] = $('#brandname_id').val();
    techPosArray[2] = "0";
    $('#modelname_id').empty();
    if (techPosArray[1] != 0) {
        loadTypesList(techPosArray[1], 'modelname_id');
    }
    console.log(techPosArray);
});

$('#modelname_id').on('change', function () {
    techPosArray[2] = $('#modelname_id').val();
    console.log(techPosArray);
});

function fillTechPriceBlock(dataRow) {
    $('#price_new_id').val(dataRow.NewPrice);
    $('#price_goal_id').val(dataRow.GoalPrice);
    $('#calc_type_id').val(dataRow.CalculateType);
    $('#price_market_id').val(dataRow.MarketPrice);
    $('#price_impact_id').val(dataRow.Impact);
    $('#max_amount_id').val(dataRow.MaxPrice);
    $('#price_competitor_id').val(dataRow.CompetitorPrice);
    $('#impact_type_id').val(dataRow.ImpactType);
    $('#status_id').val(dataRow.MaxPriceStatusID);
    $('#impact_size_id').val(dataRow.ImpactValue);
    $('#revision_period_id').val(daysTillDate(dataRow.RevDate));
    $('#price_note_id').val(dataRow.Note);
    $('#revision_date_id').val(dataRow.RevDate);

    $('#techPriceRecordID').val(dataRow.ID);
    existingTechPriceRecordID = dataRow.ID;
}

$('i.fa-sync-alt').on('click', function () {
    techPriceForm.find('i.fa-times').trigger('click');
    criteriasOnTechID = 0;
    if (techPosArray[2] == 0) {
        alert(text_chooseModel);
    } else {
        var criteriasOnText = "";
        criteriasOnText += $('#typename_id').find('option:selected').text();
        criteriasOnText += " > " + $('#brandname_id').find('option:selected').text();
        criteriasOnText += " > " + $('#modelname_id').find('option:selected').text();
        criteriasOnTechID = techPosArray[2];
        criteriasOnTechPosArray = techPosArray.slice();
        $('table.custom-title span.red-in-title').text(criteriasOnText);

        $.ajax({
            url: 'php_code/get_tech_price.php',
            method: 'get',
            data: {'techID': criteriasOnTechID},
            dataType: 'json',
            success: function (response) {

                if (response.length > 0) {
                    techPriceRow = response[0];
                    fillTechPriceBlock(response[0]);
                    $('#price_crit_weight_status_id').val(techPriceRow.StatusID);
                    printout(response)
                } else {
                    $('#tech_price').trigger('reset');
                    $('#techPriceRecordID').val(0);
                    existingTechPriceRecordID = 0;
                }
                console.log("existingTechPriceRecordID", existingTechPriceRecordID);
            }
        });
        $('#techID').val(criteriasOnTechID);

        $.ajax({
            url: 'php_code/get_criterias_on_tech.php',
            method: 'get',
            data: {
                'techID': criteriasOnTechID,
                'onlyActive': true,
                'withValues': true
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                criteriasData = response.slice();
                groupsHavingMainCrit = [];

                criteriasData.forEach(function (item) {
                    if (item.IsMain == 1) {
                        groupsHavingMainCrit.push({
                            'name': item.gr,
                            'id': item.id
                        });
                    }
                });

                var grName = "";
                $('#criteriaValueTableBody').empty();

                response.forEach(function (item) {
                    var cloneRow = trToClone.clone();
                    cloneRow.attr("data-id", item.id);

                    if (grName != item.gr) {
                        var td_grName = $('<td />').text(item.gr);
                        td_grName.addClass("gr-name crit-name");
                        var trow = $('<tr></tr>').append(td_grName);
                        $('#criteriaValueTableBody').append(trow);
                        grName = item.gr;
                    }
                    console.log(item);
                    cloneRow.find('td.crit-name').addClass("criteria-name").attr("data-gr", item.gr).text(item.criteria);

                    var chackMain = item.IsMain == 1;

                    if (item.crWeightID != null) {
                        cloneRow.find('select.id_impact').val(item.Impact);
                        cloneRow.find('select.id_type').val(item.ImpactType);
                        cloneRow.find('input.id_size').val(item.ImpactValue);
                        cloneRow.find('input.chk-box').attr("checked", chackMain);
                        cloneRow.find('input.id_day').val(daysTillDate(item.RevDate));
                        cloneRow.find('input.id_date').val(item.RevDate);
                        cloneRow.find('select.id_status').val(item.CritValuesStatusID);
                        cloneRow.attr("data-recID", item.crWeightID);
                    }

                    disableValueInputForm(cloneRow);

                    $('#criteriaValueTableBody').append(cloneRow);

                });

                waitingForResponse = false;
            }
        });

    }
});

var criteriaValueEditTable = $('#tb_technic_criteria');

criteriaValueEditTable.on('click', 'i.fa-check', function () {

    if (waitingForResponse || !isCriteriaInEditMode)
        return;

    var thisRow = $(this).closest("tr");
    var mainCritConflict = false;

    if (thisRow.find('input.chk-box').is(":checked")) {
        var grName = thisRow.find('td.crit-name').attr("data-gr");
        groupsHavingMainCrit.forEach(function (item) {
            if (item.name == grName && thisRow.attr("data-id") != item.id) {

                mainCritConflict = true;
            }
        })
    }

    if (mainCritConflict) {
        alert("ამ ჯგუფში უკვე განსაზღვრულია ერთი მთავარი კრიტერიუმი!");
    } else {
        waitingForResponse = true;
        isCriteriaInEditMode = false;
        $.ajax({
            url: 'php_code/ins_criteria_values.php',
            method: 'post',
            data: {
                'criteriumID': thisRow.attr("data-id"),
                'impact': thisRow.find('select.id_impact').val(),
                'impact_type': thisRow.find('select.id_type').val(),
                'size': thisRow.find('input.id_size').val(),
                'is_main': thisRow.find('input.chk-box').is(":checked") ? 1 : 0,
                'rev_day': thisRow.find('input.id_day').val(),
                'rev_date': thisRow.find('input.id_date').val(),
                'status': thisRow.find('select.id_status').val(),
                'record_id': thisRow.attr("data-recID")
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.result == "success") {
                    thisRow.attr("data-recID", response.record_id);
                } else {
                    waitingForResponse = false;
                    console.log(response.error);
                }
                $('i.fa-sync-alt').trigger('click');
            }
        });
    }


    // disableValueInputForm(thisRow);
    console.log(thisRow.attr("data-id"));
});

criteriaValueEditTable.on('click', 'i.fa-times', function () {
    if (!isCriteriaInEditMode)
        return;
    isCriteriaInEditMode = false;
//    var thisRow = $(this).closest("tr");
//    disableValueInputForm(thisRow);
    $('i.fa-sync-alt').trigger('click');
});

criteriaValueEditTable.on('click', 'i.fa-edit', function () {
    if (isCriteriaInEditMode)
        return;
    var thisRow = $(this).closest("tr");
    thisRow.find('select').attr("readonly", false).find('option').attr('disabled', false);
    thisRow.find('input').attr("readonly", false);
    thisRow.find('input.chk-box').attr("disabled", false);
    isCriteriaInEditMode = true;
});

function disableValueInputForm(conteinerRow) {
    conteinerRow.find('select').attr("readonly", true).find('option').attr('disabled', true);
    conteinerRow.find('input').attr("readonly", true);
    conteinerRow.find('input.chk-box').attr("disabled", true);
}

criteriaValueEditTable.on('change', 'input.id_day', function () {
    var thisRow = $(this).closest("tr");
    var revisionDate = new Date();
    var days = revisionDate.getDate() + parseInt(thisRow.find('input.id_day').val());

    revisionDate.setDate(days);
    console.log(revisionDate);

    thisRow.find('input.id_date').val(dateformat(revisionDate));
});

criteriaValueEditTable.on('change', 'input.id_date', function () {
    var thisRow = $(this).closest("tr");

    var revisionDate = thisRow.find('input.id_date').val();
    var revDate = new Date(revisionDate);
    var now = new Date();
    var diff = new Date(revDate - now);
    console.log(revDate);
    console.log(revDate.getDate() - now.getDate());

    thisRow.find('input.id_day').val(Math.floor(diff / 1000 / 60 / 60 / 24) + 1);
});


techPriceForm.find('i.fa-check').on('click', function () {
    if (criteriasOnTechID != 0) {
        sendData = $('#tech_price').serialize();
        printout(sendData);
        $.ajax({
            url: 'php_code/ins_tech_price.php',
            method: 'post',
            data: sendData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.result == "success") {
                    // workingID - Insertis dros axlad damatebuli, Update-s dros moqmedi
                    $('#techPriceRecordID').val(response.workingID);
                    existingTechPriceRecordID = response.workingID;
                    $('#price_crit_weight_status_id').find('option[data-code="Project"]').attr("selected", "selected");
                }
                console.log("existingTechPriceRecordID", existingTechPriceRecordID);
            }
        });
        disablePriceForm(techPriceForm);
    } else {
        alert(text_chooseModel);
    }

});


techPriceForm.find('i.fa-edit').on('click', function () {
    techPriceForm.find('input').attr("readonly", false);
    techPriceForm.find('select').attr("readonly", false).find('option').attr('disabled', false);
    calculateMaxPrice();
});

techPriceForm.find('i.fa-times').on('click', function () {
    fillTechPriceBlock(techPriceRow);
    disablePriceForm(techPriceForm);
});

function disablePriceForm(aform) {
    aform.find('input').attr("readonly", true);
    aform.find('select').attr("readonly", true).find('option').attr('disabled', true);
}

divTitle1.find('i.fa-check').on('click', function () {
    console.log("existingTechPriceRecordID", existingTechPriceRecordID);

    if (criteriasOnTechID != 0) {
        var stateID = $('#price_crit_weight_status_id').val();
        sendData = {
            'price_crit_weight_status': stateID,
            'tech_id': criteriasOnTechID,
            'record_id': existingTechPriceRecordID
        };
        printout(sendData);
        $.ajax({
            url: 'php_code/ins_tech_price.php',
            method: 'post',
            data: sendData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.result == "success") {
                    price_and_crit_weight_STATE = stateID;
                    $('#price_crit_weight_status_id').attr("readonly", true).find('option').attr('disabled', true);
                }
            }
        });
    } else {
        alert(text_chooseModel);
    }

});

divTitle1.find('i.fa-edit').on('click', function () {
    priceAndCritWeightStatusSelector.attr("readonly", false).find('option').attr('disabled', false);
    price_and_crit_weight_STATE = priceAndCritWeightStatusSelector.val();
});

divTitle1.find('i.fa-times').on('click', function () {
    priceAndCritWeightStatusSelector.val(price_and_crit_weight_STATE);
    priceAndCritWeightStatusSelector.attr("readonly", true).find('option').attr('disabled', true);
});


//$('#price_goal_id').on('change', function () {
//    calculateMaxPrice();
//});

techPriceForm.find('select, input').on('change', function () {
    calculateMaxPrice();
});

function calculateMaxPrice() {
    var amount = 0;

    switch ($('#price_goal_id').find('option:selected').data("code")) {
        case "new_price":
            amount = parseFloat($('#price_new_id').val());
            break;
        case "market_price":
            amount = parseFloat($('#price_market_id').val());
            break;
        case "competitor_price":
            amount = parseFloat($('#price_competitor_id').val());
            break;
    }

    var positiveImpact = false;
    if ($('#price_impact_id').find('option:selected').data("code") == "positive") {
        positiveImpact = true;
    }

    var impactSize = parseFloat($('#impact_size_id').val());

    switch ($('#impact_type_id').find('option:selected').data("code")) {
        case "money":
            if (positiveImpact) {
                amount += impactSize;
            } else {
                amount -= impactSize;
            }
            break;
        case "percent":
            if (positiveImpact) {
                amount += (amount / 100) * impactSize;
            } else {
                amount -= (amount / 100) * impactSize;
            }
            break;
        case "coefficient":
            amount = amount * impactSize;
            break;
    }

    checkCalculationType(amount);
}

function checkCalculationType(amount) {
    if ($('#calc_type_id').find('option:selected').data("code") == "impact_on_fees") {
        $('#max_amount_id').val(amount).attr("readonly", true);
    } else {
        $('#max_amount_id').attr("readonly", false);
    }
}

$('#revision_period_id').on('change', function () {
    var revisionDate = new Date();
    var days = revisionDate.getDate() + parseInt($('#revision_period_id').val());

    revisionDate.setDate(days);
    console.log(revisionDate);

    $('#revision_date_id').val(dateformat(revisionDate));
});

$('#revision_date_id').on('change', function () {
    $('#revision_period_id').val(daysTillDate($('#revision_date_id').val()));
});

function daysTillDate(dateString) {
    var revDate = new Date(dateString);
    var now = new Date();
    var diff = new Date(revDate - now);
    return Math.floor(diff / 1000 / 60 / 60 / 24) + 1;
}

$('#impact_type_id').on('change', function (el) {
    var holder = "";
    switch ($('#impact_type_id').find('option:selected').data("code")) {
        case "money":
            holder = "₾";
            break;
        case "percent":
            holder = "%";
            break;
        case "coefficient":
            holder = "x კოეფ.";
    }

    $('#impact_size_id').attr("placeholder", holder);
});

var trToClone;

$(document).ready(function () {
    console.log("ready!");
    $('#typename_id').attr("data-nn", 0);
    $('#brandname_id').attr("data-nn", 1);
    $('#modelname_id').attr("data-nn", 2);

    $('#price_crit_weight_status_id').attr("readonly", true).val(0).find('option').attr('disabled', true);
    loadTypesList(0, 'typename_id');

    trToClone = $('table.hidden').find('tr');
    techPriceForm.find('i.fa-times').trigger('click');
});