var secInDay = 86400;

function f_show(){};
function f_hide(){};

$('#paramLi').removeClass('alert-light').addClass('alert-info');
$('#msgdiv').hide();
$('#passsubmit').attr('disabled', true);

$('#pass').on('keyup',function (value) {
    var ps = $(this).val();
    var pass = sha256_digest(ps);
    $('#passHiden').val(pass);    
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

 getparamiters();

 function getparamiters(){
    var data = {'io':'get'};
    $.ajax({
        url: '../php_code/ioparameters.php',
        method: 'post',
        data: data,
        dataType: 'json',
        success: function (response) {
            // console.log(response);
            $('#userpassduration').val(response.userpassduration/secInDay);
            $('#applReservPeriod').val(response.reserv_period/secInDay);
            for(var cvla_i in response.cvlebi){
                $('#inp_cvla'+cvla_i).val(response.cvlebi[cvla_i]);
            }
        }
    });
 }

 $('#btn_saveuserpass').on('click',function(){
    var data = {'userpassduration':$('#userpassduration').val()*86400};
    $.ajax({
        url: '../php_code/ioparameters.php',
        method: 'post',
        data: data,
        dataType: 'json',
        success: function (response) {
            // console.log(response);
            if (response == "ok"){
                alert ("saved");
            }            
        }
    });
 })

 $('#btn_savereservperion').on('click',function(){
    var data = {'reserv_period':$('#applReservPeriod').val()*86400};
    $.ajax({
        url: '../php_code/ioparameters.php',
        method: 'post',
        data: data,
        dataType: 'json',
        success: function (response) {
            // console.log(response);
            if (response == "ok"){
                alert ("saved");
            }            
        }
    });
 })

 $('#btn_save_cvlebi').on('click',function(){
    var arraydata = "";
    for (var i = 0; i < 4; i++){
        if ($('#inp_cvla'+i).val() == ""){
            $('#inp_cvla'+i).val(0);
        }
        arraydata += $('#inp_cvla'+i).val();
        if (i<3){
            arraydata += "|";
        }
    }
    var data = {'cvlebi': arraydata};
    $.ajax({
        url: '../php_code/ioparameters.php',
        method: 'post',
        data: data,
        dataType: 'json',
        success: function (response) {
            // console.log(response);
            if (response == "ok"){
                alert ("saved");
            }            
        }
    });
 })

 $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('.modal-body input').val(recipient)

    $('#passsubmit').val(modal.find('.modal-body textarea').val());
  })

  $('#btndone').on('click', function(){
    $('#passsubmit').val($('#message-text').val());
  })


  $('#myTab a').on('click', function (e) {
    e.preventDefault()
    $(this).tab('show')
  })