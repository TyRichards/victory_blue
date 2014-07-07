<?php

$options = array (
	
	array(	"name" => "contact",
			"format" => "help"),

	array(	"name" => "Contact Form",
			"format" => "title"),

	array(	"format" => "start"),
					
		array(	"name" => "Contact Email",
				"desc" => "Enter the email address where contact for submissions should be sent. (i.e., webmaster@yoursite.com)",
				"id" => $shortname."contactEmail",
				"default" => "",
				"format" => "text"),
		array(	"name" => "Subject",
				"desc" => "Enter the email subject used for contact form messages.",
				"id" => $shortname."contactEmailSubject",
				"default" => "",
				"format" => "text"),
		array(	"name" => "Thank You Message",
				"desc" => "Enter the thank you message the visitor will see after sending.",
				"id" => $shortname."contactThankYouMessage",
				"default" => "Your message has been sent. Thank you!",
				"format" => "textarea"),
		array( "name"	=>	"Short Code",
		 		"desc"  =>	"You can optionally specify different values for the <u>to</u>, <u>subject</u> or <u>thankyou</u> fields with each instance of the form. Empty fields default to the default settings entered above.",
				"default" => $str_shortcode,
				"id"	=>	$shortname."contactShortCode",
				"format" =>	"text_readonly"),
				
	array(	"format" => "end")
	
);

?>