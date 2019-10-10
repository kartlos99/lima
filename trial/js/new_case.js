/**
 * Created by k.diakonidze on 10/10/19.
 */

$(function(){
   console.log('sdsdsd');
});

$('#btnSaveCase').on('click', function(){
    console.log($('#caseform').serialize());
});