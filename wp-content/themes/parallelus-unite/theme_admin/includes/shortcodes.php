<?php
#==================================================================
#
#	Shortcode functions for theme
#
#==================================================================


#-----------------------------------------------------------------
# Default functions
#-----------------------------------------------------------------

// Assign memory limit (set higher limit with extended content: http://core.trac.wordpress.org/ticket/8553)
@ini_set('pcre.backtrack_limit', 500000);


// Enable shortdoces in sidebar default Text widget
//...............................................
add_filter('widget_text', 'do_shortcode');


// Remove WordPress automatic formatting
//...............................................
function shortcode_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}
/* Disable main auto-formatters */
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

/* Run formatter on content */
add_filter('the_content', 'shortcode_formatter', 99);



#-----------------------------------------------------------------
# Images
#-----------------------------------------------------------------

// Images with overlay
//...............................................
function theme_styled_image( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'size' => 'medium',
		'align' => '',
		'link' => '',
		'icon' => '',
		'lightbox' => '',
		'alt' => 'image'
	), $atts));

	// get the image path
	$src = do_shortcode(strip_tags($content));	// strip_tags incase editor auto-created <a href="..."></a> on image URL
	
	// size specific image and options
	switch ($size) {
		case "small":
			$img = theme_plain_image(array('w'=>148,'h'=>78,'alt'=>$alt), $src);
			$class = 'img';
			break;
		case "blog": case "large":	// blog or large
			$img = theme_plain_image(array('w'=>556,'h'=>133,'alt'=>$alt), $src);
			$class = 'img';
			break;
		default:	// medium (default)
			$img = theme_plain_image(array('w'=>216,'h'=>174,'alt'=>$alt), $src);
			$class = 'img';
			break;
	}
		
	// class options for lightbox
	if ($lightbox) { 
		$class .= ' zoom'; 	
		// if no link - open original image and add icon
		if (!$link)	{
			$link =  $src;
			//$class .= ' iconZoom';
		}	
	}
	
	// class options for alignment
	if ($align) { $class .= ' '. $align; }

	// class options for hover icon
	if ($icon == 'image' || $icon == 'enlarge' || $icon == 'zoom') { $class .= ' iconZoom'; }
	
	// image container
	if ($link) {
		$styledImage = '<a href="'. $link .'" class="'. $class .'" title="'. $alt .'">'. $img .'</a>';
	} else {
		$styledImage = '<div class="'. $class .'">'. $img .'</div>';	
	}

	return $styledImage;					
}
add_shortcode('styled_image', 'theme_styled_image');


// Resized Image
//...............................................
function theme_plain_image( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'w' => '',			// width
		'h' => '',			// height
		'zc' => '',			// zoom = 0, crop = 1
		'q' => '',			// quality (optional 0-100)
		'alt' => 'image',	// alt text for image tag
		'resize' => '1'		// use timthumb?
	), $atts));

	$src = do_shortcode(strip_tags($content));	// strip_tags incase editor auto-created <a href="..."></a> on image URL

	// check resize option
	if ($resize == true ||$resize == 'true' || $resize == '1' || $resize == 'Yes' || $resize == 'yes' ) {
		if ($w) : $arr['w'] = $w; endif;
		if ($h) : $arr['h'] = $h; endif;
		if ($zc) : $arr['zc'] = $zc; endif;
		if ($q) : $arr['q'] = $q; endif;
		$src = theme_resized_image_path($arr,$src);
	}
	
	// final image tag
	$img = '<img src="'. $src .'" width="'. $w .'" height="'. $h .'" alt="'. $alt .'" />';

	return $img;
	
}
add_shortcode('plain_image', 'theme_plain_image');


