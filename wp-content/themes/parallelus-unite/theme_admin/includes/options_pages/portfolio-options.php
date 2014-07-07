<?php
#==================================================================
#
#	Display control panel options for Portfolio/Gallery
#
#==================================================================

global $themePath;
?>
<script src="<?php echo bloginfo('template_url'); ?>/theme_admin/js/jquery-1.4.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript"> var $j = jQuery.noConflict(); </script>
<script type="text/javascript">
	// launches help file
	function openHelp(section) {
		window.open('<?php echo $themePath; ?>theme_admin/readme.html#'+section,'help','width=750,height=500,scrollbars=yes,resizable=yes');
	}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_url'); ?>/theme_admin/css/styles.css" />
<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_url'); ?>/theme_admin/css/sortable-lists.css" />

<div class="wrap">
	
	<h2><?php echo $themeTitle; ?> - Theme Settings</h2>

	<?php
	
	// save options to database (on submit)
	if (isset($_POST['save_theme_options'])) :
		
		// if all portfolio have been deleted
		if ( empty($_POST[$shortname.'portfolioPages']) ) { 
			update_option($shortname.'portfolioPages', ''); 
		} else {
			
			// if we do have data in the portfolioPages array... do the normal DB update
			foreach ($_POST as $key => $value) {
				if ($key != 'save_theme_options') {
					update_option($key, $value);
				}
			}
			
		}
		
		// display success message
		echo '<div id="message" class="updated fade"><p><strong>Updated Successfully</strong></p></div>';
	endif;

	// Start printing page content
		
	// call title function
	options_title(array('name'=>'Portfolio'));
	
	// the default options
	echo '<form method="post" action="">';
	
	// top buttons
	echo '<input type="button" class="button-secondary autowidth" style="float:right;" onClick="openHelp(\'portfolio\');" value="Theme Help" />';
	echo '<input type="submit" name="save_theme_options" class="button-primary autowidth" value="Save Changes" style="float:left; margin-right: 2em;" />';
	echo '<input type="button" class="button-secondary autowidth" style="float:left;" onClick="addMenuItem(true);" value="Add New Portfolio Page" />';
	echo '<p style="clear:both; margin: 0;">&nbsp;</p>';

	// start the main slide setup table	
	echo '<div class="themeTableWrapper">';
	echo '<table cellspacing="0" class="widefat themeTable">';
	echo '<thead><tr>';
	echo '<th scope="row">&nbsp;</th>';
	echo '</tr></thead><tbody>';

	?>
	<tr>
		<td>
		
			<div>
				<ul id="Portfolio">
					<?php
					// output the menu as an unordered list
					$P_Pages = get_option($shortname.'portfolioPages');
					$P_Settings = get_option($shortname.'portfolioSettings');
									
					if(!empty($P_Pages) && is_array($P_Pages)) {
						buildList($P_Pages, $P_Settings);
					}
					?>
				</ul>
			</div>
		
		</td>
	</tr>
	<?php
	
	// call table end function
	options_end(NULL);
	
	echo '<p class="submit"><input type="submit" name="save_theme_options" class="button-primary autowidth" value="Save Changes" /></p>';
	echo '</form>';

	?>
	
	<br/>	
	
	<ul style="display:none;" id="sample-item">
		<?php 
		// Default options (for new items)
		$P_Defaults = array(
			'#_SubTitle'	=>	'',
			'#_Items'		=>	'9',
			'#_Open'		=>	'media',
			'#_Categories'	=>	'',
			'#_Featured'	=>	''
		);

		// create the template li used for inserting new items
		buildList(array('#' => '#'), $P_Defaults);
		?>
	</ul>
		
	<?php

	// a function to print the items
	function buildList($theArray, $theValues = array()) {  
		global $shortname, $categoryList, $pageList;

		foreach ($theArray as $key => $value) {
		
			// get variables setup
			$id = $key;
			$selectedPage = $value;
			$options = $theValues;
			$arr = $shortname .'portfolioSettings';		// used to produce a settins array to store ALL values of all items "theme_portfolioSettings[#_OptionName]"
			$deleteFunction = '';
			if ($id !== '#') { $deleteFunction = 'onclick="deleteItem(\'item-'. $id .'\');"'; }
							
			?>
			<li id="item-<?php echo $id ?>" rel="<?php echo $id ?>" class="portfolio-item">
				<div>
					<table cellpadding="3" cellspacing="0" width="100%">
						<tbody><tr>
							<td>
								<table cellpadding="1" cellspacing="0" width="100%">
									<tbody>
									<tr>
										<td colspan="2">
											<p><strong>Page</strong></p>
											<div>
											<?php 
												echo '<select style="width:350px;" name="'. $shortname .'portfolioPages['. $id .']" id="portfolioPage_'. $id .'" >';
												echo '<option value="">Choose one...</option>';
												
												foreach ($pageList as $key=>$option) { 
													echo '<option value="'. $key .'"'; 
														if ( $selectedPage == $key ) { 
															echo ' selected="selected"'; 
														}
													echo '>'. $option .'</option>';
												}
												
												echo '</select>';
											?>
											</div>
											<p>Select a page to display this portfolio.</p>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<p><strong>Sub-title</strong></p>
											<div>
												<input style="width:350px;" name="<?php printf("%s[%s_%s]",$arr,$id,"SubTitle"); ?>" id="<?php echo $id; ?>_SubTitle" type="text" value="<?php echo $options[$id.'_SubTitle']; ?>" />
											</div>
											<p>Optional: Text displayed below the page title.</p>
										</td>
									</tr>
									<tr>
										<td><strong>Items per page:</strong></td>
										<td>
											<input style="width:50px;" name="<?php printf("%s[%s_%s]",$arr,$id,"Items"); ?>" id="<?php echo $id; ?>_Items" type="text" value="<?php echo $options[$id.'_Items']; ?>" />
										</td>
									</tr>
									<tr>
										<td><strong>Click image opens:</strong></td>
										<td>
										<select style="width:150px;" name="<?php printf("%s[%s_%s]",$arr,$id,"Open"); ?>" id="<?php echo $id ?>_Open" >
											<option value="media" <?php if ($options[$id.'_Open'] == 'media') {echo 'selected="selected"';}?>>Image in Lightbox</option>
											<option value="post" <?php if ($options[$id.'_Open'] == 'post') {echo 'selected="selected"';}?>>Full Post</option>
										</select>
										</td>
									</tr></tbody>
								</table>	
							</td>
							<td>
								<table cellpadding="1" cellspacing="0" width="100%">
									<tbody>
									<tr>
										<td>
											<p><strong>Select the categories to get portfolio items from.</strong></p>
											<select style="width:250px; height:100px" name="<?php printf("%s[%s_%s]",$arr,$id,"Categories"); ?>[]" id="<?php echo $id ?>_Categories" multiple="multiple">
											<?php 
												
												foreach ($categoryList as $key=>$option) { 
													echo '<option value="'. $key .'"'; 
														if ( is_array($options[$id.'_Categories']) ) {
															if ( in_array($key, $options[$id.'_Categories']) ) { 
																echo ' selected="selected"'; 
															}
														}
													echo '>'. $option .'</option>';
												}
														
												echo '</select><br />';
			
											?>
											<p>(Ctrl+Click to select/deselect multiple categories, Mac users Option+Click)</p>
										</td>
									</tr>
									<tr>
										<td>
											<p><strong>Inlcude featured items?</strong></p>
											<div>
												<select style="width:350px;" name="<?php printf("%s[%s_%s]",$arr,$id,"Featured"); ?>" id="<?php echo $id ?>_Featured" >
												<option value="">Choose one...</option>
												<?php 
													echo '';
													
													foreach ($categoryList as $key=>$option) { 
														echo '<option value="'. $key .'"'; 
															if ($options[$id.'_Featured'] == $key) {
															//if ( get_option($shortname .'portfolio_'. $id .'_Featured') == $key ) { 
																echo ' selected="selected"'; 
															}
														echo '>'. $option .'</option>';
													}
													
													echo '</select>';
												?>
											</div>
											<p>Selecting a featured category will pull 5 extra items to the top of the page before any content. This can be any categoy including one already selected above.</p>
										</td>
									</tr>
									<!--tr>
										<td>
											<p><strong>Short Code :</strong>
											<input type="text" readonly="readonly" onfocus="this.select();" id="<?php echo $id ?>_Shortcode" value="[portfolio id=<?php echo $id; ?>]"></p>
										</td>
									</tr-->
									</tbody>
								</table>
							</td>
							<td align="center" width="90"><div class="button-secondary delete-item" <?php echo $deleteFunction; ?>>Delete</div></td>
						</tr></tbody>
					</table>
				</div>
			</li>
		<?php
				
		} // end foreach item
	}
	
	?>
