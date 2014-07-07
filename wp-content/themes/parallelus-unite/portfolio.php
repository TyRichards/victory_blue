<?php get_header(); 

	// Get options for portfolio page ($portfolioID set in checkPageType() found in addon-functions.php)
	//--------------------------------------------------------------------------------------------------------------
	
	$options = get_theme_var('portfolioSettings');	// retrieves settings array from database

	// get portfolio id
	$flipped_ids = array_flip(get_theme_var('portfolioPages'));
	$portfolioID = $flipped_ids[$post->ID];
	
	$pageID = $post->ID;
	$pageTitle = get_the_title($post->ID);
	$useCategories = $options[$portfolioID.'_Categories'];
	$pageItems = $options[$portfolioID.'_Items'];
	$linkOption = $options[$portfolioID.'_Open'];
	
	// breadcrumbs
	$hideBreadcrumbs = false;
	if ( get_post_meta($post->ID, 'breadcrumbOff', true) ) {
		$hideBreadcrumbs = true;
	} elseif ( $GLOBALS['globalBreadcrumbsOff'] ) {
		$hideBreadcrumbs = true;
	}

	// sub-title
	$subTitle = get_post_meta($post->ID, 'subTitle', true); // from page options (overrides portfolio setup sub-title)
	if ( $subTitle == '' ) {
		$subTitle = $options[$portfolioID.'_SubTitle']; // from portfolio setup
	}
	// setup subtitle formatting
	if ( $subTitle != '' ) {
		$subTitle = ' &nbsp;//&nbsp; ' . $subTitle;
	}
	
	?>

			<!-- Portfolio/Gallery Content -->
			<div class="contentArea">
				<!-- Title / Page Headline -->
				<div class="full-page">
					<h1 class="headline"><strong><?php echo $pageTitle; ?></strong><?php echo $subTitle; ?></h1>
				</div>
				
				<div class="hr"></div>

				<?php if (!$hideBreadcrumbs) : ?>
					<!-- Breadcrumbs -->
					<div class="full-page">
						<p class="breadcrumbs"><?php show_breadcrumbs(); ?></p>
					</div>
					
					<!-- End of Content -->
					<div class="clear"></div>
				<?php endif; ?>
			</div>
			
			<?php 
			
			// Featured Content 
			if ( $options[$portfolioID.'_Featured'] != '') {
			
			?>
			<!-- Featured Items -->
			<div class="contentArea" <?php if ($hideBreadcrumbs) { echo 'style="margin-top: -25px;"'; } ?>>
				<div class="full-page">
					<?php 
					query_posts('cat='.$options[$portfolioID.'_Featured'].'&posts_per_page=5');
					
					if (have_posts()) : 
					
					$loops = 0;
					while (have_posts()) : the_post(); 
					
						$loops++;
						
						// get the post image
						$primaryMedia = get_post_meta($post->ID, "_imageOriginal", true);
						$portfolioImg = showImage(150, 100, get_the_title(), 'medium');
						
						// check for video
						if ( $portfolioImg['hasvideo'] ) {
							$is_video = true;	// this isn't an image, so it must be a video
							$rel = '';
						} else {
							// ok, it's an image
							$fullsizeImg = showImage(640, 480, '', 'original');
							$is_video = false;
							$rel = 'rel="featured"';
						}
						
						// image link and class info
						$imgClass = 'img';
						if ($linkOption == 'post') {
							$linkHref = get_permalink();
							$class = 'class="'. $imgClass .'"';
						} else {
							$class = 'class="zoom '. $imgClass .'"';
							if ($is_video) {
								$linkHref = $primaryMedia;
							}else {
								$linkHref = $fullsizeImg['src'];
							}
						}

						// last loop (to alter styles)
						$style = 'style="margin-right: 17px;"';
						if ($loops == 5) {
							$style = 'style="margin-right: 0;"';
						}
						
						?>
						<a href="<?php echo $linkHref; ?>" <?php echo $class; ?> title="<?php the_title(); ?>" <?php echo $style; ?>  <?php echo $rel; ?>>
							<?php echo $portfolioImg['full']; ?>
						</a>
						<?php
						
					endwhile;
					endif;
					?>
				</div>
				
				<!-- End of Content -->
				<div class="clear"></div>

			</div>
			<?php
			} // end Featured
			?>

		

			
		<?php 
		query_posts('page_id='.$pageID);
		
		if (have_posts()) : 
		while (have_posts()) : the_post(); 
			if (get_the_excerpt() != '') {
			
				if ($options[$portfolioID.'_Featured'] != '') {
				// Top page background gap only necessary when using Featured images
				?>
				<!-- BEGIN: Floating content area -->	
				</div>
				<div class="pageBottom"></div>
				<div class="pageTop"></div>
				<div class="pageMain">
					<div class="contentArea">
				<?php 
				}else { 
					// We're adding the contentArea DIV above so we can have this else condition to do some special styling
					// when breadcrumbs are off. This way we don't need to test again if featured items are enabled.
					?>
					<div class="contentArea" <?php if ($hideBreadcrumbs) { echo 'style="margin-top: -25px;"'; } ?>>
				<?php } ?>
				
						<div class="full-page">
								<?php
								// Print content from the page
								the_content(__('More Information',THEMENAME ).'...');
								?>
						</div>
						
						<!-- End of Content -->
						<div class="clear"></div>
		
					</div>
				
				</div>
				<div class="pageBottom"></div>
				<div class="pageTop"></div>
				<div class="pageMain">
				<!-- END: Floating content area -->
				<?php
			}
		endwhile;
		endif;
		?>
		

		<div class="contentArea">
			<div class="full-page">
				
				<!-- Gallery/Portfolio -->
				<div class="portfolio">
					
					<?php 
					
					// Main gallery/portfolio items
					
					// Categories to include
					if ( is_array($useCategories) ) {
						$portfolioCategories = implode(',',$useCategories );
					}
					
					// Posts per page
					$itemsPerPage = ($pageItems <= 0) ? '9' : $pageItems;
					
					// query the selected items
					query_posts('cat='.$portfolioCategories.'&posts_per_page='.$itemsPerPage.'&paged='.$paged);
					
					if (have_posts()) : 
					while (have_posts()) : the_post(); 
						
						// get the post image
						$primaryMedia = get_post_meta($post->ID, "_imageOriginal", true);
						$portfolioImg = showImage(261, 174, get_the_title(), 'medium');
						
						// check for video
						if ( $portfolioImg['hasvideo'] ) {
							$is_video = true;	// this isn't an image, so it must be a video
							$rel = '';
						} else {
							// ok, it's an image
							$fullsizeImg = showImage(640, 480, '', 'original');
							$is_video = false;
							$rel = 'rel="portfolio"';
						}
						
						// image link and class info
						$imgClass = 'img';
						if ($linkOption == 'post') {
							$linkHref = get_permalink();
							$class = 'class="'. $imgClass .'"';
						} else {
							$class = 'class="zoom '. $imgClass .'"';
							if ($is_video) {
								$linkHref = $primaryMedia;
							}else {
								$linkHref = $fullsizeImg['src'];
							}
						}

						?>
						<div class="portfolio-item">
							<a href="<?php echo $linkHref; ?>" <?php echo $class; ?> title="<?php the_title(); ?>"  <?php echo $rel; ?>>
								<!--img src="<?php echo $postImage; ?>" width="261" height="174" class="portfolio-image" alt="image" /-->
								<?php echo $portfolioImg['full']; ?>
							</a>
							<div class="portfolio-description">
								<h4><?php the_title(); ?></h4>
								<p><?php the_content_rss('...', TRUE, '', 15); ?></p>
								<a href="<?php echo get_permalink(); ?>"><?php _e('More Information',THEMENAME ) ?>... </a>
							</div>
						</div>
						<?php
						
					endwhile;
					endif;
					?>						
				</div>
				
				<!-- End of Content -->
				<div class="clear"></div>

				<?php get_pagination(); ?>
				
			</div>
			
			<!-- End of Content -->
			<div class="clear"></div>
		
		</div>
<?php get_footer(); ?>