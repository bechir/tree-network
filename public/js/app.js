
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

    const avatarInput = $('input[type="file"]');
    const img = `<img class="img-circle img-150" src="#">`;

    avatarInput.change(function(){
        $('.preview-container').html(img);
        readURL(this, '.avatar .img-preview img');
    });

    const galleryContainer = $('#gallery_gallery');
    let indexImage = galleryContainer.find('div').length;
    const addImageBtn = $('#add-images');

    addImageBtn.on('click', function (e) {
        addImage(galleryContainer);
        e.preventDefault();
        return false;
    });

    if (indexImage == 0)
        addImage(galleryContainer);
    else {
        galleryContainer.children('div').each(function () {
            addDeleteImageLink($(this))
        });
    }

    function addImage(container) {
        if(typeof container.attr('data-prototype') !== 'undefined') {
            const fileId = `gallery_gallery_${indexImage+1}_imageFile`;
            const img = $(`<img class="img-preview ${fileId}_preview">`);

            var prototype = $(container
                .attr('data-prototype')
                .replace(/<label class="required">__name__label__<\/label>/g, `<label for="${fileId}" class="file-label text-center aqua-gradient rounded text-white"><i class="fa fa-download"></i> Uploader</label>`)
                .replace(/__name__/g, `${(indexImage + 1)}`)
            );
            addDeleteImageLink(prototype);

            img.insertBefore(prototype.find('label'));
    
            prototype.addClass('col-sm-3 mb-3 transition');
            galleryContainer.append(prototype);

            indexImage++;

            $('#' + fileId).change(function(){
                readURL(this, '.'+fileId+ '_preview');
            })
        }
    }
    
    function addDeleteImageLink(prototype) {
        const deleteLink = $(`<button class="btn delete-item text-danger"><i class="fas fa-trash"></i></button>`);
        const label = prototype.find('label');
        deleteLink.insertBefore(label);
    
        deleteLink.on('click', function (e) {
            prototype.hide('normal', function () {
                prototype.remove();
            })
            e.preventDefault();
            return false;
        }).hover(function () {
            prototype.addClass('bordered-red shadow');
        }, function () {
            prototype.removeClass('bordered-red shadow');
        })
    }

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
