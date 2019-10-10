
$(document).ready(function() {
    new WOW().init();

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('#navbarSupportedContent-332').on('show.bs.collapse', function(){
        $('#navbarSupportedContent-333').collapse('hide');
    });

    $('#navbarSupportedContent-333').on('show.bs.collapse', function(){
        $('#navbarSupportedContent-332').collapse('hide');
    });

    let modalId = $('#image-gallery');    
    loadGallery(true, 'a.thumbnail');

    //This function disables buttons when needed
    function disableButtons(counter_max, counter_current) {
        $('#show-previous-image, #show-next-image')
        .show();
        if (counter_max === counter_current) {
        $('#show-next-image')
            .hide();
        } else if (counter_current === 1) {
        $('#show-previous-image')
            .hide();
        }
    }

    /**
     *
     * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
     * @param setClickAttr  Sets the attribute for the click handler.
     */

    function loadGallery(setIDs, setClickAttr) {
        let current_image,
        selector,
        counter = 0;

        $('#show-next-image, #show-previous-image')
        .click(function () {
            if ($(this)
            .attr('id') === 'show-previous-image') {
            current_image--;
            } else {
            current_image++;
            }

            selector = $('[data-image-id="' + current_image + '"]');
            updateGallery(selector);
        });

        function updateGallery(selector) {
        let $sel = selector;
        current_image = $sel.data('image-id');
        $('#image-gallery-title')
            .text($sel.data('title'));
        $('#image-gallery-image')
            .attr('src', $sel.data('image'));
        disableButtons(counter, $sel.data('image-id'));
        }

        if (setIDs == true) {
        $('[data-image-id]')
            .each(function () {
            counter++;
            $(this)
                .attr('data-image-id', counter);
            });
        }
        $(setClickAttr)
        .on('click', function () {
            updateGallery($(this));
        });
    }

    // build key actions
    $(document)
      .keydown(function (e) {
        switch (e.which) {
          case 37: // left
            if ((modalId.data('bs.modal') || {})._isShown && $('#show-previous-image').is(":visible")) {
              $('#show-previous-image')
                .click();
            }
            break;
    
          case 39: // right
            if ((modalId.data('bs.modal') || {})._isShown && $('#show-next-image').is(":visible")) {
              $('#show-next-image')
                .click();
            }
            break;
    
          default:
            return; // exit this handler for other keys
        }
        e.preventDefault(); // prevent the default action (scroll / move caret)
    });    

    const snackbar = $("#snackbar");
    snackbar.addClass("show");
    setTimeout(function() {
        snackbar.removeClass("show");
    }, 7000);

    const ratio = .3;
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: ratio
    };

    //
    // SEARCH USER FORM
    //
    const formResuslts = $('#form-resuslts');
    const searchInput = $('input#search-user');
    let currentRequest = null;

    $(document).on('click', function(){
        formResuslts.fadeOut();
    });

    formResuslts.click(function(e){
        e.stopPropagation();
    })

    searchInput.on('keyup', function(){
        let value = searchInput.val();
        
        if(value.length >= 3) {
            currentRequest = $.ajax({
                type: "GET",
                dataType: "html",
                url: searchInput.data('url'),
                data: `terms=${value}`,

                beforeSend: function(){
                    if(currentRequest) {
                        currentRequest.abort();
                    }
                },
  
                success: function(data) {
                    formResuslts.html(data);
                },
  
                error: function(data) {
                    console.log(data)
                }
            });

            formResuslts.fadeIn();
        } else {
            formResuslts.fadeOut();
        }
    });

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
