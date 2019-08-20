var selectedModel = 0;
var maxPrice = 0;
var trToClone;
var criteriasConteiner = $('div.kriterias-box').find('tbody');
var criteriasData;
var priceCalculated = 0;
var appRecID = 0;
var checkedCriteriastext;
var estimateResultSucces = false;
var ganacxadiN;

function compare(a, b) {
    if (a.ImpactType < b.ImpactType) {
        return 1;
    }
    if (a.ImpactType > b.ImpactType) {
        return -1;
    }
    return 0;
}

$('#btnRate').on('click', function () {
    var emptyRows = criteriasConteiner.find('tr[data-answ=0]');
    estimateResultSucces = false;

    if (emptyRows.length > 0) {
        alert("აუცილებელია ყველა კრიტერიუმზე მნიშვნელობის დაფიქსირება!");
    } else {
        var selecterRows = criteriasConteiner.find('tr[data-answ=yes]');
        // console.log("posAnsw:", selecterRows);
        var selN = [];
        var minOut = 0;
        var dontLeave = false;
        priceCalculated = maxPrice;
        checkedCriteriastext = "";

        selecterRows.each(function (index) {
            // console.log( index + ": " + $( this ).attr("data-id") );
            selN.push($(this).attr("data-id"));
        });

        criteriasData.sort(compare);

        criteriasData.forEach(function (item) {
            if (selN.includes(item.id)) {
                console.log('id', item.id);
                if (item.impactCode == "min_out") {
                    minOut += item.ImpactValue;
                } else if (item.impactCode == "dont_leave") {
                    dontLeave = true;
                } else if (item.impactCode == "negative" || item.impactCode == "positive") {
                    priceCalculated = calculateImpact(item, priceCalculated);
                    console.log("prMAX:", maxPrice);
                    console.log("prCalc:", priceCalculated);
                }
                checkedCriteriastext += item.criteria;
                checkedCriteriastext += ", ";
            }
        });

        if (priceCalculated < minOut) {
            priceCalculated = minOut;
        }

        if (dontLeave) {
            $('#reteResultText').text("არ ვიტოვებთ!").addClass('alert-warning').removeClass('alert-success');
            $('#rateResultNumber').text(0);
        } else {
            estimateResultSucces = true;
            $('#reteResultText').text("შეფასება განხორციელდა წარმატებით !").addClass('alert-success').removeClass('alert-warning');
            $('#rateResultNumber').text(priceCalculated);
        }

        console.log("estimateResultSucces", estimateResultSucces);
    }
});

function calculateImpact(dataRow, currPrice) {
    var newValue;
    currPrice = parseFloat(currPrice);
    switch (dataRow.impactTypeCode) {
        case "coefficient":
            newValue = currPrice * parseFloat(dataRow.ImpactValue);
            break;
        case "percent":
            if (dataRow.impactCode == "positive") {
                newValue = currPrice + (currPrice / 100) * parseFloat(dataRow.ImpactValue);
            } else {
                newValue = currPrice - (currPrice / 100) * parseFloat(dataRow.ImpactValue);
            }
            break;
        case "money":
            if (dataRow.impactCode == "positive") {
                newValue = currPrice + parseFloat(dataRow.ImpactValue);
            } else {
                newValue = currPrice - parseFloat(dataRow.ImpactValue);
            }
            break;
    }
    return newValue;
}

$('#btnStartPriceRate').on('click', function () {
    if (techPosArray[2] == 0) {
        alert(text_chooseModel);
    } else {
        selectedModel = techPosArray[2];

        $.ajax({
            url: 'php_code/get_tech_price.php',
            method: 'get',
            data: {'techID': selectedModel},
            dataType: 'json',
            success: function (response) {
                // printout(response)

                if (response.length > 0) {
                    techPriceRow = response[0];
                    var pcwStatus = techPriceRow.pcwStatus;
                    maxPrice = techPriceRow.MaxPrice;

                    if (pcwStatus != 'Active') {
                        alert(text_PriceAndCriteriaWeightStatusAlert);
                    } else {
                        // არჩეული მოდელი მოიძებნა და აქტიური სტატუსი აქვს
                        getEstimateInfo();
                    }
                } else {
                    alert(text_NotFound);
                }
                // console.log("existingTechPriceRecordID", existingTechPriceRecordID);
            }
        });
    }
});


