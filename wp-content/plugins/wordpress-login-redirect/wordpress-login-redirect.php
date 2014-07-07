<?php
/*
Plugin Name: WordPress Login Redirect
Plugin URI: http://thisismyurl.com/plugins/wordpress-login-redirect/
Description: A plugin which redirects subscriber level users back to the homepage after they've logged in.
Author: Christopher Ross
Author URI: http://thisismyurl.com/
Tags: subscriber, login, redirect
Version: 2.5.0
*/



/**
 * WordPress Login Redirect
 *
 * This file contains all the logic required for the plugin
 *
 * @link		http://wordpress.org/extend/plugins/wordpress-login-redirect/
 *
 * @package 		WordPress Login Redirect
 * @copyright		Copyright (c) 2008, Chrsitopher Ross
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		WordPress Login Redirect 1.0
 */


/**
 * Check to see if a redirect is needed
 *
 */
$temp = explode( '/', $_SERVER['SCRIPT_FILENAME'] );
$wlr_profile = get_option( 'wlr_profile' );

$redirect = true;
if( $temp[ count( $temp )-1 ] == 'profile.php' && $wlr_profile != '' )
	$redirect = false;

if( $redirect == true )
	add_action( 'admin_head', 'thisismyurl_wordress_login_redirect_to_front_page' );


function thisismyurl_wordress_login_redirect_to_front_page( ) {

	global $current_user;
	get_currentuserinfo( );

	if ( 'subscriber' == $current_user->roles[0] ) {

		wp_redirect( '../' );

		echo '<meta http-equiv="refresh" content="0;URL=../" />
			  <script type="text/javascript"><!-- window.location = "../" //--></script>';

	}

}

/**
 * Add redirect option to menu
 *
 */
function thisismyurl_wordress_login_redirect_menu( ) {

	add_management_page( 'Login Redirect', 'Login Redirect', 10, 'thisismyurl_wordress_login_redirect.php', 'thisismyurl_wordress_login_redirect_options' );

}
add_action( 'admin_menu', 'thisismyurl_wordress_login_redirect_menu' );

/**
 * Add plugin functions
 *
 */
function thisismyurl_wordress_login_redirect_plugin_actions( $links, $file ) {

	static $this_plugin;

	if( !$this_plugin ) $this_plugin = plugin_basename( __FILE__ );

	if( $file == $this_plugin ){
		$settings_link = '<a href="tools.php?page=thisismyurl_wordress_login_redirect.php">' . __( 'Settings' ) . '</a>';
		$links = array_merge( array( $settings_link ), $links );
	}
	return $links;

}
add_filter( 'plugin_action_links', 'thisismyurl_wordress_login_redirect_plugin_actions', 10, 2 );

/**
 * Options page for plugin
 *
 */
function thisismyurl_wordress_login_redirect_options( $options='' ) {

	if ( isset( $_POST['wlr_profile'] ) )
		update_option( 'wlr_profile', $_POST['wlr_profile'] );

	$wlr_profile = get_option( 'wlr_profile' );

?>
<div class="wrap">
	<a href="http://thisismyurl.com/"><div id="cross-icon" style="background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAA0lBMVEX///9Jj6xrpLxJj6xrpLxhnbdJj6xxqL5moblhnbdJj6xhnbdJj6xxqL5rpLxmoblJj6xxqL5hnbdJj6x1qsBJj6xrpLxmoblJj6xrpLxJj6x4rMFJj6x1qsBJj6xxqL5Jj6x4rMF1qsBxqL5Jj6z////3+vv0+Pru9ffm7/Tf6/Hd6u/V5ezS4+rO4OjG3OW71eC509+z0Nyvztuqy9ikx9aZwNCRu82OucuMtcWCssZ/sMWAsMV4rMF1qsBrpLxmoblhnbdamrRUlrFSlLBJj6wucLoaAAAAJXRSTlMAESIiMzMzRERERFVVZmZmZnd3d4iImZmZqqq7u8zM3d3u7u7u5Bc3VAAAAehJREFUOMttU9li0zAQdAkNEEoJhXIUp4HEK1vxJeLYiQ/FuGL//5dYWb5I2SdLM56dPWRZQ7z9tj5LHevPr63ncbfN9wEDCi84lNvbC/h6m0cwiShfXU/x27PQt2muM+Qpcdl+MxH5UnKAuJRDlMQPyg89/p5w7yj/iaMHvHxn8DdnTgd5EfRTtHnREtYCvBEXQc/wYL/S+LICGPUrlg1ZgJWviPBDgBiVo2D8jkGQxE0DYBJUR/1XbjCtWQKTL62vGYin9jIAP/eNWMZaXgTpJ+sxhgIbfTzoRhsBbngpxCsLOTSIWqOKQurgQVM9YyIHf2MhAFI8nSV1L9oB8KxiaWeTTPQE/FPpIbHIo3Hu+joARgLGZo47PSlRPSfIYdShTyIdwZOdSUR/XAYWc9ab/GnKRMym69J3lsr8bt2fQBAhnOBe87s+m0Zld9ZcAajBYhvSuEYFHGftsJKpRwg7HFNIbT3uxoUa8TQQmg6vwVULvRCPGXCF8S/X4EmfgEPx0G7UzInBL6nPsaa4qsN9EM6VWcolHdonk8js1OE1p+Lm/VovlWjV696eSqgZuBwfxo2TkQQvWn9NQXS3cObTpzWzVcrGSt1UPVxdvM6FjUUSkk03TAq0F/953/N729EpHPvjbLz9C0A/pR4RVDYdAAAAAElFTkSuQmCC) no-repeat;" class="icon32"><br /></div></a>
	<h2><?php _e( 'WordPress Login Redirect by Christopher Ross', 'thisismyurl_wordress_login_redirect' );?></h2>
	<div class="postbox-container" style="width:70%;">
		<div class="metabox-holder">
		<div id="normal-sortables" class="meta-box-sortables">


			<form method="post" action="options.php"><?php wp_nonce_field( 'update-options' ); ?>
			<div id="wpsettings" class="postbox">
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class="hndle"><span>Settings</span></h3>
			<div class="inside">

				<p><label><input name="wlr_profile" type="checkbox" id="wlr_profile" <?php if( $wlr_profile != '' ) {echo "checked";} ?> /> Allow Users to see profile page.</label></p>

				<p><small>Users will now be directed to their profile at <em><a href="<?php bloginfo( 'url' );?>/wp-admin/profile.php"><?php bloginfo( 'url' );?>/wp-admin/profile.php</a></em></small>.</p>

			</div>
			</div>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="wlr_profile" />


			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
			</p>
			</form>

		</div>
		</div>
	</div>

<?php
}

