var ThrivePostOptions = {};
var ThriveScPageOptions = {'current_input': 'thrive_shortcode_option_image'};
/*
 * Handles the logic for adding a shortcode in the editor (visual or text editor)
 */
var ThriveHandleAddShortcote = function (shortcode) {
    var renderOptionsUrl = ThriveAdminAjaxUrl + "?action=shortcode_display_options&sc=" + shortcode;
    switch (shortcode) {
        case 'ResponsiveVideo':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Accordion':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Headline':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'BlankSpace':
            var sc_text = "[blank_space height='3em']"; //or some default value
            send_to_editor(sc_text);
            break;
        case 'ContentContainer':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Button':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'ContentBox':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'CustomFont':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'FillCounter':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'NumberCounter':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'ProgressBar':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Borderless':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Code':
            ThriveGenerateCodeShortcode();
            break;
        case 'Countdown':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'DividerLine':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Highlight':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'HeadlineFocus':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'DropCaps':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'GMaps':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Tabs':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Toggle':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'PageSection':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Pullquote':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Optin':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'PostsList':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Phone':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'CustomMenu':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'CustomBox':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'PostsGallery':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'VideoSection':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Testimonal':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'FollowMe':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Grid':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'Price':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'SplitButton':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'MegaButton':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        case 'IconBox':
            tb_show('Edit shortcode options', renderOptionsUrl);
            break;
        default:
            ThriveGenerateColumnShortcode(shortcode);
            break;
    }
};

var ThriveGenerateColumnShortcode = function (shortcode) {
    var type = shortcode.toLowerCase();
    var sc_text = "[one_half]YourContentHere[/one_half]";
    sc_text += "[one_half_last]YourContentHere[/one_half_last]";

    switch (type) {
        case 'columns-1-2':
            sc_text = "[one_half_first]YourContentHere[/one_half_first]";
            sc_text += "[one_half_last]YourContentHere[/one_half_last]";
            break;
        case 'columns-1-3':
            sc_text = "[one_third_first]YourContentHere[/one_third_first]";
            sc_text += "[one_third]YourContentHere[/one_third]";
            sc_text += "[one_third_last]YourContentHere[/one_third_last]";
            break;
        case 'columns-1-4':
            sc_text = "[one_fourth_first]YourContentHere[/one_fourth_first]";
            sc_text += "[one_fourth]YourContentHere[/one_fourth]";
            sc_text += "[one_fourth]YourContentHere[/one_fourth]";
            sc_text += "[one_fourth_last]YourContentHere[/one_fourth_last]";
            break;
        case 'columns-2-3-1':
            sc_text = "[two_third_first]YourContentHere[/two_third_first]";
            sc_text += "[one_third_last]YourContentHere[/one_third_last]";
            break;
        case 'columns-3-2-1':
            sc_text = "[one_third_first]YourContentHere[/one_third_first]";
            sc_text += "[two_third_last]YourContentHere[/two_third_last]";
            break;
        case 'columns-3-4-1':
            sc_text = "[one_fourth_3_first]YourContentHere[/one_fourth_3_first]";
            sc_text += "[three_fourth_last]YourContentHere[/three_fourth_last]";
            break;
        case 'columns-4-3-1':
            sc_text = "[three_fourth_first]YourContentHere[/three_fourth_first]";
            sc_text += "[one_fourth_3_last]YourContentHere[/one_fourth_3_last]";
            break;
        case 'columns-4-2-1':
            sc_text = "[one_fourth_2_first]YourContentHere[/one_fourth_2_first]";
            sc_text += "[one_fourth_2]YourContentHere[/one_fourth_2]";
            sc_text += "[one_half_last]YourContentHere[/one_half_last]";
            break;
        case 'columns-2-4-1':
            sc_text = "[one_fourth_2_first]YourContentHere[/one_fourth_2_first]";
            sc_text += "[one_half]YourContentHere[/one_half]";
            sc_text += "[one_fourth_2_last]YourContentHere[/one_fourth_2_last]";
            break;
        case 'columns-4-1-2':
            sc_text = "[one_half_first]YourContentHere[/one_half_first]";
            sc_text += "[one_fourth_2]YourContentHere[/one_fourth_2]";
            sc_text += "[one_fourth_2_last]YourContentHere[/one_fourth_2_last]";
            break;
    }

    send_to_editor(sc_text);

};

var ThriveGenerateCodeShortcode = function (shortcode) {
    var sc_text = "[code]Your content here[/code]";
    send_to_editor(sc_text);
};

var ThriveGenerateDividerShortcode = function (shortcode) {
    var sc_text = "[divider]";
    send_to_editor(sc_text);
};

