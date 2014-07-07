<?php
#==================================================================
#
#	Added functionality and custom functions for theme
#
#==================================================================


#-----------------------------------------------------------------
# Include Sidebars
#-----------------------------------------------------------------
include_once("sidebars.php");


#-----------------------------------------------------------------
# Include Metaboxes
#-----------------------------------------------------------------
include_once("metaboxes.php");


#-----------------------------------------------------------------
# Include Shortcodes
#-----------------------------------------------------------------
include_once('shortcodes.php');


#-----------------------------------------------------------------
# Include Editor Buttons
#-----------------------------------------------------------------
include_once('editor/load-buttons.php');


#-----------------------------------------------------------------
# Excerpt Functions
#-----------------------------------------------------------------

// Replace "[...]" in excerpt with "..."
//................................................................
function new_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'new_excerpt_more');


// Custom Length Excerpts
//................................................................
// 
// Usage:
// echo customExcerpt(get_the_content(), 30);
// echo customExcerpt(get_the_content(), 50);
// echo customExcerpt($your_content, 30);
//
//................................................................
function customExcerpt($excerpt = '', $excerpt_length = 50, $tags = '', $trailing = '...') {
	global $post;	
	$string_check = explode(' ', $excerpt);
 
	if (count($string_check, COUNT_RECURSIVE) > $excerpt_length) {
		$excerpt = strip_shortcodes( $excerpt );
		$new_excerpt_words = explode(' ', $excerpt, $excerpt_length+1); 
		array_pop($new_excerpt_words);
		$excerpt_text = implode(' ', $new_excerpt_words); 
		$temp_content = strip_tags($excerpt_text, $tags);
		$short_content = preg_replace('`\[[^\]]*\]`','',$temp_content);
		$short_content .= $trailing;
		
		return $short_content;
	}
} 


#-----------------------------------------------------------------
# Retrieve database options with $shortname
#-----------------------------------------------------------------


// Get theme variables, default action is echo 
//................................................................

//	$option = the option name in the database (without $shortname)
// 	$echo = print the return value (true, false). Default: true
// 	$default = value returned is no value exists in database

function theme_var($option, $act = 'echo', $default = '') {
	global $shortname;

	if ($default !== '') {
		$theme_option = get_option($shortname.$option, $default);
	} else {
		$theme_option = get_option($shortname.$option);
	}
	
	switch ($act){
		case "return":
			return $theme_option;
			break;
		default:
			echo $theme_option;
			break;
	}
}

// Shortcut for options without echo 
//................................................................

function get_theme_var($option, $default = '') {
	return theme_var($option, 'return', $default);
}


#-----------------------------------------------------------------
# Check page type for different templates and layouts
#-----------------------------------------------------------------

function checkPageType($id) {

	// Check for blog pages
	//................................................................
	$blogPages = get_theme_var('blogPages');
	
	if (is_array($blogPages)) { // only check if it's an array
		$flipped_blogPages = array_flip($blogPages);  // returns reversed key/value array: [0] -> $id, becomes: $id -> [0]
		if ( isset($flipped_blogPages[$id]) ) { 
			// found ID in the blog list
			$pageType = 'blog';
		} 
	}
	
	// Check for portfolio pages
	//................................................................	
	$portfolioPages = get_theme_var('portfolioPages');
	
	if (is_array($portfolioPages)) { // only check if it's an array
		$flipped_portfolioPages = array_flip($portfolioPages);  // returns reversed key/value array: [0] -> $id, becomes: $id -> [0]
		if ( isset($flipped_portfolioPages[$id]) ) { 
			// found ID in the portfolio list
			$pageType = 'portfolio';
		} 
	}
	
	// Check for the contact page
	if ( get_theme_var('contactPageId') == $id ) {
		$pageType = 'contact'; // This is a contact page
	}

	return $pageType;	
}


#-----------------------------------------------------------------
# Pagination function (<< 1 2 3 >>)
#-----------------------------------------------------------------

