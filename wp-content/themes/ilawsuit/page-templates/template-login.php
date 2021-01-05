<?php 
	
	/* Template Name: Login */ ?>
	 
<?php wp_head(); ?>

<div class="custom_login">
	
	<div class="custom_login_inner">
		
		<?php echo file_get_contents("wp-content/themes/ilawsuit/images/ilawuit-logo-dark.svg"); ?>
		
		
    
    <?php if( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) { ?>
    
    	<div class="wp_login_error">
        
        <span>The username/password you entered is incorrect, Please try again.</span>
        
      </div><!-- wp_login_error -->
    
    <?php } 
    
    else if( isset( $_GET['login'] ) && $_GET['login'] == 'loggedout' ) { ?>
    
    	<div class="wp_login_error">
        
        <span>Please enter both username and password.</span>
        
      </div>
   
    <?php } ?>
	
   
		
		<?php
			if ( ! is_user_logged_in() ) { // Display WordPress login form:
				
			$args = array(
        //'redirect' => admin_url(), 
        'form_id' => 'loginform-custom',
        'label_username' => __( 'Username' ),
        'label_password' => __( 'Password' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in' => __( 'Log In' ),
        'remember' => true
			);
			
			wp_login_form( $args );
		} 
?>


	
	<span class="back_to_site" onclick="goBack()">Back to Site</span><!-- back_to_site -->
	
	<script type="text/javascript">
		function goBack() {
    	window.history.back();
		}
	</script>
		
	</div><!-- custom_login_inner -->
	
</div><!-- custom_login -->

<?php wp_footer();?>