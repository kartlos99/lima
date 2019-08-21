/**
 * Created by k.diakonidze on 8/8/19.
 */

var parentID = 0;
var typeID = 0;

var criteriasOnTechID = 0;


$("input").attr("disabled", true);
$("td.selstatus select").val(0).attr("disabled", true);

// სისტემაში ასახვა, შენახვა
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
    var action = trtr.attr("data-enterType");
    var editingID = trtr.find("td.selobject select").val();

    var techName = trtr.find("input[data-field='name']").val();
    var techNote = trtr.find("input[data-field='note']").val();
    var statusi = trtr.find("td.selstatus select").val();
    console.log(techName, techNote, statusi, "editingID", editingID);

    if (techName == "" || statusi == null) {
        alert("შეავსეთ მონაცემები!");
    } else {
        var dataObj = {
            'techName': techName,
            'techNote': techNote,
            'status': statusi,
            'parentID': parentID,
            'typeID': typeID,
            'action': action,
            'editingID': editingID
        };
        console.log(dataObj);

        $.ajax({
            url: 'php_code/ins_tech.php',
            method: 'post',
            data: dataObj,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.result == "success") {
                    disableInputs(trtr);
                    loadTypesList(parentID, trtr.find("td.selobject select").attr("id"));
                }
                if (response.result == "error") {
                    alert(response.error);
                }
            }
        });
    }
});

function disableInputs(tableRow) {
    tableRow.find("input[data-field='name']").val("").attr("disabled", true);
    tableRow.find("input[data-field='note']").val("").attr("disabled", true);
    tableRow.find("td.selstatus select").val(0).attr("disabled", true);
}

// სისტემაში ასახვა, შენახვა
$('#critManage').find("i.fa-arrow-alt-circle-left").on("click", function () {
    var trID = this.closest("tr").id;
    var trtr = $('#' + trID);

    parentID = 0;
    if (trtr.attr("data-nn") > 0) {
        parentID = criteriaPosArray[trtr.attr("data-nn") - 1];
    }
    typeID = trtr.attr("data-type");
    var action = trtr.attr("data-enterType");
    var editingID = trtr.find("td.selobject select").val();
    var editingMappingID = trtr.find("td.selobject select").find('option:selected').attr('data-mid');

    var vName = trtr.find("input[data-field='name']").val();
    var vNote = trtr.find("input[data-field='note']").val();
    var vSstatus = trtr.find("td.selstatus select").val();


    if (vName == "") {
        alert("შეავსეთ მონაცემები!");
    } else if (vSstatus == null) {
        alert("შეავსეთ მონაცემები!");
    } else {
        var dataObj = {
            'Name': vName,
            'Note': vNote,
            'status': vSstatus,
            'parentID': parentID,
            'typeID': typeID,
            'techID': criteriasOnTechID,
            'techArr': criteriasOnTechPosArray,
            'action': action,
            'editingID': editingID,
            'editingMappingID': editingMappingID
        };
        console.log(dataObj);

        $.ajax({
            url: 'php_code/ins_criteria.php',
            method: 'post',
            data: dataObj,
            dataType: 'json',
            success: function (response) {
                console.log("resp: ", response);
                if (response.result != undefined){
                    if (response.result == "success") {
                        disableInputs(trtr);
                        loadCriteriaslist(criteriasOnTechID, parentID, trtr.find("td.selobject select").attr("id"));
                    }
                    if (response.result == "error") {
                        alert(response.error);
                    }
                }else {
                    alert("Connection Error!")
                }

            }
        });
    }

});

$("i.fa-times").on("click", function () {
    var thistr = this.closest("tr");
    var trtr = $('#' + thistr.id);
    disableInputs(trtr);
});

$("#techManage").find("i.fa-plus").on("click", function () {
    var thistr = this.closest("tr[id][data-nn]");
    var trID = thistr.id;
    var trtr1 = $('#' + trID);
    changeAppearance1(trtr1, techPosArray);
});

