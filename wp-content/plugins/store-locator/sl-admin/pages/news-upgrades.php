<?php 
include(SL_INCLUDES_PATH."/top-nav.php");
sl_move_upload_directories();

print "<div class='wrap'>";
print "<table class='widefat' cellpadding='0px' cellspacing='0px'>";

if (preg_match('@wordpress-store-locator-location-finder@', SL_DIR)) { 
	$icon_notification_msg="<p><div class='sl_admin_warning'>".__("<b>Note:</b> Your directory is <b>'wordpress-store-locator-location-finder'</b>. Please rename to <b>'store-locator'</b> to continue receiving notifications of future updates in your admin panel. After changing to <b>'store-locator'</b>, make sure to also update your icon URLs on the 'Map Designer' page.", SL_TEXT_DOMAIN)."</div></p>"; 
	print $icon_notification_msg;
	}
	elseif ((preg_match("@wordpress-store-locator-location-finder@", sl_data('sl_map_home_icon')) && preg_match("@store-locator@", SL_DIR)) || (preg_match("@wordpress-store-locator-location-finder@", sl_data('sl_map_end_icon')) && preg_match("@store-locator@", SL_DIR))) {
	$icon_notification_msg="<p><div class='sl_admin_warning'>You have switched from <strong>'wordpress-store-locator-location-finder'</strong> to <strong>'store-locator'</strong> --- great! <br>Now, please re-select your <b>'Home Icon'</b> and <b>'Destination Icon'</b> on the <a href='".SL_MAP_DESIGNER_PAGE."'>Map Designer</a> page, so that they show up properly on your store locator map.</div></p>";
	print $icon_notification_msg;
	}

print "<tr><td valign='top' width='50%' style='padding:0px'>

<table width='100%'><thead><tr>
<th>".
__("Latest News", SL_TEXT_DOMAIN).
"</th>
</tr>
</thead>
<tr>
<td width='50%'>
<div style='overflow:scroll; height:450px; padding:7px;'>

<script src='http://feeds2.feedburner.com/Viadat?format=sigpro' type='text/javascript' ></script><!--noscript><p>Subscribe to RSS headline updates from: <a href='http://feeds2.feedburner.com/Viadat'></a><br/>Powered by FeedBurner</p> </noscript-->";

/*
// include lastRSS library
include_once (SL_ACTIONS_PATH."/lastRSS.php");
// create lastRSS object
$rss = new lastRSS; 
// setup transparent cache
$rss->cache_dir = './cache'; 
$rss->cache_time = 3600; // one hour

// load some RSS file
if ($rs = $rss->get('http://feeds2.feedburner.com/Viadat')) {
	//var_dump($rs);
$c=1;
foreach ($rs[items] as $value) {

if ($c<=100) {
	print "<li><A href=\"$value[link]\" target='_blank' class='home_rss' style='font-size:12px'>
	<b>$value[title]</b></a></li><b>$value[pubDate]</b><br>
	<!--br-->
	<span class='home_rss'> ".
	str_replace("]]>","",str_replace("</p>", "", preg_replace("@<!\[CDATA\[@s", "", html_entity_decode(nl2br($value[description]))))).
	"</span><br><br>";
}
else {
	if ($c<=4)
	print "<li style='font-size:10px; color:black; position:relative; left:10px'><A href=\"$value[link]\" target='_blank' class='home_rss' style='font-size:11px'>$value[title]</a></li>";
	}
$c++;
	}	
}
*/

print "</td>
</tr></table>";

/*print "
<table width='100%' height='350px'><thead><tr>
<th width=''>".
__("For Your Information", SL_TEXT_DOMAIN).
"</th></tr></thead>
<tr>
<td><div style='overflow:scroll; height:350px'> ";
include(SL_INCLUDES_PATH."/thank-you.php");
print "</div></td></tr></table>";
*/

print "</td>
<td rowspan='1' valign='top' style='padding:0px'>

<table width='100%'><thead><tr>
<th width=''>".
__("Addons & Themes", SL_TEXT_DOMAIN).
"</th></tr></thead>
<tr>
<td><div style='overflow:scroll; height:460px; padding:7px; padding-top:0px;'>";
?>
<?php

// include lastRSS library
include_once (SL_ACTIONS_PATH."/lastRSS.php");
// create lastRSS object
$rss = new lastRSS; 
// setup transparent cache
$rss->cache_dir = SL_CACHE_PATH; 
$rss->cache_time = 3600; // one hour

// load some RSS file
if ($rs = $rss->get('http://www.viadat.com/index.php?rss=true&action=product_list&category_id=7')) {
	//var_dump($rs);
$c=1;
foreach ($rs['items'] as $value) {

if ($c<=100) {
	print "<li style='list-style-type:none; margin-top:10px; margin-bottom:0px;'><A href=\"$value[link]\" target='_blank' class='home_rss' style='font-size:18px; font-family: Georgia;'>
	<b>$value[title]</b></a></li>
	<!--br-->
	<div class='home_rss'> ".
	str_replace("]]>","",str_replace("</p>", "", html_entity_decode(nl2br($value['description'])))). 
	"</div><br><br>";
}
else {
	if ($c<=4)
	print "<li style='font-size:10px; color:black; position:relative; left:10px'><A href=\"$value[link]\" target='_blank' class='home_rss' style='font-size:11px'>$value[title]</a></li>";
	}
$c++;
	}	
}

print "
</div>
</td>
</tr>
</table>


</td>
</tr>
</table>

</div>";

include(SL_INCLUDES_PATH."/sl-footer.php");
?>