<?php

    $context = Timber::get_context();

    $context['sidebar404'] = Timber::get_widgets('404');

    $context['url'] = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

	$context['posts'] = array();

    Timber::render('twig/index.twig', $context);