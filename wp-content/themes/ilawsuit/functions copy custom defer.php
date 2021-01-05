<?php 



/* Enqueued Scripts and passing php data into js files
-------------------------------------------------------------- */



 
function load_my_styles_scripts() {
  
    
    wp_enqueue_style( 'styles', get_template_directory_uri() . '/style.css', '', 5, 'all' ); 
    

    // disables jquery then registers it again to go into footer
    
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
    wp_enqueue_script( 'jquery' );
    
		
		// custom js to fall uner jquery in footer
		    
    wp_register_script( 'jquery-addon', get_template_directory_uri() . '/js/custom-min.js','', 1);
    
		// Localized PHP Data that needs to be passed onto my custom-min.js file
			
		if (get_query_var( 'currentstate') && get_query_var( 'currentcity')) { 
			
				
				$currentpracticearea =  get_query_var( 'office_pa'); // figure out how to decale these outside of a function one time on this file and call them into where needed

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
     		
     		// build gecode url to retrieve the current city coordinates so the map can recenter
     		
     		$mapaddress = $citytermtitle . ',' . $statetermtitle; 
		 		$prepAddr = str_replace(' ','+',$mapaddress);
        
        
		 		$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key=' . $google_map_api .'');
     

		 		$output= json_decode($geocode);
		 		$city_latitude = $output->results[0]->geometry->location->lat;
		 		$city_longitude = $output->results[0]->geometry->location->lng;
        
       }
       
       // current domian used for the rest api url call
       
       $currentdomain = get_bloginfo('url');
       $lawyer_title = get_the_title();
       
       // Attorney Bio Meta Data for form and post updates
       
       $lawyerbio_city = get_field('lawyer_city');
       $lawyerbio_state = get_field('lawyer_state');
       $lawyerbio_stateabr = get_field('state_abbr');
       $lawyerbio_zipcode = get_field('lawyer_zip');
       
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
			);

			wp_localize_script( 'jquery-addon', 'my_mapdata', $map_array );
		
		
		
		// carry on to enqueue script like normal, but now it contains my needed js variable with php data tied to it from above
		

		// Enqueue Script
		
		wp_enqueue_script( 'jquery-addon', get_template_directory_uri() . '/js/custom-min.js', 'jquery', '', true );
		
		wp_enqueue_script( 'jquery-mygravity', get_template_directory_uri() . '/js/gravityforms-min.js', 'jquery', '', true );
		
		
		if (get_query_var( 'currentstate') && get_query_var( 'currentcity')) { 
			
			// https://giogadesign.com/how-to-add-defer-async-attributes-to-wordpress-scripts/
		
			wp_enqueue_script('googleapis', esc_url( add_query_arg( 'key', $google_map_api .'&callback=initMap', '//maps.googleapis.com/maps/api/js' )), array(), null, true );
		
		
		}
		    
   
    

 }
 
 add_action( 'wp_enqueue_scripts', 'load_my_styles_scripts', 20 );
 
 
 
 /* Defer JS for Lighthouse
-------------------------------------------------------------- */
 
 
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





/* dequeue embed for lighthouse
-------------------------------------------------------------- */




 function my_deregister_scripts(){
  
  wp_deregister_script( 'wp-embed' );

	}

	add_action( 'wp_footer', 'my_deregister_scripts' );





/* dequeue gravity form files that effect critical chain page speed and defer them later in a combined file
-------------------------------------------------------------- */
	
	


	function deregister_scripts(){
			
  wp_deregister_script("gform_placeholder");
  wp_deregister_script("gform_masked_input");
  wp_deregister_script("gform_json");
  wp_deregister_script("gform_gravityforms");
  wp_deregister_script("gform_conditional_logic");
  
  
 }
	
	
 add_action("gform_enqueue_scripts", "deregister_scripts");
 
 





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
 //'min_chars' => 250,
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
	
	
	
	
	