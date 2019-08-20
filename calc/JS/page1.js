/**
 * Created by k.diakonidze on 7/29/19.
 */
var organizationObj;



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

$('#type_id2').on('change', function () {
    techPosArray = [$('#type_id2').val(), "0", "0"];
    $('#brand_id2').empty();
    $('#model_id2').empty();
    if (techPosArray[0] != 0) {
        loadTypesList(techPosArray[0], 'brand_id2');
    }
    console.log(techPosArray);
});

$('#brand_id2').on('change', function () {
    techPosArray[1] = $('#brand_id2').val();
    techPosArray[2] = "0";
    $('#model_id2').empty();
    if (techPosArray[1] != 0) {
        loadTypesList(techPosArray[1], 'model_id2');
    }
    console.log(techPosArray);
});

$('#model_id2').on('change', function () {
    techPosArray[2] = $('#model_id2').val();
    console.log(techPosArray);
});



$(document).ready(function () {
    console.log("ready!");
    loadTypesList(0, 'type_id');
    loadTypesList(0, 'type_id2');

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