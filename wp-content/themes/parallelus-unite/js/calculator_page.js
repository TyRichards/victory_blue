
		
			jQuery(document).ready(function() {
											
											
			//On itial page load, lets see what we get in the fields
			
			
			digits_start = function(digits_start){
					
					
				jQuery(digits_start).val("");
			
				//  if( jQuery(digits_start).val() > "") {
									  
									  
								
									
								//	jQuery(digits_start).parent(".calc_buttons").addClass("calc_buttons_over");
									  
								 // } else {
									  
								//	  jQuery(digits_start).parent(".calc_buttons").removeClass("calc_buttons_over");
									  
								//  }
											
											
			}
				 
							
			//Add commas, remove non-integers
			
			digits = function(digits){
				  jQuery(digits).keyup(
								 function() {
								   jQuery(this).val( jQuery(this).val().replace(/[A-Za-z$-,]/g, ""));
								   jQuery(this).val( jQuery(this).val().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
								   
								   
								   
								     go_flag = 1;
						  
									  jQuery('#calcform :input').each(function() {
																			   
											if(jQuery(this).val() <= "") {
												
											go_flag	= 0;
												
											}
											
											
												
									  });
									  
									  activate_calc(go_flag);
								   
								   
								 }
								 
								 
					
					
				  )
				  
				  
				   jQuery(digits).change(
								 function() {
								   
								   
								  if( jQuery(this).val() > "") {
									  
									  
									
									
									jQuery(this).parent(".calc_buttons").addClass("calc_buttons_over");
									  
								  } else {
									  
									  jQuery(this).parent(".calc_buttons").removeClass("calc_buttons_over");
									  
								  }
								   
								   
								 }
				  )
				   
				   
				   
				   
				   
				   
				   
				   
				 
				  
    		}

	
	
					
							
				
				
				
				
				
								
				jQuery('select').change(function() {
  							
							
						  go_flag = 1;
						  
						  jQuery('#calcform :input').each(function() {
																   
								if(jQuery(this).val() <= "") {
									
								go_flag	= 0;
									
								}
								
								
									
						  });
						  
						 
						 
						 activate_calc(go_flag);
						 

  
  
				});			
											
			
			
			function activate_calc (flag) {
				
				
				//alert(flag);
				if(flag == 1) {
				
				jQuery(".calc_go").addClass("calc_go_over");
				jQuery(".calc_go").attr("href","#");
				
				} else {
					
					
				jQuery(".calc_go").removeClass("calc_go_over");	
				jQuery(".calc_go").removeAttr('href');
				
				
				}
				
				
			}
				
				
				
			
			
					
			
			
			        digits('#num_mileagepervehicle');
					digits('#num_vehicles');
					digits('#num_mileagepervehicle');
					digits('#num_mileagepergallon');
					digits('#num_sizeofdef');
					digits('#num_defusagepercent');	
					
					
					
					digits_start('#num_mileagepervehicle');
					digits_start('#num_vehicles');
					digits_start('#num_mileagepervehicle');
					digits_start('#num_mileagepergallon');
					digits_start('#num_sizeofdef');
					digits_start('#num_defusagepercent');	
					
					
					
					
					
			//When activating claculation
			
			
			
			jQuery('#calc_go_button').click(function() {
													 
				if( jQuery(this).attr('href') ) {									 
									
									
						
						function stripCharacters(str) {
							str = str.replace('$','');
							str = str.replace(',','');
							str = str.replace(',','');
							str = str.replace(',','');
							return str;
						} 
											
											
						function addCommas(nStr)
						{
							nStr += '';
							x = nStr.split('.');
							x1 = x[0];
							x2 = x.length > 1 ? '.' + x[1] : '';
							var rgx = /(\d+)(\d{3})/;
							while (rgx.test(x1)) {
								x1 = x1.replace(rgx, '$1' + ',' + '$2');
							}
							return x1 + x2;
						}

			
						num_vehicles = stripCharacters(jQuery('#num_vehicles').val());
						num_mileagepervehicle = stripCharacters(jQuery('#num_mileagepervehicle').val());
						num_mileagepergallon = stripCharacters(jQuery('#num_mileagepergallon').val());
						num_sizeofdef = stripCharacters(jQuery('#num_sizeofdef').val());
						num_defusagepercent = jQuery('#num_defusagepercent').val();
						
						
						calc_dieselyear = Math.round(num_vehicles * (num_mileagepervehicle / num_mileagepergallon));
						
						calc_defyear = Math.round(calc_dieselyear * num_defusagepercent);
						
						calc_deftruck = Math.round(calc_defyear/num_vehicles);
						
						//alert(addCommas(calc_dieselyear));
						jQuery('#dfpy').html(addCommas(calc_dieselyear)+ " gal");
						jQuery('#defpy').html(addCommas(calc_defyear)+ " gal");
						jQuery('#deftruck').html(addCommas(calc_deftruck)+ " gal");
						
						
						//Now the products
						//Using calc_defyear
						
						//Prod 1 Gallon
						
						if(calc_defyear >= 1) {
							
							
							jQuery('#prod1 span').html(addCommas(calc_defyear));
							
							jQuery('#prod1').parent('div').removeClass('size1off');
							jQuery('#prod1').parent('div').addClass('size1on');
							jQuery('#prod1').removeClass('numoff');
							jQuery('#buy1').css('display','block');
							
						
							
						} else {
							
							
							jQuery('#prod1').addClass('numoff');
							
							jQuery('#prod1 span').html('');
							jQuery('#prod1').parent('div').removeClass('size1on');
							jQuery('#prod1').parent('div').addClass('size1off');
							jQuery('#buy1').css('display','none');
							
							
						}
						
						
						
						
						if(calc_defyear >= 2) {
							
							
							newamount = Math.ceil(calc_defyear / 2.5);
							
							jQuery('#prod2 span').html(addCommas(newamount));
							
							jQuery('#prod2').parent('div').removeClass('size2off');
							jQuery('#prod2').parent('div').addClass('size2on');
							jQuery('#prod2').removeClass('numoff');
							jQuery('#buy2').css('display','block');
							
							
							
							} else {
							
							
							jQuery('#prod2').addClass('numoff');
							
							jQuery('#prod2 span').html('');
							jQuery('#prod2').parent('div').removeClass('size2on');
							jQuery('#prod2').parent('div').addClass('size2off');
							jQuery('#buy2').css('display','none');
							
						
							
						}
						
						
						
						
							if(calc_defyear >= 55) {
							
							
							newamount = Math.ceil(calc_defyear / 55);
							
							jQuery('#prod3 span').html(addCommas(newamount));
							
							jQuery('#prod3').parent('div').removeClass('size3off');
							jQuery('#prod3').parent('div').addClass('size3on');
							jQuery('#prod3').removeClass('numoff');
							jQuery('#buy3').css('display','block');
							
							
							
							} else {
							
							
							jQuery('#prod3').addClass('numoff');
							
							jQuery('#prod3 span').html('');
							jQuery('#prod3').parent('div').removeClass('size3on');
							jQuery('#prod3').parent('div').addClass('size3off');
							jQuery('#buy3').css('display','none');
							
						
							
						}
						
						
						
						
						
							if(calc_defyear >= 275) {
							
							
							newamount = Math.ceil(calc_defyear / 275);
							
							jQuery('#prod4 span').html(addCommas(newamount));
							
							jQuery('#prod4').parent('div').removeClass('size4off');
							jQuery('#prod4').parent('div').addClass('size4on');
							jQuery('#prod4').removeClass('numoff');
							jQuery('#buy4').css('display','block');
							
							
							
							} else {
							
							
							jQuery('#prod4').addClass('numoff');
							
							jQuery('#prod4 span').html('');
							jQuery('#prod4').parent('div').removeClass('size4on');
							jQuery('#prod4').parent('div').addClass('size4off');
							jQuery('#buy4').css('display','none');
							
						
							
						}
						
						
						
						
						
						
							if(calc_defyear >= 330) {
							
							
							newamount = Math.ceil(calc_defyear / 330);
							
							jQuery('#prod45 span').html(addCommas(newamount));
							
							jQuery('#prod45').parent('div').removeClass('size45off');
							jQuery('#prod45').parent('div').addClass('size45on');
							jQuery('#prod45').removeClass('numoff');
							jQuery('#buy45').css('display','block');
							
							
							
							} else {
							
							
							jQuery('#prod45').addClass('numoff');
							
							jQuery('#prod45 span').html('');
							jQuery('#prod45').parent('div').removeClass('size45on');
							jQuery('#prod45').parent('div').addClass('size45off');
							jQuery('#buy45').css('display','none');
							
						
							
						}
						
						
						
						
						
						
							if(calc_defyear >= 5000) {
							
							
							newamount = Math.ceil(calc_defyear / 5000);
							
							jQuery('#prod5 span').html(addCommas(newamount));
							
							jQuery('#prod5').parent('div').removeClass('size5off');
							jQuery('#prod5').parent('div').addClass('size5on');
							jQuery('#prod5').removeClass('numoff');
							jQuery('#buy5').css('display','block');
							
							
							
							} else {
							
							
							jQuery('#prod5').addClass('numoff');
							
							jQuery('#prod5 span').html('');
							jQuery('#prod5').parent('div').removeClass('size5on');
							jQuery('#prod5').parent('div').addClass('size5off');
							jQuery('#buy5').css('display','none');
							
						
							
						}
						
						
						
							if(calc_defyear >= 18000) {
							
							
							newamount = Math.ceil(calc_defyear / 18000);
							
							jQuery('#prod6 span').html(addCommas(newamount));
							
							jQuery('#prod6').parent('div').removeClass('size6off');
							jQuery('#prod6').parent('div').addClass('size6on');
							jQuery('#prod6').removeClass('numoff');
							jQuery('#buy6').css('display','block');
							
							
							
							} else {
							
							
							jQuery('#prod6').addClass('numoff');
							
							jQuery('#prod6 span').html('');
							jQuery('#prod6').parent('div').removeClass('size6on');
							jQuery('#prod6').parent('div').addClass('size6off');
							jQuery('#buy6').css('display','none');
							
						
							
						}
						
						
						
						
			
			  
				}
			  
			  
			  
			});
							
			

});

    