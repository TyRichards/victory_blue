<?php

function move_upload_directories() {
	global $sl_upload_path, $sl_path;
	
	if (!is_dir(ABSPATH . "wp-content/uploads")) {
			mkdir(ABSPATH . "wp-content/uploads", 0755);
	}
	if (!is_dir($sl_upload_path)) {
			mkdir($sl_upload_path, 0755);
	}
	if (is_dir($sl_path . "/addons") && !is_dir($sl_upload_path . "/addons")) {
		copyr($sl_path . "/addons", $sl_upload_path . "/addons");
	}
	if (is_dir($sl_path . "/themes") && !is_dir($sl_upload_path . "/themes")) {
		copyr($sl_path . "/themes", $sl_upload_path . "/themes");
	}
	if (is_dir($sl_path . "/languages") && !is_dir($sl_upload_path . "/languages")) {
		copyr($sl_path . "/languages", $sl_upload_path . "/languages");
	}
	if (is_dir($sl_path . "/images") && !is_dir($sl_upload_path . "/images")) {
		copyr($sl_path . "/images", $sl_upload_path . "/images");
	}
	//mkdir($sl_upload_path . "/addons", 0755);
	//mkdir($sl_upload_path . "/themes", 0755);
	//mkdir($sl_upload_path . "/languages", 0755);
	if (!is_dir($sl_upload_path . "/custom-icons")) {
		mkdir($sl_upload_path . "/custom-icons", 0755);
	}
	//mkdir($sl_upload_path . "/images", 0755);
	if (!is_dir($sl_upload_path . "/custom-css")) {
		mkdir($sl_upload_path . "/custom-css", 0755);
	}
	//copyr($sl_path . "/store-locator.css", $sl_upload_path . "/custom-css/store-locator.css");
}
/* -----------------*/
function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
$xmlStr=str_replace("," ,"&#44;" ,$xmlStr);
return $xmlStr; 
} 

/*-----------------*/

