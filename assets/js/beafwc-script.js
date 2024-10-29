/*
 * Metabox tab script
 */
function beafwc_option_tab(evt, cityName) {
    var i, beafwc_tabcontent, beafwc_tablinks;
    beafwc_tabcontent = document.getElementsByClassName("beafwc-tabcontent");
    for (i = 0; i < beafwc_tabcontent.length; i++) {
        beafwc_tabcontent[i].style.display = "none";
    }
    beafwc_tablinks = document.getElementsByClassName("beafwc-tablinks");
    for (i = 0; i < beafwc_tablinks.length; i++) {
        beafwc_tablinks[i].className = beafwc_tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

/*
Conditional fields
*/
function beafwc_before_after_method_conditional_field() {
    var beafwc_before_after_method = jQuery('input:radio[name=beafwc_before_after_method]:checked').val();
    if (beafwc_before_after_method == 'method_2') {
        jQuery('.beafwc-row-before-image, .beafwc-row-after-image').hide();
        jQuery('.beafwc-row-before-after-image, .beafwc_filter_style, .beafwc_filter_apply').show();
    } else {
        jQuery('.beafwc-row-before-image, .beafwc-row-after-image').show();
        jQuery('.beafwc-row-before-after-image, .beafwc_filter_style, .beafwc_filter_apply').hide();
    }
}

function beafwc_auto_slide_conditional_field() {
    var beafwc_auto_slide = jQuery('input:radio[name=beafwc_auto_slide]:checked').val();
    if (beafwc_auto_slide == 'true') {
        jQuery('.beafwc_move_slider_on_hover').hide();
        jQuery('.beafwc_slide_handle').show();
        jQuery('.beafwc_on_scroll_slide').hide();
    } else {
        jQuery('.beafwc_move_slider_on_hover').show();
        jQuery('.beafwc_slide_handle').hide();
        jQuery('.beafwc_on_scroll_slide').show();
    }

}

function beafwc_on_scroll_slide_conditional_field() {
    var beafwc_on_scroll_slide = jQuery('input:radio[name=beafwc_on_scroll_slide]:checked').val();
    var beafwc_auto_slide = jQuery('input:radio[name=beafwc_auto_slide]:checked').val();

    if (beafwc_on_scroll_slide == 'true' || beafwc_auto_slide == 'true') {
        jQuery('.beafwc_default_offset_row').hide();
    } else {
        jQuery('.beafwc_default_offset_row').show();
    }

}

function beafwc_readmore_alignment_field() {
    var beafwc_width = jQuery('#beafwc_slider_info_readmore_button_width option:selected').val();
    if (beafwc_width == 'full-width') {
        jQuery('.beafwc_slider_info_readmore_alignment').hide();
    } else {
        jQuery('.beafwc_slider_info_readmore_alignment').show();
    }
}

//label outside image condtional display
function beafwc_label_outside_conditional_display() {
    var beafwc_label_outside_option = jQuery('input:radio[name=beafwc_image_styles]:checked').val();
    if (beafwc_label_outside_option == 'vertical') {
        jQuery('.beafwc_label_outside').show();
    } else {
        jQuery('.beafwc_label_outside').hide();
    }
}

jQuery('input:radio[name=beafwc_image_styles]').on('change', function () {
    beafwc_label_outside_conditional_display();
});

jQuery(document).ready(function () {
    beafwc_before_after_method_conditional_field();
    beafwc_on_scroll_slide_conditional_field();
    beafwc_auto_slide_conditional_field();
    beafwc_readmore_alignment_field();
    beafwc_label_outside_conditional_display();
});

jQuery('input:radio[name=beafwc_before_after_method]').on('change', function () {
    beafwc_before_after_method_conditional_field();
});

jQuery('input:radio[name=beafwc_on_scroll_slide]').on('change', function () {
    beafwc_on_scroll_slide_conditional_field();
});

jQuery('input:radio[name=beafwc_auto_slide]').on('change', function () {
    beafwc_auto_slide_conditional_field();
    beafwc_on_scroll_slide_conditional_field();
});


jQuery('#beafwc_slider_info_readmore_button_width').on('change', function () {
    beafwc_readmore_alignment_field();
});

// Uploading files
var beafwc_before_file_frame;
jQuery('#beafwc_before_image_upload').on('click', function (e) {
    e.preventDefault();

    // If the media frame already exists, reopen it.
    if (beafwc_before_file_frame) {
        beafwc_before_file_frame.open();
        return;
    }

    // Create the media frame.
    beafwc_before_file_frame = wp.media.frames.beafwc_before_file_frame = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        multiple: false // Set to true to allow multiple files to be selected
    });

    // When a file is selected, run a callback.
    beafwc_before_file_frame.on('select', function () {
        // We set multiple to false so only get one image from the uploader
        attachment = beafwc_before_file_frame.state().get('selection').first().toJSON();

        var url = attachment.url;

        //var field = document.getElementById("podcast_file");
        var field = document.getElementById('beafwc_before_image');
        var thumbnail = document.getElementById('beafwc_before_image_thumbnail');

        field.value = url;
        thumbnail.setAttribute('src', url);
    });

    // Finally, open the modal
    beafwc_before_file_frame.open();
});


