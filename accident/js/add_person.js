
$(function () {
    console.log('add_person_ready');
    getOrganizations('organization_id');
    loadBranches(0, 0, 'filial_id');

});

$('#organization_id').on('change', function () {
    loadBranches($('#organization_id').val(), 0, 'filial_id');
});

$('#btnSave').on('click', function (event) {
    event.preventDefault();
    savePerson($('#person_form').serialize());
});

function savePerson(data){
    console.log(data);
    $.ajax({
        url: 'php_code/ins_person.php',
        method: 'post',
        data: data,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.result == "success"){
                $('#person_form').trigger('reset');
                alert("saved!");
            }
        }
    });
}
