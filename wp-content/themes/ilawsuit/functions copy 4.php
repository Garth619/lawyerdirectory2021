<?php 



/* Enqueued Scripts and passing php data into js files
-------------------------------------------------------------- */



 
function load_my_styles_scripts() {
  
    
    wp_enqueue_style( 'styles', get_template_directory_uri() . '/style.css', '', 5, 'all' ); 
    

    // disables jquery then registers it again to go into footer
    
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, false );
    wp_enqueue_script( 'jquery' );
    
		
		// custom js to fall uner jquery in footer
		    
    wp_register_script( 'jquery-addon', get_template_directory_uri() . '/js/custom-min.js','', 1);
    
    
    
		// Localized PHP Data that needs to be passed onto my custom-min.js file
			
		if (get_query_var( 'currentstate') && get_query_var( 'currentcity')) { 
			
				
				$currentpracticearea =  get_query_var( 'office_pa'); // figure out how to declare these outside of a function one time on this file and call them into where needed

				$currentcity = get_query_var( 'currentcity');
				
				$currentstate = get_query_var( 'currentstate');
				
				if(empty(get_query_var('mypaged'))) {
					
					$mypaged = 1;
					
				}
				
				else {
					
					$mypaged = get_query_var('mypaged');
					
				}

				
				$taxlocations = 'location';
				
		 		$taxpracticeareas = 'practice_area';
			
				
				// Get lat and long by address 
     
     		$google_map_api = 'AIzaSyDPAds-G8zjbtCxCC19dH2o_voVQIEjg7o';
     		
		 		// pa url query -> pa id conversion
	
		 		$patermslug = get_term_by('slug', $currentpracticearea, $taxpracticeareas);
		 		
		 		$patermslug_map = $patermslug->slug;
		 		
		 		// Get Current City and State as Titles
     		
     		// state url query -> state id conversion
	
		 		$statetermslug = get_term_by('slug', $currentstate, $taxlocations);
	
		 		$statetermid = $statetermslug->term_taxonomy_id;
	
		 		$statetermtitle = $statetermslug->name;
	
		 		// city url query -> city id conversion
	
		 		$citytermslug = get_term_by('slug', $currentcity, $taxlocations);
	
		 		$citytermid = $citytermslug->term_taxonomy_id;
	
		 		$citytermtitle = $citytermslug->name;
     		
     		// if page that displays map i.e. "/lawyers-practice/california/san-diego/business-lawyers"
     		
     		if (get_query_var( 'currentstate') && get_query_var( 'currentcity')) {
	     		
	     		// build gecode url to retrieve the current city coordinates so the map can recenter
	     		
	     		$mapaddress = $citytermtitle . ',' . $statetermtitle; 
			 		$prepAddr = str_replace(' ','+',$mapaddress);
        
        
			 		$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key=' . $google_map_api .'');
     

			 		$output= json_decode($geocode);
			 		$city_latitude = $output->results[0]->geometry->location->lat;
			 		$city_longitude = $output->results[0]->geometry->location->lng;
	     		
	     	} 
	     	
	     	
     		
     	}
       
       // current domian used for the rest api url call
       
       $currentdomain = get_bloginfo('url');
       $lawyer_title = get_the_title();
       
       // Attorney Bio Meta Data for form and post updates
       
       $lawyerbio_city = get_field('lawyer_city');
       $lawyerbio_state = get_field('lawyer_state');
       $lawyerbio_stateabr = get_field('state_abbr');
       $lawyerbio_zipcode = get_field('lawyer_zip');
       $lawyerbio_latitude = get_field('latitude');
       $lawyerbio_longitude = get_field('longitude');
       
       
       // Localize the script with new data array 
						
			
			$map_array = array(
    		'map_current_city_latitude' => $city_latitude,
				'map_current_city_longitude' => $city_longitude,
				'map_current_city' => $currentcity,
				'map_current_pa' => $patermslug_map,
				'map_paged' => $mypaged,
				'current_domain' => $currentdomain,
				'lawyerbio_city' => $lawyerbio_city,
				'lawyerbio_state' => $lawyerbio_state,
				'lawyerbio_stateabr' => $lawyerbio_stateabr,
				'lawyerbio_zipcode' => $lawyerbio_zipcode,
				'lawyerbio_latitude' => $lawyerbio_latitude,
				'lawyerbio_longitude' => $lawyerbio_longitude,
			);

			wp_localize_script( 'jquery-addon', 'my_mapdata', $map_array );
		
		
		
		// carry on to enqueue script like normal, but now it contains my needed js variable with php data tied to it from above
		

		// Enqueue Script
		
		wp_enqueue_script( 'jquery-addon', get_template_directory_uri() . '/js/custom-min.js', 'jquery', '', true );
		
		
		//wp_enqueue_script( 'jquery-mygravity', get_template_directory_uri() . '/js/gravityforms-min.js', 'jquery', '', true );
		
		
		if (get_query_var( 'currentstate') && get_query_var( 'currentcity')) { 
			
			// https://giogadesign.com/how-to-add-defer-async-attributes-to-wordpress-scripts/
		
			wp_enqueue_script('googleapis', esc_url( add_query_arg( 'key', $google_map_api .'&callback=initMap', '//maps.googleapis.com/maps/api/js' )), array(), null, true );
		
		
		}
		    
   
    

 }
 
 add_action( 'wp_enqueue_scripts', 'load_my_styles_scripts', 20 );
 
 
 
 /* Defer JS for Lighthouse
-------------------------------------------------------------- */
 
 
/*
function add_defer_attribute($tag, $handle) {
   // add script handles to the array below
   $scripts_to_defer = array(
   	'jquery', 
   	'jquery-addon', 
   	'jquery-mygravity',
   	'googleapis'
   	
   );
   
   foreach($scripts_to_defer as $defer_script) {
      if ($defer_script === $handle) {
         return str_replace(' src', ' defer="defer" src', $tag);
      }
   }
   return $tag;
}


add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);
*/





/* dequeue embed for lighthouse
-------------------------------------------------------------- */



/*

 function my_deregister_scripts(){
  
  wp_deregister_script( 'wp-embed' );

	}

	add_action( 'wp_footer', 'my_deregister_scripts' );
*/





/* dequeue gravity form files that effect critical chain page speed and defer them later in a combined file
-------------------------------------------------------------- */
	
	

/*

	function deregister_scripts(){
			
  wp_deregister_script("gform_placeholder");
  wp_deregister_script("gform_masked_input");
  wp_deregister_script("gform_json");
  wp_deregister_script("gform_gravityforms");
  wp_deregister_script("gform_conditional_logic");
  
  
 }
	
	
 add_action("gform_enqueue_scripts", "deregister_scripts");
 
 
*/





/* CSS in Header for Lighthouse
-------------------------------------------------------------- */
 

/*
 
function internal_css_print() {
   echo '<style>';
   
   include_once get_template_directory() . '/style.css';
  
   echo '</style>';
}


add_action( 'wp_head', 'internal_css_print' );
*/



 
 
/* Force Gravity Forms to init scripts in the footer and ensure that the DOM is loaded before scripts are executed
-------------------------------------------------------------- */


/*
add_filter( 'gform_init_scripts_footer', '__return_true' );
add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open', 1 );
function wrap_gform_cdata_open( $content = '' ) {
if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
return $content;
}
$content = 'document.addEventListener( "DOMContentLoaded", function() { ';
return $content;
}
add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close', 99 );
function wrap_gform_cdata_close( $content = '' ) {
if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
return $content;
}
$content = ' }, false );';
return $content;
}
*/


// minumum characters

