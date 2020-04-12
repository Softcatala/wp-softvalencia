<?php get_header(); ?>
    <div id="pre_content">
        <div id="pre_content_esq">
            <div class="introduction-text">
                <h1>Què és Softvalencià?</h1>
                Softvalencià és un lloc web on trobareu guies i programari per posar el vostre ordinador en valencià.
                <h3>Qui hi ha al darrere?</h3>
                Softvalencià és una iniciativa dels membres valencians de Softcatalà i d'Escola Valenciana per promoure l'ús del programari en valencià.
                Softvalencià té el reconeixement dels serveis lingüístics de les universitats públiques valencianes i de l'Acadèmia Valenciana de la Llengua.
                <div class="imatges_br">
                    <a href="http://www.softcatala.org"><img src="https://www.softvalencia.org/wp-content/uploads/2010/03/sc-xic-e1269881754771.png"/></a>
                    <a href="http://www.escolavalenciana.org"><img src="https://www.softvalencia.org/wp-content/uploads/2010/03/ev-xic1.png"/></a>
                </div>
                <br/>
            </div>
        </div>
        <div id="pre_content_dreta">
            <div class="slides">
                <?php echo do_shortcode("[metaslider id=1095]"); ?>
            </div>
        </div>
    </div>


    <div id="content1">


        <div id="windows" class="sistema">

            <a href="<?php echo get_option( 'siteurl' ); ?>/categoria/windows"><img src="<?php echo get_option( 'siteurl' ); ?>/imatges/windowsos.png"/></a>

            <ul>

                <?php
                $windows = new WP_Query('cat=3&posts_per_page=15&post_type=guies');
                while ($windows->have_posts()) {
                    $windows->the_post();
                    echo '<li><a href="', get_permalink(get_the_ID()), '">';
                    the_title();
                    echo '</a><br /><small>';
                    $d_curta = get_post_custom_values('descripcio_portada');
                    echo $d_curta[0];
                    echo '</small></li>';
                }
                ?>


            </ul>

        </div>

        <div id="mac" class="sistema">
            <a href="<?php echo get_option( 'siteurl' ); ?>/categoria/macosx"><img src="<?php echo get_option( 'siteurl' ); ?>/imatges/macos.png"/></a>
            <ul>
                <?php
                $windows = new WP_Query('cat=15&posts_per_page=15&post_type=guies');
                while ($windows->have_posts()) {
                    $windows->the_post();
                    echo '<li><a href="', get_permalink(get_the_ID()), '">';
                    the_title();
                    echo '</a><br /><small>';
                    $d_curta = get_post_custom_values('descripcio_portada');
                    echo $d_curta[0];
                    echo '</small></li>';
                }
                ?>
            </ul>

        </div>
        <div id="linux" class="sistema">
            <a href="<?php echo get_option( 'siteurl' ); ?>/categoria/gnulinux"><img src="<?php echo get_option( 'siteurl' ); ?>/imatges/linuxos.png"/></a>
            <ul>
                <?php
                $windows = new WP_Query('cat=5&posts_per_page=15&post_type=guies');
                while ($windows->have_posts()) {
                    $windows->the_post();
                    echo '<li><a href="', get_permalink(get_the_ID()), '">';
                    the_title();
                    echo '</a><br /><small>';
                    $d_curta = get_post_custom_values('descripcio_portada');
                    echo $d_curta[0];
                    echo '</small></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <div id="sidebar">
        <?php get_sidebar(); ?>
    </div>

<?php get_footer(); ?>