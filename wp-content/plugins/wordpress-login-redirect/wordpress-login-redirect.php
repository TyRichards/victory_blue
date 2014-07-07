<?php
/*
Plugin Name: WordPress Login Redirect
Plugin URI: http://thisismyurl.com/downloads/wordpress/plugins/wordpress-login-redirect/
Description: A plugin which redirects subscriber level users back to the homepage after they've logged in.
Author: Christopher Ross
Author URI: http://thisismyurl.com
Tags: subscriber, login, redirect
Version: 1.1.0
*/

/*
	/--------------------------------------------------------------------\
	|                                                                    |
	| License: GPL                                                       |
	|                                                                    |
	| Copyright (C) 2011, Christopher Ross						  	     |
	| http://thisismyurl.com/		                                     |
	| All rights reserved.                                               |
	|                                                                    |
	| This program is free software; you can redistribute it and/or      |
	| modify it under the terms of the GNU General Public License        |
	| as published by the Free Software Foundation; either version 2     |
	| of the License, or (at your option) any later version.             |
	|                                                                    |
	| This program is distributed in the hope that it will be useful,    |
	| but WITHOUT ANY WARRANTY; without even the implied warranty of     |
	| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
	| GNU General Public License for more details.                       |
	|                                                                    |
	| You should have received a copy of the GNU General Public License  |
	| along with this program; if not, write to the                      |
	| Free Software Foundation, Inc.                                     |
	| 51 Franklin Street, Fifth Floor                                    |
	| Boston, MA  02110-1301, USA                                        |   
	|                                                                    |
	\--------------------------------------------------------------------/
*/




global $cr_wplink;
global $cr_wpname;
$cr_wpname = "WordPress Login Redirect";
$cr_wplink = "wordpress-login-redirect";





//
// add a javascript redict to the admin header
//


$temp = explode("/",$_SERVER['SCRIPT_FILENAME']);
$wlr_profile = get_option('wlr_profile');


$redirect = true;
if($temp[count($temp)-1] == 'profile.php' && $wlr_profile != "") {$redirect = false;}

if($redirect == true) {
	add_action('admin_head', 'cr_wlr_to_front_page');
}


function cr_wlr_to_front_page() {
	global $current_user;
	get_currentuserinfo();
	
	if ($current_user->roles[0] == 'subscriber') {
		//wp_redirect('../?page_id=10');
		echo '<meta http-equiv="refresh" content="0;URL=../" />';
		
		echo '<script type="text/javascript">
				<!--
				window.location = "../?page_id=10"
				//-->
				</script>';

	} 
	
}




// add menu to WP admin

function cr_wlr_menu() {add_management_page('Login Redirect', 'Login Redirect', 10,'cr_wlr.php', 'cr_wlr_options');}
add_action('admin_menu', 'cr_wlr_menu');





// add a comment to the footer

function cr_wlr_footer_code($options='') {echo "<!--  WordPress Login Redirect Plugin for WordPress by Christopher Ross  - http://thisismyurl.com  -->";}
add_action('wp_footer', 'cr_wlr_footer_code');




// add plugin functions

function cr_wlr_plugin_actions($links, $file){
	static $this_plugin;

	if( !$this_plugin ) $this_plugin = plugin_basename(__FILE__);

	if( $file == $this_plugin ){
		$settings_link = '<a href="tools.php?page=cr_wlr.php">' . __('Settings') . '</a>';
		$links = array_merge( array($settings_link), $links); // before other links
	}
	return $links;
}
add_filter('plugin_action_links', 'cr_wlr_plugin_actions', 10, 2);






// options page for plugin