function get_pagination($range = 4) {

	// $paged - number of the current page
	global $paged, $wp_query, $firstPage, $postIndex;

	// How many pages do we have?
	if ( !$max_page ) {
		$max_page = $wp_query->max_num_pages;
	}
	
	// We need the pagination only if there are more than 1 page
	if($max_page > 1) {

		echo '<div class="pagination">';

		if (!$paged){ $paged = 1;}
		
		// On the first page, don't put the First page link
		// if($paged != 1){ echo "<a href=" . get_pagenum_link(1) . "> First </a>"; }
		
		// For home page, posts on page may be different from page 2, 3, etc. To prevent
		// inacurate page numbering, only show "next page" link. The query must also be
		// taking this into account and be modified with offset for other pages
		if ($firstPage && $postIndex) {
			if($max_page > 1) {
				// show next link on home page
				next_posts_link('More &raquo; ');
			}
		} else {
			
			// another special feature of the home page... we offset the count (paged) using a -1 because the second page 
			// of results is actaually the first page minus the posts on the home page. This makes the offset a lot
			// easier to do. So, when we show page 2 on page 3, it means we may not have the link to page 4. To ensure we 
			// have all links to pages we need to add 1 to the total # of pages!
			if ($postIndex) { 
				$max_page = $max_page + 1;
				if (!$firstPage) {
					$paged = $paged + 1;	// needs to be upped 1 to counter act the subtraction on home page (or the wrong # shows active :)
				}
			}
			
			// To the previous page
			previous_posts_link(' &laquo;');
			
			// We need the sliding effect only if there are more pages than is the sliding range
			if ($max_page > $range) {
			
			  // When closer to the beginning
				if ($paged < $range) {
					for($i = 1; $i <= ($range + 1); $i++) {
						echo "<a href='" . get_pagenum_link($i) ."'";
						if($i==$paged) echo "class='current'";
						echo ">$i</a>";
					}
				} elseif($paged >= ($max_page - ceil(($range/2)))){
					// When closer to the end	
					for($i = $max_page - $range; $i <= $max_page; $i++){
						echo "<a href='" . get_pagenum_link($i) ."'";
						if($i==$paged) echo "class='current'";
						echo ">$i</a>";
					}
				} elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
					// Somewhere in the middle
					for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){
						echo "<a href='" . get_pagenum_link($i) ."'";
						if($i==$paged) echo "class='current'";
						echo ">$i</a>";
					}
				}
			} else{
				// Less pages than the range, no sliding effect needed
				for($i = 1; $i <= $max_page; $i++){
					echo "<a href='" . get_pagenum_link($i) ."'";
					if($i==$paged) echo "class='current'";
					echo ">$i</a>";
				}
			}
			
			// Next page
			next_posts_link('&raquo; ');
			
		}
		// On the last page, don't put the Last page link
		//if($paged != $max_page){ echo " <a href=" . get_pagenum_link($max_page) . "> Last </a>"; }
		
		echo '</div>';
	}
}

// Function to allow paging to work with offsets (needed for home page)
//................................................................

function my_post_limit($limit) {
	global $paged, $myOffset;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval(get_option('posts_per_page'));
	$pgstrt = ((intval($paged) -1) * $postperpage) + $myOffset . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
}


#-----------------------------------------------------------------
# Main Menu Functions
#-----------------------------------------------------------------


// Retrieve variables for the main menu from the database
//................................................................

$_MM_ItemLevels = get_option($shortname.'MM-ItemLevels');
$_MM_ItemLevels = $_MM_ItemLevels['MainMenu'];
$_MM_ItemValues = get_option($shortname.'MM-ItemValues');


// Print the main menu
//................................................................

function printMenuItems($list = false, $options = false, $isChild = false) {
	
	if (!is_array($list)) {$list = $GLOBALS['_MM_ItemLevels'];}
	if (!is_array($options)) {$options = $GLOBALS['_MM_ItemValues'];}
	
	if (is_array($list)) {
		foreach ($list as $key => $value) {
		
			// get variables setup
			$id = $value['id'];
			$className = '';
			$URL = '';
	
			// check for the type of item being printed
			if ($options['mm-'. $id .'-linkTitle'] == 'mm-separator') {
				if ($isChild == false) {
					?>
					</ul>
					<div class="mmDivider"><!-- separator --></div>				
					<ul class="sf-menu">
					<?php
				} else {
					?>
					<li class="separator-item"><hr /></li>	
					<?php
				}				
			} else {
			
				// get link path
				switch ($options['mm-'. $id .'-linkType']) {
					case 'page':
						$URL = get_page_link($options['mm-'. $id .'-linkPage']);
						break;
					case 'category':
						$URL = get_category_link($options['mm-'. $id .'-linkCategory']);
						break;
					case 'url':
						$URL = $options['mm-'. $id .'-linkURL'];
						break;
					default:
						$URL = "#";
						break;
				} // end switch linkType
							
				?>
				<li class="<?php echo $className ?>">
					<a href="<?php echo htmlspecialchars_decode(stripslashes($URL)) ?>" title="<?php echo $options['mm-'. $id .'-linkDescription'] ?>"><?php echo htmlspecialchars_decode(stripslashes($options['mm-'. $id .'-linkTitle'])) ?></a>
					<?php
	
					
					// check for child elements
					if (is_array($value['children'])) {
						echo "<ul>";
						printMenuItems($value['children'], $options, true);
						echo "</ul>";
					} 
					?>
				</li>
			<?php
			} // end if (separator) else 
		}
	}
}


