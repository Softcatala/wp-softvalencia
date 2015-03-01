<?php get_header(); ?>

			<div id="content">
            	<div class="post-arch-info">
					<p>* You are viewing the Search Results for "<?php the_search_query(); ?>"</p>
	  			</div>
				<?php
					include(TEMPLATEPATH . "/wp-loop.php");
				?>

			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
            
			</div>

			<div id="sidebar">
				<?php
					get_sidebar();
				?>
			</div>

<?php get_footer(); ?>