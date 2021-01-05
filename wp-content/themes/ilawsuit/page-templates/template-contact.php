<?php
	
	/* Template Name: Contact */
	
	get_header(); ?>


<div id="internal_main">
	
	<div class="internal_banner">
		
		<h1><?php the_title();?></h1>

	</div><!-- internal_banner -->
	
	<div class="outer_container">
		
		<div class="directory_wrapper">
			
			<div class="form_wrapper">
				
				<?php gravity_form(1, false, false, false, '', true, 12); ?>
				
			</div><!-- form_wrapper -->
			
		</div><!-- directory_wrapper -->
		
	</div><!-- outer_container -->
	
</div><!-- internal_main -->
		

<?php get_footer(); ?>
