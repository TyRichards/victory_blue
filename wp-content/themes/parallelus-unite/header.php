<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<?php global $cssPath, $themePath; ?>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="author" content="Parallelus" />
	<title><?php
	if (is_home()) { bloginfo('name'); echo " - "; bloginfo('description'); }
	elseif (is_category() || is_tag()) { single_cat_title(); }
	elseif (is_single() || is_page()) { single_post_title(); }
	elseif (is_search()) { _e('Search Results', THEMENAME); echo " ".wp_specialchars($s); }
	else { echo trim(wp_title(' ',false)); }
	if (!is_home()) { theme_var('appendToPageTitle'); }
	?></title>

	<!-- Feed link / Pingback link -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- Favorites icon -->
	<link rel="shortcut icon" href="<?php if (get_theme_var('favicon')) : theme_var('favicon'); else: echo 'http://para.llel.us/favicon.ico'; endif; ?>" />
	
	<!-- Style sheets -->
	<link rel="stylesheet" type="text/css" href="<?php echo $cssPath ?>css/base.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $cssPath ?>style-default.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $cssPath ?>css/font-awesome.min.css" />
	<?php 
	// Tool Tips CSS
	if (get_theme_var('toolTipsActive') !== '' || get_theme_var('toolTipsAllTitles') == true) {
		echo '<link rel="stylesheet" type="text/css" href="'. $cssPath .'css/tooltip.min.css" />';
	}
		
	// Skin CSS include (selected in theme options)
	if (get_theme_var('skinName')) { 
		if (get_theme_var('skinName') == 'custom' && get_theme_var('custom_skin')) {
			$skinCSS = get_theme_var('custom_skin') .'.css';
		} else {
			$skinCSS = 'style-skin-'. get_theme_var('skinName') .'.css';
		}
		echo '<!-- Skin Style Sheet -->';
		echo '<link rel="stylesheet" href="'. $cssPath . $skinCSS .'" type="text/css" id="SkinCSS" />';
	}
	
	// Includes the jQuery framework
	if( !is_admin()){
		wp_deregister_script('jquery');
		wp_register_script('jquery', ($themePath ."js/jquery-1.4.min.js"), false, '1.4.2');
		wp_enqueue_script('jquery');
	}
	
	// calls hook to WordPress head functions
	wp_head(); 
	?>
	
	<!-- jQuery utilities -->
	<script type="text/javascript">
		var themePath = '<?php echo $themePath; ?>'; // for js functions 
		var blogPath = '<?php bloginfo('url'); ?>'; // for js functions 
	</script>
	<script type="text/javascript" src="<?php echo $themePath ?>js/base.js"></script>
	<?php 
	// Tool Tips JavaScript
	if (get_theme_var('toolTipsActive') !== '' || get_theme_var('toolTipsAllTitles') == true) {
		echo '<!-- Tooltips -->';
		echo '<script type="text/javascript" src="'. $themePath .'js/toolTipOptions.min.js"></script>';
		?>
		<script type="text/javascript">
		  jQuery(document).ready(function($) {
			// select items to apply tooltip function
			$('.tip').cluetip({showtitle: false, arrows: true, splitTitle: '|'});
			$('.tipInclude').cluetip({attribute: 'rel', showtitle: false, arrows: true}); // external file indluded tips
			<?php 
			if (get_theme_var('toolTipsAllTitles') == true) { ?>
				$('a[title != ""]').each( function() {
					// don't apply to any links in the drop down menu or side navigation (due to display errors)
					if ( !jQuery(this).parents('.sf-menu').length && !jQuery(this).parents('.sideNav').length ) {
						jQuery(this).cluetip({showtitle: false, arrows: true, splitTitle: '|'});
					}
				});
			<?php 
			} ?>
		  });
		</script>
		<?php
	}
	?>
	
	<?php 
	// Ribbon Scroll Effect
	if (get_theme_var('ribbonScrollActive') !== '') {
		echo '<!-- Ribbon Scroll Effect -->';
		echo '<script type="text/javascript" src="'. $themePath .'js/ribbonScroll.js"></script>';
	}
	?>
	<!-- Input labels -->
	<script type="text/javascript" src="<?php echo $themePath ?>js/jquery.overlabel.min.js"></script>

	<?php 
	// Anchor tag scrolling "smooth scroll" or "scrollTo"
	if (get_theme_var('anchorScrollingActive') !== '') {
		echo '<!-- Anchor tag scrolling effects -->';
		echo '<script type="text/javascript" src="'. $themePath .'js/scrollTo.min.js"></script>';
		?>
		<script type="text/javascript">
		  jQuery(document).ready(function() {
			// initialize anchor tag scrolling effect (scrollTo)
			$j.localScroll();
		  });
		</script>
		<?php
	}
	?>
	<!-- Inline popups/modal windows -->
	<script type="text/javascript" src="<?php echo $themePath ?>js/jquery.fancybox-1.3.1.pack.js"></script>
	
	<?php
	
