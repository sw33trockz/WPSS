<?php if ( post_password_required() ) { return; } ?>

<?php if ( comments_open() || get_comments_number() ) : ?>

	<div id="comments" class="herald-comments">

		<?php
			ob_start();
			comments_number(__herald('no_comments'), __herald('one_comment'), __herald('multiple_comments'));
			$comments_title = ob_get_contents();
			ob_end_clean();

			$args = array(
					'title' => '<h4 class="h6 herald-mod-h herald-color">'.$comments_title.'</h4>',
					'actions' =>  get_comment_pages_count() > 1 && get_option( 'page_comments' ) ? paginate_comments_links( array('echo' => false)) : ''
			);

			echo herald_print_heading( $args ); 
		?>
			<div class="herald-gray-area"><span class="herald-fake-button herald-comment-form-open"><?php echo __herald('comment_button'); ?></span></div>
		
		<?php comment_form(array('title_reply' => '')); ?>

		<?php if ( have_comments() ) : ?>

			<ul class="comment-list">
			<?php $args = array(
				'avatar_size' => 60,
				'reply_text' => 'Reply'
			); ?>
				<?php wp_list_comments($args); ?>
			</ul>
		<?php endif; ?>

	</div>

<?php endif; ?>