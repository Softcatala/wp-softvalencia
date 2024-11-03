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

<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />

<meta name="author" content="Softcatalà" />

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/tabs.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/spell_checker.css" type="text/css" media="screen" />

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/base.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/cpaint2.inc.compressed.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/corrector/spell_checker.js"></script>

<?php if(is_traductor()): ?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/traductor.js?20200108"></script>
    <meta name="keywords" content="traductor, valencià, castellà, traductor, valenciano, castellano, catalán, català, francés, francès, portuguès, portugués" />
<?php endif; ?>

<?php wp_head(); ?>

</head>
<body>
<div id="wrapper">



    	<div id="capcalera">

			<div class="sidebar_home">

			<div class="logo_cap">
                <?php if (!is_home()): ?>
                    <a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo_sv_dol.png" alt="Softvalencià" title="Softvalencià" /></a></div>
                <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo_sv_dol.png" alt="Softvalencià" title="Softvalencià" /></div>
                <?php endif; ?>
			</div>

			<!--i menutop -->
			<div class="menutop">
			<div class="menutop1">
			<div class="menutop1_links">
			<div class="top-links">
                <a href="<?php echo get_home_url(); ?>/preguntes-mes-frequents/">Preguntes més freqüents</a>  |
                <a href="<?php echo get_home_url(); ?>/contacte">Contacte</a> |
                <a href="<?php echo get_home_url(); ?>/collaboreu/">Col·laboreu amb nosaltres</a>
            </div>

			</div>

				</div>	

		<div class="menutop2">

		<ul>

		<li><a href="<?php echo get_home_url(); ?>">Inici</a></li>

		<li><a href="<?php echo get_home_url(); ?>/traductor/">Traductor</a></li>

		<li><a href="<?php echo get_home_url(); ?>/corrector/">Corrector</a></li>

		<li><a href="http://www.softcatala.org/forum" target="_blank">Fòrums d'ajuda</a></li>

		</ul>

		</div>

			</div>

			<!--f menutop -->

		</div>

    

