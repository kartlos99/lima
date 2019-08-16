







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




$(document).ready(function () {
    console.log("ready!");
    $('#typename_id').attr("data-nn", 0);
    $('#brandname_id').attr("data-nn", 1);
    $('#modelname_id').attr("data-nn", 2);
    loadTypesList(0, 'typename_id');
});