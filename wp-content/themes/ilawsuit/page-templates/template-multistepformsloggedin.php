<div class="mymultistep_form_wrapper">
							
	<img class="price_logo" src="<?php bloginfo('template_directory');?>/images/ilawuit-logo-dark.svg"/>
	
	<div class="price_description content">
		
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
		
		<div class="price_tier_wrapper">
			
		<?php if(get_field('lawyer_premium_layout_two') == 'Claim Free Profile') { ?>
		
			<div class="price_tier">
		
				<h3>Basic Profile</h3>
			
				<span class="price_tier_subheder">$99/Year</span><!-- price_tier_subheder -->
		
				<p>Lorem ipsum dolor sit amet, consectetur adip</p>
		
				<div class="layout_selection">
			
					<span class="radio_button radio_button_three"></span>
			
					<span class="radio_button_verbiage">Update Premium Profile</span>
			
				</div><!-- layout_selection -->
		
			</div><!-- price_tier -->

		<?php } ?>
		
		<div class="price_tier">
		
			<h3>Premium Profile</h3>
			
			<span class="price_tier_subheder">$199/Year</span><!-- price_tier_subheder -->
		
			<p>Lorem ipsum dolor sit amet, consectetur adip</p>
		
			<div class="layout_selection">
			
				<span class="radio_button radio_button_three"></span>
			
				<span class="radio_button_verbiage">Update Premium Profile</span>
			
			</div><!-- layout_selection -->
		
		</div><!-- price_tier -->
		
		</div><!-- price_tier_wrapper -->
		
		<span class="claim_begin">Let's Begin</span><!-- claim_begin -->
		
		<?php 
			
			if(is_singular('lawyer')) {?>
		
				<span class="go_back_to_profile">Go Back to Profile</span><!-- go_back_to_profile -->
		
		<?php } ?>
		
	</div><!-- price_description -->
	
	<div class="mymultistep_form">
		
		
		<?php 
			
			if(is_singular('lawyer')) {
		
				gravity_form(11, false, false, false, '', true, 1344);
				
				echo "<span class='go_back_to_profile'>Go Back to Profile</span>";
			
			}
			
			if(is_page_template('page-templates/template-createprofile.php')) {
				
				gravity_form(4, false, false, false, '', true, 1344);
				
			}
		
		?>
		
	
		
		</div><!-- mymultistep_form -->
		
	</div><!-- mymultistep_form_wrapper -->