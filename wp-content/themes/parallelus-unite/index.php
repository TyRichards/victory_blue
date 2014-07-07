<?php get_header(); ?>

		  <?php 
		  $postIndex = true; // special case variable for index paging bug		  
		  
		  // setup the showcase
		  if (get_theme_var('showcaseColumns') !== '' && get_theme_var('showcaseColumns') !== 'off') {
		  	
			// get default settings
			parse_str(get_theme_var('showcaseColumns', 'showcase_left=true&showcase_right=true'), $showcaseAreas);
			$showcaseColumns = count($showcaseAreas);
			$showcaseClass1 = "two-thirds";
			
			// update 1st column class
			if ($showcaseColumns == 3) {
				$showcaseClass1 = "one-third";
			} elseif ($showcaseColumns == 1) {
				$showcaseClass1 = "full-page";
			}
			?>
			
			<!-- Showcase Content -->
			<div id="Showcase">
				<div class="<?php echo $showcaseClass1 ?> showcase-area-left">
				  <?php 
				  if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home - Showcase Left')) : 
				  	echo '<h1 class="title">'.__('Left Showcase',THEMENAME).'</h1><p>'.__('Populate this area from the &quot;Appearance &raquo; Widgets&quot; section of your admin.',THEMENAME).'</p>';
				  endif; 
				  ?>
				</div>
				
			  <?php 
			  	// Middle showcase column
			  	if ($showcaseColumns == 3) echo '<div class="one-third  showcase-area-middle">';
				if ( $showcaseColumns == 3 && (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home - Showcase Middle')) ) : 
					echo '<h1 class="title">'.__('Middle Showcase',THEMENAME).'</h1><p>'.__('Populate this area from the &quot;Appearance &raquo; Widgets&quot; section of your admin.',THEMENAME).'</p>';
				endif; 
			  	if ($showcaseColumns == 3) echo '</div>';
			  ?>
				
			  <?php 
				// Middle showcase column
				if ($showcaseColumns >= 2) echo '<div class="one-third  showcase-area-right">';
				if ( $showcaseColumns >= 2 && (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Home - Showcase Right')) ) : 
					echo '<h1 class="title">'.__('Right Showcase',THEMENAME).'</h1><p>'.__('Populate this area from the &quot;Appearance &raquo; Widgets&quot; section of your admin.',THEMENAME).'</p>'; 
				endif; 
				if ($showcaseColumns >= 2) echo '</div>';
			  ?>
				
				<!-- End of Content -->
				<div class="clear"></div>
						
				<div class="hr"></div>
				
			</div>
			<?php
		  } // end if (showcaseColumns !== '') ?>
			
			<!-- Page Content -->
			<div class="contentArea">
			
				<div class="two-thirds">
					
				<?php 
				if (get_theme_var('homePageHeadline') !== '' && $paged <= 1) { ?>
					<!-- Page Headline -->
					<h1 class="headline"><?php echo stripslashes(get_theme_var('homePageHeadline')); ?></h1>
					<?php
				} // end if (homePageHeadline)
				if (get_theme_var('homePageMessage') !== '' && $paged <= 1) { ?>
					<!-- Welcome Message -->
					<p class="impact"><?php echo stripslashes(get_theme_var('homePageMessage')); ?></p>
					<?php
				} //end if (homePageMessage)
				?>
	
				<?php
				
				// Featured Content	(only show if active and no paging has taken place)
				if (get_theme_var('featuredContentActive') !== '' && $paged <= 1) { 
				
					// Featured Content settings
					$featuredTitle = get_theme_var('featuredContentTitle', __('Featured Content',THEMENAME));
					$featuredCount = get_theme_var('featuredContentCount', '4');
					
					// Excluded categories
					$excludeCategories = '';
					$excludeCategories = get_theme_var('blogCategoriesMenuExclude');
					?>

					<!-- Featured Content -->
					<div class="ribbon">
						<div class="wrapAround"></div>
						<div class="tab">
							<span><?php echo $featuredTitle ?></span>
						</div>
					</div>
		
					<div class="featuredContent">
	
					<?php
					// Featured posts pulled from stickies
					$sticky = get_option('sticky_posts');	/* Get only sticky posts */
					rsort($sticky );						/* Sort the stickies with the newest ones at the top */

					if ($featuredCount == 'all') {
						$args = array( 'post__in' => array_slice($sticky, 0), 'caller_get_posts' =>1, 'showposts'=>-1, 'exclude'=>$excludeCategories  );									
					} else {
						$args = array( 'post__in' => array_slice($sticky, 0, $featuredCount), 'caller_get_posts' => 1, 'showposts'=>$featuredCount, 'category__not_in'=>$excludeCategories );									
					}
					
					query_posts( $args );	/* Query sticky posts */
					
					if (have_posts()) : 
						while (have_posts()) : the_post(); 
	
							// get the post image
							$postImg = showImage(148, 78, get_the_title(), 'small');
							
							// strip domain, use local path to image
							$UrlParts = parse_url($postImage);
							$postImage = $UrlParts['path'];
				
							?>
	
							<!-- Featured Item -->
							<div class="featuredItem">
								<?php
								if ( $postImg['showImage'] ) { ?>
									<a href="<?php echo get_permalink() ?>" class="featuredImg img"><?php echo $postImg['full']; ?> </a>
								<?php } ?>
								<div class="featuredText">
									<h1 class="title" onclick="document.location.href='<?php echo get_permalink(); ?>'" style="cursor:pointer;">
										<?php the_title(); ?>
										<span><?php the_content_rss('...', TRUE, '', 14); //the_content(); //the_excerpt(); ?></span>
									</h1>
									<a href="<?php echo get_permalink(); ?>"><?php _e('More Information',THEMENAME ); ?>...</a>
								</div>
								<div class="clear"></div>
							</div>
							
							<?php 
						endwhile; 
					else : 
						echo '<p>'.__('There are no featured posts selected to display in this area (yet).',THEMENAME).'</p>';
					endif; 
					
					//Reset Query
					wp_reset_query();
					?>
						
						<!-- End of Content -->
						<div class="clear"></div>
	
					</div> <!-- End featured posts -->
					<?php
				} // end if( featuredContentActive != '') 
				?>
					
				<?php
				
				// Home Page Blog Posts
				if (get_theme_var('homePostsActive') !== '') { ?>
				
					<!-- Recent Blog Posts -->
					<?php
					global $firstPage;
					$firstPage = true;
					
					if ($paged > 1) {
						// filter for offset and proper paging
						add_filter('post_limits', 'my_post_limit'); 
						// modify paging (to work with offset for home page)
						$paged = $paged-1;
						$firstPage = false;
					}
					
					// Excluded categories
					$excludeCategories = '';
					$excludeCategories = get_theme_var('blogCategoriesMenuExclude');
					
					// Recent Posts on Home Page
					$sticky = get_option('sticky_posts'); /* get sticky post list (to exclude)  */
					$homePostCount = get_theme_var('homePostsCount','2');
					
					global $myOffset;
					$myOffset = $homePostCount;
					$temp = $wp_query;
					$wp_query = null;
					$wp_query = new WP_Query();
										
					if (!$firstPage) {
						// change the query for paging, and offest for homepage
						$wp_query->query(array('caller_get_posts'=>1, 'showposts'=>intval(get_option('posts_per_page')), 'offset'=>$myOffset, 'post__not_in'=> $sticky, 'paged'=>$paged, 'category__not_in'=>$excludeCategories ));
					} else {
						// default query on home page
						$wp_query->query(array('caller_get_posts'=>1, 'showposts'=>$homePostCount, 'post__not_in'=> $sticky, 'category__not_in'=>$excludeCategories ));
					}

					// loop
					while ($wp_query->have_posts()) : $wp_query->the_post();

	
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
											<?php _e('Posted by ',THEMENAME) ?><?php the_author_posts_link(); _e(' in ',THEMENAME ) ?>
											<?php 
										} ?>
										<?php the_category(', ') ?> | <?php comments_popup_link(__('Comments',THEMENAME ), __('1 comment',THEMENAME ), __('% comments',THEMENAME )); ?>
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
								<p><a href="<?php echo get_permalink(); ?>"><?php _e('Read more',THEMENAME) ?>...</a></p>
							</div>
												
							<?php 
					endwhile;

					//paging;
					get_pagination();
					
					if (!$firstPage) {
						// remove filter for offset
						$wp_query = null; $wp_query = $temp;
						remove_filter('post_limits', 'my_post_limit');
					}
				} // end if ( homePostsActive )
				?>
				
				</div>
				
				<div class="one-third">
									
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Sidebar')) : endif; ?>
	
				</div>
				
				<!-- End of Content -->
				<div class="clear"></div>
			
			</div>
<?php get_footer(); ?>