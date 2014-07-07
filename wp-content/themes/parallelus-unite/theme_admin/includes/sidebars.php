<?php
#==================================================================
#
#	Sidebars and metaboxes for the theme
#
#==================================================================


#-----------------------------------------------------------------
# Sidebars (widget areas)
#-----------------------------------------------------------------


// Pre-configured sidebars
//................................................................

function theme_sidebars_load() {

	register_sidebar(array(
		'name'=> 'Default Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="title">',
		'after_title' => '</h1>'
	));

	register_sidebar( array(
		'name' => 'Homepage Sidebar',
		'description' => 'Homepage sidebar area',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="title">',
		'after_title' => '</h1>',
	) );

	register_sidebar(array(
		'name'=> 'Slide Open Top',
		'id' => 'slide_top',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="title">',
		'after_title' => '</h1>'
	));
	
	register_sidebar(array(
		'name'=> 'Header',
		'id' => 'header_top',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="title">',
		'after_title' => '</h1>'
	));
	
	register_sidebar(array(
		'name'=> 'Footer Left',
		'id' => 'footer_1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	
	register_sidebar(array(
		'name'=> 'Footer Middle',
		'id' => 'footer_2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	
	register_sidebar(array(
		'name'=> 'Footer Right',
		'id' => 'footer_3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	
	register_sidebar(array(
		'name'=> 'Footer Extra',
		'id' => 'footer_4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	
	// Create Showcase Widget Areas	
	//................................................................
	if (get_theme_var('showcaseColumns') !== '' && get_theme_var('showcaseColumns') !== 'off') {
		parse_str(get_theme_var('showcaseColumns', 'showcase_left=true&showcase_right=true'), $widgetArea);
		
		if ($widgetArea['showcase_left'] == true) {
			register_sidebar(array(
				'name'=> 'Home - Showcase Left',
				'id' => 'showcase_left',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h1 class="title">',
				'after_title' => '</h1>'
			));
		}
		if ($widgetArea['showcase_middle'] == true) {
			register_sidebar(array(
				'name'=> 'Home - Showcase Middle',
				'id' => 'showcase_middle',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h1 class="title">',
				'after_title' => '</h1>'
			));	
		}
		if ($widgetArea['showcase_right'] == true) {
			register_sidebar(array(
				'name'=> 'Home - Showcase Right',
				'id' => 'showcase_right',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h1 class="title">',
				'after_title' => '</h1>'
			));	
		}
	}	


}

// Register pre-configured sidebars using widgets_init
//................................................................
add_action( 'widgets_init', 'theme_sidebars_load' );


// Dynamic sidebar generation
//................................................................

include_once('sidebar-generator.php');


?>