<?php
#==================================================================
#
#	Admin control panel setup
#
#==================================================================


#-----------------------------------------------------------------
# Default theme variables and information
#-----------------------------------------------------------------

$themeInfo = get_theme_data(TEMPLATEPATH . '/style.css');
$themeVersion = trim($themeInfo['Version']);
$themeTitle= trim($themeInfo['Title']);
$shortname = strtolower(str_replace(" ","",$themeTitle)) . "_";

$postIndex = false; // special case variable for index paging bug


// set as constants
//................................................................

define('THEMENAME', $themeTitle);
define('THEMEVERSION', $themeVersion);


// shortcuts variables
//................................................................

$cssPath = get_bloginfo('stylesheet_directory') . "/";
$themePath = get_bloginfo('template_url') . "/";
$themeUrlArray = parse_url(get_bloginfo('template_url'));
$themeLocalUrl = $themeUrlArray['path'] . "/";


// setup info (category list, page list, etc)
//................................................................

$allCategories = get_categories('hide_empty=0');
$allPages = get_pages('hide_empty=0');
$pageList = array();
$categoryList = array();


// create category and page list arrays
//................................................................

foreach ($allPages as $thisPage) {
	$pageList[$thisPage->ID] = $thisPage->post_title;
	$pages_ids[] = $thisPage->ID;
}
foreach ($allCategories as $thisCategory) {
	$categoryList[$thisCategory->cat_ID] = $thisCategory->cat_name;
	$cats_ids[] = $thisCategory->cat_ID;
}


// Translation ready code
//................................................................

// Make theme available for translation, Translations can be filed 
// in the "languages" directory. To change language just change 
// the value of $locale with laguage .mo file name.. 
// for example: global $locale; $locale = 'pa_IN';

load_theme_textdomain( THEMENAME, TEMPLATEPATH . '/languages' );


// This theme uses wp_nav_menu() in one location.
//................................................................

if (version_compare( get_bloginfo('version'), '3.0', '>=' )) {
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', $themeTitle ),
	) );
}


#-----------------------------------------------------------------
# Admin Menu Options
#-----------------------------------------------------------------

// include options functions
//................................................................

include_once('theme_admin/includes/option_functions.php');

// Menu structure
//................................................................

function this_theme_menu() {
	add_menu_page('Theme Options', THEMENAME, 10, 'theme-setup', 'loadOptionsPage', get_template_directory_uri().'/theme_admin/images/themePanelIcon.png');
	add_submenu_page('theme-setup', 'General Settings', 'General Options', 10, 'theme-setup', 'loadOptionsPage');
	add_submenu_page('theme-setup', 'Home Page', 'Home Page', 10,  'homepage-options', 'loadOptionsPage');
	if ( version_compare( get_bloginfo('version'), '3.0', '<' ) ) {
		// Theme menu manager only used for WP versions earlier than 3.0
		add_submenu_page('theme-setup', 'Main Menu', 'Main Menu', 10, 'mainmenu-options', 'loadOptionsPage');
	}
	add_submenu_page('theme-setup', 'Slideshow', 'Slideshow', 10, 'slideshow-options', 'loadOptionsPage');
	add_submenu_page('theme-setup', 'Sidebar', 'Sidebar', 10, 'sidebar-options', 'loadOptionsPage');
	add_submenu_page('theme-setup', 'Blog', 'Blog Pages', 10, 'blog-options', 'loadOptionsPage'); // 18-Aug ubhi -ps (added the blog link)
	add_submenu_page('theme-setup', 'Portfolio', 'Portfolio Pages', 10, 'portfolio-options', 'loadOptionsPage');
	add_submenu_page('theme-setup', 'Contact Page', 'Contact Page', 10, 'contact-options', 'loadOptionsPage');
}
	
// Create menu
//................................................................

add_action('admin_menu','this_theme_menu');

// call and display the requested options page
//................................................................

