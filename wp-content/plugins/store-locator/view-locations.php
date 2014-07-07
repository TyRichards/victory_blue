<?php
include("variables.sl.php");
include("top-nav.php");
?>
<div class='wrap'>
<?php

print "<style>#wpadminbar {display:none !important;}</style>";

$hidden="";
foreach($_GET as $key=>$val) {
	//hidden keys to keep same view after form submission
	if ($key!="q" && $key!="o" && $key!="d" && $key!="changeView" && $key!="start") {
		$hidden.="<input type='hidden' value='$val' name='$key'>\n"; 
	}
}
//$view_all_link=(!empty($_GET[q]))?"<a href='?q=page=$sl_dir/view-locations.php' style='font-size:12px'>Back&nbsp;to&nbsp;View&nbsp;All</a>&nbsp;&nbsp;":"";
print "<form><table cellpadding='0px' cellspacing='0px' width='100%'><tr><td style='width:300px'>
<h2>".__("Manage Locations", $text_domain)."</h2></td>";

if ($num_ugc=$wpdb->get_var("SELECT COUNT(sl_id) FROM ".$wpdb->prefix."store_locator WHERE sl_longitude=0 OR sl_longitude='' OR sl_longitude IS NULL OR sl_latitude=0 OR sl_latitude='' OR sl_latitude IS NULL")) {
	if (!empty($_GET['ugc']) && $_GET['ugc']==1) {
		//Step 2 - submit selected un-geocoded locations
		$ugc_button_text="Attempt to Re-geocode Selected";
		$ugc_num=2;
		$_GET['q']="";$_GET['start']=0; //so that a search query won't interfere with showing ungeocoded locations
		$onclick_text="onclick=\"LF=document.forms['locationForm'];LF.act.value='regeocode';LF.submit();\"";
		$cancel_link="<a href='".ereg_replace("&ugc=$_GET[ugc]","",$_SERVER['REQUEST_URI'])."'>Cancel</a><br>";
	} else {
		//Step 1 - Show un-geocoded locations
		$ugc_button_text="Show Un-geocoded Locations ($num_ugc)";
		$ugc_num=1; $ugc=(!empty($_GET['ugc']))? $_GET['ugc'] : "" ;
		$onclick_text="onclick='location.href=\"".ereg_replace("&ugc=$ugc","",$_SERVER['REQUEST_URI'])."&ugc=$ugc_num\"'";
		$cancel_link="";
	}
	print "<td style='text-align:center'>$cancel_link<input type='button' value='$ugc_button_text' class='button-primary' style='/*background-image:-moz-linear-gradient(center bottom, #900, maroon); background-color: #900; border:maroon*/' $onclick_text></td>";
}
if (empty($_GET['q'])){ $_GET['q']=""; }
print "<td align='right' style='width:300px'><div style='float:right; padding-right:0px; width:100%'><input value='".comma(stripslashes($_GET['q']))."' name='q'><input type='submit' value='".__("Search Locations", $text_domain)."' class='button-primary'></div>$hidden</td></tr></table></form><br>";

