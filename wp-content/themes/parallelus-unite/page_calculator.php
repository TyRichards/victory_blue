<?php
/*
Template Name: Calculator Page
*/
?>
<?php get_header(); 

			// breadcrumbs
			$hideBreadcrumbs = false;
			if ( get_post_meta($post->ID, 'breadcrumbOff', true) ) {
				$hideBreadcrumbs = true;
			} elseif ( $GLOBALS['globalBreadcrumbsOff'] ) {
				$hideBreadcrumbs = true;
			}

			// sub-title
			$subTitle = get_post_meta($post->ID, 'subTitle', true); // from page options
			if ( $subTitle != '' ) {
				$subTitle = ' &nbsp;//&nbsp; ' . $subTitle;	// setup subtitle formatting
			}

			?>

			<!-- Full Page Content -->
			<div class="contentArea pageContent">

				<!-- Title / Page Headline -->
				<div class="full-page">
					<h1 class="headline"><strong><?php the_title(); ?></strong><?php echo $subTitle; ?></h1>
                    
                    
                    <div class="hr"></div>
			
			
				
	
			
				<div id="calc_holder" style="background:url(/images/map/background.jpg) repeat-x top right; width:900px; padding:10px; margin-left:10px;" >
		
            
				<h3 style="margin-top:15px;">Enter all required information to calculate.</h3>
				  <form action="#" method="get" name="calcform" id="calcform" >
                    
                  <div style="height:71px; z-index:100l position:absolute; ">
                       
                       <div class="calc_buttons" style="z-index:9;">
                       
                      Number of <br />
Vehicles<br /> 

<input name="num_vehicles" id="num_vehicles" type="text" />
                       
                       </div>
                           
                       <div class="calc_buttons pos"  style="z-index:8;">
                               
                       Annual Mileage <br />
Per Vehicle<br />
<input name="num_mileagepervehicle" id="num_mileagepervehicle" type="text" />
                       </div>
                      
                        <div class="calc_buttons pos"  style="z-index:7;">
                        
                                   
                       Average Miles <br />
Per Gallon<br />
<input name="num_mileagepergallon" id="num_mileagepergallon" type="text" />
                        
                       </div>
                        <div class="calc_buttons pos"  style="z-index:6;">
                                 
                                 
                                   Size of DEF <br />
Tank (GAL)<br />
<input name="num_sizeofdef" id="num_sizeofdef" type="text" />
                           
                                 
                       </div>
                        <div class="calc_buttons pos"  style="z-index:5;">
                           
                           
                             %  DEF Usage of<br />
Fuel Consumption<br />
                   
                       <select name="num_defusagepercent" id="num_defusagepercent">
                         <option value="" selected="selected">-</option>
                         <option value=".02">2%</option>
                         <option value=".03">3%</option>
                         <option value=".04">4%</option>
                       </select>
                      </div>
                        <a class="calc_go pos_go" id="calc_go_button"  style="z-index:4;" >
                           
                       </a>
                    
                    </div>
                  </form> 
				   <h3 style="margin-top:15px;">Caclulator Results</h3>
                
                
                  <table width="100%" border="0" cellpadding="0" cellspacing="10" >
  <tr>
    <td width="33%" class="optionstext">  <img src="/images/icon_fuel.jpg" width="35" height="35" />
                  <div>Diesel Fuel per Year</div> </td>
    <td width="34%" class="optionstext">   <img src="/images/icon_def.jpg" width="35" height="35" />   
                  <div>DEF Per Year</div></td>
    <td width="33%" class="optionstext"> <img src="/images/icon_truck.jpg" width="35" height="35" />
                  <div>DEF per Truck/Year</div></td>
  </tr>
  <tr>
    <td width="33%"><div id="dfpy" class="calc_results">&nbsp;</div></td>
    <td width="34%"><div id="defpy" class="calc_results">&nbsp;</div></td>
    <td width="33%"><div id="deftruck" class="calc_results">&nbsp;</div></td>
  </tr>
</table>

                  
                  
                 
                  
               
                  
                 
                 
                  <h3 style="margin-top:15px;">Ordering Options</h3>
                  
                    
                  <div style="height:200px;">
                  
                  <div class="prod_calc_display size1off">
                    <div id="prod1" class="numfloat numoff"><span>&nbsp;</span></div>
                    <span id="buy1" class="buyshow" style="display:none;"><a href="/?page_id=10">Order</a></span>
                  </div>
                  
                    <div class="prod_calc_display size2off">
                    <div id="prod2" class="numfloat numoff"><span>&nbsp;</span></div>
                        <span id="buy2" class="buyshow" style="display:none;"><a href="/?page_id=10">Order</a></span>
                        </div>
                    
                     <div class="prod_calc_display size3off">
                    <div id="prod3" class="numfloat numoff"><span>&nbsp;</span></div>
                        <span id="buy3" class="buyshow" style="display:none;"><a href="/?page_id=10">Order</a></span>
                        </div>
                    
                       <div class="prod_calc_display size4off">
                    <div id="prod4" class="numfloat numoff"><span>&nbsp;</span></div>
                        <span id="buy4" class="buyshow" style="display:none;"><a href="/?page_id=10">Order</a></span>
                        </div>
                        
                          <div class="prod_calc_display size45off">
                    <div id="prod45" class="numfloat numoff"><span>&nbsp;</span></div>
                        <span id="buy45" class="buyshow" style="display:none;"><a href="/?page_id=10">Order</a></span>
                        </div>
                     
                      
                        <div class="prod_calc_display size5off">
                    <div id="prod5" class="numfloat numoff"><span>&nbsp;</span></div>
                        <span id="buy5" class="buyshow" style="display:none;"><a href="/?page_id=10">Order</a></span>
                        </div>
                      
                      
                         <div class="prod_calc_display size6off no-right">
                    <div id="prod6" class="numfloat numoff"><span>&nbsp;</span></div>
                        <span id="buy6" class="buyshow" style="display:none;"><a href="/?page_id=10">Order</a></span>
                        </div>
                                     
                  </div>
                  
                  <div class="clear"></div>
                  
                  
                  
                  </div>
                  <!-- End of Holder -->
                  
                  
		
				</div>
				
                
               
                
		    <!-- End of Content -->
        
				<div class="clear"></div>
				
			</div>
            
         

		


<?php get_footer(); ?>