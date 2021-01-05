<?php get_header(); ?>


<?php 	
	
	
	
	$currentcity = get_query_var( 'currentcity');
	$currentstate = get_query_var( 'currentstate');
	$currentpracticearea =  get_query_var( 'office_pa');
	$mypaged = get_query_var('mypaged');
	
	$taxlocations = 'location';
	$taxpracticeareas = 'practice_area';
	
	
	// pa url query -> pa id conversion
	
	$patermslug = get_term_by('slug', $currentpracticearea, $taxpracticeareas);
	
	$patermsid = $patermslug->term_taxonomy_id;
	
	$patermstitle = $patermslug->name;
	
	// state url query -> state id conversion
	
	$statetermslug = get_term_by('slug', $currentstate, $taxlocations);
	
	$statetermid = $statetermslug->term_taxonomy_id;
	
	$statetermtitle = $statetermslug->name;
	
	// city url query -> city id conversion
	
	$citytermslug = get_term_by('slug', $currentcity, $taxlocations);
	
	$citytermid = $citytermslug->term_taxonomy_id;
	
	$citytermtitle = $citytermslug->name;
	
	
?>


<div id="internal_main">
	
	<div class="internal_banner">
		
		<?php if($mypaged >= 2) {
			
			$lawyer_page_number = 'Page '. $mypaged;
			
		} ?>
		
		<h1><?php echo $citytermtitle . ' ' . $patermstitle . ' Lawyers' . ' ' . $lawyer_page_number;?></h1>
		
		<!-- template-locations_city_pa.php /lawyers-practice/california/los-angeles/business-lawyers -->

	</div><!-- internal_banner -->
	
	<div id="map_outer">
		<div id="map"></div><!-- map -->
	</div><!-- map_outer -->
	
	<div class="outer_container">
		
		<div class="directory_wrapper lawyer_wrapper">
			
			<div class="breadcrumb_wrapper">
			
				<a href="<?php bloginfo('url');?>">Home</a>
	
				<a href="<?php the_permalink(126);?>">Practice Areas</a> 
				
				<a href="<?php echo get_bloginfo('url') . '/lawyers-practice/' . $currentpracticearea . '-lawyers'; ?>"><?php echo  $patermstitle;?></a>
				
				<a href="<?php echo get_bloginfo('url') . '/lawyers-practice/' . $currentstate . '/' . $currentpracticearea . '-lawyers';?>"><?php echo $statetermtitle;?></a>
	
				<a><?php echo $citytermtitle;?></a>
			
			</div><!-- breadcrumb_wrapper -->
			
				<?php if(get_field('pa_location_content_blocks','option')) :?>
		 		 
					<?php while(has_sub_field('pa_location_content_blocks','option')) :
			 			 
			 			if(get_sub_field('current_taxonomy') == $patermsid && (get_sub_field('current_location_taxonomy_state') == $statetermid) && get_sub_field('current_location_taxonomy_city') == $citytermid ) : ?>
			 			
			 			
			 				<div class="directory_description content">
			 			 
			 					<?php the_sub_field('block');?>
			 				
			 				</div><!-- directory_description -->
			 			
			 				<h2 class="section_header">Browse by Lawyer</h2>
		 			 		
		 				<?php endif;
		 			 	
			 			endwhile;
			
		 		endif; ?>
		 		
		 		<span class="results_number no_filter_space">Total Lawyers (<?php echo $count;?>)</span>
		 		
		 		<div class="make_new_search_wrapper lawyer_search_styles">
						
					<span class="make_new_search">refine your search</span><!-- make_new_search -->
						
					<div class="new_search_wrapper">
							
						<?php get_template_part('searchform','threepart');?>
							
					</div><!-- new_search_wrapper -->
						
					</div><!-- make_new_search_wrapper -->
						
					<div class="top_pagination"></div><!-- top_pagination -->
						
					<div class="lawyer_results_wrapper">
		 		
		 		<?php 
			 		
			 		if($mypaged < 2) :
		 	
		
			 			if ( have_posts() ) :
				
			 				$featured_total_count = $wp_query->found_posts;
					
			 				$featured_array = array(); 
			 			 
			 			 while ( have_posts() ) : the_post(); ?>
						
						<div class="single_lawyer_result">
							
							<img class="featured_icon" src="<?php bloginfo('template_directory');?>/images/star_icon.svg"/>
							
							<a class="" href="<?php the_permalink();?>">
							
							<div class="single_lawyer_img_wrapper">
								
							<?php if (has_post_thumbnail( $post->ID ) ): ?>
						
								<?php 
							
									$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
						
								?>
							
								<img class="att_feed_image" src="<?php echo $image[0]; ?>" alt="<?php the_title();?> Profile Picture"/>
						
								<?php else:?>
						
								<div class="logo_placeholder">
									
									<img src="<?php bloginfo('template_directory');?>/images/lawfirm_icon.png"/>
									
								</div><!-- logo_placeholder -->

							<?php endif; ?>
								
							</div><!-- single_lawyer_img_wrapper -->
							
							<div class="single_lawyer_content">
								
								<span class="single_lawyer_title"><?php the_title();?></span><!-- single_lawyer_title -->
								
									<div class="single_lawyer_meta">
									
