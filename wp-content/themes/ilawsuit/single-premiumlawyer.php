<div id="internal_main">
	
	<?php if(is_user_logged_in() && get_current_user_id() == $post->post_author) { ?>
	
		<?php if(get_field('disable_selling_point_section') || get_field('disable_case_results_section') || get_field('disable_faq_section')) { ?>
			
			<div class="upgrade_prompt_wrapper">
		
			<span class="prompt enable_header">The following sections are disabled:</span><!-- upgrade_prompt -->
		
			<?php if(get_field('disable_selling_point_section')) { ?>	
		
				<span data-acfupdate="selling_points_section" class="prompt enable_subheader">Selling Points: <span class="enable">Enable</span></span><!-- upgrade_prompt -->
				
			<?php } ?>
			
			<?php if(get_field('disable_case_results_section')) { ?>	
		
				<span data-acfupdate="case_result_section" class="prompt enable_subheader">Case Results: <span class="enable">Enable</span></span><!-- upgrade_prompt -->
			
			<?php } ?>
			
			<?php if(get_field('disable_faq_section')) { ?>	
			
				<span data-acfupdate="lawyer_faq_col" class="prompt enable_subheader">FAQs: <span class="enable">Enable</span></span><!-- upgrade_prompt -->
			
			<?php } ?>
				
		</div><!-- upgrade_prompt_wrapper -->
	
	<?php } ?>
	
	<?php } ?>	
	
	<div class="internal_banner">
		
		<?php 
			
			// some info i need to make the form redirects work properly
			
			$hiddenpost_id = get_the_ID();?>
			
			<div class="internal_banner_content">
		
			<h1 data-homeurl="<?php bloginfo('url');?>" id="<?php echo $hiddenpost_id;?>" data-gravityupdate="gform_wrapper_7" class="myedit edit_content gravity_edit" data><?php the_title();?></h1>
		
		<div class="internal_banner_meta">
			
			<?php 
				
				$terms = get_the_terms( get_the_ID(), 'practice_area' );
				
				if(get_field('lawyer_featured_practice_area')) { ?>
					
					<span><?php the_field('lawyer_featured_practice_area');?></span>
					
				<?php }
					
					else {
				
					
				
					$term = reset($terms);
				
				?>
			
					<span data-gravityupdate="gform_wrapper_10" class="myedit edit_content edit_banner_meta gravity_edit"><?php echo $term->name; ?></span>
			
			<?php } ?>
			
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
				
						<div class="att_bio_row_wrapper">
					
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
					
						<span class="att_bio_sidebar_title att_bio_phone">Phone</span><!-- att_bio_sidebar_title -->
					
						<a class="att_bio_row_title" href="tel:<?php echo str_replace(['-', '(', ')', ' '], '', get_field('lawyer_phone')); ?>"><?php the_field( 'lawyer_phone' ); ?></a><!-- att_bio_row_title -->
					
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
				
					<div class="att_bio_experience">
				
						<?php the_field( 'lawyer_bio' ); ?>
				
					</div><!-- att_bio_experience -->
				
				<?php } ?>
				

						
				</div><!-- att_bio_content -->
			
		</section><!-- att_bio_wrapper -->
		
		<?php if(!get_field('disable_selling_point_section')) { ?>
		
		<?php if(get_field('selling_points_title') || get_field('selling_points_description')) { ?>
		
		<section class="att_bio_selling_point">
			
			<div data-acfupdate="selling_points_section" class="att_bio_selling_point_inner myedit edit_content acf_edit">
				
				<span class="selling_points_subheader"><?php the_field( 'selling_points_title' ); ?></span><!-- subheader -->
				
				<span class="selling_points_description"><?php the_field( 'selling_points_description' ); ?></span><!-- selling_points_description -->
				
				
			</div><!-- att_bio_selling_point_inner -->
			
			<?php 
				
				if(get_field('selling_point_banner_image_custom')) { 
			
					$selling_point_banner_image_custom = get_field( 'selling_point_banner_image_custom' ); ?>
				
					<img data-src="<?php echo $selling_point_banner_image_custom['url']; ?>" alt="<?php echo $selling_point_banner_image_custom['alt']; ?>" />
			
					<?php 
					
				} 
						
				else {
			
					if(get_field('selling_point_banner_options') == 'Building') { ?>
			
						<img data-src="<?php bloginfo('template_directory');?>/images/profile-quote-img-2.jpg" alt="<?php the_title();?> Selling Point" />
			
					<?php	}
			
					if(get_field('selling_point_banner_options') == 'Inside Office') { ?>
			
						<img data-src="<?php bloginfo('template_directory');?>/images/profile-quote-img.jpg" alt="<?php the_title();?> Selling Point" />
			
						<?php } 
				
				} ?>

			
		</section><!-- att_bio_selling_point -->
		
		<?php } ?>
		
		<?php } ?>
		
		<section class="att_bio_middle_content_wrapper">
			
			<div class="att_bio_middle_content_inner content">
			
				<div class="att_bio_middle_content">
				
					<?php the_field( 'lawyer_bottom_content' ); ?>
				
				</div><!-- att_bio_middle_content -->
			
				<div class="att_bio_middle_sidebar">
				
					<div class="att_bio_middle_sidebar_inner">
						
						<?php if(get_field('lawyer_bar_admission')) { ?>
					
							<div class="att_bio_content_row">
				
								<span class="att_bio_content_title">Bar Admission</span><!-- att_bio_sidebar_title -->
					
								<ul>
									
									 <?php while(has_sub_field('lawyer_bar_admission')): ?>
									 
											<li data-acfupdate="lawyer_bar_admission" class="myedit acf_edit edit_inline"><?php the_sub_field('bar_admission_bullet');?></li>
									    
										<?php endwhile; ?>
									 
								</ul>
					
						</div><!-- att_bio_sidebar_row -->
						
						<?php } ?>
						
						<?php if(get_field('school_one_name') && get_field('school_one_name') !== 'NULL') { ?>
						
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
									
											<span data-acfupdate="school_two_year_graduated"><?php the_field( 'school_two_year_graduated' );?></span><!-- school_two_year_graduated -->
										
										<?php } ?>
								
									</li>
									
									<?php } ?>
								
								</ul>
												
							</div><!-- att_bio_contents_row -->
						
						<?php } ?>
				
					</div><!-- att_bio_middle_sidebar_inner -->
				
				</div><!-- att_bio_middle_sidebar -->
			
			</div><!-- att_bio_middle_content_inner -->
			
		</section><!-- att_bio_middle_content_wrapper -->
		
		<?php if(!get_field('disable_case_results_section')) { ?>	
		
		<?php if(get_field('lawyer_case_result_slides')): ?>
		 
		<section class="att_bio_caseresults">
			
			<div class="att_bio_caseresults_inner">
				
				<div class="caseresults_header_wrapper">
				
					<h2 class="att_bio_title">Case Results</h2><!-- att_bio_title -->
				
				</div><!-- caseresults_header_wrapper -->
				
				<?php if(get_field('lawyer_case_result_selling_points')): ?>
				
					<div class="case_results_meta">
						
							<?php while(has_sub_field('lawyer_case_result_selling_points')): ?>
						 
								<div class="single_case_results_meta">
						
									<div class="single_case_icon">
							
										<img data-src="<?php bloginfo('template_directory');?>/images/star_icon.svg" alt="star_icon"/>
							
									</div><!-- single_case_icon -->
						
									<div class="single_case_content">
							
										<span class="cr_title"><?php the_sub_field( 'case_result_bold_header' ); ?></span><!-- cr_title -->
							
										<span class="cr_subtitle"><?php the_sub_field( 'case_results_subheader' ); ?></span><!-- cr_subtitle -->
							
									</div><!-- single_case_content -->
						
								</div><!-- single_case_results_meta -->
						    
							<?php endwhile; ?>
						 
						</div><!-- case_results_meta -->
					
					<?php endif; ?>
				
				<div data-acfupdate="case_result_section" class="att_bio_case_results_slider_wrapper myedit edit_content_top acf_edit">
					
					<div class="att_bio_case_results_slider">
						
							<?php while(has_sub_field('lawyer_case_result_slides')): ?>
		 
								<div class="att_bio_case_results_slide">
							
									<span class="att_bio_case_results_title"><?php the_sub_field( 'lawyer_case_results_header' ); ?></span><!-- att_bio_case_results_title -->
							
									<span class="att_bio_case_results_subtitle"><?php the_sub_field( 'lawyer_case_results_verdict' ); ?></span><!-- att_bio_case_results_subtitle -->
							
									<span class="att_bio_case_results_description"><?php the_sub_field( 'lawyer_case_results_description' ); ?></span><!-- att_bio_case_results_description -->
							
								</div><!-- att_bio_case_results_slide -->
		    
							<?php endwhile; ?>
		 
						
						
					</div><!-- att_bio_case_results_slider -->
					
				</div><!-- att_bio_case_results_slider_wrapper -->
				
			</div><!-- att_bio_caseresults_inner -->
			
			<div class="cr_button_wrapper">
						
						<div class="cr_button_left cr_button">
							
							<div class="cr_arrow"></div><!-- cr_arrow -->
							
						</div><!-- cr_button -->
						
						<div class="cr_button_right cr_button">
							
							<div class="cr_arrow"></div><!-- cr_arrow -->
							
						</div><!-- cr_button -->
						
					</div><!-- cr_button_wrapper -->
			
		</section><!-- att_bio_caseresults -->
		
		<?php endif; ?>
		
		<?php } ?>
		
		<?php if(!get_field('disable_faq_section')) { ?>	
		
		<?php if(get_field('lawyer_faq')) { ?>
		
		<section class="faq">
			
			<div class="faq_inner">
				
				<h2 class="att_bio_title">FAQs</h2>
				
				<div class="faq_questions">
					
					<div data-acfupdate="lawyer_faq_col" class="faq_col myedit edit_content_top acf_edit">
						
						<?php if(get_field('lawyer_faq')): ?>
						 
							<?php while(has_sub_field('lawyer_faq')): ?>
						 
								<div class="single_faq">
							
									<span class="faq_question"><?php the_sub_field( 'question' ); ?></span><!-- faq_question -->
							
									<div class="faq_answer content">
								
										<?php the_sub_field( 'answer' ); ?>
							
									</div><!-- faq_answer -->
							
								</div><!-- single_faq -->
						    
							<?php endwhile; ?>
						 
						<?php endif; ?>
						
					</div><!-- faq_col -->
					
					<div data-acfupdate="lawyer_faq_col_two" class="faq_col myedit edit_content_top acf_edit">
						
						<?php if(get_field('lawyer_faq_col_two')): ?>
						 
							<?php while(has_sub_field('lawyer_faq_col_two')): ?>
						 
								<div class="single_faq">
							
									<span class="faq_question"><?php the_sub_field( 'question' ); ?></span><!-- faq_question -->
							
									<div class="faq_answer content">
								
										<?php the_sub_field( 'answer' ); ?>
							
									</div><!-- faq_answer -->
							
								</div><!-- single_faq -->
						    
							<?php endwhile; ?>
						 
						<?php endif; ?>
						
					</div><!-- faq_col -->
					
				</div><!-- faq_questions -->
				
			</div><!-- faq_inner -->
			
		</section><!-- faq -->
		
		<?php } ?>
		
		<?php } ?>
	
</div><!-- internal_main -->