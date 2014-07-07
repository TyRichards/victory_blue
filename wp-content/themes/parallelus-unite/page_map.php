<?php
/*
Template Name: Map Page
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
			<div class="contentArea">

				<!-- Title / Page Headline -->
				<div class="full-page">
					<h1 class="headline"><strong><?php the_title(); ?></strong><?php echo $subTitle; ?></h1>
                    
                    
                    <div class="hr"></div>
				</div>
			
				
	<div style="background:#00FF00;" id="distributor_map">
     <!-- Start the Loop. -->
    
     
 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

   <?php the_content(); ?>

 <?php endwhile; else: ?>

 <!-- The very first "if" tested to see if there were any Posts to -->
 <!-- display.  This "else" part tells what do if there weren't any. -->
 <p>Sorry, no posts matched your criteria.</p>

 <!-- REALLY stop The Loop. -->
 <?php endif; ?>

    
    </div>
			
				
		
            
				<div class="full-page" style="height:600px;">
                
				<div id="map-container" style="margin-left:25px;">
				    <div id="details_holder">
                   <img src="/images/map/logo.png" />
                   <h1 id="facname">Factory Name</h1>
                   <div id="facaddr">123 Main Street<br />Somewhere, NA 98756</div>
                   <img src="/images/map/loc_visalia.jpg" id="detail_image" />
                   </div>
                <div id="map-holder">
                
                
                
                            <div style="z-index:20; position:absolute;" id="map_mover">
                            <img src="/images/map/usa_large.png" width="885" id="main_usa"/>
                            </div>
                            
                
                
                
               	 <div id="marker-holder" style="z-index:55;">
                
                
                         
                     
                          
                         
                          
                         
                           
                          
                          
                          
                          
                          
                         
                          
                          
                          
                          
                          
                          <div class="marker" id="fortworth" title="Forth Worth, TX"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="millington" title="Millington, TN"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="lima" title="Lima, OH"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="thomaston" title="Thomaston, GA"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="elpaso" title="El Paso, TX"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="chicago" title="Willow Springs, IL"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="neworleans" title="Waggaman, LA"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="denver" title="Denver, CO"><img src="/images/map/marker.png" width="43" height="57" /></div>
                           <div class="marker" id="visalia" title="Visalia, CA"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="losangeles" title="Los Angeles, CA"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="saltlakecity" title="Salt Lake City, UT"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="houston" title="Houston, TX"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="phoenix" title="Phoenix, AZ"><img src="/images/map/marker.png" width="43" height="57" /></div>
                  		 
                          <div class="marker" id="stockton" title="Stockton, CA"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="davenport" title="Davenport, FL"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="augusta" title="August, GA"><img src="/images/map/marker.png" width="43" height="57" /></div>
                          <div class="marker" id="imperial" title="Imperial, CA"><img src="/images/map/marker.png" width="43" height="57" /></div>
                  
               
                
                
                	</div>
                
                <div class="clear"></div>
                  
                  
                  
		
				</div>
				
                
               
                
		    <!-- End of Content -->
        
				<div class="clear"></div>
				
			</div>
             
            </div>
            
          <h4 style="text-align:center;">Ready to get started with Victory Blue? <a href="/?page_id=10">Order Online</a> or <a href="/?page_id=14">Contact Us</a></h4>
            
            </div>

		


<?php get_footer(); ?>