/*
/*	Dynamic design functions and onLoad events
/*	----------------------------------------------------------------------
/* 	Creates added dynamic functions and initializes loading.
*/


// ======================================================================
//
//	On document ready functions
//
// ======================================================================

jQuery(document).ready(function($) {
	
	
	// initialise main-menu (jQuery superfish plug-in)
	// -------------------------------------------------------------------
	
	if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 7) {
		// IE 6 has problem with supersubs plugin so we don't use it here...
		$j('ul.sf-menu').superfish({  		// initialize superfish
				delay:       400,			// one second delay on mouseout 
				animation: {				// fade-in and slide-down animation 
					height:	'show'
				},
				speed:		275
			});
	} else {
		// all other browsers, include supersubs plugin.
		$j('ul.sf-menu').supersubs({ 
	            minWidth:    12,	// minimum width of sub-menus in em units 
	            maxWidth:    27,	// maximum width of sub-menus in em units 
	            extraWidth:  0		// extra width for slight rounding differences in fonts 
	        }).superfish({  		// initialize superfish
	            delay:       400,	// one second delay on mouseout 
	            animation: {		// fade-in and slide-down animation 
					height:	'show'
				},
	            speed:		275
	        });
	}
	
		
	// initialize modal (fancybox)
	// -------------------------------------------------------------------
	
	// Quickly setup some special references
	// fancybox doesn't like #name references at the end of links so we find
	// them and modify the link to use a class and remove the #name.
	jQuery('a[href$="#popup"]').addClass('zoom iframe').each( function() {
		jQuery(this).attr('href', this.href.replace('#popup',''));
	});

	// setup fancybox for login modal
	jQuery('a[href$="#login"]').addClass('login').each( function() {
		theHref = jQuery(this).attr('href');
		if (theHref == '#login') {
			theHref = themePath + 'login.html';
		}
		jQuery(this).attr('href', theHref.replace('#login',''))
	});

	// setup fancybox for YouTube
	jQuery("a.zoom[href*='http://www.youtube.com/watch?']").each( function() {
		jQuery(this).addClass('fancyYouTube').removeClass('zoom').removeClass('iframe'); // might have iframe if using #popup
	});

	// setup fancybox for Vimeo
	jQuery("a.zoom[href*='http://www.vimeo.com/'], a.zoom[href*='http://vimeo.com/']").each( function() {
		jQuery(this).addClass('fancyVimeo').removeClass('zoom').removeClass('iframe'); // might have iframe if using #popup
	});
	

	var overlayColor = jQuery('#fancybox-overlay').css('background-color') || '#2c2c2c';
	
	// fancybox - default
	jQuery('a.zoom').fancybox({
		'padding': 12,
		'overlayOpacity': 0.2,
		'overlayColor': overlayColor, 
		'onComplete': modalStart
	});
	
	// initialize login modal (fancybox)
	jQuery('a.login').fancybox({
		'padding': 12, 
		'overlayOpacity': 0.2,
		'overlayColor': overlayColor, 
		'showCloseButton': false,
		'frameWidth': 400,
		'frameHeight': 208,
		'scrolling': 'no',
		'titleShow': false,
		'hideOnContentClick': false,
		'callbackOnShow': modalStart		
	});
	
	// fancybox - YouTube
	jQuery('a.fancyYouTube').click(function() {
		jQuery.fancybox({
			'padding': 12,
			'overlayOpacity': 0.2,
			'overlayColor': overlayColor, 
			'onComplete': modalStart,
			'title': this.title,
			'href': this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
			'type': 'swf',
			'swf': {
				'wmode': 'transparent',
				'allowfullscreen'	: 'true'} // <-- flashvars
		});
		return false;
	});

	// fancybox - Vimeo	
	jQuery("a.fancyVimeo").click(function() {
		jQuery.fancybox({
			'padding': 12,
			'overlayOpacity': 0.2,
			'overlayColor': overlayColor, 
			'onComplete': modalStart,
			'title': this.title,
			'href': this.href.replace(new RegExp("([0-9])","i"),'moogaloop.swf?clip_id=$1'),
			'type': 'swf'
		});
		return false;
	});
	
		

	// Slide down top content (topReveal) 
	// -------------------------------------------------------------------
	$j('.topReveal, a[href$="#topReveal"]').click( function() {
		$j('#ContentPanel').slideToggle(800,'easeOutQuart');	// show/hide the content area
		$j.scrollTo('#ContentPanel');
		return false;
	});
	

	// image hover effects	
	// -------------------------------------------------------------------
	$j("a.img").hover( function () {
		if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) <= 8) {
			$j(this).stop(false, true).toggleClass('imgHover');
		} else {
			$j(this).stop(false, true).toggleClass('imgHover', 200);
		}
	});
			
			
	// Text and password input styling
	// -------------------------------------------------------------------
	
	// This should be in the CSS file but IE 6 will ignore it.
	// If you have an input you don't want styles, add the class "noStyle"

	$j("input[type='text']:not(.noStyle), input[type='password']:not(.noStyle)").each(function(){
		$j(this).addClass('textInput');
	});
	
	
	// portfolio item height test (prevents long titles from causing gaps)
	// -------------------------------------------------------------------
	if ($('.portfolio-description').length > 0 ) {
		var pi = $('.portfolio-description');
		pi.each( function(i, val) {
			if (pi[i].scrollHeight > 120) {
				pi.css('height',pi[i].scrollHeight+'px');
				return false;
			}
		});
	}

						   
	// input lable replacement
	// -------------------------------------------------------------------
	$j("label.overlabel").overlabel();
	
	// apply custom search input functions
	// -------------------------------------------------------------------
	searchInputEffect();
		
	// apply custom button styles
	// -------------------------------------------------------------------
	buttonStyles();
	
	// CSS Rounded Corners (not for IE)
	// -------------------------------------------------------------------
	if (!jQuery.browser.msie) {
		$j("a.img, div.img, .pagination a, .textInput, input[type='text'], input[type='password'], textarea").addClass('rounded');	// items to add rounded class
		roundCorners(); // execute it!
	}
	
});




