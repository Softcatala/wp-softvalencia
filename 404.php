<?php get_header(); ?>

			<div id="content">
				<div class="post">
					<h2>No s'ha trobat la pàgina</h2><br />
					<p>Sembla que la pàgina que estaves buscant no existeix:<br /><br />
					<div style="font-weight:bold;text-align:center;width:100%"><pre><?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?></pre></div></p><br />
					<?php dynamic_sidebar( '404' ); ?>
				</div>
			</div>

			<div id="sidebar">
				<?php
					get_sidebar();
				?>
			</div>

<?php get_footer(); ?>

		
