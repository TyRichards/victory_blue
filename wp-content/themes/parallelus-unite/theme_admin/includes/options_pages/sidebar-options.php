<?php
#==================================================================
#
#	Display control panel options for Sidebar
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

		// if all sidebars have been deleted
		if ( empty($_POST[$shortname.'sidebarSettings']) ) { 
			update_option($shortname.'sidebarSettings', ''); 
		} else {
			
			// if we do have data in the array... do the normal DB update
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
	options_title(array('name'=>'Sidebar'));
	
	// the default options
	echo '<form method="post" action="" id="SortForm">';
	
	// top buttons
	echo '<input type="button" class="button-secondary autowidth" style="float:right;" onClick="openHelp(\'sidebar\');" value="Theme Help" />';
	echo '<input type="submit" name="save_theme_options" class="button-primary autowidth" value="Save Changes" style="float:left; margin-right: 2em;" />';
	echo '<input type="button" class="button-secondary autowidth" style="float:left;" onClick="addMenuItem(true);" value="Add New Sidebar" />';
	echo '<p style="clear:both; margin: 0;">&nbsp;</p>';

	// start the main slide setup table	
	echo '<div class="themeTableWrapper">';
	echo '<table cellspacing="0" class="widefat themeTable" style="width: 500px;">';
	echo '<thead><tr>';
	echo '<th scope="row">&nbsp;</th>';
	echo '</tr></thead><tbody>';

	?>
	<tr>
		<td colspan="4">
		
			<div>
				<ul id="SortList">
					<?php
					// output the menu as an unordered list
					//$_Levels = get_option($shortname.'sidebarItems');
					$_Settings = get_option($shortname.'sidebarSettings');
									
					if(!empty($_Settings) && is_array($_Settings)) {
						buildList($_Settings);
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
		// create the template li used for inserting new items
		buildList(array('#' => ''));
		?>
	</ul>
		
	<?php

	// a function to print the items
	function buildList($theArray) {  
		global $shortname, $categoryList, $pageList;

		foreach ($theArray as $key => $value) {
		
			// get variables setup
			$id = $key;
			$options = $theArray;
			$arr = $shortname .'sidebarSettings';		// used to produce a settins array to store ALL values of all items "theme_portfolioSettings[#_OptionName]"
			$deleteFunction = '';
			if ($id !== '#') { $deleteFunction = 'onclick="deleteItem(\'item-'. $id .'\');"'; }
							
			?>
			<li id="item-<?php echo $id; ?>" rel="<?php echo $id; ?>" class="li-item">
				<div>
					<table cellpadding="3" cellspacing="0" width="100%">
						<tbody>
						<tr>
							<td>
								<?php if ($id !== '#') { ?>
									<strong><?php echo $options[$id]; ?></strong>
									<input name="<?php printf("%s[%s]",$arr,$id); ?>" id="<?php echo $arr.$id; ?>" type="hidden" value="<?php echo $options[$id]; ?>" />
									<?php
								} else { ?>
									<strong>Sidebar Name: </strong>
									<input name="<?php printf("%s[%s]",$arr,$id); ?>" id="<?php echo $arr.$id; ?>"  type="text" value="<?php echo $options[$id]; ?>" style="width: 350px;" onkeyup="fixField(this);" />
									
									<?php
								} ?>
							</td>
							<td align="center" width="90"><div class="button-secondary delete-item" <?php echo $deleteFunction; ?>>Delete</div></td>
						</tr>
						</tbody>
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

	var count = $j('#SortList').find('li').length,
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
			if (attrName) $j(this).attr('name', attrName.replace('#',newID));
			if (attrFor) $j(this).attr('for', attrFor.replace('#',newID));
		
		}).end()
		.find('.delete-item').click( function() {
			deleteItem('item-'+newID);
		}).end()
		.prependTo($j('#SortList'));
}



jQuery(document).ready(function() {
	
//	$j('#SortList').NestedSortable({
//		accept: 'isSortable',
//		noNestingClass: "noNesting",
//		opacity: 0.8,
//		helperclass: 'helper',
//		onChange: function(serialized) {
//			$j('#<?php echo $shortname.'sidebarItems'; ?>').val((serialized[0].hash));
//		},
//		onStart: function() {
//			// prevents a horizontal scroll when dragging
//			$j(document.body).css('overflow-x','hidden');
//		},
//		onStop: function() {
//			// restors scrolling after draggin completes
//			$j(document.body).css('overflow-x','auto');
//		},
//		autoScroll: true,
//		handle: '.handle'
//	})
//
	// populate the array of id's to prevent duplication
	jQuery('#SortList').find('li').each( function() {
		allListIds.push(
			parseInt( jQuery(this).attr('rel') )
		); 
	});
	
//	// onsubmit function
//	jQuery('#SortForm').submit( function() {
//		// get the list in it's sorted order for creating menus and sub-menus
//		alert(jQuery.iNestedSortable.serialize('SortList').hash);
//		jQuery('#<?php echo $shortname.'sidebarItems'; ?>').val(jQuery.iNestedSortable.serialize('SortList').hash);
//	});
	
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

// prevent invalid characters (for sidebar)
function fixField(field) {
	str = jQuery(field).val();
	jQuery(field).val(str.replace(/[^a-zA-Z_0-9]+/ig,''));
}
</script>
