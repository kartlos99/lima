function f_show(){};
function f_hide(){};

$('#paramLi').removeClass('alert-light').addClass('alert-info');
$('#msgdiv').hide();
$('#passsubmit').attr('disabled', true);

$('#pass').on('keyup',function (value) {
    var ps = $(this).val();
    var pass = sha256_digest(ps);
    $('#passHiden').val(pass);
    console.log(pass);
});
$('#pass1').on('keyup',function (value) {
    var ps = $(this).val();
    var pass = sha256_digest(ps);
     $('#passHiden1').val(pass);
 });
 $('#pass2').on('keyup',function (value) {
     var ps = $(this).val();
     var pass = sha256_digest(ps);
     $('#passHiden2').val(pass);
 });


 $('#pass1').on('blur', function(){
    var ps = $(this).val();
    if (validatepass(ps) != 0){
        $('#msgdiv').show();
        $('#passsubmit').attr('disabled',true);
    }else{
        $('#msgdiv').hide();
        $('#passsubmit').attr('disabled',false);
    }

 })

 function validatepass(pass){    
    if (!pass)
        return 1;

    if (pass.length < 8)
        return 8;

    var variations = {
        digits: /\d/.test(pass),
        lower: /[a-z]/.test(pass),
        upper: /[A-Z]/.test(pass),
        nonWords: /\W/.test(pass),
    }

    var cc = 0;
    for (var check in variations) {
        cc += (variations[check] == true) ? 0 : 1;
    }
    return cc;
 }