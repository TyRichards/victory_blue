<?php

$options = array (
	
	array(	"name" => "config",
			"format" => "help"),

	array(	"name" => "General Settings",
			"format" => "title"),

	array(	"format" => "start",
			"title" => "Skins"),
	
		array(	"name" => "Choose a skin",
					"desc" => "Select the skin you want to use. (default = Skin 1)",
					"id" => $shortname."skinName",
					"default" => "1",
					"options" => array('1'=>'Skin 1','2'=>'Skin 2','3'=>'Skin 3','4'=>'Skin 4','5'=>'Skin 5','custom'=>'Custom'),
					"custom" => $shortname."custom_skin",
					"custom_desc" => 'Enter the filename of your custom CSS skin. (i.e., if you named you file "Skin-6.css" you would enter "Skin-6")<br />This file must be saved in '.get_template_directory().'/css/skins/ ',
					"format" => "select"),	
		array(	"name" => "Custom skin",
					"desc" => "Use a custom skin.",
					"id" => $shortname."custom_skin",
					"default" => "",
					"format" => "custom"),	
					
	array(	"format" => "end"),
	
	array(	"format" => "start",
			"title" => "Logo"),
		
		array(	"name" => "Main  Logo",
				"desc" => "Enter the full URL to your logo file. (i.e., http://www.mydomain.com/wp-content/uploads/logo.png)",
				"id" => $shortname."logoImage",
				"default" => "",
				"format" => "text"),

	array(	"format" => "end"),
	
	array(	"format" => "start",
			"title" => "Blog Post Settings"),
		
		array(	"name" => "Show Post Date",
				"desc" => "Include the posted date in blog entries.",
				"id" => $shortname."postsShowDate",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),
		array(	"name" => "Show Author Name",
				"desc" => "Include the author name in blog entries.",
				"id" => $shortname."postsShowAuthor",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),

	array(	"format" => "end"),
	
	array(	"format" => "start",
			"title" => "Tool Tips"),
		
		array(	"name" => "Show Tool Tips",
				"desc" => "Enable tool tips on items you specify. Add the class \"tip\" to show a link's \"title\" attribute and the class \"tipInclude\" to pull AJAX content from link's HREF (URL).",
				"id" => $shortname."toolTipsActive",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),
		array(	"name" => "Tool Tip ALL Links",
				"desc" => "Enable tool tips for ALL links with \"title\" attribute. This will enable tool tips on many default WordPress links.",
				"id" => $shortname."toolTipsAllTitles",
				"label" => "Enable",
				"default" => "0",
				"format" => "checkbox"),

	array(	"format" => "end"),
	
	array(	"format" => "start",
			"title" => "Other Add-on Functionality"),
		
		array(	"name" => "Ribbon Scroll Effect",
				"desc" => "Show changing ribbon wrap around effect during scrolling. This is the switching of the view perspective from top/middle/bottom on the wrap around imaged.",
				"id" => $shortname."ribbonScrollActive",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),
		
		array(	"name" => "Anchor Tag Scrolling",
				"desc" => "Activate \"ScrollTo\" jQuery plug-in to enable smooth scrolling for same page anchor tags (i.e., <a href=\"#Top\">Top</a> .",
				"id" => $shortname."anchorScrollingActive",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),

	array(	"format" => "end"),
	
	array(	"format" => "start",
			"title" => "Miscellaneous"),

		array(	"name" => "Favorites Icon",
				"desc" => "Enter the full URL to your favorites (shortcut) icon file. (i.e., http://www.mydomain.com/wp-content/uploads/favicon.ico)",
				"id" => $shortname."favicon",
				"default" => "http://para.llel.us/favicon.ico",
				"format" => "text"),
		array(	"name" => "Append to Browser Title",
				"desc" => "This text will be appended to the title shown in the browser's titlebar. You should include a separator first, i.e., \"- My Site Name\".<br /><strong>Note:</strong> This text will only apear on sub-pages and not the home page of your site.",
				"id" => $shortname."appendToPageTitle",
				"default" => "",
				"format" => "text"),
		array(	"name" => "Placeholder Images",
				"desc" => "Show placeholder images for posts and portfolio items without images attached.",
				"id" => $shortname."placeholderImages",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),
		array(	"name" => "Font Replacement",
				"desc" => "Enable the use of font replacement to allow custom fonts for headings and titles.<br /><small>If you are having trouble with different languages or special characters not showing in titles, try disabling this option.</small>",
				"id" => $shortname."fontReplacement",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),
		array(	"name" => "Show Breadcrumbs",
				"desc" => "Enable showing the content link path to pages and posts in your content.",
				"id" => $shortname."showBreadcrumbs",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),
		array(	"name" => "Copyright / Legal",
				"desc" => "Add your own copyright and legal notice to the footer.",
				"id" => $shortname."legalText",
				"default" => 
					'Copyright &copy; 2010 - <a href="http://para.llel.us" onclick="window.open(this.href); return false;">This Site</a> - All rights reserved. Conforms to W3C Standard <a href="http://validator.w3.org/check?uri=referer" onclick="window.open(this.href); return false;">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3" onclick="window.open(this.href); return false;">CSS</a>',
				"format" => "textarea"),	
		array(	"name" => "404 Error",
				"desc" => "Add your own content to display on 404 error pages.",
				"id" => $shortname."custom404",
				"default" => "",
				"format" => "textarea"),	
		array(	"name" => "Google Analytics",
				"desc" => "Enter your Google Analytics scripts or other tracking scripts to append before the &lt;/body&gt; tab..",
				"id" => $shortname."googleAnalytics",
				"default" => "",
				"format" => "textarea"),

	array(	"format" => "end")
	
);

?>