

<div id="internal_main">
	
	<?php if(is_user_logged_in() && get_current_user_id() == $post->post_author) { ?>
			
				<div class="upgrade_prompt_wrapper">
					
					<?php if(get_field('lawyer_premium_layout_two') !== 'Claim Free Profile') { ?>
				
						<span class="prompt upgrade_prompt">want a premium profile? Upgrade now</span><!-- upgrade_prompt -->
					
					<?php } else {?>
						
						<span class="prompt upgrade_prompt">want to upgrade your profile? Get Started now</span><!-- upgrade_prompt -->
						
					<?php } ?>
				
				</div><!-- upgrade_prompt_wrapper -->
			
			<?php } ?>

	
	<div class="internal_banner">
		
		<?php 
			
			// some info i need to make the form redirects work properly
			
			$hiddenpost_id = get_the_ID();?>
			
			<div class="internal_banner_content">
				
					
			<h1 data-homeurl="<?php bloginfo('url');?>" id="<?php echo $hiddenpost_id;?>" data-gravityupdate="gform_wrapper_7" class="myedit edit_content gravity_edit" data><?php the_title();?></h1>
		
			<div class="internal_banner_meta">
			
			<?php $terms = get_the_terms( get_the_ID(), 'practice_area' ); ?>
			

			
			<?php $term = reset($terms);
				
				$termslug = $term->slug;
				
			?>
			
			<span data-gravityupdate="gform_wrapper_10" class="myedit edit_content edit_banner_meta gravity_edit"><?php echo $term->name; ?></span>
			
			<?php if(get_field('lawyer_city') && get_field('lawyer_city') !== 'NULL') { ?>
			
				<span data-gravityupdate="gform_wrapper_9" class="myedit edit_content edit_banner_meta gravity_edit"><?php the_field( 'lawyer_city' ); ?></span>
			
			<?php }?>
			
			<?php if(get_field('lawyer_state') && get_field('lawyer_state') !== 'NULL') { ?>
			
				<span data-gravityupdate="gform_wrapper_9" class="myedit edit_content edit_banner_meta gravity_edit"><?php the_field( 'lawyer_state' ); ?></span>
			
			<?php }?>


		</div><!-- internal_banner_meta -->
		
		</div><!-- internal_banner_content -->

	</div><!-- internal_banner -->
	
		<section class="att_bio_wrapper">
			
			<div class="att_bio_sidebar">
				
				<div class="att_bio_sidebar_inner">
				
				<div data-gravityupdate="gform_wrapper_8" class="att_bio_profile myedit edit_sidebar gravity_edit">
					
					<?php if (has_post_thumbnail( $post->ID ) ): ?>
						
						<?php 
							
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
						
						?>
							
						<img class="att_img" src="<?php echo $image[0]; ?>" alt="<?php the_title();?> Profile Picture"/>
						
						<?php else:?>
						
						<div class="att_bio_placeholder">
							
							<img class="placeholder" src="<?php bloginfo('template_directory');?>/images/lawfirm_icon.png"/>
						
						</div><!-- att_bio_placeholder -->

					<?php endif; ?>
					
				</div><!-- att_bio_profile -->
				
				<?php if(get_field('lawyer_street_address')) : ?>
				
						<div data-gravityupdate="gform_wrapper_9" class="att_bio_row_wrapper myedit edit_sidebar gravity_edit">
					
							<span class="att_bio_sidebar_title">Address</span><!-- att_bio_sidebar_title -->
						
							<span class="att_bio_address"><span class="street_address"><?php the_field( 'lawyer_street_address' ); ?></span>, <?php the_field( 'lawyer_city' ); ?>, <?php the_field( 'lawyer_state' ); ?> 