function getEstimateInfo() {
    // $.ajax({
    //     url: 'php_code/get_tech_price.php',
    //     method: 'get',
    //     data: {'techID': selectedModel},
    //     dataType: 'json',
    //     success: function (response) {
    //
    //         if (response.length > 0) {
    //             techPriceRow = response[0];
    //             fillTechPriceBlock(response[0]);
    //             $('#price_crit_weight_status_id').val(techPriceRow.StatusID);
    //             printout(response)
    //         } else {
    //             $('#tech_price').trigger('reset');
    //             $('#techPriceRecordID').val(0);
    //             existingTechPriceRecordID = 0;
    //         }
    //         console.log("existingTechPriceRecordID", existingTechPriceRecordID);
    //     }
    // });
    // $('#techID').val(criteriasOnTechID);
    criteriasData = [];
    $.ajax({
        url: 'php_code/get_criterias_on_tech.php',
        method: 'get',
        data: {
            'techID': selectedModel,
            'onlyActive': true,
            'withValues': true,
            'onlyActiveValue': true
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            criteriasData = response.slice();
            var grName = "";

            criteriasConteiner.empty();

            response.forEach(function (item) {
                // console.log(item);
                var cloneRow = trToClone.clone();
                cloneRow.attr("data-id", item.id);

                if (grName != item.gr) {
                    var td_grName = $('<td />').text(item.gr);
                    td_grName.addClass("grNameStyle");
                    var trow = $('<tr></tr>').append(td_grName, $('<td />'), $('<td />'));
                    trow.find('td:first').attr("colspan", 3);
                    criteriasConteiner.append(trow);
                    grName = item.gr;
                }

                cloneRow.find('span').text(item.criteria);
                cloneRow.find('input').attr("name", "name_" + item.id);

                if (item.crWeightID == null) {
                    console.log("No Values Found! id:", item.id);
                }

                criteriasConteiner.append(cloneRow);

            });

        }
    });
}

criteriasConteiner.on('click', 'input.answ1', function () {
    var thisRow = $(this).closest("tr");
    thisRow.attr("data-answ", "yes");
});

criteriasConteiner.on('click', 'input.answ2', function () {
    var thisRow = $(this).closest("tr");
    thisRow.attr("data-answ", "no");
});

function answer1() {

    console.log('a1', this);
    var thisRow = $(this).closest("tr");
    thisRow.attr("data-answ", "yes");
    // console.log('el',el);
    console.log('thisrow', thisRow);
    thisRow.empty();
}

function answer2(el) {
    console.log('a2', this);
    var thisRow = $(this).closest("tr");
    thisRow.attr("data-answ", "no");
}

var priceCorectionTable = $('#tbPriceCorection');
var correction = false;

priceCorectionTable.find('input[type=checkbox]').on('click', function () {
    correction = (priceCorectionTable.find('input[name=inc_by_manager]').is(":checked") || priceCorectionTable.find('input[name=dec_by_client]').is(":checked"))
    $('#corection_id').attr("readonly", !correction);
    if (!correction) {
        $('#corection_id').val(0);
        $('#rateResultNumberCorected').text(0);
    }else {
        $('#corection_id').val(parseFloat(priceCalculated).toFixed(2));
    }
});

$('#corection_id').on('blur', function () {
    $('#rateResultNumberCorected').text(parseFloat($('#corection_id').val()).toFixed(2));
});

