<?php
/**
 * The template for displaying the Slider
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


if( !function_exists( 'catchadaptive_featured_slider' ) ) :
/**
 * Add slider.
 *
 * @uses action hook catchadaptive_before_content.
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_featured_slider() {
	global $post, $wp_query;
	//catchadaptive_flush_transients();
	// get data value from options
	$options 		= catchadaptive_get_theme_options();
	$enableslider 	= $options['featured_slider_option'];
	$sliderselect 	= $options['featured_slider_type'];
	$imageloader	= $options['featured_slider_image_loader'];

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 
 
	if ( $enableslider == 'entire-site' || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enableslider == 'homepage' ) ) {
		if( ( !$catchadaptive_featured_slider = get_transient( 'catchadaptive_featured_slider' ) ) ) {
			echo '<!-- refreshing cache -->';
		
			$catchadaptive_featured_slider = '
				<section id="feature-slider">
					<div class="wrapper">
						<div class="cycle-slideshow" 
						    data-cycle-log="false"
						    data-cycle-pause-on-hover="true"
						    data-cycle-swipe="true"
						    data-cycle-auto-height=container
						    data-cycle-fx="'. esc_attr( $options['featured_slide_transition_effect'] ) .'"
							data-cycle-speed="'. esc_attr( $options['featured_slide_transition_length'] ) * 1000 .'"
							data-cycle-timeout="'. esc_attr( $options['featured_slide_transition_delay'] ) * 1000 .'"
							data-cycle-loader="'. esc_attr( $imageloader ) .'"
							data-cycle-slides="> article"
							>
						    
						    <!-- prev/next links -->
						    <div class="cycle-prev"></div>
						    <div class="cycle-next"></div>

						    <!-- empty element for pager links -->
	    					<div class="cycle-pager"></div>';

							// Select Slider
							if ( $sliderselect == 'demo-featured-slider' && function_exists( 'catchadaptive_demo_slider' ) ) {
								$catchadaptive_featured_slider .=  catchadaptive_demo_slider( $options );
							}
							else if ( $sliderselect == 'featured-post-slider' && function_exists( 'catchadaptive_post_slider' ) ) {
								$catchadaptive_featured_slider .=  catchadaptive_post_slider( $options );
							}
							elseif ( $sliderselect == 'featured-page-slider' && function_exists( 'catchadaptive_page_slider' ) ) {
								$catchadaptive_featured_slider .=  catchadaptive_page_slider( $options );
							}
							elseif ( $sliderselect == 'featured-category-slider' && function_exists( 'catchadaptive_category_slider' ) ) {
								$catchadaptive_featured_slider .=  catchadaptive_category_slider( $options );
							}
							elseif ( $sliderselect == 'featured-image-slider' && function_exists( 'catchadaptive_image_slider' ) ) {
								$catchadaptive_featured_slider .=  catchadaptive_image_slider( $options );
							}

			$catchadaptive_featured_slider .= '
						</div><!-- .cycle-slideshow -->
					</div><!-- .wrapper -->
				</section><!-- #feature-slider -->';
			
			set_transient( 'catchadaptive_featured_slider', $catchadaptive_featured_slider, 86940 );
		}
		echo $catchadaptive_featured_slider;
	}
}
endif;
add_action( 'catchadaptive_before_content', 'catchadaptive_featured_slider', 10 );


if ( ! function_exists( 'catchadaptive_demo_slider' ) ) :
/**
 * This function to display featured posts slider
 *
 * @get the data value from customizer options
 *
 * @since Catch Adaptive 0.1
 *
 */
