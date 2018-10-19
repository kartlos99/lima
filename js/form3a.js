$('#agr_history').hide();

$('#btn_edit_f31').attr('disabled', true);
limited = true;

function f32edit() {

    $('#d_f324').find('button').attr('disabled', false);
    $('#btn_edit_f32').attr('disabled', true);

    $('#sel_status_f32').attr('disabled', false);
    $('#comment_f324').attr('readonly', false);

    screenLockChange();

};