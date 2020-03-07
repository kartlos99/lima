/**
 * Created by k.diakonidze on 10/10/19.
 */
var theAccidentObj = {
    instBefore: [],
    instAfter: []
};
var canEdit = ['StatusID_id', 'DurationDeys_id', 'DurationHours_id', 'SolveDate_id', 'SolveDateTime_id', 'solv_description_id'];
var accidentForm = $('#accident_form');
var guiltyPersonSelect = $('#guiltyPersonID_id');
var ulGuiltyPersons = $('#divGuiltyPersons ul');
var commentForm = $('#commentForm');
var commentTable = $('#tb_comment_list').find('tbody');
var currCommentsPageN = 0;
var commentsPageCount = 0;
var typeSelector = $('#TypeID_id');
var formIsBlocked = false;

function fillAccidentForm(aData) {
    if ($('#currusertype').data('ut') == 'monitoring' || $('#currusertype').data('ut') == 'im_owner_plus'){
        unBlockFormPart()
    }
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
    $('#DiscovererID_id').val(aData.DiscovererID).trigger('chosen:updated');
    $('#DiscoveryDate_id').val(aData.DiscoverDate);
    $('#DiscoveryDateTime_id').val(aData.DiscoverDateTime);
    // $('#guiltyPersonID_id').val(aData.DebFirstName);  damrRvevi pirebi box-shi

    $('#CategoryID_id').val(aData.CategoryID);
    $('#CategoryOther_id').val(aData.CategoryOther);
    console.log("Forma ivseba!!!");
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

    if (waitForDropdowns == 2 && $('#currusertype').data('ut') == 'performer')
        blockFormPart();
    if ($('#currusertype').data('ut') == 'monitoring' && $('#currusertype').data('userid') != aData.CreateUser){
        blockFormPart()
    }
    if ($('#currusertype').data('ut') == 'im_owner_plus' && $('#currusertype').data('userid') != aData.CreateUser){
        blockFormPart()
    }
    if ($('#currusertype').data('ut') == 'monitoring' || $('#currusertype').data('ut') == 'im_owner_plus'){
        blockTypeSelector();
    }
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
                if (categoryObj == undefined) {
                    waitingItem = response.accident;
                } else {
                    fillAccidentForm(response.accident);
                }

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
        // redaqtirebis rejimi, wamvigot sachiro monacemebi da avsaxot gverdze
        getAccidentData(theAccidentObj.id);
        currCommentsPageN = 1;
        getComments(theAccidentObj.id, currCommentsPageN)
    }
    if ($('#currusertype').data('ut') == 'im_owner')
        blockTypeSelector('type_standard');
    if ($('#currusertype').data('ut') == 'monitoring'){
        canEdit = [];
        if (theAccidentObj.id == 0){
            blockTypeSelector('type_monitoring');
        }else {
            blockFormPart();
        }
    }
    if ($('#currusertype').data('ut') == 'im_owner_plus'){
        canEdit = [];
        if (theAccidentObj.id == 0){
            blockTypeSelector('type_standard');
        }else {
            blockFormPart();
        }
    }

    $('#DiscovererID_id').addClass("chosen").chosen();
    $('#guiltyPersonID_id').addClass("chosen").chosen();
    $("<br/>").insertAfter("#DiscovererID_id");
    $("<br/>").insertAfter("#guiltyPersonID_id");
});

function blockFormPart() {
    accidentForm.find('input').each(function (value) {
        if (!canEdit.includes($(this).attr('id'))) {
            $(this).attr('readonly', true);
        }
    });
    accidentForm.find('textarea').each(function (value) {
        if (!canEdit.includes($(this).attr('id'))) {
            $(this).attr('disabled', true);
        }
    });
    accidentForm.find('select').each(function (value) {
        if (!canEdit.includes($(this).attr('id'))) {
            $(this).find('option').attr('disabled', true);
            $(this).attr('readonly', true);
        }
    });
    $('#NotInStatistics_id').attr('disabled', true);
    $('#DiscovererID_id').prop('disabled', true).trigger("chosen:updated");
    $('#guiltyPersonID_id').prop('disabled', true).trigger("chosen:updated");
    formIsBlocked = true
}

function unBlockFormPart() {
    accidentForm.find('input').each(function (value) {
        if (!canEdit.includes($(this).attr('id'))) {
            $(this).removeAttr('readonly');
        }
    });
    accidentForm.find('textarea').each(function (value) {
        if (!canEdit.includes($(this).attr('id'))) {
            $(this).removeAttr('disabled');
        }
    });
    accidentForm.find('select').each(function (value) {
        if (!canEdit.includes($(this).attr('id'))) {
            $(this).find('option').removeAttr('disabled');
            $(this).removeAttr('readonly');
        }
    });
    $('#NotInStatistics_id').removeAttr('disabled');
    $('#DiscovererID_id').prop('disabled', false).trigger("chosen:updated");
    $('#guiltyPersonID_id').prop('disabled', false).trigger("chosen:updated");
    formIsBlocked = false
}

