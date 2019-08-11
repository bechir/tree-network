
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

    var snackbar = $("#snackbar");
    snackbar.addClass("show");
    setTimeout(function() {
        snackbar.removeClass("show");
    }, 7000);
});