initialize_variables();

	if (!empty($_GET['delete'])) {
		//If delete link is clicked
		$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."store_locator WHERE sl_id='%d'", $_GET['delete']));
		sl_process_tags("", "delete", $_GET['delete']);
	}
	if (!empty($_POST) && !empty($_GET['edit']) && $_POST['act']!="delete") {
		$field_value_str="";
		foreach ($_POST as $key=>$value) {
			if (ereg("\-$_GET[edit]", $key)) {
				$key=ereg_replace("\-$_GET[edit]", "", $key); // stripping off number at the end (giving problems when constructing address string below)
				if ($key=="sl_tags") {
					//print "before: $value <br><br>";
					$value=prepare_tag_string($value);
					//print "after: $value \r\n"; die();
				}
				$field_value_str.=$key."=".$wpdb->prepare("%s", trim(comma(stripslashes($value)))).", ";				
				$_POST["$key"]=$value; 
			}
		}

		$field_value_str=substr($field_value_str, 0, strlen($field_value_str)-2);
		$edit=$_GET['edit']; extract($_POST);
		$the_address="$sl_address $sl_address2, $sl_city, $sl_state $sl_zip";
		
		$old_address=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."store_locator WHERE sl_id='".mysql_real_escape_string($_GET['edit'])."'", ARRAY_A);
		//print "address: $the_address<br>";
		//print "UPDATE ".$wpdb->prefix."store_locator SET $field_value_str WHERE sl_id='$_GET[edit]'"; exit;
		//print "UPDATE ".$wpdb->prefix."store_locator SET $field_value_str WHERE sl_id='$_GET[edit]'"; exit;
		$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."store_locator SET $field_value_str WHERE sl_id='%d'", $_GET['edit']));
		if(!empty($_POST['sl_tags'])){sl_process_tags($_POST['sl_tags'], "insert", $_GET['edit']);}
		
		if ($the_address!=$old_address[0]['sl_address']." ".$old_address[0]['sl_address2'].", ".$old_address[0]['sl_city'].", ".$old_address[0]['sl_state']." ".$old_address[0]['sl_zip'] || ($old_address[0]['sl_latitude']=="" || $old_address[0]['sl_longitude']=="")) {
			do_geocoding($the_address,$_GET['edit']);
		}
		print "<script>location.replace('".ereg_replace("&edit=$_GET[edit]", "", $_SERVER['REQUEST_URI'])."');</script>";
	}
	
	if (!empty($_POST['act']) && !empty($_POST['sl_id']) && $_POST['act']=="delete") {
		//If bulk delete is used
		include("deleteLocations.php");
	}
	if (!empty($_POST['act']) && !empty($_POST['sl_id']) && eregi("tag", $_POST['act'])) {
		//if bulk tagging is used
		include("tagLocations.php");
	}
	if (!empty($_POST['act']) && eregi("multi", $_POST['act'])) {
		//if bulk updating is used
		include($sl_upload_path."/addons/multiple-field-updater/multiLocationUpdate.php");
	}
	if (!empty($_POST['act']) && $_POST['act']=="locationsPerPage") {
		//If change in locations per page
		update_option('sl_admin_locations_per_page', $_POST['sl_admin_locations_per_page']);
		extract($_POST);
	}
	if (!empty($_POST['act']) && $_POST['act']=="regeocode") {
		//var_dump($_POST); die();
		if ($_POST) {extract($_POST);}
		if (is_array($sl_id)==1) {
			$id_string="";
			foreach ($sl_id as $value) {
				$id_string.=mysql_real_escape_string($value).",";
			}
			$id_string=substr($id_string, 0, strlen($id_string)-1);
		}
		else {
			$id_string=mysql_real_escape_string($sl_id);
		}
		
		$locs=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."store_locator WHERE sl_id IN ($id_string)", ARRAY_A);
		foreach ($locs as $value) {
			do_geocoding("$value[sl_address] $value[sl_address2], $value[sl_city], $value[sl_state] $value[sl_zip]", $value['sl_id']);
		}
		print "<script>location.replace('".ereg_replace("&ugc=$_GET[ugc]", "", $_SERVER['REQUEST_URI'])."');</script>";
	}
	if (!empty($_GET['changeView']) && $_GET['changeView']==1) {
		if (get_option('sl_location_table_view')=="Normal") {
			update_option('sl_location_table_view', 'Expanded');
			$tabViewText="Expanded";
		} else {
			update_option('sl_location_table_view', 'Normal');
			$tabViewText="Normal";
		}
		$_SERVER['REQUEST_URI']=ereg_replace("&changeView=1", "", $_SERVER['REQUEST_URI']);
		print "<script>location.replace('$_SERVER[REQUEST_URI]');</script>";
	}
	if (!empty($_GET['changeUpdater']) && $_GET['changeUpdater']==1) {
		if (get_option('sl_location_updater_type')=="Tagging") {
			update_option('sl_location_updater_type', 'Multiple Fields');
			$updaterTypeText="Multiple Fields";
		} else {
			update_option('sl_location_updater_type', 'Tagging');
			$updaterTypeText="Tagging";
		}
		$_SERVER['REQUEST_URI']=ereg_replace("&changeUpdater=1", "", $_SERVER['REQUEST_URI']);
		print "<script>location.replace('$_SERVER[REQUEST_URI]');</script>";
	}

