<?php
/**
 * Core functions and definitions
 *
 * Sets up the theme
 *
 * The first function, catchadaptive_initial_setup(), sets up the theme by registering support
 * for various features in WordPress, such as theme support, post thumbnails, navigation menu, and the like.
 *
 * Catch Adaptive functions and definitions
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
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 860; /* pixels */


if ( ! function_exists( 'catchadaptive_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	function catchadaptive_setup() {
		/**
		 * Get Theme Options Values
		 */		
		$options 	= catchadaptive_get_theme_options();
		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on catchadaptive, use a find and replace
		 * to change 'catch-adaptive' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'catch-adaptive', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// Used for Featured Content, Featured Grid Content and Archive/blog Featured Image
    	add_image_size( 'catchadaptive-featured-content', 410, 231, true); // used in Featured Content Options Ratio 16:9

        // Used for Featured Slider Ratio 21:9
        add_image_size( 'catchadaptive-slider', 1680, 720, true);

        //Used For Archive Landescape Ratio 16:9
    	add_image_size( 'catchadaptive-featured', 860, 484, true);

    	// Used for Archive No-Sidebar-Full-Width 21:9
    	add_image_size( 'catchadaptive-featured-full', 1200, 514, true);

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary' 	=> __( 'Primary Menu', 'catch-adaptive' )
		) );

		/**
		 * Enable support for Post Formats
		 */
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		/**
		 * Setup the WordPress core custom background feature.
		 */
		if ( $options['color_scheme'] != 'light' ) {
			$default_color = '202020';
		}
		else {
			$default_color = 'ffffff';
		}
		add_theme_support( 'custom-background', apply_filters( 'catchbase_custom_background_args', array(
			'default-color' => $default_color
		) ) );
		
		/**
		 * Setup Editor style
		 */
		add_editor_style( 'css/editor-style.css' );

		/**
		 * Setup title support for theme
		 * Supported from WordPress version 4.1 onwards 
		 * More Info: https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Setup Infinite Scroll using JetPack if navigation type is set
		 */
		$pagination_type	= isset( $options['pagination_type'] ) ? $options['pagination_type'] : '';

		if( 'infinite-scroll-click' == $pagination_type ) {
			add_theme_support( 'infinite-scroll', array(
				'type'		=> 'click',
				'container' => 'main',
				'footer'    => 'page',
				'wrapper'        => false
			) );
		}
		else if ( 'infinite-scroll-scroll' == $pagination_type ) {
			add_theme_support( 'infinite-scroll', array(
				'type'		=> 'scroll',
				'container' => 'main',
				'footer'    => 'page',
				'wrapper'        => false
			) );
		}
	}
endif; // catchadaptive_setup
add_action( 'after_setup_theme', 'catchadaptive_setup' );


