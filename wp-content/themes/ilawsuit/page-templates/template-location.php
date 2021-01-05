<?php get_header(); ?>


<div id="internal_main">
	
	<div class="internal_banner">
		
		<?php	// state url query -> state id conversion
		
			$currentstate = get_query_var( 'office_location_currentstate');
	
			$taxlocations = 'location';
			$taxpracticeareas = 'practice_area';	
		
			$stateterms = get_term_by('slug', $currentstate, $taxlocations);
			$statetermid = $stateterms->term_taxonomy_id;
			$statetermtitle = $stateterms->name;
			$statetermslug = $stateterms->slug;
	
		?>
		
		<h1><?php echo $statetermtitle;?> Lawyers</h1>
		
		<!-- template-location.php. /lawyers-location/state/alaska-lawyers/ -->

	</div><!-- internal_banner -->
	
	<div class="outer_container">
		
		<div class="directory_wrapper">
			
			<div class="breadcrumb_wrapper">
				
				<a href="<?php bloginfo('url');?>">Home</a> 
	
				<a href="<?php the_permalink(133);?>">Locations</a>
	
				<a><?php echo $statetermtitle;?></a>
				
			</div><!-- breadcrumb_wrapper -->
			
			<?php 
				
				if(get_field('content_blocks','option')) : 
					
					while(has_sub_field('content_blocks','option')) :
								
						if(get_sub_field('current_taxonomy') == $statetermid) :?>
								
									<div class="directory_description content">
			 			 
									<?php the_sub_field('block');?>
										
										</div><!-- directory_description -->
			
										
			 		
			 				<?php endif;
		 			 		
				 		endwhile;
				 					
				 endif;	
				 
			if(get_field('featured_cities_blocks_location_page','option')):
			  
			 	while(has_sub_field('featured_cities_blocks_location_page','option')):
			  
			 		if((get_sub_field( 'location_featured_city' ) == $statetermid) ) :
			 		
			 			if(get_sub_field('featured_city_internal')): ?>
			 			
			 			<h2 class="section_header featured_city">Featured Cities</h2><!-- featured_title -->
			 				
			 				<div class="list_wrapper featured_cities">
				 				
				 				<h3 class="featured_city_header">Most Popular Cities to Find <?php echo $statetermtitle;?> Lawyers</h3>
				 			
				 				<ul>
			 			 
				 				<?php while(has_sub_field('featured_city_internal')): 
			 			 
			 						$featured_city_term = get_sub_field( 'featured_city' );
			 					
			 						if ( $featured_city_term ): 
			 					
			 						echo '<li><a href="' . get_bloginfo('url') . '/lawyers-location/state/' . $currentstate . '/' . $featured_city_term->slug . '-lawyers">' . $featured_city_term->name . '</a></li>';
			 					
			 						endif;
			 			    
			 					endwhile; ?>
			 				
				 				</ul>
				 			
			 				</div><!-- list_wrapper -->
			 				
			 			<?php endif;
			 		
				 			endif;
			     
				 		endwhile;
			  
				 	endif; ?>

				 
			<h2 class="section_header browse_city">Browse by city</h2>
			
			<div class="filter_by_search_wrapper">
				
				<input class="list_input desktop" type="text" placeholder="Filter<?php // single_term_title();?> Cities Below">
				
				<input class="list_input mobile" type="text" placeholder="Filter">
				
				<div class="filter_by_search_button"></div><!-- filter_by_search_button -->
				
			</div><!-- filter_by_search_wrapper -->
			
			<div class="list_wrapper browse_filter">
				
			<?php 
					
				$termargs = array (
					'taxonomy' => $taxlocations,
					'parent' => $statetermid 
				);
				
				
				$terms = new WP_Term_Query( $termargs );
	
		
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
     
					echo '<ul>';
     
						foreach ( $terms->terms as $term ) {
	     
							echo '<li><a href="'. get_bloginfo('url') . '/lawyers-location/state/'. $statetermslug . '/' . $term->slug . '-lawyers">' . $term->name . '</a></li>';
        
     				}
     
		 			echo '</ul>';
     
     }
     
     	
    
    ?>

			</div><!-- list_wrapper -->
			
		</div><!-- directory_wrapper -->
		
	</div><!-- outer_container -->
	
</div><!-- internal_main -->
		

<?php get_footer(); ?>