// SRC for Resized Image (image in timthumb path)
//...............................................
function theme_resized_image_path( $atts, $content = null ) {
	global $themePath;

	extract(shortcode_atts(array(
		'w' => '250',	// width
		'h' => '160',	// height
		'zc' => '1',	// zoom = 0, crop = 1
		'q' => ''		// quality (optional 0-100)
	), $atts));

	$img = do_shortcode(strip_tags($content));	// strip_tags incase editor auto-created <a href="..."></a> on image URL
	$q = ($q) ? '&amp;q='. $q : '';
	
	// strip domain, use local path to image
	$UrlParts = parse_url($img);
	$img = $UrlParts['path'];

	// full image SRC
	$src = $themePath .'includes/timthumb.php?src='. $img .'&amp;w='. $w .'&amp;h='. $h .'&amp;zc='. $zc . $q;
	
	return $src;
	
}
add_shortcode('resized_image_path', 'theme_resized_image_path');



#-----------------------------------------------------------------
# Buttons
#-----------------------------------------------------------------

// Button Function
//...............................................
function theme_button_for_forms( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'title'		=> '',
		'class'		=> '',
		'id'		=> '',
		'onclick'	=> '',
		'name'		=> '',
		'value'		=> '',
		'type'		=> 'button'
    ), $atts));
	
	// variable setup
	$title = ($title) ? ' title="'.$title .'"' : '';
	$id = ($id) ? ' id="'.$id .'"' : '';
	$name = ($name) ? ' name="'.$name .'"' : '';
	$onclick = ($onclick) ? ' onclick="'.$onclick .'"' : '';
	$value = ($value) ? ' value="'.$value .'"' : '';

	// code
	$button = '<button' .$value. ' '. $name .' ' .$id. ' ' .$onclick. ' class="btn ' .$class. '" type="'. $type .'" ><span>' .do_shortcode($content). '</span></button>';
    
    return $button;
}

// Add shortcode
//...............................................
add_shortcode('button_for_forms', 'theme_button_for_forms');


// Button as Link Function
//...............................................
function theme_button_with_link( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'url'		=> '#',
		'target'	=> '',
		'title'		=> '',
		'class'		=> '',
		'id'		=> '',
		'onclick'	=> ''
    ), $atts));
	
	// variable setup
	$title = ($title) ? ' title="'.$title .'"' : '';
	$class = ($class) ? ' '.$class : '';
	$onclick = ($onclick) ? ' onclick="'.$onclick .'"' : '';

	// target setup
	if		($target == 'blank' || $target == '_blank' || $target == 'new' )	{ $target = ' target="_blank"'; }
	elseif	($target == 'parent')	{ $target = ' target="_parent"'; }
	elseif	($target == 'self')		{ $target = ' target="_self"'; }
	elseif	($target == 'top')		{ $target = ' target="_top"'; }
	else	{ $target = ''; }

	$button = '<a' .$target. ' ' .$onclick. '  ' .$title. ' class="btn' .$class. '" id="' .$id. '" href="' .$url. '"><span>' .do_shortcode($content). '</span></a>';
    
    return $button;
}

// Add shortcode
//...............................................
add_shortcode('button_with_link', 'theme_button_with_link');



#-----------------------------------------------------------------
# Text Formatting
#-----------------------------------------------------------------

// Heading
//...............................................
function theme_heading( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'h' => '1'
    ), $atts));

	if		($h == '2')	{	$content = '<h2>'. do_shortcode($content) .'</h2>';	}
	elseif	($h == '3')	{	$content = '<h3>'. do_shortcode($content) .'</h3>';	}
	elseif	($h == '4')	{	$content = '<h4>'. do_shortcode($content) .'</h4>';	}
	elseif	($h == '5')	{	$content = '<h5>'. do_shortcode($content) .'</h5>';	}
	elseif	($h == '6')	{	$content = '<h6>'. do_shortcode($content) .'</h6>';	}
	else	/* $h=1 */	{	$content = '<h1>'. do_shortcode($content) .'</h1>';	}
	
	return $content;
	
}
add_shortcode('heading', 'theme_heading');


// Headlines
//...............................................
function theme_headline( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'h' => '1'
    ), $atts));

	if		($h == '2')	{	$content = '<h2 class="headline">'. do_shortcode($content) .'</h2>';	}
	elseif	($h == '3')	{	$content = '<h3 class="headline">'. do_shortcode($content) .'</h3>';	}
	elseif	($h == '4')	{	$content = '<h4 class="headline">'. do_shortcode($content) .'</h4>';	}
	elseif	($h == '5')	{	$content = '<h5 class="headline">'. do_shortcode($content) .'</h5>';	}
	elseif	($h == '6')	{	$content = '<h6 class="headline">'. do_shortcode($content) .'</h6>';	}
	else	/* $h=1 */	{	$content = '<h1 class="headline">'. do_shortcode($content) .'</h1>';	}
	
	return $content;
	
}
add_shortcode('headline', 'theme_headline');


