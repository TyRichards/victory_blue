<?php
#==================================================================
#
#	Widgets
#
#==================================================================


#-----------------------------------------------------------------
# Sub-Page Navigation
#-----------------------------------------------------------------

// Sub-Page Nav Class
//................................................................

class theme_subNav_widget extends WP_Widget {

    function theme_subNav_widget() {
		global $themeTitle;
		
        $options = array('classname' => 'subNav_widget', 'description' => __( "Displays a sub-pages menu") );
		$controls = array('width' => 250, 'height' => 200);
		
		$this->WP_Widget('subnav', __($themeTitle.' - Sub Navigation'), $options, $controls);
    }

    function widget($args, $instance) {
		global $post, $page_exclusions;
		
        extract( $args );
		
		// get parent id
		$testChildren = get_pages('child_of='.$post->ID);
		$parent = ( count( $testChildren ) > 0 ) ? $post->ID : $post->post_parent;
		
		$title = apply_filters('widget_title', empty($instance['title']) ? get_the_title($parent) : $instance['title'], $instance, $this->id_base);
				
		// Sub-Title
		if ( !empty($instance['subtitle']) ) {  
			$subtitle = '<span>'. stripslashes($instance['subtitle']) .'</span>';
		}

		if ( is_search() || is_404() || is_archive() || is_single() ){ return; }	

		$children = wp_list_pages("sort_column=menu_order&exclude=$page_exclusions&title_li=&child_of=".$parent."&echo=0&depth=1");
		
      	echo $before_widget; 
        echo $before_title . $title . $subtitle . $after_title;

		echo '<div class="sideNavWrapper"><div class="sideNavBox-1"><div class="sideNavBox-2">';
		echo '<ul class="sideNav">';
		echo $children;
		echo '</ul>';
		echo '</div></div></div>';
	
 		echo $after_widget;

		}

    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);
        return $instance;
    }

    function form($instance) {				
        $title = esc_attr($instance['title']);
		$subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : '';
        ?>
        <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub-Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>" />
		</p>
        <?php 
    }

}


#-----------------------------------------------------------------
# Popular Post Widget
#-----------------------------------------------------------------

// Popular Post Class
//................................................................
class theme_popularPost_widget extends WP_Widget {

    function theme_popularPost_widget() {
		global $themeTitle;
		
		$options = array('classname' => 'popular-widget', 'description' => __( "Theme styled popular posts with optional preview image.") );
		$controls = array('width' => 250, 'height' => 200);
		
		$this->WP_Widget('popularwidget', __($themeTitle.' - Popular Post'), $options, $controls);
    }

    function widget($args, $instance) {
		global $wpdb;
		
        extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Popular Posts') : $instance['title'], $instance, $this->id_base);
		
		// Sub-Title
		if ( !empty($instance['subtitle']) ) {  
			$subtitle = '<span>'. stripslashes($instance['subtitle']) .'</span>';
		}

		// number of posts to show
		if ( !$number = (int) $instance['number'] ) {
			$number = 3;	// default
		}else if ( $number < 1 ) {
			$number = 1;	// minimum
		}else if ( $number > 15 ) {	
			$number = 15;	// maximum
		}
			
		// length of content description
		if ( !$excerpt = (int) $instance['excerpt'] ) {
			$excerpt = 12;	// default
		}else if ( $excerpt < 0 ) {
			$excerpt = 0;	// minimum
		}else if ( $excerpt > 55 ) {
			$excerpt = 55;	// maximum
		}
			
		$disable_thumb = $instance['disable_thumb'] ? '1' : '0';
		$pop_posts =  $number;
		
		// look up popular posts
		$now = gmdate("Y-m-d H:i:s",time());
		$lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
		$popularposts = "SELECT ID, post_title, post_content, post_date, COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT ".$pop_posts;
		$posts = $wpdb->get_results($popularposts);
		$popular = '';

		// title
		echo $before_widget;
		echo $before_title . $title . $subtitle . $after_title;

		// posts
		if($posts){ ?>
		<ul class="post-list">
			<?php 
			foreach($posts as $post){
				setup_postdata($post);
				$post_title = stripslashes($post->post_title);
				$permalink = get_permalink($post->ID);
				$post_image = showImage(64, 64, $post_title, 'small', $post);
				?>
			<li>
				<?php if (!$disable_thumb) { ?>
					<a href="<?php echo $permalink; ?>" title="<?php echo $post_title; ?>" class="post-listImage"><?php echo $post_image['full']; ?></a>
				<?php } ?>
				<a href="<?php echo $permalink; ?>" title="<?php echo $post_title; ?>" class="post-listTitle"><?php echo $post_title; ?></a>
				<p><?php echo customExcerpt(get_the_content(), $excerpt); ?></p>
				<div class="clear"></div>
			</li>
				<?php 
			} // end foreach ?>
		</ul>
			<?php 
		} // end IF ($posts)
			
		echo $after_widget;
    }

