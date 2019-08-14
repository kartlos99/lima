/**
 * Created by k.diakonidze on 8/8/19.
 */

var parentID = 0;
var typeID = 0;
var optionChoose = "...აირჩიეთ";
var criteriasOnTechID = 0;

var techPosArray = [0, 0, 0];
var techDataArray = ["0", "0", "0"];
var criteriaPosArray = [];
var criteriaDataArray = [];
var criteriasOnTechPosArray = [];

$("#techManage").find("i.fa-arrow-alt-circle-left").on("click", function () {
    var thistr = this.closest("tr");
    console.log("AAAAAARA");
    var trID = thistr.id;

    var trtr = $('#' + trID);
    console.log(trtr.attr("data-nn"), "istNN");
    console.log($(trtr).data("nn"), "istNN");

    parentID = 0;
    if (trtr.attr("data-nn") > 0) {
        parentID = techPosArray[trtr.attr("data-nn") - 1];
    }
    typeID = trtr.attr("data-type");

    var techName = trtr.find("input[data-field='techName']").val();
    var techNote = trtr.find("input[data-field='techNote']").val();
    var statusi = trtr.find("td.selstatus select").val();
    console.log(techName, techNote, statusi);

    if (techName == "" || statusi == null) {
        alert("შეავსეთ მონაცემები!");
    } else {
        var dataObj = {
            'techName': techName,
            'techNote': techNote,
            'status': statusi,
            'parentID': parentID,
            'typeID': typeID
        };
        console.log(dataObj);

        $.ajax({
            url: 'php_code/ins_tech.php',
            method: 'post',
            data: dataObj,
            dataType: 'json',
            success: function (response) {
                console.log(response);
            }
        });
    }
});

$('#critManage').find("i.fa-arrow-alt-circle-left").on("click", function () {
    var trID = this.closest("tr").id;
    var trtr = $('#' + trID);

    parentID = 0;
    if (trtr.attr("data-nn") > 0) {
        parentID = criteriaPosArray[trtr.attr("data-nn") - 1];
    }
    typeID = trtr.attr("data-type");

    var vName = trtr.find("input[data-field='criteriaName']").val();
    var vNote = trtr.find("input[data-field='criteriaNote']").val();
    var vSstatus = trtr.find("td.selstatus select").val();

    var mappingParentID = $('#selgroupname_id').find('option:selected').attr('data-mid');

    if (vName == "" || vSstatus == null) {
        alert("შეავსეთ მონაცემები!");
    } else {
        var dataObj = {
            'Name': vName,
            'Note': vNote,
            'status': vSstatus,
            'parentID': parentID,
            'typeID': typeID,
            'techID' : criteriasOnTechID,
            'techArr': criteriasOnTechPosArray
//            'mappingParentID' : mappingParentID
        };
        console.log(dataObj);

        $.ajax({
            url: 'php_code/ins_criteria.php',
            method: 'post',
            data: dataObj,
            dataType: 'json',
            success: function (response) {
                console.log("resp: ", response);
            }
        });
    }

});

$("i.fa-times").on("click", function () {
    var thistr = this.closest("tr");

    var trID = thistr.id;

    var trtr = $('#' + trID);
    trtr.find("input[data-field='techName']").val("");
    trtr.find("input[data-field='techNote']").val("");
    trtr.find("td.selstatus select").val(0);
});

$("i.fa-edit").on("click", function () {
    var thistr = this.closest("tr[id][data-nn]");

    var trID = thistr.id;

    var trtr = $('#' + trID);
    var nn = trtr.data("nn");
    console.log("nn", nn);
    var arr = techDataArray[nn];
    arr.forEach(function (item) {
        console.log(item);
        console.log(techPosArray);
        if (item.id == techPosArray[nn]) {
            trtr.find("input[data-field='techName']").val(item.Name);
            trtr.find("input[data-field='techNote']").val(item.Note);
            trtr.find("td.selstatus select").val(item.StatusID);
        }
    });

});