$('#btnInfoGen').on('click', function () {
    $('#finalInfo').empty();
    console.log("estimateResultSucces", estimateResultSucces);
    if (!estimateResultSucces) {
        alert("შეფასება განხორციელდა წარუმატებლად!");
    } else if (priceCorectionTable.find('input[name=inc_by_manager]').is(":checked") && $('#corection_id').val() - priceCalculated > 50) {
        alert("გასაცემი თანხა 50 ლარზე მეტად აღემატება გამოთვლილ მნიშვნელობას!");
    } else if (!$('#serial_N_id').val()) {
        alert("seriuli nomeri araa Seyvanili");
    } else if (!$('#imei_id').val()) {
        alert("IMEI araa Seyvanili");
    } else {
// infos Senaxa
        $.ajax({
            url: 'php_code/ins_application.php',
            method: 'post',
            data: {
                'TechTreeID': selectedModel,
                'TechModelFix': $('#modelbyhand_id').val(),
                'TechSerial': $('#serial_N_id').val(),
                'TechIMEI': $('#imei_id').val(),
                'note': $('#note_id').val(),
                'SysTechPrice': priceCalculated,
                'ManagerAdd': priceCorectionTable.find('input[name=inc_by_manager]').is(":checked") ? 1 : 0,
                'ClientDec': priceCorectionTable.find('input[name=dec_by_client]').is(":checked") ? 1 : 0,
                'CorTechPrice': $('#corection_id').val(),
                'OrganizationID': $('#organization_id').val(),
                'BranchID': $('#filial_id').val(),
                'record_id': appRecID
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.result == "success") {

                    if (appRecID == 0) {
                        ganacxadiN = response.ApNumber + " " + response.ApDate;
                    }
                    appRecID = response.record_id;


                    var teqnika = $('#type_id').find('option:selected').text() + ", " + $('#brand_id').find('option:selected').text() + ", " + $('#model_id').find('option:selected').text()
                        + " (" + $('#modelbyhand_id').val() + " IMEI: " + $('#imei_id').val() + ". SN: " + $('#serial_N_id').val() + ")";
                    var mdgomareoba = checkedCriteriastext.trim(", ");
                    var gacemuli = correction ? $('#corection_id').val() : priceCalculated;
                    var correctionText = correction ? "დიახ" : "არა";

                    var br = "</br>";


                    $('#finalInfo').append("განაცხადი N: " + ganacxadiN, br);
                    $('#finalInfo').append("ტექნიკა: " + teqnika, br);
                    $('#finalInfo').append("მდგომარეობა: " + mdgomareoba, br);
                    $('#finalInfo').append("თანხა სისტემიდან: " + priceCalculated + " ₾", br);
                    $('#finalInfo').append("თანხის კორექტირება: " + correctionText, br);
                    $('#finalInfo').append("გაცემული თანხა: " + gacemuli + " ₾", br);

                } else {
                    console.log(response.error);
                }
            }
        });
    }


});

$('#type_id').on('change', function () {
    techPosArray = [$('#type_id').val(), "0", "0"];
    $('#brand_id').empty();
    $('#model_id').empty();
    if (techPosArray[0] != 0) {
        loadTypesList(techPosArray[0], 'brand_id');
    }
    console.log(techPosArray);
});

$('#brand_id').on('change', function () {
    techPosArray[1] = $('#brand_id').val();
    techPosArray[2] = "0";
    $('#model_id').empty();
    if (techPosArray[1] != 0) {
        loadTypesList(techPosArray[1], 'model_id');
    }
    console.log(techPosArray);
});

$('#model_id').on('change', function () {
    techPosArray[2] = $('#model_id').val();
    console.log(techPosArray);
});

var organizationObj;

$(document).ready(function () {
    console.log("ready!");
    $('#type_id').attr("data-nn", 0);
    $('#brand_id').attr("data-nn", 1);
    $('#model_id').attr("data-nn", 2);

    loadTypesList(0, 'type_id');
    $('#corection_id').attr("readonly", true);

    trToClone = $('table.hidden').find('tr');

    $.ajax({
        url: '../php_code/get_dropdown_lists.php',
        method: 'post',
        data: {
            'org': 'org'
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);

            //<!--    organizaciebis chamonatvali -->
            organizationObj = response.org;
            $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#organization_id');
            organizationObj.forEach(function (item) {
                $('<option />').text(item.OrganizationName).attr('value', item.id).appendTo('#organization_id');
            });

        }
    });
});

$('#organization_id').on('change', function () {

    org_p1 = $('#organization_id').val();

    loadBranches11(org_p1, 0)
});

function loadBranches11(orgID, brID) {
    $('#filial_id').empty().removeAttr('disabled');

    // <!--    filialebis chamonatvali -->
    if (orgID == "") {
        $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#filial_id');
    } else {
        organizationObj.forEach(function (org) {
            if (org.id == orgID) {
                var branches = org.branches;
                if (branches.length != 1) {
                    $('<option />').text('აირჩიეთ...').attr('value', '').appendTo('#filial_id');
                }
                branches.forEach(function (item) {
                    $('<option />').text(item.BranchName).attr('value', item.id).appendTo('#filial_id');
                });
                if (brID > 0) {
                    $('#filial_id').val(brID);
                }
            }
        });
    }
}

function mycopy() {
    $('#atext').val($('#finalInfo').text())
    var copyel = document.getElementById("atext");
    copyel.select();
    document.execCommand("copy");
    // alert("Copied the text: " + copyel.value);
}