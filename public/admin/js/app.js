jQuery(function ($) {
    const alerts = $(".alert.alert-dismissable");
    alerts.addClass('show');

    setTimeout(function() {
        alerts.removeClass('show');
    }, 9000);

    let imagefile = $('input[type="file"]');
    let $img = $('<img id="img-preview" src="#"> class="img-responsive"');

    imagefile.change(function(){
        $('.preview-container').html($img);
        readURL(this, '#img-preview');
    });

    function readURL(input, src) {
        if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function(e) {
            $(src).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        }
    }
});