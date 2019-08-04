
$(document).ready(function() {
    new WOW().init();

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $( "#birthDate" ).datepicker( $.datepicker.regional[ "fr" ] );
    $( "#birthDate" ).datepicker({
        changeMonth: true,
        changeYear: true,
        showAnim: 'slideDown',
        maxDate: '-12Y'
    });
});
