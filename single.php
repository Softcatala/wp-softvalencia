<?php get_header(); ?>

			<div id="content">
				<?php
					include(TEMPLATEPATH . "/wp-loop.php");
				?>
				<?php comments_template(); ?>

				<div class="navigation">
					<div class="alignleft"><?php next_post_link('%link', '&laquo; %title'); ?></div>
					<div class="alignright"><?php previous_post_link('%link', '%title &raquo;'); ?></div>
				</div>
			</div>

			<div id="sidebar">
				<?php
					get_sidebar();
				?>
			</div>

<?php get_footer(); ?>
