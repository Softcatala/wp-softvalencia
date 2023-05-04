<!-- Begin Sidebar -->
			<div>
				<ul>
				<?php 
	/* Widgetized sidebar, if you have the plugin installed. */
	
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :
	?>
                    <li class="widget">
                       <h2>Recent Posts</h2>
                    	<ul id="recent-posts">
						<?php  query_posts('showposts=5'); ?>
						<?php 
	while(have_posts()) :
	the_post();
	
	if(!($first_post == $post->ID)) :
	?>
							<li><span><a href="<?php  the_permalink()  ?>" title="Continue reading <?php  the_title(); ?>"><?php  the_title()  ?></a></span></li>
					<?php 
	endif;
	endwhile;
	?>
						</ul>
                    </li>
					<li class="widget"><h2>Categories</h2>
						<ul id="categories">
							<?php  wp_list_categories('title_li=&show_count=0&hierarchical=0'); ?>
						</ul>
					</li>
                 	<li class="widget"><h2>Archives</h2>
                    	<ul class="list-archives">
        				<?php  wp_get_archives('type=monthly'); ?>
      					</ul>
                    </li>
                    <li class="widget"><h2>Blogroll</h2>
                    	<ul class="linkcat">
        			<?php  get_links('-1', '<li>', '</li>', '<br />', FALSE, 'id', FALSE, FALSE, -1, FALSE); ?>
      					</ul>
                    </li>
                  <?php  endif; ?>
<li class="widget widget_pages">
<h2 class="widgettitle" style="color: #555555;">Enllaços d'interés</h2>
<ul>
<li class="page_item">
<a title="Escola Valenciana" href="http://www.escolavalenciana.com/">Escola Valenciana</a>
</li>
<li class="page_item">
<a title="Softcatalà" href="http://www.softcatala.org">Softcatalà</a>
</li>
</ul>
</li>
</ul>
<div class="social">
		<ul>
		  <li><a href="http://twitter.com/softvalencia"><img src="/wp-content/themes/wp-softvalencia/imatges/twitter.png"/></a></li>
		  <li><a href="http://www.facebook.com/#!/pages/Softvalencia/380344137430"><img src="/wp-content/themes/wp-softvalencia/imatges/facebook.png"/></a></li>
		  <li><a href="http://identi.ca/softvalencia"><img src="/wp-content/themes/wp-softvalencia/imatges/identica.png"/></a></li>		  
                  <li><a href="http://www.softvalencia.org/feed/"><img src="/wp-content/themes/wp-softvalencia/imatges/rss.png"/></a></li>
		</ul>
	  </div>

			</div><!-- End Sidebar -->