function loadOptionsPage() {
	global $themeTitle,$shortname,$pageList,$categoryList,$wp_deprecated_widgets_callbacks;

	include_once('theme_admin/includes/options_pages/'. $_GET['page'] .'.php');
	
	// Get the list in array array form of excludes
	$customOptionsPages = array('slideshow-options', 'mainmenu-options', 'blog-options', 'portfolio-options', 'sidebar-options');
	
	if ( !in_array($_GET['page'], $customOptionsPages) ) {
		include_once("theme_admin/options.php");
	}
}



#-----------------------------------------------------------------
# Addon Functions and Content
#-----------------------------------------------------------------

include_once("theme_admin/includes/addon-functions.php");


#-----------------------------------------------------------------
# Include Widgets
#-----------------------------------------------------------------
include_once('theme_admin/includes/widgets.php');






add_action("login_head", "my_login_head");
function my_login_head() {
	echo "
	<style>
	body.login #login h1 a {
		background: url('/images/login_logo.png') no-repeat scroll center top transparent;
		height: 70px;
		width: 325px;
	}
	</style>
	";
}


 add_shortcode( 'member', 'member_check_shortcode' );
  add_shortcode( 'notmember', 'not_member_check_shortcode' );

function member_check_shortcode( $atts, $content = null ) {
	 if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
		return $content;
	return '';
}


function not_member_check_shortcode( $atts, $content = null ) {
	 if ( !is_user_logged_in() && !is_null( $content ) && !is_feed() )
		return $content;
	return '';
}





// Remove/change profile fields
function remove_contact( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  return $contactmethods;
}
add_filter('user_contactmethods','remove_contact',10,1);

function remove_fields( $buffer ) {
	$website = '#<th><label for="url">Website</label></th>.+?/table>#s';
	$buffer = preg_replace($website,'<th></th><td></td></tr></table>',$buffer,1);
	
	$aboutheading = '#<h3>About Yourself</h3>#s';
	$buffer = preg_replace($aboutheading,'<h3>Password</h3>',$buffer,1);
	
	$description = '#<th><label for="description">Biographical Info</label></th>.+?/tr>#s';
	$buffer = preg_replace($description,'<th></th><td></td></tr>',$buffer,1);

	return $buffer;
}
function profile_admin_buffer_start() {
    ob_start("remove_fields"); 
}
add_action( 'wp_head', 'profile_admin_buffer_start');

// Add profile fields
add_action( 'show_user_profile', 'extra_profile_fields',1,1 );
add_action( 'edit_user_profile', 'extra_profile_fields',1,1 );

function extra_profile_fields( $user ) { ?>

    <h3>Company Details</h3>

        <table class="form-table">
            <tbody>

		<tr>
			<th><label for="company">Company</label></th>

			<td>
				<input type="text" name="usercompany" id="usercompany" value="<?php echo esc_attr( get_the_author_meta( 'usercompany', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="phone">Phone Number</label></th>

			<td>
				<input type="text" name="userphone" id="userphone" value="<?php echo esc_attr( get_the_author_meta( 'userphone', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>

		<tr>
			<th><label for="address">Address</label></th>

			<td>
				<input type="text" name="useraddress" id="useraddress" value="<?php echo esc_attr( get_the_author_meta( 'useraddress', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>

		<tr>
			<th><label for="city">City</label></th>

			<td>
				<input type="text" name="usercity" id="usercity" value="<?php echo esc_attr( get_the_author_meta( 'usercity', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>

		<tr>
			<th><label for="zip">Zip Code</label></th>

			<td>
				<input type="text" name="userzip" id="userzip" value="<?php echo esc_attr( get_the_author_meta( 'userzip', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>

	</table>
    
<?php }

add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );

function save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_usermeta( $user_id, 'usercompany', $_POST['company'] );
	update_usermeta( $user_id, 'userphone', $_POST['phone'] );
	update_usermeta( $user_id, 'useraddress', $_POST['address'] );
	update_usermeta( $user_id, 'usercity', $_POST['city'] );	
	update_usermeta( $user_id, 'userzip', $_POST['zip'] );		
}



?>