/**
 * Enqueue scripts and styles
 *
 * @uses  wp_register_script, wp_enqueue_script, wp_register_style, wp_enqueue_style, wp_localize_script
 * @action wp_enqueue_scripts
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_scripts() {
	$options			= catchadaptive_get_theme_options();

	wp_enqueue_style( 'catchadaptive-style', get_stylesheet_uri() );

	wp_enqueue_script( 'catchadaptive-navigation', get_template_directory_uri() . '/js/navigation.min.js', array(), '20120206', true );

	wp_enqueue_script( 'catchadaptive-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.min.js', array(), '20130115', true );

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	//For genericons
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/css/genericons/genericons.css', false, '3.3' );

	/**
	 * Enqueue the styles for the current color scheme for catchadaptive.
	 */
	if ( $options['color_scheme'] != 'light' ) {
		wp_enqueue_style( 'catchadaptive-dark', get_template_directory_uri() . '/css/colors/'. $options['color_scheme'] .'.css', array(), null );
	}
	
	/**
	 * Loads up Responsive menu and video script
	 */		
	wp_enqueue_script( 'sidr', get_template_directory_uri() . '/js/jquery.sidr.min.js', array('jquery'), '1.2.1', false );	

	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.min.js', array( 'jquery' ), '1.1', true );
	

	/**
	 * Loads up Cycle JS
	 */
	if( 'disabled' != $options['featured_slider_option'] || $options['featured_content_slider']  ) {
		wp_register_script( 'jquery.cycle2', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.min.js', array( 'jquery' ), '2.1.5', true );

		/**
		 * Condition checks for additional slider transition plugins
		 */
		// Scroll Vertical transition plugin addition
		if ( 'scrollVert' ==  $options['featured_slide_transition_effect'] ){
			wp_enqueue_script( 'jquery.cycle2.scrollVert', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.scrollVert.min.js', array( 'jquery.cycle2' ), '20140128', true );
		}
		// Flip transition plugin addition
		else if ( 'flipHorz' ==  $options['featured_slide_transition_effect'] || 'flipVert' ==  $options['featured_slide_transition_effect'] ){
			wp_enqueue_script( 'jquery.cycle2.flip', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.flip.min.js', array( 'jquery.cycle2' ), '20140128', true );
		}
		// Suffle transition plugin addition
		else if ( 'tileSlide' ==  $options['featured_slide_transition_effect'] || 'tileBlind' ==  $options['featured_slide_transition_effect'] ){
			wp_enqueue_script( 'jquery.cycle2.tile', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.tile.min.js', array( 'jquery.cycle2' ), '20140128', true );
		}
		// Suffle transition plugin addition
		else if ( 'shuffle' ==  $options['featured_slide_transition_effect'] ){
			wp_enqueue_script( 'jquery.cycle2.shuffle', get_template_directory_uri() . '/js/jquery.cycle/jquery.cycle2.shuffle.min.js', array( 'jquery.cycle2' ), '20140128 ', true );
		}
		else {
			wp_enqueue_script( 'jquery.cycle2' );
		}
	}

	/**
	 * Loads up Scroll Up script
	 */	
	wp_enqueue_script( 'catchadaptive-scrollup', get_template_directory_uri() . '/js/catchadaptive-scrollup.min.js', array( 'jquery' ), '20072014', true  );
	
	/**
	 * Load Masonry for Column Layout
	 */
	if ( ( is_archive() || is_home() ) && 'columns-layout' == $options['content_layout'] ) {
		wp_enqueue_script( 'catchadaptive-custom-masonry', get_template_directory_uri() . '/js/catchadaptive-custom.masonry.min.js', array( 'masonry' ), true );		
	}

	/**
	 * Enqueue custom script for catchadaptive.
	 */
	wp_enqueue_script( 'catchadaptive-custom-scripts', get_template_directory_uri() . '/js/catchadaptive-custom-scripts.min.js', array( 'jquery' ), null );
}
add_action( 'wp_enqueue_scripts', 'catchadaptive_scripts' );


/**
 * Enqueue scripts and styles for Metaboxes
 * @uses wp_register_script, wp_enqueue_script, and  wp_enqueue_style
 *
 * @action admin_print_scripts-post-new, admin_print_scripts-post, admin_print_scripts-page-new, admin_print_scripts-page
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_enqueue_metabox_scripts() {
    //Scripts
	wp_enqueue_script( 'catchadaptive-metabox', get_template_directory_uri() . '/js/catchadaptive-metabox.min.js', array( 'jquery' , 'jquery-ui-tabs' ), '2013-10-05' );
	
	//CSS Styles
	wp_enqueue_style( 'catchadaptive-metabox-tabs', get_template_directory_uri() . '/css/catchadaptive-metabox-tabs.css' );
}
add_action( 'admin_print_scripts-post-new.php', 'catchadaptive_enqueue_metabox_scripts', 11 );
add_action( 'admin_print_scripts-post.php', 'catchadaptive_enqueue_metabox_scripts', 11 );
add_action( 'admin_print_scripts-page-new.php', 'catchadaptive_enqueue_metabox_scripts', 11 );
add_action( 'admin_print_scripts-page.php', 'catchadaptive_enqueue_metabox_scripts', 11 );


/**
 * Default Options.
 */
require get_template_directory() . '/inc/catchadaptive-default-options.php';

/**
 * Custom Header.
 */
require get_template_directory() . '/inc/catchadaptive-custom-header.php';


/**
 * Structure for catchadaptive
 */
require get_template_directory() . '/inc/catchadaptive-structure.php';


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer-includes/catchadaptive-customizer.php';


/**
 * Custom Menus
 */
require get_template_directory() . '/inc/catchadaptive-menus.php';


/**
 * Load Slider file.
 */
require get_template_directory() . '/inc/catchadaptive-featured-slider.php';


/**
 * Load Featured Content.
 */
require get_template_directory() . '/inc/catchadaptive-featured-content.php';


/**
 * Load Breadcrumb file.
 */
require get_template_directory() . '/inc/catchadaptive-breadcrumb.php';


/**
 * Load Widgets and Sidebars
 */
require get_template_directory() . '/inc/catchadaptive-widgets.php';


/**
 * Load Social Icons
 */
require get_template_directory() . '/inc/catchadaptive-social-icons.php';


/**
 * Load Metaboxes
 */
require get_template_directory() . '/inc/catchadaptive-metabox.php';


/**
 * Returns the options array for catchadaptive.
 * @uses  get_theme_mod
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_get_theme_options() {
	return get_theme_mod( 'catchadaptive_theme_options', catchadaptive_get_default_theme_options() );
}


/**
 * Flush out all transients
 *
 * @uses delete_transient 
 * 
 * @action customize_save, catchadaptive_customize_preview (see catchadaptive_customizer function: catchadaptive_customize_preview)
 * 
 * @since Catch Adaptive 0.1
 */
function catchadaptive_flush_transients(){
	delete_transient( 'catchadaptive_featured_content' );
	
	delete_transient( 'catchadaptive_featured_slider' );

	delete_transient( 'catchadaptive_favicon' );

	delete_transient( 'catchadaptive_webclip' );

	delete_transient( 'catchadaptive_custom_css' );

	delete_transient( 'catchadaptive_footer_content' );	

	delete_transient( 'catchadaptive_promotion_headline' );

	delete_transient( 'catchadaptive_featured_image' );

	delete_transient( 'catchadaptive_social_icons' );	

	delete_transient( 'catchadaptive_scrollup' );

	delete_transient( 'all_the_cool_cats' );

	//Add Adaptive default themes if there i 
	if ( !get_theme_mod('catchadaptive_theme_options') ) {
		set_theme_mod( 'catchadaptive_theme_options', catchadaptive_get_default_theme_options() );
	}
}
add_action( 'customize_save', 'catchadaptive_flush_transients' );

/**
 * Flush out category transients
 *
 * @uses delete_transient 
 * 
 * @action edit_category
 * 
 * @since Catch Adaptive 0.1
 */
function catchadaptive_flush_category_transients(){
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'catchadaptive_flush_category_transients' );


/**
 * Flush out post related transients
 *
 * @uses delete_transient 
 * 
 * @action save_post
 * 
 * @since Catch Adaptive 0.1
 */
function catchadaptive_flush_post_transients(){
	delete_transient( 'catchadaptive_featured_content' );
	
	delete_transient( 'catchadaptive_featured_slider' );

	delete_transient( 'catchadaptive_featured_image' );

	delete_transient( 'all_the_cool_cats' );
}
add_action( 'save_post', 'catchadaptive_flush_post_transients' );


if ( ! function_exists( 'catchadaptive_favicon' ) ) :
	/**
	 * Get the favicon Image options
	 *
	 * @uses favicon 
	 * @get the data value of image from options
	 * @display favicon
	 *
	 * @uses set_transient
	 *
	 * @action wp_head, admin_head
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_favicon() {
		if( ( !$catchadaptive_favicon = get_transient( 'catchadaptive_favicon' ) ) ) {
			$options 	= catchadaptive_get_theme_options();
			
			echo '<!-- refreshing cache -->';
			
			if ( isset( $options[ 'favicon' ] ) &&  $options[ 'favicon' ] != '' &&  !empty( $options[ 'favicon' ] ) ) {
				// if not empty fav_icon on options
				$catchadaptive_favicon = '<link rel="shortcut icon" href="'.esc_url( $options[ 'favicon' ] ).'" type="image/x-icon" />'; 	
			}

			set_transient( 'catchadaptive_favicon', $catchadaptive_favicon, 86940 );	
		}
		echo $catchadaptive_favicon ;	
	}
endif; //catchadaptive_favicon
//Load Favicon in Header Section
add_action( 'wp_head', 'catchadaptive_favicon' );
//Load Favicon in Admin Section
add_action( 'admin_head', 'catchadaptive_favicon' );


if ( ! function_exists( 'catchadaptive_web_clip' ) ) :
	/**
	 * Get the Web Clip Icon Image from options
	 *
	 * @uses web_clip and remove_web_clip 
	 * @get the data value of image from theme options
	 * @display web clip
	 *
	 * @uses default Web Click Icon if web_clip field on theme options is empty
	 *
	 * @uses set_transient and delete_transient 
	 *
	 * @action wp_head
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_web_clip() {
		if( ( !$catchadaptive_web_clip = get_transient( 'catchadaptive_web_clip' ) ) ) {
			$options 	= catchadaptive_get_theme_options();
			
			echo '<!-- refreshing cache -->';
			
			if ( isset( $options[ 'web_clip' ] ) &&  $options[ 'web_clip' ] != '' &&  !empty( $options[ 'web_clip' ] ) ){
				$catchadaptive_web_clip = '<link rel="apple-touch-icon-precomposed" href="'.esc_url( $options[ 'web_clip' ] ).'" />'; 	
			}
			
			set_transient( 'catchadaptive_web_clip', $catchadaptive_web_clip, 86940 );	
		}	
		echo $catchadaptive_web_clip ;	
	}
endif; //catchadaptive_web_clip
//Load Web Clip Icon in Header Section
add_action('wp_head', 'catchadaptive_web_clip');


if ( ! function_exists( 'catchadaptive_custom_css' ) ) :
	/**
	 * Enqueue Custon CSS
	 *
	 * @uses  set_transient, wp_head, wp_enqueue_style
	 *
	 * @action wp_enqueue_scripts
	 * 
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_custom_css() {
		//catchadaptive_flush_transients();
		$options 	= catchadaptive_get_theme_options();

		$defaults 	= catchadaptive_get_default_theme_options();
		
		if ( ( !$catchadaptive_custom_css = get_transient( 'catchadaptive_custom_css' ) ) ) {		
			$catchadaptive_custom_css ='';

			$text_color = get_header_textcolor();
			if ( 'blank' == $text_color ){
				$catchadaptive_custom_css	.=  ".site-title a, .site-description { position: absolute !important; clip: rect(1px 1px 1px 1px); clip: rect(1px, 1px, 1px, 1px); }". "\n";
			}
			elseif ( HEADER_TEXTCOLOR != $text_color ) {
				$catchadaptive_custom_css	.=  ".site-title a, .site-title a:hover, .site-description { color: #".  $text_color ."; }". "\n";
			}

			// Featured Content Background Image Options
			if( $defaults['featured_content_background_image'] != $options['featured_content_background_image'] ) {
				$catchadaptive_custom_css .= "#featured-content {". "\n";
				$catchadaptive_custom_css .=  "background-image: url(\"". esc_url( $options[ 'featured_content_background_image' ] ) ."\");". "\n";
				$catchadaptive_custom_css .= "}";
			}


			//Custom CSS Option		
			if( !empty( $options[ 'custom_css' ] ) ) {
				$catchadaptive_custom_css	.=  $options['custom_css'] . "\n";
			}			

			if ( '' != $catchadaptive_custom_css ){
				echo '<!-- refreshing cache -->' . "\n";
				
				$catchadaptive_custom_css = '<!-- '.get_bloginfo('name').' inline CSS Styles -->' . "\n" . '<style type="text/css" media="screen">' . "\n" . $catchadaptive_custom_css;
			
				$catchadaptive_custom_css .= '</style>' . "\n";
			
			}
			
			set_transient( 'catchadaptive_custom_css', htmlspecialchars_decode( $catchadaptive_custom_css ), 86940 );
		}
		
		echo $catchadaptive_custom_css;
	}
endif; //catchadaptive_custom_css
add_action( 'wp_head', 'catchadaptive_custom_css', 101  );


/**
 * Alter the query for the main loop in homepage
 * 
 * @action pre_get_posts
 * 
 * @since Catch Adaptive 0.1
 */
function catchadaptive_alter_home( $query ){
	if( $query->is_main_query() && $query->is_home() ) {
    	$options 	= catchadaptive_get_theme_options();
		
	    $cats 		= $options[ 'front_page_category' ];

		$post_list	= array();	// list of valid post ids

		if ( is_array( $cats ) && !in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] =  $cats;
		}
	}
}
add_action( 'pre_get_posts','catchadaptive_alter_home' );


if ( ! function_exists( 'catchadaptive_content_nav' ) ) :
	/**
	 * Display navigation to next/previous pages when applicable
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_content_nav( $nav_id ) {
		global $wp_query, $post;

		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous )
				return;
		}
		
		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$options			= catchadaptive_get_theme_options();
		
		$pagination_type	= $options['pagination_type'];

		$nav_class = ( is_single() ) ? 'site-navigation post-navigation' : 'site-navigation paging-navigation';
		
		/**
		 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled, else goto default pagination
		 * if it's active then disable pagination
		 */
		if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
			return false;
		}

		?>
	        <nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>">
	        	<h3 class="screen-reader-text"><?php _e( 'Post navigation', 'catch-adaptive' ); ?></h3>
				<?php
				/**
				 * Check if navigation type is numeric and if Wp-PageNavi Plugin is enabled
				 */
				if ( 'numeric' == $pagination_type && function_exists( 'wp_pagenavi' ) ) {
					wp_pagenavi();
	            }
	            else { ?>	
	                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'catch-adaptive' ) ); ?></div>
	                <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'catch-adaptive' ) ); ?></div>
	            <?php 
	            } ?>
	        </nav><!-- #nav -->	
		<?php
	}
