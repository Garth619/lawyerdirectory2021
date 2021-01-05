<?php get_header(); ?>


<div id="internal_main">
	
	<div class="internal_banner">
		
		<h1>Not Found</h1>

	</div><!-- internal_banner -->
	
	<div class="outer_container">
		
		<div class="directory_wrapper">
			
			<div class="not_found_description content" style="text-align:center">
				
					<p>The page you were looking for appears to have been moved, deleted or does not exist. You could <a class="go_back" onclick="goBack()">go back</a> to where you were, head straight to our <a href="/">home page</a>, or refine your search below.</p>
				
					<?php get_template_part('searchform','threepart');?>
			 	
			 </div><!-- not_found_description -->
			
		
				
		</div><!-- directory_wrapper -->
		
		
		
	</div><!-- outer_container -->
	
</div><!-- internal_main -->


	<script type="text/javascript">

		function goBack() {
    	window.history.back();
		}

	</script>


<?php get_footer(); ?>