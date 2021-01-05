<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<?php if (get_query_var( 'currentstate')) {
		
		echo "<title>garrett</title>";
	
	}
	
	
?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />



<style>


<?php the_field( 'review_css','option'); ?>

@import url('https://fonts.googleapis.com/css?family=Montserrat:800|Prata|Work+Sans:400,600,700');

</style>

<?php wp_head(); ?>

<?php the_field('schema_code', 'option'); ?>

<?php the_field('analytics_code', 'option'); ?>

</head>

<body <?php body_class(); ?>>
	
	
	<header>
		
		<div class="header_left">
			
			<a class="" href="<?php bloginfo('url');?>">
				
				<img src="<?php bloginfo('template_directory');?>/images/ilawuit-logo.svg"/>
				
			</a>
			
		</div><!-- header_left -->
		
		<div class="header_middle">
			
		<?php
			
			if ( is_user_logged_in() ) {
				
				$current_user = wp_get_current_user();?>
				
				<div class="login_header_wrapper loggedin">
					
										
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
						
						// redirect to wp-admin 
						
						if($user_id === 1) {
							
							$url = get_bloginfo('url') . '/wp-admin'; 
						
						}
						
						else {
							
							$url_id = reset($post_redirect);

							$url = get_bloginfo('url') . "/lawyer/?p=" . $url_id; 
						
						
						}
						
						 
	        ?>
			
					<a class="username_post_link" href="<?php echo $url;?>"><?php echo $current_user->user_login;?></a>
				
					<a class="logout_link" href="<?php echo wp_logout_url(); ?>">Logout</a>
				
				</div><!-- login_header_wrapper -->
			
				<?php } else { ?>
				
				<div class="login_header_wrapper loggedout">
			
					<a class="login_link" href="<?php bloginfo('url');?>/login">Login</a>
				
					<a class="create_link" href="<?php the_permalink(597956);?>">Create Your Profile</a><!-- create_link -->
				
				</div><!-- login_header_wrapper -->
			
			<?php } ?>
		
		
			
			<div class="search_wrapper"><?php get_search_form(); ?></div><!-- search_wrapper -->
			
		</div><!-- header_middle -->
		
		<div class="header_right">
			
			
			
			<div class="menu_wrapper">
				
				<div class="menu_bars">
				
					<span class="menu_bar"></span><!-- menu_bar -->
					<span class="menu_bar"></span><!-- menu_bar -->
					<span class="menu_bar"></span><!-- menu_bar -->
				
				</div><!-- menu_bars -->
			
				<span class="menu_title">Menu</span><!-- menu_title -->
			
			</div><!-- menu_wrapper -->
			
		</div><!-- header_right -->
		
	
	</header>
	
	<?php 
		
		// this clashed with the multistep forms visually its confusing
		
		if(!is_singular('lawyer')) {?>
	
	
	<div class="mobile_sticky_header">
		
			<div class="mobile_refine_wrapper">
			
				<div class="mobile_search_icon"></div><!-- mobile_search_icon -->
			
				<span>Refine Your Search</span>
			
			</div><!-- mobile_refine_wrapper -->
			
			<div class="mobile_close_wrapper">
				
				<div class="mobile_refine_close"></div><!-- mobile_refine_close -->
				
				<span>Close</span>
				
			</div><!-- mobile_close_wrapper -->
			
		</div><!-- mobile_sticky_header -->
		
		<div class="mobile_search_overlay">
			
			<div class="mobile_search_overlay_inner">
			
				<?php get_template_part('searchform','threepart');?>
			
			</div><!-- mobile_search_overlay_inner -->
			
		</div><!-- mobile_search_overlay -->
	
	
	<?php } ?>
	
	
	
	
	
	<nav>
		
		<div class="nav_close">
			
			<div class="nav_close_inner"></div><!-- nav_close_inner -->
			
		</div><!-- nav_close -->
		
		<div class="nav_inner">
			
			<div class="nav_col nav_col_one">
				
				<a href="<?php bloginfo('url');?>">
				
					<img class="nav_logo" src="<?php bloginfo('template_directory');?>/images/ilawuit-logo.svg"/>
				
				</a>
				
			</div><!-- nav_col -->
			
			<div class="nav_col nav_col_two">
				
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'main_menu' ) ); ?>
			
				
			</div><!-- nav_col -->
			
			<div class="nav_col nav_col_three">
				
				<div class="submenu_container"></div><!-- submenu_container -->
				
			</div><!-- nav_col -->
			
		</div><!-- nav_inner -->
		
	</nav>
				


			