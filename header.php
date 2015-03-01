<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ca-valencia"  <?php echo language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php 
    if(is_404()) {
        echo "No s'ha trobat la pàgina";
    } else {
    wp_title();
    }
?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<link rel="shortcut icon" type="image/x-icon" href="/imatges/favicon.ico" />

<meta name="author" content="Softcatalà" />

<link rel="stylesheet" href="/estils/tabs.css" type="text/css" media="screen" />

<link rel="stylesheet" href="/estils/spell_checker.css" type="text/css" media="screen" />

<script type="text/javascript" src="/js/jquery-latest.min.js"></script>

<script type="text/javascript" src="/js/base.js"></script>
<script type="text/javascript" src="/js/jquery.cycle.js"></script>


<script type="text/javascript" src="/lib/corrector/cpaint/cpaint2.inc.compressed.js"></script>

<script type="text/javascript" src="/js/corrector/spell_checker.js"></script>

<?php

	if(is_traductor()) {

	        echo '<script type="text/javascript" src="/wp-content/themes/wp-softvalencia/traductor.js"></script>';
                echo '<meta name="keywords" content="traductor, valencià, castellà, traductor, valenciano, castellano, catalán, català, francés, francès, portuguès, portugués" />';
	}



?>



<?php wp_head(); ?>



</head>

<body>

<div id="wrapper">



    	<div id="capcalera">

			<div class="sidebar_home">

			<div class="logo_cap"><a href="/"><img src="/wp-content/themes/wp-softvalencia/images/logo_sv.png" alt="Softvalencià" title="Softvalencià" /></a></div>

			</div>

			<!--i menutop -->

			<div class="menutop">

			<div class="menutop1">

			<div class="menutop1_links">

			<h1><a href="/preguntes-mes-frequents/">Preguntes més freqüents</a>  |     <a href="/contacte">Contacte</a> | <a href="/collaboreu/">Col·laboreu amb nosaltres</a></h1>

			</div>

				</div>	

		<div class="menutop2">

		<ul>

		<li><a href="/">Inici</a></li>		

		<li><a href="/traductor">Traductor</a></li>

		<li><a href="/corrector">Corrector</a></li>

		<li><a href="http://www.softcatala.org/forum" target="_blank">Fòrums d'ajuda</a></li>

		</ul>

		</div>

			</div>

			<!--f menutop -->

		</div>

    

