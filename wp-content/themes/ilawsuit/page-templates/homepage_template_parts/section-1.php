<section id="section_one">
	
		<div class="sec_one_inner">
			
			<h1><?php the_field( 'section_one_title' ); ?></h1>
			
				<?php get_template_part('searchform','threepart');?>
			
		</div><!-- sec_one_inner -->
		
		<?php 
			
			$section_one_image_jpg = get_field( 'section_one_image_jpg' );
			$section_one_image_webp = get_field( 'section_one_image_webp' );
		
		?>
		
		<img class="sec_one_bg" data-jpg="<?php echo $section_one_image_jpg['url']; ?>" alt="<?php echo $section_one_image_jpg['alt']; ?>" data-webp="<?php echo $section_one_image_webp['url']; ?>" />

		
</section><!-- section_one -->

