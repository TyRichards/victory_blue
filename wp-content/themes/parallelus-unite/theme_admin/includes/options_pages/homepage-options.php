<?php

$options = array (

	array(	"name" => "homepage",
			"format" => "help"),

	array(	"name" => "Home Page",
			"format" => "title"),
			
	array(	"format" => "start",
			"title" => "Showcase"),
			
		array(	"name" => "Showcase Columns",
				"desc" => "Select the number of widget columns to use for the home page showcase area. This is the area that appears directly below the slide show and before the page content or side bar. To add content to this area add widget from the \"Appearance &raquo; Widgets\" section.",
				"id" => $shortname."showcaseColumns",
				"default" => "showcase_left=true&showcase_right=true",
				"options" => array(
					'off' => 'Hide Showcase Area', 
					'showcase_left=true' => '1 Column (full page)', 
					'showcase_left=true&showcase_right=true' => '2 Column (default)', 
					'showcase_left=true&showcase_middle=true&showcase_right=true' =>'3 Column'),
				"format" => "select"),
						
	array(	"format" => "end"),

	array(	"format" => "start",
			"title" => "Introduction Text"),
			
		array(	"name" => "Headline",
				"desc" => "The headline text to show on the home page. Use &lt;strong&gt;strong tags&lt;/strong&gt; to highlight specific words or phrases.",
				"id" => $shortname."homePageHeadline",
				"default" => "Welcome to <strong>Unite</strong>, merging <strong>crisp</strong> design, <strong>powerful</strong> communication and <strong>ease of use</strong>.",
				"format" => "textarea"),
				
		array(	"name" => "Message",
				"desc" => "The \"welcome\" message to show on the home page. This text immediately follows the headline.",
				"id" => $shortname."homePageMessage",
				"default" => 'Unite takes a clean, organized approach to presenting content so it\'s easier to find what you want. The theme includes page layouts for: <a href="#">full page</a>, <a href="#">multi-column</a>, <a href="#">blog</a>, <a href="#">portfolio</a>, <br /><a href="#">contact form</a> and an <a href="#" class="login" title="Custom Login Page|This theme includes 2 different login forms. Apply either with your admin portal for a cohesive, stylish website. (click for preveiw)">administrative login</a> (<a href="#ContentPanel" class="topReveal" title="Alternate Admin Login|Preview the alternate login.">alternate</a>).',
				"format" => "textarea"),
						
	array(	"format" => "end"),
			
	array(	"format" => "start",
			"title" => "Featured Content"),
			
		array(	"name" => "Show Featured Posts",
				"desc" => "Include featured posts section on the home page.",
				"id" => $shortname."featuredContentActive",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),
				
		array(	"name" => "Number of Featured",
				"desc" => "Select the number of posts to show in the Featured Content section.",
				"id" => $shortname."featuredContentCount",
				"default" => "4",
				"options"=>array('all'=>'Show all','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15'),
				"format" => "select"),
				
		array(	"name" => "Title",
				"desc" => "Type the title to use for the Featured Content section.",
				"id" => $shortname."featuredContentTitle",
				"default" => "Featured Content",
				"format" => "text"),
		
	array(	"format" => "end"),
	
	array(	"format" => "start",
			"title" => "Home Page Posts"),
		
		array(	"name" => "Show Posts on Home Page",
				"desc" => "Include posts section on the home page. These show immediately after the Featured Content and exclude any posts marked as sticky.",
				"id" => $shortname."homePostsActive",
				"label" => "Enable",
				"default" => "1",
				"format" => "checkbox"),
		
		array(	"name" => "Number of Posts",
				"desc" => "Select the number of posts to show on the home page.",
				"id" => $shortname."homePostsCount",
				"default" => "2",
				"options"=>array('-1'=>'Show all','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15'),
				"format" => "select"),
					
	array(	"format" => "end")

);

?>