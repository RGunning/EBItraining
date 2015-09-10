<?php
/**
 * The template for adding Featured Slider Options in Customizer
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
	// Featured Slider
	$wp_customize->add_panel( 'catchadaptive_featured_slider', array(
	    'capability'     => 'edit_theme_options',
	    'description'    => __( 'Options for Featured Slider', 'catch-adaptive' ),
	    'priority'       => 500,
		'title'    		 => __( 'Featured Slider', 'catch-adaptive' ),
	) );
	
	$wp_customize->add_section( 'catchadaptive_featured_slider', array(
		'panel'			=> 'catchadaptive_featured_slider',
		'priority'		=> 1,
		'title'			=> __( 'Featured Slider Options', 'catch-adaptive' ),
	) );

	$wp_customize->add_setting( 'catchadaptive_theme_options[featured_slider_option]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_option'],
		'sanitize_callback' => 'catchadaptive_sanitize_select',
	) );

	$featured_slider_content_options = catchadaptive_featured_slider_content_options();
	$choices = array();
	foreach ( $featured_slider_content_options as $featured_slider_content_option ) {
		$choices[$featured_slider_content_option['value']] = $featured_slider_content_option['label'];
	}

	$wp_customize->add_control( 'catchadaptive_theme_options[featured_slider_option]', array(
		'choices'   => $choices,
		'label'    	=> __( 'Enable Slider on', 'catch-adaptive' ),
		'priority'	=> '2',
		'section'  	=> 'catchadaptive_featured_slider',
		'settings' 	=> 'catchadaptive_theme_options[featured_slider_option]',
		'type'    	=> 'select',
	) );

	$wp_customize->add_setting( 'catchadaptive_theme_options[featured_slide_transition_effect]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_effect'],
		'sanitize_callback'	=> 'catchadaptive_sanitize_select',
	) );

	$catchadaptive_featured_slide_transition_effects = catchadaptive_featured_slide_transition_effects();
	$choices = array();
	foreach ( $catchadaptive_featured_slide_transition_effects as $catchadaptive_featured_slide_transition_effect ) {
		$choices[$catchadaptive_featured_slide_transition_effect['value']] = $catchadaptive_featured_slide_transition_effect['label'];
	}

	$wp_customize->add_control( 'catchadaptive_theme_options[featured_slide_transition_effect]' , array(
		'choices'  	=> $choices,
		'label'		=> __( 'Transition Effect', 'catch-adaptive' ),
		'priority'	=> '3',
		'section'  	=> 'catchadaptive_featured_slider',
		'settings' 	=> 'catchadaptive_theme_options[featured_slide_transition_effect]',
		'type'	  	=> 'select',
		)
	);

	$wp_customize->add_setting( 'catchadaptive_theme_options[featured_slide_transition_delay]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_delay'],
		'sanitize_callback'	=> 'absint',
	) );

	$wp_customize->add_control( 'catchadaptive_theme_options[featured_slide_transition_delay]' , array(
		'description'	=> __( 'seconds(s)', 'catch-adaptive' ),
		'input_attrs' => array(
        	'style' => 'width: 40px;'
    	),
    	'label'    		=> __( 'Transition Delay', 'catch-adaptive' ),
		'priority'		=> '4',
		'section'  		=> 'catchadaptive_featured_slider',
		'settings' 		=> 'catchadaptive_theme_options[featured_slide_transition_delay]',
		)
	);

	$wp_customize->add_setting( 'catchadaptive_theme_options[featured_slide_transition_length]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_length'],
		'sanitize_callback'	=> 'absint',
	) );

	$wp_customize->add_control( 'catchadaptive_theme_options[featured_slide_transition_length]' , array(
		'description'	=> __( 'seconds(s)', 'catch-adaptive' ),
		'input_attrs' => array(
        	'style' => 'width: 40px;'
    	),
    	'label'    		=> __( 'Transition Length', 'catch-adaptive' ),
		'priority'		=> '5',
		'section'  		=> 'catchadaptive_featured_slider',
		'settings' 		=> 'catchadaptive_theme_options[featured_slide_transition_length]',
		)
	);

	$wp_customize->add_setting( 'catchadaptive_theme_options[featured_slider_image_loader]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_image_loader'],
		'sanitize_callback' => 'catchadaptive_sanitize_select',
	) );

	$featured_slider_image_loader_options = catchadaptive_featured_slider_image_loader();
	$choices = array();
	foreach ( $featured_slider_image_loader_options as $featured_slider_image_loader_option ) {
		$choices[$featured_slider_image_loader_option['value']] = $featured_slider_image_loader_option['label'];
	}

	$wp_customize->add_control( 'catchadaptive_theme_options[featured_slider_image_loader]', array(
		'choices'   => $choices,
		'label'    	=> __( 'Image Loader', 'catch-adaptive' ),
		'priority'	=> '6',
		'section'  	=> 'catchadaptive_featured_slider',
		'settings' 	=> 'catchadaptive_theme_options[featured_slider_image_loader]',
		'type'    	=> 'select',
	) );

	$wp_customize->add_setting( 'catchadaptive_theme_options[featured_slider_type]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_type'],
		'sanitize_callback'	=> 'catchadaptive_sanitize_select',
	) );

	$featured_slider_types = catchadaptive_featured_slider_types();
	$choices = array();
	foreach ( $featured_slider_types as $featured_slider_type ) {
		$choices[$featured_slider_type['value']] = $featured_slider_type['label'];
	}

	$wp_customize->add_control( 'catchadaptive_theme_options[featured_slider_type]', array(
		'choices'  	=> $choices,
		'label'    	=> __( 'Select Slider Type', 'catch-adaptive' ),
		'priority'	=> '7',
		'section'  	=> 'catchadaptive_featured_slider',
		'settings' 	=> 'catchadaptive_theme_options[featured_slider_type]',
		'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'catchadaptive_theme_options[featured_slide_number]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_number'],
		'sanitize_callback'	=> 'catchadaptive_sanitize_number_range',
	) );

	$wp_customize->add_control( 'catchadaptive_theme_options[featured_slide_number]' , array(
		'description'	=> __( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'catch-adaptive' ),
		'input_attrs' 	=> array(
            'style' => 'width: 45px;',
            'min'   => 0,
            'max'   => 20,
            'step'  => 1,
        	),
		'label'    		=> __( 'No of Slides', 'catch-adaptive' ),
		'priority'		=> '8',
		'section'  		=> 'catchadaptive_featured_slider',
		'settings' 		=> 'catchadaptive_theme_options[featured_slide_number]',
		'type'	   		=> 'number',
		)
	);

	//loop for featured page sliders
	for ( $i=1; $i <= $options['featured_slide_number'] ; $i++ ) {
		$wp_customize->add_setting( 'catchadaptive_theme_options[featured_slider_page_'. $i .']', array(
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'catchadaptive_sanitize_page',
		) );

		$wp_customize->add_control( 'catchadaptive_theme_options[featured_slider_page_'. $i .']', array(
			'label'    	=> __( 'Featured Page', 'catch-adaptive' ) . ' # ' . $i ,
			'priority'	=> '11' . $i,
			'section'  	=> 'catchadaptive_featured_slider',
			'settings' 	=> 'catchadaptive_theme_options[featured_slider_page_'. $i .']',
			'type'	   	=> 'dropdown-pages',
		) );
	}
// Featured Slider End