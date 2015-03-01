<?php

//Si estem a la portada, només mostrem els articles d'actualitat

global $wp_query;

if ( is_home() ) {

$args = array_merge( $wp_query->query_vars, array( 'cat' => '20' ) );


} else {

$args = array_merge( $wp_query->query_vars, array( 'post_type' => array( 'post','guies','page' )) );

}
query_posts( $args );
?>



<?php if (have_posts()) : ?>



		<?php while (have_posts()) : the_post(); ?>



				<div class="post">

						<h2><?php if (is_page() || is_single()) { the_title(); ?> <?php } else { ?> <a href="<?php the_permalink() ?>" rel="bookmark"

						title="Enllaç permanent a <?php the_title(); ?>"><?php

						the_title(); ?></a> <?php } ?></h2>
						<?php botons_socials() ?>
<?php if(is_page() || is_single()) { ?>

						<div class="post-info">

							<?php if(!is_page()) : ?>

                        	<span class="setting filedlink"><?php the_category(', ') ?></span> 

                      		<?php comments_popup_link('Cap comentari', 'Un comentari', '% comentaris', 'setting commentslink'); ?>

                      		</span> 

                            

							<?php edit_post_link($link = 'Edita', $before = '<span class="setting editlink">', $after = '</span>'); ?>

							



							<?php endif; ?>

						</div>

						<?php } ?>



					<div class="post-entry">

                    	<?php if(is_page() || is_single()) { ?>

						<?php the_content('Continua llegint &raquo;'); ?>

                        <?php } else { ?>

                        <ul class='post-meta'> 
<?php 
$imatge=get_post_meta(get_the_ID(),'wpcf-imatge',true);

if($imatge!='') {
?>
<div class="programa"><img style="vertical-align:middle" src="<?=get_post_meta(get_the_ID(),'wpcf-imatge',true)?>" /></div>
<?php } ?>
<div class="programa_desc"><br /><?=get_post_meta(get_the_ID(),'wpcf-descripcio_curta',true)?></div>
</ul> 

                        <?php } ?>

					</div>

                    <div class="post-meta">



						<?php if(is_single()) : ?>							



						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {

							// Both Comments and Pings are open

						?>



						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {

							// Only Pings are Open

						?>

							Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.



						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {

							// Comments are open, Pings are not

						?>

							You can skip to the end and leave a response. Pinging is currently not allowed.



						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {

							// Neither Comments, nor Pings are open

						?>

							Both comments and pings are currently closed.



						<?php } ?>

						</p>

						<?php endif; ?>

					</div>

					

				</div>



		<?php endwhile; ?>



	<?php else : ?>



				<div class="post">

					<div class="post-entry">

						<h2>No s'ha trobat</h2>

						<p class="center">Sembla que el que el que esteu cercant no es troba ací.</p>

					</div>

				</div>

		



	<?php endif; ?>