/**
* Gravity Wiz // Require Minimum Character Limit for Gravity Forms
* 
* Adds support for requiring a minimum number of characters for text-based Gravity Form fields.
* 
* @version	 1.0
* @author    David Smith <david@gravitywiz.com>
* @license   GPL-2.0+
* @link      http://gravitywiz.com/...
* @copyright 2013 Gravity Wiz
*/
class GW_Minimum_Characters {
    
    public function __construct( $args = array() ) {
        
        // make sure we're running the required minimum version of Gravity Forms
        if( ! property_exists( 'GFCommon', 'version' ) || ! version_compare( GFCommon::$version, '1.7', '>=' ) )
            return;
    	
    	// set our default arguments, parse against the provided arguments, and store for use throughout the class
    	$this->_args = wp_parse_args( $args, array( 
    		'form_id' => false,
    		'field_id' => false,
    		'min_chars' => 0,
            'max_chars' => false,
            'validation_message' => false,
            'min_validation_message' => __( 'Please enter at least %s characters.' ),
            'max_validation_message' => __( 'You may only enter %s characters.' )
    	) );
    	
        extract( $this->_args );
        
        if( ! $form_id || ! $field_id || ! $min_chars )
            return;
        
    	// time for hooks
    	add_filter( "gform_field_validation_{$form_id}_{$field_id}", array( $this, 'validate_character_count' ), 10, 4 );
        
    }
    
    public function validate_character_count( $result, $value, $form, $field ) {

        $char_count = strlen( $value );
        $is_min_reached = $this->_args['min_chars'] !== false && $char_count >= $this->_args['min_chars'];
        $is_max_exceeded = $this->_args['max_chars'] !== false && $char_count > $this->_args['max_chars'];

        if( ! $is_min_reached ) {

            $message = $this->_args['validation_message'];
            if( ! $message )
                $message = $this->_args['min_validation_message'];

            $result['is_valid'] = false;
            $result['message'] = sprintf( $message, $this->_args['min_chars'] );

        } else if( $is_max_exceeded ) {

            $message = $this->_args['max_validation_message'];
            if( ! $message )
                $message = $this->_args['validation_message'];

            $result['is_valid'] = false;
            $result['message'] = sprintf( $message, $this->_args['max_chars'] );

        }
        
        return $result;
    }
    
}

# Configuration


new GW_Minimum_Characters( array( 
 'form_id' => 2,
 'field_id' => 9,
 'min_chars' => 1,
 'max_chars' => 2000,
 'min_validation_message' => __( 'You need to enter at least %s characters.' ),
 'max_validation_message' => __( 'You can only enter %s characters.' )
) );


/* No Tab Conflicts Gravity Forms
 --------------------------------------------------------------------------------------- */

add_filter( 'gform_tabindex', 'gform_tabindexer', 10, 2 );
function gform_tabindexer( $tab_index, $form = false ) {
  $starting_index = 1000; // if you need a higher tabindex, update this number
  if( $form )
    add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
  return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}


/* Remove Unnecessary Scripts
-------------------------------------------------------------- */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

/* Register Nav-Menus
-------------------------------------------------------------- */

register_nav_menus(array(
    'main_menu' => 'Main Menu',
));

/* Widgets
-------------------------------------------------------------- */

