function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function insertThemeLink() {
	
	var tagtext;
	
	var style = document.getElementById("style_panel");
	var contact = document.getElementById("contact_panel");
	
	// select current shortcode for output
	if (style.className.indexOf("current") != -1) {
		var styleid = document.getElementById("style_shortcode").value;
		if (styleid != 0 ){
			tagtext = '['+ styleid + ']Your content here...[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "styled_image" ){
			tagtext = '['+ styleid + ' size="medium" align="left" link="#" lightbox="yes" alt="Image Description"]Insert full image URL here[/' + styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "plain_image" ){
			tagtext = '['+ styleid + ' w="250" h="250" alt="Image Description" resize="yes"]Insert full image URL here[/' + styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "resized_image_path" ){
			tagtext = '['+ styleid + ' w="250" h="250"]Insert full image URL here (returns resized image URL)[/' + styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "button_for_forms" ){
			tagtext = '['+ styleid + ' type="button" title="" class="" id="" name="" value="" onclick=""]Button Text[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "button_with_link" ){
			tagtext = '['+ styleid + ' url="#" target="" class="" id="" onclick=""]Button Text[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "headline" || styleid == "heading" ){
			tagtext = '['+ styleid + ' h="1"]Your Text Here[/' + styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "sub_title" ){
			tagtext = '[headline h="1"]Your Headline Here['+ styleid + ']Your Sub-Title Here[/' + styleid + '][/headline]';	
		}
		
		if (styleid != 0 && styleid == "ribbon" ){
			tagtext = '['+ styleid + ' toplink="true"]Your Text Here[/' + styleid + ']';	
		}

		if (styleid != 0 && styleid == "callout" ){
			tagtext = '['+ styleid + ']Your Text Here[/' + styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "quote" ){
			tagtext = '['+ styleid + ' cite="Person Quoted"]Your quoted text here.[/' + styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "bulleted_list" ){
			tagtext = '['+ styleid + ' style="check"]<ul>\r<li>Your Text</li>\r<li>Your Text</li>\r<li>Your Text</li>\r</ul>[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "numbered_list" ){
			tagtext = '['+ styleid + ' style="number-pad"]<ol>\r<li>Your First Item</li>\r<li>Your Second Item</li>\r<li>Your Third Item</li>\r</ol>[/' + styleid + ']';
		}
		
		if (styleid != 0 && styleid == "toggle_content" ){
			tagtext = '['+ styleid + ' title="The Title Text"]Your description text to show/hide when title is clicked.[/' + styleid + ']';	
		}
		if (styleid != 0 && styleid == "hr" || styleid == "hr_small" || styleid == "clear" ){
			tagtext = '['+ styleid + ']';	
		}
		
		if (styleid != 0 && styleid == "contact_form" ){
			tagtext = '['+ styleid + ' to="your@email.com" subject="Message from Contact Form" thankyou="Thank\'s your message has been sent."]';	
		}
		
		
		// Layout Groups
		if (styleid != 0 && styleid == "one_half_layout"){
			tagtext = "[one_half]<p>Your content here...</p>[/one_half]<br /><br />[one_half_last]<p>Your content here...</p>[/one_half_last]<br />";	
		}
		
		if (styleid != 0 && styleid == "one_third_layout"){
			tagtext = "[one_third]<p>Your content here...</p>[/one_third]<br /><br />[one_third]<p>Your content here...</p>[/one_third]<br /><br />[one_third_last]<p>Your content here...</p>[/one_third_last]<br />";	
		}
		
		if (styleid != 0 && styleid == "one_fourth_layout"){
			tagtext = "[one_fourth]<p>Your content here...</p>[/one_fourth]<br /><br />[one_fourth]<p>Your content here...</p>[/one_fourth]<br /><br />[one_fourth]<p>Your content here...</p>[/one_fourth]<br /><br />[one_fourth_last]<p>Your content here...</p>[/one_fourth_last]<br />";	
		}
		
		if (styleid != 0 && styleid == "one_third_two_third"){
			tagtext = "[one_third]<p>Your content here...</p>[/one_third]<br /><br />[two_third_last]<p>Your content here...</p>[/two_third_last]<br />";	
		}
		
		if (styleid != 0 && styleid == "two_third_one_third"){
			tagtext = "[two_third]<p>Your content here...</p>[/two_third]<br /><br />[one_third_last]<p>Your content here...</p>[/one_third_last]<br />";	
		}
		
		if (styleid != 0 && styleid == "one_fourth_one_fourth_one_half"){
			tagtext = "[one_fourth]<p>Your content here...</p>[/one_fourth]<br /><br />[one_fourth]<p>Your content here...</p>[/one_fourth]<br /><br />[one_half_last]<p>Your content here...</p>[/one_half_last]<br />";	
		}
		
		if (styleid != 0 && styleid == "one_fourth_one_half_one_fourth"){
			tagtext = "[one_fourth]<p>Your content here...</p>[/one_fourth]<br /><br />[one_half]<p>Your content here...</p>[/one_half]<br /><br />[one_fourth_last]<p>Your content here...</p>[/one_fourth_last]<br />";	
		}
		
		if (styleid != 0 && styleid == "one_half_one_fourth_one_fourth"){
			tagtext = "[one_half]<p>Your content here...</p>[/one_half]<br /><br />[one_fourth]<p>Your content here...</p>[/one_fourth]<br /><br />[one_fourth_last]<p>Your content here...</p>[/one_fourth_last]<br /><br />";	
		}		

		if ( styleid == 0 ){
			tinyMCEPopup.close();
		}
	}

	if (contact.className.indexOf("current") != -1) {
		var to = document.getElementById("contact_email").value;
		var subject = document.getElementById("contact_subject").value;
		var thankYou = document.getElementById("contact_thankyou").value;
		if (to != 0 )
			tagtext = '[contact_form to="'+ to +'" subject="'+ subject +'" thankyou="'+ thankYou +'"]';	
		else
			tinyMCEPopup.close();
		}
	
	if(window.tinyMCE) {
		window.tinyMCE.execInstanceCommand("content", "mceInsertContent", false, tagtext);
		tinyMCEPopup.editor.execCommand("mceRepaint");
		tinyMCEPopup.close();
	}
	return;
}
