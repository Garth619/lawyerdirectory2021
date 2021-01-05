<?php
	
	/* Template Name: Create Profile */
	
	get_header(); ?>



<div id="internal_main">
	
	<div class="internal_banner">
		
		<?php 
			
		// some info i need to make the form redirects work properly
			
		$hiddenpost_id = get_the_ID();?>
		
		<h1 data-homeurl="<?php bloginfo('url');?>" id="<?php echo $hiddenpost_id;?>" data><?php the_title();?></h1>

	</div><!-- internal_banner -->
	
	<div class="outer_container">
		
		<div class="directory_wrapper">
			
			<div class="default_wrapper content">
				
				<?php if(is_user_logged_in()) : ?>
				
					<?php 
						
						$user_id = $current_user->ID;
	        	
	        	$author_args = array(
							'posts_per_page' => 1,
							'post_type' => 'lawyer',
							'post_status' => 'publish',
							'author' => $user_id,
							'orderby' => 'date',
							'order' => 'ASC',
						);
						
						
						
						$first_post = new WP_Query($author_args); while($first_post->have_posts()) : $first_post->the_post(); 
            
            $post_redirect[] = get_the_ID();
            
            endwhile; 
            
            wp_reset_postdata(); // reset the query 
						
						
						$url_id = reset($post_redirect);

	        	
	        	$url = get_bloginfo('url') . "/lawyer/?p=" . $url_id;  
	        	
	        	?>

				
					<p>Please <a href="<?php echo wp_logout_url(); ?>">logout</a> to create a new profile</p>
				
					<p>Or you can <a href="<?php echo $url;?>">update</a> your existing one here</p>
				
				<?php else: ?>
				
					<?php get_template_part('page-templates/template','multistepforms');?>
				
				<?php endif; ?>
				
			</div><!-- list_wrapper -->
			
		</div><!-- directory_wrapper -->
		
	</div><!-- outer_container -->
	
</div><!-- internal_main -->

<?php get_template_part('page-templates/template','prepareoverlay');?>

<?php get_footer(); ?>