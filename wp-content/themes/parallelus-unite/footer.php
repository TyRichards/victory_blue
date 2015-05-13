	</div> <!-- end <div class="pageMain"> -->
		
		<!-- Footer -->
		<div id="Footer">
			<div id="FooterTop"></div>
			<div id="FooterContent">
			
				<div class="contentArea">
				
					<!-- Column 1 -->
					<div class="one-third">
						<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Left')) : ?>
						<?php endif; ?>
					</div>

					<!-- Column 2 -->
					<div class="one-third">
						<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Middle')) : ?>
						<?php endif; ?>
					</div>

					<!-- Column 3 -->
					<div class="one-third last">
						<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Right')) : ?>
						<?php endif; ?>
					</div>
					
					<!-- End of Content -->
					<div class="clear"></div>
	
					<!-- Column 1 -->
					<div class="full-page">
						<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Extra')) : ?>
						<?php endif; ?>
					</div>

					<!-- End of Content -->
					<div class="clear"></div>
				</div>
					
			</div>
			<div id="FooterBottom"></div>
			
		</div>
		
		<!-- Copyright/legal text -->
		<div id="Copyright">
			<p>
				<?php echo stripslashes(get_theme_var('legalText')); ?>
			</p>
		</div>
		
	</div>
</div>

<?php wp_footer(); ?>

<?php 
// Font Replacement
if (get_theme_var('fontReplacement', 1) != false) :
	// font replacement add-on to prevent flicker/delay on IE only (don't use on search results page because it causes distortion)
	if (!$_GET['s']) : ?>
		<!-- Activate Font Replacement (cufon) -->
		<script type="text/javascript"> Cufon.now(); </script>
	<?php 
	endif;
endif; ?>


<?php echo stripslashes(get_theme_var('googleAnalytics')); ?>

</body>
</html>