function catchadaptive_demo_slider( $options ) {
	$catchadaptive_demo_slider ='
								<article class="post hentry slides demo-image displayblock">
									<figure class="slider-image">
										<a title="' .  esc_attr( __( 'Slider Image 1', 'catch-adaptive' ) ) . '" href="'. esc_url( home_url( '/' ) ) .'">
											<img src="'.get_template_directory_uri().'/images/gallery/slider1-1680x720.jpg" class="wp-post-image" alt="' .  esc_attr( __( 'Slider Image 1', 'catch-adaptive' ) ) . '" title="' .  esc_attr( __( 'Slider Image 1', 'catch-adaptive' ) ) . '">
										</a>
									</figure>
									<div class="entry-container">
										<header class="entry-header">
											<h1 class="entry-title">
												<a title="' .  esc_attr( __( 'Slider Image 1', 'catch-adaptive' ) ) . '" href="#"><span>' .  __( 'Slider Image 1', 'catch-adaptive' ) . '</span></a>
											</h1>

											<div class="assistive-text">
												<span class="post-time">
													' . __( 'Posted on', 'catch-adaptive' ) .'
													
													<time pubdate="" datetime="2014-08-16T10:56:23+00:00" class="entry-date updated">
														' . date_i18n( get_option( 'date_format' ), strtotime( '8/16-2014' ) ) /* https://codex.wordpress.org/Function_Reference/date_i18n */. '
													</time>
												</span>

												<span class="post-author">
													' . sprintf( _x( 'By', 'attribution', 'catch-adaptive' ) ) . '&nbsp;
													<span class="author vcard">
														<a rel="author" title="' .  esc_attr( __( 'View all posts by', 'catch-adaptive' ) ) . ' Catch Themes" href="#" class="url fn n">Catch Themes</a>
													</span>
												</span>
											</div>
										</header>
										<div class="entry-content">
											<p>' . __( 'Slider Image 1 Content', 'catch-adaptive' ) . '</p>
										</div>   
									</div>             
								</article><!-- .slides --> 	
								
								<article class="post hentry slides demo-image displaynone">
									<figure class="slider-image">
										<a title="' .  esc_attr( __( 'Slider Image 2', 'catch-adaptive' ) ) . '" href="'. esc_url( home_url( '/' ) ) .'">
											<img src="'. get_template_directory_uri() . '/images/gallery/slider2-1680x720.jpg" class="wp-post-image" alt="' .  esc_attr( __( 'Slider Image 2', 'catch-adaptive' ) ) . '" title="' .  esc_attr( __( 'Slider Image 2', 'catch-adaptive' ) ) . '">
										</a>
									</figure>
									<div class="entry-container">
										<header class="entry-header">
											<h1 class="entry-title">
												<a title="' .  esc_attr( __( 'Slider Image 1', 'catch-adaptive' ) ) . '" href="#"><span>' .  __( 'Slider Image 2', 'catch-adaptive' ) . '</span></a>
											</h1>
											<div class="assistive-text">
												<span class="post-time">
													' . __( 'Posted on', 'catch-adaptive' ) .'
													
													<time pubdate="" datetime="2014-08-16T10:56:23+00:00" class="entry-date updated">
														' . date_i18n( get_option( 'date_format' ), strtotime( '8/16-2014' ) ) /* https://codex.wordpress.org/Function_Reference/date_i18n */. '
													</time>
												</span>

												<span class="post-author">
													' . sprintf( _x( 'By', 'attribution', 'catch-adaptive' ) ) . '&nbsp;
													<span class="author vcard">
														<a rel="author" title="' .  esc_attr( __( 'View all posts by', 'catch-adaptive' ) ) . ' Catch Themes" href="#" class="url fn n">Catch Themes</a>
													</span>
												</span>
											</div>
										</header>
										<div class="entry-content">
											<p>' . __( 'Slider Image 2 Content', 'catch-adaptive' ) . '</p>
										</div>   
									</div>             
								</article><!-- .slides --> ';
	return $catchadaptive_demo_slider;
}
endif; // catchadaptive_demo_slider