/**
 * Admin scripts to footer
 *
 */
function thisismyurl_wordress_login_redirect_add_scripts( ){
    if ( isset( $_GET['page'] ) &&  'thisismyurl_wordress_login_redirect.php' == $_GET['page'] ) {
   ?>
   <script type='text/javascript' src='<?php bloginfo( 'url' );?>/wp-admin/load-scripts.php?c=1&amp;load=hoverIntent,common,jquery-color,wp-ajax-response,wp-lists,jquery-ui-core,jquery-ui-resizable,admin-comments,jquery-ui-sortable,postbox,dashboard,thickbox,plugin-install,media-upload&amp;ver=1c33e12a06a28402104d18bdc95ada53'></script>
	<?php
    }
}
add_filter( 'admin_footer', 'thisismyurl_wordress_login_redirect_add_scripts', 10, 2 );



/**
 * Add scripts to header
 *
 */
function thisismyurl_wordress_login_redirect_add_scripts_head( ){
	if ( isset( $_GET['page'] ) ) {
		if ( $_GET['page'] == 'thisismyurl_wordress_login_redirect.php' ) {
		?>
		<script type="text/javascript">
		//<![CDATA[
		addLoadEvent = function( func ){if( typeof jQuery!="undefined" )jQuery( document ).ready( func );else if( typeof wpOnload!='function' ){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function( ){oldonload( );func( );}}};
		var userSettings = {
				'url': '/',
				'uid': '2',
				'time':'1296327223'
			},
			ajaxurl = '<?php bloginfo( 'url' );?>/wp-admin/admin-ajax.php',
			pagenow = 'settings_page_thisismyurl_wordress_login_redirect',
			typenow = '',
			adminpage = 'settings_page_thisismyurl_wordress_login_redirect',
			thousandsSeparator = ', ',
			decimalPoint = '.',
			isRtl = 0;
		//]]>
		</script>
		<link rel='stylesheet' href='<?php bloginfo( 'url' );?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=dashboard,plugin-install,global,wp-admin&amp;ver=030f653716b08ff25b8bfcccabe4bdbd' type='text/css' media='all' />
		<script type='text/javascript'>
		/* <![CDATA[ */
		var quicktagsL10n = {
			quickLinks: "( Quick Links )",
			wordLookup: "Enter a word to look up:",
			dictionaryLookup: "Dictionary lookup",
			lookup: "lookup",
			closeAllOpenTags: "Close all open tags",
			closeTags: "close tags",
			enterURL: "Enter the URL",
			enterImageURL: "Enter the URL of the image",
			enterImageDescription: "Enter a description of the image"
		};
		try{convertEntities( quicktagsL10n );}catch( e ){};
		/* ]]> */
		</script>
		<script type='text/javascript' src='<?php bloginfo( 'url' );?>/wp-admin/load-scripts.php?c=1&amp;load=jquery,utils,quicktags&amp;ver=b50ff5b9792a9e89a2e131ad3119a463'></script>
	<?php
		}
	}
}
add_filter( 'admin_head', 'thisismyurl_wordress_login_redirect_add_scripts_head', 10, 2 );
