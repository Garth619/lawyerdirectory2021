<?php get_header(); ?>

<div id="internal_main">
	
	<div class="internal_banner">
		
		
		<?php
			
			$currentpracticearea = get_query_var( 'office_pa');
			
			$taxlocations = 'location';
			
			$taxpracticeareas = 'practice_area';
			
			// pa url query -> pa id/title conversion
	
			$patermobject = get_term_by('slug', $currentpracticearea, $taxpracticeareas);
	
			$patermsid = $patermobject->term_taxonomy_id;
	
			$patermstitle = $patermobject->name;
			
			$patermslug = $patermobject->slug;
			
		?>
		
		<h1><?php echo $patermstitle . ' ' . 'Lawyers';?></h1>
		
		<!-- template-practice_area.php <br/> /lawyers-practice/business-lawyers -->

	</div><!-- internal_banner -->
	
	<div class="outer_container">
		
		<div class="directory_wrapper">
			
			<div class="breadcrumb_wrapper">
				
				<a href="<?php bloginfo('url');?>">Home</a>
	
				<a href="<?php the_field( 'practice_area_view_more_button', 124); ?>">Practice Areas</a>
	
				<a><?php echo $patermstitle;?></a>
				
			</div><!-- breadcrumb_wrapper -->
			 			 
			 <?php // $currentterm = get_queried_object()->term_id; 
	
				 if(get_field('pa_location_content_blocks','option')) : 
		 		 
					  while(has_sub_field('pa_location_content_blocks','option')) :
			 			 
				 			if(get_sub_field('current_taxonomy') == $patermsid && empty(get_sub_field('current_location_taxonomy_state')) && empty(get_sub_field('current_location_taxonomy_city')) ) : ?>
				 		
				 			<div class="directory_description content">
			 			 
				 				<?php the_sub_field('block');?>
				 			
				 			</div><!-- directory_description -->
			
				 			<h2 class="section_header">Browse by state</h2>
		 			 		
		 				<?php endif;
		 			 	
		 			endwhile;
			
		 		endif;	?>
		 		
		 		<div class="filter_by_search_wrapper">
				
					<input class="list_input desktop" type="text" placeholder="Filter<?php // single_term_title();?> States Below">
				
					<input class="list_input mobile" type="text" placeholder="Filter">
				
					<div class="filter_by_search_button"></div><!-- filter_by_search_button -->
				
				</div><!-- filter_by_search_wrapper -->
				
			 				
			<div class="list_wrapper">
				
			<?php
	
				$query_args = array (
					'post_type' => 'lawyer',
					'fields' => 'ids',
					'post_status' => 'publish',
					'no_found_rows' => true,
					'posts_per_page' => 2000, // -1 screws up some searches with too much memory
					'tax_query' => array(
						array(
								'taxonomy'  => $taxlocations,
								'operator' => 'IN',
								'field'     => 'ids',
								'include_children' => false,
								'terms'     => 139 
							),
						array(
								'taxonomy'  => $taxpracticeareas,
								'field'     => 'ids',
								'operator' => 'IN',
								'terms'     => $patermsid,
							)
						),
					);
				
				
				$myposts = new Wp_Query( $query_args );?>
				
<!-- 				//  ^ run the reg main_query here somehow? pluck ids from main_query so i can use pre_get_posts up to this point? -->
					
<!-- 				<pre><code><?php print_r($myposts->posts);?></code></pre> -->

				<?php $termargs = array (
					'taxonomy' => $taxlocations,
					'posts_per_page' => -1,
					'object_ids' => $myposts->posts,
					'parent' => 139 
				);
	
				$currenttermslug = get_queried_object()->slug; 

				$term_query = new WP_Term_Query( $termargs );

		
				if ( ! empty( $term_query ) && ! is_wp_error( $term_query ) ) {
			
					echo "<ul>";
			
						foreach ( $term_query->terms as $term )
			
							echo '<li><a href="' . get_bloginfo('url') . '/lawyers-practice/' . $term->slug . '/' . $patermslug . '-lawyers">' . $term->name . '</a></li>';
			
						}
			
					echo "</ul>"; ?>

				</div><!-- list_wrapper -->
			
		</div><!-- directory_wrapper -->
		
	</div><!-- outer_container -->
	
</div><!-- internal_main -->



<?php get_footer(); ?>