endif; // catchadaptive_content_nav


if ( ! function_exists( 'catchadaptive_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:', 'catch-adaptive' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'catch-adaptive' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
						<?php printf( __( '%s <span class="says">says:</span>', 'catch-adaptive' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'catch-adaptive' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit', 'catch-adaptive' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'catch-adaptive' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					) ) );
				?>
			</article><!-- .comment-body -->

		<?php
		endif;
	}
endif; // catchadaptive_comment()


if ( ! function_exists( 'catchadaptive_the_attached_image' ) ) :
	/**
	 * Prints the attached image with a link to the next attached image.
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_the_attached_image() {
		$post                = get_post();
		$attachment_size     = apply_filters( 'catchadaptive_attachment_size', array( 1200, 1200 ) );
		$next_attachment_url = wp_get_attachment_url();

		/**
		 * Grab the IDs of all the image attachments in a gallery so we can get the
		 * URL of the next adjacent image in a gallery, or the first image (if
		 * we're looking at the last image in a gallery), or, in a gallery of one,
		 * just the link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => 1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id )
				$next_attachment_url = get_attachment_link( $next_id );

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}

		printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url( $next_attachment_url ),
			the_title_attribute( array( 'echo' => false ) ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
endif; //catchadaptive_the_attached_image


if ( ! function_exists( 'catchadaptive_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_entry_meta() {
		echo '<p class="entry-meta">';

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		printf( '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			sprintf( _x( '<span class="screen-reader-text">Posted on</span>', 'Used before publish date.', 'catch-adaptive' ) ),
			esc_url( get_permalink() ),
			$time_string
		);

		if ( is_singular() || is_multi_author() ) {
			printf( '<span class="byline"><span class="author vcard">%1$s<a class="url fn n" href="%2$s">%3$s</a></span></span>',
				sprintf( _x( '<span class="screen-reader-text">Author</span>', 'Used before post author name.', 'catch-adaptive' ) ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			);
		}

		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'catch-adaptive' ), esc_html__( '1 Comment', 'catch-adaptive' ), esc_html__( '% Comments', 'catch-adaptive' ) );
			echo '</span>';
		}

		edit_post_link( esc_html__( 'Edit', 'catch-adaptive' ), '<span class="edit-link">', '</span>' ); 

		echo '</p><!-- .entry-meta -->';
	}
endif; //catchadaptive_entry_meta


if ( ! function_exists( 'catchadaptive_tag_category' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags.
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_tag_category() {
		echo '<p class="entry-meta">';

		if ( 'post' == get_post_type() ) {
			$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'catch-adaptive' ) );
			if ( $categories_list && catchadaptive_categorized_blog() ) {
				printf( '<span class="cat-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Categories</span>', 'Used before category names.', 'catch-adaptive' ) ),
					$categories_list
				);
			}

			$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'catch-adaptive' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Tags</span>', 'Used before tag names.', 'catch-adaptive' ) ),
					$tags_list
				);
			}
		}

		echo '</p><!-- .entry-meta -->';
	}
endif; //catchadaptive_tag_category


/**
 * Returns true if a blog has more than 1 category
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so catchadaptive_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so catchadaptive_categorized_blog should return false
		return false;
	}
}


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'catchadaptive_page_menu_args' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'catchadaptive_enhanced_image_navigation', 10, 2 );


/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'footer-1' ) )
		$count++;

	if ( is_active_sidebar( 'footer-2' ) )
		$count++;

	if ( is_active_sidebar( 'footer-3' ) )
		$count++;

	if ( is_active_sidebar( 'footer-4' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}


if ( ! function_exists( 'catchadaptive_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_excerpt_length( $length ) {
		// Getting data from Customizer Options
		$options	= catchadaptive_get_theme_options();
		$length	= $options['excerpt_length'];
		return $length;
	}
endif; //catchadaptive_excerpt_length
add_filter( 'excerpt_length', 'catchadaptive_excerpt_length' );


/**
 * Change the defult excerpt length of 30 to whatever passed as value
 * 
 * @use excerpt(10) or excerpt (..)  if excerpt length needs only 10 or whatevere
 * @uses get_permalink, get_the_excerpt
 */
function catchadaptive_excerpt_desired( $num ) {
    $limit = $num+1;
    $excerpt = explode( ' ', get_the_excerpt(), $limit );
    array_pop( $excerpt );
    $excerpt = implode( " ",$excerpt )."<a href='" .get_permalink() ." '></a>";
    return $excerpt;
}


if ( ! function_exists( 'catchadaptive_continue_reading' ) ) :
	/**
	 * Returns a "Custom Continue Reading" link for excerpts
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_continue_reading() {
		// Getting data from Customizer Options
		$options		=	catchadaptive_get_theme_options();
		$more_tag_text	= $options['excerpt_more_text'];

		return ' <a class="more-link" href="' . esc_url( get_permalink() ) . '">' .  sprintf( __( '%s', 'catch-adaptive' ) , $more_tag_text ) . '</a>';
	}
endif; //catchadaptive_continue_reading
add_filter( 'excerpt_more', 'catchadaptive_continue_reading' );


if ( ! function_exists( 'catchadaptive_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with catchadaptive_continue_reading().
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_excerpt_more( $more ) {
		return catchadaptive_continue_reading();	
	}
endif; //catchadaptive_excerpt_more
add_filter( 'excerpt_more', 'catchadaptive_excerpt_more' );


if ( ! function_exists( 'catchadaptive_custom_excerpt' ) ) :
	/**
	 * Adds Continue Reading link to more tag excerpts.
	 *
	 * function tied to the get_the_excerpt filter hook.
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_custom_excerpt( $output ) {
		if ( has_excerpt() && ! is_attachment() ) {
			$output .= catchadaptive_continue_reading();
		}
		return $output;
	}
endif; //catchadaptive_custom_excerpt
add_filter( 'get_the_excerpt', 'catchadaptive_custom_excerpt' );


if ( ! function_exists( 'catchadaptive_more_link' ) ) :
	/**
	 * Replacing Continue Reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_more_link( $more_link, $more_link_text ) {
	 	$options		=	catchadaptive_get_theme_options();
		$more_tag_text	= $options['excerpt_more_text'];

		return str_replace( $more_link_text, $more_tag_text, $more_link );
	}
endif; //catchadaptive_more_link
add_filter( 'the_content_more_link', 'catchadaptive_more_link', 10, 2 );


if ( ! function_exists( 'catchadaptive_body_classes' ) ) :
	/**
	 * Adds Catch Adaptive layout classes to the array of body classes.
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_body_classes( $classes ) {
		global $post, $wp_query;

		// Adds a class of group-blog to blogs with more than 1 published author
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Front page displays in Reading Settings
	    $page_on_front 	= get_option('page_on_front') ;
	    $page_for_posts = get_option('page_for_posts');

	    // Get Page ID outside Loop
	    $page_id = $wp_query->get_queried_object_id();

	    // Blog Page or Front Page setting in Reading Settings
		if ( $page_id == $page_for_posts || $page_id == $page_on_front ) {
	        $layout = get_post_meta( $page_id,'catchadaptive-layout-option', true );
	    }
	    else if ( is_singular() ) {
	 		if ( is_attachment() ) { 
				$parent = $post->post_parent;
				
				$layout = get_post_meta( $parent,'catchadaptive-layout-option', true );
			} else {
				$layout = get_post_meta( $post->ID,'catchadaptive-layout-option', true ); 
			}
		}
		else {
			$layout = 'default';
		}	

		//check empty and load default
		if( empty( $layout ) ) {
			$layout = 'default';
		}    	

		$options 		= catchadaptive_get_theme_options();
			
		$current_layout = $options['theme_layout'];

		if( 'default' == $layout ) {
			$layout_selector = $current_layout;
		}
		else {
			$layout_selector = $layout;
		}

		switch ( $layout_selector ) {
			case 'left-sidebar':
				$classes[] = 'two-columns content-right';
			break;
			
			case 'right-sidebar':
				$classes[] = 'two-columns content-left';
			break;
			
			case 'no-sidebar':
				$classes[] = 'no-sidebar content-width';
			break;
		}

		if ( is_archive() || is_home() ) {
			$current_content_layout = $options['content_layout'];
			if( "" != $current_content_layout ) {
				$classes[] = $current_content_layout;
			}
			if( 'columns-layout' == $current_content_layout ) {
				$classes[] = 'catchadaptive-masonry';
			}
		}

		$classes 	= apply_filters( 'catchadaptive_body_classes', $classes );

		return $classes;
	} 
endif; //catchadaptive_body_classes
add_filter( 'body_class', 'catchadaptive_body_classes' );


if ( ! function_exists( 'catchadaptive_post_classes' ) ) :
	/**
	 * Adds Catch Adaptive post classes to the array of post classes.
	 * used for supporting different content layouts
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_post_classes( $classes ) {
		//Getting Ready to load data from Theme Options Panel
		$options 		= catchadaptive_get_theme_options();
	
		$current_content_layout = $options['content_layout'];

		/*if ( is_archive() || is_home() ) {
			$classes[] = $contentlayout;
		}*/
		if ( ( is_archive() || is_home() ) && ( 'columns-layout' == $current_content_layout ) ) {
			if( is_sticky() ) {
				$classes[] = 'masonry-full';
    		} 
    		else {
    			$classes[] = 'masonry-normal';
    		}

		}


		return $classes;
    }
endif; //catchadaptive_post_classes
add_filter( 'post_class', 'catchadaptive_post_classes' );

if ( ! function_exists( 'catchadaptive_responsive' ) ) :
	/**
	 * Responsive Layout
	 *
	 * @get the data value of responsive layout from theme options
	 * @display responsive meta tag
	 * @action wp_head
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_responsive() {

		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

	}
endif; //catchadaptive_responsive
add_filter( 'wp_head', 'catchadaptive_responsive', 1 );


if ( ! function_exists( 'catchadaptive_archive_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply create your own catchadaptive_archive_content_image(), and that function will be used instead.
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_archive_content_image() {
		$options 			= catchadaptive_get_theme_options();
		
		$featured_image = $options['content_layout'];

		$current_layout = $options['theme_layout'];
			
		if ( has_post_thumbnail() && 'full-content' != $featured_image ) { ?>
			<figure class="featured-image">
	            <a rel="bookmark" href="<?php the_permalink(); ?>">
	                <?php 
						if ( $featured_image == 'excerpt-image-left' ) {
		                    the_post_thumbnail( 'catchadaptive-featured-content' );
		                }
		                elseif ( $featured_image == 'columns-layout' ) {         	
							if ( is_sticky() ) {
		                    	the_post_thumbnail( 'catchadaptive-featured' );
		                	}
		                	else { 
		                		the_post_thumbnail( 'catchadaptive-featured-content' );
		                	}
		                }
		               	elseif ( $featured_image == 'excerpt-full-image' ) {
		                    the_post_thumbnail( 'full' );
		                }		                
					?>
				</a>
	        </figure>
	   	<?php
		}
	}
endif; //catchadaptive_archive_content_image
add_action( 'catchadaptive_before_entry_container', 'catchadaptive_archive_content_image', 10 );


if ( ! function_exists( 'catchadaptive_single_content_image' ) ) :
	/**
	 * Template for Featured Image in Single Post
	 *
	 * To override this in a child theme
	 * simply create your own catchadaptive_single_content_image(), and that function will be used instead.
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_single_content_image() {
		global $post, $wp_query;
		
		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		if( $post ) {
	 		if ( is_attachment() ) { 
				$parent = $post->post_parent;
				$individual_featured_image 	= get_post_meta( $parent,'catchadaptive-featured-image', true );
				$individual_layout			= get_post_meta( $parent,'catchadaptive-layout-option', true );
			} else {
				$individual_featured_image 	= get_post_meta( $page_id,'catchadaptive-featured-image', true );
				$individual_layout			= get_post_meta( $page_id,'catchadaptive-layout-option', true );
			}
		}

		if( empty( $individual_featured_image ) || ( !is_page() && !is_single() ) ) {
			$individual_featured_image = 'default';
		}

		if( empty( $individual_layout ) || ( !is_page() && !is_single() ) ) {
			$individual_layout = 'default';
		}
		
		// Getting data from Theme Options
	   	$options = catchadaptive_get_theme_options();
		
		$featured_image = $options['single_post_image_layout'];

		if ( ( $individual_featured_image == 'disable' || '' == get_the_post_thumbnail() || ( $individual_featured_image=='default' && $featured_image == 'disabled') ) ) {
			echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
			return false;
		}
		else {
			$class = '';

			if ( 'default' == $individual_featured_image ) {
				$class = $featured_image;
			}
			else {
				$class = 'from-metabox ' . $individual_featured_image;
			}

			?>
			<figure class="featured-image <?php echo $class; ?>">
                <?php 
				if ( $individual_featured_image == 'featured' || ( $individual_featured_image=='default' && $featured_image == 'featured' ) ) {
                    the_post_thumbnail( 'catchadaptive-featured' );
                }
                else {
					the_post_thumbnail( 'full' );
				} ?>
	        </figure>
	   	<?php
		}
	}
endif; //catchadaptive_single_content_image
add_action( 'catchadaptive_before_post_container', 'catchadaptive_single_content_image', 10 );
add_action( 'catchadaptive_before_page_container', 'catchadaptive_single_content_image', 10 );


if ( ! function_exists( 'catchadaptive_get_comment_section' ) ) :
	/**
	 * Comment Section
	 *
	 * @get comment setting from theme options and display comments sections accordingly
	 * @display comments_template
	 * @action catchadaptive_comment_section
	 *
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_get_comment_section() {
		if ( comments_open() || '0' != get_comments_number() ) {
				comments_template();
		}
	}
endif;
add_action( 'catchadaptive_comment_section', 'catchadaptive_get_comment_section', 10 );


if ( ! function_exists( 'catchadaptive_promotion_headline' ) ) :
	/**
	 * Template for Promotion Headline
	 *
	 * To override this in a child theme
	 * simply create your own catchadaptive_promotion_headline(), and that function will be used instead.
	 *
	 * @uses catchadaptive_before_main action to add it in the header
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_promotion_headline() { 
		//delete_transient( 'catchadaptive_promotion_headline' );
		
		global $post, $wp_query;
	   	$options 	= catchadaptive_get_theme_options();

		$promotion_headline 		= $options['promotion_headline'];
		$promotion_subheadline 		= $options['promotion_subheadline'];
		$promotion_headline_button 	= $options['promotion_headline_button'];
		$promotion_headline_target 	= $options['promotion_headline_target'];
		$enablepromotion 			= $options['promotion_headline_option'];
		
		//support qTranslate plugin
		if ( function_exists( 'qtrans_convertURL' ) ) {
			$promotion_headline_url = qtrans_convertURL($options[ 'promotion_headline_url' ]);
		}
		else {
			$promotion_headline_url = $options[ 'promotion_headline_url' ];
		}
		
		// Front page displays in Reading Settings
		$page_on_front = get_option( 'page_on_front' ) ;
		$page_for_posts = get_option('page_for_posts'); 

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		 if ( ( "" != $promotion_headline || "" != $promotion_subheadline || "" != $promotion_headline_url ) && ( $enablepromotion == 'entire-site' || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enablepromotion == 'homepage' ) ) ) { 	
			
			if ( !$catchadaptive_promotion_headline = get_transient( 'catchadaptive_promotion_headline' ) ) {
				
				echo '<!-- refreshing cache -->';	
				
				$catchadaptive_promotion_headline = '
				<div id="promotion-message">
					<div class="wrapper">
						<div class="section left">';
				
						if ( "" != $promotion_headline ) {
							$catchadaptive_promotion_headline .= '<h2>' . $promotion_headline . '</h2>';
						}

						if ( "" != $promotion_subheadline ) {
							$catchadaptive_promotion_headline .= '<p>' . $promotion_subheadline . '</p>';
						}			
						
						$catchadaptive_promotion_headline .= '
						</div><!-- .section.left -->';  
							
						if ( "" != $promotion_headline_url ) {
							if ( "1" == $promotion_headline_target ) {
								$headlinetarget = '_blank';
							}
							else {
								$headlinetarget = '_self';
							}
							
							$catchadaptive_promotion_headline .= '
							<div class="section right">
								<a href="' . esc_url( $promotion_headline_url ) . '" target="' . $headlinetarget . '">' . esc_attr( $promotion_headline_button ) . '
								</a>
							</div><!-- .section.right -->';
						}
				
				$catchadaptive_promotion_headline .= '
					</div><!-- .wrapper -->
				</div><!-- #promotion-message -->';
				
				set_transient( 'catchadaptive_promotion_headline', $catchadaptive_promotion_headline, 86940 );
			}
			echo $catchadaptive_promotion_headline;	
		 }
	}
endif; // catchadaptive_promotion_featured_content
add_action( 'catchadaptive_before_content', 'catchadaptive_promotion_headline', 50 );


/**
 * Footer Text
 *
 * @get footer text from theme options and display them accordingly
 * @display footer_text
 * @action catchadaptive_footer
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_footer_content() {
	//catchadaptive_flush_transients();
	if ( ( !$catchadaptive_footer_content = get_transient( 'catchadaptive_footer_content' ) ) ) {
		echo '<!-- refreshing cache -->';
		
		$catchadaptive_content = catchadaptive_get_content();

		$catchadaptive_footer_content =  '    	
    	<div id="site-generator" class="two">
    		<div class="wrapper">
    			<div id="footer-left-content" class="copyright">' . $catchadaptive_content['left'] . '</div>

    			<div id="footer-right-content" class="powered">' . $catchadaptive_content['right'] . '</div>
			</div><!-- .wrapper -->
		</div><!-- #site-generator -->';
		
    	set_transient( 'catchadaptive_footer_content', $catchadaptive_footer_content, 86940 );
    }

    echo $catchadaptive_footer_content;
}
add_action( 'catchadaptive_footer', 'catchadaptive_footer_content', 100 );


/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Catch Adaptive 0.1
 */

function catchadaptive_get_first_image( $postID, $size, $attr ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if( isset( $matches [1] [0] ) ) {
		//Get first image
		$first_img = $matches [1] [0];
		
		return '<img class="pngfix wp-post-image" src="'. $first_img .'">';
	}
	
	return false;
}


if ( ! function_exists( 'catchadaptive_scrollup' ) ) {
	/**
	 * This function loads Scroll Up Navigation
	 *
	 * @action catchadaptive_footer action
	 * @uses set_transient and delete_transient
	 */
	function catchadaptive_scrollup() {
		//catchadaptive_flush_transients();
		if ( !$catchadaptive_scrollup = get_transient( 'catchadaptive_scrollup' ) ) {

			// get the data value from theme options
			$options = catchadaptive_get_theme_options();
			echo '<!-- refreshing cache -->';	
			
			//site stats, analytics header code
			$catchadaptive_scrollup =  '<a href="#masthead" id="scrollup" class="genericon"><span class="screen-reader-text">' . __( 'Scroll Up', 'catch-adaptive' ) . '</span></a>' ;
			
			set_transient( 'catchadaptive_scrollup', $catchadaptive_scrollup, 86940 );
		}
		echo $catchadaptive_scrollup;	
	}
}
add_action( 'catchadaptive_after', 'catchadaptive_scrollup', 10 );


if ( ! function_exists( 'catchadaptive_page_post_meta' ) ) :
	/**
	 * Post/Page Meta for Google Structure Data
	 */
	function catchadaptive_page_post_meta() {
		$catchadaptive_author_url = esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) );
		
		$catchadaptive_page_post_meta = '<span class="post-time">' . __( 'Posted on', 'catch-adaptive' ) . ' <time class="entry-date updated" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" pubdate>' . esc_html( get_the_date() ) . '</time></span>';
	    $catchadaptive_page_post_meta .= '<span class="post-author">' . __( 'By', 'catch-adaptive' ) . ' <span class="author vcard"><a class="url fn n" href="' . $catchadaptive_author_url . '" title="View all posts by ' . get_the_author() . '" rel="author">' .get_the_author() . '</a></span>';

		return $catchadaptive_page_post_meta;
	} 