if (function_exists('register_sidebars')) {


    register_sidebar(array(
        'name' => 'Recent Posts',
        'id' => 'recent_posts',
        'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));

    
    register_sidebar(array(
        'name' => 'Category',
        'id' => 'category_sidebar',
        'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));
    
    register_sidebar(array(
        'name' => 'Archive',
        'id' => 'archive_sidebar',
        'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));

 }

/* Add Theme Support Page Thumbnails
-------------------------------------------------------------- */

add_theme_support('post-thumbnails');

/* Modify the_excerpt() " read more "
-------------------------------------------------------------- */

function new_excerpt_more($more)
{
    global $post;
    return '... <a href="' . get_permalink($post->ID) . '">' . 'read more' . '</a>';
}

add_filter('excerpt_more', 'new_excerpt_more');

/* Add Page Slug to Body Class
-------------------------------------------------------------- */
function add_slug_body_class($classes)
{
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}

add_filter('body_class', 'add_slug_body_class');



/* ACF: CREATE OPTIONS PAGE
-------------------------------------------------------------- */

if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
    'page_title' 	=> 'Descriptions and Featured Cities',
    'menu_title'	=> 'Descriptions and Featured Cities',
    'menu_slug' 	=> 'theme-options',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
  ));

}



/* ALLOW SVGs IN MEDIA UPLOAD
-------------------------------------------------------------- */
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');


/* ALLOW WEBPs IN MEDIA UPLOAD
-------------------------------------------------------------- */


function webp_upload_mimes( $existing_mimes ) {
	// add webp to the list of mime types
	$existing_mimes['webp'] = 'image/webp';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'mime_types', 'webp_upload_mimes' );


/* Blog Pagination
-------------------------------------------------------------- */

function wpbeginner_numeric_posts_nav() {
 
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
 
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<div class="paged_wrapper"><div class="navigation"><ul>' . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="myprev">%s</li>' . "\n", get_previous_posts_link('prev') );
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }
 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="mynext">%s</li>' . "\n", get_next_posts_link('next') );
 
    echo '</ul></div></div>' . "\n";
 
}



/* Permalink Rewrites
-------------------------------------------------------------- */


function prefix_rewrite_rule() {
	
		
		// location urls
		
		
		// "/lawyers-location/state/alaska/anchorage-lawyers"
		
		add_rewrite_rule( 'lawyers-location/state/([^/]+)/([^/]+)-lawyers', 'index.php?office_location_currentstate=$matches[1]&office_location_currentcity=$matches[2]', 'top' );
		
		
		// "/lawyers-location/state/alaska-lawyers"
		
		add_rewrite_rule( 'lawyers-location/state/([^/]+)-lawyers', 'index.php?office_location_currentstate=$matches[1]', 'top' );
		
		
		// practice area urls
		
		
		// pagination "/lawyers-practice/california/los-angeles/business/page/2"
		
		add_rewrite_rule( 'lawyers-practice/([^/]+)/([^/]+)/([^/]+)-lawyers/page/([0-9]+)', 'index.php?currentstate=$matches[1]&currentcity=$matches[2]&office_pa=$matches[3]&mypaged=$matches[4]', 'top' );
		
		// "/lawyers-practice/california/los-angeles/business-lawyers"
		
		add_rewrite_rule( 'lawyers-practice/([^/]+)/([^/]+)/([^/]+)-lawyers', 'index.php?currentstate=$matches[1]&currentcity=$matches[2]&office_pa=$matches[3]', 'top');
		
		
		// "/lawyers-practice/california/business-lawyers"
		
		add_rewrite_rule( 'lawyers-practice/([^/]+)/([^/]+)-lawyers', 'index.php?currentstate=$matches[1]&office_pa=$matches[2]', 'top' );
		
		
		// "/lawyers-practice/business-lawyers"
		
		add_rewrite_rule( 'lawyers-practice/([^/]+)-lawyers', 'index.php?office_pa=$matches[1]', 'top' );
		
		
		  // bio
    
    //https://wordpress.stackexchange.com/questions/39500/how-to-create-a-permalink-structure-with-custom-taxonomies-and-custom-post-types/39862#39862
    
    //https://gist.github.com/kasparsd/2924900
    
    //https://travis.media/modifying-the-custom-taxonomy-permalink-structure-in-a-custom-post-type
    
    
    
    // other pages possible could be done like this with custom permalink varables ^ maybe like "/lawyers-practice/california/alhambra/alhambra-criminal-defense-lawyers"
		
 
 }
 
add_action( 'init', 'prefix_rewrite_rule' );


// global query vars

function prefix_register_query_var( $vars ) {
    
    // custom permalink vars
    
    $vars[] = 'office_location_currentstate';
    $vars[] = 'office_location_currentcity';
    $vars[] = 'office_pa';
    $vars[] = 'currentstate';
    $vars[] = 'currentcity';
    $vars[] = 'mypaged';
    
    // custom search vars
    
    $vars[] = 'attorney_keyword';
    $vars[] = 'attorney_pa';
    $vars[] = 'attorney_location';
 
    return $vars;
}
 
add_filter( 'query_vars', 'prefix_register_query_var' );


// templates assignment based on query vars


function prefix_url_rewrite_templates() {
	
	
		// "/lawyers-location/state/california/los-angeles-lawyers"
	
		if ( get_query_var( 'office_location_currentstate') && get_query_var( 'office_location_currentcity') ) { 
       
     	add_filter( 'template_include', function() {
            return get_template_directory() . '/page-templates/template-practicearea_city.php';
       });

    }
    
    // /lawyers-location/state/california-lawyers
    
    if ( get_query_var( 'office_location_currentstate') && !get_query_var( 'office_location_currentcity') ) { 
	    
	    add_filter( 'template_include', function() {
        return get_template_directory() . '/page-templates/template-location.php';
      });

    }
    
		
		// "/lawyers-practice/california/los-angeles/business-lawyers"
    
    
		if (get_query_var( 'currentstate') && get_query_var( 'currentcity')) { 
       
	    add_filter( 'template_include', function() {
            return get_template_directory() . '/page-templates/template-locations_city_pa.php';
       });

		}
		
		// "/lawyers-practice/colorado/criminal-defense-lawyers"
		
		
		if ( get_query_var( 'currentstate') && !get_query_var( 'currentcity') ) { 
       
			add_filter( 'template_include', function() {
       return get_template_directory() . '/page-templates/template-locations_state_pa.php';
     	});

    }
		
		
		// "/lawyers-practice/business-lawyers"
		
		
		if ( get_query_var( 'office_pa') && !get_query_var( 'currentstate') && !get_query_var( 'currentcity') ) { 
			
			
       
			add_filter( 'template_include', function() {
       return get_template_directory() . '/page-templates/template-practice_area.php';
     	});

    }
    
    
  

}
 
add_action( 'template_redirect', 'prefix_url_rewrite_templates' );





// pre_get_post



function my_custom_search($query) {
	
		// custom search query vars
	        
	  $att_keyword = get_query_var( 'attorney_keyword');
		$att_pa = get_query_var( 'attorney_pa');
		$att_location = get_query_var( 'attorney_location');
		$mypaged = get_query_var('mypaged');
		
		
		// template query_vars
		
		
		$currentcity = get_query_var( 'currentcity'); // figure out how to decale these outside of a function one time on this file and call them into where needed
		$currentstate = get_query_var( 'currentstate');
		$currentpracticearea =  get_query_var( 'office_pa');
	
		$taxlocations = 'location';
		$taxpracticeareas = 'practice_area';
				
		
		// three part custom search template (its assigned to archive lawyer cpt)
		
		if ( ! is_admin() && $query->is_main_query() && $query->is_archive('lawyer') && !$query->is_tax('practice_area')) {
        
       			
	        		
	        	// CPT args
						
						$query-> set('posts_per_page' , 50);
	      		$query-> set('order' , 'ASC');
	      		$query-> set('orderby' ,'title');
	      		$query-> set('post_status' , 'publish');
	      		$query-> set('ignore_sticky_posts' , true);
	      		$query-> set('post_type' , 'lawyer');
	      		  
						
						
						// tax_query setup
						
						$taxquery = array('relation' => 'AND');
						
						// custom search arg conditionals
						
						
						// just keyword
						
						if($att_keyword && !$att_pa && !$att_location) {
							
							$query-> set('s' , $att_keyword);
							
						}
						
						// just pa
						
						if(!$att_keyword && $att_pa && $att_pa !== 'Search All Types' && !$att_location) {
							
							array_push($taxquery, 
								array(
									'taxonomy' => 'practice_area',
									'field' => 'slug',
									'terms' => $att_pa, 
									'operator' => 'IN',
								)
							);
							
							$query->set('tax_query', $taxquery);
							
						}
						
						// just location
						
						if(!$att_keyword && !$att_pa && $att_location) {
							
							array_push($taxquery, 
								array(
									'taxonomy' => 'location',
									'field' => 'slug',
									'terms' => $att_location,
									'operator' => 'IN',
								)
							);
							
							$query->set('tax_query', $taxquery);
							
						}
						
						// keyword and pa
						
						if($att_keyword && $att_pa && $att_pa !== 'Search All Types' && !$att_location) {
							
							$query-> set('s' , $att_keyword);
							
							array_push($taxquery, 
								array(
									'taxonomy' => 'practice_area',
									'field' => 'slug',
									'terms' => $att_pa,
									'operator' => 'IN',
								)
							);
							
							$query->set('tax_query', $taxquery);
							
						}
						
						// keyword and location
						
						if($att_keyword && !$att_pa && $att_location) {
							
							$query-> set('s' , $att_keyword);
							
							array_push($taxquery,
								array(
									'taxonomy' => 'location',
									'field' => 'slug',
									'terms' => $att_location,
									'operator' => 'IN',
								)
							);
							
							$query->set('tax_query', $taxquery);
							
						}
						
						// pa and location
						
						if(!$att_keyword && $att_pa && $att_pa !== 'Search All Types' && $att_location) {
							
							array_push($taxquery,
								array(
									'taxonomy'  => 'practice_area',
									'field' => 'slug',
									'terms' => $att_pa,
									'operator' => 'IN',
								), 
								array(
									'taxonomy' => 'location',
									'field' => 'slug',
									'terms' => $att_location,
									'operator' => 'IN',
								)
							);
							
							$query->set('tax_query', $taxquery);
							
						}
						
						// all three
						
						if($att_keyword && $att_pa && $att_pa !== 'Search All Types' && $att_location) {
							
							$query-> set('s' , $att_keyword);
							
							array_push($taxquery, 
								array(
									'taxonomy'  => 'location',
									'field' => 'slug',
									'terms' => $att_location,
									'operator' => 'IN',
								), 
								array(
									'taxonomy'  => 'practice_area',
									'field' => 'slug',
									'terms' => $att_pa,
									'operator' => 'IN',
								)
							);
							
							$query->set('tax_query', $taxquery);
							
						}
						
						
						// "Search All Types" 
						
						
						
						// get all term ids
						
						
						if($att_pa =='Search All Types') {
							
							$termids = get_terms( array( 
									'taxonomy' => 'practice_area',
									'fields' => 'slugs',
								)
							);
							
						}
						
						
						 // all pas
						
						
						if(!$att_keyword && $att_pa =='Search All Types' && !$att_location) {
							
							return;
							
						}
						
						
						 // keywords and all pas
						
						
						if($att_keyword && $att_pa == 'Search All Types' && !$att_location) {
							
							$query-> set('s' , $att_keyword);
							
							array_push($taxquery,
								array(
									'taxonomy'  => 'practice_area',
									'field' => 'slug',
									'terms' => $termids,
									'operator' => 'IN',
								)
							);
							
							$query->set('tax_query', $taxquery);
							
						}
						
						
						//all pas and locations
						
						
						if(!$att_keyword && $att_pa == 'Search All Types' && $att_location) {
							
							$query-> set('s' , $att_keyword);
							
							array_push($taxquery, 
								array(
									'taxonomy'  => 'practice_area',
									'field' => 'slug',
									'terms' => $termids,
									'operator' => 'IN',
								),
								array(
									'taxonomy'  => 'location',
									'field' => 'slug',
									'terms' => $att_location, 
									'operator' => 'IN',
								)
							);
							
							$query->set('tax_query', $taxquery);
							
						}
						
						// all three (all pas)
						
						if($att_keyword && $att_pa == 'Search All Types' && $att_location) {
							
							$query-> set('s' , $att_keyword);
							
							array_push($taxquery,
								array(
									'taxonomy' => 'practice_area',
									'field' => 'slug',
									'terms' => $termids,
									'operator' => 'IN',
								), 
								array(
									'taxonomy'  => 'location',
									'field' => 'slug',
									'terms' => $att_location,
									'operator' => 'IN',
								)
							);
							
							$query->set('tax_query', $taxquery);
							
						}
						
						
						// If all inputs are empty and a search is ran
						
						
						if(empty($att_keyword) && empty($att_pa) && empty($att_location)) {
							
							return;
							
						}
						
        
						// print_r($query);
        
     
		}
		
		
		
		// pas "/lawyers-practice/criminal-defense"
		
		
		// if ( ! is_admin() && $query->is_main_query() && $query->is_archive('lawyer') && $query->is_tax('practice_area')) {
			
		
		// }
		
		
		
		
		//  "template-locations_city_pa.php"  /lawyers-practice/business/california/anaheim-hills
		
	
		if ( ! is_admin() && $query->is_main_query() && get_query_var( 'currentstate') && get_query_var( 'currentcity')) {
			
			
			// tax query for featured lawyers, these will sit up top of the regular results 
			
			$taxquery = array('relation' => 'AND');
			
			array_push($taxquery, 
				array(
					'taxonomy'  => $taxlocations,
					'field'     => 'slug',
					'terms'     => $currentcity,
					'operator' => 'IN',
				),
				array(
					'taxonomy'  => $taxpracticeareas,
					'field'     => 'slug',
					'terms'     =>	$currentpracticearea,
					'operator' => 'IN',
				),
				array(
					'taxonomy'  => 'featured_lawyers',
					'field'     => 'slug',
					'terms'     =>'featured-lawyer',
					'operator' => 'IN',
				)
			);
			
			
			$query-> set('tax_query', $taxquery);
			$query-> set('post_type' , 'lawyer');
			//$query-> set('paged' , $mypaged); // this is now unlimited
			$query-> set('fields' , 'ids');
			$query-> set('order' , 'ASC');
			$query-> set('post_status' , 'publish');
			$query-> set('orderby' , 'title');
			$query-> set('posts_per_page' , -1); // this could potentially timeout if there becomes a ton of featured posts for a pa, but unlikely 
			
		}		
		
	}
	
	
	add_action( 'pre_get_posts', 'my_custom_search' );
	

	// rest map endpoint

	require get_theme_file_path('/functions-inc/rest-map-endpoint.php');
	

	
	
	
	add_filter('rewrite_rules_array', 'mmp_rewrite_rules');
function mmp_rewrite_rules($rules) {
    $newRules  = array();
    $newRules['location/(.+)/(.+)/(.+)/(.+)/?$'] = 'index.php?lawyer=$matches[4]'; // my custom structure will always have the post name as the 5th uri segment
    $newRules['location/(.+)/?$'] = 'index.php?location=$matches[1]'; 

    return array_merge($newRules, $rules);
}


function filter_post_type_link($link, $post)
{
    if ($post->post_type != 'lawyer')
        return $link;

    if ($cats = get_the_terms($post->ID, 'location'))
    {
        $link = str_replace('%location%', get_taxonomy_parents(array_pop($cats)->term_id, 'location', false, '/', true), $link); // see custom function defined below
    }
    return $link;
}
add_filter('post_type_link', 'filter_post_type_link', 10, 2);



// my own function to do what get_category_parents does for other taxonomies
function get_taxonomy_parents($id, $taxonomy, $link = false, $separator = '/', $nicename = false, $visited = array()) {    
    $chain = '';   
    $parent = &get_term($id, $taxonomy);

    if (is_wp_error($parent)) {
        return $parent;
    }

    if ($nicename)    
        $name = $parent -> slug;        
else    
        $name = $parent -> name;

    if ($parent -> parent && ($parent -> parent != $parent -> term_id) && !in_array($parent -> parent, $visited)) {    
        $visited[] = $parent -> parent;    
        $chain .= get_taxonomy_parents($parent -> parent, $taxonomy, $link, $separator, $nicename, $visited);

    }

    if ($link) {
        // nothing, can't get this working :(
    } else    
        $chain .= $name . $separator;    
    return $chain;    
}





// Assigns parent child cats. also assigns city to exisiting state if a city does not exist, the advanced post creation plugin settings page is not capable of this so it needs to be written by hand 

add_action( 'gform_advancedpostcreation_post_after_creation', 'update_term_information', 10, 4 );

function update_term_information( $post_id, $feed, $entry, $form ) {
		
		//old address from orignal posts need to get updated for consistency
    
    $streetaddress = rgar( $entry, '36' );
    $city = rgar( $entry, '39' );
    $state = rgar( $entry, '56' );
    $zip = rgar( $entry, '38' );
    
    $newaddress = '' . $streetaddress . ' ' . $city . ', ' . $state . ' ' . $zip . '';
    
    update_field( 'lawyer_address', $newaddress, $post_id );
    update_field( 'hide_claim_button', 'Yes', $post_id );
    
    
    $layoutOption = rgar( $entry, '42' );
    
    if($layoutOption == 'Premium Profile $189/Year') {
    
    
    	// premium auto populate, these areas cant have repeaters on the gravity forms i cant figure out how to get repeaters on gform. so the second best way is to auto populate and then they can go in and adjust after the post is created through the front facing acf form
			
			$prem_bio = 'Lawyer Bio Content Section One';
			
			update_field( 'field_5b67c74fb7d3e', $prem_bio, $post_id );
			
			// selling points section
			
			$prem_selling_title = 'Selling Point Title';
			
			update_field( 'field_5c86cf23e8492', $prem_selling_title, $post_id );
			
			// selling point description
			
			$prem_selling_description = 'Selling Point Description';
			
			update_field( 'field_5c86cf7735c24', $prem_selling_description, $post_id );
			
			// selling poiny bg
			
			$prem_selling_bg = 'Building';
			
			update_field( 'field_5c86c4c695a34', $prem_selling_bg, $post_id );

			// second bio section
			
			$prem_bio_two = 'Lawyer Bio Content Section Two';
			
			update_field( 'field_5c86cfdfe5bd2', $prem_bio_two, $post_id );
			
			
			// bar admissions
			
			
			$prem_bar_admission = array(
			  // nested for each row
			  array(
			    'field_5c86d86e93e12' => 'Bar Admission List Item'
			  ),
			  array(
			    'field_5c86d86e93e12' => 'Bar Admission List Item'
			  ),
			  array(
			    'field_5c86d86e93e12' => 'Bar Admission List Item'
			  ),
			);
			
			/*
			foreach ($wows as $wow) {
			    $feature_value = (string)$second_gen;
			    $value[] = array( 'field_59606dc9525dc' => $feature_value );
			}
			*/
			
			update_field( 'field_5c86d7cc93e11', $prem_bar_admission, $post_id );
			
			
			// Case Results
			
			$prem_case_results = array(
			  // nested for each row
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  
			);
			
			update_field( 'field_5c86dee8caf28', $prem_case_results, $post_id );
			
			
			// faqs
			
			// column one
			
			$prem_faqs = array(
			  // nested for each row
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  
			);
			
			update_field( 'field_5c86e1152b9e9', $prem_faqs, $post_id );
			
			
			// column two
			
			$prem_faqs_two = array(
			  // nested for each row
			  array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
			   array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
				 array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
				 array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
			
			    
			);
			
			update_field( 'field_5c86e1a5d7023', $prem_faqs_two, $post_id );
			
			
			}
			
			
			
			// parent cat "State"
			
			$stateid = '139';
			
			// State Name to ID
			
			$statenameid = $entry['56'];
			
			$mystate_term = term_exists( $statenameid, 'location' );
			
			$mystate_termid = $mystate_term['term_id'];
			
			// City Name to ID
			
			$entrycity = $entry['39'];
			
			$mycity_term = term_exists( $entrycity, 'location' );
			
			$mycity_termid = $mycity_term['term_id'];
			
			$location_string = $stateid . ',' . $mystate_termid . ', ' . $mycity_termid;
			
			
			if($mycity_term) {
				
				wp_set_post_terms( $post_id, $location_string, 'location' );
			
			}
			
			if(!$mycity_term) {
				
					$rules[] = ",";
					$rules[] = " ";
					$rules[] = "'";
				
				  $entrycity_nospace = str_replace($rules, '-', $entrycity);
				
				//$entrycity_nospace = preg_replace('/\s*/', '', $entrycity);
				
				
				$entrycity_slug = strtolower($entrycity_nospace);
				
				wp_insert_term(
					$entrycity, // the term 
					'location', // the taxonomy
					array(
						//'description'=> 'a term update test of san diego',
						'slug' => $entrycity_slug,
						'parent'=> $mystate_termid  // get numeric term id
					)
				);
				
				//get the term id i just created and throw into the string below
				
				$mynewcity_term = term_exists( $entrycity, 'location' );
				
				$mynewcity_termid = $mynewcity_term['term_id'];
				
				$newlocation_string = $stateid . ',' . $mystate_termid . ', ' . $mynewcity_termid;
				
				wp_set_post_terms( $post_id, $newlocation_string, 'location' ); // does $post_id need to become $post_id = get_post( $entry['post_id'] ); $podt_id->ID or is it just assumed in the advanced custom stuff, if i make my own post creation then i might have to do this ^^^
			
			}

	}
	
	
	// update profile image logged in
	
	add_action( 'gform_after_submission_8', 'loggedinProfile', 10, 2 );
	
	function loggedinProfile( $entry, $form ) {
		
		// all redundant code to form 2
		
		//getting post
    $post = get_post( $entry['post_id'] );
    
    // featured image
    
    $url = rgar( $entry, 55 ); 
    
    // Current directory
		
		$abs_path = getcwd();
		
		// Convert to absolute URL
		
		$url = str_replace( site_url(), $abs_path, $url);
		
		// Checking filetype for MIME
		
		$filetype = wp_check_filetype( basename( $url ), null );
		
		// WordPress upload directory	
		
		$wp_upload_dir = wp_upload_dir();	
		
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $url ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $url ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
	
		// Get attachment ID
	
		$attach_id = wp_insert_attachment( $attachment, $url, $post );
	
		// Dependency for wp_generate_attachment_metadata().
	
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
	
		// Generate metadata for image attachment.
	
		$attach_data = wp_generate_attachment_metadata( $attach_id, $url );
	
		wp_update_attachment_metadata( $attach_id, $attach_data );
	
		// Set as featured image for the post created on line 13.
	
		set_post_thumbnail( $post, $attach_id );
		
    //updating post
    wp_update_post( $post );
		
		
	}
	
	
	// update title and slug logged in
	
	add_action( 'gform_after_submission_7', 'loggedinTitle', 10, 2 );
	
	function loggedinTitle( $entry, $form ) {
		
		// all redundant code to form 2
		
		//getting post
    $post = get_post( $entry['post_id'] );
    
    //changing post title
    
    $post->post_title = rgar( $entry, '1' );
    $post->post_name = rgar( $entry, '1' );
		
    //updating post
    wp_update_post( $post );
		
		
	}
	
	
	
	
	// update practice areas logged in
	
	add_action( 'gform_after_submission_10', 'loggedinPracticeareas', 10, 2 );
	
	function loggedinPracticeareas( $entry, $form ) {
		
		// all redundant code to form 2
    
     //getting post
    $post = get_post( $entry['post_id'] );
    
    // practice areas
    
    
    $postid = $post->ID;
				

		$field_id = 28; // Update this number to your field id number
		$field = RGFormsModel::get_field( $form, $field_id );
		$value = is_object( $field ) ? $field->get_value_export( $entry, $field_id, true ) : '';
		
		wp_set_post_terms( $postid, $value, 'practice_area' );
		
		
	}

	
	
	
	
	// update address logged in
	
	add_action( 'gform_after_submission_9', 'loggedinAddress', 10, 2 );
	
	function loggedinAddress( $entry, $form ) {
		
		// all redundant code to form 2
		
		//getting post
    $post = get_post( $entry['post_id'] );
    
    
    update_field( 'lawyer_street_address', rgar( $entry, '36' ), $post );
    update_field( 'lawyer_city', rgar( $entry, '39' ), $post );
    update_field( 'lawyer_state', rgar( $entry, '56' ), $post );
    update_field( 'lawyer_zip', rgar( $entry, '38' ), $post );
    
    update_field( 'latitude', rgar( $entry, '88' ), $post );
    update_field( 'longitude', rgar( $entry, '87' ), $post );

    
    //updating post
    wp_update_post( $post );
    
    // locations
    
    $postid = $post->ID;
			
		$stateid = '139';
		
		// State Name to ID
		
		$statenameid = $entry['56'];
		
		$mystate_term = term_exists( $statenameid, 'location' );
		
		$mystate_termid = $mystate_term['term_id'];
		
		// City Name to ID
		
		$entrycity = $entry['39'];
		
		$mycity_term = term_exists( $entrycity, 'location' );
		
		$mycity_termid = $mycity_term['term_id'];
		
		$location_string = $stateid . ',' . $mystate_termid . ', ' . $mycity_termid;
		
		
		if($mycity_term) {
			
			wp_set_post_terms( $postid, $location_string, 'location' );
		
		}
		
		if(!$mycity_term) {
			
				$rules[] = ",";
				$rules[] = " ";
				$rules[] = "'";
			
			  $entrycity_nospace = str_replace($rules, '-', $entrycity);
			
			//$entrycity_nospace = preg_replace('/\s*/', '', $entrycity);
			
			
			$entrycity_slug = strtolower($entrycity_nospace);
			
			wp_insert_term(
				$entrycity, // the term 
				'location', // the taxonomy
				array(
					//'description'=> 'a term update test of san diego',
					'slug' => $entrycity_slug,
					'parent'=> $mystate_termid  // get numeric term id
				)
			);
			
			//get the term id i just created and throw into the string below
			
			$mynewcity_term = term_exists( $entrycity, 'location' );
			
			$mynewcity_termid = $mynewcity_term['term_id'];
			
			$newlocation_string = $stateid . ',' . $mystate_termid . ', ' . $mynewcity_termid;
			
			wp_set_post_terms( $postid, $newlocation_string, 'location' ); 
		
		}

		
		
	}
	
	
	
	// update existing posts 
	
	add_action( 'gform_after_submission_2', 'set_post_content', 10, 2 );
	
	
	function set_post_content( $entry, $form ) {
 
    //getting post
    $post = get_post( $entry['post_id'] );
 
    //changing post title
    
    $post->post_title = rgar( $entry, '1' );
    $post->post_name = rgar( $entry, '1' );
    
    //update_field("_personal_information_first_name","field_5b672aa250437",$post);
    
    update_field( 'lawyer_premium_layout_two', rgar( $entry, '42' ), $post );
    
    update_field( 'hide_claim_button', 'Yes', $post );
    
    
    
    //The field’s key should be used when saving a new value to a post (when no value exists) https://www.advancedcustomfields.com/resources/update_field/
    
    
    
    update_field( 'lawyer_phone', rgar( $entry, '2' ), $post );
    update_field( 'lawyer_email', rgar( $entry, '48' ), $post );
    update_field( 'lawfirm_name', rgar( $entry, '4' ), $post );
    update_field( 'lawyer_website', rgar( $entry, '5' ), $post );
    
    update_field( 'lawyer_street_address', rgar( $entry, '36' ), $post );
    update_field( 'lawyer_city', rgar( $entry, '39' ), $post );
    update_field( 'lawyer_state', rgar( $entry, '56' ), $post );
    update_field( 'lawyer_zip', rgar( $entry, '38' ), $post );
    
    //old address from orignal posts need to get updated for consistency redundant from other function fix this and combine into one function call
    
    $streetaddress = rgar( $entry, '36' );
    $city = rgar( $entry, '39' );
    $state = rgar( $entry, '56' );
    $zip = rgar( $entry, '38' );
    
    $newaddress = '' . $streetaddress . ' ' . $city . ', ' . $state . ' ' . $zip . '';
    
    update_field( 'lawyer_address', $newaddress, $post );
    
    update_field( 'latitude', rgar( $entry, '88' ), $post );
    update_field( 'longitude', rgar( $entry, '87' ), $post );
    
    update_field( 'school_one_name', rgar( $entry, '10' ), $post );
    
    
    if(rgar( $entry, '11' )) {
	    update_field( 'school_one_major', rgar( $entry, '11' ), $post );
    }
    
    if(rgar( $entry, '12' )) {
	    update_field( 'school_one_degree', rgar( $entry, '12' ), $post );
	  }
    
    if(rgar( $entry, '13' )) {
	    update_field( 'school_one_year_graduated', rgar( $entry, '13' ), $post );
    }
    
    if(rgar( $entry, '14' )) {
	    update_field( 'school_two_name', rgar( $entry, '14' ), $post );
    }
    
    if(rgar( $entry, '15' )) {
	    update_field( 'school_two_major', rgar( $entry, '15' ), $post );
    }
    
    if(rgar( $entry, '16' )) {
	    update_field( 'school_two_degree', rgar( $entry, '16' ), $post );
    }
    
    if(rgar( $entry, '17' )) {
	    update_field( 'school_two_year_graduated', rgar( $entry, '17' ), $post );
    }
    
    if(rgar( $entry, '3' )) {
	    update_field( 'years_licensed_for', rgar( $entry, '3' ), $post );
    }
    
    if(rgar( $entry, '9' )) {
	    update_field( 'lawyer_bio', rgar( $entry, '9' ), $post );
    }
    
    
   
    
    $layoutOption = rgar( $entry, '42' );
    
    if($layoutOption == 'Premium Profile $189/Year') {
    
    
    	// premium auto populate, these areas cant have repeaters on the gravity forms i cant figure out how to get repeaters on gform. so the second best way is to auto populate and then they can go in and adjust after the post is created through the front facing acf form
			
			$prem_bio = 'Lawyer Bio Content Section One';
			
			update_field( 'field_5b67c74fb7d3e', $prem_bio, $post_id );
			
			// selling points section
			
			$prem_selling_title = 'Selling Point Title';
			
			update_field( 'field_5c86cf23e8492', $prem_selling_title, $post_id );
			
			// selling point description
			
			$prem_selling_description = 'Selling Point Description';
			
			update_field( 'field_5c86cf7735c24', $prem_selling_description, $post_id );
			
			// selling poiny bg
			
			$prem_selling_bg = 'Building';
			
			update_field( 'field_5c86c4c695a34', $prem_selling_bg, $post_id );

			// second bio section
			
			$prem_bio_two = 'Lawyer Bio Content Section Two';
			
			update_field( 'field_5c86cfdfe5bd2', $prem_bio_two, $post_id );
			
			
			// bar admissions
			
			
			$prem_bar_admission = array(
			  // nested for each row
			  array(
			    'field_5c86d86e93e12' => 'Bar Admission List Item'
			  ),
			  array(
			    'field_5c86d86e93e12' => 'Bar Admission List Item'
			  ),
			  array(
			    'field_5c86d86e93e12' => 'Bar Admission List Item'
			  ),
			);
			
			/*
			foreach ($wows as $wow) {
			    $feature_value = (string)$second_gen;
			    $value[] = array( 'field_59606dc9525dc' => $feature_value );
			}
			*/
			
			update_field( 'field_5c86d7cc93e11', $prem_bar_admission, $post_id );
			
			
			// Case Results
			
			$prem_case_results = array(
			  // nested for each row
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  
			);
			
			update_field( 'field_5c86dee8caf28', $prem_case_results, $post_id );
			
			
			// faqs
			
			// column one
			
			$prem_faqs = array(
			  // nested for each row
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  
			);
			
			update_field( 'field_5c86e1152b9e9', $prem_faqs, $post_id );
			
			
			// column two
			
			$prem_faqs_two = array(
			  // nested for each row
			  array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
			   array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
				 array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
				 array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
			
			    
			);
			
			update_field( 'field_5c86e1a5d7023', $prem_faqs_two, $post_id );
			
			
			}

        
    // featured image
    
    $url = rgar( $entry, 55 ); 
    
    // Current directory
		
		$abs_path = getcwd();
		
		// Convert to absolute URL
		
		$url = str_replace( site_url(), $abs_path, $url);
		
		// Checking filetype for MIME
		
		$filetype = wp_check_filetype( basename( $url ), null );
		
		// WordPress upload directory	
		
		$wp_upload_dir = wp_upload_dir();	
		
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $url ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $url ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
	
		// Get attachment ID
	
		$attach_id = wp_insert_attachment( $attachment, $url, $post );
	
		// Dependency for wp_generate_attachment_metadata().
	
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
	
		// Generate metadata for image attachment.
	
		$attach_data = wp_generate_attachment_metadata( $attach_id, $url );
	
		wp_update_attachment_metadata( $attach_id, $attach_data );
	
		// Set as featured image for the post created on line 13.
	
		set_post_thumbnail( $post, $attach_id );
		
		// Set newly created user as the author for this updated post

		$username = rgar( $entry, '30' );
		
		// at this point in the hook sequence, it looks like the new user is already registered and able to be found
    
    $newuser = get_user_by('login', $username);
		
		$newuser_id = $newuser->ID;
		
		$post->post_author = $newuser_id;

    //updating post
    wp_update_post( $post );
    
    
    // all taxonomies, pa, location and featured lawyers cats
    
    
    // locations
    
    $postid = $post->ID;
			
		$stateid = '139';
		
		// State Name to ID
		
		$statenameid = $entry['56'];
		
		$mystate_term = term_exists( $statenameid, 'location' );
		
		$mystate_termid = $mystate_term['term_id'];
		
		// City Name to ID
		
		$entrycity = $entry['39'];
		
		$mycity_term = term_exists( $entrycity, 'location' );
		
		$mycity_termid = $mycity_term['term_id'];
		
		$location_string = $stateid . ',' . $mystate_termid . ', ' . $mycity_termid;
		
		
		if($mycity_term) {
			
			wp_set_post_terms( $postid, $location_string, 'location' );
		
		}
		
		if(!$mycity_term) {
			
				$rules[] = ",";
				$rules[] = " ";
				$rules[] = "'";
			
			  $entrycity_nospace = str_replace($rules, '-', $entrycity);
			
			//$entrycity_nospace = preg_replace('/\s*/', '', $entrycity);
			
			
			$entrycity_slug = strtolower($entrycity_nospace);
			
			wp_insert_term(
				$entrycity, // the term 
				'location', // the taxonomy
				array(
					//'description'=> 'a term update test of san diego',
					'slug' => $entrycity_slug,
					'parent'=> $mystate_termid  // get numeric term id
				)
			);
			
			//get the term id i just created and throw into the string below
			
			$mynewcity_term = term_exists( $entrycity, 'location' );
			
			$mynewcity_termid = $mynewcity_term['term_id'];
			
			$newlocation_string = $stateid . ',' . $mystate_termid . ', ' . $mynewcity_termid;
			
			wp_set_post_terms( $postid, $newlocation_string, 'location' ); 
		
		}
		
		// practice areas
				

		$field_id = 28; // Update this number to your field id number
		$field = RGFormsModel::get_field( $form, $field_id );
		$value = is_object( $field ) ? $field->get_value_export( $entry, $field_id, true ) : '';
		
		wp_set_post_terms( $postid, $value, 'practice_area' );
		
		// featured lawyer
		
		if($entry['42'] =="Premium Profile $189/Year") { // this value or featured lawyer wont work
			
			wp_set_post_terms( $postid, 'Featured Lawyer', 'featured_lawyers' );
			
		}
		
		
	}
	
	
	
	add_action( 'gform_after_submission_11', 'set_upgradepost_content', 10, 2 );
	
	
	
	
	function set_upgradepost_content( $entry, $form ) {
 
    //getting post
    $post = get_post( $entry['post_id'] );
 
    //changing post title
    
    $post->post_title = rgar( $entry, '1' );
    $post->post_name = rgar( $entry, '1' );
    
    //update_field("_personal_information_first_name","field_5b672aa250437",$post);
    
    update_field( 'lawyer_premium_layout_two', rgar( $entry, '42' ), $post );
    
    update_field( 'hide_claim_button', 'Yes', $post );
    
    
    
    //The field’s key should be used when saving a new value to a post (when no value exists) https://www.advancedcustomfields.com/resources/update_field/
    
    
    
    update_field( 'lawyer_phone', rgar( $entry, '2' ), $post );
    update_field( 'lawyer_email', rgar( $entry, '48' ), $post );
    update_field( 'lawfirm_name', rgar( $entry, '4' ), $post );
    update_field( 'lawyer_website', rgar( $entry, '5' ), $post );
    
    update_field( 'lawyer_street_address', rgar( $entry, '36' ), $post );
    update_field( 'lawyer_city', rgar( $entry, '39' ), $post );
    update_field( 'lawyer_state', rgar( $entry, '56' ), $post );
    update_field( 'lawyer_zip', rgar( $entry, '38' ), $post );
    
    //old address from orignal posts need to get updated for consistency redundant from other function fix this and combine into one function call
    
    $streetaddress = rgar( $entry, '36' );
    $city = rgar( $entry, '39' );
    $state = rgar( $entry, '56' );
    $zip = rgar( $entry, '38' );
    
    $newaddress = '' . $streetaddress . ' ' . $city . ', ' . $state . ' ' . $zip . '';
    
    update_field( 'lawyer_address', $newaddress, $post );
    
    update_field( 'latitude', rgar( $entry, '88' ), $post );
    update_field( 'longitude', rgar( $entry, '87' ), $post );
    
    update_field( 'school_one_name', rgar( $entry, '10' ), $post );
    update_field( 'school_one_major', rgar( $entry, '11' ), $post );
    update_field( 'school_one_degree', rgar( $entry, '12' ), $post );
    update_field( 'school_one_year_graduated', rgar( $entry, '13' ), $post );
    
    update_field( 'school_two_name', rgar( $entry, '14' ), $post );
    update_field( 'school_two_major', rgar( $entry, '15' ), $post );
    update_field( 'school_two_degree', rgar( $entry, '16' ), $post );
    update_field( 'school_two_year_graduated', rgar( $entry, '17' ), $post );
    
    update_field( 'years_licensed_for', rgar( $entry, '3' ), $post );
    update_field( 'lawyer_bio', rgar( $entry, '9' ), $post );
    
    $layoutOption = rgar( $entry, '42' );
    
    if($layoutOption == 'Premium Profile $189/Year') {
    
    
    	// premium auto populate, these areas cant have repeaters on the gravity forms i cant figure out how to get repeaters on gform. so the second best way is to auto populate and then they can go in and adjust after the post is created through the front facing acf form
			
			$prem_bio = 'Lawyer Bio Content Section One';
			
			update_field( 'field_5b67c74fb7d3e', $prem_bio, $post_id );
			
			// selling points section
			
			$prem_selling_title = 'Selling Point Title';
			
			update_field( 'field_5c86cf23e8492', $prem_selling_title, $post_id );
			
			// selling point description
			
			$prem_selling_description = 'Selling Point Description';
			
			update_field( 'field_5c86cf7735c24', $prem_selling_description, $post_id );
			
			// selling poiny bg
			
			$prem_selling_bg = 'Building';
			
			update_field( 'field_5c86c4c695a34', $prem_selling_bg, $post_id );

			// second bio section
			
			$prem_bio_two = 'Lawyer Bio Content Section Two';
			
			update_field( 'field_5c86cfdfe5bd2', $prem_bio_two, $post_id );
			
			
			// bar admissions
			
			
			$prem_bar_admission = array(
			  // nested for each row
			  array(
			    'field_5c86d86e93e12' => 'Bar Admission List Item'
			  ),
			  array(
			    'field_5c86d86e93e12' => 'Bar Admission List Item'
			  ),
			  array(
			    'field_5c86d86e93e12' => 'Bar Admission List Item'
			  ),
			);
			
			/*
			foreach ($wows as $wow) {
			    $feature_value = (string)$second_gen;
			    $value[] = array( 'field_59606dc9525dc' => $feature_value );
			}
			*/
			
			update_field( 'field_5c86d7cc93e11', $prem_bar_admission, $post_id );
			
			
			// Case Results
			
			$prem_case_results = array(
			  // nested for each row
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  array(
			    'field_5c86def7caf29' => 'Case Results Title',
			    'field_5c86df05caf2a' => 'Verdict',
			    'field_5c86df0fcaf2b' => 'Description',
			  ),
			  
			);
			
			update_field( 'field_5c86dee8caf28', $prem_case_results, $post_id );
			
			
			// faqs
			
			// column one
			
			$prem_faqs = array(
			  // nested for each row
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  array(
			    'field_5c86e1292b9ea' => 'Question',
			    'field_5c86e1332b9eb' => 'Answer',
			  ),
			  
			);
			
			update_field( 'field_5c86e1152b9e9', $prem_faqs, $post_id );
			
			
			// column two
			
			$prem_faqs_two = array(
			  // nested for each row
			  array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
			   array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
				 array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
				 array(
			    'field_5c86e1a5d7024' => 'Question',
			    'field_5c86e1a5d7025' => 'Answer',
			  ),
			
			    
			);
			
			update_field( 'field_5c86e1a5d7023', $prem_faqs_two, $post_id );
			
			
			}

        
    // featured image
    
    $url = rgar( $entry, 55 ); 
    
    // Current directory
		
		$abs_path = getcwd();
		
		// Convert to absolute URL
		
		$url = str_replace( site_url(), $abs_path, $url);
		
		// Checking filetype for MIME
		
		$filetype = wp_check_filetype( basename( $url ), null );
		
		// WordPress upload directory	
		
		$wp_upload_dir = wp_upload_dir();	
		
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $url ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $url ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
	
		// Get attachment ID
	
		$attach_id = wp_insert_attachment( $attachment, $url, $post );
	
		// Dependency for wp_generate_attachment_metadata().
	
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
	
		// Generate metadata for image attachment.
	
		$attach_data = wp_generate_attachment_metadata( $attach_id, $url );
	
		wp_update_attachment_metadata( $attach_id, $attach_data );
	
		// Set as featured image for the post created on line 13.
	
		set_post_thumbnail( $post, $attach_id );

		

    //updating post
    wp_update_post( $post );
    
    
    // all taxonomies, pa, location and featured lawyers cats
    
    
    // locations
    
    $postid = $post->ID;
			
		$stateid = '139';
		
		// State Name to ID
		
		$statenameid = $entry['56'];
		
		$mystate_term = term_exists( $statenameid, 'location' );
		
		$mystate_termid = $mystate_term['term_id'];
		
		// City Name to ID
		
		$entrycity = $entry['39'];
		
		$mycity_term = term_exists( $entrycity, 'location' );
		
		$mycity_termid = $mycity_term['term_id'];
		
		$location_string = $stateid . ',' . $mystate_termid . ', ' . $mycity_termid;
		
		
		if($mycity_term) {
			
			wp_set_post_terms( $postid, $location_string, 'location' );
		
		}
		
		if(!$mycity_term) {
			
				$rules[] = ",";
				$rules[] = " ";
				$rules[] = "'";
			
			  $entrycity_nospace = str_replace($rules, '-', $entrycity);
			
			//$entrycity_nospace = preg_replace('/\s*/', '', $entrycity);
			
			
			$entrycity_slug = strtolower($entrycity_nospace);
			
			wp_insert_term(
				$entrycity, // the term 
				'location', // the taxonomy
				array(
					//'description'=> 'a term update test of san diego',
					'slug' => $entrycity_slug,
					'parent'=> $mystate_termid  // get numeric term id
				)
			);
			
			//get the term id i just created and throw into the string below
			
			$mynewcity_term = term_exists( $entrycity, 'location' );
			
			$mynewcity_termid = $mynewcity_term['term_id'];
			
			$newlocation_string = $stateid . ',' . $mystate_termid . ', ' . $mynewcity_termid;
			
			wp_set_post_terms( $postid, $newlocation_string, 'location' ); 
		
		}
		
		// practice areas
				

		$field_id = 28; // Update this number to your field id number
		$field = RGFormsModel::get_field( $form, $field_id );
		$value = is_object( $field ) ? $field->get_value_export( $entry, $field_id, true ) : '';
		
		wp_set_post_terms( $postid, $value, 'practice_area' );
		
		// featured lawyer
		
		if($entry['42'] =="Premium Profile $189/Year") { // this value or featured lawyer wont work
			
			wp_set_post_terms( $postid, 'Featured Lawyer', 'featured_lawyers' );
			
		}
		
		
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	add_filter("gform_submit_button", "form_submit_button", 10, 2); 
	
	function form_submit_button( $button, $form ) {
		
		$dom = new DOMDocument();
    $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $button );
    $input = $dom->getElementsByTagName( 'input' )->item(0);
    $onclick = $input->getAttribute( 'onclick' );
    $onclick .= "document.getElementById('prepare').classList.add('fadein');var elems = document.querySelectorAll('.gform_wrapper');[].forEach.call(elems, function(el) {el.classList.remove('gform_validation_error')})"; // Here's the JS function we're calling on click.
    $input->setAttribute( 'onclick', $onclick );
    return $dom->saveHtml( $input );
    
    //document.getElementsByClassName('gform_wrapper_2').classList.remove('gform_validation_error');
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



// autologin after registration


add_action( 'gform_user_registered', 'autologin',  10, 4 );


function autologin( $user_id, $user_config, $entry, $password ) {
	
	$user = get_userdata( $user_id );
	$user_login = $user->user_login;
	$user_password = $password;
  $user->set_role(get_option('default_role', 'subscriber'));

    wp_signon( array(
		'user_login' => $user_login,
		'user_password' =>  $user_password,
		'remember' => true
		) );
		
		
}




// hide admin

add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {

	if (!current_user_can('administrator') && !is_admin()) {
  	show_admin_bar(false);
	}

}




add_action( 'wp_login_failed', 'login_fail' );  // hook failed login

function login_fail( $username ) {
     
     $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
     // if there's a valid referrer, and it's not the default log-in screen
     if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
          
          wp_safe_redirect(get_bloginfo('url') . '/login/?login=failed' );  // let's append some information (login=logged-out) to the URL for the theme to use
          
          exit;
     }
}

add_action( 'authenticate', 'check_username_password', 1, 3);
function check_username_password( $login, $username, $password ) {

// Getting URL of the login page
$referrer = $_SERVER['HTTP_REFERER'];

// if there's a valid referrer, and it's not the default log-in screen
if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) { 
    if( $username == "" || $password == "" ){
        wp_safe_redirect( get_bloginfo('url') . '/login/?login=loggedout' );
        exit;
    }
}

}