function initialize_variables() {

global $height, $width, $width_units, $height_units, $radii;
global $icon, $icon2, $google_map_domain, $google_map_country, $theme, $sl_base, $sl_upload_base, $location_table_view;
global $search_label, $zoom_level, $sl_use_city_search, $sl_use_name_search, $sl_default_map;
global $sl_radius_label, $sl_website_label, $sl_directions_label, $sl_num_initial_displayed, $sl_load_locations_default;
global $sl_distance_unit, $sl_map_overview_control, $sl_admin_locations_per_page, $sl_instruction_message;
global $sl_map_character_encoding, $sl_start;

$sl_start=get_option('sl_start');
if (empty($sl_start)) {
	$sl_start=date("Y-m-d H:i:s");
	add_option('sl_start', $sl_start);
	}
$sl_map_character_encoding=get_option('sl_map_character_encoding');
if (empty($sl_map_character_encoding)) {
	$sl_map_character_encoding="";
	add_option('sl_map_character_encoding', $sl_map_character_encoding);
	}
$sl_instruction_message=get_option('sl_instruction_message');
if (empty($sl_instruction_message)) {
	$sl_instruction_message="Enter Your Address or Zip Code Above.";
	add_option('sl_instruction_message', $sl_instruction_message);
	}
$sl_admin_locations_per_page=get_option('sl_admin_locations_per_page');
if (empty($sl_admin_locations_per_page)) {
	$sl_admin_locations_per_page="100";
	add_option('sl_admin_locations_per_page', $sl_admin_locations_per_page);
	}
$sl_map_overview_control=get_option('sl_map_overview_control');
if (empty($sl_map_overview_control)) {
	$sl_map_overview_control="0";
	add_option('sl_map_overview_control', $sl_map_overview_control);
	}
$sl_distance_unit=get_option('sl_distance_unit');
if (empty($sl_distance_unit)) {
	$sl_distance_unit="miles";
	add_option('sl_distance_unit', $sl_distance_unit);
	}
$sl_load_locations_default=get_option('sl_load_locations_default');
if (empty($sl_load_locations_default)) {
	$sl_load_locations_default="1";
	add_option('sl_load_locations_default', $sl_load_locations_default);
	}
$sl_num_initial_displayed=get_option('sl_num_initial_displayed');
if (empty($sl_num_initial_displayed)) {
	$sl_num_initial_displayed="25";
	add_option('sl_num_initial_displayed', $sl_num_initial_displayed);
	}
$sl_website_label=get_option('sl_website_label');
if (empty($sl_website_label)) {
	$sl_website_label="Website";
	add_option('sl_website_label', $sl_website_label);
	}
$sl_directions_label=get_option('sl_directions_label');
if (empty($sl_directions_label)) {
	$sl_directions_label="Directions";
	add_option('sl_directions_label', $sl_directions_label);
	}
$sl_radius_label=get_option('sl_radius_label');
if (empty($sl_radius_label)) {
	$sl_radius_label="Radius";
	add_option('sl_radius_label', $sl_radius_label);
	}
$sl_map_type=get_option('sl_map_type');
if (empty($sl_map_type)) {
	$sl_map_type=G_NORMAL_MAP;
	add_option('sl_map_type', $sl_map_type);
	}
$sl_remove_credits=get_option('sl_remove_credits');
if (empty($sl_remove_credits)) {
	$sl_remove_credits="0";
	add_option('sl_remove_credits', $sl_remove_credits);
	}
$sl_use_name_search=get_option('sl_use_name_search');
if (empty($sl_use_name_search)) {
	$sl_use_name_search="0";
	add_option('sl_use_name_search', $sl_use_name_search);
	}
$sl_use_city_search=get_option('sl_use_city_search');
if (empty($sl_use_city_search)) {
	$sl_use_city_search="1";
	add_option('sl_use_city_search', $sl_use_city_search);
	}
$zoom_level=get_option('sl_zoom_level');
if (empty($zoom_level)) {
	$zoom_level="4";
	add_option('sl_zoom_level', $zoom_level);
	}
$search_label=get_option('sl_search_label');
if (empty($search_label)) {
	$search_label="Address";
	add_option('sl_search_label', $search_label);
	}
$location_table_view=get_option('sl_location_table_view');
if (empty($location_table_view)) {
	$location_table_view="Normal";
	add_option('sl_location_table_view', $location_table_view);
	}
$theme=get_option('sl_map_theme');
if (empty($theme)) {
	$theme="";
	add_option('sl_map_theme', $theme);
	}
$google_map_country=get_option('sl_google_map_country');
if (empty($google_map_country)) {
	$google_map_country="United States";
	add_option('sl_google_map_country', $google_map_country);
}
$google_map_domain=get_option('sl_google_map_domain');
if (empty($google_map_domain)) {
	$google_map_domain="maps.google.com";
	add_option('sl_google_map_domain', $google_map_domain);
}
$icon2=get_option('sl_map_end_icon');
if (empty($icon2)) {
	add_option('sl_map_end_icon', $sl_base.'/icons/marker.png');
	$icon2=get_option('sl_map_end_icon');
}
$icon=get_option('sl_map_home_icon');
if (empty($icon)) {
	add_option('sl_map_home_icon', $sl_base.'/icons/arrow.png');
	$icon=get_option('sl_map_home_icon');
}
$height=get_option('sl_map_height');
if (empty($height)) {
	add_option('sl_map_height', '350');
	$height=get_option('sl_map_height');
	}

$height_units=get_option('sl_map_height_units');
if (empty($height_units)) {
	add_option('sl_map_height_units', "px");
	$height_units=get_option('sl_map_height_units');
	}	

$width=get_option('sl_map_width');
if (empty($width)) {
	add_option('sl_map_width', "100");
	$width=get_option('sl_map_width');
	}

$width_units=get_option('sl_map_width_units');
if (empty($width_units)) {
	add_option('sl_map_width_units', "%");
	$width_units=get_option('sl_map_width_units');
	}	

$radii=get_option('sl_map_radii');
if (empty($radii)) {
	add_option('sl_map_radii', "1,5,10,25,(50),100,200,500");
	$radii=get_option('sl_map_radii');
	}
}
/*--------------------------*/
function choose_units($unit, $input_name) {
	$unit_arr[]="%";$unit_arr[]="px";$unit_arr[]="em";$unit_arr[]="pt";
	$select_field="<select name='$input_name'>";
	
	//global $height_units, $width_units;
	
	foreach ($unit_arr as $value) {
		$selected=($value=="$unit")? " selected='selected' " : "" ;
		if (!($input_name=="height_units" && $unit=="%")) {
			$select_field.="\n<option value='$value' $selected>$value</option>";
		}
	}
	$select_field.="</select>";
	return $select_field;
}
/*----------------------------*/
function do_geocoding($address,$sl_id="") {
	global $wpdb, $text_domain;
	if (!defined("MAPS_HOST")){define("MAPS_HOST", get_option('sl_google_map_domain'));}
	$delay = 0; $base_url = "http://maps.googleapis.com/maps/api/geocode/json?";
	if ($sensor!="" && !empty($sensor)) {$base_url .= "sensor=".$sensor;} else {$base_url .= "sensor=false";}
	$request_url = $base_url . "&address=" . urlencode(trim($address));
	$ccTLD_arr=explode(".", MAPS_HOST);
	$ccTLD=trim($ccTLD_arr[count($ccTLD_arr)-1]);
	if ($ccTLD!="com") {
		$request_url .= "&region=".$ccTLD;
		//die($request_url);
	}
	//New code to accomdate those without 'file_get_contents' functionality for their server - added 3/27/09 8:56am - provided by Daniel C. - thank you
	if (extension_loaded("curl") && function_exists("curl_init")) {
		$cURL = curl_init();
		curl_setopt($cURL, CURLOPT_URL, $request_url);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
		$resp_json = curl_exec($cURL);
		curl_close($cURL);  
	}else{
		$resp_json = file_get_contents($request_url) or die("url not loading");
	}
	//End of new code
	$resp = json_decode($resp_json, true);
	$status = $resp['status'];
	$lat = (!empty($resp['results'][0]['geometry']['location']['lat']))? $resp['results'][0]['geometry']['location']['lat'] : "" ;
	$lng = (!empty($resp['results'][0]['geometry']['location']['lng']))? $resp['results'][0]['geometry']['location']['lng'] : "" ;
	if (strcmp($status, "OK") == 0) {
		// successful geocode
		$geocode_pending = false;
		$lat = $resp['results'][0]['geometry']['location']['lat'];
		$lng = $resp['results'][0]['geometry']['location']['lng'];

		if ($sl_id==="") {
			$query = sprintf("UPDATE ".$wpdb->prefix."store_locator SET sl_latitude = '%s', sl_longitude = '%s' WHERE sl_id = '%s' LIMIT 1;", mysql_real_escape_string($lat), mysql_real_escape_string($lng), mysql_real_escape_string($wpdb->insert_id)); //die($query); 
		} else {
			$query = sprintf("UPDATE ".$wpdb->prefix."store_locator SET sl_latitude = '%s', sl_longitude = '%s' WHERE sl_id = '%s' LIMIT 1;", mysql_real_escape_string($lat), mysql_real_escape_string($lng), mysql_real_escape_string($sl_id)); 
		}
		$update_result = mysql_query($query);
		if (!$update_result) {
			die("Invalid query: " . mysql_error());
		}
    } else if (strcmp($status, "OVER_QUERY_LIMIT") == 0) {
		// sent geocodes too fast
		$delay += 100000;
    } else {
		// failure to geocode
		$geocode_pending = false;
		echo __("Address " . $address . " <font color=red>failed to geocode</font>. ", $text_domain);
		echo __("Received status " . $status , $text_domain)."\n<br>";
    }
    usleep($delay);
}
/*-------------------------------*/
function sl_install_tables() {
	global $wpdb, $sl_db_version, $sl_path, $sl_upload_path;

	$table_name = $wpdb->prefix . "store_locator";
	$sql = "CREATE TABLE " . $table_name . " (
			sl_id mediumint(8) unsigned NOT NULL auto_increment,
			sl_store varchar(255) NULL,
			sl_address varchar(255) NULL,
			sl_address2 varchar(255) NULL,
			sl_city varchar(255) NULL,
			sl_state varchar(255) NULL,
			sl_zip varchar(255) NULL,
			sl_latitude varchar(255) NULL,
			sl_longitude varchar(255) NULL,
			sl_tags mediumtext NULL,
			sl_description varchar(255) NULL,
			sl_url varchar(255) NULL,
			sl_hours varchar(255) NULL,
			sl_phone varchar(255) NULL,
			sl_image varchar(255) NULL,
			sl_private varchar(1) NULL,
			sl_neat_title varchar(255) NULL,
			PRIMARY KEY  (sl_id)
			) ENGINE=innoDB  DEFAULT CHARACTER SET=utf8  DEFAULT COLLATE=utf8_unicode_ci;";
			
	$table_name_2 = $wpdb->prefix . "sl_tag";
	$sql .= "CREATE TABLE " . $table_name_2 . " (
			sl_tag_id bigint(20) unsigned NOT NULL auto_increment,
			sl_tag_name varchar(255) NULL,
			sl_tag_slug varchar(255) NULL,
			sl_id mediumint(8) NULL,
			PRIMARY KEY  (sl_tag_id)
			) ENGINE=innoDB  DEFAULT CHARACTER SET=utf8  DEFAULT COLLATE=utf8_unicode_ci;";
	
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		add_option("sl_db_version", $sl_db_version);
	}
	
	$installed_ver = get_option( "sl_db_version" );
	if( $installed_ver != $sl_db_version ) {
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		update_option("sl_db_version", $sl_db_version);
	}
	
	move_upload_directories();
}
/*-------------------------------*/
function head_scripts() {
	global $sl_dir, $sl_base, $sl_upload_base, $sl_path, $sl_upload_path, $wpdb, $sl_version, $pagename, $map_character_encoding;
	
	print "\n<!-- ========= Google Maps Store Locator for WordPress (v$sl_version) | http://www.viadat.com/store-locator/ ========== -->\n";
	//print "<!-- ========= Learn More & Download Here: http://www.viadat.com/store-locator ========== -->\n";

	//Check if currently on page with shortcode
	$_GET['p']=(!empty($_GET['p']))? $_GET['p'] : ""; $_GET['page_id']=(!empty($_GET['page_id']))? $_GET['page_id'] : "";
	$on_sl_page=$wpdb->get_results("SELECT post_name FROM ".$wpdb->prefix."posts WHERE LOWER(post_content) LIKE '%[store-locator%' AND post_status IN ('publish', 'draft') AND (post_name='$pagename' OR ID='".mysql_real_escape_string($_GET['p'])."' OR ID='".mysql_real_escape_string($_GET['page_id'])."')", ARRAY_A);		
	//Checking if code used in posts	
	$sl_code_is_used_in_posts=$wpdb->get_results("SELECT post_name FROM ".$wpdb->prefix."posts WHERE LOWER(post_content) LIKE '%[store-locator%' AND post_type='post'");
	//If shortcode used in posts, get post IDs, and put into array of numbers
	if ($sl_code_is_used_in_posts) {
		$sl_post_ids=$wpdb->get_results("SELECT ID FROM ".$wpdb->prefix."posts WHERE LOWER(post_content) LIKE '%[store-locator%' AND post_type='post'", ARRAY_A);
		foreach ($sl_post_ids as $val) { $post_ids_array[]=$val['ID'];}
	}		
	else {		
		$post_ids_array=array(9999999999999999999999999999999999999); //post number that'll never be reached
	}
	//print_r($post_ids_array);
	
	//If on page with store locator shortcode, on an archive, search, or 404 page while shortcode has been used in a post, on the front page, or a specific post with shortcode, display code, otherwise, don't
	if ($on_sl_page || is_search() || ((is_archive() || is_404()) && $sl_code_is_used_in_posts) || is_front_page() || is_single($post_ids_array)) {
		$api_key=get_option('store_locator_api_key');
		$google_map_domain=(get_option('sl_google_map_domain')!="")? get_option('sl_google_map_domain') : "maps.google.com";
	
		print "<script src='http://$google_map_domain/maps?file=api&amp;v=2&amp;key=$api_key&amp;sensor=false{$map_character_encoding}' type='text/javascript'></script>\n";
		//print "<script src='".$sl_base."/js/store-locator-js.php' type='text/javascript'></script>";

//dynamic js
//find_wp_config(); 
		print "<script type=\"text/javascript\">\n";
		include("variables.sl.php");
$zl=(trim(get_option('sl_zoom_level'))!="")? get_option('sl_zoom_level') : 4;
$mt=(trim(get_option('sl_map_type'))!="")? get_option('sl_map_type') : "G_NORMAL_MAP";
$wl=(trim(get_option('sl_website_label'))!="")? parseToXML(get_option('sl_website_label')) : "Website";
$dl=(trim(get_option('sl_directions_label'))!="")? parseToXML(get_option('sl_directions_label')) : "Directions";
$du=(trim(get_option('sl_distance_unit'))!="")? get_option('sl_distance_unit') : "miles";
$oc=(trim(get_option('sl_map_overview_control'))!="")? get_option('sl_map_overview_control') : 0;
print "if (document.getElementById('map')){window.onunload = function (){ GUnload(); }}
var add_base='".$sl_base."'; 
var add_upload_base='".$sl_upload_base."'; 
var sl_map_home_icon='".get_option('sl_map_home_icon')."'; 
var sl_map_end_icon='".get_option('sl_map_end_icon')."'; 
var sl_google_map_country='".parseToXML(get_option('sl_google_map_country'))."'; 
var sl_google_map_domain='".get_option('sl_google_map_domain')."'; 
var sl_zoom_level=$zl; 
var sl_map_type=$mt; 
var sl_website_label='$wl'; 
var sl_directions_label='$dl';
var sl_load_locations_default='".get_option('sl_load_locations_default')."'; 
var sl_distance_unit='$du'; 
var sl_map_overview_control='$oc';\n";
if (ereg($sl_upload_base, get_option('sl_map_home_icon'))){
	$home_icon_path=ereg_replace($sl_upload_base, $sl_upload_path, get_option('sl_map_home_icon'));
} else {
	$home_icon_path=ereg_replace($sl_base, $sl_path, get_option('sl_map_home_icon'));
}
$home_size=(function_exists("getimagesize") && file_exists($home_icon_path))? getimagesize($home_icon_path) : array(0 => 20, 1 => 34);
//$home_size=($home_size[0]=="")? array(0 => 20, 1 => 34) : $home_size;
print "var sl_map_home_icon_width=$home_size[0];\n";
print "var sl_map_home_icon_height=$home_size[1];\n";
if (ereg($sl_upload_base, get_option('sl_map_end_icon'))){
	$end_icon_path=ereg_replace($sl_upload_base, $sl_upload_path, get_option('sl_map_end_icon'));
} else {
	$end_icon_path=ereg_replace($sl_base, $sl_path, get_option('sl_map_end_icon'));
}
$end_size=(function_exists("getimagesize") && file_exists($end_icon_path))? getimagesize($end_icon_path) : array(0 => 20, 1 => 34);
//$end_size=($end_size[0]=="")? array(0 => 20, 1 => 34) : $end_size;
print "var sl_map_end_icon_width=$end_size[0];\n";
print "var sl_map_end_icon_height=$end_size[1];\n</script>\n";
//end dynamic js

		print "<script src='".$sl_base."/js/store-locator.js' type='text/javascript'></script>
<script src='".$sl_base."/js/functions.js' type='text/javascript'></script>\n";
		//print "<link  href='".$sl_base."/base.css' type='text/css' rel='stylesheet'/>\n"; //merged into store-locator.css 12/31/09 (v1.2.37)
		//if store-locator.css exists in custom-css/ folder in uploads/ dir it takes precedence over, store-locator.css in store-locator plugin directory to allow for css customizations to be preserved after updates
		$has_custom_css=(file_exists($sl_upload_path."/custom-css/store-locator.css"))? $sl_upload_base."/custom-css" : $sl_base; 
		print "<link  href='".$has_custom_css."/store-locator.css' type='text/css' rel='stylesheet'/>";
		$theme=get_option('sl_map_theme');
		if ($theme!="") {print "\n<link  href='".$sl_upload_base."/themes/$theme/style.css' rel='stylesheet' type='text/css'/>";}
		$zl=(trim(get_option('sl_zoom_level'))!="")? get_option('sl_zoom_level') : 4;		

			//print "<style></style>";
		move_upload_directories();
	}
	else {
		$sl_page_ids=$wpdb->get_results("SELECT ID FROM ".$wpdb->prefix."posts WHERE LOWER(post_content) LIKE '%[store-locator%' AND post_status='publish'", ARRAY_A);
		print "<!-- No store locator on this page, so no unnecessary scripts for better site performance. (";
		if ($sl_page_ids) {
			foreach ($sl_page_ids as $value) { print "$value[ID],";}
		}
		print ")-->";
	}
	print "\n<!-- ========= End Google Maps Store Locator for WordPress ========== -->\n\n";
}
/*-------------------------------*/
function foot_scripts() {
	//print "<script type='text/javascript'>if (document.getElementById('map')){load();}</script>";
}
/*-------------------------------*/
function ajax_map($content) {

	global $sl_dir, $sl_base, $sl_upload_base, $sl_path, $sl_upload_path, $text_domain, $wpdb;
	if(! preg_match('|\[store-locator|i', $content)) {
		return $content;
	}
	else {
		$height=(get_option('sl_map_height'))? get_option('sl_map_height') : "500" ;
		$width=(get_option('sl_map_width'))? get_option('sl_map_width') : "100" ;
		$radii=(get_option('sl_map_radii'))? get_option('sl_map_radii') : "1,5,10,(25),50,100,200,500" ;
		$height_units=(get_option('sl_map_height_units'))? get_option('sl_map_height_units') : "px";
		$width_units=(get_option('sl_map_width_units'))? get_option('sl_map_width_units') : "%";
		$sl_instruction_message=(get_option('sl_instruction_message'))? get_option('sl_instruction_message') : "Enter Your Address or Zip Code Above.";
	
		$r_array=explode(",", $radii);
		$search_label=(get_option('sl_search_label'))? get_option('sl_search_label') : "Address" ;
		
		$unit_display=(get_option('sl_distance_unit')=="km")? "km" : "mi";
		$r_options="";
		foreach ($r_array as $value) {
			$s=(ereg("\(.*\)", $value))? " selected='selected' " : "" ;
			$value=ereg_replace("[^0-9]", "", $value);
			$r_options.="<option value='$value' $s>$value $unit_display</option>";
		}
		
		if (get_option('sl_use_city_search')==1) {
			$cs_array=$wpdb->get_results("SELECT CONCAT(TRIM(sl_city), ', ', TRIM(sl_state)) as city_state FROM ".$wpdb->prefix."store_locator WHERE sl_city<>'' AND sl_state<>'' AND sl_latitude<>'' AND sl_longitude<>'' GROUP BY city_state ORDER BY city_state ASC", ARRAY_A);
			//var_dump($cs_array); die();
			if ($cs_array) {
				$cs_options="";
				foreach($cs_array as $value) {
$cs_options.="<option value='$value[city_state]'>$value[city_state]</option>";
				}
			}
		}
		/*if (get_option('sl_use_name_search')==1) {
			$name_array=$wpdb->get_results("SELECT sl_store FROM ".$wpdb->prefix."store_locator WHERE sl_store<>'' ORDER BY sl_store ASC", ARRAY_A);
			//var_dump($cs_array); die();
			if ($name_array) {
				foreach($name_array as $value) {
					$name_options.="<option value='".comma($value[sl_store])."'>".comma($value[sl_store])."</option>";
				}
			}
		}*/
	
	if (get_option('sl_map_theme')!="") {
		$theme_base=$sl_upload_base."/themes/".get_option('sl_map_theme');
		$theme_path=$sl_upload_path."/themes/".get_option('sl_map_theme');	
	}
	else {
		$theme_base=$sl_upload_base."/images";
		$theme_path=$sl_upload_path."/images";
	}
	if (!file_exists($theme_path."/search_button.png")) {
		$theme_base=$sl_base."/images";
		$theme_path=$sl_path."/images";
	}
	$submit_img=$theme_base."/search_button.png";
	$loading_img=(file_exists($sl_upload_path."/images/loading.gif"))? $sl_upload_base."/images/loading.gif" : $sl_base."/images/loading.gif"; //for loading/processing gif image
	$mousedown=(file_exists($theme_path."/search_button_down.png"))? "onmousedown=\"this.src='$theme_base/search_button_down.png'\" onmouseup=\"this.src='$theme_base/search_button.png'\"" : "";
	$mouseover=(file_exists($theme_path."/search_button_over.png"))? "onmouseover=\"this.src='$theme_base/search_button_over.png'\" onmouseout=\"this.src='$theme_base/search_button.png'\"" : "";
	$button_style=(file_exists($theme_path."/search_button.png"))? "type='image' src='$submit_img' $mousedown $mouseover" : "type='submit'";
	$button_style.=" onclick=\"showLoadImg('show');\""; //added 3/30/12 for loading/processing gif image
	//print "$submit_img | ".$sl_upload_path."/themes/".get_option('sl_map_theme')."/search_button.png";
	$hide=(get_option('sl_remove_credits')==1)? "style='display:none;'" : "";
	
$form="
<div id='sl_div'>
  <form onsubmit='searchLocations(); return false;' id='searchForm' action=''>
    <table border='0' cellpadding='3px' class='sl_header' style='width:$width$width_units;'><tr>
	<td valign='top' id='search_label'>$search_label&nbsp;</td>
	<td ";
	
	if (get_option('sl_use_city_search')!=1) {$form.=" colspan='4' ";}
	
	$form.=" valign='top'><input type='text' id='addressInput' size='50' /></td>
	";
	
	if ($cs_array && get_option('sl_use_city_search')==1) {
		$form.="<td valign='top'></td>";
	}
	
	if ($cs_array && get_option('sl_use_city_search')==1) {
	$form.="
	<td id='addressInput2_container' colspan='2'>";
	$form.="<select id='addressInput2' onchange='aI=document.getElementById(\"searchForm\").addressInput;if(this.value!=\"\"){oldvalue=aI.value;aI.value=this.value;}else{aI.value=oldvalue;}'>
<option value=''>--".__("Search By City", $text_domain)."--</option>$cs_options</select></td>";
	}
	
	/*if ($name_array && get_option('sl_use_name_search')==1) {
		$form.="<td valign='top'><nobr>&nbsp;<b>OR</b>&nbsp;</nobr></td>";
	}
	
	if ($name_array && get_option('sl_use_name_search')==1) {
	$form.="
	<td valign='top'>";
	$form.="<select id='addressInput3' onchange='aI=document.getElementById(\"searchForm\").addressInput;if(this.value!=\"\"){oldvalue=aI.value;aI.value=this.value;}else{aI.value=oldvalue;}'>
	<option value=''>--Search By Name--</option>
	$name_options
    </select>";
	
	//$form.="<input name='addressInput3'><input type='hidden' value='1' name='name_search'></td>";
	}*/
	
	$sl_radius_label=get_option('sl_radius_label');
	$form.="
	</tr><tr>
	 <td id='radius_label'>".__("$sl_radius_label", $text_domain)."</td>
	 <td id='radiusSelect_td' ";
	
	if (get_option('sl_use_city_search')==1) {$form.="colspan='2'";}
	 
	$form.="><select id='radiusSelect'>$r_options</select>
	</td>
	<td valign='top' ";
	
	if (get_option('sl_use_city_search')!=1) {$form.="colspan='2'";}
	
	$form.=" ><input $button_style value='Search Locations' id='addressSubmit'/></td>
	<td><img src='$loading_img' id='loadImg' style='opacity:0; filter:alpha(opacity=0); height:28px; vertical-align:bottom; position:relative; '></td>
	</tr></table>
<table width='100%' cellspacing='0px' cellpadding='0px' style='/*border:solid silver 1px*/'> 
     <tr>
        <td width='100%' valign='top' id='map_td'> <div id='map' style='width:$width$width_units; height:$height$height_units'></div><table cellpadding='0px' class='sl_footer' width='$width$width_units;' $hide><tr><td class='sl_footer_left_column'><a href='http://www.viadat.com/store-locator' target='_blank'>LotsOfLocales&trade;</a></td><td class='sl_footer_right_column'> <a href='http://www.viadat.com' target='_blank' title='by Viadat Creations'>by Viadat</a></td></tr></table>
		</td>
      </tr>
	  <tr id='cm_mapTR'>
        <td width='' valign='top' style='/*display:hidden; border-right:solid silver 1px*/' id='map_sidebar_td'> <div id='map_sidebar' style='width:$width$width_units;/* $height$height_units; */'> <div class='text_below_map'>$sl_instruction_message</div></div>
        </td></tr>
  </table></form>
<p><script type=\"text/javascript\">if (document.getElementById(\"map\")){setTimeout(\"sl_load()\",1000);}</script></p>
</div>";
	
	return eregi_replace("\[store-locator(.*)?\]", $form, $content);
	}
}
/*-----------------------------------*/
function sl_add_options_page() {
	global $sl_dir, $sl_base, $sl_upload_base, $text_domain, $map_character_encoding;
	
	$api=get_option('store_locator_api_key');
	add_menu_page(__("Store Locator", $text_domain), __("Store Locator", $text_domain), 'administrator', $sl_dir.'/news-upgrades.php');
	add_submenu_page($sl_dir.'/news-upgrades.php', __("News & Upgrades", $text_domain), __("News & Upgrades", $text_domain), 'administrator', $sl_dir.'/news-upgrades.php');
	add_submenu_page($sl_dir.'/news-upgrades.php', __("Manage Locations", $text_domain), __("Manage Locations", $text_domain), 'administrator', $sl_dir.'/view-locations.php');
	add_submenu_page($sl_dir.'/news-upgrades.php', __("Add Locations", $text_domain), __("Add Locations", $text_domain), 'administrator', $sl_dir.'/add-locations.php');
	add_submenu_page($sl_dir.'/news-upgrades.php', __("Map Designer", $text_domain), __("Map Designer", $text_domain), 'administrator', $sl_dir.'/map-designer.php');
	add_submenu_page($sl_dir.'/news-upgrades.php', __("Localization", $text_domain)." &amp; ".__("Google API Key", $text_domain),  __("Localization", $text_domain)." &amp; ".__("Google API Key", $text_domain), 'administrator', $sl_dir.'/api-key.php');
	add_submenu_page($sl_dir.'/news-upgrades.php', __("ReadMe", $text_domain), __("ReadMe", $text_domain), 'administrator', $sl_dir.'/readme.php');
	
}

