<?php
/**
 * The template for adding Additional Header Option in Customizer
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

	// Header Options
	$wp_customize->add_setting( 'catchadaptive_theme_options[enable_featured_header_image]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['enable_featured_header_image'],
		'sanitize_callback' => 'catchadaptive_sanitize_select',
	) );

	$catchadaptive_enable_featured_header_image_options = catchadaptive_enable_featured_header_image_options();
	$choices = array();
	foreach ( $catchadaptive_enable_featured_header_image_options as $catchadaptive_enable_featured_header_image_option ) {
		$choices[$catchadaptive_enable_featured_header_image_option['value']] = $catchadaptive_enable_featured_header_image_option['label'];
	}

	$wp_customize->add_control( 'catchadaptive_theme_options[enable_featured_header_image]', array(
			'choices'  	=> $choices,
			'label'		=> __( 'Enable Featured Header Image on ', 'catch-adaptive' ),
			'section'   => 'header_image',
	        'settings'  => 'catchadaptive_theme_options[enable_featured_header_image]',
	        'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'catchadaptive_theme_options[featured_image_size]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_image_size'],
		'sanitize_callback' => 'catchadaptive_sanitize_select',
	) );

	$catchadaptive_featured_image_size_options = catchadaptive_featured_image_size_options();
	$choices = array();
	foreach ( $catchadaptive_featured_image_size_options as $catchadaptive_featured_image_size_option ) {
		$choices[$catchadaptive_featured_image_size_option['value']] = $catchadaptive_featured_image_size_option['label'];
	}

	$wp_customize->add_control( 'catchadaptive_theme_options[featured_image_size]', array(
			'choices'  	=> $choices,
			'label'		=> __( 'Page/Post Featured Image Size', 'catch-adaptive' ),
			'section'   => 'header_image',
			'settings'  => 'catchadaptive_theme_options[featured_image_size]',
			'type'	  	=> 'select',
	) );
// Header Options End