function my_login_redirect( $redirect_to, $request, $user ) {
    
    //is there a user to check?
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if ( in_array( 'administrator', $user->roles ) ) {
            // redirect them to the default place
            
            $mydashboard = get_bloginfo('url') . '/wp-admin';
            
            return $mydashboard;
        
        } else {
	        
	        	$user_id = $user->ID;
	        	
	        	$author_args = array(
							'posts_per_page' => 1,
							'post_type' => 'lawyer',
							'post_status' => 'publish',
							'author' => $user_id,
							'orderby' => 'date',
							'order' => 'ASC',
						);
						
						
						
						$first_post = new WP_Query($author_args); while($first_post->have_posts()) : $first_post->the_post(); 
            
            	$post_redirect[] = get_the_ID();
            
            endwhile; 
            
            wp_reset_postdata(); // reset the query 
						
						
						$url_id = reset($post_redirect);

	        	
	        	$url = get_bloginfo('url') . "/lawyer/?p=" . $url_id;  
	        
	        
            return $url;
        
        }
    } else {
        return $redirect_to;
    }
}
 

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );


//add_filter("gform_confirmation_anchor", create_function("","return 300;"));


add_filter( 'gform_confirmation_anchor_2', function() {
    return 0;
} );

add_filter( 'gform_confirmation_anchor_4', function() {
    return 300;
} );


function custom_login_logo() {
    echo '<style type ="text/css">.login h1 a { display:none!important; }</style>';
}

add_action('login_head', 'custom_login_logo');



// disabes acf form styles 


function unqueue_af_css() {
    wp_deregister_style('acf-input'); 
}
add_action( 'wp_enqueue_scripts', 'unqueue_af_css', 9999 );



	// overrides the confirmation on form 2 to just redirect back itself (the ?p=post_id doesnt redirect properly when starting on the bio post, but works from settings from antoher page like "create a profile"
	
	
	//add_filter( 'gform_confirmation_2', 'custom_confirmation', 10, 4 );
	
/*
	function custom_confirmation( $confirmation, $form, $entry, $ajax ) {
				
		$pid = $entry['post_id'];
		
		$slug = get_post_field( 'post_name', $pid );
			
		$url = get_bloginfo('url') . '/lawyer/' . $slug . '/?profile=success';

		$confirmation = array('redirect' => $url);
				
		return $confirmation;
		
		//{embed_post:ID}

	}
*/











	