function add_admin_javascript() {
        global $sl_base, $sl_upload_base, $sl_dir, $google_map_domain, $sl_path, $sl_upload_path, $map_character_encoding;
		$api=get_option('store_locator_api_key');
        print "<script src='".$sl_base."/js/functions.js'></script>\n";

//New WP Admin Bar in version 3+ gets in the way of editing a specific location, hide it
if (ereg("view-locations", $_GET['page'])) {
	print "<style>#wpadminbar {
	display:none !important;
}</style>";
}
        print "<script type='text/javascript'>
        var sl_dir='".$sl_dir."';
        var sl_google_map_country='".get_option('sl_google_map_country')."';
        </script>\n";
        if (ereg("add-locations", $_GET['page'])) {
            $google_map_domain=(get_option('sl_google_map_domain')!="")? get_option('sl_google_map_domain') : "maps.google.com";
			
            print "<script src='http://$google_map_domain/maps?file=api&amp;v=2&amp;key=$api&amp;sensor=false{$map_character_encoding}' type='text/javascript'></script>\n";
            if (file_exists($sl_upload_path."/addons/point-click-add/point-click-add.js")) {
				print "<script src='".$sl_upload_base."/addons/point-click-add/point-click-add.js'></script>\n";
			} elseif (file_exists($sl_path."/js/point-click-add.js")) {
				print "<script src='".$sl_base."/js/point-click-add.js'></script>\n";
			}
        }
}

