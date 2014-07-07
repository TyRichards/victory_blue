<?php

// Load head file
require_once('popup-head.php');

?>
<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
	<form name="theme_editor_options" action="#">
	<div class="tabs">
		<ul>
			<li id="style_tab" class="current"><span><a href="javascript:mcTabs.displayTab('style_tab','style_panel');" onMouseDown="return false;">Styles Shortcodes</a></span></li>
			<li id="contact_tab"><span><a href="javascript:mcTabs.displayTab('contact_tab','contact_panel');" onMouseDown="return false;">Contact Form</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper" style="height: 215px;">

			<!-- Shortcode List -->
			<div id="style_panel" class="panel current">
			<br />
			<fieldset>
				<legend>Shortcodes</legend>
				<table border="0" cellpadding="4" cellspacing="0">
				 <tr>
					<td nowrap="nowrap"><label for="style_shortcode" style="font-size:12px;">Select One:</label></td>
					<td><select id="style_shortcode" name="style_shortcode" style="font-size:13px;">
						<option value="0">Select a shortcode...</option>
						<?php
						if(is_array($shortcode_tags)) {
							$i=1;
							foreach ($shortcode_tags as $theme_sc_key => $theme_sc_value) {
								if( preg_match('/theme/', $theme_sc_value) ) {
	
									$theme_sc_name = str_replace('theme_', '' ,$theme_sc_value);
									$theme_sc_name = str_replace('_sc', '' ,$theme_sc_name);
									$theme_sc_name = str_replace('_', ' ' ,$theme_sc_name);
									
									$optionGroups = array(
									// position	=>	label
										1		=>	"Images",
										4		=>	"Buttons",
										6		=>	"Text",
										10		=>	"Lists",
										12		=>	"Dividers",
										14		=>	"Content Layouts",									
										23		=>	"Forms"									
									);
									
									// insert optiongroup label START
									if ($optionGroups[$i]) { echo '<optgroup label="'. $optionGroups[$i] .'">'; }
	
									$theme_sc_name = ucwords($theme_sc_name);
									echo '<option value="' . $theme_sc_key . '" >' . $theme_sc_name . '</option>' . "\n";
	
									// insert optiongroup label END
									if ($optionGroups[$i+1]) { echo '</optgroup>'; }
									
									// Add layout groups
									if($i==11){ 
										echo '<optgroup label="Content Layout Groups">';
										echo '<option value="one_half_layout" >Two Column Layout</option>' . "\n";
										echo '<option value="one_third_layout" >Three Column Layout</option>' . "\n";
										echo '<option value="one_fourth_layout" >Four Column Layout</option>' . "\n";
										echo '<option value="one_third_two_third" >One Third - Two Third</option>' . "\n";
										echo '<option value="two_third_one_third" >Two Third - One Third</option>' . "\n";
										echo '<option value="one_fourth_one_fourth_one_half" >One Fourth - One Fourth - One Half</option>' . "\n";
										echo '<option value="one_fourth_one_half_one_fourth" >One Fourth - One Half - One Fourth</option>' . "\n";
										echo '<option value="one_half_one_fourth_one_fourth" >One Half - One Fourth - One Fourth</option>' . "\n";
										echo '</optgroup>'; 
									}
									$i++;
								}
							}
						} ?>
					</select>
					
					</td>
				  </tr>
				  <tr>
				  	<td>&nbsp;</td>
					<td><p style="font-size:12px; line-height: 1.4;">Select a shortcode and click the "Insert" button to add it to your page.</p></td>
				  </tr>
				</table>
				
			</fieldset>
			</div>
		
		
		
		<!-- Contact Form Shortcode -->
		<div id="contact_panel" class="panel">
		<br />
		<fieldset>
			<legend>Contact Options</legend>
		<table border="0" cellpadding="4" cellspacing="0">
			<tr>
				<td nowrap="nowrap"><label for="contact_email">Email Address:</label></td>
				<td><input type="text" id="contact_email" name="contact_email" size="35" style="font-size:13px;" /><br /></td>
			</tr>
			<tr>
				<td nowrap="nowrap"><label for="contact_subject">Subject:</label></td>
				<td><input type="text" id="contact_subject" name="contact_subject" size="35" style="font-size:13px;" /><br /></td>
			</tr>
			<tr>
				<td nowrap="nowrap"><label for="contact_thankyou">Thank You Message:</label></td>
				<td><input type="text" id="contact_thankyou" name="contact_thankyou" size="35" style="font-size:13px;" /><br /></td>
			</tr>
        </table>
		</fieldset>
		</div><!-- contact_panel -->
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="<?php echo "Cancel"; ?>" onClick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="<?php echo "Insert"; ?>" onClick="insertThemeLink();" />
		</div>
	</div>
</form>
</body>
</html>
