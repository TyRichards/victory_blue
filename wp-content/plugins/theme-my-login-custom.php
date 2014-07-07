<?php



// This function will output the fields to the register form
function tml_register_form( &$template ) {
	echo '<div>' . "\n";
        echo '<label for="profile_first_name">First Name</label>' . "\n";
        echo '<input type="text" class="input" id="profile_first_name" name="profile_first_name" value="' . $_POST['profile_first_name'] . '" />' . "\n";
	echo '</div>' . "\n";  
    echo '<div>' . "\n";     
        echo '<label for="profile_last_name">Last Name</label>' . "\n";
        echo '<input type="text" class="input" id="profile_last_name" name="profile_last_name" value="'. $_POST['profile_last_name'] .'" />' . "\n";
	echo '</div>' . "\n";	  
    echo '<div>' . "\n";     
        echo '<label for="profile_company">Company</label>' . "\n";
        echo '<input type="text" class="input" id="profile_company" name="profile_company" value="'. $_POST['profile_company'] .'" />' . "\n";
	echo '</div>' . "\n";	  
    echo '<div>' . "\n";     
        echo '<label for="profile_address">Address</label>' . "\n";
        echo '<input type="text" class="input" id="profile_address" name="profile_address" value="'. $_POST['profile_address'] .'" />' . "\n";
	echo '</div>' . "\n";	  
    echo '<div>' . "\n";     
        echo '<label for="profile_city">City</label>' . "\n";
        echo '<input type="text" class="input" id="profile_city" name="profile_city" value="'. $_POST['profile_city'] .'" />' . "\n";
	echo '</div>' . "\n";	  
    echo '<div>' . "\n";     
        echo '<label for="profile_zip">Zip Code</label>' . "\n";
        echo '<input type="text" class="input" id="profile_zip" name="profile_zip" value="'. $_POST['profile_zip'] .'" />' . "\n";
	echo '</div>' . "\n";	  
    echo '<div>' . "\n";     
        echo '<label for="profile_phone">Phone Number</label>' . "\n";
        echo '<input type="text" class="input" id="profile_phone" name="profile_phone" value="'. $_POST['profile_phone'] .'" />' . "\n";
	echo '</div>' . "\n";	
    echo '<div class="last-div">' . "\n";     
        echo '<label for="profile_username">Username - use company &amp; city  (Ex: Victory Blue Dallas)</label>' . "\n";
        echo '<input type="text" class="input" id="profile_username" name="profile_username" value="'. $_POST['profile_username'] .'" />' . "\n";
	echo '</div>' . "\n";	
}
add_action( 'tml_register_form', 'tml_register_form' );

function tml_registration_errors( $errors = '' ) {
		// Make sure $errors is a WP_Error object
		if ( empty( $errors ) )
			$errors = new WP_Error();
	if ( empty( $_POST['profile_first_name'] ) )
		$errors->add( 'profile_first_name', __( '<strong>ERROR</strong>: Please enter your first name.' ) );
	if ( empty( $_POST['profile_last_name'] ) )
		$errors->add( 'profile_last_name', __( '<strong>ERROR</strong>: Please enter your last name.' ) );
	if ( empty( $_POST['profile_company'] ) )
		$errors->add( 'profile_company', __( '<strong>ERROR</strong>: Please enter your Company name.' ) );
	if ( empty( $_POST['profile_city'] ) )
		$errors->add( 'profile_city', __( '<strong>ERROR</strong>: Please enter your city.' ) );
	if ( empty( $_POST['profile_zip'] ) )
		$errors->add( 'profile_zip', __( '<strong>ERROR</strong>: Please enter your zip code.' ) );
	if ( empty( $_POST['profile_phone'] ) )
		$errors->add( 'profile_phone', __( '<strong>ERROR</strong>: Please enter your phone number.' ) );
	if ( empty( $_POST['profile_username'] ) )
		$errors->add( 'profile_username', __( '<strong>ERROR</strong>: Please enter your username.' ) );

		return $errors;		
}
add_filter( 'registration_errors', 'tml_registration_errors' );

function tml_new_user_registered( $user_id ) {
				
	$first_name = $_POST['profile_first_name'];
	$last_name = $_POST['profile_last_name'];		
	$user_nicename = sanitize_title(strtolower($_POST['profile_first_name'].'-'.$_POST['profile_last_name']));
	$usercompany = $_POST['profile_company'];									
	$useraddress = $_POST['profile_address'];			
	$usercity = $_POST['profile_city'];			
	$userzip = $_POST['profile_zip'];			
	$userphone = $_POST['profile_phone'];		
	$userusername = $_POST['profile_username'];		


	update_user_meta($user_id, 'usercompany', $usercompany);
	update_user_meta($user_id, 'useraddress', $useraddress);
	update_user_meta($user_id, 'usercity', $usercity);
	update_user_meta($user_id, 'userzip', $userzip);
	update_user_meta($user_id, 'userphone', $userphone);
	wp_update_user(array('ID' => $user_id,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'user_nicename' => $user_nicename,
						'display_name' => $userusername,
						'nickname' => $userusername,
						'role' => 'Pending'
						)
						);		
		
	
	//wp_set_auth_cookie( $user_id, false, is_ssl() );
    wp_redirect( 'http://www.govictoryblue.com/order-online/thanks-for-registering/' );
    exit;
}
add_action( 'tml_new_user_registered', 'tml_new_user_registered',50 );

?>