function add_admin_stylesheet() {
  global $sl_base;
  print "<link rel='stylesheet' type='text/css' href='".$sl_base."/admin.css'>\n";
}
/*---------------------------------*/
function set_query_defaults() {
	global $where, $o, $d, $wpdb;
	//print sprintf(" WHERE sl_store LIKE '%%%s%%' OR sl_address LIKE '%%%s%%' OR sl_city LIKE '%%%s%%' OR sl_state LIKE '%%%s%%' OR sl_zip LIKE '%%%s%%' OR sl_tags LIKE '%%%s%%'", $_GET['q'], $_GET['q'], $_GET['q'], $_GET['q'], $_GET['q'], $_GET['q']); die();
	$where=($_GET['q']!="")? $wpdb->prepare(" WHERE sl_store LIKE '%%%s%%' OR sl_address LIKE '%%%s%%' OR sl_city LIKE '%%%s%%' OR sl_state LIKE '%%%s%%' OR sl_zip LIKE '%%%s%%' OR sl_tags LIKE '%%%s%%'", $_GET['q'], $_GET['q'], $_GET['q'], $_GET['q'], $_GET['q'], $_GET['q']) : "" ;
	$o=(!empty($_GET['o']))? mysql_real_escape_string($_GET['o']) : "sl_store";
	$d=(empty($_GET['d']) || $_GET['d']=="DESC")? "ASC" : "DESC";
}
/*----------------------------------*/
function match_imported_data($the_array) {
	global $text_domain;
	print "<h3>".__("Choose Heading That Matches Columns You Want to Import", $text_domain).":</h3>(".__("Leave headings for undesired columns unchanged", $text_domain).")<br><br>
<form method='post'>
<input type='button' value='".__("Cancel", $text_domain)."' class='button' onclick='history.go(-1)'>&nbsp;<input type='submit' value='".__("Import Locations", $text_domain)."' class='button'>
<table class='widefat'><thead><tr style='/*background-color:black*/'>";

$array_to_be_counted=(is_array($the_array[0]))? $the_array[0] : $the_array[1] ; //needed for the csv import (where first line is usually skipped)  vs the point-click-add import (where there's only the first line)
for ($ctr=1; $ctr<=count($array_to_be_counted); $ctr++) {
	print "<td><select name='field_map[]'>";
	print "<option value=''>".__("Choose")."</option>
			<option value='sl_store'>".__("Name", $text_domain)."</option>
				<option value='sl_address'>".__("Street(Line1)", $text_domain)."</option>
				<option value='sl_address2'>".__("Street(Line2)", $text_domain)."</option>
				<option value='sl_city'>".__("City", $text_domain)."</option>
				<option value='sl_state'>".__("State", $text_domain)."</option>
				<option value='sl_zip'>".__("Zip", $text_domain)."</option>
				<option value='sl_tags'>".__("Tags", $text_domain)."</option>
				<option value='sl_description'>".__("Description", $text_domain)."</option>
				<option value='sl_hours'>".__("Hours", $text_domain)."</option>
				<option value='sl_url'>".__("URL", $text_domain)."</option>
				<option value='sl_phone'>".__("Phone", $text_domain)."</option>
				<option value='sl_image'>".__("Image", $text_domain)."</option>
				<option value='sl_private'>".__("Is Private?", $text_domain)."</option>";
	print "</select></td>";
}
print "</tr></thead>";

foreach ($the_array as $key=>$value) {
	print "<tr style='border-bottom:solid silver 1px'>";
	$bgcolor="#ddd";
	$ctr2=0;
	foreach ($value as $key2=>$value2) {
		//if (ereg("^[0-9]", $key2)) {
			$bgcolor=($bgcolor=="#fff" || empty($bgcolor))? "#ddd" : "#fff";
			print "<td style='background-color:$bgcolor'>$value2<input type='hidden' value='$value2' name='column{$ctr2}[]'></td>\n";
			$ctr2++;
		//}
	}
	print "</tr>\n";
}
print "</table><input type='hidden' name='finish_import' value='1'>
<input type='hidden' name='total_entries' value='".(count($the_array))."'>
<input type='button' value='".__("Cancel", $text_domain)."' class='button' onclick='history.go(-1)'>&nbsp;<input type='submit' value='".__("Import Locations", $text_domain)."' class='button'></form>";
}
/*--------------------------------------------------------------*/