// ======================================================================
//
//	Design functions
//
// ======================================================================


// Search input - custom effects for mouse over and focus.
// -------------------------------------------------------------------

// Search input - custom effects for mouse over and focus.
// -------------------------------------------------------------------

function searchInputEffect() {

		searchFocus = false,
		searchHover = false,
		searchCtnr = $j('#Search'),
		searchInput = $j('#SearchInput'),
		searchSubmit = $j('#SearchSubmit');
	// Search input - mouse events
	if (searchCtnr.length > 0) {
		searchCtnr.hover(
			function () {	// mouseover
				if (!searchFocus) $j(this).addClass('searchHover');
				searchHover = true; }, 
			function () {	// mouseout
				if (!searchFocus) $j(this).removeClass('searchHover');
				searchHover = false;
		}).mousedown( function() {
			if (!searchFocus) $j(this).removeClass('searchHover').addClass('searchActive');
		}).mouseup( function() {
			searchInput.focus();
			searchSubmit.show();
			searchFocus = true;
		});
		// set focus/blur events
		searchInput.blur( function() {
			if (!searchHover) {
				searchCtnr.removeClass('searchActive');
				searchSubmit.hide();
				searchFocus = false;
			}
		});
	}
}



// button styling function
// -------------------------------------------------------------------

function buttonStyles() {
	// Button styles
	
	// This will style buttons to match the theme. If you don't want a button
	// styled, give it the class "noStyle" and it will be skipped.
	jQuery("button:not(:has(span),.noStyle), input[type='submit']:not(.noStyle), input[type='button']:not(.noStyle)").each(function(){
		var	b = jQuery(this),
			tt = b.html() || b.val();
		
		// convert submit inputs into buttons
		if (!b.html()) {
			b = (jQuery(this).attr('type') == 'submit') ? jQuery('<button type="submit">') : jQuery('<button>');
			b.insertAfter(this).addClass(this.className).attr('id',this.id);
			jQuery(this).remove();	// remove input
		}
		b.text('').addClass('btn').append(jQuery('<span>').html(tt));	// rebuilds the button
	});
	
	// Get all styled buttons
	var styledButtons = jQuery('.btn');

// Button hover class (IE 6 needs this)
	styledButtons.hover(
		function(){ jQuery(this).addClass('submitBtnHover'); },		// mouseover
		function(){ jQuery(this).removeClass('submitBtnHover'); }	// mouseout
	);
}


// Rounded corner styles
// -------------------------------------------------------------------

function roundCorners() {
	jQuery('.rounded, .ui-corner-all').css({
		'-moz-border-radius': '4px',
		'-webkit-border-radius': '4px',
		'border-radius': '4px'
	});
}
	

