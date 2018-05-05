$('#pan_f33').hide();
$('#f32_h1').hide();
$('#f32_h2').hide();

$('#btn_edit_f31').attr('disabled', true);
limited = true;

function f32edit() {

    $('#d_f324').find('button').attr('disabled', false);
    $('#btn_edit_f32').attr('disabled', true);

    // $('#pass_res_f32').attr('readonly', false);
    // $('#pass_enc_f32').attr('readonly', false);
    $('#sel_status_f32').attr('disabled', false);
    $('#comment_f324').attr('readonly', false);


    screenLockChange();

};