if ( ! function_exists( 'catchadaptive_post_slider' ) ) :
/**
 * This function to display featured posts slider
 *
 * @param $options: catchadaptive_theme_options from customizer
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_post_slider( $options ) {
	$quantity	= $options['featured_slide_number'];

	global $post;

    $catchadaptive_post_slider = '';

   	$number_of_post = 0; 		// for number of posts

	$post_list		= array();	// list of valid post ids

	//Get valid post ids
	for( $i = 1; $i <= $quantity; $i++ ){
		if( isset ( $options['featured_slider_post_' . $i] ) && $options['featured_slider_post_' . $i] > 0 ){
			$number_of_post++;

			$post_list	=	array_merge( $post_list, array( $options['featured_slider_post_' . $i] ) );
		}

	}

	if ( !empty( $post_list ) && $number_of_post > 0 ) {
        $catchadaptive_post_slider = '';

    	$get_featured_posts = new WP_Query( array(
            'posts_per_page' => $number_of_post,
            'post__in'       => $post_list,
            'orderby'        => 'post__in',
            'ignore_sticky_posts' => 1 // ignore sticky posts
        ));

		$i=0; 
		while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;

			$title_attribute = the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) );
			$excerpt = get_the_excerpt();
			if ( $i == 1 ) { $classes = "slides displayblock"; } else { $classes = "slides displaynone"; }

			$catchadaptive_post_slider .= '
			<article class="'.$classes.'">
				<figure class="slider-image">';
				if ( has_post_thumbnail() ) {
					$catchadaptive_post_slider .= '<a title="' . the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">
						'. get_the_post_thumbnail( $post->ID, 'catchadaptive_slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'
					</a>';
				}
				else {
					//Default value if there is no first image
					$catchadaptive_image = '<img class="pngfix wp-post-image" src="'.get_template_directory_uri().'/images/gallery/no-featured-image-1680x720.jpg" >';
					
					//Get the first image in page, returns false if there is no image
					$catchadaptive_first_image = catchadaptive_get_first_image( $post->ID, 'catchadaptive-slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class' => 'pngfix' ) );

					//Set value of image as first image if there is an image present in the page
					if ( '' != $catchadaptive_first_image ) {
						$catchadaptive_image =	$catchadaptive_first_image;
					}

					$catchadaptive_post_slider .= '<a title="' . the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">
						'. $catchadaptive_image .'
					</a>';
				}

				$catchadaptive_post_slider .= '
				</figure><!-- .slider-image -->
				<div class="entry-container">
					<header class="entry-header">
						<h1 class="entry-title">
							<a title="' . the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">'.the_title( '<span>','</span>', false ).'</a>
						</h1>
						<div class="assistive-text">'.catchadaptive_page_post_meta().'</div>
					</header>';
					if( $excerpt !='') {
						$catchadaptive_post_slider .= '<div class="entry-content">'. $excerpt.'</div>';
					}
					$catchadaptive_post_slider .= '
				</div><!-- .entry-container -->
			</article><!-- .slides -->';	
		endwhile;

		wp_reset_query();
	
		return $catchadaptive_post_slider;
	}
}
endif; // catchadaptive_post_slider


if ( ! function_exists( 'catchadaptive_page_slider' ) ) :
/**
 * This function to display featured page slider
 *
 * @param $options: catchadaptive_theme_options from customizer
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_page_slider( $options ) {
	$quantity		= $options['featured_slide_number'];
	$more_link_text	=	$options['excerpt_more_text'];

    global $post;

    $catchadaptive_page_slider = '';
    $number_of_page 		= 0; 		// for number of pages
	$page_list				= array();	// list of valid page ids

	//Get number of valid pages
	for( $i = 1; $i <= $quantity; $i++ ){
		if( isset ( $options['featured_slider_page_' . $i] ) && $options['featured_slider_page_' . $i] > 0 ){
			$number_of_page++;

			$page_list	=	array_merge( $page_list, array( $options['featured_slider_page_' . $i] ) );
		}

	}

	if ( !empty( $page_list ) && $number_of_page > 0 ) {
		$get_featured_posts = new WP_Query( array(
			'posts_per_page'	=> $quantity,
			'post_type'			=> 'page',
			'post__in'			=> $page_list,
			'orderby' 			=> 'post__in'
		));
		$i=0; 

		while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
			$title_attribute = the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) );
			$excerpt = get_the_excerpt();
			if ( $i == 1 ) { $classes = 'page pageid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'page pageid-'.$post->ID.' hentry slides displaynone'; }
			$catchadaptive_page_slider .= '
			<article class="'.$classes.'">
				<figure class="slider-image">';
				if ( has_post_thumbnail() ) {
					$catchadaptive_page_slider .= '<a title="' . the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">
						'. get_the_post_thumbnail( $post->ID, 'catchadaptive_slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'
					</a>';
				}
				else {
					//Default value if there is no first image
					$catchadaptive_image = '<img class="pngfix wp-post-image" src="'.get_template_directory_uri().'/images/gallery/no-featured-image-1680x720.jpg" >';
					
					//Get the first image in page, returns false if there is no image
					$catchadaptive_first_image = catchadaptive_get_first_image( $post->ID, 'catchadaptive-slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class' => 'pngfix' ) );

					//Set value of image as first image if there is an image present in the page
					if ( '' != $catchadaptive_first_image ) {
						$catchadaptive_image =	$catchadaptive_first_image;
					}

					$catchadaptive_page_slider .= '<a title="' . the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">
						'. $catchadaptive_image .'
					</a>';
				}

				$catchadaptive_page_slider .= '
				</figure><!-- .slider-image -->
				<div class="entry-container">
					<header class="entry-header">
						<h1 class="entry-title">
							<a title="' . the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">'.the_title( '<span>','</span>', false ).'</a>
						</h1>
						<div class="assistive-text">'.catchadaptive_page_post_meta().'</div>
					</header>';
					if( $excerpt !='') {
						$catchadaptive_page_slider .= '<div class="entry-content">'. $excerpt.'</div>';
					}
					$catchadaptive_page_slider .= '
				</div><!-- .entry-container -->
			</article><!-- .slides -->';
		endwhile; 

		wp_reset_query();
  	}
	return $catchadaptive_page_slider;
}
endif; // catchadaptive_page_slider


if ( ! function_exists( 'catchadaptive_category_slider' ) ) :
/**
 * This function to display featured category slider
 *
 * @param $options: catchadaptive_theme_options from customizer
 *
 * @since Catch Adaptive 0.1
 */
