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
			<div class="contentArea pageContent">
			
				<div class="two-thirds">
				<?php 
				if (have_posts()) : 
				while (have_posts()) : the_post();	

					?>
					<!-- Title / Page Headline -->
					<h1 class="headline"><strong><?php the_title(); ?></strong><?php echo $subTitle; ?></h1>
					
					<div class="hr"></div>

					<?php if (!$hideBreadcrumbs) : ?>
						<!-- Breadcrumbs -->
						<p class="breadcrumbs"><?php show_breadcrumbs(); ?></p>
					<?php endif; ?>

					<!-- Page Text and Main Content -->
					<?php the_content(__('More Information',THEMENAME ).'...'); ?>
					<!-- Post Extras -->
					<div class="postFooter">
						<?php edit_post_link('Edit','<p class="postEdit">','</p>'); ?>
					</div>

					<!-- End of Content -->
					<div class="clear"></div>

					<?php 
				endwhile; 
				endif; ?>
				</div> <!-- end  <div class="two-thirds"> -->
								
				<div class="one-third">
				
					<?php get_sidebar(); ?>
				
				</div>
				
				<!-- End of Content -->
				<div class="clear"></div>
			</div>
			
<?php get_footer(); ?>