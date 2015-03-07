<?php 

    global $wp_query;

    $context = Timber::get_context();
   
    $context['posts'] = Timber::get_posts(
        array_merge($wp_query->query_vars, array( 'post_type' => array( 'post','guies','page' ))) 
    );
    
    if(is_category()) {
        $context['title'] = get_category_link_with_image();
    } else if (is_tag()) {
        $context['title'] = single_tag_title(true);
    } else if (is_day()) {
        $context['title'] = get_the_time('F jS, Y');
    } else if (is_month()) {
        $context['title'] = get_the_time('F, Y');
    } else if (is_year()) {
        $context['title'] = the_time('F jS, Y');
    }
    
    Timber::render('twig/archive.twig', $context);
