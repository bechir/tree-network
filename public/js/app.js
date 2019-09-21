
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

    const avatarInput = $('input#edit_profile_avatar_avatarFile');
    const img = `<img class="img-circle img-150" src="#">`;

    avatarInput.change(function(){
        $('.preview-container').html(img);
        readURL(this, '.avatar .img-preview img');
    });

    function readURL(input, src) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
            $(src).attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
    }
});
