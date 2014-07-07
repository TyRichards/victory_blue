<?php
#==================================================================
#
#	Display control panel options for Main Menu
#
#==================================================================

global $themePath;

?>
<script src="<?php echo bloginfo('template_url'); ?>/js/jquery-1.4.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/theme_admin/js/sortMenu.js"></script>
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
	
		// convert strings and store to array 
		parse_str($_POST['MM-ItemLevels'], $MenuLevels);
		update_option($shortname.'MM-ItemLevels', $MenuLevels);
		
		// convert strings and store to array 
		parse_str($_POST['MM-ItemValues'], $ItemValues);
		update_option($shortname.'MM-ItemValues', $ItemValues);
		
		// display success message
		echo '<div id="message" class="updated fade"><p><strong>Updated Successfully</strong></p></div>';
	endif;
	
	
	
	// Start printing page content
		
	echo '<form method="post" action="" id="editForm">';
	
	// call title function
	options_title(array('name'=>'Main Menu'));
	
	// top buttons
	echo '<input type="button" class="button-secondary autowidth" style="float:right;" onClick="openHelp(\'mainmenu\');" value="Theme Help" />';
	echo '<input type="button" name="save_theme_options" class="button-primary autowidth" onClick="saveMenu();" value="Save Changes" style="float:left; margin-right: 2em;" />';
	echo '<input type="button" class="button-secondary autowidth" style="float:left;" onClick="addMenuItem(true);" value="Add New Menu Item" />';
	echo '<input type="button" class="button-secondary autowidth" style="float:left; margin-left: 0.5em" onClick="addMenuItem(\'separator\');" value="- Add Separator -" />';
	echo '<p style="clear:both; margin: 0;">&nbsp;</p>';
	
	// call table start function
	options_start(array('title'=>'Edit Menu Options'));
	
	?>
	<td colspan="2">
	
		<div>
			<ul id="MainMenu">
				<?php
				// output the menu as an unordered list
				$MM_Levels = get_option($shortname.'MM-ItemLevels');
				$MM_Values = get_option($shortname.'MM-ItemValues');
				
				if(!empty($MM_Levels) && is_array($MM_Levels)) {
					buildList($MM_Levels['MainMenu'], $MM_Values);
				}
				?>
			</ul>
		</div>
	
	</td>
	<?php
	
	// call table end function
	options_end(NULL);
	
	echo '<p class="submit"><input type="button" name="save_theme_options" class="button-primary autowidth" onClick="saveMenu();" value="Save Changes" /></p>';
	echo '</form>';

	?>
	
	<br/>
	<form method="post" action="" id="submitForm" style="display:none;">
		<input type="hidden" name="MM-ItemLevels" id="MM-ItemLevels" value="" />
		<input type="hidden" name="MM-ItemValues" id="MM-ItemValues" value="" />
		<input type="hidden" value="true" name="save_theme_options" />
	</form>
	
	
	<ul style="display:none;" id="sample-mm-item">
		<?php 
		
		// Default options (for new items)
		$MM_Defaults = array(
			'mm-#-linkTitle'		=>	'Title',
			'mm-#-linkDescription'	=>	'Description',
			'mm-#-linkType'			=>	'page',
			'mm-#-linkPage'			=>	'',
			'mm-#-linkCategory'		=>	'',
			'mm-#-linkURL'			=>	'http://'	
		);

		// create the template li used for inserting new items
		buildList(array('id' => '#'), $MM_Defaults);
		?>
	</ul>
	
	<ul style="display:none;" id="separator-mm-item">
		<?php 
		// create the template separator used for inserting a separator
		buildList(array('id' => '#'), array('mm-#-linkTitle' => 'mm-separator'));
		?>
	</ul>
	
	
	<?php

	// a function to print the items
	function buildList($theArray, $theValues = array()) {   
		foreach ($theArray as $key => $value) {
		
			// get variables setup
			$id = $value['id'];
			$options = $theValues;
			
			// is this a separator?
			if ($options['mm-'. $id .'-linkTitle'] == 'mm-separator') {
				
				// print the separator item type
				?>
				<li id="mm-item-<?php echo $id ?>" rel="<?php echo $id ?>" class="isSortable noNesting menu-separator">
					<div class="sortItem">
						<table cellpadding="0" cellspacing="0" width="100%">
							<tbody>
								<td>
									<div class="handle"><strong>- separator -</strong></div>
									<input type="hidden" name="mm-<?php echo $id ?>-linkTitle" value="mm-separator" />
								</td>
								<td align="center" width="90"><a href="javascript: return false;" class="delete-item">Delete</a></td>
							</tbody>
						</table>
					</div>
				</li>				
				<?php	
			
			// it's not a separator so print a standard menu item
			} else {
						
				$MM_LinkCategory = "";
				$MM_SelectCategory = "";
				$MM_LinkURL = "";
				$MM_SelectURL = "";
				$MM_LinkPage = "";
				$MM_SelectPage = "";
				
				switch ($options['mm-'. $id .'-linkType']) {
					case 'category':
						$MM_LinkCategory = "checked";
						$MM_SelectCategory = "display: block;";
						break;
					case 'url':
						$MM_LinkURL = "checked";
						$MM_SelectURL = "display: block;";
						break;
					default:
						$MM_LinkPage = "checked";
						$MM_SelectPage = "display: block;";
						break;
				}
							
				?>
				<li id="mm-item-<?php echo $id ?>" rel="<?php echo $id ?>" class="isSortable menu-item">
					<div class="sortItem">
						<table cellpadding="3" cellspacing="0" width="100%">
							<tbody>
								<td class="handle"><div></div></td>
								<td align="right"><input type="text" name="mm-<?php echo $id ?>-linkTitle" value="<?php echo htmlspecialchars(stripslashes($options['mm-'. $id .'-linkTitle'])) ?>" class="mm-Title" alt="Title"></td>
								<td align="right"><input type="text" name="mm-<?php echo $id ?>-linkDescription" value="<?php echo htmlspecialchars(stripslashes($options['mm-'. $id .'-linkDescription'])) ?>" class="mm-Description" alt="Description"></td>
								<td align="right" width="45"><strong>Link:</strong> </td>
								<td style="white-space: nowrap;" align="right" width="200">
									<label for="MM-LinkTypePage-<?php echo $id ?>" class="<?php echo $MM_LinkPage ?>">
										<input type="radio" name="mm-<?php echo $id ?>-linkType" id="MM-LinkTypePage-<?php echo $id ?>" value="page" <?php echo $MM_LinkPage ?> />&nbsp;Page
									</label>
									<label for="MM-LinkTypeCategory-<?php echo $id ?>" class="<?php echo $MM_LinkCategory ?>">
										<input type="radio" name="mm-<?php echo $id ?>-linkType" id="MM-LinkTypeCategory-<?php echo $id ?>" value="category" <?php echo $MM_LinkCategory ?> />&nbsp;Category
									</label>
									<label for="MM-LinkTypeURL-<?php echo $id ?>" class="<?php echo $MM_LinkURL ?>">
										<input type="radio" name="mm-<?php echo $id ?>-linkType" id="MM-LinkTypeURL-<?php echo $id ?>" value="url" <?php echo $MM_LinkURL ?> />&nbsp;URL
									</label>
								</td>
								<td align="center" width="175">
								
									<?php 
																	
									// print page drop down
									MM_select_option(
										array(
											'name' => 'mm-'. $id .'-linkPage',
											'id' => 'MM-LinkPage-'. $id ,
											'style' => $MM_SelectPage,
											'selected' => $options['mm-'. $id .'-linkPage'],
											'default' => 'Choose a page...',
											'options' => $GLOBALS['pageList']
										)
									);
									
									// print category drop down
									MM_select_option(
										array(
											'name' => 'mm-'. $id .'-linkCategory',
											'id' => 'MM-LinkCategory-'. $id ,
											'style' => $MM_SelectCategory,
											'selected' => $options['mm-'. $id .'-linkCategory'],
											'default' => 'Choose a category...',
											'options' =>  $GLOBALS['categoryList']
										)
									);
									
									?>
									
									<input type="text" name="mm-<?php echo $id ?>-linkURL" value="<?php echo htmlspecialchars(stripslashes($options['mm-'. $id .'-linkURL'])) ?>" id="MM-LinkURL-<?php echo $id ?>" class="mm-Link" style="<?php echo $MM_SelectURL ?>" >
								</td>
								<td align="center" width="90"><div class="button-secondary delete-item">Delete</div></td>
							</tbody>
						</table>
					</div>
	
				<?php
				
				// check for child elements
				if (is_array($value['children'])) {
					echo "<ul>";
					buildList($value['children'], $options);
					echo "</ul>";
				}
				echo "</li>";
				
			} // end (if separator) else statement
		} // end foreach item
	}
	
	
	// pages and categories select boxes
	function MM_select_option($value) {
		echo '<select class="mm-Link" name="'. $value['name'] .'" id="'. $value['id'] .'" style="'. $value['style'] .'">';
		echo '<option value="">'. $value['default'] .'</option>';
		foreach ($value['options'] as $key=>$option) { 
			echo '<option value="'. $key .'"'; 
				if ( $value['selected'] == $key ) { 
					echo ' selected="selected"'; 
				}
			echo '>'. $option .'</option>';
		}
				
		echo '</select>';
	}
	
	
	
	?>