    function update($new_instance, $old_instance) {				
        $instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['excerpt'] = (int) $new_instance['excerpt'];
		$instance['disable_thumb'] = !empty($new_instance['disable_thumb']) ? 1 : 0;
				
        return $instance;
    }

    function form($instance) {				
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : '';
		$disable_thumb = isset( $instance['disable_thumb'] ) ? (bool) $instance['disable_thumb'] : false;
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] ) {
			$number = 3;	// set default
		}
		if ( !isset($instance['excerpt']) || !$excerpt = (int) $instance['excerpt'] ) {
			$excerpt = 12;	// set default
		}
        ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub-Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of popular posts to display:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('excerpt'); ?>">Length of post excerpt:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="text" value="<?php echo $excerpt; ?>" />
			<small>(0 for no excerpt)</small>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('disable_thumb'); ?>" name="<?php echo $this->get_field_name('disable_thumb'); ?>"<?php checked( $disable_thumb ); ?> />
			<label for="<?php echo $this->get_field_id('disable_thumb'); ?>"><?php _e( 'Hide Thumbnail?' ); ?></label>
		</p>

        <?php 
    }

}


#-----------------------------------------------------------------
# Recent Post Widget
#-----------------------------------------------------------------

// Recent Post Class
//................................................................
class theme_recentPost_widget extends WP_Widget {

    function theme_recentPost_widget() {
		global $themeTitle;
		$options = array('classname' => 'recentPosts-widget', 'description' => __( "Theme styled recent posts with optional preview image.") );
		$controls = array('width' => 250, 'height' => 200);
		$this->WP_Widget('recentposts', __($themeTitle.' - Recent Post'), $options, $controls);
    }

    function widget($args, $instance) {
		global $wpdb, $shortname;
        extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
		
		// Sub-Title
		if ( !empty($instance['subtitle']) ) {  
			$subtitle = '<span>'. stripslashes($instance['subtitle']) .'</span>';
		}

		// number of posts to show
		if ( !$number = (int) $instance['number'] ) {
			$number = 3;	// default
		}else if ( $number < 1 ) {
			$number = 1;	// minimum
		}else if ( $number > 15 ) {	
			$number = 15;	// maximum
		}
			
		// length of content description
		if ( !$excerpt = (int) $instance['excerpt'] ) {
			$excerpt = 12;	// default
		}else if ( $excerpt < 0 ) {
			$excerpt = 0;	// minimum
		}else if ( $excerpt > 55 ) {
			$excerpt = 55;	// maximum
		}
			
		$disable_thumb = $instance['disable_thumb'] ? '1' : '0';
		
		// setup post query
		$posts = get_posts("numberposts=$number&offset=0");

		echo $before_widget;
		echo $before_title . $title . $subtitle . $after_title;

		if($posts){ ?>
		<ul class="post-list">
			<?php 
			foreach($posts as $post){
				setup_postdata($post);
				$post_title = stripslashes($post->post_title);
				$permalink = get_permalink($post->ID);
				$post_image = showImage(64, 64, $post_title, 'small', $post);
				?>
			<li>
				<?php if (!$disable_thumb) { ?>
					<a href="<?php echo $permalink; ?>" title="<?php echo $post_title; ?>" class="post-listImage"><?php echo $post_image['full']; ?></a>
				<?php } ?>
				<a href="<?php echo $permalink; ?>" title="<?php echo $post_title; ?>" class="post-listTitle"><?php echo $post_title; ?></a>
				<p><?php echo customExcerpt(get_the_content(), $excerpt); ?></p>
				<div class="clear"></div>
			</li>
				<?php 
			} // end foreach ?>
		</ul>
			<?php 
		} // end IF ($posts)
			
		echo $after_widget;
    }

