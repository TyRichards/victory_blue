<?php

$options = array (
	
	array(	"name" => "slideshow",
			"format" => "help"),

	array(	"name" => "&nbsp;",
			"format" => "title"),
			
	array(	"format" => "start",
			"title" => "Slide Show Options"),
			
		array(	"name" => "Disable Slide Show",
				"desc" => "If you do not want a home page slide show, enable this option.",
				"label" => "Disable Slide Show",
				"id" => $shortname."slideShowDisabled",
				"default" => "",
				"format" => "checkbox"),
		array(	"name" => "Slide Show Style",
				"desc" => "Select which slide show style to use on the home page.",
				"id" => $shortname."slideShowType",
				"options"=> array('cycle'=>'Default (Cycle Plugin)', 'galleryView'=>'Gallery View'),
				"default" => "cycle",
				"format" => "select"),
		array(	"name" => "Delay",
				"desc" => "The delay in seconds between slides between slides.",
				"id" => $shortname."slideShowTimeout",
				"default" => "6",
				"options"=> array(
					'0'=>'0 (auto play off) ', 
					'1'=>'1', 
					'2'=>'2', 
					'3'=>'3', 
					'4'=>'4', 
					'5'=>'5', 
					'6'=>'6', 
					'7'=>'7', 
					'8'=>'8', 
					'9'=>'9', 
					'10'=>'10', 
					'11'=>'11', 
					'12'=>'12', 
					'13'=>'13', 
					'14'=>'14', 
					'15'=>'15'),
				"format" => "select"),
				
	array(	"format" => "end")
	
);

?>