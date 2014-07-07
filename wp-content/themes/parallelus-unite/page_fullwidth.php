<?php
/*
Template Name: Full Page (No Sidebar)
*/
?>
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

			<!-- Full Page Content -->
			<div class="contentArea">

				<!-- Title / Page Headline -->
				<div class="full-page">
					<h1 class="headline"><strong><?php the_title(); ?></strong><?php echo $subTitle; ?></h1>
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
			
			if (have_posts()) : 
			while (have_posts()) : the_post();		
				
			?>
			<!-- Content -->
			<div class="contentArea">
				<div class="full-page">

					<!-- Page Text and Main Content -->
					<?php the_content(__('More Information',THEMENAME ).'...'); ?>
					<!-- End of Content -->
					<div class="clear"></div>
		
				</div>
				
				<!-- End of Content -->
				<div class="clear"></div>
				
			</div>

			<?php 
			endwhile;
			endif; 
			?>


<?php get_footer(); ?>