function blockTypeSelector(typeCode = "") {
    if (typeCode != ""){
        var id = typeSelector.find("option[data-code='" + typeCode + "']").val();
        typeSelector.val(id);
    }
    typeSelector.find('option').attr('disabled', true);
    typeSelector.attr('readonly', true);
}

function unBlockTypeSelector() {
    typeSelector.find('option').removeAttr('disabled');
    typeSelector.removeAttr('readonly');
}

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
            newLi.fadeOut(1);
            ulGuiltyPersons.append(newLi);
            ulGuiltyPersons.find("li:last").fadeIn(300);
        } else {
            console.log("alredi in list");
        }
    }

});

ulGuiltyPersons.on('click', 'li.guilty-item i', function (it) {
    if (!formIsBlocked){
        console.log($(this).closest('li').html());
        var li = $(this).closest('li');
        li.fadeOut(300);
        setTimeout(function () {
            li.remove();
        }, 300);
    }
});

$('#btnSave').on('click', function (event) {
    event.preventDefault();
    var formIsValid = true;
    if ($('#currusertype').data('ut') == 'im_owner_plus') {
        unBlockTypeSelector();
    }
    if ($('#currusertype').data('ut') == 'im_owner') {
        unBlockTypeSelector();
        unBlockOrgSelector();
        unBlockFilialSelector();
    }
    if ($('#currusertype').data('ut') == 'performer') {
        unBlockFormPart()
    }
    if ($('#currusertype').data('ut') == 'monitoring') {
        unBlockTypeSelector()
    }

    var sendData = accidentForm.serialize();
    console.log(sendData);

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

    if ($('#currusertype').data('ut') == 'im_owner') {
        blockTypeSelector();
        blockOrgSelector();
        blockFilialSelector();
    }
    if ($('#currusertype').data('ut') == 'performer') {
        blockFormPart()
    }
    if ($('#currusertype').data('ut') == 'monitoring') {
        blockTypeSelector()
    }
    if ($('#currusertype').data('ut') == 'im_owner_plus') {
        blockTypeSelector()
    }

    if (formIsValid) {
        saveAccidentRequest(sendData);
        console.log("form IS valid");
    } else {
        alert("გთხოვთ, შეავსოთ სავალდებულო რეკვიზიტები ☹");
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

$('#btnSaveComment').on('click', function (event) {
    event.preventDefault();
    if ($('#recID').val() != 0) {
        if (commentForm.find('textarea').val() != '') {
            $('#commentForRecID').val($('#recID').val());
            currCommentsPageN = 1;
            saveComment(commentForm.serialize());
            $('#btnCommentNextPage').show();
        }
    } else {
        alert('ინციდენტი არაა შენახული!');
    }
});

$('#btnCommentNextPage').on('click', function (event) {
    currCommentsPageN++;
    getComments($('#recID').val(), currCommentsPageN);
    if (currCommentsPageN == commentsPageCount) {
        $('#btnCommentNextPage').hide();
    }
});

function saveComment(commData) {
    commentTable.empty();
    $.ajax({
        url: 'php_code/ins_comment.php',
        method: 'post',
        data: commData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.result == "success") {
                getComments($('#recID').val(), currCommentsPageN);
                commentForm.find('textarea').val('');
            } else {
                console.log(response.error);
            }
        }
    });
}

function getComments(imID, pageN) {
    var sendObj = {
        'recID': imID,
        'pageN': pageN
    };
    $.ajax({
        url: 'php_code/get_comments.php',
        method: 'post',
        data: sendObj,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            fillcommentsTable(response.data);

            var itemCount = response.count;
            commentsPageCount = Math.ceil(itemCount / 10);
            console.log('commentsPageCount ' + commentsPageCount);
            if (commentsPageCount == 1) {
                $('#btnCommentNextPage').hide();
            }
        }
    });
}

function fillcommentsTable(comments) {
    comments.forEach(function (item) {
        var td_id = $('<td />').text(item.ID).addClass('equalsimbols');
        var td_comm = $('<td />').text(item.Comment);
        var td_date = $('<td />').text(item.dro);
        var td_user = $('<td />').text(item.UserName);

        var trow = $('<tr></tr>').append(td_id, td_comm, td_user, td_date);

        commentTable.append(trow);
    });
}