function cr_wlr_options($options='') {
	
	
	
	// save settings
	if (isset($_POST['wlr_profile'])) {
		update_option('wlr_profile',$_POST['wlr_profile']);
	}

	$wlr_profile = get_option('wlr_profile');
?>
    
<div class="wrap">

	<a href="http://thisismyurl.com/"><div id="cross-icon" style="background: url('<?php echo WP_PLUGIN_URL .'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));?>/icon.png') no-repeat;" class="icon32"><br /></div></a>
	<h2>WordPress Login Redirect by Christopher Ross</h2>
	


	<div class="postbox-container" style="width:70%;">
		<div class="metabox-holder">	
		<div id="normal-sortables" class="meta-box-sortables">


			<form method="post" action="options.php"><?php wp_nonce_field('update-options'); ?>
			<div id="wpsettings" class="postbox">
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class="hndle"><span>Settings</span></h3>
			<div class="inside">
				<p>This plugin has no settings. To use the plugun effectively, please consult the <a target='_blank' href='<?php echo WP_PLUGIN_URL .'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'readme.txt';?>'>readme file</a>.</p>
				
				
				<p><label><input name="wlr_profile" type="checkbox" id="wlr_profile" <?php if($wlr_profile != "") {echo "checked";} ?> /> Allow Users to see profile page.</label></p>
			
				<p><small>Users will now be directed to their profile at <em><?php bloginfo('url');?>/wp-admin/profile.php</em></small>.</p>
			
			</div>
			</div>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="wlr_profile" />
			
			
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
			</form>
			
		</div>
		</div>
	</div>
	

	<?php include(WP_PLUGIN_DIR .'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'common.php');?>
	
	
			
<?php
}




// add scripts to footer
add_filter('admin_footer', 'cr_wlr_add_scripts', 10, 2);
function cr_wlr_add_scripts(){
    if ($_GET['page'] == "cr_wlr.php") {
   ?>
   
   
   <script type='text/javascript' src='<?php bloginfo('url');?>/wp-admin/load-scripts.php?c=1&amp;load=hoverIntent,common,jquery-color,wp-ajax-response,wp-lists,jquery-ui-core,jquery-ui-resizable,admin-comments,jquery-ui-sortable,postbox,dashboard,thickbox,plugin-install,media-upload&amp;ver=1c33e12a06a28402104d18bdc95ada53'></script>



   <?php
    }
}



// add scripts to header
add_filter('admin_head', 'cr_wlr_add_scripts_head', 10, 2);
function cr_wlr_add_scripts_head(){
    if ($_GET['page'] == "cr_wlr.php") {
    ?>
	
	
	
	<script type="text/javascript">
	//<![CDATA[
	addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
	var userSettings = {
			'url': '/',
			'uid': '2',
			'time':'1296327223'
		},
		ajaxurl = '<?php bloginfo('url');?>/wp-admin/admin-ajax.php',
		pagenow = 'settings_page_cr_wlr',
		typenow = '',
		adminpage = 'settings_page_cr_wlr',
		thousandsSeparator = ',',
		decimalPoint = '.',
		isRtl = 0;
	//]]>
	</script>
	<link rel='stylesheet' href='<?php bloginfo('url');?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=dashboard,plugin-install,global,wp-admin&amp;ver=030f653716b08ff25b8bfcccabe4bdbd' type='text/css' media='all' />
	<script type='text/javascript'>
	/* <![CDATA[ */
	var quicktagsL10n = {
		quickLinks: "(Quick Links)",
		wordLookup: "Enter a word to look up:",
		dictionaryLookup: "Dictionary lookup",
		lookup: "lookup",
		closeAllOpenTags: "Close all open tags",
		closeTags: "close tags",
		enterURL: "Enter the URL",
		enterImageURL: "Enter the URL of the image",
		enterImageDescription: "Enter a description of the image"
	};
	try{convertEntities(quicktagsL10n);}catch(e){};
	/* ]]> */
	</script>
	<script type='text/javascript' src='<?php bloginfo('url');?>/wp-admin/load-scripts.php?c=1&amp;load=jquery,utils,quicktags&amp;ver=b50ff5b9792a9e89a2e131ad3119a463'></script>





<?php


    }
}





?>