function do_hyperlink(&$text, $target="'_blank'", $type="both")
{
  if ($type=="both" || $type=="protocol") {	
   // match protocol://address/path/
   $text = ereg_replace("[a-zA-Z]+://([.]?[a-zA-Z0-9_/?&amp;%20,=-\+-\#])+", "<a href=\"\\0\" target=$target>\\0</a>", $text);
  }
  if ($type=="both" || $type=="noprotocol") {
   // match www.something
   $text = ereg_replace("(^| )(www([.]?[a-zA-Z0-9_/=-\+-\#])*)", "\\1<a href=\"http://\\2\" target=$target>\\2</a>", $text);
  }

return $text;
}
/*--------------------------------------------------------------*/
function find_wp_config() {
if (file_exists("./wp-config.php")){include("./wp-config.php");}
elseif (file_exists("../wp-config.php")){include("../wp-config.php");}
elseif (file_exists("../../wp-config.php")){include("../../wp-config.php");}
elseif (file_exists("../../../wp-config.php")){include("../../../wp-config.php");}
elseif (file_exists("../../../../wp-config.php")){include("../../../../wp-config.php");}
elseif (file_exists("../../../../../wp-config.php")){include("../../../../../wp-config.php");}
elseif (file_exists("../../../../../../wp-config.php")){include("../../../../../../wp-config.php");}
elseif (file_exists("../../../../../../../wp-config.php")){include("../../../../../../../wp-config.php");}
elseif (file_exists("../../../../../../../../wp-config.php")){include("../../../../../../../../wp-config.php");}
}
/*--------------------------------------------------------------*/
function insert_matched_data() {
	global $wpdb;

	$ctr=0;
	foreach ($_POST[field_map] as $value) {
		if($value!="") {
			$selected_fields.="$value,";
			$column_number[]=$ctr;
			if ($value=="sl_tags") {
				$sl_tags_position=$ctr;
			}
		}
		$ctr++;
	}
	$selected_fields=substr($selected_fields,0, strlen($selected_fields)-1);

	
	for ($entry_number=0; $entry_number<$_POST[total_entries]; $entry_number++) { 
		for ($ctr2=0; $ctr2<count($column_number); $ctr2++) {
			//print "'".$_POST["column{$column_number[$ctr2]}"][$entry_number]."',";
			//die();
			$val=trim($_POST["column{$column_number[$ctr2]}"][$entry_number]);
			if ($val==trim($_POST["column{$sl_tags_position}"][$entry_number])) {
				$val=prepare_tag_string($val);
			}
			$value_string.=$wpdb->prepare("%s", $val).",";
			//die($value_string);
		}
		$value_string=substr($value_string,0, strlen($value_string)-1);
		$wpdb->query("INSERT INTO ".$wpdb->prefix."store_locator ($selected_fields) VALUES ($value_string)");
		$current_loc_id=$wpdb->insert_id;
		$for_geo=$wpdb->get_results("SELECT CONCAT(sl_address, ', ', sl_city, ', ', sl_state, ' ', sl_zip) as the_address FROM ".$wpdb->prefix."store_locator WHERE sl_id='".$current_loc_id."'", ARRAY_A);
		//var_dump($for_geo);  
		//exit();
		do_geocoding($for_geo[0][the_address]);
		$value_string="";
		if (!empty($sl_tags_position) && trim($_POST["column{$sl_tags_position}"][$entry_number])!="") {
			sl_process_tags($_POST["column{$sl_tags_position}"][$entry_number], "insert", $current_loc_id);
		}

		}
}
/*-------------------------------------------------------------*/
function comma($a) {
	$a=ereg_replace('"', "&quot;", $a);
	$a=ereg_replace("'", "&#39;", $a);
	$a=ereg_replace(">", "&gt;", $a);
	$a=ereg_replace("<", "&lt;", $a);
	$a=ereg_replace(" & ", " &amp; ", $a);
	return ereg_replace("," ,"&#44;" ,$a);
	
}
/*------------------------------------------------------------*/
function addon_activation_message($url_of_upgrade="") {
	global $sl_dir, $text_domain;
	print "<div style='background-color:#eee; border:solid silver 1px; padding:7px; color:black'>".__("You haven't activated this upgrade yet", $text_domain).". <a href='".get_option('siteurl')."/wp-admin/admin.php?page=$sl_dir/news-upgrades.php'>".__("Activate", $text_domain)."</a></div><br>";
}
/*-----------------------------------------------------------*/
function url_test($url)
{
	if(strtolower(substr($url,0,7))=="http://")	{
		return TRUE; }
	else{
		return FALSE; }
}
/*-----------------------------------------------------------*/
function sl_process_tags($tag_string, $db_action="insert", $sl_id="") {
	global $wpdb;
	$id_string="";
	
	//die($sl_id." - sl_id - start of process tags func"); 
	
	if (!is_array($sl_id) && ereg(",", $sl_id)) {
		$id_string=$sl_id;
		$sl_id=explode(",",$id_string);
		$rplc_arr=array_fill(0, count($sl_id), "%d"); //var_dump($rplc_arr); //die();
		$id_string=implode(",", array_map(array($wpdb, "prepare"), $rplc_arr, $sl_id));
	} elseif (is_array($sl_id)) {
		$rplc_arr=array_fill(0, count($sl_id), "%d"); //var_dump($rplc_arr); //die();
		$id_string=implode(",", array_map(array($wpdb, "prepare"), $rplc_arr, $sl_id));
	} else {
		$id_string=$wpdb->prepare("%d", $sl_id);
	}
	
	//creating array of tags
	if (ereg(",", $tag_string)) {
		//$tag_string=preg_replace("/[ ]*/", "", $tag_string);
		$tag_string=preg_replace('/[^A-Za-z0-9_\-,]/', '', $tag_string);
		$sl_tag_array=array_map('trim',explode(",",trim($tag_string)));
		$sl_tag_array=array_map('strtolower', $sl_tag_array);
		//$rplc_arr=array_fill(0, count($sl_tag_array), "%s"); //var_dump($rplc_arr); //die();
		//$sl_tag_array=array_map(array($wpdb, "prepare"), $rplc_arr, $sl_tag_array);
	} else {
		//$sl_tag_array[]=$wpdb->prepare("%s", strtolower(trim($tag_string)));
		$sl_tag_array[]=strtolower(trim($tag_string));
	}
	//$wpdb->query("DELETE FROM ".$wpdb->prefix."sl_tag WHERE sl_id IN ($id_string)"); //clear current tags for locations being modified
	
	if ($db_action=="insert") {		
		//build insert query
		$query="INSERT INTO ".$wpdb->prefix."sl_tag (sl_tag_slug, sl_id) VALUES ";
		if (!is_array($sl_id)) {
			$main_sl_id=($sl_id=="")? $wpdb->insert_id : $sl_id ;	
			foreach ($sl_tag_array as $value)  {
				if (trim($value)!="") {
					$query.="('$value', '$main_sl_id'),";
				}
			}
		} elseif (is_array($sl_id)) {
			foreach ($sl_id as $value2) {
				$main_sl_id=$value2;
				foreach ($sl_tag_array as $value)  {
					if (trim($value)!="") {
						$query.="('$value', '$main_sl_id'),";
					}
				}
			}
		}
		$query=substr($query, 0, strlen($query)-1); // remove last comma 
		//die($query);
	} elseif ($db_action=="delete") {
		if (trim($tag_string)=="") {
			$query="DELETE FROM ".$wpdb->prefix."sl_tag WHERE sl_id IN ($id_string)";
			//die($query);
		} else {
			//var_dump($sl_tag_array); die();
			$t_string=implode("','", $sl_tag_array); //die($t_string);
			$query="DELETE FROM ".$wpdb->prefix."sl_tag WHERE sl_id IN ($id_string) AND sl_tag_slug IN ('".trim($t_string)."')";
			//die($query."\n");
		}
	} 
	$wpdb->query($query);
	
}
/*-----------------------------------------------------------*/
function prepare_tag_string($sl_tags) {
	//$sl_tags=preg_replace('/[ ]*\&\#44\;[ ]*/', '&#44; ', $sl_tags);
	$sl_tags=preg_replace('/\,+/', ', ', $sl_tags);
	$sl_tags=preg_replace('/(\&\#44\;)+/', '&#44; ', $sl_tags);
	$sl_tags=preg_replace('/[^A-Za-z0-9_\-,]/', '', $sl_tags);
	if (substr($sl_tags, 0, 1) == ",") {
		$sl_tags=substr($sl_tags, 1, strlen($sl_tags));
	}
	if (substr($sl_tags, strlen($sl_tags)-1, 1) != "," && trim($sl_tags)!="") {
		$sl_tags.=",";
	}
	$sl_tags=preg_replace('/\,+/', ', ', $sl_tags);
	$sl_tags=preg_replace('/(\&\#44\;)+/', '&#44; ', $sl_tags);
	$sl_tags=preg_replace('/[ ]*,[ ]*/', ', ', $sl_tags);
	$sl_tags=preg_replace('/[ ]*\&\#44\;[ ]*/', '&#44; ', $sl_tags);
	$sl_tags=trim($sl_tags);
	return $sl_tags;
}
?>
