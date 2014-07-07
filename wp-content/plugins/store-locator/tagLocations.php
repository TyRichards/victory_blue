<?php
//adding or removing tags for specified a locations
if (!empty($_POST)) {extract($_POST);}

//var_dump($sl_id); exit;
if (is_array($sl_id)==1) {
	$rplc_arr=array_fill(0, count($sl_id), "%d"); //var_dump($rplc_arr); //die();
	$id_string=implode(",", array_map(array($wpdb, "prepare"), $rplc_arr, $sl_id));
} else {
	$id_string=$wpdb->prepare("%d", $sl_id);
}
if ($act=="add_tag") {
	//adding tags
	//print "UPDATE ".$wpdb->prefix."store_locator SET sl_tags=CONCAT(sl_tags, '".strtolower($sl_tags).", ') WHERE sl_id IN ($id_string)"; exit;
	//print $sl_tags."<br><br>";
	//print prepare_tag_string(strtolower($sl_tags)); die();
	//print sprintf("UPDATE ".$wpdb->prefix."store_locator SET sl_tags=CONCAT(sl_tags, %s ) WHERE sl_id IN ($id_string)", prepare_tag_string(strtolower($sl_tags))); die();
	$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."store_locator SET sl_tags=CONCAT(sl_tags, %s ) WHERE sl_id IN ($id_string)", prepare_tag_string(strtolower($sl_tags))));
	sl_process_tags(prepare_tag_string(strtolower($sl_tags)), "insert", $sl_id);
}
elseif ($act=="remove_tag") {
	//removing tags
	if (empty($sl_tags)) {
		//if no tag is specified, all tags will be removed from selected locations
		//print sprintf("UPDATE ".$wpdb->prefix."store_locator SET sl_tags='' WHERE sl_id IN (%s)", $id_string); die();
		$wpdb->query("UPDATE ".$wpdb->prefix."store_locator SET sl_tags='' WHERE sl_id IN ($id_string)");
		sl_process_tags("", "delete", $id_string);
	}
	else {
		//$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."store_locator SET sl_tags='".prepare_tag_string("%s")."' WHERE sl_id IN (%s)", $sl_tags, $id_string));
		//print sprintf("UPDATE ".$wpdb->prefix."store_locator SET sl_tags=REPLACE(sl_tags, %s, '') WHERE sl_id IN ($id_string)", $sl_tags); die();
		$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."store_locator SET sl_tags=REPLACE(sl_tags, %s, '') WHERE sl_id IN ($id_string)", $sl_tags.","));
		$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."store_locator SET sl_tags=REPLACE(sl_tags, %s, '') WHERE sl_id IN ($id_string)", $sl_tags."&#44;"));
		sl_process_tags($sl_tags, "delete", $id_string);
	}
}
?>