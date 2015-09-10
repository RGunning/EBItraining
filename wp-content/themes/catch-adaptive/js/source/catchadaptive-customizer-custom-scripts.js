/**
 * Theme Customizer custom scripts
 * Control of show/hide events for Customizer
 */
(function($) {

    //Message if WordPress version is less tham 4.0
    if (parseInt(catchadaptive_misc_links.WP_version) < 4) {
        $('.preview-notice').prepend('<span style="font-weight:bold;">' + catchadaptive_misc_links.old_version_message + '</span>');
        jQuery('#customize-info .btn-upgrade, .misc_links').click(function(event) {
            event.stopPropagation();
        });
    }

    //Add Upgrade Button,Theme instruction, Support Forum, Changelog, Donate link, Review, Facebook, Twitter, Google+, Pinterest links 
    $('.preview-notice').prepend('<span id="catchadaptive_upgrade"><a target="_blank" class="button btn-upgrade" href="' + catchadaptive_misc_links.upgrade_link + '">' + catchadaptive_misc_links.upgrade_text + '</a></span>');
    jQuery('#customize-info .btn-upgrade, .misc_links').click(function(event) {
        event.stopPropagation();
    });
    /*
     * For Featured Content on featured_content_type change event
     */
    $("#customize-control-catchadaptive_theme_options-featured_content_type label select").live( "change", function() {
        var value = $(this).val();

        if (value == 'demo-featured-content') {
            $('#customize-control-catchadaptive_theme_options-featured_content_number').hide();
            $('#customize-control-catchadaptive_theme_options-featured_content_headline').hide();
            $('#customize-control-catchadaptive_theme_options-featured_content_subheadline').hide();
            $('#customize-control-catchadaptive_theme_options-featured_content_show').hide();
            $('#customize-control-catchadaptive_theme_options-featured_content_enable_title').hide();
            $('[id*=customize-control-catchadaptive_theme_options-featured_content_page]').hide();
        } else {
            $('#customize-control-catchadaptive_theme_options-featured_content_number').show();
            $('#customize-control-catchadaptive_theme_options-featured_content_headline').show();
            $('#customize-control-catchadaptive_theme_options-featured_content_subheadline').show();
            $('#customize-control-catchadaptive_theme_options-featured_content_show').show();
            $('#customize-control-catchadaptive_theme_options-featured_content_enable_title').show();
            $('[id*=customize-control-catchadaptive_theme_options-featured_content_page]').show();
        }
    });

    /**
     * Control of show/hide events on feature content type selection on panel click if prevously value has been saved
     */
    $('#accordion-panel-catchadaptive_featured_content_options .accordion-section-title').live( "click", function() {
        var value = $("#customize-control-catchadaptive_theme_options-featured_content_type label select").val();
         if (value == 'demo-featured-content') {
            $('#customize-control-catchadaptive_theme_options-featured_content_number').hide();
            $('#customize-control-catchadaptive_theme_options-featured_content_headline').hide();
            $('#customize-control-catchadaptive_theme_options-featured_content_subheadline').hide();
            $('#customize-control-catchadaptive_theme_options-featured_content_show').hide();
            $('#customize-control-catchadaptive_theme_options-featured_content_enable_title').hide();           
            $('[id*=customize-control-catchadaptive_theme_options-featured_content_page]').hide();
        } else {
            $('#customize-control-catchadaptive_theme_options-featured_content_number').show();
            $('#customize-control-catchadaptive_theme_options-featured_content_headline').show();
            $('#customize-control-catchadaptive_theme_options-featured_content_subheadline').show();
            $('#customize-control-catchadaptive_theme_options-featured_content_show').show();
            $('#customize-control-catchadaptive_theme_options-featured_content_enable_title').show();
            $('[id*=customize-control-catchadaptive_theme_options-featured_content_page]').show();
        }
    });

    /*
     * For Feature Slider on featured_slider_type change event
     */

    $('#accordion-panel-catchadaptive_featured_slider .accordion-section-title').live( "click", function() {
        var value = $("#customize-control-catchadaptive_theme_options-featured_slider_type label select").val();

        if (value == 'demo-featured-slider') {
            $('#customize-control-catchadaptive_theme_options-featured_slide_number').hide();
            $('[id*=customize-control-catchadaptive_theme_options-featured_slider_page]').hide();
        } else {
            $('#customize-control-catchadaptive_theme_options-featured_slide_number').show();
            $('[id*=customize-control-catchadaptive_theme_options-featured_slider_page]').show();
        }
    });

    $("#customize-control-catchadaptive_theme_options-featured_slider_type label select").live( "change", function() {
        var value = $(this).val();

        if (value == 'demo-featured-slider') {
            $('#customize-control-catchadaptive_theme_options-featured_slide_number').hide();
            $('[id*=customize-control-catchadaptive_theme_options-featured_slider_page]').hide();
        } else {
            $('#customize-control-catchadaptive_theme_options-featured_slide_number').show();
            $('[id*=customize-control-catchadaptive_theme_options-featured_slider_page]').show();
        }
    });

    //For Color Scheme
    $("#customize-control-catchadaptive_theme_options-color_scheme").live( "change", function() {
        var value = $('#customize-control-catchadaptive_theme_options-color_scheme input:checked').val();
        if ( 'dark' == value ){
            $('#customize-control-header_textcolor .color-picker-hex').iris('color', '#bebebe');

            $('#customize-control-background_color .color-picker-hex').iris('color', '#202020');
        
        }
        else {
            $('#customize-control-header_textcolor .color-picker-hex').iris('color', '#dddddd');

            $('#customize-control-background_color .color-picker-hex').iris('color', '#ffffff');
        }
    });
     
})(jQuery);