print "<form name='locationForm' method='post'>";
print "<table width=100%><tr><td width='33%'><b>".__("Current View", $text_domain).":</b>&nbsp;".get_option('sl_location_table_view')."&nbsp;(<a href='".ereg_replace("&changeView=1", "", $_SERVER['REQUEST_URI'])."&changeView=1'>".__("Change View", $text_domain)."</a>)</td>
<td width='33%' align='center'>
<nobr><b>".__("Locations Per Page", $text_domain).":</b> <select name='sl_admin_locations_per_page'>
<option value=''>".__("Choose", $text_domain)."</option>";

$opt_arr=array(10,25,50,100,200,300,400,500,1000,2000,4000,5000,10000);
foreach ($opt_arr as $value) {
	$selected=($sl_admin_locations_per_page==$value)? " selected " : "";
	print "<option value='$value' $selected>$value</option>";
}
print "</select><input type='button' value='".__("Change", $text_domain)."' class='button-primary' onclick=\"LF=document.forms['locationForm'];LF.act.value='locationsPerPage';LF.submit();\">
</nobr>
</td>
<td align=right width='33%'>";

if (file_exists($sl_upload_path."/addons/multiple-field-updater/multiLocationUpdate.php")) {
print "<b>".__("Updater", $text_domain).":</b>&nbsp;".get_option('sl_location_updater_type')."&nbsp;(<a href='".ereg_replace("&changeUpdater=1", "", $_SERVER['REQUEST_URI'])."&changeUpdater=1'>".__("Change Updater", $text_domain)."</a>)";
}

print "</td></tr></table><br>";
include("mgmt-buttons-links.php");
//print "<br>";

//establishes WHERE clause in query from URL querystring
set_query_defaults();

//overrides WHERE clause to show ungeocoded locations only
if(!empty($_GET['ugc']) && $_GET['ugc']==1) {
	$where="WHERE sl_longitude=0 OR sl_longitude='' OR sl_longitude IS NULL OR sl_latitude=0 OR sl_latitude='' OR sl_latitude IS NULL";
	print "<script>jQuery(document).ready(function(){checkAll(document.getElementById('master_checkbox'), document.forms[\"locationForm\"]);});</script>";
	$master_check="checked='checked'";
} elseif (!empty($_GET['ugc']) && $_GET['ugc']==2) {
	
} else {
	$master_check="";
}

//for search links
	$numMembers=$wpdb->get_results("SELECT sl_id FROM " . $wpdb->prefix . "store_locator $where");
	$numMembers2=count($numMembers); 
	$start=(empty($_GET['start']))? 0 : $_GET['start'];
	$num_per_page=$sl_admin_locations_per_page; //edit this to determine how many locations to view per page of 'Manage Locations' page
	if ($numMembers2!=0) {include("$sl_path/search-links.php");}
	//include("$sl_path/qstring.php");
//end of for search links

if(empty($_GET['d'])) {$_GET['d']="";} if(empty($_GET['o'])) {$_GET['o']="";}

