<?php 
#==================================================================
#
#	Functions used to load and display the theme options
#
#==================================================================


#-----------------------------------------------------------------
# Print options - Gets and runs function for each option type
#-----------------------------------------------------------------

function listOptions($options) {	
	echo '<form method="post" action="">';
	
	// load the function type for this option
	foreach ($options as $value) { 
		if (function_exists('options_'.$value['format'])) {
			// calls the specific function (i.e., options_start($value) )
			call_user_func('options_'.$value['format'], $value);
		}
	}
	echo '<p class="submit">';
	echo '<input type="submit" name="save_theme_options" class="button-primary autowidth" value="Save Changes" /></p>';
	echo '</form>';
}


#-----------------------------------------------------------------
# Option type functions
#-----------------------------------------------------------------


// start (begins the table and adds section title)
//................................................................
function options_start($value) {
	echo '<div class="themeTableWrapper">';
	echo '<table cellspacing="0" class="widefat themeTable">';
	echo '<thead><tr>';
	echo '<th scope="row" colspan="2">'. $value['title'] .'</th>';
	echo '</tr></thead><tbody>';
}

// end (closes the table)
//................................................................
function options_end($value) {
	echo '</tbody></table></div>';
}

// title (prints the options page title)
//................................................................
function options_title($value) {
	echo '<h3>'. $value['name'] .'</h3>';
}

// help (shows the help button)
//................................................................
function options_help($value) {
	echo '<input type="button" class="button-secondary autowidth" style="float:right;" onClick="openHelp(\''. $value['name'] .'\');" value="Theme Help" />';
}

// save (adds additional save button)
//................................................................
function options_save($value) {
	echo '<p class="submit"><input type="submit" name="save_theme_options" class="button-primary autowidth" value="'. $value['name'] .'" /></p>';
}

// select (drop down list)
//................................................................
function options_select($value) {
	echo '<tr><th scope="row"><h4>'. $value['name'] .'</h4></th>';
	echo '<td><label>'. $value['label'] .'</label>';
	echo '<select style="width:350px;" name="'. $value['id'] .'" id="'. $value['id'] .'" onchange="checkForCustom(this, \''. $value['id'] .'_customOption\');">';
	echo '<option value="">Choose one...</option>';
	
	foreach ($value['options'] as $key=>$option) { 
		echo '<option value="'. $key .'"'; 
			if ( get_option( $value['id'] ) == $option || get_option( $value['id'] ) == $key) { 
				echo ' selected="selected"'; 
			} elseif  ( !get_option( $value['id']) && $key == $value['default'] ) {
				echo ' selected="selected"'; 
			}
		echo '>'. $option .'</option>';
	}
			
	echo '</select><br />';
	echo '<span class="description">'. $value['desc'] .'</span><br />';
	
	// this select allows for a custom value entered by the user 
	if ($value['custom']) {
		echo '<div class="customOption" id="'. $value['id'] .'_customOption"'; 
			if ( get_option( $value['id'] ) == 'custom' ) { 
				echo 'style="display:block;"'; 
			} 
		echo '><br />';
		echo '<label for="'. $value['custom'] .'">Custom:</label>';
		echo '<input style="width:297px;" name="'. $value['custom'] .'" id="'. $value['custom'] .'" type="text" value="'. get_option( $value['custom'] ) .'" />';
		echo '<br /><span class="description">'. $value['custom_desc'] .'</span>';
		echo '</div></td></tr>';
	}
}

// multiselect
//................................................................
function options_multiselect($value) {
	echo '<tr><th scope="row"><h4>'. $value['name'] .'</h4></th>';
	echo '<td><label>'. $value['label'] .'</label>';
	echo '<select style="width:350px; height:100px" name="'. $value['id'] .'[]" id="'. $value['id'] .'" multiple="multiple">';
	echo '<option value="">No Selection</option>';
	
	foreach ($value['options'] as $key=>$option) { 
		echo '<option value="'. $key .'"'; 
			if ( is_array(get_option($value['id'])) ) {
				if ( in_array($key, get_option($value['id'])) ) { 
					echo ' selected="selected"'; 
				}
			}
		echo '>'. $option .'</option>';
	}
			
	echo '</select><br />';
	echo '<span class="description">'. $value['desc'] .'</span><br />';
}