    function update($new_instance, $old_instance) {				
        $instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['excerpt'] = (int) $new_instance['excerpt'];
		$instance['disable_thumb'] = !empty($new_instance['disable_thumb']) ? 1 : 0;
				
        return $instance;
    }

    function form($instance) {				
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : '';
		$disable_thumb = isset( $instance['disable_thumb'] ) ? (bool) $instance['disable_thumb'] : false;
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] ) {
			$number = 3;	// set default
		}
		if ( !isset($instance['excerpt']) || !$excerpt = (int) $instance['excerpt'] ) {
			$excerpt = 12;	// set default
		}
        ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub-Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of recent posts to display:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('excerpt'); ?>">Length of post excerpt:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="text" value="<?php echo $excerpt; ?>" />
			<small>(0 for no excerpt)</small>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('disable_thumb'); ?>" name="<?php echo $this->get_field_name('disable_thumb'); ?>"<?php checked( $disable_thumb ); ?> />
			<label for="<?php echo $this->get_field_id('disable_thumb'); ?>"><?php _e( 'Hide Thumbnail?' ); ?></label>
		</p>

        <?php 
    }

}


#-----------------------------------------------------------------
# Categories Widget
#-----------------------------------------------------------------

// Categories Class
//................................................................
class theme_categories_widget extends WP_Widget {

    function theme_categories_widget() {
		global $themeTitle;
		$options = array('classname' => 'categories-widget', 'description' => __( "Theme styled categories list.") );
		$controls = array('width' => 250, 'height' => 200);
		$this->WP_Widget('theme_categories', __($themeTitle.' - Categories'), $options, $controls);
    }

    function widget($args, $instance) {
		global $wpdb, $shortname;
        extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Categories') : $instance['title'], $instance, $this->id_base);

		// Sub-Title
		if ( !empty($instance['subtitle']) ) {  
			$subtitle = '<span>'. stripslashes($instance['subtitle']) .'</span>';
		}

		// Excluded categories
		$exclude = '';
		if ( !empty($instance['exclude']) ) {
			$exclude = '&exclude='. $instance['exclude'];
		}
		
		echo $before_widget;
		//echo $before_title . $title . $after_title;
		?>
	
		<!-- Category Menu -->
		<h1 class="title" style="margin-bottom:0;">
			<?php echo $title . $subtitle ?>
		</h1>
		<div class="sideNavWrapper">
			<div class="sideNavBox-1">
				<div class="sideNavBox-2">
					<ul class="sideNav">
						<?php wp_list_categories('orderby=name&show_count=0&title_li='.$exclude); ?>
					</ul>
				</div>
			</div>
		</div>
		<?php 
			
		echo $after_widget;
    }

    function update($new_instance, $old_instance) {				
        $instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);
		$instance['exclude'] = strip_tags($new_instance['exclude']);
        return $instance;
    }

    function form($instance) {				
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : '';
		$exclude = isset($instance['exclude']) ? esc_attr($instance['exclude']) : '';
        ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub-Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e('Exclude:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" type="text" value="<?php echo $exclude; ?>" />
			<small>Category IDs, separated by commas.</small>
		</p>

        <?php 
    }

}


#-----------------------------------------------------------------
# Archives Widget
#-----------------------------------------------------------------

// Archives Class
//................................................................
class theme_archives_widget extends WP_Widget {

    function theme_archives_widget() {
		global $themeTitle;
		$options = array('classname' => 'archives-widget', 'description' => __( "Theme styled archives list.") );
		$controls = array('width' => 250, 'height' => 200);
		$this->WP_Widget('theme_archives', __($themeTitle.' - Archives'), $options, $controls);
    }

