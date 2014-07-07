<?php
if ($_POST) {extract($_POST);}
if (is_array($sl_id)==1) {
	$rplc_arr=array_fill(0, count($sl_id), "%d"); //var_dump($rplc_arr); //die();
	$id_string=implode(",", array_map(array($wpdb, "prepare"), $rplc_arr, $sl_id));
} else {
	$id_string=$wpdb->prepare("%d", $sl_id);
}
//print sprintf("DELETE FROM ".$wpdb->prefix."store_locator WHERE sl_id IN (%s)", $id_string); die();
$wpdb->query("DELETE FROM ".$wpdb->prefix."store_locator WHERE sl_id IN ($id_string)");
sl_process_tags("", "delete", $id_string);
?>