<?php
/**
 * The main template for implementing Theme/Customzer Options
 *
 * @package Catch Themes
 * @subpackage Catch Adaptive
 * @since Catch Adaptive 0.1
 */

if ( ! defined( 'CATCHADAPTIVE_THEME_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Implements Adaptive theme options into Theme Customizer.
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport			= 'postMessage';

	/**
	  * Set priority of blogname (Site Title) to 1. 
	  *  Strangly, if more than two options is added, Site title is moved below Tagline. This rectifies this issue.
	  */
	$wp_customize->get_control( 'blogname' )->priority			= 1;

	$wp_customize->get_setting( 'blogdescription' )->transport	= 'postMessage';

	$options  = catchadaptive_get_theme_options();

	$defaults = catchadaptive_get_default_theme_options();

	//Custom Controls
	require get_template_directory() . '/inc/customizer-includes/catchadaptive-customizer-custom-controls.php';

	// Custom Logo (added to Site Title and Tagline section in Theme Customizer)
	$wp_customize->add_setting( 'catchadaptive_theme_options[logo]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['logo'],
		'sanitize_callback'	=> 'catchadaptive_sanitize_image'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label'		=> __( 'Logo', 'catch-adaptive' ),
		'priority'	=> 100,
		'section'   => 'title_tagline',
        'settings'  => 'catchadaptive_theme_options[logo]',
    ) ) );

    $wp_customize->add_setting( 'catchadaptive_theme_options[logo_disable]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['logo_disable'],
		'sanitize_callback' => 'catchadaptive_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'catchadaptive_theme_options[logo_disable]', array(
		'label'    => __( 'Check to disable logo', 'catch-adaptive' ),
		'priority' => 101,
		'section'  => 'title_tagline',
		'settings' => 'catchadaptive_theme_options[logo_disable]',
		'type'     => 'checkbox',
	) );
	
	$wp_customize->add_setting( 'catchadaptive_theme_options[logo_alt_text]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['logo_alt_text'],
		'sanitize_callback'	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'catchadaptive_logo_alt_text', array(
		'label'    	=> __( 'Logo Alt Text', 'catch-adaptive' ),
		'priority'	=> 102,
		'section' 	=> 'title_tagline',
		'settings' 	=> 'catchadaptive_theme_options[logo_alt_text]',
		'type'     	=> 'text',
	) );

	$wp_customize->add_setting( 'catchadaptive_theme_options[move_title_tagline]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['move_title_tagline'],
		'sanitize_callback' => 'catchadaptive_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'catchadaptive_theme_options[move_title_tagline]', array(
		'label'    => __( 'Check to move Site Title and Tagline before logo', 'catch-adaptive' ),
		'priority' => 103,
		'section'  => 'title_tagline',
		'settings' => 'catchadaptive_theme_options[move_title_tagline]',
		'type'     => 'checkbox',
	) );
	// Custom Logo End

	//Basic Color Options
	$wp_customize->add_setting( 'catchadaptive_theme_options[color_scheme]', array(
		'capability' 		=> 'edit_theme_options',
		'default'    		=> $defaults['color_scheme'],
		'sanitize_callback'	=> 'catchadaptive_sanitize_select'
	) );

	$schemes = catchadaptive_color_schemes();

	$choices = array();

	foreach ( $schemes as $scheme ) {
		$choices[ $scheme['value'] ] = $scheme['label'];
	}

	$wp_customize->add_control( 'catchadaptive_theme_options[color_scheme]', array(
		'choices'  => $choices,
		'label'    => __( 'Color Scheme', 'catch-adaptive' ),
		'priority' => 5,
		'section'  => 'colors',
		'settings' => 'catchadaptive_theme_options[color_scheme]',
		'type'     => 'radio',
	) );
	//Basic Color Options


	// Header Options (added to Header section in Theme Customizer)
	require get_template_directory() . '/inc/customizer-includes/catchadaptive-customizer-header-options.php';

	//Theme Options
	require get_template_directory() . '/inc/customizer-includes/catchadaptive-customizer-theme-options.php';
	
	//Featured Content Setting
	require get_template_directory() . '/inc/customizer-includes/catchadaptive-customizer-featured-content-options.php';
   	
	//Featured Slider
	require get_template_directory() . '/inc/customizer-includes/catchadaptive-customizer-featured-slider-options.php';

	//Social Links
	require get_template_directory() . '/inc/customizer-includes/catchadaptive-customizer-social-icon-options.php';
	
	// Reset all settings to default
	$wp_customize->add_section( 'catchadaptive_reset_all_settings', array(
		'description'	=> __( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'catch-adaptive' ),
		'priority' 		=> 700,
		'title'    		=> __( 'Reset all settings', 'catch-adaptive' ),
	) );

	$wp_customize->add_setting( 'catchadaptive_theme_options[reset_all_settings]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['reset_all_settings'],
		'sanitize_callback' => 'catchadaptive_reset_all_settings',
		'transport'			=> 'postMessage',
	) );

	$wp_customize->add_control( 'catchadaptive_theme_options[reset_all_settings]', array(
		'label'    => __( 'Check to reset all settings to default', 'catch-adaptive' ),
		'section'  => 'catchadaptive_reset_all_settings',
		'settings' => 'catchadaptive_theme_options[reset_all_settings]',
		'type'     => 'checkbox',
	) );
	// Reset all settings to default end


	//Important Links
		$wp_customize->add_section( 'important_links', array(
			'priority' 		=> 999,
			'title'   	 	=> __( 'Important Links', 'catch-adaptive' ),
		) );

		/**
		 * Has dummy Sanitizaition function as it contains no value to be sanitized
		 */
		$wp_customize->add_setting( 'important_links', array(
			'sanitize_callback'	=> 'catchadaptive_sanitize_important_link',
		) );

		$wp_customize->add_control( new Catchadaptive_Important_Links( $wp_customize, 'important_links', array(
	        'label'   	=> __( 'Important Links', 'catch-adaptive' ),
	         'section'  	=> 'important_links',
	        'settings' 	=> 'important_links',
	        'type'     	=> 'important_links',
	    ) ) );  
	    //Important Links End
}
add_action( 'customize_register', 'catchadaptive_customize_register' );