    function widget($args, $instance) {
		global $wpdb, $shortname;
        extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Archives') : $instance['title'], $instance, $this->id_base);

		// Sub-Title
		if ( !empty($instance['subtitle']) ) {  
			$subtitle = '<span>'. stripslashes($instance['subtitle']) .'</span>';
		}

		echo $before_widget;
		//echo $before_title . $title . $after_title;
		?>
	
		<!-- Category Menu -->
		<h1 class="title" style="margin-bottom:0;">
			<?php echo $title . $subtitle; ?>
		</h1>
		<div class="sideNavWrapper">
			<div class="sideNavBox-1">
				<div class="sideNavBox-2">
					<ul class="sideNav">
						<?php wp_get_archives('type=monthly'); ?>
					</ul>
				</div>
			</div>
		</div>
		<?php 
			
		echo $after_widget;
    }

    function update($new_instance, $old_instance) {				
        $instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);
        return $instance;
    }

    function form($instance) {				
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : '';
		$exclude = isset($instance['exclude']) ? esc_attr($instance['exclude']) : '';
        ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub-Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>" />
		</p>

        <?php 
    }

}


#-----------------------------------------------------------------
# Quote Widget
#-----------------------------------------------------------------

// Quote Class
//................................................................
class theme_quote_widget extends WP_Widget {

    function theme_quote_widget() {
		global $themeTitle;
		$options = array('classname' => 'quote-widget', 'description' => __( "Theme styled quote or testimonial.") );
		$controls = array('width' => 250, 'height' => 200);
		$this->WP_Widget('quote', __($themeTitle.' - Quote'), $options, $controls);
    }

    function widget($args, $instance) {
		global $wpdb, $shortname;
        extract( $args );

		$quote = stripslashes($instance['quote']);
		$author = stripslashes($instance['author']);
		$details = stripslashes($instance['details']);

		
		echo $before_widget;

		?>
		<!-- Testimonial/Quote -->
		<div class="quote">
			<div class="quoteBox-1">
				<div class="quoteBox-2">
					<p><?php echo $quote; ?></p>
				</div>
			</div>
		</div>
		<div class="quoteAuthor">
			<p class="name"><?php echo $author; ?></p>
			<p class="details"><?php echo $details; ?></p>
		</div>
		
		<div class="hr"></div>
		<?php 
			
		echo $after_widget;
    }

    function update($new_instance, $old_instance) {				
        $instance = $old_instance;
		$instance['quote'] = strip_tags($new_instance['quote']);
		$instance['author'] = strip_tags($new_instance['author']);
		$instance['details'] = strip_tags($new_instance['details']);
        return $instance;
    }

    function form($instance) {				
		$quote = isset($instance['quote']) ? esc_attr($instance['quote']) : '';
		$author = isset($instance['author']) ? esc_attr($instance['author']) : '';
		$details = isset($instance['details']) ? esc_attr($instance['details']) : '';
        ?>

		<p>
			<label for="<?php echo $this->get_field_id('quote'); ?>"><?php _e('Quote Text:'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('quote'); ?>" name="<?php echo $this->get_field_name('quote'); ?>"><?php echo $quote; ?></textarea>
			<small>Enter the text being quoted.</small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('author'); ?>"><?php _e('Author Name:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('author'); ?>" name="<?php echo $this->get_field_name('author'); ?>" type="text" value="<?php echo $author; ?>" />
			<small>The name of the person being quoted.</small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('details'); ?>"><?php _e('Author Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('details'); ?>" name="<?php echo $this->get_field_name('details'); ?>" type="text" value="<?php echo $details; ?>" />
			<small>The title, company or other details associated with the person being quoted.</small>
		</p>

        <?php 
    }

}


#-----------------------------------------------------------------
# Flickr Widget
#-----------------------------------------------------------------

// Flickr Class
//................................................................
class theme_flickr_widget extends WP_Widget {

