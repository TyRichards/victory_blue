<?php

// Do not edit this if you are not familiar with php
error_reporting (E_ALL ^ E_NOTICE);
$post = (!empty($_POST)) ? true : false;
if($post) {
	function ValidateEmail($email){

		$regex = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
		$eregi = preg_replace($regex,'', trim($email));
		
		return empty($eregi) ? true : false;
	}

	$name = stripslashes($_POST['ContactName']);
	$to = strDec(trim($_POST['_R']));
	$email = trim($_POST['ContactEmail']);
	$subject = strDec(trim($_POST['_S']));
	$message = stripslashes($_POST['ContactComment']);
	$phone = stripslashes($_POST['ContactPhone']);
	$error = '';
	$Reply=$to;
	$from=$to;
	
	// Check Name Field
	if(!$name) {
		$error .= 'Please enter your name.<br />';
	}
	
	// Checks Email Field
	if(!$email) { 
		$error .= 'Please enter an e-mail address.<br />';
	}
	if($email && !ValidateEmail($email)) {
		$error .= 'Please enter a valid e-mail address.<br />';
	}
	if(is_numeric($phone) && strlen($phone) < 8) {
		$error .= 'Please enter your full phone number.<br />';
	}

	// Checks Subject Field
	//if(!$subject) {
	//	$error .= 'Please enter your subject.<br />';
	//}
	
	// Checks Message (length)
	if(!$message || strlen($message) < 3) {
		$error .=  "Please enter your message. It should have at least 5 characters.<br />";
	}
	
	// Let's send the email.
	if(!$error) {
		$messages="From: $email <br>";
		$messages.="Name: $name <br>";
		$messages.="Email: $email <br>";
		$messages.="Phone: $phone <br>";
		$messages.="Message: $message <br>";
		$emailto=$to;
		
		$mail = mail($emailto,$subject,$messages,"from: $from <$Reply>\nReply-To: $Reply \nContent-type: text/html");	
	
		if($mail) {
			echo 'success';
		}
	} else {
		echo '<div class="error">'.$error.'</div>';
	}

}

#-----------------------------------------------------------------
# Simple string encode/decode functions
#-----------------------------------------------------------------

$strEncOffset = 19; // set to a unique number for offset (must be same as "contact.php".

function strEnc($s) {
    for( $i = 0; $i < strlen($s); $i++ )
        $r[] = ord($s[$i]) + $strEncOffset;
    return implode('.', $r);
}
 
function strDec($s) {
    $s = explode(".", $s);
    for( $i = 0; $i < count($s); $i++ )
        $s[$i] = chr($s[$i] - $strEncOffset);
    return implode('', $s);
}

?>