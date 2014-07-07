 jQuery(document).ready(function($) {

var fullwidth = 1406;
//var fullheight = 863;
var fullheight = 834;
var miniwidth = 885;
//var miniheight = 543;
var miniheight = 525;

var fullmarkerwidth = 72;
var fullmarkerheight = 	95;
var minimarkerwidth = 43;
var minimarkerheight = 57;

var aspect_left = (fullwidth/miniwidth) - 1;
var aspect_top = (fullheight/miniheight) - 1;

var show_left_marker = 150;
var show_top_marker = 200;

var newmarkersrc = "/images/map/marker_over.png";  
var oldmarkersrc = "/images/map/marker.png";  

var currentsel = "";

/*

From Christine in May 2013

*/



//Array [left, top, name, address]
//var paramount = [116, 274, "Paramount, CA", "7739 Monroe Street<br>Paramount, CA 90723" ];




//Tooltops for markers
 $('.marker').tooltip();



var fortworth = [469,375,"Fort Worth, TX","2101 Terminal Rd<br>Fort Worth, TX 76106"];
var millington = [585,315,"Millington, TN","5790 Old Millington Rd<br>Millington, TN 38053"];
var lima = [650,197,"Lima, OH","1900 Fort Amanda Road<br>Lima, OH 45804"];
//NEW
var thomaston = [678,357,"Thomaston, GA","100 Callas Parkway<br>Thomaston, GA, 30286"];
//NEW
var elpaso = [318,391,"El Paso, TX","9650 Railroad Dr.<br>El Paso, TX 79924"];
var chicago= [598,185,"Chicago", "Willow Springs, IL"];
//NEW
var neworleans= [594,426,"New Orleans", "Waggaman, LA"];
//NEW
var denver= [340,236,"Denver, CO", "Coming Soon"];
//NEW
var losangeles= [125,318,"Los Angeles, CA", "Coming Soon"];
var saltlakecity = [253, 207, "Salt Lake City, UT", "Coming Soon"];
var houston = [500,432,"Houston, TX","Coming Soon"];
//NEW
var phoenix = [235,346,"Phoenix, AZ","10 South 48th Ave.<br>Phoenix, AZ 85043"];
var visalia = [126,283,"Visalia, CA","7625 West Sunnyview Avenue<br>Visalia, CA 93291"];
//NEW
var stockton = [101,242,"Stockton, CA","812A Luce Ave<br>Stockton, CA 95203"];
//NEW
var davenport = [750,451,"Davenport, FL","3600 County Rd 547 N<br>Davenport, FL 18071"];
var augusta = [718,340,"Augusta, GA","23 Columbia Nitrogen Dr<br>Augusta, GA, 30901"];
//NEW
var imperial = [170, 350, "Imperial, CA", "422 East Barioni Blvd<br>Imperial, CA 92251" ];






						//Passs tring as array name and get top left x,y
						function perform_left(array_name) {
							 array_name = eval(array_name);
							 //With issues with Ty, adding some adjustments here
							 // left = -17
    						 return (array_name[0] - 17);

						}
						
						function perform_top(array_name) {
							 array_name = eval(array_name);
							 //With issues with Ty, adding some adjustments here
							 // top = -55
    						 return array_name[1] - 55;

						}
						
						
						function perform_facname(array_name) {
							 array_name = eval(array_name);
    						 return array_name[2];

						}
						
						
						function perform_facaddr(array_name) {
							 array_name = eval(array_name);
    						 return array_name[3];

						}
						
						function calc_top(coord) {
							
							
							return (aspect_top * coord) + coord;
							
							
						}
						
						
						function calc_left(coord) {
							
							
							return (aspect_left * coord) + coord;
							
							
							
						}
						



		//position elements
		
		  jQuery('.marker').each(function() {
			  
			  
			  		

					   
					    curid = "#"+jQuery(this).attr('id');
						cur = jQuery(this).attr('id');
						
						curleft = perform_left(cur);
						
						jQuery(curid).css('left',curleft);
						jQuery(curid).css('top',-150);
						
						
					   var method1 = "easeOutBounce";
		               //var method2 = "easeOutBounce";
					   
					   
					  jQuery(curid).animate({
					
							top: perform_top(cur),
							
							left: perform_left(cur)
							
						  }, {duration: 1000, easing: method1});


					   					   
					   
					
					   
					   
					
				 });
				  



		//When click on marker
		jQuery('.marker').click(function() {
				
				  
				   //Get the current coordinates of clicked item
				   	curid = "#"+jQuery(this).attr('id');
					cur = jQuery(this).attr('id');
				  
				    currentsel = cur;
				    
				    
					
					
				
				  
				   jQuery('#marker-holder, #main_usa').animate({
					
					width: fullwidth,
					height: fullheight
				  }, 'slow', function() {
					// Animation complete.
					
							
							
							
							imagename = "http://www.govictoryblue.com/images/map/loc_" + currentsel + ".jpg";
							
							
							//See if image exists
							function UrlExists(url)
							{
								var http = new XMLHttpRequest();
								http.open('HEAD', url, false);
								http.send();
								return http.status!=404;
							}
							
							
							if(!UrlExists(imagename)) {
								
								imagename = "http://www.govictoryblue.com/images/map/loc_none.png";
								
							} 
							
							facname = perform_facname(currentsel);
							facaddr = perform_facaddr(currentsel);
							
							jQuery('#detail_image').attr('src', imagename);
							jQuery('#facname').html(facname);
							jQuery('#facaddr').html(facaddr);
							
							
							jQuery('#details_holder').show('slow', function() {
								// Animation complete.
							  });

					
					
					
					
				  });
				   
				   
				
				 
				 //Pan the map
				 
				   
					
					
						starting_left = perform_left(cur);
						starting_top = perform_top(cur);
						
						big_top = calc_top(starting_top);
						big_left = calc_left(starting_left);
					
					newleft_map = show_left_marker - big_left;
					
					newtop_map = show_top_marker - big_top;
					
					
					 jQuery('#map-holder').animate({
						width: fullwidth,
					    height: fullheight,
						top: newtop_map,
						left: newleft_map
					  }, 'fast', function() {
						// Animation complete.
					
						
					  });
						
						
						
						
				 
				
				  
				  
				
				  
				  
				  
				   jQuery('.marker').each(function() {
					   
					   
					 
					    if(jQuery(this).attr('id') == currentsel) {
							
							
						jQuery("img", this).attr('src', newmarkersrc);
						
						} else {
							
							
							jQuery("img", this).attr('src', oldmarkersrc);
						
							
						}
									   
						
						
						
					    jQuery('img', this).animate({
					
							width: fullmarkerwidth,
							
							height: fullmarkerheight
							
						  }, 'fast', function() {
							// Animation complete.
							
						  });
						
						
						//Move into position    
					    curid = "#"+jQuery(this).attr('id');
						
						cur = jQuery(curid).attr('id');
						starting_left = perform_left(cur);
						starting_top = perform_top(cur);
						
						big_top = calc_top(starting_top);
						big_left = calc_left(starting_left);
						
						jQuery(curid).animate({
					
							top: big_top,
							
							left:big_left
							
						  }, 'fast', function() {
							// Animation complete.
							
							
								 
				  
							
						  });
						
						
					   
						  
						  
					
					   
					
				 });
				  
				  
				
			
				  
		});
		
		
		
				
				//If click anywhere else
				jQuery('#marker-holder').bind('click', function(e){
				   if(e.target == this){
						// do something
				  
				  currentsel = "";
				  
				   jQuery('#map-holder,#marker-holder,#main_usa').animate({
						
							width: miniwidth,
							height: miniheight,
							top:0,
							left: 0
				  }, 'fast', function() {
					// Animation complete.
					
					
						jQuery('#details_holder').hide('slow', function() {
								// Animation complete.
							  });
					
					
					
				  });
				   
				   
				   
				  
				   
				   jQuery('.marker').each(function() {
					   
					   
					   
					   jQuery("img", this).attr('src', oldmarkersrc);
					   
					   
					    jQuery('img', this).animate({
					
							width: minimarkerwidth,
							
							height: minimarkerheight
							
						  }, 'fast', function() {
							// Animation complete.
							
						  });
						
						
						jQuery("img", this).attr('src', oldmarkersrc);
						
					
						
						
						
						
						//Move into position    
					   
						
						cur = jQuery(this).attr('id');
						
						starting_left = perform_left(cur);
						starting_top = perform_top(cur)
						
						jQuery(this).animate({
					
							top: starting_top,
							
							left: starting_left
							
						  }, 'fast', function() {
							// Animation complete.
							
						  });
					   
					   
					   
					   	
					   
					   
					   
					   
					   
					   
					   
					   
					
				 });
				  
				  
				  
		   }
		});

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//Mouseover
		
		 jQuery(".marker").mouseover(function() {
		 
			
			jQuery("img", this).attr('src',newmarkersrc) ;
			
	
			
		  });
		  
		  
		   jQuery(".marker").mouseleave(function() {
			   
			
			if(jQuery(this).attr('id') != currentsel) {
			jQuery("img", this).attr('src', oldmarkersrc);
			
			}
	
			
		  });

			
			
			
			
			






  });