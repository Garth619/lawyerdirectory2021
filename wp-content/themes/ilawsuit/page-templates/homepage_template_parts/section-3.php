<section id="section_three">
	
	<div class="sec_three_inner">
		
		<h2 class="section_header"><?php the_field( 'section_three_title' ); ?></h2>
		
		<div class="sec_three_tabs">
			
			<div class="sec_three_tab sec_three_area_tab active" data-tab="sec-three-area-of-service">Area of Law</div><!-- sec_three_tab -->
			
			<div class="sec_three_tab sec_three_state_tab" data-tab="sec-three-state">State</div><!-- sec_three_tab -->
				
			<div class="sec_three_tab sec_three_city_tab" data-tab="sec-three-city">City</div><!-- sec_three_tab -->
			
		</div><!-- sec_three_tabs -->
		
		<div class="sec_three_list_wrapper">
			
			<div class="area_of_law_list sec_three_list sec-three-area-of-service list_wrapper" style="display:block;">
				
				
				<?php $top_practice_areas_terms = get_field( 'top_practice_areas' );
	
					if ( $top_practice_areas_terms ) {
				
					echo "<ul>";
		
					foreach ( $top_practice_areas_terms as $top_practice_areas_term ) { ?>
					
						<?php echo '<li><a href="' . get_bloginfo('url') . '/lawyers-practice/' . $top_practice_areas_term->slug . '-lawyers">' . $top_practice_areas_term->name . '</a></li>';?>
			
									
				<?php } 
					
					echo "</ul>"; 
				
				} ?>
				
				<a class="view_all_button" href="<?php the_field( 'practice_area_view_more_button' ); ?>">View All</a><!-- view_all_button -->

			</div><!-- sec_three_list -->
			
			<div class="state_list sec_three_list sec-three-state list_wrapper">
				
				<?php 
		
					$state_terms = get_terms( array( // change new WP_Term_Query later, its newer and faster i think
						'taxonomy' => 'location',
						'parent'  => 139 // add a slug to id conversion here
	
					) );
		
					if ( ! empty( $state_terms ) && ! is_wp_error( $state_terms ) ) {
					
						echo '<ul>';
						
						foreach ( $state_terms as $state_term ) {
	     
							$stateterm_link = get_term_link( $state_term );
	     
							echo '<li><a href="' . get_bloginfo('url') . '/lawyers-location/state/' . $state_term->slug . '-lawyers">' . $state_term->name . '</a></li>';
        
     				}
		 				
		 				echo '</ul>';
 				 }
 
 
 				 if(is_user_logged_in()) {
	
 				 	echo '<a href="' . get_bloginfo('url') .  '/wp-admin/edit-tags.php?taxonomy=location&post_type=office">Edit</a><br/><br/><br/>';
			 		
				}
 
			?>
			
			</div><!-- sec_three_list -->
			
			<div class="city_list sec_three_list sec-three-city list_wrapper">
				
				<?php 
			
					if(get_field('top_cities')):
			
						echo "<ul>";
		 
						while(has_sub_field('top_cities')):
		 
							$select_city_ids = get_sub_field( 'select_top_city' );
				
							$select_state = $select_city_ids->parent;
				
							$parentid = get_term_by('id', $select_state, 'location');
				
							$currentparentid = $parentid->slug;
				
							echo '<li><a href="' . get_bloginfo('url') . '/lawyers-location/state/' . $currentparentid . '/' . $select_city_ids->slug .  '-lawyers">' . $select_city_ids->name . '</a></li>';

						endwhile;
			
						echo "</ul>";
		 
				 endif; ?>

			</div><!-- sec_three_list -->
			
		</div><!-- sec_three_list_wrapper -->
		
		
		
	</div><!-- sec_three_inner -->
	
</section><!-- section_three -->