// text (displays a text input)
//................................................................
function options_text($value) {
	echo '<tr><th scope="row"><h4>'. $value['name'] .'</h4></th><td>';
	echo '<label>'. $value['label'] .'</label>';
	echo '<input style="width:350px;" name="'. $value['id'] .'" id="'. $value['id'] .'" type="'. $value['format'] .'" value="';
		if ( get_option( $value['id'] ) != "") { 
			echo stripslashes(get_option( $value['id'] )); 
		} else { 
			echo $value['default']; 
		}
	echo '" /><br />';
	echo '<span class="description">'. $value['desc'] .'</span>';
	echo '</td></tr>';
}

//Informative text for shortcode
//.................................................................
function options_text_readonly($value) {
	echo '<tr><th scope="row"><h4>'. $value['name'] .'</h4></th><td>';
	echo '<label>'. $value['label'] .'</label>';
	echo '<p>To show your contact form, copy and paste the shortcode into a post or page.<br /><br /><strong>[contact_form]</strong><br /><br />Or, enter custom values for each instance:<br /><br /><strong>[contact_form to="me@email.com" subject="My Subject" thankyou="Message Sent"]</strong></p>';
	echo '<span class="description">'. $value['desc'] .'</span>';
	echo '</td></tr>';

}

// textarea (displays a textarea)
//................................................................
function options_textarea($value) {
	echo '<tr><th scope="row"><h4>'. $value['name'] .'</h4></th><td>';
	echo '<label>'. $value['label'] .'</label>';
	echo '<textarea cols="" rows="" name="'. $value['id'] .'" style="width:350px; height:100px;" type="'. $value['format'] .'">';
		if ( get_option( $value['id'] ) != "") { 
			echo stripslashes(get_option( $value['id'] )); 
		} else { 
			echo $value['default']; 
		}
	echo '</textarea><br />';
	echo '<span class="description">'. $value['desc'] .'</span>';
	echo '</td></tr>';
}

// checkbox (adds a checkbox input)
//................................................................
function options_checkbox($value) {

	if ( get_option($value['id'],'No Value') != 'No Value' && get_option($value['id']) == true ) {
		$checked = 'checked="checked"'; 
	} elseif ( get_option($value['id'],'No Value') == 'No Value' && $value['default'] == true) { 
		$checked = 'checked="checked"';
	} else {
		$checked = ''; 
	}
	echo '<tr><th scope="row"><h4>'. $value['name'] .'</h4></th><td>';
	echo '<label>';
	echo '<input type="checkbox" name="'. $value['id'] .'" id="'. $value['id'] .'" value="true" '. $checked .' />&nbsp;';
	echo $value['label'] .'</label><br />';
	echo '<span class="description">'. $value['desc'] .'</span>';
	echo '</td></tr>';
}

// radio (adds a radio series input)
//................................................................
function options_radio($value) {
	echo '<tr><th scope="row"><h4>'. $value['name'] .'</h4></th><td>';
		
		foreach ($value['options'] as $key=>$option) { 
		
			$checked = '';
			if ( get_option($value['id'],'No Value') != 'No Value' ) {
				if ( $key == get_settings($value['id']) ){
					$checked = ' checked="checked"';
				}
			} elseif (isset($value['default']) && $key == $value['default']) {
				$checked = ' checked="checked"';
			}
			
			echo '<label><input type="radio" name="'. $value['id'] .'" value="'. $key .'" '. $checked .' />';
			echo '&nbsp;'. $option . ' &nbsp; '. $value['label'] .'</label><br />';
		}

	echo '<span class="description">'. $value['desc'] .'</span>';
	echo '</td></tr>';
}

/*
// blank ()
//................................................................
function options_blank($value) {
	echo '<tr><th scope="row"><h4>'. $value['name'] .'</h4></th><td>';
	echo '<label>'. $value['label'] .'</label>';

	echo '<br /><span class="description">'. $value['desc'] .'</span>';
	echo '</td></tr>';
}
*/


?>