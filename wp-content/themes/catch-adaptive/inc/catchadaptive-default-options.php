<?php
/**
 * Implement Default Theme/Customizer Options
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
 * Returns the default options for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_get_default_theme_options() {
	
	$theme_data = wp_get_theme();
	
	$default_theme_options = array(
		//Site Title an Tagline
		'logo'												=> get_template_directory_uri() . '/images/headers/logo.png',
		'logo_alt_text' 									=> '',
		'logo_disable'										=> 1,
		'move_title_tagline'								=> 0,
		
		//Layout
		'theme_layout' 										=> 'right-sidebar',
		'content_layout'									=> 'columns-layout',
		'single_post_image_layout'							=> 'disabled',
		
		//Header Image
		'enable_featured_header_image'						=> 'entire-site-page-post',
		'featured_image_size'								=> 'slider',

		//Breadcrumb Options
		'breadcumb_option'									=> 0,
		'breadcumb_onhomepage'								=> 0,
		'breadcumb_seperator'								=> '&raquo;',

		//Custom CSS
		'custom_css'										=> '',
		
		//Header Right Sidebar Options
		'disable_header_sidebar'							=> 0,
		
		//Excerpt Options
		'excerpt_length'									=> '40',
		'excerpt_more_text'									=> __( 'Read More ...', 'catch-adaptive' ),
		
		//Homepage / Frontpage Settings
		'front_page_category'								=> array(),
		
		//Pagination Options
		'pagination_type'									=> 'default',

		//Promotion Headline Options
		'promotion_headline_option'							=> 'disabled',
		'promotion_headline'								=> __( 'Catch Adaptive is a Premium Responsive WordPress Theme', 'catch-adaptive' ),
		'promotion_subheadline'								=> '',
		'promotion_headline_button'							=> __( 'Buy Now', 'catch-adaptive' ),
		'promotion_headline_url'							=> esc_url( 'http://catchthemes.com/' ),
		'promotion_headline_target'							=> 1,

		//Search Options
		'search_text'										=> __( 'Search...', 'catch-adaptive' ),

		//Basic Color
		'color_scheme'										=> 'light',
		//Featured Content Options
		'featured_content_option'							=> 'homepage',
		'featured_content_layout'							=> 'layout-three',
		'featured_content_position'							=> 1,
		'featured_content_slider'							=> 1,
		'featured_content_headline'							=> '',
		'featured_content_subheadline'						=> '',
		'featured_content_type'								=> 'demo-featured-content',
		'featured_content_number'							=> '4',
		'featured_content_enable_title'						=> 1,
		'featured_content_show'								=> 'hide-content',
		
		//Featured Slider Options
		'featured_slider_option'							=> 'disabled',
		'featured_slider_image_loader'						=> 'true',
		'featured_slide_transition_effect'					=> 'fadeout',
		'featured_slide_transition_delay'					=> '4',
		'featured_slide_transition_length'					=> '1',
		'featured_slider_type'								=> 'demo-featured-slider',
		'featured_slide_number'								=> '4',
		
		'featured_content_background_image'					=> '',

		//Social Links
		'custom_social_icons'								=> '1',
		
		//Reset all settings
		'reset_all_settings'								=> 0,
	);

	return apply_filters( 'catchadaptive_default_theme_options', $default_theme_options );
}


/**
 * Returns an array of featured slider image loader options
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_featured_slider_image_loader() {
	$color_scheme_options = array(
		'true' => array(
			'value' 				=> 'true',
			'label' 				=> __( 'True', 'catch-adaptive' ),
		),
		'wait' => array(
			'value' 				=> 'wait',
			'label' 				=> __( 'Wait', 'catch-adaptive' ),
		),
		'false' => array(
			'value' 				=> 'false',
			'label' 				=> __( 'False', 'catch-adaptive' ),
		),		
	);

	return apply_filters( 'catchadaptive_color_schemes', $color_scheme_options );
}


/**
 * Returns an array of color schemes registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_color_schemes() {
	$color_scheme_options = array(
		'light' => array(
			'value' 				=> 'light',
			'label' 				=> __( 'Light', 'catch-adaptive' ),
		),
		'dark' => array(
			'value' 				=> 'dark',
			'label' 				=> __( 'Dark', 'catch-adaptive' ),
		),
	);

	return apply_filters( 'catchadaptive_color_schemes', $color_scheme_options );
}


/**
 * Returns an array of layout options registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_layouts() {
	$layout_options = array(
		'left-sidebar' 	=> array(
			'value' => 'left-sidebar',
			'label' => __( 'Primary Sidebar, Content', 'catch-adaptive' ),
		),
		'right-sidebar' => array(
			'value' => 'right-sidebar',
			'label' => __( 'Content, Primary Sidebar', 'catch-adaptive' ),
		),
		'no-sidebar'	=> array(
			'value' => 'no-sidebar',
			'label' => __( 'No Sidebar ( Content Width )', 'catch-adaptive' ),
		),
	);
	return apply_filters( 'catchadaptive_layouts', $layout_options );
}


/**
 * Returns an array of content layout options registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_get_archive_content_layout() {
	$layout_options = array(
		'columns-layout' => array(
			'value' => 'columns-layout',
			'label' => __( 'Columns Layout (Image Top)', 'catch-adaptive' ),
		),		
		'excerpt-image-left' => array(
			'value' => 'excerpt-image-left',
			'label' => __( 'Show Excerpt (Image Left)', 'catch-adaptive' ),
		),		
		'full-content' => array(
			'value' => 'full-content',
			'label' => __( 'Show Full Content (No Featured Image)', 'catch-adaptive' ),
		),
	);
	return apply_filters( 'catchadaptive_get_archive_content_layout', $layout_options );
}


/**
 * Returns an array of feature header enable options
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_enable_featured_header_image_options() {
	$enable_featured_header_image_options = array(
		'homepage' 		=> array(
			'value'	=> 'homepage',
			'label' => __( 'Homepage / Frontpage', 'catch-adaptive' ),
		),
		'exclude-home' 		=> array(
			'value'	=> 'exclude-home',
			'label' => __( 'Excluding Homepage', 'catch-adaptive' ),
		),
		'exclude-home-page-post' 	=> array(
			'value' => 'exclude-home-page-post',
			'label' => __( 'Excluding Homepage, Page/Post Featured Image', 'catch-adaptive' ),
		),
		'entire-site' 	=> array(
			'value' => 'entire-site',
			'label' => __( 'Entire Site', 'catch-adaptive' ),
		),
		'entire-site-page-post' 	=> array(
			'value' => 'entire-site-page-post',
			'label' => __( 'Entire Site, Page/Post Featured Image', 'catch-adaptive' ),
		),
		'pages-posts' 	=> array(
			'value' => 'pages-posts',
			'label' => __( 'Pages and Posts', 'catch-adaptive' ),
		),
		'disabled'		=> array(
			'value' => 'disabled',
			'label' => __( 'Disabled', 'catch-adaptive' ),
		),
	);

	return apply_filters( 'catchadaptive_enable_featured_header_image_options', $enable_featured_header_image_options );
}


/**
 * Returns an array of feature image size
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_featured_image_size_options() {
	$featured_image_size_options = array(
		'full' 		=> array(
			'value'	=> 'full',
			'label' => __( 'Full Image', 'catch-adaptive' ),
		),
		'large' 	=> array(
			'value' => 'large',
			'label' => __( 'Large Image', 'catch-adaptive' ),
		),
		'slider'		=> array(
			'value' => 'slider',
			'label' => __( 'Slider Image', 'catch-adaptive' ),
		),
	);

	return apply_filters( 'catchadaptive_featured_image_size_options', $featured_image_size_options );
}


/**
 * Returns an array of content and slider layout options registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_featured_slider_content_options() {
	$featured_slider_content_options = array(
		'homepage' 		=> array(
			'value'	=> 'homepage',
			'label' => __( 'Homepage / Frontpage', 'catch-adaptive' ),
		),
		'entire-site' 	=> array(
			'value' => 'entire-site',
			'label' => __( 'Entire Site', 'catch-adaptive' ),
		),
		'disabled'		=> array(
			'value' => 'disabled',
			'label' => __( 'Disabled', 'catch-adaptive' ),
		),
	);

	return apply_filters( 'catchadaptive_featured_slider_content_options', $featured_slider_content_options );
}


/**
 * Returns an array of feature content types registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_featured_content_types() {
	$featured_content_types = array(
		'demo-featured-content' => array(
			'value' => 'demo-featured-content',
			'label' => __( 'Demo Featured Content', 'catch-adaptive' ),
		),
		'featured-page-content' => array(
			'value' => 'featured-page-content',
			'label' => __( 'Featured Page Content', 'catch-adaptive' ),
		)
	);

	return apply_filters( 'catchadaptive_featured_content_types', $featured_content_types );
}


/**
 * Returns an array of featured content options registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_featured_content_layout_options() {
	$featured_content_layout_option = array(
		'layout-three' 		=> array(
			'value'	=> 'layout-three',
			'label' => __( '3 columns', 'catch-adaptive' ),
		),
		'layout-four' 	=> array(
			'value' => 'layout-four',
			'label' => __( '4 columns', 'catch-adaptive' ),
		),
	);

	return apply_filters( 'catchadaptive_featured_content_layout_options', $featured_content_layout_option );
}


/**
 * Returns an array of featured content show registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_featured_content_show() {
	$featured_content_show_option = array(
		'excerpt' 		=> array(
			'value'	=> 'excerpt',
			'label' => __( 'Show Excerpt', 'catch-adaptive' ),
		),
		'full-content' 	=> array(
			'value' => 'full-content',
			'label' => __( 'Show Full Content', 'catch-adaptive' ),
		),
		'hide-content' 	=> array(
			'value' => 'hide-content',
			'label' => __( 'Hide Content', 'catch-adaptive' ),
		),
	);

	return apply_filters( 'catchadaptive_featured_content_show', $featured_content_show_option );
}


/**
 * Returns an array of feature slider types registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_featured_slider_types() {
	$featured_slider_types = array(
		'demo-featured-slider' => array(
			'value' => 'demo-featured-slider',
			'label' => __( 'Demo Featured Slider', 'catch-adaptive' ),
		),
		'featured-page-slider' => array(
			'value' => 'featured-page-slider',
			'label' => __( 'Featured Page Slider', 'catch-adaptive' ),
		)
	);

	return apply_filters( 'catchadaptive_featured_slider_types', $featured_slider_types );
}


/**
 * Returns an array of feature slider transition effects
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_featured_slide_transition_effects() {
	$featured_slide_transition_effects = array(
		'fade' 		=> array(
			'value'	=> 'fade',
			'label' => __( 'Fade', 'catch-adaptive' ),
		),
		'fadeout' 	=> array(
			'value'	=> 'fadeout',
			'label' => __( 'Fade Out', 'catch-adaptive' ),
		),
		'none' 		=> array(
			'value' => 'none',
			'label' => __( 'None', 'catch-adaptive' ),
		),
		'scrollHorz'=> array(
			'value' => 'scrollHorz',
			'label' => __( 'Scroll Horizontal', 'catch-adaptive' ),
		),
		'scrollVert'=> array(
			'value' => 'scrollVert',
			'label' => __( 'Scroll Vertical', 'catch-adaptive' ),
		),
		'flipHorz'	=> array(
			'value' => 'flipHorz',
			'label' => __( 'Flip Horizontal', 'catch-adaptive' ),
		),
		'flipVert'	=> array(
			'value' => 'flipVert',
			'label' => __( 'Flip Vertical', 'catch-adaptive' ),
		),
		'tileSlide'	=> array(
			'value' => 'tileSlide',
			'label' => __( 'Tile Slide', 'catch-adaptive' ),
		),
		'tileBlind'	=> array(
			'value' => 'tileBlind',
			'label' => __( 'Tile Blind', 'catch-adaptive' ),
		),
		'shuffle'	=> array(
			'value' => 'shuffle',
			'label' => __( 'Suffle', 'catch-adaptive' ),
		)
	);

	return apply_filters( 'catchadaptive_featured_slide_transition_effects', $featured_slide_transition_effects );
}


/**
 * Returns an array of color schemes registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_get_pagination_types() {
	$pagination_types = array(
		'default' => array(
			'value' => 'default',
			'label' => __( 'Default(Older Posts/Newer Posts)', 'catch-adaptive' ),
		),
		'numeric' => array(
			'value' => 'numeric',
			'label' => __( 'Numeric', 'catch-adaptive' ),
		),
		'infinite-scroll-click' => array(
			'value' => 'infinite-scroll-click',
			'label' => __( 'Infinite Scroll (Click)', 'catch-adaptive' ),
		),
		'infinite-scroll-scroll' => array(
			'value' => 'infinite-scroll-scroll',
			'label' => __( 'Infinite Scroll (Scroll)', 'catch-adaptive' ),
		),
	);

	return apply_filters( 'catchadaptive_get_pagination_types', $pagination_types );
}


/**
 * Returns an array of content featured image size.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_single_post_image_layout_options() {
	$single_post_image_layout_options = array(
		'featured' => array(
			'value' => 'featured',
			'label' => __( 'Featured', 'catch-adaptive' ),
		),
		'full-size' => array(
			'value' => 'full-size',
			'label' => __( 'Full Size', 'catch-adaptive' ),
		),
		'disabled' => array(
			'value' => 'disabled',
			'label' => __( 'Disabled', 'catch-adaptive' ),
		),
	);
	return apply_filters( 'catchadaptive_single_post_image_layout_options', $single_post_image_layout_options );
}


/**
 * Returns an array of avaliable fonts registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_avaliable_fonts() {
	$avaliable_fonts = array(
		'arial-black' => array(
			'value' => 'arial-black',
			'label' => '"Arial Black", Gadget, sans-serif',
		),
		'allan' => array(
			'value' => 'allan',
			'label' => '"Allan", sans-serif',
		),
		'allerta' => array(
			'value' => 'allerta',
			'label' => '"Allerta", sans-serif',
		),
		'amaranth' => array(
			'value' => 'amaranth',
			'label' => '"Amaranth", sans-serif',
		),
		'arial' => array(
			'value' => 'arial',
			'label' => 'Arial, Helvetica, sans-serif',
		),
		'bitter' => array(
			'value' => 'bitter',
			'label' => '"Bitter", sans-serif',
		),
		'cabin' => array(
			'value' => 'cabin',
			'label' => '"Cabin", sans-serif',
		),
		'cantarell' => array(
			'value' => 'cantarell',
			'label' => '"Cantarell", sans-serif',
		),
		'century-gothic' => array(
			'value' => 'century-gothic',
			'label' => '"Century Gothic", sans-serif',
		),
		'courier-new' => array(
			'value' => 'courier-new',
			'label' => '"Courier New", Courier, monospace',
		),
		'crimson-text' => array(
			'value' => 'crimson-text',
			'label' => '"Crimson Text", sans-serif',
		),
		'cuprum' => array(
			'value' => 'cuprum',
			'label' => '"Cuprum", sans-serif',
		),
		'dancing-script' => array(
			'value' => 'dancing-script',
			'label' => '"Dancing Script", sans-serif',
		),
		'droid-sans' => array(
			'value' => 'droid-sans',
			'label' => '"Droid Sans", sans-serif',
		),
		'droid-serif' => array(
			'value' => 'droid-serif',
			'label' => '"Droid Serif", sans-serif',
		),
		'exo' => array(
			'value' => 'exo',
			'label' => '"Exo", sans-serif',
		),	
		'exo-2' => array(
			'value' => 'exo-2',
			'label' => '"Exo 2", sans-serif',
		),				
		'georgia' => array(
			'value' => 'georgia',
			'label' => 'Georgia, "Times New Roman", Times, serif',
		),
		'helvetica' => array(
			'value' => 'helvetica',
			'label' => 'Helvetica, "Helvetica Neue", Arial, sans-serif',
		),
		'helvetica-neue' => array(
			'value' => 'helvetica-neue',
			'label' => '"Helvetica Neue",Helvetica,Arial,sans-serif',
		),
		'istok-web' => array(
			'value' => 'istok-web',
			'label' => '"Istok Web", sans-serif',
		),
		'impact' => array(
			'value' => 'impact',
			'label' => 'Impact, Charcoal, sans-serif',
		),
		'lato' => array(
			'value' => 'lato',
			'label' => '"Lato", sans-serif',
		),
		'lucida-sans-unicode' => array(
			'value' => 'lucida-sans-unicode',
			'label' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
		),
		'lucida-grande' => array(
			'value' => 'lucida-grande',
			'label' => '"Lucida Grande", "Lucida Sans Unicode", sans-serif',
		),
		'lobster' => array(
			'value' => 'lobster',
			'label' => '"Lobster", sans-serif',
		),
		'lora' => array(
			'value' => 'lora',
			'label' => '"Lora", serif',
		),
		'monaco' => array(
			'value' => 'monaco',
			'label' => 'Monaco, Consolas, "Lucida Console", monospace, sans-serif',
		),
		'montserrat' => array(
			'value' => 'montserrat',
			'label' => '"Montserrat", sans-serif',
		),
		'nobile' => array(
			'value' => 'nobile',
			'label' => '"Nobile", sans-serif',
		),
		'noto-serif' => array(
			'value' => 'noto-serif',
			'label' => '"Noto Serif", serif',
		),
		'neuton' => array(
			'value' => 'neuton',
			'label' => '"Neuton", serif',
		),
		'open-sans' => array(
			'value' => 'open-sans',
			'label' => '"Open Sans", sans-serif',
		),
		'oswald' => array(
			'value' => 'oswald',
			'label' => '"Oswald", sans-serif',
		),
		'palatino' => array(
			'value' => 'palatino',
			'label' => 'Palatino, "Palatino Linotype", "Book Antiqua", serif',
		),
		'patua-one' => array(
			'value' => 'patua-one',
			'label' => '"Patua One", sans-serif',
		),
		'playfair-display' => array(
			'value' => 'playfair-display',
			'label' => '"Playfair Display", sans-serif',
		),
		'pt-sans' => array(
			'value' => 'pt-sans',
			'label' => '"PT Sans", sans-serif',
		),
		'pt-serif' => array(
			'value' => 'pt-serif',
			'label' => '"PT Serif", serif',
		),
		'quattrocento-sans' => array(
			'value' => 'quattrocento-sans',
			'label' => '"Quattrocento Sans", sans-serif',
		),
		'roboto' => array(
			'value' => 'roboto',
			'label' => '"Roboto", sans-serif',
		),
		'roboto-slab' => array(
			'value' => 'roboto-slab',
			'label' => '"Roboto Slab", serif',
		),
		'sans-serif' => array(
			'value' => 'sans-serif',
			'label' => 'Sans Serif, Arial',
		),
		'source-sans-pro' => array(
			'value' => 'source-sans-pro',
			'label' => '"Source Sans Pro", sans-serif',
		),
		'tahoma' => array(
			'value' => 'tahoma',
			'label' => 'Tahoma, Geneva, sans-serif',
		),
		'trebuchet-ms' => array(
			'value' => 'trebuchet-ms',
			'label' => '"Trebuchet MS", "Helvetica", sans-serif',
		),
		'times-new-roman' => array(
			'value' => 'times-new-roman',
			'label' => '"Times New Roman", Times, serif',
		),
		'ubuntu' => array(
			'value' => 'ubuntu',
			'label' => '"Ubuntu", sans-serif',
		),
		'verdana' => array(
			'value' => 'verdana',
			'label' => 'Verdana, Geneva, sans-serif',
		),
		'yanone-kaffeesatz' => array(
			'value' => 'yanone-kaffeesatz',
			'label' => '"Yanone Kaffeesatz", sans-serif',
		),
	);

	return apply_filters( 'catchadaptive_avaliable_fonts', $avaliable_fonts );
}


/**
 * Returns list of social icons currently supported
 *
 * @since Catch Adaptive 0.1
*/
function catchadaptive_get_social_icons_list() {
	$catchadaptive_social_icons_list =	array( 
											__( 'Facebook', 'catch-adaptive' ), 
											__( 'Twitter', 'catch-adaptive' ), 
											__( 'Googleplus', 'catch-adaptive' ),
											__( 'Email', 'catch-adaptive' ),
											__( 'Feed', 'catch-adaptive' ),	
											__( 'WordPress', 'catch-adaptive' ), 
											__( 'GitHub', 'catch-adaptive' ), 
											__( 'LinkedIn', 'catch-adaptive' ), 
											__( 'Pinterest', 'catch-adaptive' ), 
											__( 'Flickr', 'catch-adaptive' ), 
											__( 'Vimeo', 'catch-adaptive' ), 
											__( 'YouTube', 'catch-adaptive' ), 
											__( 'Tumblr', 'catch-adaptive' ), 
											__( 'Instagram', 'catch-adaptive' ), 
											__( 'PollDaddy', 'catch-adaptive' ),
											__( 'CodePen', 'catch-adaptive' ), 
											__( 'Path', 'catch-adaptive' ), 
											__( 'Dribbble', 'catch-adaptive' ), 
											__( 'Skype', 'catch-adaptive' ), 
											__( 'Digg', 'catch-adaptive' ), 
											__( 'Reddit', 'catch-adaptive' ), 
											__( 'Stumbleupon', 'catch-adaptive' ), 
											__( 'Pocket', 'catch-adaptive' ), 
											__( 'DropBox', 'catch-adaptive' ),
											__( 'Spotify', 'catch-adaptive' ),
											__( 'Foursquare', 'catch-adaptive' ),											
											__( 'Spotify', 'catch-adaptive' ),
											__( 'Twitch', 'catch-adaptive' ),
										);

	return apply_filters( 'catchadaptive_social_icons_list', $catchadaptive_social_icons_list );
}


