<?php 
	
	/* Template Name: All Practice Areas */
	
	get_header(); ?>
	
	
	<div id="internal_main">
	
	<div class="internal_banner">
		
		<h1><?php the_title();?></h1>

	</div><!-- internal_banner -->
	
	<div class="outer_container">
		
		<div class="directory_wrapper">
			
			<div class="breadcrumb_wrapper">
				
				<a href="<?php bloginfo('url');?>">Home</a>
	
				<a>Practice Areas</a>
				
			</div><!-- breadcrumb_wrapper -->
			
			<?php if(!empty(get_the_content())) : ?>
			
				<div class="directory_description content">
			 			 
			 		<?php get_template_part( 'loop', 'page' ); ?>
			 				
				</div><!-- directory_description -->
				
				<h2 class="section_header">Browse by Practice Area</h2>
			
			<?php endif;?>
			
			<div class="filter_by_search_wrapper">
				
					<input class="list_input desktop" type="text" placeholder="Filter<?php // echo $citytermtitle;?> Practice Areas Below">
				
					<input class="list_input mobile" type="text" placeholder="Filter">
				
					<div class="filter_by_search_button"></div><!-- filter_by_search_button -->
				
				</div><!-- filter_by_search_wrapper -->
			
			<div class="list_wrapper browse_filter">
				
				<?php 
		
					$terms = get_terms( array(
					'taxonomy' => 'practice_area',
	
					) );
		
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					
						echo '<ul>';
					
						foreach ( $terms as $term ) {
	     
							//$term_link = get_term_link( $term );
							
							//rint_r($term->slug);
	     
							echo '<li><a href="'. get_bloginfo('url') . '/lawyers-practice/' . $term->slug . '-lawyers">' . $term->name . '</a></li>';
        
     				}
    
		 				echo '</ul>';
 					}
		
				?>
				
			</div><!-- list_wrapper -->
			
		</div><!-- directory_wrapper -->
		
	</div><!-- outer_container -->
	
</div><!-- internal_main -->



<?php get_footer(); ?>
