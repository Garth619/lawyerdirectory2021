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
		
		global $wpdb;
		
		$parameters = $request_data->get_params();
    $map_city = $parameters['map_city'];
    $map_pa = $parameters['map_pa'];
    $page = $parameters['page'];
		
    $featured_args = array(
	  	'post_type' => 'lawyer',
			'posts_per_page' => -1, // could potentially be alot of posts
			//'paged' => $page,
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
				),
				array(
					'taxonomy'  => 'featured_lawyers',
					'field'     => 'slug',
					'terms'     =>'featured-lawyer',
					'operator' => 'IN',
				)
			),
		);
		
		$postid_array = array();
		$post_data = array();
		
		
		if($page == 1) {
		
			$featured_query = new WP_Query($featured_args); 
		
		
			while($featured_query->have_posts()) : $featured_query->the_post();
						
				
				$lawyer_profile_picture = get_the_post_thumbnail_url();
				
				
				
				$post_ids[] = get_the_ID();
				
				
				$latlong = get_the_ID();    
				$result = $wpdb->get_results( "SELECT lat_long FROM gmoney_geocode WHERE post_id='".$latlong."'");
				
				$latgnum = get_field('latitude');
				$latfloat = (float)$latgnum;
				
				//$longnum = get_field('longitude');
				//$longfloat = (float)$longnum;
				
				
				
				// loop data
				
				$post_data[] = array(
		    	'Title' => get_the_title(),
		    	'Post ID' => get_the_ID(),
					'Featured_lawyer' => true,
					'Featured_post_image' => $lawyer_profile_picture,
					'Permalink' => get_the_permalink(),
					'Latlong' => $result,
					'Lat' => $latlong,
					'Full_address' => get_field('lawyer_address'),
					'Street_address' => get_field('lawyer_street_address'),
					'City' => get_field('lawyer_city'),
					'State' => get_field('lawyer_state'),
					'Phone' => get_field('lawyer_phone'),
					'Zip_code' => get_field('lawyer_zip'),
					'Tel_href' => str_replace(['-', '(', ')', ' '], '', get_field('lawyer_phone')),
					//'"ACF"' => get_fields($post->ID)
				);
	    
			endwhile; 
		
			wp_reset_postdata();
		
		
		}
		
		$posts_not_in = array_merge($postid_array, $post_ids);
		
		
		
		$reg_args = array(
	  	'post_type' => 'lawyer',
			'posts_per_page' => 40,
			'paged' => $page,
    	'orderby' => 'title',
    	'post_status' => 'publish',
			'order' => 'ASC',
			'post__not_in' => $posts_not_in, // exclude featured posts so they aren't listed in both 
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
		
		
		
		$reg_query = new WP_Query($reg_args); 
		
		while($reg_query->have_posts()) : $reg_query->the_post();
		
		// long/lat string to integer conversion
				
		$latgnum = get_field('latitude');
		$latfloat = (float)$latgnum;
				
		//$longnum = get_field('longitude');
		//$longfloat = (float)$longnum;
		
			
			$latlong = get_the_ID();    
			$result = $wpdb->get_results( "SELECT lat_long FROM gmoney_geocode WHERE post_id='".$latlong."'");
		
			$post_data_two[] = array(
		    'Title' => get_the_title(),
		    'Post ID' => get_the_ID(),
		    'Permalink' => get_the_permalink(),
		    'Featured_lawyer' => false,
		    'Featured_post_image' => false,
		    'Latlong' => $result,
		    'Lat' => $latlong,
		    'Full_address' => get_field('lawyer_address'),
		    'Street_address' => get_field('lawyer_street_address'),
				'City' => get_field('lawyer_city'),
				'State' => get_field('lawyer_state'),
				'Phone' => get_field('lawyer_phone'),
				'Zip_code' => get_field('lawyer_zip'),
		    'Tel_href' => str_replace(['-', '(', ')', ' '], '', get_field('lawyer_phone')),
		    //'"ACF"' => get_fields($post->ID)
		  );
	    
	  endwhile; 
		
		wp_reset_postdata();
		
		$entire_list = array_merge($post_data,$post_data_two);
    
    return rest_ensure_response($entire_list);
		
   
	}
	
