<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

			<div id="content">
				<?php
					include(TEMPLATEPATH . "/wp-loop.php");
				?>

			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
            
			</div>

			<div id="sidebar">
				<?php get_sidebar(); ?>
			</div>

<?php get_footer(); ?>
