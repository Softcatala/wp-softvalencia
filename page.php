<?php get_header(); 

		global $post;
                if(isset($post)) {
			$sensesidebar = get_post_meta($post->ID, 'sensesidebar',true);
		}
?>

			<div id="content" <?php
				if(isset($sensesidebar) && $sensesidebar) {
					echo ' class="sensesidebar" ';
				}
			?> >
				<?php
					include(TEMPLATEPATH . "/wp-loop.php");
				?>

			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
            
			</div>

			<?php

				

				if(!(isset($sensesidebar) && $sensesidebar)) {
			?>
			<div id="sidebar">
				<?php
					get_sidebar();
				?>
			</div>
			<?php } ?>
<?php get_footer(); ?>