function catchadaptive_category_slider( $options ) {
    $quantity	= $options['featured_slide_number'];
	
	global $post;

	$catchadaptive_category_slider = '';

	$category_list	= array_filter( $options['featured_slider_select_category'] );

	if ( !empty( $category_list ) ) {
		$get_featured_posts = new WP_Query( array(
			'posts_per_page'		=> $quantity,
			'category__in'			=> $category_list,
			'ignore_sticky_posts' 	=> 1 // ignore sticky posts
		));

		$i=0;

		while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
			$title_attribute = the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) );
			$excerpt = get_the_excerpt();
			if ( $i == 1 ) { $classes = 'page pageid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'page pageid-'.$post->ID.' hentry slides displaynone'; }
			$catchadaptive_category_slider .= '
			<article class="'.$classes.'">
				<figure class="slider-image">';
				if ( has_post_thumbnail() ) {
					$catchadaptive_category_slider .= '<a title="' . the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">
						'. get_the_post_thumbnail( $post->ID, 'catchadaptive_slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'
					</a>';
				}
				else {
					//Default value if there is no first image
					$catchadaptive_image = '<img class="pngfix wp-post-image" src="'.get_template_directory_uri().'/images/gallery/no-featured-image-1680x720.jpg" >';
					
					//Get the first image in page, returns false if there is no image
					$catchadaptive_first_image = catchadaptive_get_first_image( $post->ID, 'catchadaptive-slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class' => 'pngfix' ) );
					//Set value of image as first image if there is an image present in the page
					if ( '' != $catchadaptive_first_image ) {
						$catchadaptive_image =	$catchadaptive_first_image;
					}

					$catchadaptive_category_slider .= '<a title="' . the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">
						'. $catchadaptive_image .'
					</a>';
				}
				
				
				$catchadaptive_category_slider .= '
				</figure><!-- .slider-image -->
				<div class="entry-container">
					<header class="entry-header">
						<h1 class="entry-title">
							<a title="' . the_title_attribute( array( 'before' => __( 'Permalink to:', 'catch-adaptive' ), 'echo' => false ) ) . '" href="' . get_permalink() . '">'.the_title( '<span>','</span>', false ).'</a>
						</h1>
						<div class="assistive-text">'.catchadaptive_page_post_meta().'</div>
					</header>';
					if( $excerpt !='') {
						$catchadaptive_category_slider .= '<div class="entry-content">'. $excerpt.'</div>';
					}
					$catchadaptive_category_slider .= '
				</div><!-- .entry-container -->
			</article><!-- .slides -->';
		endwhile; 

		wp_reset_query();
	} 	
	return $catchadaptive_category_slider;
}
endif; // catchadaptive_category_slider


