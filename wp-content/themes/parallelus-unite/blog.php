<?php get_header(); ?>
<?php

	// Get options for blog page ($blogID set in checkPageType() found in addon-functions.php)
	//--------------------------------------------------------------------------------------------------------------
	
	$options = get_theme_var('blogSettings');	// retrieves settings array from database

	// get blog id
	$flipped_ids = array_flip(get_theme_var('blogPages'));
	$blogID = $flipped_ids[$post->ID];
	$pageTitle = get_the_title($post->ID);
	$excludeCategories = $options[$blogID.'_Exclude'];
	
	
	// breadcrumbs
	$hideBreadcrumbs = false;
	if ( get_post_meta($post->ID, 'breadcrumbOff', true) ) {
		$hideBreadcrumbs = true;
	} elseif ( $GLOBALS['globalBreadcrumbsOff'] ) {
		$hideBreadcrumbs = true;
	}

	// sub-title
	$subTitle = get_post_meta($post->ID, 'subTitle', true); // from page options (overrides blog setup sub-title)
	if ( $subTitle == '' ) {
		$subTitle = $options[$blogID.'_SubTitle']; // from blog setup
	}
	if ( $subTitle != '' ) {
		$subTitle = ' &nbsp;//&nbsp; ' . $subTitle;	// setup subtitle formatting
	}

	?>
			<!-- Page Content -->
			<div class="contentArea">
				<div class="two-thirds">
					<!-- Title / Page Headline -->
					<h1 class="headline"><strong><?php echo $pageTitle; ?></strong><?php echo $subTitle; ?></h1>
					
					<div class="hr"></div>

					<?php if (!$hideBreadcrumbs) : ?>
						<!-- Breadcrumbs -->
						<p class="breadcrumbs"><?php show_breadcrumbs(); ?></p>
					<?php endif;
					
					// check for page content
					query_posts('page_id='.$post->ID);
					
					// Print content from the page
					if (have_posts()) : 
					while (have_posts()) : the_post(); 
						if (get_the_excerpt() != '') {
							the_content(__('More Information',THEMENAME ).'...');
							echo '<p class="clear">&nbsp;</p>';
						}
					endwhile;
					endif;

					// query posts for this blog page
					query_posts(array('category__not_in' => $excludeCategories, 'paged'=>$paged));

					// loop through the posts
					if ( have_posts() ) : 
						while ( have_posts() ) : the_post();
						
							// get the post image
							$postImg = showImage(556, 133, get_the_title(), 'blog');
														
							?>							
							
							<div class="blogPostSummary">
								<h1 onclick="document.location.href='<?php echo get_permalink(); ?>'" style="cursor:pointer;"><?php the_title(); ?></h1>					
						
								
								<p><?php echo str_replace(' [...]', '...', get_the_excerpt()); ?></p>
								<p><a href="<?php echo get_permalink(); ?>"><?php _e('Read more',THEMENAME ) ?>...</a></p>
							</div>								
							<?php
						endwhile;
					?>
					<!-- End of Content -->
					<div class="clear"></div>			
					<?php get_pagination(); ?>				
					<?php else : ?>
					 <p><?php _e('There is nothing here (yet).',THEMENAME ) ?></p>
					<?php endif; ?>
				</div> <!-- end  <div class="two-thirds"> -->
				<div class="one-third">	<?php get_sidebar(); ?>	</div>
				<!-- End of Content -->
				<div class="clear"></div>
			</div>	
<?php get_footer(); ?>