jQuery(document).ready(function () {
    //handle the custom ad group section
    jQuery("#sel_thrive_ad_groups_custom").change(function () {
        var _selected_custom_ad = jQuery("#sel_thrive_ad_groups_custom").val();
        if (_selected_custom_ad != "custom") {
            jQuery("#tt-container-custom-ad-groups").hide();
            jQuery("#tt-container-default-ad-groups").show();
        } else {
            jQuery("#tt-container-custom-ad-groups").show();
            jQuery("#tt-container-default-ad-groups").hide();
        }
    });
    var _selected_custom_ad = jQuery("#sel_thrive_ad_groups_custom").val();
    if (_selected_custom_ad != "custom") {
        jQuery("#tt-container-custom-ad-groups").hide();
        jQuery("#tt-container-default-ad-groups").show();
    } else {
        jQuery("#tt-container-custom-ad-groups").show();
        jQuery("#tt-container-default-ad-groups").hide();
    }

    jQuery("#publish").one('click', function (event) {
        event.preventDefault();
        var _selected_custom_ad = jQuery("#sel_thrive_ad_groups_custom").val();
        var _temp_group_ads = [];
        if (_selected_custom_ad == "custom") {
            jQuery(".tt-chk-ad-group:checked").each(function (index) {
                _temp_group_ads.push(jQuery(this).val());
            });
            jQuery("#hidden_thrive_ad_groups_custom_list").val(JSON.stringify(_temp_group_ads));
        }
        jQuery("#publish").trigger('click');
    });

});


jQuery(document).ready(function () {

    jQuery(".post-format").click(ThrivePostOptions.display_post_format_options);
    ThrivePostOptions.display_post_format_options();

    jQuery(".thrive_meta_postformat_audio_type").click(ThrivePostOptions.display_post_format_options);
    jQuery(".thrive_meta_postformat_video_type").click(ThrivePostOptions.display_post_format_options);

    jQuery('#btn_thrive_post_format_select_gallery').on('click', ThrivePostOptions.handle_file_upload);

    jQuery("#thrive_btn_postformat_select_audio_file").on('click', ThrivePostOptions.handle_audio_file_upload);

    jQuery(".thrive_meta_post_featured_image").click(ThrivePostOptions.display_featured_image_options);
    ThrivePostOptions.display_featured_image_options();

    ThrivePostOptions.display_featured_image_title_bg_type();

    jQuery("#thrive_custom_featured_title_bg_img_trans").wpColorPicker({
        change: function (event, ui) {
            jQuery("#thrive_hidden_featured_title_bg_img_trans").val(jQuery("#thrive_custom_featured_title_bg_img_trans").val());
        }
    });

    jQuery("#thrive_select_featured_title_bg_img_trans").change(function () {
        if (jQuery(this).val() == "none") {
            jQuery("#thrive_hidden_featured_title_bg_img_trans").val("");
            jQuery('#thrive_custom_featured_title_bg_img_trans_container').hide();
        } else if (jQuery(this).val() == "theme") {
            jQuery("#thrive_hidden_featured_title_bg_img_trans").val(jQuery("#thrive_hidden_theme_color").val());
            jQuery('#thrive_custom_featured_title_bg_img_trans_container').hide();
        } else {
            jQuery("#thrive_hidden_featured_title_bg_img_trans").val(jQuery("#thrive_custom_featured_title_bg_img_trans").val());
            jQuery('#thrive_custom_featured_title_bg_img_trans_container').show();
        }
    });

    ThrivePostOptions.display_header_color_options();

});


ThrivePostOptions.display_header_color_options = function () {

    var _bg_img_trans_color = jQuery("#thrive_hidden_featured_title_bg_img_trans").val();

    var _is_theme_color = (jQuery("#thrive_hidden_theme_color").val() == _bg_img_trans_color);

    if (_is_theme_color) {
        jQuery('#thrive_select_featured_title_bg_img_trans').val("theme");
    } else if (_bg_img_trans_color == "" || _bg_img_trans_color == "none") {
        jQuery('#thrive_select_featured_title_bg_img_trans').val("none");
    } else {
        jQuery('#thrive_select_featured_title_bg_img_trans').val("custom");
        jQuery('#thrive_custom_featured_title_bg_img_trans_container').show();
    }

};

