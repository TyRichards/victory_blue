<?php get_header();

			// breadcrumbs
			$hideBreadcrumbs = false;
			if ( get_post_meta($post->ID, 'breadcrumbOff', true) ) {
				$hideBreadcrumbs = true;
			} elseif ( $GLOBALS['globalBreadcrumbsOff'] ) {
				$hideBreadcrumbs = true;
			}
		
			// sub-title
			$subTitle = get_post_meta($post->ID, 'subTitle', true); // from page options 
			if ( $subTitle != '' ) {
				$subTitle = ' &nbsp;//&nbsp; ' . $subTitle;	// setup subtitle formatting
			}
			?>
			
			<!-- Page Content -->
			<div class="contentArea">
			
				<div class="two-thirds">
				<?php 
				if (have_posts()) : 
				while (have_posts()) : the_post();
				
					// get the post image
					$postImg = showImage(556, 133, get_the_title(), 'blog');
		
					?>
					
					<!-- Title / Page Headline -->
					<h1 class="headline"><strong><?php the_title(); ?></strong><?php echo $subTitle; ?></h1>
					
					<div class="hr"></div>

					<?php if (!$hideBreadcrumbs) : ?>
						<!-- Breadcrumbs -->
						<p class="breadcrumbs"><?php show_breadcrumbs(); ?></p>
					<?php endif; ?>

					<!-- Blog Post -->
				
					
					<!-- Post Text and Main Content -->
					<div class="blogPostSummary blogPostFullText">
						
						
						<div class="blogPostText">
							<?php the_content(__('More Information',THEMENAME ).'...'); ?>
						</div>
					</div>

					<!-- Post Extras -->
					<div class="postFooter">
						<?php 
						if ( function_exists('the_tags') ):
							if (get_the_tags()): ?>
							<p class="postTags">
								<strong>Tags:</strong><br />
								<?php echo the_tags('', ', ', '');?>
							</p>
							<?php
							endif; 
						endif; ?>
						<?php edit_post_link('Edit','<p class="postEdit">','</p>'); ?>
					</div>
				
					<!-- Post Comments -->
					
					
					<!-- End of Content -->
					<div class="clear"></div>

					<?php 
				endwhile; 
				endif; ?>
				</div> <!-- end  <div class="two-thirds"> -->
								
				<div class="one-third">
				
					<div id="Sidebar">
						<?php get_sidebar(); ?>
					</div>
				
				</div>
				
				<!-- End of Content -->
				<div class="clear"></div>
			</div>

<?php get_footer(); ?>