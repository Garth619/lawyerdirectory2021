<div class="three_part_search_wrapper">

<form action="<?php bloginfo('url');?>/results/" method="get">
				
	<div class="sec_one_input_wrapper">
	
		<div class="input_wrapper att_name_input">
	
			<input type="text" name="attorney_keyword" id="search" placeholder="Attorney Name" value="<?php // the_search_query(); ?>" />
			
		</div><!-- input_wrapper -->
	
		<div class="input_wrapper type_of_Law_input">
	
			<div class="sec_one_select_wrapper">
		
				<div class="sec_one_select">
			
					<span class="select_text">Type of Law</span><!-- select_text -->
			
				</div><!-- sec_one_select -->
				
				<div class="sec_one_select_dropdown">
					
					<ul>
						
						<?php $search_form_pa_dropdown_options_terms = get_field( 'search_form_pa_dropdown_options', 124);
						
						 if ( $search_form_pa_dropdown_options_terms ):
						
							foreach ( $search_form_pa_dropdown_options_terms as $search_form_pa_dropdown_options_term ): 
							
								echo '<li><span>' . $search_form_pa_dropdown_options_term->name . '</span></li>';
						
							endforeach; 
						
							endif;
						
						?>
							
						<li><span>Search All Types</span></li>
						
					</ul>
					
				</div><!-- sec_one_select_dropdown -->
		
			</div><!-- sec_one_select_wrapper -->
			
			<input id="typeoflaw" type="hidden" value="" name="attorney_pa" />
	
		</div><!-- input_wrapper -->
	
		<div class="input_wrapper city_state_input">
	
			<input type="text" placeholder="City or State" value="" autocomplete="off" name="attorney_location" required />
	
		</div><!-- input_wrapper -->
	
	</div><!-- sec_one_input_wrapper -->
	
	<div class="sec_one_submit_wrapper">
			
			<input type="submit" id="searchsubmit" value="Click to find a lawyer">
		
	</div><!-- sec_one_submit_wrapper -->
	
</form>

</div><!-- three_part_search_wrapper -->