/**
 * Sanitizes Checkboxes
 * @param  $input entered value
 * @return sanitized output
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_sanitize_checkbox( $input ) {
    // Boolean check.
	return ( ( isset( $input ) && true == $input ) ? true : false );
}


/**
 * Sanitizes Custom CSS 
 * @param  $input entered value
 * @return sanitized output
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_sanitize_custom_css( $input ) {
	if ( $input != '' ) { 
        $input = str_replace( '<=', '&lt;=', $input ); 
        
        $input = wp_kses_split( $input, array(), array() ); 
        
        $input = str_replace( '&gt;', '>', $input ); 
        
        $input = strip_tags( $input ); 

        return $input;
 	}
    else {
    	return '';
    }
}


/**
 * Sanitizes page in slider
 * @param  $input entered value
 * @return sanitized output
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_sanitize_page( $input ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $input );
	// If $page_id is an ID of a published page, return it; otherwise, return false
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : false );
}


/**
 * Sanitizes category list in slider
 * @param  $input entered value
 * @return sanitized output
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_sanitize_category_list( $input ) {
	if ( $input != '' ) { 
		$args = array(
						'type'			=> 'post',
						'child_of'      => 0,
						'parent'        => '',
						'orderby'       => 'name',
						'order'         => 'ASC',
						'hide_empty'    => 0,
						'hierarchical'  => 0,
						'taxonomy'      => 'category',
					); 
		
		$categories = ( get_categories( $args ) );

		$category_list 	=	array();
		
		foreach ( $categories as $category )
			$category_list 	=	array_merge( $category_list, array( $category->term_id ) );

		if ( count( array_intersect( $input, $category_list ) ) == count( $input ) ) {
	    	return $input;
	    } 
	    else {
    		return '';
   		}
    }
    else {
    	return '';
    }
}


/**
 * Number Range sanitization callback example.
 *
 * - Sanitization: number_range
 * - Control: number, tel
 * 
 * Sanitization callback for 'number' or 'tel' type text inputs. This callback sanitizes
 * `$number` as an absolute integer within a defined min-max range.
 * 
 * @see absint() https://developer.wordpress.org/reference/functions/absint/
 *
 * @param int                  $number  Number to check within the numeric range defined by the setting.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int|string The number, if it is zero or greater and falls within the defined range; otherwise,
 *                    the setting default.
 */
function catchadaptive_sanitize_number_range( $number, $setting ) {

	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}


/**
 * Image sanitization callback example.
 *
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default.
 *
 * - Sanitization: image file extension
 * - Control: text, WP_Customize_Image_Control
 * 
 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
 *
 * @param string               $image   Image filename.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The image filename if the extension is allowed; otherwise, the setting default.
 */
function catchadaptive_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
	// Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}


/**
 * Sanitizes footer code
 * @param  $input entered value
 * @return sanitized output
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_sanitize_footer_code( $input ) {
	return ( stripslashes( wp_filter_post_kses( addslashes ( $input ) ) ) );
}


/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 * 
 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 * 
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function catchadaptive_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


/**
 * Reset all settings to default
 * @param  $input entered value
 * @return sanitized output
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_reset_all_settings( $input ) {
	if ( $input == 1 ) {
        // Set default values
        set_theme_mod( 'catchadaptive_theme_options', catchadaptive_get_default_theme_options() );
       
        // Flush out all transients	
        catchadaptive_flush_transients();
    } 
    else {
        return '';
    }
}


/**
 * Dummy Sanitizaition function as it contains no value to be sanitized
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_sanitize_important_link() {
	return false;
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously for catchadaptive.
 * And flushes out all transient data on preview
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_customize_preview() {
	wp_enqueue_script( 'catchadaptive_customizer', get_template_directory_uri() . '/js/catchadaptive-customizer.min.js', array( 'customize-preview' ), '20120827', true );
	
	//Flush transients
	catchadaptive_flush_transients();
}
add_action( 'customize_preview_init', 'catchadaptive_customize_preview' );


/**
 * Custom scripts and styles on customize.php for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_customize_scripts() {
	wp_register_script( 'catchadaptive_customizer_custom', get_template_directory_uri() . '/js/catchadaptive-customizer-custom-scripts.min.js', array( 'jquery' ), '20131028', true );

	$catchadaptive_misc_links = array(
							'upgrade_link' 				=> esc_url( 'http://catchthemes.com/themes/catchadaptive-pro/' ),
							'upgrade_text'	 			=> __( 'Upgrade To Pro &raquo;', 'catch-adaptive' ),
							'WP_version'				=> get_bloginfo( 'version' ),
							'old_version_message'		=> __( 'Some settings might be missing or disorganized in this version of WordPress. So we suggest you to upgrade to version 4.0 or better.', 'catch-adaptive' )
		);

	//Add Upgrade Button and old WordPress message via localized script
	wp_localize_script( 'catchadaptive_customizer_custom', 'catchadaptive_misc_links', $catchadaptive_misc_links );

	wp_enqueue_script( 'catchadaptive_customizer_custom' );

	wp_enqueue_style( 'catchadaptive_customizer_custom', get_template_directory_uri() . '/css/catchadaptive-customizer.css');
}
add_action( 'customize_controls_print_footer_scripts', 'catchadaptive_customize_scripts');