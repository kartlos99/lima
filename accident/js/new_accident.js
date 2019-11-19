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

function fillCaseForm(caseData) {
    $('#caseN').text('case_N ' + caseData.ID + " " + caseData.CreateDate);
    $('#currOwner').text(caseData.ownerName);
    $('#caseID').val(caseData.ID);
    $('#ownerID').val(caseData.OwnerID);

    $('#case_status_id').val(caseData.StatusID);
    $('#case_stage_id').val(caseData.StageID);
    $('#instance_id').val(caseData.InstanceID);
    $('#time_of_begin_id').val(caseData.ReceiveDate);
    $('#get_started_date_id').val(caseData.OwnDate);
    $('#time_of_distribution_id').val(caseData.DistrDate);
    $('#time_of_finish_id').val(caseData.CloseDate);
    $('#agreement_N_id').val(caseData.AgrNumber);
    $('#date_of_decoration_id').val(caseData.AgrDate);
    $('#loan_type_id').val(caseData.AgrLoanType);
    $('#organization_id').val(caseData.AgrOrgID);
    loadBranches(caseData.AgrOrgID, caseData.AgrOrgBranchID, 'filial_id');
    $('#client_name_id').val(caseData.DebFirstName);
    $('#client_N_id').val(caseData.DebPrivateNumber);
    $('#client_address_id').val(caseData.DebAddress);

    $('#enf_status_enf_id').val(caseData.ExecStatusID);
    $('#enf_request_time_enf_id').val(caseData.ExecReqDate);
    $('#enf_take_time_enf_id').val(caseData.ExecGetDate);
    $('#enf_start_time_enf_id').val(caseData.ExecProcessDate);
    $('#enf_result_enf_id').val(caseData.ExecResultID);
    $('#enf_amount_enf_id').val(caseData.ExecMoney);

    $('#baj_status_baj_id').val(caseData.DutyStatusID);
    $('#baj_request_time_baj_id').val(caseData.DutyReqDate);
    $('#baj_take_time_baj_id').val(caseData.DutyGetDate);
    $('#baj_result_baj_id').val(caseData.DutyResultID);
    $('#baj_amount_baj_id').val(caseData.DutyMoney);

    $('#settle_status_settle_id').val(caseData.SettStatusID);
    $('#settle_start_time_settle_id').val(caseData.SettStartDate);
    $('#settle_time_settle_id').val(caseData.SettDate);
    $('#settle_result_settle_id').val(caseData.SettResultID);
    $('#settle_currency_settle_id').val(caseData.SettCurID);
    $('#settle_footer_settle_id').val(caseData.Settbase);
    $('#settle_percent_settle_id').val(caseData.SettPercent);
    $('#settle_puncture_settle_id').val(caseData.SettPenalty);
    $('#settle_costs_settle_id').val(caseData.SettCost);

    $('#case_note_id').val(caseData.caseNote);

}

