var personForm = $('#person_form');
var btnDone = $('#btnDone');
var personsTable = $('#tb_persons').find('tbody');
var pageNav = $('#my-pagination');
var btnStateSearch = $('#btnStateSearch');
var btnStateAdd = $('#btnStateAdd');

const states = {
    "insert": "ins",
    "edit": "edit",
    "search": "search"
};
var currState = states.insert;
const doneBtnText = {
    "search": "ძებნა",
    "save": "ჩაწერა"
};


$(function () {
    console.log('add_person_ready');
    getOrganizations('organization_id');
    loadBranches(0, 0, 'filial_id');

});

$('#organization_id').on('change', function () {
    loadBranches($('#organization_id').val(), 0, 'filial_id');
});

function markBtn(selectBtnID) {
    btnStateAdd.removeClass('btn-info');
    btnStateSearch.removeClass('btn-info');
    $('#' + selectBtnID).addClass('btn-info');
}

btnStateAdd.on('click', function (event) {
    // savePerson($('#person_form').serialize());
    // $('#personType_id').prop("selectedIndex", 0).val()
    // $('#status_id').prop("selectedIndex", 0).val();
    personForm.trigger('reset');
    currState = states.insert;
    btnDone.text(doneBtnText.save);
    personsTable.empty();
    markBtn('btnStateAdd');
});

btnStateSearch.on('click', function (event) {
    personForm.trigger('reset');
    $('#personType_id').val(0);
    $('#status_id').val(0);
    console.log(personForm.serialize());
    currState = states.search;
    btnDone.text(doneBtnText.search);
    personsTable.empty();
    markBtn('btnStateSearch');
});

btnDone.on('click', function (event) {
    event.preventDefault();
    var formData = personForm.serialize();
    console.log(formData);

    pageNav.empty();
    pageNav.removeData("twbs-pagination");
    pageNav.unbind("page");

    switch (currState) {
        case states.insert:
            savePerson(formData);
            break;
        case states.search:
            getPersons(formData);
            break;
    }
});

function savePerson(data) {
    console.log(data);
    $.ajax({
        url: 'php_code/ins_person.php',
        method: 'post',
        data: data,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.result == "success") {
                $('#person_form').trigger('reset');
                alert("saved!");
            }
        }
    });
}

function getPersons(querys) {
    $.ajax({
        url: 'php_code/get_person_list.php',
        method: 'post',
        data: querys,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            personsTable.empty();

            var itemCount = response.count[0];
            var pageCount = Math.ceil(itemCount.n / 20);
            var appdata = response.data;
//            $('#titleForAppTable').text("მოიძებნა " + itemCount.n + " ჩანაწერი, ლიმიტი 20");

            appdata.forEach(function (item) {
                var td_id = $('<td />').text(item.ID).addClass('equalsimbols');
                var td_name = $('<td />').text(item.FirstName + " " + item.LastName);
                var td_org = $('<td />').text(item.OrganizationName);
                var td_st = $('<td />').text(item.statusi);
                var td_type = $('<td />').text(item.tipi);

                var iconEdit = $('<i />').addClass("fas fa-edit fa-2x btn");
                iconEdit.attr('onclick', "onEditClick(" + item.ID + ")");
                var iconRemove = $('<i />').addClass("fas fa-times fa-2x btn");
                iconRemove.attr('onclick', "onRemoveClick(" + item.ID + ")");
                var td_btns = $('<td />').addClass("toright").append(iconEdit, iconRemove);

                var trow = $('<tr></tr>').append(td_id, td_name, td_org, td_type, td_st, td_btns);
                personsTable.append(trow);
            });

            if (pageCount > 0)
                pageNav.twbsPagination({
                    totalPages: pageCount,
                    visiblePages: 5,
                    first: 'პირველი',
                    last: 'ბოლო',
                    next: '>>',
                    prev: '<<',
                    onPageClick: function (event, page) {
                        if (page != $('#personsFormPageN').val()) {
                            $('#personsFormPageN').val(page);
                            getPersons(personForm.serialize());
                        }
                    }
                });
        }
    });
}

function onEditClick(pID) {
    console.log("edit " + pID)
}

function onRemoveClick(pID) {
    console.log("Rem " + pID)
}

// <i class="fas fa-edit fa-2x btn"></i>
// fas fa-times fa-2x btn