#-----------------------------------------------------------------
# Slide Show Functions
#-----------------------------------------------------------------

// Retrieve variables for the slide show from the database
//................................................................
$_SS_ItemLevels = get_option($shortname.'SS-ItemLevels');
$_SS_ItemLevels = $_SS_ItemLevels['SlideShow'];
$_SS_ItemValues = get_option($shortname.'SS-ItemValues');

// Print the slide show graphics
//................................................................
function printSlideShowItems($list = false, $options = false) {
	
	if (!is_array($list)) {$list = $GLOBALS['_SS_ItemLevels'];}
	if (!is_array($options)) {$options = $GLOBALS['_SS_ItemValues'];}
	
	if (count($list) > 0) {
		foreach ($list as $key => $value) {
		
			// get variables setup
			$id = $value['id'];
			$URL = '';
			$hasLink = false;
			$hasContent = false;
	
			// get link path
			switch ($options['ss-'. $id .'-linkType']) {
				case 'page':
					if (!empty($options['ss-'. $id .'-linkPage'])) {
						$URL = get_page_link($options['ss-'. $id .'-linkPage']);
					}
					break;
				case 'category':
					if (!empty($options['ss-'. $id .'-linkCategory'])) {
						$URL = get_category_link($options['ss-'. $id .'-linkCategory']);
					}
					break;
				case 'url':
					$URL = $options['ss-'. $id .'-linkURL'];
					break;
				default:
					$URL = "#";
					break;
			} // end switch linkType
			
			$hasLink = false;
			if (!empty($URL)) {
				$hasLink = true;
			}
			
			if (get_option($GLOBALS['shortname'].'slideShowType') == 'galleryView') {
			
				// GalleryView slide show ?>
				
					<li>
						<img src="<?php echo htmlspecialchars_decode(stripslashes($options['ss-'. $id .'-slideImagePath'])); ?>" alt="Slide" />
						<?php if ($hasContent) { ?>
							<div class="panel-overlay">
								<h2><?php echo $hasContentTitle ?></h2>
								<p><?php echo $hasContentText ?><</p>
							</div>
						<?php } ?>
					</li>
				<?php
				
			} else {
			
				// jQuery Cycle Plug-in slide show (default)
			
				?>
				<div class="<?php echo $className ?>">
					<?php 
					if ($hasLink) {
						echo '<a href="'. htmlspecialchars_decode(stripslashes($URL)) .'">';
					}
					if ($fromContent) {
						echo 'from content option not available';
					} else {
						// print the image
						echo '<img src="'. htmlspecialchars_decode(stripslashes($options['ss-'. $id .'-slideImagePath'])) .'" alt="Slide" />';
					}
					if ($hasLink) {
						echo '</a>';
					}
					?>
				</div>
				<?php
			}
		}
	}
} 


#-----------------------------------------------------------------
# Breadcrumbs
#-----------------------------------------------------------------

// Check if breadcrumbs are disabled globally
$globalBreadcrumbsOff = (get_theme_var('showBreadcrumbs', 1) == false) ? true : false;