/**
 * Returns an array of metabox layout options registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_metabox_layouts() {
	$layout_options = array(
		'default' 	=> array(
			'id' 	=> 'catchadaptive-layout-option',
			'value' => 'default',
			'label' => __( 'Default', 'catch-adaptive' ),
		),
		'left-sidebar' 	=> array(
			'id' 	=> 'catchadaptive-layout-option',
			'value' => 'left-sidebar',
			'label' => __( 'Primary Sidebar, Content', 'catch-adaptive' ),
		),
		'right-sidebar' => array(
			'id' 	=> 'catchadaptive-layout-option',
			'value' => 'right-sidebar',
			'label' => __( 'Content, Primary Sidebar', 'catch-adaptive' ),
		),
		'no-sidebar'	=> array(
			'id' 	=> 'catchadaptive-layout-option',
			'value' => 'no-sidebar',
			'label' => __( 'No Sidebar ( Content Width )', 'catch-adaptive' ),
		),
	);
	return apply_filters( 'catchadaptive_layouts', $layout_options );
}

/**
 * Returns an array of metabox header featured image options registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_metabox_header_featured_image_options() {
	$header_featured_image_options = array(
		'default' => array(
			'id'		=> 'catchadaptive-header-image',
			'value' 	=> 'default',
			'label' 	=> __( 'Default', 'catch-adaptive' ),
		),
		'enable' => array(
			'id'		=> 'catchadaptive-header-image',
			'value' 	=> 'enable',
			'label' 	=> __( 'Enable', 'catch-adaptive' ),
		),	
		'disable' => array(
			'id'		=> 'catchadaptive-header-image',
			'value' 	=> 'disable',
			'label' 	=> __( 'Disable', 'catch-adaptive' )
		)
	);
	return apply_filters( 'header_featured_image_options', $header_featured_image_options );
}


/**
 * Returns an array of metabox sidebar options registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_metabox_sidebar_options() {
	$sidebar_options = array(
		'main-sidebar' => array(
			'id'		=> 'catchadaptive-sidebar-options',
			'value' 	=> 'default-sidebar',
			'label' 	=> __( 'Default Sidebar', 'catch-adaptive' )
		),
		'optional-sidebar-one' => array(
			'id' 	=> 'catchadaptive-sidebar-options',
			'value' => 'optional-sidebar-one',
			'label' => __( 'Optional Sidebar One', 'catch-adaptive' )
		),
		'optional-sidebar-two' => array(
			'id' 	=> 'catchadaptive-sidebar-options',
			'value' => 'optional-sidebar-two',
			'label' => __( 'Optional Sidebar Two', 'catch-adaptive' )
		),
		'optional-sidebar-three' => array(
			'id' 	=> 'catchadaptive-sidebar-options',
			'value' => 'optional-sidebar-three',
			'label' => __( 'Optional Sidebar three', 'catch-adaptive' )
		)
	);
	return apply_filters( 'sidebar_options', $sidebar_options );
}


/**
 * Returns an array of metabox featured image options registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_metabox_featured_image_options() {
	$featured_image_options = array(
		'default' => array(
			'id'		=> 'catchadaptive-featured-image',
			'value' 	=> 'default',
			'label' 	=> __( 'Default', 'catch-adaptive' ),
		),							   
		'featured' => array(
			'id'		=> 'catchadaptive-featured-image',
			'value' 	=> 'featured',
			'label' 	=> __( 'Featured Image', 'catch-adaptive' )
		),
		'full' => array(
			'id' => 'catchadaptive-featured-image',
			'value' => 'full',
			'label' => __( 'Full Size', 'catch-adaptive' )
		),
		'disable' => array(
			'id' => 'catchadaptive-featured-image',
			'value' => 'disable',
			'label' => __( 'Disable Image', 'catch-adaptive' )
		)
	);
	return apply_filters( 'featured_image_options', $featured_image_options );
}

/**
 * Returns catchadaptive_contents registered for catchadaptive.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_get_content() {
	$theme_data = wp_get_theme();

	$catchadaptive_content['left'] 	= sprintf( _x( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', '1: Year, 2: Site Title with home URL', 'catch-adaptive' ), date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );

	$catchadaptive_content['right']	= esc_attr( $theme_data->get( 'Name') ) . '&nbsp;' . __( 'by', 'catch-adaptive' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_attr( $theme_data->get( 'Author' ) ) .'</a>';

	return apply_filters( 'catchadaptive_get_content', $catchadaptive_content );
}