<?php
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Sorry, you can\'t load this page directly.');

if ( post_password_required() ) { 
	echo '<p class="nocomments">This post is password protected. Enter your password to view comments.</p>';
	return;
}

function mytheme_comment($comment, $args, $depth) {
	global $themePath;
	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<?php echo get_avatar($comment,$size='60',$default=$themePath.'images/icons/gravatar1.png' ); ?>
			<div class="comment-text">
				<cite><?php comment_author_link() ?></cite><span class="date"><?php comment_date('m-d-y'); ?></span>
				<?php if ($comment->comment_approved == '0') : ?>
					<span class="awaiting_moderation"><?php _e('Your comment is awaiting moderation.') ?></span><br />
				<?php endif; ?>
				<?php comment_text() ?>
				<div class="comment-meta commentmetadata">
					<?php comment_reply_link(array_merge( $args, array('reply_text' => 'Reply', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>  <?php edit_comment_link(__('Edit'),' ','') ?> 
				</div>
			</div>
		</div>
	<?php 
}

function list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<cite><?php comment_author_link(); ?></cite><span class="date"><?php comment_date('m-d-y'); ?></span><br />

	<?php 
} 

if  ( have_comments() ) : ?>

	<!-- start commenting area -->
	<?php 
	if ( ! empty($comments_by_type['comment']) ) : ?>
		<ol class="commentlist">
			<?php wp_list_comments('callback=mytheme_comment&type=comment'); ?>
		</ol>
			
		<div class="comms-navigation">
			<div style="float:left"><?php previous_comments_link() ?></div>
			<div style="float:right"><?php next_comments_link() ?></div>
		</div>
		<?php 
	endif;
	
endif;


// Comment Form
if ('open' == $post->comment_status) : ?>
	
	<div id="Respond">
		<a name="respond"></a>
		<h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>
		<div class="cancel-comment-reply">
			<?php cancel_comment_reply_link(); ?>
		</div>
		<?php 
		if ( get_option('comment_registration') && !$user_ID ) : ?>
			<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
			<?php else : ?>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="CommentForm">
				<?php 
				if ( $user_ID ) : ?>
					<p class="logged">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
					<?php 
				else : 
					?>
					<p>
						<label  class="overlabel" for="author">Name *</label>
						<input type="text" class="textInput" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" style="width: 350px;" />
					</p>
					<p>
						<label class="overlabel" for="email">Email *</label>
						<input type="text" class="textInput" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" style="width: 350px;" />
					</p>
					<p>
						<label  class="overlabel" for="url">Website</label>
						<input type="text" class="textInput" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" style="width: 350px;" />
					</p>
					<?php 
				endif; ?>
				<p>
					<label  class="overlabel" for="comment">Comment</label>
					<textarea class="textInput" name="comment" id="comment" cols="50" rows="12" tabindex="4" style="width: 450px;"></textarea>
				</p>
				<p><button type="submit" class="btn" value="Submit Comment"><span>Add Comment</span></button><?php comment_id_fields(); ?></p>
				<p><?php do_action('comment_form', $post->ID); ?></p>
			</form>	
			<?php 
		endif; // If registration required and not logged in ?>
	</div><!-- End id=Respond -->
	<?php 
	
endif;	// if ('open' == $post->comment_status) : ?>



<?php //trackbacks
if ( have_comments() ) :
	if ( ! empty($comments_by_type['pings']) ) : ?>
		<ol class="commentlist">
			<?php wp_list_comments('callback=list_pings&type=pings'); ?>
		</ol>
	
		<div class="comms-navigation">
			<div style="float:left"><?php previous_comments_link() ?></div>
			<div style="float:right"><?php next_comments_link() ?></div>
		</div>
<?php endif; ?>

<!-- end comments area -->

<?php
endif; ?>