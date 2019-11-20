/**
 * Created by k.diakonidze on 10/10/19.
 */
var theAccidentObj = {
    instBefore: [],
    instAfter: []
};
var accidentForm = $('#accident_form');
var guiltyPersonSelect = $('#guiltyPersonID_id');
var ulGuiltyPersons = $('#divGuiltyPersons ul');

function fillAccidentForm(aData) {
    $('#caseN').text('case_N ' + aData.accidentN + " " + aData.CreateDate);
    $('#currOwner').text(aData.ownerName);
    $('#recID').val(aData.ID);
    // $('#ownerID').val(aData.OwnerID);

    $('#TypeID_id').val(aData.TypeID);
    $('#PriorityID_id').val(aData.PriorityID);
    $('#StatusID_id').val(aData.StatusID);
    $('#OwnerID_id').val(aData.OwnerID);

    $('#organization_id').val(aData.OrgID);
    loadBranches(aData.OrgID, aData.OrgBranchID, 'filial_id');
    $('#AgrNumber_id').val(aData.AgrNumber);

    $('#FactDate_id').val(aData.FactDate);
    $('#FactDateTime_id').val(aData.FactDateTime);
    $('#DiscovererID_id').val(aData.DiscovererID);
    $('#DiscoveryDate_id').val(aData.DiscoverDate);
    $('#DiscoveryDateTime_id').val(aData.DiscoverDateTime);
    // $('#guiltyPersonID_id').val(aData.DebFirstName);  damrRvevi pirebi box-shi

    $('#CategoryID_id').val(aData.CategoryID);
    $('#CategoryOther_id').val(aData.CategoryOther);

    loadSubCategory(aData.CategoryID, aData.SubCategoryID, 'SubCategoryID_id')
    $('#SubCategoryOther_id').val(aData.SubCategoryOther);

    // ulGuiltyPersons

    $('#accident_description_id').val(aData.RequetsDescription);

    $('#SolverID_id').val(aData.SolverID);
    $('#DurationDeys_id').val(aData.DurationDeys);
    $('#DurationHours_id').val(aData.DurationHours);
    $('#SolveDate_id').val(aData.SolveDate);
    $('#SolveDateTime_id').val(aData.SolveDateTime);

    $('#solv_description_id').val(aData.SolvDescription);

    $('#NotInStatistics_id').attr("checked", aData.NotInStatistics == 0);
}

function addgPerson(person) {

    var guiltyInp = $('<input />').val(person.IM_PersonsID).attr({
        "name": "guiltyPersonIDs[]",
        "type": "hidden"
    });
    var iIcon = $('<i />').addClass("fas fa-minus-circle fa-lg");
    var nameTag = $('<span />').text(person.gPersonName)
    var newLi = $('<li></li>').addClass("guilty-item").append(iIcon, nameTag, guiltyInp);
    ulGuiltyPersons.append(newLi);
}

function getAccidentData(id) {
    $.ajax({
        url: 'php_code/get_accident_data.php',
        method: 'get',
        data: 'id=' + id,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.accident != undefined) {
//                console.log(response.case);
                fillAccidentForm(response.accident);
                ulGuiltyPersons.empty();
                response.gPersons.forEach(function (gPerson) {
                    addgPerson(gPerson);
                });

            } else {
                console.log('case not found');
            }
        }
    });
}

$(function () {
    console.log('new_case_ready');
    getOrganizations('organization_id');
    loadBranches(0, 0, 'filial_id');
    getCategory('CategoryID_id');
    loadSubCategory(0, 0, 'SubCategoryID_id');
    theAccidentObj.id = getCookie("appID");
    console.log(theAccidentObj);
    $("input[type='time']").each(function () {
        $(this).val('00:00');
    });
    $('#OwnerID_id').val($('#userID').val());

    if (theAccidentObj.id == 0 || theAccidentObj.id == "") {
        $('#ownerID').val($('#userID').val());
        $('#currOwner').text($('#loged_username').text());
    } else {
        // redaqtirebis rejimi, wamvigot sachiro saqme da avsaxot gverdze
        getAccidentData(theAccidentObj.id);
    }
});