// setup slide show
if (theme_var('slideShowDisabled', 'return') != true && is_home()) {

		
	// slide change speed
	if (theme_var('slideShowTimeout', 'return')) {
		$ss_timeout = theme_var('slideShowTimeout', 'return');
	} else {
		$ss_timeout = '0';
	}

	
	echo '<!-- Slide show -->';
			
	if (theme_var('slideShowType', 'return') == 'galleryView') {

		// output the javascript for the Galler View slide show ?>
		
		<!-- Gallery View Slide Show -->
		<script type="text/javascript" src="<?php echo $themePath ?>js/galleryview/jquery.timers-1.1.2.js"></script>
		<script type="text/javascript" src="<?php echo $themePath ?>js/galleryview/jquery.galleryview-2.0-pack.js"></script>
		<script type="text/javascript">
			// initialize slideshow (Gallery View)
			jQuery(document).ready(function() {
				if ($j('#GalleryView').length > 0) {
					$j('#GalleryView').galleryView({
						show_panels: true,
						show_filmstrip: true,
						panel_width: 938,
						panel_height: 340,
						frame_width: 87,
						frame_height: 45,
						frame_gap: 8,
						pointer_size: 16,
						pause_on_hover: true,
						filmstrip_position: 'bottom',
						overlay_position: 'bottom',
						nav_theme: 'dark',
						transition_speed: 800,
						transition_interval: <?php echo $ss_timeout . '000'; ?>
					});
				}
			});
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo $cssPath ?>css/galleryview.min.css" />
		
		<?php
	} else {
	
		// output the javascript for the Cycle Plug-in (Default) 
		
		echo '<!-- Cycle Slide Show -->';
		if (!$jQueryCycle) {
			echo '<script type="text/javascript" src="'. $themePath .'js/jquery.cycle.all.min.js"></script>';
			$jQueryCycle = true; // plug-in included (prevents 2nd include by dynamic skin changer)
		}
		
		?>
		<script type="text/javascript">
			// initialize slideshow (Cycle)
			jQuery(document).ready(function() {
				if ($j('#Slides').length > 0) {
					$j('#Slides').cycle({ 
						fx: <?php
							// slide transitions
							$the_slides = $GLOBALS['_SS_ItemLevels'];
							$the_transitions =  $GLOBALS['_SS_ItemValues'];
							if (is_array($the_slides)) {
								$slide_count = 0;
								echo "'";
								foreach($the_slides as $value) {
									$id = $value['id'];
									if ($slide_count>0) { echo ','; }
									echo $the_transitions['ss-'. $id .'-slideTransition'];
									$slide_count++;
								}
								echo "',";
							} else {
								echo "'scrollHorz',";
							}
							?>
						speed: 750,
						timeout:  <?php echo $ss_timeout . '000'; ?>, 
						randomizeEffects: false, 
						easing: 'easeOutCubic',
						next:   '.slideNext', 
						prev:   '.slidePrev',
						pager:  '#slidePager',
						cleartypeNoBg: true,
						before: function() {
							// reset the overlay for the next slide
							$j('#SlideRepeat').css('cursor','default').unbind('click'); },
						after: function() {
							// get the link and apply it to the overlay
							var theLink = $j(this).children('a');
							var linkURL = (theLink) ? theLink.attr('href') : false;
							if (linkURL) {
								$j('#SlideRepeat').css('cursor','pointer').click( function() {
									document.location.href = linkURL;
								});
							}
						}
					});
				}
			});
		</script>
		<?php
	} // end if/else ( slideShowType == 'galleryView' ) 

} // end if ( slideShowActive ) ?>

	<!-- IE only includes (PNG Fix and other things for sucky browsers -->
	
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $cssPath ?>css/ie-only.css">
		<script type="text/javascript" src="<?php echo $themePath ?>js/pngFix.min.js"></script>
		<script type="text/javascript"> 
			jQuery(document).ready(function(){ 
				$j(document.body).supersleight();
			}); 
		</script> 
	<![endif]-->
	<!--[if IE]><link rel="stylesheet" type="text/css" href="<?php echo $cssPath ?>css/ie-only-all-versions.css"><![endif]-->
	
	<?php
	// Font Replacement
	if (get_theme_var('fontReplacement', 1) != false) : ?>
		<!-- Font replacement (cufon) -->
		<script src="<?php echo $themePath ?>js/cufon-yui.js" type="text/javascript"></script>
		<script src="<?php echo $themePath ?>js/LiberationSans.font.js" type="text/javascript"></script>
		<!-- Font Replacement Styles -->
		<script type="text/javascript">
			// general font replacement styles
			Cufon.replace('h1, h2, h3, h4, h5, h6, .fancy_title div');
			<?php 
			// some skin specific styling for cufon font replacement
			switch (get_theme_var('skinName','1')) {
				case '2':	// Skin 2
					echo "Cufon.replace('.headline', {textShadow: '1px 1px rgba(255, 255, 255, 1)'})('.ribbon span', {hover: true, textShadow: '-1px -1px rgba(238, 152, 15, 0.9)'});";
					break;
				case '3':	// Skin 3
					echo "Cufon.replace('.headline')('.ribbon span', {hover: true, textShadow: '-1px -1px rgba(0, 0, 0, 0.3)'});";
					break;
				case '4':	// Skin 4
					echo "Cufon.replace('.headline', {textShadow: '1px 1px rgba(255, 255, 255, 1)'})('.ribbon span', {hover: true, textShadow: '-1px -1px rgba(136, 78, 43, 0.6)'});";
					break;
				case 'custom':	// Add your own custom skin Cufon styling here...
					echo "";
					break;
				default:
				   echo "Cufon.replace('.headline', {textShadow: '1px 1px rgba(255, 255, 255, 1)'})('.ribbon span', {hover: true, textShadow: '-1px -1px rgba(0, 0, 0, 0.4)'});";
			}
			?>
			// enables cufon in popups and other modal functions
			function modalStart() {
				// updated styles
				jQuery('#fancybox-outer').addClass('rounded');
				roundCorners();
				// reload cufon
				Cufon.replace('#fancybox-title-main');
			}
		</script>
	<?php else: ?>
		<script type="text/javascript">
			function modalStart() {
				// updated styles
				jQuery('#fancybox-outer').addClass('rounded');
				roundCorners();
			}
		</script>
	<?php endif; ?>


	<!-- Functions to initialize after page load -->
	<script type="text/javascript" src="<?php echo $themePath ?>js/onLoad.js"></script>

    <!-- Calculator Functions -->
	<script type="text/javascript" src="<?php echo $themePath ?>js/calculator_page.js"></script>
    	<script type="text/javascript" src="<?php echo $themePath ?>js/dump.js"></script>
        
        <script type="text/javascript" src="<?php echo $themePath ?>js/mapactions.js"></script>
          <script type="text/javascript" src="<?php echo $themePath ?>js/easing.js"></script>

	
    <script type="text/javascript">
	

	
	</script>
    
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30404629-1']);
  _gaq.push(['_setDomainName', 'govictoryblue.com']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body>

<!-- Top reveal (slides open, add class "topReveal" to links for open/close toggle ) -->
<div id="ContentPanel">

	<!-- close button -->
	<a href="#" class="topReveal closeBtn">Close</a>
	
	<div class="contentArea">
	  <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Slide Open Top')) : ?>
		<!-- New member registration -->
		<div class="right" style="margin:10px 0 0;">
			<h1>
				<?php _e("Don't have a login?",THEMENAME ); ?>
				<span><?php _e('Register now to order Victory Blue.',THEMENAME ); ?></span>
			</h1>
			<button type="button" onclick="document.location.href='<?php bloginfo('url'); ?>/?page_id=14'"><?php _e('Register for Access',THEMENAME ); ?></button>
		</div>
		
		<!-- Alternate Login -->				
		<div>
			<form class="loginForm" method="post" action="/wp-login.php" style="height:auto;">
				<div id="loginBg"><img src="<?php echo $themePath ?>images/icons/lock-and-key-110.png" width="110" height="110" alt="lock and key" /></div>
				<h2 style="margin-top: 20px;"><?php _e('Online Ordering Login',THEMENAME ); ?></h2>
				<fieldset>
					<legend>Account Login</legend>
					<p class="left" style="margin: 0 8px 0 0;">
						<label for="RevealUsername" class="overlabel"><?php _e('Username',THEMENAME ); ?></label>
						<input id="RevealUsername" name="log" type="text" class="loginInput textInput rounded" />
					</p>
					<p class="left" style="margin: 0 5px 0 0;">
						<label for="RevealPassword" class="overlabel"><?php _e('Password',THEMENAME ); ?></label>
						<input id="RevealPassword" name="pwd" type="password" class="loginInput textInput rounded" />
					</p>
					<p class="left" style="margin: -3px 0 0;">
						<button type="submit" class="btn" style="margin:0;"><span><?php _e('Sign in',THEMENAME ); ?></span></button>
					</p>
				</fieldset>
				<p class="left noMargin">
					<a href="<?php bloginfo('url'); ?>/wp-login.php?action=lostpassword"><?php _e('Forgot your password?',THEMENAME ); ?></a>
				</p>
			</form>		
		</div>
		<!-- End of Content -->
		<div class="clear"></div>
	  <?php endif; ?>
	
	</div>
 	<!-- End of Content -->
	<div class="clear"></div>
</div>

<!-- Site Container -->
<div id="Wrapper">
	<div id="PageWrapper">
		<div class="pageTop">
        	<div class="contact-info">
	            <!-- <a href="http://g.co/maps/hgjk3">1670 Keller Parkway, Suite 247 Keller, TX 76248</a> -->
	            <a href="tel:817-431-9894">(817) 337-3311</a>						
				<a href="https://www.facebook.com/pages/Victory-Blue-DEF/231252883587702" target="_blank" title="Facebook"><i class="fa fa-facebook-square fa-2x"></i></a>
				<a href="https://twitter.com/victoryblue_def" target="_blank" title="Twitter"><i class="fa fa-twitter-square fa-2x"></i></a>
				<a href="https://plus.google.com/+GovictoryblueDEF" target="_blank" title="Google Plus"><i class="fa fa-google-plus-square fa-2x"></i></a>
				<a href="https://www.linkedin.com/company/1130377" target="_blank" title="LinkedIn"><i class="fa fa-linkedin-square fa-2x"></i></a>
				<a href="https://www.youtube.com/VictoryBlueDEF" target="_blank" title="YouTube"><i class="fa fa-youtube-square fa-2x"></i></a>
	            <!-- <span id="subscriber"><?php // echo do_shortcode("[subscribe2]"); ?></span> -->
            </div>
            <div class="call-to-action">
            	<a class="btn-primary" href="/distributors">Become a Distributor</a>
            	<a class="btn-primary" href="/consumers">Buy Victory Blue</a>
            </div>
        </div>
		<div id="Header">
		
	
			<!--
			<div id="HeaderRight">
			  <?php //if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Header')) : ?>
			  
			  <div id="Search">
				<form action="<?php //bloginfo('home'); ?>" id="SearchForm" method="get">
					<p style="margin:0;"><input type="text" name="s" id="SearchInput" value="<?php //echo $_GET['s']; ?>" /></p>
					<p style="margin:0;"><input type="submit" id="SearchSubmit" class="noStyle" value="" /></p>
				</form>
			  </div>
			  <?php //endif; ?>
			</div>
            -->
			
			<!-- Logo -->
			<?php 
				if (theme_var('logoImage','return')) {
					$themeLogo = '<a href="'. get_bloginfo('url') .'" style="background-image:none; width:auto; height:auto;"><img src="'. theme_var('logoImage','return') .'" alt="'. get_bloginfo('name') .'" /></a>';
				} else {
					$themeLogo = '<a href="'. get_bloginfo('url') .'"></a>';
				}
			?>
			<div id="Logo">				         
				<?php echo $themeLogo; ?>
			</div>
			<div class="victory-with-valvoline">
				<a href="http://victorywithvalvoline.com" target="blank" alt="Victory With Valvoline"><img class="vwv" src="<?php bloginfo('url'); ?>/images/victory-with-valvoline.png"/></a>
			</div>
            <div class="side-box">
	            <a href="http://www.api.org/" target="blank" alt="API Certified"><img class="api" src="<?php bloginfo('url'); ?>/images/api-logo.png"/></a>
	            <a href="http://en.wikipedia.org/wiki/Selective_catalytic_reduction" target="blank" alt="For use with SCR Engines"><img class="src" src="<?php bloginfo('url'); ?>/images/scr-logo.png"/></a>
            </div>   			
			
			<!-- End of Content -->
			<div class="clear"></div>
            
            
            
            		<!-- Main Menu -->
			<div id="MenuWrapper">
				<div id="MainMenu">
					<!--<div id="MmLeft"></div>-->
						
						<!-- Main Menu Links -->
						<?php 
						if ( version_compare( get_bloginfo('version'), '3.0', '>=' ) ) {
							// If using WP 3 or later enable WP Menus
							wp_nav_menu( array( 'container_id' => 'MmBody', 'menu_class' => 'sf-menu', 'theme_location' => 'primary' ) );
						} else { 
							// Older versions of WP use the theme options menu manager
							?>
							<div id="MmBody">
								<ul class="sf-menu">
									<li class="<?php if (is_home()) : echo 'current'; endif; ?>"><a href="<?php bloginfo('url'); ?>">Home</a></li>
									<?php printMenuItems(); ?>
								</ul>
							</div>
							<?php						
						} ?>
						
				
				</div>
			</div>
            
            	<div class="clear"></div>
		
		</div>

<?php
if (theme_var('slideShowDisabled', 'return') != true && is_home()) {
	
	if (theme_var('slideShowType', 'return') == 'galleryView') {

		// output the javascript for the Galler View slide show ?>

		<!-- Slide show: jQuery GalleryView -->
		<div id="SlideShow-GalleryView">
			<ul id="GalleryView">
				<?php printSlideShowItems(); ?>
			</ul>
		</div>

		<?php
		
	} else {
	
		// output the javascript for the Cycle Plug-in (Default) ?>	

		<!-- Slide show: jQuery Cycle (default) -->
		<div id="Slideshow">
			<div id="SlideTop"></div>
			<div id="SlideRepeat"></div>
			<div id="SlideBottom"></div>
			<div id="Slides">
				<?php printSlideShowItems(); ?>
			</div>
			<a href="#" class="slidePrev"></a>
			<a href="#" class="slideNext"></a>
			<div id="slidePager"></div>
		</div>
		
		<?php
	} // end if/else ( slideShowType == 'galleryView' ) 

} // end if ( slideShowActive ) ?>
		
		<div class="pageMain">