print "<br>
<table class='widefat' cellspacing=0 id='loc_table'>
<thead><tr >
<th colspan='1'><input type='checkbox' onclick='checkAll(this,document.forms[\"locationForm\"])' class='button' id='master_checkbox' $master_check></th>
<th colspan='1'>".__("Actions", $text_domain)."</th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_id&d=$d'>".__("ID", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_store&d=$d'>".__("Name", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_address&d=$d'>".__("Street", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_address2&d=$d'>".__("Street2", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_city&d=$d'>".__("City", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_state&d=$d'>".__("State", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_zip&d=$d'>".__("Zip", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_tags&d=$d'>".__("Tags", $text_domain)."</a></th>";

if (get_option('sl_location_table_view')!="Normal") {
print "<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_description&d=$d'>".__("Description", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_url&d=$d'>".__("URL", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_hours&d=$d'>".__("Hours", $text_domain)."</th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_phone&d=$d'>".__("Phone", $text_domain)."</a></th>
<th><a href='".ereg_replace("&o=$_GET[o]&d=$_GET[d]", "", $_SERVER['REQUEST_URI'])."&o=sl_image&d=$d'>".__("Image", $text_domain)."</a></th>";
}

print "<th>(Lat, Lon)</th>
</tr></thead>";
	$o=mysql_real_escape_string($o); $d=mysql_real_escape_string($d);
	$start=mysql_real_escape_string($start); $num_per_page=mysql_real_escape_string($num_per_page);
	//print sprintf("SELECT * FROM " . $wpdb->prefix . "store_locator $where ORDER BY $o $d LIMIT %d,%d", $start, $num_per_page); //die();
	if ($locales=$wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "store_locator $where ORDER BY $o $d LIMIT $start, $num_per_page" , ARRAY_A)) {
		//function do_trim($a){return trim($a);}
		
		$colspan=(get_option('sl_location_table_view')!="Normal")? 	16 : 11;
		
		foreach ($locales as $value) {
			
			$bgcol=(empty($bgcol) || $bgcol=="#eee")?"#fff":"#eee";			
			$bgcol=($value['sl_latitude']=="" || $value['sl_longitude']=="")? "salmon" : $bgcol;			
			$value=array_map("trim",$value);
			
			if (!empty($_GET['edit']) && $value['sl_id']==$_GET['edit']) {
				print "<tr style='background-color:$bgcol'>";
	
	print "<td colspan='$colspan'><form name='manualAddForm' method=post>
	<a name='a$value[sl_id]'></a>
	<table cellpadding='0' class='manual_update_table'>
	<!--thead><tr><td>".__("Type&nbsp;Address", $text_domain)."</td></tr></thead-->
	<tr>
		<td valign='top'><b>".__("Name of Location", $text_domain)."</b><br><input name='sl_store-$value[sl_id]' value='$value[sl_store]' size=40><br><br>
		<b>".__("Address", $text_domain)."</b><br><input name='sl_address-$value[sl_id]' value='$value[sl_address]' size=21>&nbsp;<small>(".__("Street - Line1", $text_domain).")</small><br>
		<input name='sl_address2-$value[sl_id]' value='$value[sl_address2]' size=21>&nbsp;<small>(".__("Street - Line 2 - optional", $text_domain).")</small><br>
		<table cellpadding='0px' cellspacing='0px'><tr><td style='padding-left:0px' class='nobottom'><input name='sl_city-$value[sl_id]' value='$value[sl_city]' size='21'><br><small>".__("City", $text_domain)."</small></td>
		<td><input name='sl_state-$value[sl_id]' value='$value[sl_state]' size='7'><br><small>".__("State", $text_domain)."</small></td>
		<td><input name='sl_zip-$value[sl_id]' value='$value[sl_zip]' size='10'><br><small>".__("Zip", $text_domain)."</small></td></tr></table><br>
		<nobr><input type='submit' value='".__("Update", $text_domain)."' class='button-primary'><input type='button' class='button' value='".__("Cancel", $text_domain)."' onclick='location.href=\"".ereg_replace("&edit=$_GET[edit]", "",$_SERVER['REQUEST_URI'])."\"'></nobr>
		</td><td>
		<b>".__("Additional Information", $text_domain)."</b><br>
		<textarea name='sl_description-$value[sl_id]' rows='5' cols='17'>$value[sl_description]</textarea>&nbsp;<small>".__("Description", $text_domain)."</small><br>
		<input name='sl_tags-$value[sl_id]' value='$value[sl_tags]'>&nbsp;<small>".__("Tags (seperate with commas)", $text_domain)."</small><br>		
		<input name='sl_url-$value[sl_id]' value='$value[sl_url]'>&nbsp;<small>".__("URL", $text_domain)."</small><br>
		<input name='sl_hours-$value[sl_id]' value='$value[sl_hours]'>&nbsp;<small>".__("Hours", $text_domain)."</small><br>
		<input name='sl_phone-$value[sl_id]' value='$value[sl_phone]'>&nbsp;<small>".__("Phone", $text_domain)."</small><br>
		<input name='sl_image-$value[sl_id]' value='$value[sl_image]'>&nbsp;<small>".__("Image URL (shown with location)", $text_domain)."</small><br><br>
	</td>
		</tr>
	</table>
</form></td>";

print "</tr>";
			}
			else {
			$value['sl_url']=(!url_test($value['sl_url']) && trim($value['sl_url'])!="")? "http://".$value['sl_url'] : $value['sl_url'] ;
			$value['sl_url']=($value['sl_url']!="")? "<a href='$value[sl_url]' target='blank'>".__("View", $text_domain)."</a>" : "" ;
			$value['sl_image']=($value['sl_image']!="")? "<a href='$value[sl_image]' target='blank'>".__("View", $text_domain)."</a>" : "" ;
			$value['sl_description']=($value['sl_description']!="")? "<a onclick='alert(\"".comma($value['sl_description'])."\")' href='#'>".__("View", $text_domain)."</a>" : "" ;
			
			$edit=(!empty($_GET['edit']))? $_GET['edit'] : "" ;
			print "<tr style='background-color:$bgcol'>
			<th><input type='checkbox' name='sl_id[]' value='$value[sl_id]'></th>
			<th><a class='edit_loc_link' href='".ereg_replace("&edit=$edit", "",$_SERVER['REQUEST_URI'])."&edit=" . $value['sl_id'] ."#a$value[sl_id]' id='$value[sl_id]'>".__("Edit", $text_domain)."</a>&nbsp;|&nbsp;<a class='del_loc_link' href='$_SERVER[REQUEST_URI]&delete=$value[sl_id]' onclick=\"confirmClick('Sure?', this.href); return false;\" id='$value[sl_id]'>".__("Delete", $text_domain)."</a></th>
			<th> $value[sl_id] </th>
			<td> $value[sl_store] </td>
<td>$value[sl_address]</td>
<td>$value[sl_address2]</td>
<td>$value[sl_city]</td>
<td>$value[sl_state]</td>
<td>$value[sl_zip]</td>
<td>$value[sl_tags]</td>";

if (get_option('sl_location_table_view')!="Normal") {
print "<td>$value[sl_description]</td>
<td>$value[sl_url]</td>
<td>$value[sl_hours]</td>
<td>$value[sl_phone]</td>
<td>$value[sl_image]</td>";
}

print "<td>($value[sl_latitude],&nbsp;$value[sl_longitude])</td>
</tr>";
			}
		}
	}
	else {
		$notice=($_GET['q']!="")? __("No Locations Showing for this Search of ", $text_domain)."<b>\"$_GET[q]\"</b>. $view_link" : __("No Locations Currently in Database", $text_domain);
		print "<tr><td colspan='5'>$notice | <a href='admin.php?page=$sl_dir/add-locations.php'>".__("Add Locations", $text_domain)."</a></td></tr>";
	}
	print "</table>
	<input name='act' type='hidden'><br>";
//include("mgmt-buttons-links.php");
if ($numMembers2!=0) {include("$sl_path/search-links.php");}

print "</form>";
	
//}
	
?>
</div>