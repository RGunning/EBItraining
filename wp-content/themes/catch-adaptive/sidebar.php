<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Catch Themes
 * @subpackage Catch Adaptive
 * @since Catch Adaptive 0.1
 */
?>

<?php
/** 
 * catchadaptive_before_secondary hook
 */
do_action( 'catchadaptive_before_secondary' );?>
	
<?php
	global $post, $wp_query;

	$options = catchadaptive_get_theme_options();
	
	$themeoption_layout = $options['theme_layout'];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();	
	
	// Post /Page /General Layout
	if ( $post) {
		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$layout = get_post_meta( $parent, 'catchadaptive-layout-option', true );
			$sidebaroptions = get_post_meta( $parent, 'catchadaptive-sidebar-options', true );
			
		} else {
			$layout = get_post_meta( $post->ID, 'catchadaptive-layout-option', true ); 
			$sidebaroptions = get_post_meta( $post->ID, 'catchadaptive-sidebar-options', true ); 
		}
	}
	else {
		$sidebaroptions = '';
	}
			
	if( empty( $layout ) || ( !is_page() && !is_single() ) ) {
		$layout = 'default';
	}
	
	if( 'no-sidebar' == $layout ) {
		return;
	}

	if( 'default' == $layout && 'no-sidebar' == $themeoption_layout ) {
		return;
	}

	do_action( 'catchadaptive_before_primary_sidebar' ); 
	?>   
		<aside class="sidebar sidebar-primary widget-area" role="complementary">
			<?php
			if ( is_active_sidebar( 'primary-sidebar' ) ) {
	        	dynamic_sidebar( 'primary-sidebar' ); 
	   		}	
			else { 
				//Helper Text
				if ( current_user_can( 'edit_theme_options' ) ) { ?>
					<section id="widget-default-text" class="widget widget_text">	
						<div class="widget-wrap">
		                	<h4 class="widget-title"><?php _e( 'Primary Sidebar Widget Area', 'catch-adaptive' ); ?></h4>
		           		
		           			<div class="textwidget">
		                   		<p><?php _e( 'This is the Primary Sidebar Widget Area if you are using a two column site layout option.', 'catch-adaptive' ); ?></p>
		                   		<p><?php printf( __( 'By default it will load Search and Archives widgets as shown below. You can add widget to this area by visiting your <a href="%s">Widgets Panel</a> which will replace default widgets.', 'catch-adaptive' ), admin_url( 'widgets.php' ) ); ?></p>
		                 	</div>
		           		</div><!-- .widget-wrap -->
		       		</section><!-- #widget-default-text -->
				<?php
				} ?>
				<section class="widget widget_search" id="default-search">
					<div class="widget-wrap">
						<?php get_search_form(); ?>
					</div><!-- .widget-wrap -->
				</section><!-- #default-search -->
				<section class="widget widget_archive" id="default-archives">
					<div class="widget-wrap">
						<h4 class="widget-title"><?php _e( 'Archives', 'catch-adaptive' ); ?></h4>
						<ul>
							<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
						</ul>
					</div><!-- .widget-wrap -->
				</section><!-- #default-archives -->
				<?php 
			}
		?>
		</aside><!-- .sidebar sidebar-primary widget-area -->
	<?php
	/** 
	 * catchadaptive_after_primary_sidebar hook
	 */
	do_action( 'catchadaptive_after_primary_sidebar' ); ?>

<?php
/** 
 * catchadaptive_after_secondary hook
 *
 */
do_action( 'catchadaptive_after_secondary' );
