<?php 
	
	if(is_user_logged_in() && get_current_user_id() == $post->post_author) { 

		acf_form_head();

	} ?>

<?php get_header(); 

	
	if(get_field('lawyer_premium_layout_two') == 'Premium Profile $189/Year') {

		get_template_part('single','premiumlawyer');
	
	}
	
	else {
		
		get_template_part('single','standardlawyer');
		
	} ?>
	
	<?php get_template_part('page-templates/template','prepareoverlay');?>
	
	<div class="success_overlay show_on_success">
		
		<div class="success_overlay_inner">
			
			<div class="success_content">
			
				<?php echo file_get_contents("wp-content/themes/ilawsuit/images/success.svg"); ?>
			
				<span class="success_header">Success</span><!-- success_header -->
			
				<p>Your profile has been updated!</p>
				
				<span class="success_close">View Profile</span>
			
			</div><!-- success_content -->
			
		</div><!-- success_overlay_inner -->
		
	</div><!-- success_overlay -->
	
		
	<?php 
		
	// if user is logged and looking at their current profile and its not a free profile then allow them to edit
		
	if(is_user_logged_in() && get_current_user_id() == $post->post_author && get_field('lawyer_premium_layout_two') !== "Claim Free Profile") { ?>
	
	<div class="update_custom_form current_author_form content">
		
		<div class="update_custom_form_left"></div><!-- update_custom_form_left -->
		
		<div class="update_custom_form_right">
			
				<div class="acf_close_wrapper">
				
					<div class="acf_close"></div><!-- acf_close -->
				
				</div><!-- acf_close_wrapper -->
				
					<?php 
						
						// updates are broken into seperate forms for speed. Some items, acf form can handle fast, others need to be gravity forms in order to do the custom functions such as update title, slug, featured image and terms
						
						// post title and slug
						
						gravity_form(7, false, false, false, '', true, 3344);
						
						// image upload that sets to the featured image and add to the media library
						
						gravity_form(8, false, false, false, '', true, 3345);
						
						// practice areas - sets terms and plots post to the directory 
						
						gravity_form(10, false, false, false, '', true, 3346);
						
						// Address - plots post to the directory and the director google map
						
						gravity_form(9, false, false, false, '', true, 3347);
						
						// all other items on page 
						
						$acf_redirect = $_SERVER['REQUEST_URI'];
						
						$acf_success = $acf_redirect . '/?profile=success';
						
						acf_form($settings = array('return' => $acf_success)); 
					
					?>
				
			</div><!-- update_custom_form_right -->
		
	</div><!-- acf_form -->
	
	<div class="mobile_edit">
		
		<span>Tap any content to edit</span>
	
	</div><!-- mobile_edit -->
	
<?php } ?>

<?php  get_footer(); ?>