    function theme_flickr_widget() {
		global $themeTitle;
		$options = array('classname' => 'theme_flickr_widget', 'description' => __( "Show images from a Flickr account.") );
		$controls = array('width' => 400, 'height' => 200);
		$this->WP_Widget('flickr', __($themeTitle.' - Flickr'), $options, $controls);
    }

    function widget($args, $instance) {	
        extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Photos on flickr') : $instance['title'], $instance, $this->id_base);
		$id = $instance['id'];
		
		// Sub-Title
		if ( !empty($instance['subtitle']) ) {  
			$subtitle = '<span>'. stripslashes($instance['subtitle']) .'</span>';
		}

		if ( !$number = (int) $instance['number'] ) {
			$number = 3;
		}else if ( $number < 1 ) {
			$number = 1;
		}else if ( $number > 15 ) {
			$number = 15;
		}

		$hr = $instance['hr'] ? '1' : '0';

        ?>

			<?php echo $before_widget; ?>
				<?php echo $before_title . $title . $subtitle . $after_title; ?>
				<div class="flickrFeed">
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script> 
					<div class="clear"></div>
				</div>
				<?php if ( $hr ) : ?><div class="hr"></div><?php endif; ?>

			<?php echo $after_widget; ?>

        <?php
    }

    function update($new_instance, $old_instance) {				
        $instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['hr'] = !empty($new_instance['hr']) ? 1 : 0;

		return $instance;
    }

    function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : '';
		$id = isset($instance['id']) ? esc_attr($instance['id']) : '';
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] ) {
			$number = 3;
		}
 		$hr = isset( $instance['hr'] ) ? (bool) $instance['hr'] : false;
       ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub-Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('id'); ?>">Flickr ID (<a href="http://www.idgettr.com" target="_blank">idGettr</a>):</label>
			<input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of photos:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hr'); ?>" name="<?php echo $this->get_field_name('hr'); ?>"<?php checked( $hr ); ?> />
			<label for="<?php echo $this->get_field_id('hr'); ?>"><?php _e( 'Show border at bottom?' ); ?></label>
		</p>
        <?php 
    }

}


#-----------------------------------------------------------------
# Twitter Widget
#-----------------------------------------------------------------

// Twitter Class
//................................................................
class theme_twitter_widget extends WP_Widget {

    function theme_twitter_widget() {
		global $themeTitle;
		$options = array('classname' => 'theme_twitter_widget', 'description' => __( "Show recent tweets from a Twitter account.") );
		$controls = array('width' => 250, 'height' => 200);
		$this->WP_Widget('twitter', __($themeTitle.' - Twitter'), $options, $controls);
    }

    function widget($args, $instance) {
		global $shortname;
        extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Tweets') : $instance['title'], $instance, $this->id_base);
		$id = $instance['id'];
		
		// Sub-Title
		if ( !empty($instance['subtitle']) ) {  
			$subtitle = '<span>'. stripslashes($instance['subtitle']) .'</span>';
		}

		if ( !$number = (int) $instance['number'] )
			$number = 5;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;
		
		$limit = $number;
		$type = 'widget';
        ?>

			<?php echo $before_widget; ?>
				<?php echo $before_title . $title . $subtitle . $after_title; ?>
						<ul class="twitterFeed">
							<?php echo parse_cache_twitter_feed($id, $limit, $type); ?>
						</ul>
			<?php echo $after_widget; ?>

        <?php
    }

    function update($new_instance, $old_instance) {	
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['number'] = (int) $new_instance['number'];
				
        return $instance;
	
				
    }

    function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : '';
		$id = isset($instance['id']) ? esc_attr($instance['id']) : '';
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 5;
        ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub-Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('id'); ?>">Twitter username:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of tweets to display:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>

        <?php 
    }

}



#-----------------------------------------------------------------
# Add Widget Classes to the System
#-----------------------------------------------------------------

add_action('widgets_init', create_function('', 'return register_widget("theme_subNav_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("theme_flickr_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("theme_twitter_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("theme_popularPost_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("theme_recentPost_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("theme_quote_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("theme_categories_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("theme_archives_widget");'));

?>