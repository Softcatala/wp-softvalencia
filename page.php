<?php

    $context = Timber::get_context();
    $context['post'] = new TimberPost();
    
    Timber::render('twig/page.twig', $context );