var beafwc_after_file_frame;
jQuery('#beafwc_after_image_upload').on('click', function (e) {
    e.preventDefault();

    // If the media frame already exists, reopen it.
    if (beafwc_after_file_frame) {
        beafwc_after_file_frame.open();
        return;
    }

    // Create the media frame.
    beafwc_after_file_frame = wp.media.frames.beafwc_after_file_frame = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        multiple: false // Set to true to allow multiple files to be selected
    });

    // When a file is selected, run a callback.
    beafwc_after_file_frame.on('select', function () {
        // We set multiple to false so only get one image from the uploader
        attachment = beafwc_after_file_frame.state().get('selection').first().toJSON();

        var url = attachment.url;

        var field = document.getElementById('beafwc_after_image');
        var thumbnail = document.getElementById('beafwc_after_image_thumbnail');

        field.value = url;
        thumbnail.setAttribute('src', url);
    });

    // Finally, open the modal
    beafwc_after_file_frame.open();
});

/*
Color picker
*/
jQuery('.beafwc-color-field').each(function () {
    jQuery(this).wpColorPicker();
});

/*
* Shortcode generator
*/
jQuery('#beafwc_gallery_generator #beafwc_gallery_shortcode_generator').on('click', function () {
    var cata_field = jQuery('#beafwc_gallery_generator #beafwc_gallery_cata');
    var cata_id = cata_field.val();
    var items_field = jQuery('#beafwc_gallery_generator #beafwc_gallery_item');
    var info_val = jQuery('#beafwc_gallery_generator #beafwc_gallery_info');
    var items = items_field.val();

    if (cata_id == '') {
        cata_field.css('border-color', 'red');
        return;
    } else {
        cata_field.css('border-color', '#ccc');
    }

    if (items != '' && isNaN(items)) {
        items_field.css('border-color', 'red');
        return;
    } else {
        items_field.css('border-color', '#ccc');
    }

    var column = jQuery('#beafwc_gallery_generator #beafwc_gallery_column').val();

    var max_items = '';
    if (items != '') {
        var max_items = ' items=' + items + '';
    }

    var slider_info = '';
    if (info_val.is(":checked")) {
        var slider_info = ' info=true';
    }

    var beafwc_shortcode = '[beafwc_gallery category=' + cata_id + ' column=' + column + '' + max_items + '' + slider_info + ']';
    jQuery('#beafwc_gallery_generator #beafwc_gallery_shortcode').val(beafwc_shortcode).focus();

});

/*
* Copy gallery shortcode
*/
jQuery('#beafwc_gallery_generator #beafwc_gallery_shortcode').on('click', function () {

    var copyText = document.getElementById("beafwc_gallery_shortcode");

    if (copyText.value != '') {
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");

        var elem = document.getElementById("beafwc_gallery_shortcode_copy_alert");
        elem.style.right = '0px';

        var time = 0;
        var id = setInterval(copyAlert, 10);

        function copyAlert() {
            if (time == 50) {
                clearInterval(id);
                elem.style.display = 'none';
            } else {
                time++;
                elem.style.display = 'flex';
            }
        }
    }

});

/*
beafwc style 7
*/
function bagf_style_7() {
    if (jQuery('#beafwc_before_after_style').val() == 'design-7') {
        jQuery('#beafwc_image_styles1').removeAttr('checked').parent().disabled;
        jQuery('#beafwc_image_styles1').attr('disabled', true);
        jQuery('#beafwc_image_styles2').attr('checked', 'checked');
        jQuery('label[for="beafwc_image_styles2"]').trigger('click');
    } else {
        jQuery('#beafwc_image_styles1').attr('disabled', false);
    }
}
bagf_style_7();

jQuery('#beafwc_before_after_style').on('change', function () {
    bagf_style_7();
});


//hide pro in free version
//jQuery('.beafwc-tooltip').closest('tr').hide();