if ( ! function_exists( 'catchadaptive_image_slider' ) ) :
/**
 * This function to display featured posts slider
 *
 * @get the data value from theme options
 * @displays on the index
 *
 * @useage Featured Image, Title and Excerpt of Post
 *
 */
function catchadaptive_image_slider( $options ) {	
	$quantity	= $options['featured_slide_number'];
	
	$catchadaptive_image_slider = '';
			
	for ( $i = 1 ; $i <= $quantity; $i++ ) {
		
		//Adding in Classes for Display block and none
		if ( $i == 1 ) { $classes = "slides displayblock"; } else { $classes = "slides displaynone"; }
		
		//Check Image Not Empty to add in the slides
		if ( !empty ( $options[ 'featured_slider_image_'. $i ] ) ) { 
		
			//Checking Link Target
			if ( !empty ( $options[ 'featured_target_'. $i ] ) ) {
				$target = '_blank';
			} else {
				$target = '_self';
			}
			
			//Checking Title
			if ( !empty ( $options[ 'featured_title_'. $i ] ) ) {
				$imagetitle = $options[ 'featured_title_'. $i ];
			}
			else {
				$imagetitle = 'Featured Image-'.$i;
			}
			
			//Checking Link
			if ( !empty ( $options[ 'featured_link_'. $i ] ) ) {
				$link = $options[ 'featured_link_'. $i ];
				$image = '<a href="'. esc_url( $link ).'" title="'. esc_attr( $imagetitle ) .'" target="'.$target.'"><img title="'. esc_attr( $imagetitle ) .'" alt="'. esc_attr( $imagetitle ) .'" class="pngfix wp-post-image" src="'. esc_url( $options[ 'featured_slider_image_'. $i ] ) .'" /></a>';
			}
			else {
				$link = '#';
				$image = '<img title="'. esc_attr( $imagetitle ).'" alt="'. esc_attr( $imagetitle ) .'" class="pngfix wp-post-image" src="'. esc_url( $options['featured_slider_image_'. $i] ).'" />';
			}
			
			//Checking Content
			if ( !empty ( $options['featured_title_'. $i] ) ) {
				$content_title = $options['featured_title_'. $i];
			}
			else {
				$content_title = '';
			}

			//Checking Content
			if ( !empty ( $options['featured_content_'. $i] ) ) {
				$content = $options['featured_content_'. $i];
			}
			else {
				$content = '';
			}
			
			$catchadaptive_image_slider .= '
								<article class="'. $classes .'">
									<figure class="slider-image">
										'. $image .'
									</figure>
									<div class="entry-container">
										<header class="entry-header">
											<h1 class="entry-title">
												<a title="'. esc_attr( $content_title ) .'" href="'. esc_url( $link ) .'"><span>'. esc_attr( $content_title ) .'</span></a>  
											</h1>
										</header>
										<div class="entry-content">
											<p>'. esc_attr( $content ) .'</p>
										</div>   
									</div>             
								</article><!-- .slides --> ';	
		}
	}
	return $catchadaptive_image_slider;
}
endif; //catchadaptive_image_slider