<?php 
	
	/* Template Name: All States */
	
	get_header(); ?>


<div id="internal_main">
	
	<div class="internal_banner">
		
		<h1><?php the_title();?></h1>

	</div><!-- internal_banner -->
	
	<div class="outer_container">
		
		<div class="directory_wrapper">
			
			<div class="breadcrumb_wrapper">
				
				<a href="<?php bloginfo('url');?>">Home</a>
				
				<a>Locations</a>
				
			</div><!-- breadcrumb_wrapper -->
			
			<?php if(!empty(get_the_content())) : ?>
			
				<div class="directory_description content">
			 			 
			 		<?php get_template_part( 'loop', 'page' ); ?>
			 				
				</div><!-- directory_description -->
				
				<h2 class="section_header">browse by states</h2>
			
			<?php endif;?>
			
				<div class="filter_by_search_wrapper">
				
					<input class="list_input desktop" type="text" placeholder="Filter<?php // echo $citytermtitle;?> States Below">
				
					<input class="list_input mobile" type="text" placeholder="Filter">
				
					<div class="filter_by_search_button"></div><!-- filter_by_search_button -->
				
				</div><!-- filter_by_search_wrapper -->
			
			<div class="list_wrapper browse_filter">
				
				<?php 
		
					$state_terms = get_terms( array( // change new WP_Term_Query later, its newer and faster i think
						'taxonomy' => 'location',
						'parent'  => 139 // add a slug to id conversion here
	
					) );
		
					if ( ! empty( $state_terms ) && ! is_wp_error( $state_terms ) ) {
						
						echo '<ul>';
						
						foreach ( $state_terms as $state_term ) {
	     
							//$stateterm_link = get_term_link( $state_term );
	     
							echo '<li><a href="' . get_bloginfo('url') . '/lawyers-location/state/' . $state_term->slug . '-lawyers">' . $state_term->name . '</a></li>';
        
     				}
     
		 				echo '</ul>';
 					
 					} ?>
				
			</div><!-- list_wrapper -->
			
		</div><!-- directory_wrapper -->
		
	</div><!-- outer_container -->
	
</div><!-- internal_main -->



<?php get_footer(); ?>