// Sub-Heading (sub-title)
//...............................................
function theme_sub_title( $atts, $content = null ) {
	return '<span class="subTitle">'. do_shortcode($content) .'</span>';
}
add_shortcode('sub_title', 'theme_sub_title');


// Ribbon heading
//...............................................
function theme_ribbon( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'toplink' => ''
    ), $atts));

	$ribbon = '<div class="ribbon"><div class="wrapAround"></div><div class="tab">';
	if ( $toplink == 'true' || $toplink == true ) {
		// add link to return to top of page
		$ribbon .= '<span class="scrollTop"><a href="#Wrapper">Top</a></span>';
	}
	$ribbon .= '<span>'. do_shortcode($content) .'</span></div></div>';
		
	return $ribbon;
	
}
add_shortcode('ribbon', 'theme_ribbon');



// Code (internall only)
//...............................................
function shortcode_code( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'class' => '',
    ), $atts));

	return '<pre class="code '.$class.'">[raw]'. $content .'[/raw]</pre>';
}
add_shortcode('code', 'shortcode_code');



#-----------------------------------------------------------------
# Lists
#-----------------------------------------------------------------

// Unordered Lists
//...............................................
function theme_bulleted_list( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'style' => '',
    ), $atts));

	$style = ($style) ? ' class="bullet-'. $style .'"' : '';
	$content = str_replace('<ul>', '<ul' .$style. '>', do_shortcode($content));
	
	return $content;
	
}
add_shortcode('bulleted_list', 'theme_bulleted_list');


// Ordered Lists
//...............................................
function theme_numbered_list( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'style' => 'number-pad',
    ), $atts));

	$style = ' class="'.$style. '"';
	$content = str_replace('<ol>', '<ol' .$style. '>', do_shortcode($content));
	
	return $content;
	
}
add_shortcode('numbered_list', 'theme_numbered_list');


#-----------------------------------------------------------------
# Content Dividers
#-----------------------------------------------------------------

function theme_hr( $atts ) {
   return '<div class="hr"></div>';
}
add_shortcode('hr', 'theme_hr');


function theme_clear( $atts ) {
   return '<div class="clear"></div>';
}
add_shortcode('clear', 'theme_clear');



#-----------------------------------------------------------------
# Page Layout Shortcodes
#-----------------------------------------------------------------

// Content Columns
//...............................................

function theme_one_third( $atts, $content = null ) {
	return '<div class="one-third">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_third', 'theme_one_third');


function theme_one_third_last( $atts, $content = null ) {
	return '<div class="one-third last">'. do_shortcode($content) .'</div><div class="clear"></div>';
}
add_shortcode('one_third_last', 'theme_one_third_last');


function theme_two_third( $atts, $content = null ) {
	return '<div class="two-thirds">'. do_shortcode($content) .'</div>';
}
add_shortcode('two_third', 'theme_two_third');


function theme_two_third_last( $atts, $content = null ) {
	return '<div class="two-thirds last">'. do_shortcode($content) .'</div><div class="clear"></div>';
}
add_shortcode('two_third_last', 'theme_two_third_last');


function theme_one_half( $atts, $content = null ) {
	return '<div class="half-page">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_half', 'theme_one_half');


function theme_one_half_last( $atts, $content = null ) {
	return '<div class="half-page last">'. do_shortcode($content) .'</div><div class="clear"></div>';
}
add_shortcode('one_half_last', 'theme_one_half_last');


function theme_one_fourth( $atts, $content = null ) {
	return '<div class="one-fourth">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_fourth', 'theme_one_fourth');


function theme_one_fourth_last( $atts, $content = null ) {
	return '<div class="one-fourth last">'. do_shortcode($content) .'</div><div class="clear"></div>';
}
add_shortcode('one_fourth_last', 'theme_one_fourth_last');