ThrivePostOptions.display_post_format_options = function () {
    var _selected_format = jQuery(".post-format:checked").val();

    if (_selected_format == "audio") {
        var _selected_audio_type = jQuery(".thrive_meta_postformat_audio_type:checked").val();
        if (_selected_audio_type == "file") {
            jQuery("#tr_thrive_post_format_audio_file").show();
            jQuery("#tr_thrive_post_format_audio_soundcould").hide();
        } else {
            jQuery("#tr_thrive_post_format_audio_file").hide();
            jQuery("#tr_thrive_post_format_audio_soundcould").show();
        }

        jQuery("#thrive_post_format_audio_options").show();
        jQuery("#thrive_post_format_video_options").hide();
        jQuery("#thrive_post_format_quote_options").hide();
        jQuery("#thrive_post_format_gallery_options").hide();
        jQuery("#thrive_post_format_options").show();
    } else if (_selected_format == "video") {
        jQuery("#thrive_post_format_audio_options").hide();
        jQuery("#thrive_post_format_video_options").show();
        jQuery("#thrive_post_format_quote_options").hide();
        jQuery("#thrive_post_format_gallery_options").hide();
        jQuery("#thrive_post_format_options").show();

        var _selected_video_type = jQuery(".thrive_meta_postformat_video_type:checked").val();
        if (_selected_video_type == "vimeo") {
            jQuery(".thrive_shortcode_container_video_vimeo").show();
            jQuery(".thrive_shortcode_container_video_youtube").hide();
            jQuery(".thrive_shortcode_container_video_custom").hide();
        } else if (_selected_video_type == "custom") {
            jQuery(".thrive_shortcode_container_video_youtube").hide();
            jQuery(".thrive_shortcode_container_video_vimeo").hide();
            jQuery(".thrive_shortcode_container_video_custom").show();
        } else {
            jQuery(".thrive_shortcode_container_video_vimeo").hide();
            jQuery(".thrive_shortcode_container_video_custom").hide();
            jQuery(".thrive_shortcode_container_video_youtube").show();
        }

    } else if (_selected_format == "quote") {
        jQuery("#thrive_post_format_audio_options").hide();
        jQuery("#thrive_post_format_video_options").hide();
        jQuery("#thrive_post_format_quote_options").show();
        jQuery("#thrive_post_format_gallery_options").hide();
        jQuery("#thrive_post_format_options").show();
    } else if (_selected_format == "gallery") {
        jQuery("#thrive_post_format_audio_options").hide();
        jQuery("#thrive_post_format_video_options").hide();
        jQuery("#thrive_post_format_quote_options").hide();
        jQuery("#thrive_post_format_gallery_options").show();
        jQuery("#thrive_post_format_options").show();
    } else {
        jQuery("#thrive_post_format_options").hide();
    }


};

//deal with the file upload
var file_frame;
ThrivePostOptions.handle_file_upload = function (event) {
    event.preventDefault();
    if (file_frame) {
        file_frame.open();
        return;
    }
    file_frame = wp.media.frames.file_frame = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        library: {
            type: 'image'
        },
        multiple: true  // Set to true to allow multiple files to be selected
    });

    file_frame.on('open', function () {
        var selection = file_frame.state().get('selection');
        ids = jQuery('#thrive_meta_postformat_gallery_images').val().split(',');
        ids.forEach(function (id) {
            attachment = wp.media.attachment(id);
            attachment.fetch();
            selection.add(attachment ? [attachment] : []);
        });
    });

    // When an image is selected, run a callback.
    file_frame.on('select', function () {

        var _thrive_gallery_ids = "";
        jQuery("#thrive_container_post_format_gallery_list").html("");
        file_frame.state().get('selection').each(function (element) {
            if (element.attributes.id != "") {
                _thrive_gallery_ids += element.attributes.id + ",";
                jQuery("#thrive_container_post_format_gallery_list").append("<img class='thrive-gallery-thumb' src='" + element.attributes.url + "' width='50' height='50' />");
            }
        });
        jQuery("#thrive_meta_postformat_gallery_images").val(_thrive_gallery_ids);
    });
    file_frame.open();
};

ThrivePostOptions.display_featured_image_options = function () {
    var _selected_featured_img = jQuery(".thrive_meta_post_featured_image:checked").val();

    if (_selected_featured_img == "wide" || _selected_featured_img == "default") {
        jQuery("#thrive_input_meta_post_title_bg_type_image").prop('disabled', false);
    } else {
        jQuery("#thrive_input_meta_post_title_bg_type_image").prop('disabled', true);
        jQuery("#thrive_input_meta_post_title_bg_type_color").prop('checked', true);
    }
    ThrivePostOptions.display_featured_image_title_bg_type();
};

ThrivePostOptions.display_featured_image_title_bg_type = function () {
    var _selected_bg_type = jQuery(".thrive_shortcode_bg_type:checked").val();
    if (_selected_bg_type === "solid") {
        jQuery("#thrive_shortcode_container_bg_solid").show();
        jQuery("#thrive_shortcode_container_bg_image").hide();
    } else if (_selected_bg_type === "image") {
        jQuery("#thrive_shortcode_container_bg_image").show();
        jQuery("#thrive_shortcode_container_bg_solid").hide();
    } else {
        jQuery("#thrive_shortcode_container_bg_image").hide();
        jQuery("#thrive_shortcode_container_bg_solid").hide();
    }
};

var file_frame_audio;
ThrivePostOptions.handle_audio_file_upload = function (event) {
    event.preventDefault();
    if (file_frame_audio) {
        file_frame_audio.open();
        return;
    }
    file_frame_audio = wp.media.frames.file_frame_audio = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        library: {
            type: 'audio'
        },
        multiple: false
    });
    file_frame_audio.on('select', function () {
        attachment = file_frame_audio.state().get('selection').first().toJSON();
        jQuery("#thrive_meta_postformat_audio_file").val(attachment.url);
    });
    file_frame_audio.open();
};