function fillInstanceForm(instance) {
    var i = instance.TypesID;
//    console.log(instance.TypesID, instance);
    $('#i' + i + '_ID').val(instance.ID);

    $('#i' + i + '_judicial_type_i' + i + '_id').val(instance.JudicialentityTypeID);
    $('#i' + i + '_judicial_name_i' + i + '_id').val(instance.JudicialentityD);
    $('#i' + i + '_currency_i' + i + '_id').val(instance.ClaimCurID);
    $('#i' + i + '_footer_i' + i + '_id').val(instance.Claimbase);
    $('#i' + i + '_percent_i' + i + '_id').val(instance.ClaimPercent);
    $('#i' + i + '_puncture_i' + i + '_id').val(instance.ClaimPenalty);
    $('#i' + i + '_costs_i' + i + '_id').val(instance.ClaimCost);
    $('#i' + i + '_baj_i' + i + '_id').val(instance.ClaimDuty);
    $('#i' + i + '_request_add_info_i' + i + '_id').val(instance.ClaimNotice);

    $('#i' + i + '_put_suit_i' + i + '_idSelPutSuit').val(instance.ClaimdeliveryStatus);
    $('#i' + i + '_suit_put_date_i' + i + '_id').val(instance.ClaimdeliveryDate);
    $('#i' + i + '_el_code_user_i' + i + '_id').val(instance.ClaimSysUserName);
    $('#i' + i + '_el_code_pass_i' + i + '_id').val(instance.ClaimSysPassword);

    $('#i' + i + '_take_suit_i' + i + '_idSelTakeSuit').val(instance.ClaimProceeedID);
    $('#i' + i + '_suit_take_date_i' + i + '_id').val(instance.ClaimProceeedDate);
    $('#i' + i + '_judge_name_i' + i + '_id').val(instance.ClaimJudgeName);
    $('#i' + i + '_assistant_name_i' + i + '_id').val(instance.ClaimJudgeAssistant);
    $('#i' + i + '_contact_info_i' + i + '_id').val(instance.ClaimJudgePhone);

    $('#i' + i + '_client_put_suit_i' + i + '_idSelClientPutSuit').val(instance.CltoPerDeliveryStatus);
    $('#i' + i + '_suit_put_type_i' + i + '_id').val(instance.CltoPerDeliveryMethod);
    $('#i' + i + '_suit_client_put_date_i' + i + '_id').val(instance.CltoPerDeliveryDate);
    $('#i' + i + '_suit_send_time1_i' + i + '_id').val(instance.CltoPerFirstSentDate);
    $('#i' + i + '_suit_send_result1_i' + i + '_id').val(instance.CltoPerFirstSentResult);
    $('#i' + i + '_suit_send_time2_i' + i + '_id').val(instance.CltoPerSecondSentDate);
    $('#i' + i + '_suit_send_result2_i' + i + '_id').val(instance.CltoPerSecondSentResult);
    $('#i' + i + '_suit_put_result_i' + i + '_id').val(instance.CltoPerStandardSentResult);
    $('#i' + i + '_judge_notice_date_i' + i + '_id').val(instance.CltoPerDeliveryToCourtDate);
    $('#i' + i + '_public_put_date_i' + i + '_id').val(instance.CltoPerPublicDeliveryReqDate);
    $('#i' + i + '_public_put_reminder_i' + i + '_id').attr("checked", instance.CltoPerPublicRemainder == 1);
    $('#i' + i + '_idcltoPerPublicRemainderStartDate').val(instance.CltoPerPublicRemainderStartDate);
    $('#i' + i + '_idcltoPerPublicRemainderEndDate').val(instance.CltoPerPublicRemainderEndDate);

    $('#i' + i + '_response_status_i' + i + '_id').val(instance.ClaimContStatusID);
    $('#i' + i + '_response_date_i' + i + '_id').val(instance.ClaimContPresDate);

    $('#i' + i + '_court_status_i' + i + '_idCourtStatus').val(instance.CourtProcessStatusID);
    $('#i' + i + '_court_mark_date_i' + i + '_id').val(instance.CourtProcessPreDate);
    $('#i' + i + '_court_mark_comment_i' + i + '_id').val(instance.CourtProcessComment);
    $('#i' + i + '_court_date_i' + i + '_id').val(instance.CourtProcessDate);
    $('#i' + i + '_court_hearing_reminder_i' + i + '_id').attr("checked", instance.CourtProcessRemainder == 1);
    $('#i' + i + '_idCourtProcessRemainderStartDate').val(instance.CourtProcessRemainderStartDate);
    $('#i' + i + '_idCourtProcessRemainderEndDate').val(instance.CourtProcessRemainderEndDate);

    $('#i' + i + '_court_decision_reminder_i' + i + '_id').attr("checked", instance.CourtDecRemainder == 1);
    $('#i' + i + '_idCourtDecRemainderStartDate').val(instance.CourtDecRemainderStartDate);
    $('#i' + i + '_idCourtDecRemainderEndDate').val(instance.CourtDecRemainderEndDate);
    $('#i' + i + '_decision_type_i' + i + '_id').val(instance.CourtDecTypeID);
    $('#i' + i + '_decision_take_date_i' + i + '_id').val(instance.CourtDecDate);
    $('#i' + i + '_decision_take_effect_date_i' + i + '_id').val(instance.CourtDecActDate);
    $('#i' + i + '_decision_currency_i' + i + '_id').val(instance.CourtDecResCurID);
    $('#i' + i + '_decision_footer_i' + i + '_id').val(instance.CourtDecResBase);
    $('#i' + i + '_decision_percent_i' + i + '_id').val(instance.CourtDecResPercent);
    $('#i' + i + '_decision_puncture_i' + i + '_id').val(instance.CourtDecResPenalty);
    $('#i' + i + '_decision_costs_i' + i + '_id').val(instance.CourtDecResCost);
    $('#i' + i + '_additional_info_i' + i + '_id').val(instance.Notice);

    theAccidentObj.instBefore[i] = $('#i' + i + '_form').serialize();
}

function getCaseData(id) {
    $.ajax({
        url: 'php_code/get_case_data.php',
        method: 'get',
        data: 'id=' + id,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.case != undefined) {
//                console.log(response.case);
                fillCaseForm(response.case);
                response.instances.forEach(function (instance) {
                    fillInstanceForm(instance);
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
    theAccidentObj.instBefore[1] = $('#i1_form').serialize();
    theAccidentObj.instBefore[2] = $('#i2_form').serialize();
    theAccidentObj.instBefore[3] = $('#i3_form').serialize();
    console.log(theAccidentObj);

    if (theAccidentObj.id == 0 || theAccidentObj.id == "") {
        $('#ownerID').val($('#userID').val());
        $('#currOwner').text($('#loged_username').text());
    } else {
        // redaqtirebis rejimi, wamvigot sachiro saqme da avsaxot gverdze
        getCaseData(theAccidentObj.id);
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
                theAccidentObj.id = response.caseID;
                getCaseData(response.caseID);
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
                getCaseData(theAccidentObj.id);
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