</div>



<script type="text/javascript">

// array to track all nested item id's
var allListIds = [];

// inserts a new menu item
function addMenuItem(itemType) {

	var count = $j('#Portfolio').find('li').length,
		menuItem = $j('#sample-item li'),
		template;
	
	// adding a menu item
	template = menuItem;
	
	// prevent duplicate id's by checking agains all current ones	
	var newID = count;
	while ($j.inArray(newID, allListIds) != -1 ) {
		newID++;
	}
	allListIds.push(parseInt(newID)); // add to the id list

	template.clone()
		.attr('id',template.attr('id').replace('#',newID))
		.attr('rel',newID)
		.find('*').each( function() {
			
			var attrId = $j(this).attr('id'),
				attrName = $j(this).attr('name'),
				attrFor = $j(this).attr('for');
				
			if (attrId) $j(this).attr('id', attrId.replace('#',newID));
			if (attrName)$j(this).attr('name', attrName.replace('#',newID));
			if (attrFor)$j(this).attr('for', attrFor.replace('#',newID));
		
		}).end()
		.find('.delete-item').click( function() {
			deleteItem('item-'+newID);
		}).end()
		.prependTo($j('#Portfolio'));
}



jQuery(document).ready(function() {
	
	// populate the array of id's to prevent duplication
	jQuery('#Portfolio').find('li').each( function() {
		allListIds.push(
			parseInt( jQuery(this).attr('rel') )
		); 
	});
	
});	

// delete items
function deleteItem(id) {
	// add click event for delete button
	if (confirm("Are you sure you want to delete this item?")) {
		jQuery('#'+id).remove();
	} else {
		return false;
	}
}
</script>