<!--
										<span>
										
										<?php echo $citytermtitle;
										
										 if(get_field('state_abbr') && get_field('state_abbr') !== 'NULL') {
										
											echo ", "; the_field('state_abbr');
										
										} ?>
										
										</span>
-->	
										<?php if(get_field('lawyer_street_address')) : ?>
										
											<span class="results_address"><?php the_field( 'lawyer_street_address' ); ?>, <?php the_field( 'lawyer_city' ); ?> <?php the_field( 'lawyer_state' ); ?> 
<?php the_field( 'lawyer_zip' ); ?></span><!-- results_address -->
										
										<?php else: ?>
										
											<span class="results_address"><?php the_field( 'lawyer_address' ); ?></span><!-- results_address -->
											
										<?php endif;?>
										
										
									
										<?php if(get_field('lawyer_phone') && get_field('lawyer_phone') !== 'NULL') { ?>
									
											<span><?php the_field( 'lawyer_phone' ); ?></span>
									
										<?php }?>
										
									</div><!-- single_lawyer_meta -->
									
									<div class="visit_button_wrapper">
									
										<span class="visit_button">Visit Profile</span><!-- visit_button -->
									
									</div><!-- visit_button_wrapper -->
								
								</div><!-- single_lawyer_content -->
							
							</a>
							
						</div><!-- single_lawyer_result -->
	
						<?php $featured_id[] = get_the_ID();
		
						endwhile;
						
						endif;
						
					endif; ?>
					
					
					<?php $featured_lawyers= array_merge($featured_array,$featured_id);
							
						// second loop excluding featured posts
							
							$reg_lawyer_list = array(
								'post_type' => 'lawyer',
								'fields' => 'ids',
								'order' => 'ASC',
								'orderby' => 'title',
								'post_status' => 'publish',
								'posts_per_page' => 40,
								'paged' => $mypaged,
								'post__not_in' => $featured_lawyers,
								'tax_query' => array(
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
									)
								),
							);
							
							$temp = $wp_query; 
							$wp_query = null; 
							$wp_query = new WP_Query(); 
							$wp_query->query($reg_lawyer_list); 
							
							
							if($wp_query->have_posts()) {
								
								$count = $wp_query->found_posts;
								
							}
							

							while ($wp_query->have_posts()) : $wp_query->the_post(); 
						?>

							<div class="single_lawyer_result">
							
								<a class="" href="<?php the_permalink();?>">
							
									<div class="single_lawyer_img_wrapper">
								
								
										<?php if (has_post_thumbnail( $post->ID ) ): ?>
						
										<?php 
							
											$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
						
										?>
							
										<img class="att_feed_image" src="<?php echo $image[0]; ?>" alt="<?php the_title();?> Profile Picture"/>
						
										<?php else:?>
						
											<div class="logo_placeholder">
												
												<img src="<?php bloginfo('template_directory');?>/images/lawfirm_icon.png"/>
									
											</div><!-- logo_placeholder -->
					
										 <?php endif; ?>
								
									</div><!-- single_lawyer_img_wrapper -->
							
									<div class="single_lawyer_content">
								
										<span class="single_lawyer_title"><?php the_title();?></span><!-- single_lawyer_title -->
								
											<div class="single_lawyer_meta">
									
<!--
										<span>
										
										<?php echo $citytermtitle;
										
										 if(get_field('state_abbr') && get_field('state_abbr') !== 'NULL') {
										
											echo ", "; the_field('state_abbr');
										
										} ?>
										
										</span>
-->
										
										<?php if(get_field('lawyer_street_address')) : ?>
										
											<span class="results_address"><?php the_field( 'lawyer_street_address' ); ?>, <?php the_field( 'lawyer_city' ); ?> <?php the_field( 'lawyer_state' ); ?> 
<?php the_field( 'lawyer_zip' ); ?></span><!-- results_address -->
										
										<?php else: ?>
										
											<span class="results_address"><?php the_field( 'lawyer_address' ); ?></span><!-- results_address -->
											
										<?php endif;?>
									
										<?php if(get_field('lawyer_phone') && get_field('lawyer_phone') !== 'NULL') { ?>
									
											<span><?php the_field( 'lawyer_phone' ); ?></span>
									
										<?php }?>
										
									</div><!-- single_lawyer_meta -->
									
									<div class="visit_button_wrapper">
									
										<span class="visit_button">Visit Profile</span><!-- visit_button -->
									
									</div><!-- visit_button_wrapper -->
								
								</div><!-- single_lawyer_content -->
							
							</a>
							
						</div><!-- single_lawyer_result -->


						<?php endwhile; ?>

						</div><!-- lawyer_results_wrapper -->
  
					<div class="pagination bottom_pagination">

						<?php wpbeginner_numeric_posts_nav(); ?>

					</div><!-- pagination -->

				
				<?php 
				
					$wp_query = null; 
					$wp_query = $temp;  // Reset
				
				?>

			</div><!-- list_wrapper -->
			
			<?php // copying this and adding to the top of the page (i need it outside of the loop)
				
				$total_count = $featured_total_count + $count;
				
				$withcommas = number_format($total_count);
				
				echo '<span class="overall_count">' . $withcommas . "</span>";
			
			?>
			
		</div><!-- directory_wrapper -->
		
	</div><!-- outer_container -->
	
</div><!-- internal_main -->
		

<?php get_footer(); ?>