$("#critManage").find("i.fa-plus").on("click", function () {
    if (criteriasOnTechID != 0) {
        var thistr = this.closest("tr[id][data-nn]");
        var trID = thistr.id;
        var trtr1 = $('#' + trID);
        changeAppearance1(trtr1, criteriaPosArray);
    } else {
        alert("აირჩიეთ ტექნიკა!");
    }
});

function changeAppearance1(trtr, sectionData) {
    var nn = trtr.data("nn");
    console.log("nn", nn);
    console.log(sectionData[nn - 1]);

    if (nn == 0 || (sectionData.length > 0 && sectionData[nn - 1] != 0)) {
        console.log("nn_", nn);
        trtr.find("input[data-field='name']").val("").attr("disabled", false);
        trtr.find("input[data-field='note']").val("").attr("disabled", false);
        trtr.find("td.selstatus select").val(0).attr("disabled", false);
        trtr.attr("data-enterType", "new");
    }
}


$("#techManage").find("i.fa-edit").on("click", function () {
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
            trtr.find("input[data-field='name']").attr("disabled", false).val(item.Name);
            trtr.find("input[data-field='note']").attr("disabled", false).val(item.Note);
            trtr.find("td.selstatus select").attr("disabled", false).val(item.StatusID);
            trtr.attr("data-enterType", "edit");
        }
    });

});

$("#critManage").find("i.fa-edit").on("click", function () {
    var thistr = this.closest("tr[id][data-nn]");

    var trID = thistr.id;

    var trtr = $('#' + trID);
    var nn = trtr.data("nn");
    console.log("Criteria_nn:", nn);
    console.log("criteriaDataArray:", criteriaDataArray);
    var arr = criteriaDataArray[nn];
    arr.forEach(function (item) {
        console.log(item);
        console.log(criteriaPosArray);
        if (item.CriteriumID == criteriaPosArray[nn]) {
            trtr.find("input[data-field='name']").attr("disabled", false).val(item.Name);
            trtr.find("input[data-field='note']").attr("disabled", false).val(item.Note);
            trtr.find("td.selstatus select").attr("disabled", false).val(item.CriteriumStatusID);
            trtr.attr("data-enterType", "edit");
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

    if (criteriasOnTechID > 0) {
        loadCriteriaslist(criteriasOnTechID, 0, 'selgroupname_id');
    } else {
        alert("აირჩიეთ ტექნიკის ტიპი, ბრენდი, მოდელი");
    }

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

$('#section3').find('i.fa-sync-alt').on('click', function () {

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

    $('#section3').find('span.red-in-title').text(criteriasOnText);

    if (criteriasOnTechID > 0) {
        $.ajax({
            url: 'php_code/get_criterias_on_tech.php',
            method: 'get',
            data: {'techID': criteriasOnTechID},
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $('#section3Body').empty();
                response.forEach(function (item) {

                    var combineStatus = item.grcode != 'Active' ? item.grstatus : item.st;

                    var td_id = $('<td />').text(item.id);
                    var td_gr = $('<td />').text(item.gr);
                    var td_crit = $('<td />').text(item.criteria);
                    var td_status = $('<td />').text(combineStatus);
                    var td_note = $('<td />').text(item.Note);
                    var td_date = $('<td />').text(item.CreateDate);
                    var td_user = $('<td />').text(item.CreateUser);
                    var trow = $('<tr></tr>').append(td_id, td_gr, td_crit, td_status, td_note, td_date, td_user);
//                trow.attr('onclick', "onRowClick(" + item.id + ")");
                    $('#section3Body').append(trow);
                });
            }
        });
    } else {
        alert("აირჩიეთ ტექნიკის ტიპი, ბრენდი, მოდელი");
    }

});

$(document).ready(function () {
    console.log("ready!");
    loadTypesList(0, 'seltypename_id');
});

