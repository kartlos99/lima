var secInDay = 86400;

$('#paramLi').removeClass('alert-light').addClass('alert-info');
$('#msgdiv').hide();
$('#passsubmit').attr('disabled', true);

$('#pass').on('keyup', function (value) {
    var ps = $(this).val();
    var pass = sha256_digest(ps);
    $('#passHiden').val(pass);
});
$('#pass1').on('keyup', function (value) {
    var ps = $(this).val();
    var pass = sha256_digest(ps);
    $('#passHiden1').val(pass);
});
$('#pass2').on('keyup', function (value) {
    var ps = $(this).val();
    var pass = sha256_digest(ps);
    $('#passHiden2').val(pass);
});


$('#pass1').on('blur', function () {
    var ps = $(this).val();
    if (validatepass(ps) != 0) {
        $('#msgdiv').show();
        $('#passsubmit').attr('disabled', true);
    } else {
        $('#msgdiv').hide();
        $('#passsubmit').attr('disabled', false);
    }
});

function validatepass(pass) {
    if (!pass)
        return 1;

    if (pass.length < 8)
        return 8;

    var variations = {
        digits: /\d/.test(pass),
        lower: /[a-z]/.test(pass),
        upper: /[A-Z]/.test(pass),
        nonWords: /\W/.test(pass),
    };

    var cc = 0;
    for (var check in variations) {
        cc += (variations[check] == true) ? 0 : 1;
    }
    return cc;
}

$(document).ready(function () {
    $('p').addClass('p-title');

    $.ajax({
        url: 'php_code/io_params.php',
        method: 'post',
        data: {'read': 1},
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.result == resultType.SUCCSES) {
                $('#criteriaExpirePeriod').val(response.data.ValueInt);
            }
        }
    });
});

$('#btnSaveNotinyPerion').on('click', function () {
    var newVal = $('#criteriaExpirePeriod').val();
    if (newVal == '') newVal = 0;

    var data = {'update': newVal};
    $.ajax({
        url: 'php_code/io_params.php',
        method: 'post',
        data: data,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.result == resultType.SUCCSES) {
                alert("saved");
            }
        }
    });
});


$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient);
    modal.find('.modal-body input').val(recipient);

    $('#passsubmit').val(modal.find('.modal-body textarea').val());
});

$('#btndone').on('click', function () {
    $('#passsubmit').val($('#message-text').val());
});


$('#myTab a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show')
});