// Function to print breadcrumbs
function show_breadcrumbs($homeLink = ''){
	global $post;
	
	$separator = ' <span>&raquo;</span> '; // what to place between the pages

	// the text to show for "Home" link
	if ($homeLink == '') {
		$homeLink = 'Home';
	} else {
		$homeLink = bloginfo('name');
	}

	if ( is_page() ){
		// bread crumb structure only logical on pages
		$trail = array($post); // initially $trail only contains the current page
		$parent = $post; // initially set to current post
		$show_on_front = get_option( 'show_on_front'); // does the front page display the latest posts or a static page
		$page_on_front = get_option( 'page_on_front' ); // if it shows a page, what page
		// while the current page isn't the home page and it has a parent
		while ( $parent->post_parent ){
			$parent = get_post( $parent->post_parent ); // get the current page's parent
			array_unshift( $trail, $parent ); // add the parent object to beginning of array
		}
		if ( 'posts' == $show_on_front ) // if the front page shows latest posts, simply display a home link
			echo '<a href="' . get_bloginfo('home') . '">'. $homeLink .'</a>'; // home page link
		else{ // if the front page displays a static page, display a link to it
			$home_page = get_post( $page_on_front ); // get the front page object
			echo '<a href="' . get_bloginfo('home') . '">'. $homeLink .'</a>'; // home page link
			if($trail[0]->ID == $page_on_front) // if the home page is an ancestor of this page
				array_shift( $trail ); // remove the home page from the $trail because we've already printed it
		}
		foreach ( $trail as $page){
			// print the link to the current page in the foreach
			if ($page->ID == $post->ID) {
				// don't need a link for the current page
				echo $separator . $page->post_title;
			} else {
				echo $separator .'<a href="'. get_page_link( $page->ID ) . '">'. $page->post_title .'</a>';
			}
		}
	}else{
		
		echo '<a href="'. get_option('home') .'">'. $homeLink .'</a>';
		
		// the text for different post types
		if (is_category() || is_single()) {
			single_cat_title($separator);
			if (is_single()) {
				echo $separator; the_title();
			}
		} elseif (is_tag()) {
			echo $separator; single_tag_title();
		} elseif (is_day()) {
			echo $separator .'Archive for '; the_time('F jS, Y');
		} elseif (is_month()) {
			echo $separator .'Archive for '; the_time('F, Y');
		} elseif (is_year()) {
			echo $separator .'Archive for '; the_time('Y');
		} elseif (is_author()) {
			echo $separator .'Author Archive';
		} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			echo $separator .'Blog Archives';
		} elseif (is_search()) {
			echo $separator .'Search Results';
		}		

	}
}


#-----------------------------------------------------------------
# Image Function
#-----------------------------------------------------------------

function showImage($w = '', $h = '', $alt = '', $outputSize = 'medium', $thePost = false){
	global $themePath, $post, $blog_id;
	
	$post = ($thePost) ? $thePost : $post;
	$theImg['showImage'] = false;  // default
	$theImg['hasvideo'] = false;  // default
	$placeHolder = '';  // default

	// image attributes
	$imgW = $w;
	$imgH = $h;
	$imgAlt = $alt;
		
	// post image info
	$imageOriginal = get_post_meta($post->ID, "_imageOriginal", true);
	$imageBlog = get_post_meta($post->ID, "_imageBlogHeader", true);
	$imageMedium = get_post_meta($post->ID, "_imageMedium", true);
	$imageSmall = get_post_meta($post->ID, "_imageSmall", true);
	
	// make sure the primary isn't a video
	if ( !in_array(substr($imageOriginal, strrpos($imageOriginal, '.') + 1), array('png','gif','jpeg','jpg','tif','tiff','bmp')) ) {
		$imageOriginal = false;
		$theImg['hasvideo'] = true;
	}
	
	// get image at requested size (or next biggest if selected size not provided)
	if ($imageOriginal && ( $outputSize == 'original' || $outputSize == 'blog' || $outputSize == 'medium' || $outputSize == 'small' )) : 
		$postImage = $imageOriginal;
		$theImg['showImage'] = true;
	endif;
	if ($imageBlog && ( $outputSize == 'blog' || $outputSize == 'medium' || $outputSize == 'small' )) : 
		$postImage = $imageBlog; 
		$theImg['showImage'] = true;
	endif;
	if ($imageMedium && ( $outputSize == 'medium' || $outputSize == 'small' )) : 
		$postImage = $imageMedium; 
		$theImg['showImage'] = true;
	endif;
	if ($imageSmall && $outputSize == 'small')	: 
		$postImage = $imageSmall; 
		$theImg['showImage'] = true;
	endif;
	
	// placeholder images (if no image and placeholder active) - FOR POSTS ONLY, NOT USED ON PAGES
	if (get_theme_var('placeholderImages') !== '' && $theImg['showImage'] == false && get_post_type( $post ) !== 'page' ) {
		$postImage = '../images/content/placeholder-('. $imgW .'x'. $imgH .').gif';
		$theImg['showImage'] = true;
	}
	
	// modify image path for multi-site setups
	if (isset($blog_id) && $blog_id > 0) {
		$imageParts = explode('/files/', $postImage, 2);
		if (isset($imageParts[1])) {
			$postImage = '/blogs.dir/'. $blog_id .'/files/'. $imageParts[1];
		}
	}
	
	// strip domain for local path
	$UrlParts = parse_url($postImage);
	$postImage = $UrlParts['path'];
	
	// full image SRC
	$theImg['src'] = $themePath .'includes/timthumb.php?src='. $postImage .'&amp;w='. $imgW .'&amp;h='. $imgH .'&amp;zc=1';
	
	// final image tag
	$theImg['full'] = '<img src="'. $theImg['src'] .'" width="'. $imgW .'" height="'. $imgH .'" alt="'. $imgAlt .'" />';
	
	return $theImg;

}


