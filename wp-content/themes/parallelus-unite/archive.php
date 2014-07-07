<?php get_header(); 

			// breadcrumbs
			$hideBreadcrumbs = false;
			if ( $GLOBALS['globalBreadcrumbsOff'] ) {
				$hideBreadcrumbs = true;
			}

			?>

			<!-- Page Content -->
			<div class="contentArea">
			
				<div class="two-thirds">
				
					<!-- Title / Page Headline -->
					<h1 class="headline"><?php 
						$catTitle = single_cat_title(NULL, false);
						if (is_string(category_description())) {
							$catDesc = str_replace('</p>','',str_replace('<p>','',category_description()));
						}
						if (is_category()) { 
							if (!$catDesc) $catDesc = __('Browsing posts in ',THEMENAME ).$catTitle;
							printf('<strong>%s</strong> &nbsp;// %s', $catTitle, $catDesc);
						} elseif( is_tag() ) {
							$catTitle = single_tag_title(NULL, false);
							$catDesc = __('Posts tagged as "',THEMENAME ).$catTitle.'"';
							printf('<strong>%s</strong> &nbsp;// %s', $catTitle, $catDesc);
						} elseif (is_day()) {
							$catTitle = get_the_time(get_option('date_format'));
							$catDesc = __('Posts published on ',THEMENAME ).$catTitle;
							printf('<strong>%s</strong> &nbsp;// %s', $catTitle, $catDesc);
						} elseif (is_month()) {
							$catTitle = get_the_time('F, Y');
							$catDesc = __('Posts published in ',THEMENAME ).$catTitle;
							printf('<strong>%s</strong> &nbsp;// %s', $catTitle, $catDesc);
						} elseif (is_year()) {
							$catTitle = get_the_time('Y');
							$catDesc = __('Posts published in ',THEMENAME ).$catTitle;
							printf('<strong>%s</strong> &nbsp;// %s', $catTitle, $catDesc);
						} elseif (is_author()) {
							$currentAuthor = $wp_query->get_queried_object();
							$catTitle = $currentAuthor->display_name?$currentAuthor->display_name:$currentAuthor->nickname;
							$catDesc = __('Posts published by ',THEMENAME ).$catTitle;
							printf('<strong>%s</strong> &nbsp;// %s', $catTitle, $catDesc);
						} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { 
							printf('<strong>%s</strong>', __('Archives ',THEMENAME ));
						} ?>
					</h1>
					
					<div class="hr"></div>

					<?php if (!$hideBreadcrumbs) : ?>
						<!-- Breadcrumbs -->
						<p class="breadcrumbs"><?php show_breadcrumbs(); ?></p>
					<?php endif; ?>
					
				<?php 
				if (have_posts()) : 
				while (have_posts()) : the_post();
				
					// get the post image
					$postImg = showImage(556, 133, get_the_title(), 'blog');

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
								if (get_theme_var('postsShowAuthor') !== '' ) { 
									_e('Posted by ',THEMENAME ); the_author_posts_link(); _e(' in ',THEMENAME ); 
								} 
								 the_category(', ') ?> | <?php comments_popup_link(__('Comments',THEMENAME ), __('1 comment',THEMENAME ), __('% comments',THEMENAME )); ?>
							</span>
						</div>
					</div>
					<div class="blogPostSummary">
						<h1 onclick="document.location.href='<?php echo get_permalink(); ?>'" style="cursor:pointer;"><?php the_title(); ?></h1>
						<?php
						if ( $postImg['showImage'] ) { ?>
							<div class="blogPostImage">
								<a href="<?php echo get_permalink(); ?>" class="img"><?php echo $postImg['full']; ?></a>
							</div>
						<?php } ?>
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
								
				<div class="one-third">
				
					<?php get_sidebar(); ?>
				
				</div>
				
				<!-- End of Content -->
				<div class="clear"></div>
			</div>
	
<?php get_footer(); ?>