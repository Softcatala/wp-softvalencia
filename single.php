<?php


    $context = Timber::get_context();
    $post = Timber::query_post();
    $context['post'] = $post;
    $context['comment_form'] = TimberHelper::get_comment_form();

    if ( post_password_required( $post->ID ) ) {
        Timber::render( 'single-password.twig', $context );
    } else {
        Timber::render( array(
            'twig/single-' . $post->ID . '.twig',
            'twig/single-' . $post->post_type . '.twig',
            'twig/single.twig' ), $context );
    }