</div>



<script type="text/javascript">

// array to track all nested item id's
var nestedListIds = [];

// creates draggable nested item menu
function initializeMenu() {

	// convert into sortable list
	$j('#MainMenu').NestedSortable({
		accept: 'isSortable',
		noNestingClass: "noNesting",
		opacity: 0.8,
		helperclass: 'helper',
		onChange: function(serialized) {
			$j('#MM-ItemLevels').val((serialized[0].hash));
		},
		onStart: function() {
			// prevents a horizontal scroll when dragging
			$j(document.body).css('overflow-x','hidden');
		},
		onStop: function() {
			// restors scrolling after draggin completes
			$j(document.body).css('overflow-x','auto');
		},
		autoScroll: true,
		handle: '.handle'
	})
	.find('li').each( function() {
		
		// add onclick other dynamic functions
		if (!this.hasClickEventHandlers) {
			
			var thisItem = $j(this);
			var n = thisItem.attr('rel');
			nestedListIds.push(parseInt(n)); // add the id to a list (used to prevent duplicates when editing)
			var linkOptions = $j("input[name='mm-"+n+"-linkType']");
			var deleteButton = thisItem.find(".delete-item:first");
			// add click event for link options
			linkOptions.click( function() {
				var p = $j('#MM-LinkPage-'+n);
				var c = $j('#MM-LinkCategory-'+n);
				var u = $j('#MM-LinkURL-'+n);
				
				// toggle display of page/category/url field
				($j(this).val() == 'page') 		? p.css('display','block') : p.css('display','none');
				($j(this).val() == 'category') 	? c.css('display','block') : c.css('display','none');
				($j(this).val() == 'url') 		? u.css('display','block') : u.css('display','none');
				
				// mark active label with "checked" class
				$j(this + ':not(:checked)').parent('label').removeClass('checked');
				$j(this + ':checked').parent('label').addClass('checked');
				
			});
			
			// add click event for delete button
			deleteButton.click( function() {
				if (confirm("Are you sure you want to delete this item?")) {
					thisItem.remove();
				} else {
					return false;
				}
			});
			
			this.hasClickEventHandlers = true;
		}
	});
	
}

// inserts a new menu item
function addMenuItem(itemType) {

	var count = $j('#MainMenu').find('li').length,
		menuItem = $j('#sample-mm-item li'),
		separator = $j('#separator-mm-item li'),
		template;
	
	if (itemType == 'separator') {
		// adding a separator
		template  = separator;
	} else {
		// adding a menu item
		template  = menuItem;
	}
	
	// prevent duplicate id's by checking agains all current ones	
	var newID = count;
	while ($j.inArray(newID, nestedListIds) != -1 ) {
		newID++;
	}

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
		.prependTo($j('#MainMenu'));
		
	// re-initialize sorting to include new item
	initializeMenu();
}


// save the menu options to the database
function saveMenu() {
	
	// get the individual item options
	$j('#MM-ItemValues').val($j('#editForm').serialize());
	
	// get the list in it's sorted order for creating menus and sub-menus
	$j('#MM-ItemLevels').val(jQuery.iNestedSortable.serialize('MainMenu').hash);
	
	$j('#submitForm').submit();
}


jQuery(document).ready(function() {

	// activate the sortable list
	initializeMenu();

});	
</script>