<?php the_field( 'lawyer_zip' ); ?></span><!-- att_bio_address -->
						
						
							
							<?php $claim_address = get_field('lawyer_street_address') . ' ' . get_field('lawyer_city') . ' ' . get_field('lawyer_state') . ' ' . get_field('lawyer_zip');
	
								$claim_addressCleaned = str_replace(' ', '%20', $claim_address); // this works but doesnt echo in ahref below?
					
							?>
					
							<a class="get_directions" href="https://www.google.com/maps/search/?api=1&query=<?php echo $claim_addressCleaned;?>" target="_blank" rel="noopener">Directions</a><!-- get_directions -->

						</div><!-- att_bio_row_wrapper -->
						
						<?php else : ?>
				
					<?php if(get_field('lawyer_address') && get_field('lawyer_address') !== 'NULL') { ?>
				
						<div data-gravityupdate="gform_wrapper_9" class="att_bio_row_wrapper myedit edit_sidebar gravity_edit">
					
							<span class="att_bio_sidebar_title">Address</span><!-- att_bio_sidebar_title -->
						
							<span class="att_bio_address"><?php the_field( 'lawyer_address' ); ?></span><!-- att_bio_address -->
						
							<?php $address = get_field('lawyer_address');
	
								$addressCleaned = str_replace(' ', '%20', $address); // this works but doesnt echo in ahref below?
					
							?>
					
							<a class="get_directions" href="https://www.google.com/maps/search/?api=1&query=<?php echo $addressCleaned;?>" target="_blank" rel="noopener">Directions</a><!-- get_directions -->

						</div><!-- att_bio_row_wrapper -->
				
					<?php } ?>
				
				
				<?php endif;?>
				
				
				<?php if(get_field('lawyer_phone') && get_field('lawyer_phone') !== 'NULL') { ?>
				
					<div data-acfupdate="lawyer_phone" class="att_bio_row_wrapper myedit edit_sidebar acf_edit">
					
						<span class="att_bio_sidebar_title">Phone</span><!-- att_bio_sidebar_title -->
					
						<a class="att_bio_row_title att_bio_phone" href="tel:<?php echo str_replace(['-', '(', ')', ' '], '', get_field('lawyer_phone')); ?>"><?php the_field( 'lawyer_phone' ); ?></a><!-- att_bio_row_title -->
					
					</div><!-- att_bio_row_wrapper -->
				
				<?php } ?>
				
				<?php if(get_field('lawyer_email') && get_field('lawyer_email') !== 'NULL') { ?>
				
					<div data-acfupdate="lawyer_email" class="att_bio_row_wrapper myedit edit_sidebar acf_edit">
					
						<span class="att_bio_sidebar_title">Email</span><!-- att_bio_sidebar_title -->
					
						<a class="att_bio_row_title att_bio_email" href="mailto:<?php the_field('lawyer_email'); ?>"><?php the_field( 'lawyer_email' ); ?></a><!-- att_bio_row_title -->
					
					</div><!-- att_bio_row_wrapper -->
				
				<?php } ?>
				
				<?php if(get_field('lawfirm_name') && get_field('lawfirm_name') !== 'NULL') { ?>
				
					<div data-acfupdate="lawfirm_name" class="att_bio_row_wrapper myedit edit_sidebar acf_edit">
					
						<span class="att_bio_sidebar_title">Lawfirm Name</span><!-- att_bio_sidebar_title -->
					
						<span class="att_bio_row_title lawfirm_name"><?php the_field( 'lawfirm_name' ); ?></span><!-- att_bio_row_title -->
					
					</div><!-- att_bio_row_wrapper -->
				
				<?php } ?>
				
				<?php if(get_field('years_licensed_for') && get_field('years_licensed_for') !== 'NULL') { ?>
				
					<div data-acfupdate="years_licensed_for" class="att_bio_row_wrapper myedit edit_sidebar acf_edit">
					
						<span class="att_bio_sidebar_title">Years Licensed For</span><!-- att_bio_sidebar_title -->
					
						<span class="att_bio_row_title years_licensed_for"><?php the_field( 'years_licensed_for' ); ?></span><!-- att_bio_row_title -->
					
					</div><!-- att_bio_row_wrapper -->
				
				<?php } ?>
				
				<?php if(get_field('lawyer_website') && get_field('lawyer_website') !== 'NULL') { ?>
				
					<div data-acfupdate="lawyer_website" class="visit_website_button_wrapper myedit acf_edit">
						
						<a class="visit_website_button" href="<?php the_field( 'lawyer_website' ); ?>" target="_blank" rel="noopener">Visit Website</a><!-- visit_website -->
						
					</div><!-- visit_website_button_wrapper -->
				
				<?php } ?>
				
				</div><!-- att_bio_sidebar_inner -->
				
			</div><!-- att_bio_sidebar -->
			
			<div class="att_bio_content content">
				
				<?php if ( $terms && ! is_wp_error( $terms ) ) {?>
								
						<div data-gravityupdate="gform_wrapper_10" class="att_bio_practice_areas myedit edit_content gravity_edit">
					
							<h2>Practice Areas</h2>
					
							<div class="att_bio_pa_list">
								
								<ul>
 
								<?php foreach ( $terms as $term ) { ?>
									
									<li><a href="<?php bloginfo('url');?>/lawyers-practice/<?php echo $term->slug;?>-lawyers"><?php echo $term->name;?></a></li>
									
									<?php } ?>
    
    						</ul>
    						
    					</div><!-- att_bio_pa_list -->
					
						</div><!-- att_bio_practice_areas -->
						
					<?php } ?>
					
					<?php if(get_field('lawyer_bio')) { ?>
					
						<div data-acfupdate="lawyer_bio" class="lawyer_bio myedit edit_content acf_edit">
					
							<?php the_field( 'lawyer_bio' ); ?>
				
						</div><!-- lawyer_bio -->
					
					<?php } ?>
				
					<?php if(get_field('school_one_name') && get_field('school_one_name') !== 'NULL') { ?>
					
						<div class="att_standard_education">
						
							<div class="att_bio_content_row">
					
								<span class="att_bio_content_title">Education</span><!-- att_bio_sidebar_title -->
					
								<ul>
									
									<?php if(get_field('school_one_name') && get_field('school_one_name') !== 'NULL') { ?>
								
									<li>
									
										<strong>
										
											<span data-acfupdate="school_one_name" class="school_one_name myedit acf_edit edit_inline"><?php the_field( 'school_one_name' );?></span><!-- school_one_name -->
											
										</strong>
										
										<?php if(get_field('school_one_major') && get_field('school_one_major') !== 'NULL' && get_field('school_one_major') !== 'N/A' ) { ?>
									
											<span data-acfupdate="school_one_major" class="school_one_major myedit acf_edit edit_inline"><?php the_field( 'school_one_major' ); ?></span><!-- school_one_major -->
										
										<?php } ?>
										
										<?php if(get_field('school_one_degree') && get_field('school_one_degree') !== 'NULL' && get_field('school_one_degree') !== 'N/A' ) { ?>
									
											<span data-acfupdate="school_one_degree" class="school_one_degree myedit acf_edit edit_inline"><?php the_field( 'school_one_degree' ); ?></span><!-- school_one_major -->
										<?php } ?>
										
										<?php if(get_field('school_one_year_graduated') && get_field('school_one_year_graduated') !== 'NULL' && get_field('school_one_year_graduated') !== 'N/A') { ?>
									
											<span data-acfupdate="school_one_year_graduated" class="school_one_year_graduated myedit acf_edit edit_inline"><?php the_field( 'school_one_year_graduated' );?></span><!-- school_one_year_graduated -->
										
										<?php } ?>
										
									</li>
								
									<?php } ?>
										
									<?php if(get_field('school_two_name') && get_field('school_two_name') !== 'NULL') { ?>
										
										<li>
									
										<strong>
									
											<span data-acfupdate="school_two_name" class="school_two_name myedit acf_edit edit_inline"><?php the_field( 'school_two_name' );?></span><!-- school_two_name -->
											
										</strong>
										
										<?php if(get_field('school_two_major') && get_field('school_two_major') !== 'NULL' && get_field('school_two_major') !== 'N/A') { ?>
									
											<span data-acfupdate="school_two_major" class="school_two_major myedit acf_edit edit_inline"><?php the_field( 'school_two_major' );?></span><!-- school_two_major -->
										
										<?php } ?> 
										
										<?php if(get_field('school_two_degree') && get_field('school_two_degree') !== 'NULL' && get_field('school_two_degree') !== 'N/A' ) { ?>
									
											<span data-acfupdate="school_two_degree" class="school_two_degree myedit acf_edit edit_inline"><?php the_field( 'school_two_degree' ); ?></span><!-- school_one_major -->
										<?php } ?>
										
										<?php if(get_field('school_two_year_graduated') && get_field('school_two_year_graduated') !== 'NULL' && get_field('school_two_year_graduated') !== 'N/A') { ?>
									
											<span data-acfupdate="school_two_year_graduated" class="school_two_year_graduated myedit acf_edit edit_inline"><?php the_field( 'school_two_year_graduated' );?></span><!-- school_two_year_graduated -->
										
										<?php } ?>
								
									</li>
									
									<?php } ?>
								
								</ul>
												
							</div><!-- att_bio_sidebar_row -->
							
						</div><!-- att_standard_education -->
						
						<?php } ?>
						
					
						
					<?php if(!get_field('hide_claim_button')) { ?>
					
						<?php if(!is_user_logged_in()) { ?>
					
						<a class="claim_button">Claim this Listing</a><!-- claim_button -->
					
					<?php } ?>
					
					<?php } ?>
					
					
				
				</div><!-- att_bio_content -->
			
		</section><!-- att_bio_wrapper -->
		
		<section class="related_att">
			
			<div class="related_att_inner">
				
				<?php 
					
					$term = reset($terms);
				
				?>
			
				<span class="related_att_title"><?php echo $term->name; ?> Attorneys in 
				
				<?php if(get_field('lawyer_city') && get_field('lawyer_city') !== 'NULL') {
			
					the_field( 'lawyer_city' );
			
				} ?>
				
				</span><!-- related_att_title -->
				
				<div class="related_att_grid">
					
					
				<?php 
					
					// gets the deepest location term which in this case is a single term of city name
					
					$locationterms = wp_get_post_terms( get_queried_object_id(), 'location', array( 'orderby' => 'id', 'order' => 'DESC' ) );

					$deepestTerm = false;
					$maxDepth = -1;

					foreach ($locationterms as $locationterm) {
						$ancestors = get_ancestors( $locationterm->term_id, 'location' );
						$locationtermDepth = count($ancestors);

						if ($locationtermDepth > $maxDepth) {
							$deepestTerm = $locationterm;
							$maxDepth = $locationtermDepth;
    				}
					}
					
					$currentcityterm = $deepestTerm->slug;
					
					// exclude current post
					
					$exclude_post = $post->ID;
					
					// query args for wp query below
					
					$query_args = array (
						'post_type' => 'lawyer',
						'orderby' => 'rand',
						'post_staus' => 'publish',
						'posts_per_page' => 8,
						'post__not_in' => array($exclude_post),
						'tax_query' => array(
							array(
								'taxonomy' => 'location',
								'field' => 'slug',
								'terms' => $currentcityterm
							),
							array(
								'taxonomy'  => 'practice_area',
								'field'     => 'slug',
								'terms'     =>	$termslug,
							)
						),
					); 
				
				 
				 $mymain_query = new WP_Query($query_args); if($mymain_query->have_posts()): while($mymain_query->have_posts()) : $mymain_query->the_post(); ?>
                	
          
          	<div class="related_single_att">
						
						<?php $lawyer_profile_image = get_field( 'lawyer_profile_image' ); ?>
					
						<?php if ( $lawyer_profile_image ) : ?>
					
							<img class="att_img" src="<?php echo $lawyer_profile_image['url']; ?>" alt="<?php echo $lawyer_profile_image['alt']; ?>" />
						
						<?php else:?>
						
							<div class="att_bio_placeholder">
						
								<img class="placeholder" src="<?php bloginfo('template_directory');?>/images/lawfirm_icon.png"/>
						
							</div><!-- att_bio_placeholder -->
					
					<?php endif; ?>
						
						<span class="related_single_att_title"><?php the_title();?></span><!-- related_single_att_title -->
						
						<?php if(get_field('lawyer_street_address')) : ?>
										
											<span class="related_single_att_subtitle address"><?php the_field( 'lawyer_street_address' ); ?>, <?php the_field( 'lawyer_city' ); ?><br/> <?php the_field( 'lawyer_state' ); ?> <?php the_field( 'lawyer_zip' ); ?></span>
										
										<?php else: ?>
										
											<span class="related_single_att_subtitle address"><?php the_field( 'lawyer_address' ); ?></span>
											
										<?php endif;?>
									
										<?php if(get_field('lawyer_phone') && get_field('lawyer_phone') !== 'NULL') { ?>
									
											<span class="related_single_att_subtitle"><?php the_field( 'lawyer_phone' ); ?></span>
									
										<?php }?>
						
