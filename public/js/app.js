
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

    const snackbar = $("#snackbar");
    snackbar.addClass("show");
    setTimeout(function() {
        snackbar.removeClass("show");
    }, 7000);

    const ratio = .7;
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: ratio
    };

    const handleIntersect = (entries, observer) => {
        entries.forEach(entry => {
            if(entry.intersectionRatio > ratio) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    };

    const observer = new IntersectionObserver(handleIntersect, options);
    document.querySelectorAll('[class*="reveal-"]').forEach(r => {
        observer.observe(r);
    });
});
