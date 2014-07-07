<?php
#==================================================================
#
#	Meta Options for Pages and Posts
#
#==================================================================

function theme_meta_boxes($meta_name = false) {
	global $themeTitle, $themePath;

	$meta_boxes = array(
	'postImages' => array(
		'type' =>  array('post'),
		'id' => 'theme_postImages_meta',
		'title' => $themeTitle . ' Post Images',
		'function' => 'theme_postImages_meta_box',
		'noncename' => 'theme_postImages',
				
			
		'fields' => array(
			'description_meta_info' => array(
				'type' => 'info',
				'description' => '<strong>Using the "<em>Add an Image</em>" option, upload your media files and paste the "Link URL" in these image fields.</strong>',
			),
			'original_meta_image' => array(
				'name' => '_imageOriginal',
				'type' => 'text',
				'width' => 'full',
				'default' => '',
				'title' => 'Main Image or Video',
				'description' => 'The default image or video associated with your post (full size image). From your portfolio pages this is the image or video shown in the lightbox window.',
				'label' => '',
				'margin' => true,
			),
			'medium_meta_image' => array(
				'name' => '_imageMedium',
				'type' => 'text',
				'width' => 'full',
				'default' => '',
				'title' => 'Medium Image',
				'description' => 'This is the medium size image used for portfolio item previews. If you have added a "Main Image" this field is optional.<br />Images only. Recommended size: 261px * 174px.',
				'label' => '',
				'margin' => true,
			),
			'small_meta_image' => array(
				'name' => '_imageSmall',
				'type' => 'text',
				'width' => 'full',
				'default' => '',
				'title' => 'Small Image',
				'description' => 'This image is used on the home page for "Featured Posts". If you have added a "Main Image" or "Medium Size Image" this field is optional.<br />Images only. Recommended size: 148px * 78px.',
				'label' => '',
				'margin' => true,
			),
			'blog_meta_image' => array(
				'name' => '_imageBlogHeader',
				'type' => 'text',
				'width' => 'full',
				'default' => '',
				'title' => 'Blog Header Image',
				'description' => 'This is the image shown in category lists blog posts. If you have added a "Main Image" this field is optional.<br />Images only. Recommended size: 556px * 133px.',
				'label' => '',
				'margin' => true,
			)
  		)
	),
	
	'generalContentOptions' => array(
		'type' =>  array('post', 'page'),
		'id' => 'theme_generalContentOptions_meta',
		'title' => $themeTitle . ' General Content Options',
		'function' => 'theme_generalContentOptions_meta_box',
		'noncename' => 'theme_generalContentOptions',
				
				
		'fields' => array(
			'selected_sidebar_meta' => array(
				'name' => 'customSidebar',
				'type' => 'customSidebar',
				'width' => '',
				'default' => '',
				'title' => 'Custom Sidebar',
				'description' => 'Select the custom sidebar that you\'d like to be displayed on this post. <br />Note: you will need to first create a custom sidebar in your themes option panel before it will show up here.',
				'label' => '',
				'margin' => true,
			),
			'breadcrumb_meta' => array(
				'name' => 'breadcrumbOff',
				'type' => 'checkbox',
				'width' => 'full',
				'default' => '',
				'desc' => 'Disable breadcrumbs?',
				'value' => '1',
				'title' => 'Disable Breadcrumbs',
				'description' => 'You can disable breadcrumbs for individual posts and pages or turn them off globally by disabling the setting in the theme\'s "<a href="admin.php?page=theme-setup">General Options</a>" menu.',
				'label' => '',
				'margin' => true,
			),
//			'pageIcon_meta' => array(
//				'name' => 'pageIcon',
//				'type' => 'select',
//				'width' => '',
//				'default' => '',
//				'title' => 'Page Icon',
//				'description' => 'Select an icon for the page.',
//				'options' => array( 
//					$themePath."images/spacer.gif"=>"NO IMAGE", 
//					$themePath."images/icons/write.png"=>"Page", 
//					$themePath."images/icons/post.png"=>"Post", 
//					$themePath."images/icons/notes.png"=>"Notes", 
//					$themePath."images/icons/mail.png"=>"Contact", 
//					$themePath."images/icons/mail2.png"=>"Mail", 
//					$themePath."images/icons/camera.png"=>"Portfolio", 
//					$themePath."images/icons/info.png"=>"Information", 
//					$themePath."images/icons/faq.png"=>"Frequently Asked Questions", 
//					$themePath."images/icons/search.png"=>"Search", 
//					$themePath."images/icons/alert.png"=>"Alert", 
//					"custom"=>"Custom"),
//				'label' => '',
//				'custom' => 'pageIcon_custom',
//				'margin' => true,
//			),
//			'pageIcon_custom_meta' => array(
//				'name' => 'pageIcon_custom',
//				'type' => 'custom',
//			),
			'subTitle_meta' => array(
				'name' => 'subTitle',
				'type' => 'text',
				'width' => '350',
				'default' => '',
				'title' => 'Custom Sub-Title',
				'description' => 'Type a custom sub-title into this field and it will override the default provided by the post category or other settings.',
				'label' => '',
				'margin' => false,
			)
  		)
	)
	); // END $meta_boxes = array();

	if ($meta_name)
		return $meta_boxes[$meta_name];
	else
		return $meta_boxes;

}	// END function