endif; //catchadaptive_page_post_meta

if ( ! function_exists( 'catchadaptive_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since Catch Adaptive 0.1
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function catchadaptive_truncate_phrase( $text, $max_characters ) {

		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //catchadaptive_truncate_phrase


if ( ! function_exists( 'catchadaptive_get_the_content_limit' ) ) :
	/**
	 * Return content stripped down and limited content.
	 *
	 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
	 *
	 * @since Catch Adaptive 0.1
	 *
	 * @param integer $max_characters The maximum number of characters to return.
	 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 *
	 * @return string Limited content.
	 */
	function catchadaptive_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

		$content = get_the_content( '', $stripteaser );

		//* Strip tags and shortcodes so the content truncation count is done correctly
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		//* Remove inline styles / scripts
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		//* Truncate $content to $max_char
		$content = catchadaptive_truncate_phrase( $content, $max_characters );

		//* More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '<a href="%s" class="more-link">%s</a>', get_permalink(), $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		return apply_filters( 'catchadaptive_get_the_content_limit', $output, $content, $link, $max_characters );

	}
endif; //catchadaptive_get_the_content_limit


if ( ! function_exists( 'catchadaptive_post_navigation' ) ) :
	/**
	 * Displays Single post Navigation
	 *
	 * @uses  the_post_navigation
	 *
	 * @action catchadaptive_after_post
	 * 
	 * @since Catch Adaptive 0.1
	 */
	function catchadaptive_post_navigation() {
		// Previous/next post navigation.
		the_post_navigation( array(
			'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next &rarr;', 'catch-adaptive' ) . '</span> ' .
				'<span class="screen-reader-text">' . __( 'Next post:', 'catch-adaptive' ) . '</span> ' .
				'<span class="post-title">%title</span>',
			'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '&larr; Previous', 'catch-adaptive' ) . '</span> ' .
				'<span class="screen-reader-text">' . __( 'Previous post:', 'catch-adaptive' ) . '</span> ' .
				'<span class="post-title">%title</span>',
		) );

	}
endif; //catchadaptive_post_navigation
add_action( 'catchadaptive_after_post', 'catchadaptive_post_navigation', 10 );


if ( ! function_exists( 'catchadaptive_archive_page_header' ) ) :
	/**
	 * Shows Page header in Archives
	 * 
	 * @since Catch Adaptive 1.0
	 */
	function catchadaptive_archive_page_header() { ?>

		<header class="page-header">
			<h1 class="page-title">
				<?php
					if ( is_category() ) :
						single_cat_title();

					elseif ( is_tag() ) :
						single_tag_title();

					elseif ( is_author() ) :
						printf( __( 'Author: %s', 'catch-adaptive' ), '<span class="vcard">' . get_the_author() . '</span>' );

					elseif ( is_day() ) :
						printf( __( 'Day: %s', 'catch-adaptive' ), '<span>' . get_the_date() . '</span>' );

					elseif ( is_month() ) :
						printf( __( 'Month: %s', 'catch-adaptive' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'catch-adaptive' ) ) . '</span>' );

					elseif ( is_year() ) :
						printf( __( 'Year: %s', 'catch-adaptive' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'catch-adaptive' ) ) . '</span>' );

					elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
						_e( 'Asides', 'catch-adaptive' );

					elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
						_e( 'Galleries', 'catch-adaptive');

					elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
						_e( 'Images', 'catch-adaptive');

					elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
						_e( 'Videos', 'catch-adaptive' );

					elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
						_e( 'Quotes', 'catch-adaptive' );

					elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
						_e( 'Links', 'catch-adaptive' );

					elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
						_e( 'Statuses', 'catch-adaptive' );

					elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
						_e( 'Audios', 'catch-adaptive' );

					elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
						_e( 'Chats', 'catch-adaptive' );

					else :
						_e( 'Archives', 'catch-adaptive' );

					endif;
				?>
			</h1>
			<?php
				// Show an optional term description.
				$term_description = term_description();
				if ( ! empty( $term_description ) ) :
					printf( '<div class="taxonomy-description">%s</div>', $term_description );
				endif;
			?>
		</header><!-- .page-header -->	
	<?php 

	}
endif; //catchadaptive_archive_page_header