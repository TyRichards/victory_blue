<?php get_header(); ?>

			<!-- Search Content -->
			<div class="contentArea pageContent">
			
				<div class="two-thirds">
								
				<?php 
				// Search term entered
				if (is_search()) {
					?>
					<!-- Title / Page Headline -->
					<h1 class="headline"><strong><?php _e('Search Results',THEMENAME ) ?></strong> &nbsp;//&nbsp; <?php echo $s; ?></h1>
					<?php
				}
				?>
					
					<div class="hr"></div>
	
				<?php 
				// search form 
				get_search_form(); 
				
				echo '<p>&nbsp;</p>';
				
				if (have_posts()) : 
				while (have_posts()) : the_post();
				
					// get the post image
					$postImg = showImage(556, 133, get_the_title(), 'blog');
						
					// strip domain, use local path to image
					$UrlParts = parse_url($postImage);
					$postImage = $UrlParts['path'];
		
					?>
	
					<!-- Blog Post -->
					<div class="ribbon">
						<div class="wrapAround"></div>
						<div class="tab">
							<?php
							if (get_theme_var('postsShowDate') !== '' ) {
								echo '<span class="blogDate">'. get_the_time('d') .' '. get_the_time('M') .'</span>';
							} ?>
							<span class="blogPostInfo">
								<?php
								if (get_theme_var('postsShowAuthor') !== '' ) { ?>
									Posted by <?php the_author_posts_link(); ?>  in
									<?php 
								} ?>
								<?php the_category(', ') ?> | <?php comments_popup_link(__('Comments',THEMENAME ), __('1 comment',THEMENAME ), __('% comments',THEMENAME )); ?>
							</span>
						</div>
					</div>
					<div class="blogPostSummary">
						<a href="<?php echo get_permalink(); ?>"><h1><?php the_title(); ?></h1></a>
						<?php
						if ( $postImg['showImage'] ) {
							// Only print the image if we have one (because pages won't have images...)
							?>
							<div class="blogPostImage">
								<a href="<?php echo get_permalink(); ?>" class="img"><?php echo $postImg['full']; ?></a>
							</div>
							<?php
						}
						?>
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
					 <p><?php _e('No results found for',THEMENAME ) ?>: "<?php echo $s; ?>"</p>
				<?php endif; ?>
				
				</div> <!-- end  <div class="two-thirds"> -->
				
				<div class="one-third">
				
					<?php get_sidebar(); ?>
				
				</div>
				
				<!-- End of Content -->
				<div class="clear"></div>
			</div>

<?php get_footer(); ?>