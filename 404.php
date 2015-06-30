<?php

    $context = Timber::get_context();

    $context['sidebar404'] = Timber::get_widgets('404');

	$context['posts'] = array();

    Timber::render('twig/404.twig', $context);