$('#seltypename_id').on('change', function () {
    techPosArray = [$('#seltypename_id').val(), "0", "0"];
    $('#selbrandname_id').empty();
    $('#selmodelname_id').empty();
    if (techPosArray[0] != 0) {
        loadTypesList(techPosArray[0], 'selbrandname_id');
    }
    console.log(techPosArray);
});

$('#selbrandname_id').on('change', function () {
    techPosArray[1] = $('#selbrandname_id').val();
    techPosArray[2] = "0";
    $('#selmodelname_id').empty();
    if (techPosArray[1] != 0) {
        loadTypesList(techPosArray[1], 'selmodelname_id');
    }
    console.log(techPosArray);
});

$('#selmodelname_id').on('change', function () {
    techPosArray[2] = $('#selmodelname_id').val();
    console.log(techPosArray);
});

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

            if (response.length > 0) {
                $('<option />').text(optionChoose).val(0).appendTo('#' + selector);
                response.forEach(function (item) {
                    $('<option />').text(item.Name).val(item.id).appendTo('#' + selector);
                });
                var selEl = $('#' + selector);
                var nn = selEl.data("nn");
                techPosArray[nn] = selEl.val();
                console.log(techPosArray);

                techDataArray[nn] = response;
                console.log(techDataArray);
            }
        }
    });
}

function loadCriteriaslist(techID, parentID, selector){
    console.log("selector", selector);
    var data = {
        'techID' : techID,
        'parentID': parentID
    };

    $.ajax({
        url: 'php_code/get_criteria_list.php',
        method: 'get',
        data: data,
        dataType: 'json',
        success: function (response) {

            if (response.length > 0) {
                $('<option />').text(optionChoose).val(0).appendTo('#' + selector);
                response.forEach(function (item) {
                    console.log(item);
                    $('<option />').text(item.Name).val(item.CriteriumID).attr("data-mID", item.id).appendTo('#' + selector);
                });
                var selEl = $('#' + selector);
                var nn = selEl.data("nn");
                criteriaPosArray[nn] = selEl.val();
                console.log(criteriaPosArray);

                criteriaDataArray[nn] = response;
                console.log('techDataArray:', criteriaDataArray);
            }
        }
    });

    $('#'+selector).empty();
}

$('#section2').find('i.fa-sync-alt').on('click', function () {
    criteriasOnTechID = 0;
    var criteriasOnText = "";
    if (techPosArray[0] != 0) {
        criteriasOnText += $('#seltypename_id').find('option:selected').text();
        criteriasOnTechID = techPosArray[0];
    }
    if (techPosArray[1] != 0) {
        criteriasOnText += " > " + $('#selbrandname_id').find('option:selected').text();
        criteriasOnTechID = techPosArray[1];
    }
    if (techPosArray[2] != 0) {
        criteriasOnText += " > " + $('#selmodelname_id').find('option:selected').text();
        criteriasOnTechID = techPosArray[2];
    }
    criteriasOnTechPosArray = techPosArray.slice();

    $('#section2').find('span.red-in-title').text(criteriasOnText);

    loadCriteriaslist(criteriasOnTechID, 0, 'selgroupname_id');
});

$('#selgroupname_id').on('change', function () {
    criteriaPosArray[0] = $('#selgroupname_id').val();
    criteriaPosArray[1] = "0";
    $('#selratename_id').empty();
    if (criteriaPosArray[0] != 0) {
        loadCriteriaslist(criteriasOnTechID, criteriaPosArray[0], 'selratename_id');
    }
    console.log(criteriaPosArray);
});

$('#selratename_id').on('change', function () {
    criteriaPosArray[1] = $('#selratename_id').val();
    console.log(criteriaPosArray);
});


$(document).ready(function () {
    console.log("ready!");
    loadTypesList(0, 'seltypename_id');
});

function f_show() {
}