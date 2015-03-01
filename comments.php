<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>

	<div id="comments">
		<?php botons_socials(); ?>
		<h2><?php comments_number('Cap comentari', 'Un comenari', '% comentaris' );?> en &#8220;<?php the_title(); ?>&#8221;</h2>
		<ol class="commentlist">
			<?php foreach ($comments as $comment) : ?>
			<li id="comment-<?php comment_ID() ?>">
            <?php echo get_avatar( $comment, 35 ); ?>
				<h3><?php comment_author_link() ?> diu:</h3>
				<small><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('d M, Y') ?> a les <?php comment_time() ?></a></small><br/><br/>
				<?php if ($comment->comment_approved == '0') : ?>
					<small><em>El comentari està esperant a ser moderat.</em></small>
				<?php endif; ?>
				<?php comment_text() ?>
			</li>
			<?php endforeach; /* end for each comment */ ?>
		</ol>
	</div>

	<hr />

<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

	<div id="respond">
		<h2>Comenteu</h2>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p>Heu d'estar <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">connectat</a> per escriure comentaris.</p>
		<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if ( $user_ID ) : ?>
				<p>Connectat com a <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Ix &raquo;</a></p>
			<?php else : ?>
				<p class="commentinput push">
					<label class="comments" for="author">Nom <?php if ($req) echo "(requerit)"; ?></label>
					<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
				</p>
				<p class="commentinput push">
					<label class="comments" for="email">Adreça electrònica (no es publicarà) <?php if ($req) echo "(requerit)"; ?></label>
					<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
				</p>
				<p class="commentinput">
					<label class="comments" for="url">Lloc web</label>
					<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
				</p>
			<?php endif; ?>
			
			<p class="commenttext">
				<label for="comment">Comentari</label>
				<textarea name="comment" id="comment" rows="10" cols="10" tabindex="4"></textarea>
			</p>
			<p>
				<button name="submit" type="submit" id="submit" tabindex="5">Envia</button>
				<button name="reset" type="reset" id="reset" tabindex="6">Reinicia</button>
				<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			</p>
		</form>
		<?php endif; ?>
	</div>

	<hr />

<?php endif; ?>
