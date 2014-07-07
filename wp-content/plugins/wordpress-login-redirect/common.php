<?php 
global $cr_wplink;
global $cr_wpname;

?>


<div class="postbox-container" style="width:20%;">
	<div class="metabox-holder">	
		<div class="meta-box-sortables">
						<div id="wordpress-seolike" class="postbox">
	<div class="handlediv" title="Click to toggle"><br /></div>
	<h3 class="hndle"><span>Help support this plugin</span></h3>
	
	<div class="inside" style='padding: 0px 10px 5px 10px;'>
		<p>Developing this plugin cost me hours of work. If you like it, please support it.</p><p>You can help by:</p>

		<ul style='padding: 5px 5px 15px 5px; list-style: square; margin-left: 20px;'>
			<li><a href="http://wordpress.org/extend/plugins/<?php echo $cr_wplink;?>/">Rating it at WordPress.org</a></li>
			<li><a href="http://twitter.com/thisismyurl">Following me on Twitter</a></li>
			<li><a href="http://www.facebook.com/pages/thisismyurlcom/114745151907899">Becoming a Fan on Facebook</a></li>
		</ul>
		
		<div style='text-align: center;'>
		<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="info@thisismyurl.com">
		<input type="hidden" name="item_name" value="Donation for <?php echo $cr_wplink;?>">
		<input type="hidden" name="currency_code" value="USD">
		<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Make payments with PayPal">
		</form>
		
		</div>
		
		<?php
		$content = trim(get_transient("timu_donations"));
		
		if (strlen($content) == 0) {
			if (function_exists(file_get_contents)) {
				$content = file_get_contents('http://thisismyurl.com/donations.html');
				set_transient("timu_donations", $content, 86400);
			}
			
		}
		
		if (strlen($content) > 0) {
			echo "
				<p>A special thank you to the follow people for donating $20 or more to support my plugin work.</p>
				<ul style='padding: 5px; list-style: square; margin-left: 20px;'>$content</ul>
			";
		}
		
	?>

		
	</div>
</div>






<div id="support" class="postbox">
	<div class="handlediv" title="Click to toggle"><br /></div>
	<h3 class="hndle"><span>Do you need help?</span></h3>
	<div class="inside" style='padding: 0px 10px 5px 10px;'>
		<p>This plugin is distributed for free and without support but if you need help or have a question, please use the <a href="http://wordpress.org/tags/<?php echo $cr_wpname;?>">support forums</a>. If you have an idea for the plugin, please post it!</p>
		<p>I'm also <a href="http://thisismyurl.com/contact/">available for hire</a> as a consultant, if you need additional support.</p>
		<p>Many common questions can be answered by reading the <a target='_blank' href='<?php echo WP_PLUGIN_URL .'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'readme.txt';?>'>readme file</a>.</p>
	</div>
</div>







<div id="latest" class="postbox">
	<div class="handlediv" title="Click to toggle"><br /></div>
	<h3 class="hndle"><span>Latest posts from Christopher Ross</span></h3>
	<div class="inside"  style='padding: 0px 10px 5px 10px;'>
		<ul style='padding: 5px; list-style: square; margin-left: 20px;'>
		
		
		
		<?php
		include_once(ABSPATH . WPINC . '/feed.php');
		
		$rss = fetch_feed('http://feeds.feedburner.com/thisismyurl');
		if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
			// Figure out how many total items there are, but limit it to 5. 
			$maxitems = $rss->get_item_quantity(5); 
		
			// Build an array of all the items, starting with element 0 (first element).
			$rss_items = $rss->get_items(0, $maxitems); 
		endif;
		
		
		if ($maxitems == 0) echo '<li>No items.</li>';
		else
		// Loop through each feed item and display each item as a hyperlink.
		foreach ( $rss_items as $item ) : ?>
		<li>
			<a href='<?php echo $item->get_permalink(); ?>'
			title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'>
			<?php echo $item->get_title(); ?></a>
		</li>
		<?php endforeach; ?>
		
		</ul>
	</div>
</div>



		
		
		
<?php
unset($content);
$content = trim(get_transient("timu_plugins"));

if (strlen($content) == 0) {
	if (function_exists(file_get_contents)) {
		$content = file_get_contents('http://thisismyurl.com/plugins.html');
		set_transient("timu_plugins", $content, 86400);
	}
	
}

if (strlen($content) > 0) {
	echo "
	<div id='plugins' class='postbox'>
	<div class='handlediv' title='Click to toggle'><br /></div>
	<h3 class='hndle'><span>Other great plugins</span></h3>
	<div class='inside'  style='padding: 0px 10px 5px 10px;'>
		<p>Have you enjoyed using this plugin? Why not try out my other great WordPress plugins.</p>
		<ul style='padding: 5px; list-style: square; margin-left: 20px;'>$content</ul>
		</div>
	</div>
	";
}


?>
		
		


</div>
<br/><br/><br/>
</div>
</div>