function theme_add_meta_box($box_name) {
	global $post, $shortname;

	$meta_box = theme_meta_boxes($box_name);

	foreach ($meta_box['fields'] as $meta_id => $meta_field) {
	
		if ($meta_field['type'] != 'custom') {
			$existing_value = get_post_meta($post->ID, $meta_field['name'], true);
			$value = ($existing_value != '') ? $existing_value : $meta_field['default'];
			$margin = ($meta_field['margin']) ? ' class="add_margin"' : '';
			$description = ($meta_field['description']) ? '<p class="description">' . $meta_field['description'] . '</p>' : '' ;
			$style = ($meta_field['type'] != 'info') ? 'class="postbox" style="background-color:#F5F5F5; margin-bottom: 10px;"' :  'style="margin-bottom: 10px;"'; 
			?>
			<div id="<?php echo $meta_id; ?>" <?php echo $style; ?>>
			<p><strong><?php echo $meta_field['title']; ?></strong></p>
			
			<?php 
			switch ( $meta_field['type'] ) { 
			
				case 'textarea': ?>
					<p<?php echo $margin; ?>>
					<textarea id="<?php echo $meta_field['name']; ?>" name="<?php echo $meta_field['name']; ?>" type="textarea" cols="40" rows="2"><?php echo $value; ?></textarea>
					<br /><label for="<?php echo $meta_field['name']; ?>"><?php echo $meta_field['label']; ?></label>
					<?php  
					
					break;
					
				case "text": ?>
					<?php $width = (!$meta_field['width']) ? '250px' : ($meta_field['width'] == 'full') ? '100%' : $meta_field['width'] . 'px'; ?>
					<p<?php echo $margin; ?>>
					<input type="text" value="<?php echo $value; ?>" name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="text_input" style="width:<?php echo $width; ?>" />
					<br /><label for="<?php echo $meta_field['name']; ?>"><?php echo $meta_field['label']; ?></label>
					</p>
					<?php
					
					break;
					
				case "radio": ?>
					<p<?php echo $margin; ?>>
					<label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="radio" value="<?php echo $meta_field['value']; ?>" <?php if ($existing_value == $meta_field['value'] || $existing_value == ""){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc']; ?></label><br />
					<label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_2" type="radio" value="<?php echo $meta_field['value2']; ?>" <?php if ($existing_value == $meta_field['value2']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc2']; ?></label>
					</p>
					<?php
					
					break;
			
				case "radio_toggle": ?>
					<p<?php echo $margin; ?>><label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" class="selector" type="radio" value="<?php echo $meta_field['value']; ?>" <?php if ($existing_value == $meta_field['value'] || $existing_value == ""){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc']; ?></label><br />
					
					<label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_2" class="selector" type="radio" value="<?php echo $meta_field['value2']; ?>" <?php if ($existing_value == $meta_field['value2']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc2']; ?></label><br />
					
					<label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_3" class="selector" type="radio" value="<?php echo $meta_field['value3']; ?>" <?php if ($existing_value == $meta_field['value3']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc3']; ?></label><br />
					
					<label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>_4" class="selector" type="radio" value="<?php echo $meta_field['value4']; ?>" <?php if ($existing_value == $meta_field['value4']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc4']; ?></label>
					</p>
					<?php
					
					break;
					
				case "select":  ?>
					<p<?php echo $margin; ?>>
					<?php 
					// select (drop down list)
					//................................................................
					echo '<select name="'. $meta_field['name'] .'" id="'. $meta_field['name'] .'" onchange="if (this.value == \'custom\') {jQuery(\'#'.$meta_field['name'] .'_customOption\').css(\'display\',\'block\');}else{jQuery(\'#'.$meta_field['name'] .'_customOption\').css(\'display\',\'none\');}">';
					echo '<option value="">Choose one...</option>';
					
					foreach ($meta_field['options'] as $key => $option) { 
						echo '<option value="'. $key .'"'; 
							if ( $existing_value == $key) { 
								echo ' selected="selected"'; 
							} elseif  ( !$existing_value && $key == $meta_field['default'] ) {
								echo ' selected="selected"'; 
							}
						echo '>'. $option .'</option>';
					}
							
					echo '</select>';
					
					
					// this select allows for a custom value entered by the user 
					if ($meta_field['custom']) {
						echo '<span id="'. $meta_field['name'] .'_customOption"'; 
							if ( $existing_value == 'custom' ) { 
								echo ' style="display:block;"'; 
							} else {
								echo ' style="display:none;"'; 
							}
						echo '><br />';
						echo '<strong>Custom:</strong><br /';
						echo '<input style="width:100%;" name="'. $meta_field['custom'] .'" id="'. $meta_field['custom'] .'" type="text" value="'. get_post_meta($post->ID, $meta_field['custom'], true) .'" />';
						echo '</span>';
					} ?>
					</p>
					<?php
								
					break;
					
				case "checkbox":
				?>
					<p<?php echo $margin; ?>>
					<label><input name="<?php echo $meta_field['name']; ?>" id="<?php echo $meta_field['name']; ?>" type="checkbox" value="<?php echo $meta_field['value']; ?>" <?php if ($existing_value == $meta_field['value']){echo 'checked="checked"';}?> /> <?php echo $meta_field['desc']; ?></label>
					</p>
					<?php
					
					break;
									
				case "customSidebar": ?>
					<p<?php echo $margin; ?>>
					<select name="<?php echo $meta_field['name']; ?>">
						<option value=""<?php if($existing_value == ''){ echo " selected";} ?>>Select A Sidebar</option>
						<?php 
						$customSidebars = get_option($shortname.'sidebarSettings');
														
						if(!empty($customSidebars) && is_array($customSidebars)) {
					
							foreach($customSidebars as $sidebar){
								if($existing_value == $sidebar){
									echo "<option value='$sidebar' selected>$sidebar</option>\n";
								}else{
									echo "<option value='$sidebar'>$sidebar</option>\n";
								}
							}
						}
								
						echo '</select>';
					
					?>
					</p>
					<?php
					
					break;
			}	// end switch
			
			// print description
			if ($description){
				echo $description;
			}
			?>
			</div>
			<?php 
			
		}	// END - if NOT $meta_field['type'] = custom
	
	}	// end foreach
	
	?>

	<input type="hidden" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>" id="<?php echo $meta_box['noncename']; ?>_noncename" name="<?php echo $meta_box['noncename']; ?>_noncename" />
	<?php 
	
}	// end function


// Images meta boxes function
function theme_postImages_meta_box() {
	theme_add_meta_box('postImages');
}

// Default options meta boxes function
function theme_generalContentOptions_meta_box() {
	theme_add_meta_box('generalContentOptions');
}

// Add Meta boxes function
function theme_add_meta_boxes() {

	$meta_boxes = theme_meta_boxes();
	
	$i=1;
	foreach ($meta_boxes as $meta_box) {
		$type = ( is_array($meta_box['type']) && !empty($meta_box['type']) ) ? $meta_box['type'] : array('post');
		if( in_array("post", $type) ) {
			add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['function'], 'post', 'normal', 'high');
		}
		if( in_array("page", $type) ) {
			add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['function'], 'page', 'normal', 'high');	
		}
		$i++;	
	}
	
	add_action('save_post', 'theme_save_meta');
}