<!--
						<?php 
				
							if(get_field('lawyer_featured_practice_area')) { ?>
					
								<span class="related_single_att_subtitle"><?php the_field('lawyer_featured_practice_area');?></span>								
					
							<?php }
					
							else {
				
								$terms = get_the_terms( get_the_ID(), 'practice_area' );
				
								$term = reset($terms);
				
						?>
			
						<span class="related_single_att_subtitle"><?php echo $term->name; ?></span>
			
					<?php } ?>
-->
					
						<div class="related_view_profile_wrapper">
						
							<a class="related_view_profile" href="<?php the_permalink();?>">View Profile</a><!-- related_view_profile -->
						
						</div><!-- related_view_profile_wrapper -->
						
					</div><!-- related_single_att -->
          
          
          <?php endwhile; ?>
          
          <?php else:?>
          
          	<span class="no_attorneys_message">There are currently no related attorneys in this area.</span><!-- no_attorneys_message -->
          
          <?php endif;?>
					
					<?php wp_reset_postdata(); // reset the query ?>
					
					
					
				</div><!-- related_att_grid -->
				
			</div><!-- related_att_inner -->
			
		</section><!-- related_att -->
				
</div><!-- internal_main -->



<div class="overlay claim_overlay content">
						
	<div class="overlay_inner">
							
		<div class="overlay_close"></div><!-- overlay_close -->
							
			<?php get_template_part('page-templates/template','multistepforms');?>
							
		</div><!-- overlay_inner -->
						
</div><!-- overlay -->


