<?php get_header(); ?>

			<!-- Page Content -->
			<div class="contentArea">
			
				<!-- End of Content -->
				<div class="clear"></div>
				
			</div>

		<!-- BEGIN: Floating content area -->	
		</div>
		<div class="pageBottom"></div>
		<div class="pageTop"></div>
		<div class="pageMain">
		
			<!-- Error Message -->
			<div class="contentArea">
				<div class="full-page">
					
					<br />
					<br />
					<br />
					
					<!-- Title / Page Headline -->
					<h1 class="headline"><strong><?php _e( 'Error 404',THEMENAME ); ?></strong> &nbsp;//&nbsp; <?php _e( 'Page could not be found.',THEMENAME) ?></h1>

					<div class="hr"></div>
				
					<p><?php 
						if (get_theme_var("custom404") != '') {
							echo stripslashes(get_theme_var("custom404"));
						} else {
							 _e( 'Sorry, the page you are looking for wasn\'t found.',THEMENAME );
						}
					?></p>
					
					<br />
					<br />
					<br />

					<!-- End of Content -->
					<div class="clear"></div>
					
				</div>
			</div>
			
		</div>
		<div class="pageBottom"></div>
		<div class="pageTop"></div>
		<div class="pageMain">
		<!-- END: Floating content area -->
		
			<div class="contentArea">
				<div class="full-page">
				
				
					<!-- End of Content -->
					<div class="clear"></div>
					
				</div>
			</div>

<?php get_footer(); ?>