add_action('admin_menu', 'theme_add_meta_boxes');


// Save function - update database options
function theme_save_meta($post_id) {
	global $themeTitle;

	$meta_boxes = theme_meta_boxes();
	
	foreach($meta_boxes as $meta_box) {
		if ($_POST['post_type'] == 'post') {
			if (!wp_verify_nonce($_POST['theme_postImages_noncename'], plugin_basename(__FILE__)))
				return $post_id;
			if (!wp_verify_nonce($_POST['theme_generalContentOptions_noncename'], plugin_basename(__FILE__)))
				return $post_id;
		}

		if ($_POST['post_type'] == 'page') {
			if (!wp_verify_nonce($_POST['theme_generalContentOptions_noncename'], plugin_basename(__FILE__)))
				return $post_id;
		}
	}

	if ($_POST['post_type'] == 'page') {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
	}
	else {
		if (!current_user_can('edit_post', $post_id))
			return $post_id;
	}
		if ( isset($_GET['post']) && isset($_GET['bulk_edit']) )
			return $post_id;

	foreach ($meta_boxes as $meta_box) {
		foreach ($meta_box['fields'] as $meta_field) {
			$current_data = get_post_meta($post_id, $meta_field['name'], true);	
			$new_data = $_POST[$meta_field['name']];

			if ($current_data) {
				if ($new_data == '')
					delete_post_meta($post_id, $meta_field['name']);
				elseif ($new_data == $meta_field['default'])
					delete_post_meta($post_id, $meta_field['name']);
				elseif ($new_data != $current_data)
					update_post_meta($post_id, $meta_field['name'], $new_data);
			}
			elseif ($new_data != '')
				add_post_meta($post_id, $meta_field['name'], $new_data, true);
		}
	}
}

?>