$(function(){
    $( "#datepicker1" ).datepicker();
    $( "#datepicker1" ).datepicker( "option", "dateFormat", "yy/mm/dd" );
    $( "#datepicker1" ).datepicker("setDate", $( "#datepicker1").attr('value'));

    $( "#datepicker2" ).datepicker();
    $( "#datepicker2" ).datepicker( "option", "dateFormat", "yy/mm/dd" );
    $( "#datepicker2" ).datepicker("setDate", $( "#datepicker2").attr('value'));

    $( "#datepicker3" ).datepicker();
    $( "#datepicker3" ).datepicker( "option", "dateFormat", "yy/mm/dd" );
    $( "#datepicker3" ).datepicker("setDate", $( "#datepicker1").attr('value'));

    $( "#datepicker4" ).datepicker();
    $( "#datepicker4" ).datepicker( "option", "dateFormat", "yy/mm/dd" );
    $( "#datepicker4" ).datepicker("setDate", $( "#datepicker2").attr('value'));

    $('#act').click(function () {
        var val = false;
        if ($(this).prop('checked')) {
            val = true;
        }
        $('.ids').prop('checked', val);
    });

});