#-----------------------------------------------------------------
# Contact Form
#-----------------------------------------------------------------

// Contact shortcode function
//...............................................
function theme_contact_form($atts, $content = null) {
	global $themePath;
	
	// TO address
	$contact_email = get_theme_var('contactEmail', get_option('admin_email'));
	if($contact_email == "") { $contact_email = get_option('admin_email'); }
	
	// Subject
	$subject = get_theme_var('contactEmailSubject', 'Message From Website Contact Form');
	if ($subject == "") { $subject="Message From Website Contact Form"; }
	
	// Thank You Message
	$thankYouMsg = get_theme_var('contactThankYouMessage', 'Your message has been sent. Thank you!');
	if ($thankYouMsg == "") { $thankYouMsg = "Your message has been sent. Thank you!"; }

	// Shortcode variables (if blank use defaults)
	extract( shortcode_atts( array(
      'to' => $contact_email,
      'subject' => $subject,
	  'thankyou' => $thankYouMsg
      ), $atts ) );

	$return_content= '[raw]
	<script src="'. $themePath .'js/jquery.validate.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$("#CommentForm").validate({ submitHandler: function(form) {
						ajaxContact(form);	// form is valid, submit it
						return false;
					}
				});
			});
		</script>	
		<div id="FormResponse"></div>
		<form class="cmxform" id="CommentForm" method="post" action="">
			<fieldset>
				<legend>Contact Form</legend>
				<div>
					<label for="ContactName" class="overlabel">Name</label>
					<input id="ContactName" name="ContactName" class="textInput required" />
				</div>
				<div>
					<label for="ContactEmail" class="overlabel">E-Mail</label>
					<input id="ContactEmail" name="ContactEmail" class="textInput required email" />
				</div>
				<div>
					<label for="ContactPhone" class="overlabel">Phone</label>
					<input id="ContactPhone" name="ContactPhone" class="textInput digits" value="" />
				</div>
				<div>
					<label for="ContactComment" class="overlabel">Comments</label>
					<textarea id="ContactComment" name="ContactComment" class="textInput required" rows="10" cols="4"></textarea>
				</div>
				<div>
					<button type="submit" class="btn"><span>Send</span></button>
					<input class="" type="hidden" name="_R" value="'. strEnc($to) .'" />
					<input class="" type="hidden" name="_S" value="'. strEnc($subject) .'" />
					<label id="loader" style="display:none;"><img src="'.$themePath.'images/ajax-loader.gif" alt="Loading..." id="LoadingGraphic" /></label>
				</div>
			</fieldset>
		</form>';

	$return_content	.= "
		<script type='text/javascript'>  
			// Contact form submit function        
			function ajaxContact(theForm) {
		
				jQuery('#loader').fadeIn();

				var formData = jQuery(theForm).serialize(),
					msg = jQuery('#FormResponse');
		
				jQuery.ajax({
					type: 'POST',
					url: '".$themePath."/contact-send.php',
					data: formData,
					success: function(response) {
						( msg.height() ) ?	msg.fadeIn('fast', function() { jQuery(this).hide(); }) : msg.hide();
		
						jQuery('#LoadingGraphic').fadeOut('fast', function() {
							
							if (response === 'success') { 
								if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 9) { 
									// IE won't do the '.animate {opacity: 0}
									jQuery(theForm).css('visibility','hidden');
								}else {
									jQuery(theForm).animate({opacity: 0},'fast');
								}
							}
		
							// Message Sent? Show the 'Thank You' message and hide the form
							var result = response, c = 'error';
							if (response === 'success') { 
								result = \"".$thankyou."\";
								c = 'success';
							}
		
							msg.removeClass('success').removeClass('error').text('');
							var i = setInterval(function() {
								if ( !msg.is(':visible') ) {
									msg.html(result).addClass(c).slideDown('fast');
									clearInterval(i);
								}
							}, 40);    
						}); // end loading fade
					}
				});
	
				return false;
			}
		</script>[/raw]";
	
	return $return_content;
}


// Add shortcode
//...............................................
add_shortcode('contact_form','theme_contact_form'); 

?>