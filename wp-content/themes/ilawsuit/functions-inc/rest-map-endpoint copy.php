<?php
	
add_action( 'rest_api_init', 'map_route' ); 

	function map_route() {
    
		register_rest_route( 'mapping/v1', 'location/(?P<map_city>[a-z0-9]+(?:-[a-z0-9]+)*)/(?P<map_pa>[a-z0-9]+(?:-[a-z0-9]+)*)/(?P<page>[1-9]{1,2})', 
			array(
				'methods' => 'GET',
				'callback' => 'map_query',
				'args' => array(
					'map_city' => array(
						'required' => true
					),
					'map_pa' => array(
						'required' => true
					),
					'page' => array(
						'required' => true
					),
				),
			)
			
		);
		
	}
	
	
	function map_query($request_data) {
		
		$parameters = $request_data->get_params();
    $map_city = $parameters['map_city'];
    $map_pa = $parameters['map_pa'];
    $page = $parameters['page'];
		
    $testargs = array(
	  	'post_type' => 'lawyer',
			'posts_per_page' => 100,
			'paged' => $page,
    	'orderby' => 'title',
    	'post_status' => 'publish',
			'order' => 'ASC',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy'  => 'location',
					'field' => 'slug',
					'terms' => $map_city,
					'operator' => 'IN',
					),
				array(
					'taxonomy'  => 'practice_area',
					'field'     => 'slug',
					'terms'     =>  $map_pa,
					'operator' => 'IN',
				)
			),
		);
		
		
		$post_data = array();
		
		$test_query = new WP_Query($testargs); 
		
		
		while($test_query->have_posts()) : $test_query->the_post();
		
			$mytitle = get_the_title();
			$mypermalink = get_the_permalink();
		
			$lat = get_field('latitude');
			$lattwo = round($lat, 6);
		
				
			$lgn = get_field('longitude');
			$lgntwo = round($lgn, 6);
		
			
			$address = get_field('lawyer_address');
			
			$phone = get_field('lawyer_phone');
			$tel_href = str_replace(['-', '(', ')', ' '], '', $phone);
			
		
			$post_data[] = array(
		    'Title' => $mytitle,
		    'Permalink' => $mypermalink,
		    'Lat' => $lattwo,
		    'Lng' =>  $lgntwo,
		    'Address' => $address,
		    'Phone' => $phone,
		    'Tel_href' => $tel_href,
		    //'"ACF"' => get_fields($post->ID)
		    
	    );
	    
	  endwhile; 
		
		wp_reset_postdata();
    
    return rest_ensure_response($post_data);
		
   
	}
	
