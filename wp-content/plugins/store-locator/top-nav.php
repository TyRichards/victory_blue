<br>
<?php

$links[$top_nav_base.'/news-upgrades.php']=__("News & Upgrades", $text_domain);
$links[$top_nav_base.'/view-locations.php']=__("Manage Locations", $text_domain);
$links[$top_nav_base.'/add-locations.php']=__("Add Locations", $text_domain);
$links[$top_nav_base.'/map-designer.php']=__("Map Designer", $text_domain);
$links[$top_nav_base.'/api-key.php']=__("Localization", $text_domain)." &amp; ".__("Google API Key", $text_domain);
$links[$top_nav_base.'/readme.php']=__("ReadMe", $text_domain);

$hash[]='news-upgrades';
$hash[]='view-locations';
$hash[]='add-locations'; 
$hash[]='map-designer'; 
$hash[]='api-key';
$hash[]='readme';

/*
$links[$top_nav_base.'/navigator.php#news-upgrades']=__("News & Upgrades", $text_domain);
$links[$top_nav_base.'/navigator.php#view-locations']=__("Manage Locations", $text_domain);
$links[$top_nav_base.'/navigator.php#add-locations']=__("Add Locations", $text_domain);
$links[$top_nav_base.'/navigator.php#api-key']=__("Localization", $text_domain)." &amp; ".__("Google API Key", $text_domain);
$links[$top_nav_base.'/navigator.php#readme']=__("ReadMe", $text_domain);
*/

print <<<EOQ
<ul class="tablist"><!--div id="navlist"-->
EOQ;
$ctr=0;
foreach ($links as $key=>$value) {

$var=(ereg($_GET["page"],$key))?"current":"";

print <<<EOQ
      <li class="top_nav_li $hash[$ctr]" id='$var'><a href="$key"  id='__$hash[$ctr]' class='top_nav_a' style=''>$value</a></li>  
EOQ;
$ctr++;
}
print "</ul> <!--script>alert('$_SERVER[QUERY_STRING]');</script--> <!--/div-->";

?>
<br>
<?php
if (trim(get_option('store_locator_api_key'))=="") {
print "<div class='sl_admin_warning'>
<strong>".__("Update Your Google API Key", $text_domain)." <a href='$top_nav_base/api-key.php'>here</a> </strong><br><br>
<div class=''><strong><a href='https://developers.google.com/maps/documentation/javascript/v2/introduction#Obtaining_Key' target='_blank'>".__("Get your Google API Key", $text_domain)."</a></strong>&nbsp;(".__("link updated as of Store Locator v1.4",$text_domain).")<br>(".__("You'll need to log in with your Google account on the page that opens up. If you don't have an account", $text_domain).", <a href='https://www.google.com/accounts/' target='_blank'>".__("sign up here", $text_domain)."</a>.)</div>
</div><br>";
}
?>