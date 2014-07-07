<?php 
/* 
Plugin Name: SMI Connect Locations and Users 
Plugin URL: http://www.squareminc.com/ 
Description: A plugin that populates the Wordpress User Database with the Location Plugin 
Author: MJK
Version: 1.0 
Author URL: http://www.squareminc.com
*/ 


//user_register 

add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3>Distributor Address</h3>
    <p>Enter the contract information for the distributor. This will be their default company name and address on the distributor locator.</p>
    <p>Developer Notes: Has Coord [<?php echo get_the_author_meta( 'has_coord', $user->ID ); ?>] and ID: [<?php echo get_the_author_meta( 'has_coord_id', $user->ID ); ?>]</p>

	<table class="form-table">

		<tr>
			<th><label for="company">Company Name</label></th>

			<td>
				<input type="text" name="company" id="company" value="<?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter distributor's company name.</span>
			</td>
		</tr>
        
        
        
		<tr>
			<th><label for="address">Address</label></th>

			<td>
				<input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Address line 1</span>
			</td>
		</tr>
        
          
		<tr>
			<th><label for="address2">Address 2</label></th>

			<td>
				<input type="text" name="address2" id="address2" value="<?php echo esc_attr( get_the_author_meta( 'address2', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Address line 2</span>
			</td>
		</tr>
        
        
        	<tr>
			<th><label for="city">City</label></th>

			<td>
				<input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">City</span>
			</td>
		</tr>
        
        
        	<tr>
			<th><label for="state">State</label></th>

			<td>
				<input type="text" name="state" id="state" value="<?php echo esc_attr( get_the_author_meta( 'state', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">State (enter as abbreviation, i.e. CA, TX, NY)</span>
			</td>
		</tr>
        
        
        <tr>
			<th><label for="zip">Zip</label></th>

			<td>
				<input type="text" name="zip" id="zip" value="<?php echo esc_attr( get_the_author_meta( 'zip', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Zip</span>
			</td>
		</tr>

	</table>
    
    
    
    
    <h3>Pricing for this distributor</h3>
    <p>Enter each price in format <strong>1.25 or .98</strong>.  The dollar sign will be added on the frontend.</p>

	<table class="form-table">

		<tr>
			<th><label for="def1">1 Gallon</label></th>

			<td>
				<input type="text" name="def1" id="def1" value="<?php echo esc_attr( get_the_author_meta( 'def1', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Pricing for SKU: DEF1</span>
			</td>
		</tr>
        
        
        
		<tr>
			<th><label for="def25">2.5 Gallons</label></th>

			<td>
				<input type="text" name="def25" id="def25" value="<?php echo esc_attr( get_the_author_meta( 'def25', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Pricing for SKU: DEF25</span>
			</td>
		</tr>
        
          
		<tr>
			<th><label for="address2">55 Gallon Drum</label></th>

			<td>
				<input type="text" name="def55" id="def55" value="<?php echo esc_attr( get_the_author_meta( 'def55', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Pricing for SKU: DEF55</span>
			</td>
		</tr>
        
        
        	<tr>
			<th><label for="city">275 Gallon Tote</label></th>

			<td>
				<input type="text" name="def275" id="def275" value="<?php echo esc_attr( get_the_author_meta( 'def275', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Pricing for SKU: DEF275</span>
			</td>
		</tr>
        
        
        	<tr>
			<th><label for="state">330 Gallon Tote</label></th>

			<td>
				<input type="text" name="def330" id="def300" value="<?php echo esc_attr( get_the_author_meta( 'def330', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Pricing for SKU: DEF330</span>
			</td>
		</tr>
        
        
        <tr>
			<th><label for="zip">5,000 Gallon Truck Load</label></th>

			<td>
				<input type="text" name="def5000" id="def5000" value="<?php echo esc_attr( get_the_author_meta( 'def5000', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Pricing for SKU: DEF5000</span>
			</td>
		</tr>
        
        
         <tr>
			<th><label for="zip">18,000 Gallon Rail Car</label></th>

			<td>
				<input type="text" name="def18000" id="def18000" value="<?php echo esc_attr( get_the_author_meta( 'def18000', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Pricing for SKU: DEF18000</span>
			</td>
		</tr>

	</table>
    
    
    
<?php }

add_action( 'edit_user_profile_update', 'SMIsynch' );

function SMIsynch($user_id) {


	
	global $wpdb;
	
	
    update_usermeta( $user_id, 'company', $_POST['company'] );
	update_usermeta( $user_id, 'address', $_POST['address'] );
	update_usermeta( $user_id, 'address2', $_POST['address2'] );
	update_usermeta( $user_id, 'city', $_POST['city'] );
	update_usermeta( $user_id, 'state', $_POST['state'] );
	update_usermeta( $user_id, 'zip', $_POST['zip'] );
	
	//Pricing Updates
	update_usermeta( $user_id, 'def1', $_POST['def1'] );
	update_usermeta( $user_id, 'def25', $_POST['def25'] );
	update_usermeta( $user_id, 'def55', $_POST['def55'] );
	update_usermeta( $user_id, 'def275', $_POST['def275'] );
	update_usermeta( $user_id, 'def330', $_POST['def330'] );
	update_usermeta( $user_id, 'def5000', $_POST['def5000'] );
	update_usermeta( $user_id, 'def18000', $_POST['def18000'] );
	
	
	//Now that we are updated, we need to update the locations table
	
	$has_coord = get_the_author_meta( 'has_coord', $user_id );
	//if($has_coord == "9") {
		
	//} else {
		
	$wpdb->insert( 'wp_store_locator', array( 'sl_store' => $_POST['company'], 'sl_address' => $_POST['address'], 'sl_address2' => $_POST['address2'], 'sl_city' => $_POST['city'], 'sl_state' => $_POST['sl_state'], 'sl_zip' => $_POST['sl_zip'], 'sl_phone' => $_POST['sl_phone'] ), array( '%s', '%s','%s','%s','%s','%s','%s','%s' ) );

		
	update_usermeta( $user_id, 'has_coord', "Y" );
	update_usermeta( $user_id, 'has_coord_id', $wpdb->insert_id );
	//
	//}
	


}



?>
