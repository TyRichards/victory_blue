
// ======================================================================
//
//	On document ready functions
//
// ======================================================================

jQuery(document).ready(function($) {
	
	// Tooltip hover effect (jQuery clueTip)
	// -------------------------------------------------------------------
		$.fn.cluetip.defaults.cluetipClass	=	'skinned';		// added in the form of 'cluetip-' + clueTipClass
		$.fn.cluetip.defaults.cluezIndex	=	1234;			// z-index style property
		$.fn.cluetip.defaults.dropShadow	=	false;			// use drop shadow (off is best for image skinned tips)
		$.fn.cluetip.defaults.topOffset		=	35;				// px to offset clueTip from top
		$.fn.cluetip.defaults.clickThrough	=	true;			// if true, and activation is not 'click', clicking on a clueTipped link will follow link's href
		$.fn.cluetip.defaults.fx = {							// effect and speed for opening clueTips
			open:		'fadeIn', 	// can be 'show' or 'slideDown' or 'fadeIn'
			openSpeed:	'100'		// speed of effect
		};
		$.fn.cluetip.defaults.hoverIntent	= {					// settings for hoverIntent plugin	
			sensitivity:  3,		
			interval:     100,		// delay before showing tip
			timeout:      80		// delay hiding tip
		};
		$.fn.cluetip.defaults.onShow		=	function(ct, c){
			// on display fix spacing for title only tips
			if (jQuery('#cluetip-inner').html() == '') {
				// add helper class
				(jQuery.browser.msie) ? jQuery('#cluetip').addClass('ieFix') : jQuery('#cluetip').addClass('mozFix');				
			} else {
				// remove helper class
				(jQuery.browser.msie) ? jQuery('#cluetip').removeClass('ieFix') : jQuery('#cluetip').removeClass('mozFix');	
			}
		};
	
});