$('#addGuiltyPerson').on('click', function (event) {
    event.preventDefault();
    var exist = false;
    if (!guiltyPersonSelect.val() == '') {
        ulGuiltyPersons.find('input').each(function () {
            if ($(this).val() == guiltyPersonSelect.val())
                exist = true;
        });
        if (!exist) {
            var guiltyInp = $('<input />').val(guiltyPersonSelect.val()).attr({
                "name": "guiltyPersonIDs[]",
                "type": "hidden"
            });
            var iIcon = $('<i />').addClass("fas fa-minus-circle fa-lg");
            var nameTag = $('<span />').text(guiltyPersonSelect.find('option:selected').text())
            var newLi = $('<li></li>').addClass("guilty-item").append(iIcon, nameTag, guiltyInp);
            ulGuiltyPersons.append(newLi);
        } else {
            console.log("alredi in list");
        }
    }

});

ulGuiltyPersons.on('click', 'li.guilty-item i', function (it) {
    console.log($(this).closest('li').html());
    $(this).closest('li').remove();
});

$('#btnSave').on('click', function (event) {
    event.preventDefault();
    var formIsValid = true;

    var sendData = accidentForm.serialize();

    var recEl1 = $('select:required');
    var recEl2 = $('input:required');
    var recEl3 = $('textarea:required');
    recEl1.each(function (el) {
        console.log($(this));
        if (($(this).val() == null || $(this).val() === "") && formIsValid) {
            console.log($(this).val());
            formIsValid = false;
            $(this).focus();
        }
    });
    recEl2.each(function (el) {
        console.log($(this));
        if (($(this).val() == null || $(this).val() === "") && formIsValid) {
            console.log($(this).val());
            formIsValid = false;
            $(this).focus();
        }
    });
    recEl3.each(function (el) {
        console.log($(this));
        if (($(this).val() == null || $(this).val() === "") && formIsValid) {
            console.log($(this).val());
            formIsValid = false;
            $(this).focus();
        }
    });

    if (formIsValid) {
        saveAccidentRequest(sendData)
        console.log("form IS valid");
    } else {
        console.log("form not valid");
    }
});

function saveAccidentRequest(sendData) {
    $.ajax({
        url: 'php_code/ins_accident.php',
        method: 'post',
        data: sendData,
        dataType: 'json',
        success: function (response) {
            console.log(response);

            if (response.result == "success") {
                theAccidentObj.id = response.recID;
                getAccidentData(response.recID);
                alert("saved!");
            } else {
                console.log(response.error);
            }
        }
    });
}

$('#organization_id').on('change', function () {
    loadBranches($('#organization_id').val(), 0, 'filial_id');
});

$('#CategoryID_id').on('change', function () {
    loadSubCategory($('#CategoryID_id').val(), 0, 'SubCategoryID_id');
});

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

function f_hide() {
    document.cookie = "appID=0";
}

$('#btnUserCh').on('click', function () {
    if (theAccidentObj.id > 0) {
        $('#dialogUserChange').modal('show');
        $('#old_owner_D1').val($('#currOwner').text());
        $('#ownerID_old').val($('#ownerID').val());
        $('#d1_caseID').val(theAccidentObj.id);
    } else {
        alert("საქმე არაა შენახული!");
    }

});

$('#btnDoneD1').on('click', function () {
    var sendData = $('#userChForm').serialize();
    console.log(sendData);

    $.ajax({
        url: 'php_code/ins_userCh.php',
        method: 'post',
        data: sendData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.result == "success") {
                getAccidentData(theAccidentObj.id);
                alert("saved!");
            } else {
                console.log(response.error);
            }
        }
    });
});

$('#btnUserHist').on('click', function () {
    if (theAccidentObj.id > 0) {
        getHistList({'caseid': theAccidentObj.id});
        $('#histModalTiTle').text($('#caseN').text());
        $('#dialogUserHist').modal('show');
    } else {
        alert("საქმე არაა შენახული!");
    }

});

function getHistList(querys) {
    $.ajax({
        url: 'php_code/get_owner_hist.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {
            hTable = $('#tb_user_hist').find('tbody');
            hTable.empty();
            var appdata = response.data;

            appdata.forEach(function (item) {

                var td_id = $('<td />').text(item.ID).addClass('equalsimbols');
                var td_owner = $('<td />').text(item.owner);
                var td_tarigi = $('<td />').text(item.tarigi);
                var td_OwnChangeReason = $('<td />').text(item.OwnChangeReason);
                var td_op = $('<td />').text(item.op);

                var trow = $('<tr></tr>').append(td_id, td_owner, td_tarigi, td_OwnChangeReason, td_op);
                hTable.append(trow);
            });
        }
    });
}