<section id="section_two">
	
	<div class="sec_two_inner">
		
		<h2 class="section_header"><?php the_field( 'section_two_title' ); ?></h2>
		
		<div class="sec_two_grid">
			
			<?php if(get_field('popular_pa_searches')): ?>
			 
				<?php while(has_sub_field('popular_pa_searches')): ?>
				
				
				<?php $recent_practice_areas_terms = get_sub_field( 'pa_link' );?>
	
							
						<div class="sec_two_single">
				
							<a href="<?php bloginfo('url');?>/lawyers-practice/<?php echo $recent_practice_areas_terms->slug; ?>-lawyers">
				
								<div class="sec_two_svg">
									
									<?php if(get_sub_field('icons') == 'Personal Injury'):?>
									
										<img src="<?php bloginfo('template_directory');?>/images/icon-personal-injury.svg"/>
									
									<?php endif;?>
									
									<?php if(get_sub_field('icons') == 'Criminal Defense'):?>
									
										<img src="<?php bloginfo('template_directory');?>/images/icon-criminal-def.svg"/>
									
									<?php endif;?>
									
									<?php if(get_sub_field('icons') == 'Family Law'):?>
									
										<img src="<?php bloginfo('template_directory');?>/images/icon-family-law.svg"/>
									
									<?php endif;?>
									
									<?php if(get_sub_field('icons') == 'Bankruptcy'):?>
									
										<img src="<?php bloginfo('template_directory');?>/images/icon-bankruptcy.svg"/>
									
									<?php endif;?>
									
									<?php if(get_sub_field('icons') == 'Business'):?>
									
										<img src="<?php bloginfo('template_directory');?>/images/icon-business.svg"/>
									
									<?php endif;?>
									
									<?php if(get_sub_field('icons') == 'Immigration'):?>
									
										<img src="<?php bloginfo('template_directory');?>/images/icon-immigration.svg"/>
									
									<?php endif;?>
					
									<span><?php the_sub_field( 'title' ); ?></span>
					
								</div><!-- sec_two_svg -->
				
							</a>
				
						</div><!-- sec_two_single -->
					
			    
				<?php endwhile; ?>
			 
			<?php endif; ?>
			
			
		</div><!-- sec_two_grid -->
		
	</div><!-- sec_two_inner -->
	
	<div class="sec_two_button_wrapper">
		
		<div class="sec_two_button sec_two_button_left">
			
			<div class="button_arrow"></div><!-- button_arrow -->
			
		</div><!-- sec_two_button_left -->
		
		<div class="sec_two_button sec_two_button_right">
			
			<div class="button_arrow"></div><!-- sec_two_button_right -->
			
		</div><!-- sec_two_button_left -->
		
	</div><!-- sec_two_button_wrapper -->
	
</section><!-- section_two -->