#-----------------------------------------------------------------
# Twitter Content Functions
#-----------------------------------------------------------------

if ( !function_exists('relativeTime') ) :
	function relativeTime( $original, $do_more = 0 ) {
			// array of time period chunks
			$chunks = array(
					array(60 * 60 * 24 * 365 , 'year'),
					array(60 * 60 * 24 * 30 , 'month'),
					array(60 * 60 * 24 * 7, 'week'),
					array(60 * 60 * 24 , 'day'),
					array(60 * 60 , 'hour'),
					array(60 , 'minute'),
			);
	
			$today = time();
			$since = $today - $original;
	
			for ($i = 0, $j = count($chunks); $i < $j; $i++) {
					$seconds = $chunks[$i][0];
					$name = $chunks[$i][1];
	
					if (($count = floor($since / $seconds)) != 0)
							break;
			}
	
			$print = ($count == 1) ? '1 '.$name : "$count {$name}s";
	
			if ($i + 1 < $j) {
					$seconds2 = $chunks[$i + 1][0];
					$name2 = $chunks[$i + 1][1];
	
					// add second item if it's greater than 0
					if ( (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) && $do_more )
							$print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
			}
			return $print;
	}
endif;


define('MAGPIE_CACHE_ON', 1); //2.7 Cache Bug
define('MAGPIE_CACHE_AGE', 900);
define('MAGPIE_INPUT_ENCODING', 'UTF-8');
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

function parse_cache_twitter_feed($usernames, $limit, $type) {
	
	include_once(ABSPATH . WPINC . '/rss.php');
	global $shortname;
	$tweet_count = get_option("widget_twitterwidget");
	$count = ($tweet_count) ? $tweet_count : '5';
	
	$messages = fetch_rss('http://twitter.com/statuses/user_timeline/'.$usernames.'.rss');
	
	if ($usernames == '') {
		$out .= '<p>Twitter not configured.</p>';
	} else {
			if ( empty($messages->items) ) {
				$out .= '<p>No public Twitter messages.</p>';
			} else {
        $i = 0;

		foreach ( $messages->items as $message ) {
			$msg = substr(strstr($message['description'],': '), 2, strlen($message['description']))." ";
			if($encode_utf8) $msg = utf8_encode($msg);
			$link = $message['link'];
			$time = $message['pubdate'];
			
			
			if($type == 'teaser') {
				$msg = twitterHyperlinks($msg);
				$out .= '<p class="tweet">';
				$out .= $msg;
				$out .= '<small>(' . relativeTime(strtotime($time)) . '&nbsp;ago)</small>';
				$out .= '</p>';
			}
			
			if($type == 'widget') {
				$out .= '<li>';
				$out .= '<a class="target_blank" href="' .$link. '" title="' .relativeTime(strtotime($time)). '">' .$msg. '</a>';
				$out .= '</li>';
			}

			$i++;
			if ( $i >= $limit ) break;
		}


			}
		}
		
	return $out;
}

function twitterHyperlinks($text) {
	// Props to Allen Shaw & webmancers.com
	// match protocol://address/path/file.extension?some=variable&another=asf%
	$text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
	
	// match www.something.domain/path/file.extension?some=variable&another=asf%
	$text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);    
	
	// match name@address
	$text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
	
	//mach #trendingtopics. Props to Michael Voigt
	$text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
	return $text;
}


#-----------------------------------------------------------------
# Simple string encode/decode functions
#-----------------------------------------------------------------

$strEncOffset = 19; // set to a unique number for offset (must be same as number set in "contact-send.php")

function strEnc($s) {
    for( $i = 0; $i < strlen($s); $i++ )
        $r[] = ord($s[$i]) + $strEncOffset;
	if (!empty($r)) {
		return implode('.', $r);
	}
}
 
function strDec($s) {
    $s = explode(".", $s);
    for( $i = 0; $i < count($s); $i++ )
        $s[$i] = chr($s[$i] - $strEncOffset);
	if (!empty($r)) {
	    return implode('', $s);
	}
}

?>