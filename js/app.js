$(function () {
    /*
    |--------------------------------------------------------------------------
    | Photo Gallery Popup
    |--------------------------------------------------------------------------
    */
    $('.gallery').photobox('.photobox_a');
    /*
    |--------------------------------------------------------------------------
    | By YouYube URL
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '#upload_button_URL', function () {
        $("#upload_button_group").hide();
        $("#upload_form_url").show();
        $("#youtube_url").focus();
    });

    $(document).on('click', '#upload_button_URL_cancel', function () {
        $("#upload_button_group").show();
        $("#upload_form_url").hide();
    });


    $(document).on('click', '#upload_button_URL_save', function () {
        var youtube_id = validate_youtube_url($('#youtube_url').val());

        if (youtube_id) {
            var dataString = 'youtube_id=' + youtube_id;
            $.ajax({
                type: "POST",
                url: "media_upload.php",
                data: dataString,
                cache: false,
                dataType: 'JSON',
                success: function (obj) {
                    if (obj.status) {
                        var content = '<div class="col-lg-2 col-md-3 col-xs-6 gallery-block" data-media_guid="' + obj.media_GUID + '"><div class="gallery-block-inner"><a class="photobox_a" href="' + obj.youtube_url + '" rel="video"><img src="' + obj.image_small + '" class="img-responsive"></a></div><span class="media-name" contenteditable="true">' + obj.media_name_original + '</span></div>';
                        $("#gallery-block-loader").before(content);
                        $('#youtube_url').val('')
                        $("#gallery-empty").remove();
                    } else {
                        alert(obj.error);
                    }
                }
            });
        } else {
            alert("Invalid YouTube URL");
        }
    });
    /*
    |--------------------------------------------------------------------------
    | Upload Media
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '#upload_button', function () {
        $("#upload_media").click();
    });

    $(document).on('change', '#upload_media[type=file]', function () {
        var progressBar = $('#progressbar'),
                bar = $('.bar'),
                percent = $('#progressbar .percent');
        $("#gallery-block-loader").show();

        $('#upload_form').ajaxForm({
            beforeSend: function () {
                progressBar.fadeIn();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            success: function (obj, statusText, xhr, $form) {
                if (obj.status) {
                    var percentVal = '100%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                    progressBar.hide();
                    var content = '<div class="col-lg-2 col-md-3 col-xs-6 gallery-block" data-media_guid="' + obj.media_GUID + '"><div class="gallery-block-inner"><a class="photobox_a" href="' + obj.image_large + '"><img src="' + obj.image_small + '" class="img-responsive"></a></div><span class="media-name" contenteditable="true">' + obj.image_name_original + '</span></div>';
                    $("#gallery-block-loader").before(content);
                    $("#gallery-empty").remove();
                } else {
                    alert(obj.error);
                }
            },
            complete: function (xhr) {
                progressBar.fadeOut();
                $("#gallery-block-loader").hide();
                $('#upload_form').resetForm();
            }
        }).submit();
    });




    /*
    |--------------------------------------------------------------------------
    | Rename Media
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.media-name', function () {
        $(this).attr('contentEditable', true).focus();
    });
    $(document).on('blur', '.media-name', function () {
        var dataString = 'media_GUID=' + $(this).closest('.gallery-block').data("media_guid") + '&media_name_original=' + $(this).text();
        $.ajax({
            type: "POST",
            url: "media_upload.php",
            data: dataString,
            cache: false,
            dataType: 'JSON',
            success: function (html) {
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | YouTube URL Validation
    |--------------------------------------------------------------------------
    */
    function validate_youtube_url(url) {
        var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        return (url.match(p)) ? RegExp.$1 : false;
    }


});


