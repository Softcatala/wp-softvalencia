<?php
/*
Template Name: Navega
*/
?>
<?php 
	global $pg_navega;
	$pg_navega = true;
	get_header(); 
?>
<div id="sidebar">
  <?php
	global $notfound;
	$notfound=1;
      get_sidebar();
  ?>
</div>


<div id="content">

  <div class="post">
      <h1>Navega en valencià</h1>
      <div class="post-entry">

	<?php 
		the_post();
		the_content('Continua llegint &raquo;'); 
	?>
        
	<div class="combinacio_navegador">
		<ul>
			<li class="win-ie"><a onclick="document.softvalencia.desplega('nav1')">Windows XP i Internet Explorer</a></li>
			<li class="win-ff"><a onclick="document.softvalencia.desplega('nav2')">Windows XP i Firefox</a></li>

			<li class="win-ch"><a onclick="document.softvalencia.desplega('nav3')">Windows XP i Chrome</a></li>
			<li class="win-op"><a onclick="document.softvalencia.desplega('nav4')">Windows XP i Opera</a></li>
			<li class="mac-sa"><a onclick="document.softvalencia.desplega('nav5')">Mac OS X i Safari</a></li>
			<li class="mac-ff"><a onclick="document.softvalencia.desplega('nav6')">Mac OS X i Firefox</a></li>				
			<li class="lin-ff"><a onclick="document.softvalencia.desplega('nav7')">Linux i Firefox</a></li>
		</ul>
	</div>
	
	<div id="nav1" class="ocult">
		<h2 class="win-ie" id="win-ie">Windows XP i Internet Explorer 6*, 7* o 8</h2>

				<h3>Configureu el valencià com la llengua de navegació de l'Internet Explorer</h3>
				<ol>

					<li>En el menú de la part superior de la pantalla, feu clic en l'opció <strong>Eines</strong>.</li>
					<li>Trieu <strong>Opcions d'Internet</strong>.</li>
					<li>Aneu a la pestanya <strong>General</strong>. En la part inferior de la finestra que es mosra, feu clic en el botó <strong>Llengües</strong>.</li>

					<li>Si el «català» no es troba entre les llengües que hi veieu, l'heu de trobar entre el llistat desplegable i després heu de fer clic en el botó <strong>Afegeix</strong>.</li>
					<li><strong>Mou amunt</strong> el català fins que estiga a dalt de tot, el primer de la llista.</li>
					<li>Finalment feu clic en <strong>D'acord</strong> i reinicieu el navegador.</li>
				</ol>

	</div>
	
	<div id="nav2" class="ocult">
	<h2 class="win-ff" id="win-ff">Windows XP i Firefox 3.6*</h2>

				<h3>Configureu el valencià com la llengua de navegació del Firefox en Windows</h3>
				<ol>

					<li>En el menú de la part superior de la pantalla, feu clic en l'opció <strong>Eines</strong>.</li>
					<li>Trieu <strong>Opcions</strong>.</li>
					<li>Aneu a <strong>Contingut</strong>.</li>
					<li>Trobareu un quadre on diu <strong>Trieu la vostra llengua predefinida per a mostrar les pàgines</strong>. Allà haureu de triar «català».</li>

					<li>Si no apareix el català entre les llengües que es mostren, l'heu de trobar al llistat desplegable i afegir-la.</li>
					<li><strong>Moveu amunt</strong> el català fins que estiga a dalt de tot, el primer de la llista.</li>
					<li>Feu clic en <strong>d'acord</strong> i reinicieu el navegador.</li>
				</ol>

	</div>
	
	<div id="nav3" class="ocult">
		<h2 class="win-ch" id="win-chrome">Windows XP i Google Chrome*</h2>

			
				<h3>Configureu el valencià com la llengua de navegació del Google Chrome en Windows</h3>
				<ol>
					<li>En el menú de la part superior de la pantalla, aneu a dalt a la dreta, a la icona de la de clau anglesa, on diu <strong>Personalitza i controla</strong>, allà feu clic al damunt i es desplegarà un menú.</li>

					<li>Feu clic en <strong>Opcions</strong> i s'obrirà una finestra.</li>
					<li>Seleccioneu la pestanya <strong>Intermedi</strong>.</li>
					<li>Feu clic en el botó <strong>Canvia la configuració de tipus de lletra i idioma</strong>.</li>
					<li>Seleccioneu la pestanya <strong>Idiomes</strong>. Si no apareix el català, feu clic en <strong>Afegeix</strong> i seleccioneu «català» entre el llistat desplegable.</li>

					<li><strong>Moveu amunt</strong> fins a posar-lo en la primera posició, davant de la resta de les llengües.</li>
					<li><strong>Accepteu</strong> i reinicieu el navegador.</li>
				</ol>

	</div>
	
	<div id="nav4" class="ocult">
		<h2 class="win-op" id="win-op">Windows XP i Opera 10*</h2>
				
				<h3>Configureu el valencià com la llengua de navegació de l'Opera en Windows</h3>
				<ol>
					<li>En el menú de la part superior de la pantalla esquerra, feu clic en l'opció <strong>Settings</strong>.</li>

					<li>Trieu <strong>Preferences</strong> i aneu a la pestanya <strong>General</strong>.</li>
					<li>A baix de la finestra trobareu <strong>Llenguatge Preferent per a Opera i pàgines Web</strong>, trieu el català.</li>
					<li>Si no apareix el català entre les llengües que es mostren, el podreu trobar en la llista desplegable i afegir-lo des d'allà.</li>
					<li><strong>Moveu amunt</strong> el català fins que estiga a dalt de tot, la primera de les llengües que hi apareixen.</li>

					<li>Feu clic en <strong>OK</strong> i reinicieu el navegador.</li>
				</ol>

	</div>
	
	<div id="nav5" class="ocult">
	<h2 class="mac-sa" id="mac-safari">Mac OS X i Safari*</h2>

				
				<h3>Configureu el valencià com la llengua de navegació del Safari en MacOSX</h3>
				<ol>
					<li>En el menú de la part superior de la pantalla, aneu a la icona de la poma, a l'esquerra del tot.</li>
					<li>Feu clic en <strong>Preferències del sistema</strong>.</li>
					<li>En la primera barra, seleccioneu <strong>Internacional</strong> i des d'ací aneu a <strong>Idioma</strong>.</li>

					<li>Si no apareix el català entre les llengües que es mostren, el trobareu a a <strong>Edita la llista</strong> i des d'allà el podreu afegir.</li>					
					<li>Arrossegueu el català fins a dalt de la llista fins que quede el primer .</li>
					<li>Feu clic en <strong>D'acord</strong> i reinicieu el navegador.</li>
				</ol>

				
	</div>
	
	<div id="nav6" class="ocult">
	<h2 class="mac-ff" id="mac-ff">Mac OS X i Firefox 3.6*</h2>
				
				<h3>Configureu el valencià com la llengua de navegació del Firefox en MacOSX</h3>
				<ol>

					<li>Amb el Firefox obert, aneu al menú de la part superior de la pantalla, aneu a <strong>Firefox</strong>, a l'esquerra.</li>
					<li>Trieu <strong>Preferències</strong>.</li>
					<li>Aneu a <strong>Contingut</strong>.</li>
					<li>Trobareu un quadre on diu <strong>Trieu la vostra llengua predefinida per a mostrar les pàgines</strong>. Allà trieu el català.</li>

					<li>Si no apareix el català entre les llengües que es mostren, l'heu de trobar al llistat desplegable i afegir-lo.</li>
					<li><strong>Moveu amunt</strong> el català fins que estiga a dalt de tot, el primer de la llista.</li>
					<li>Feu clic en <strong>D'acord</strong> i reinicieu el navegador.</li>
				</ol>

				

	</div>
	
	<div id="nav7" class="ocult">
	<h2 class="lin-ff" id="lin-ff">Linux i Firefox 3.6*</h2>
				
				<h3>Configureu el valencià com la llengua de navegació del Firefox en GNU/Linux</h3>
				<ol>

					<li>En el menú de la part superior de la pantalla, feu clic en l'opció <strong>Edita</strong>.</li>
					<li>Trieu <strong>Preferències</strong>.</li>
					<li>Aneu a <strong>Contingut</strong>.</li>
					<li>Trobareu un quadre on diu <strong>Trieu la vostra llengua predefinida per a mostrar les pàgines</strong>. Allà trieu el català.</li>

					<li>Si no apareix el català entre les llengües que es mostren, l'heu de trobar al llistat desplegable i afegir-lo.</li>
					<li><strong>Moveu amunt</strong> el català fins que estiga a dalt de tot, el primer de la llista.</li>
					<li>Feu clic en <strong>D'acord</strong> i reinicieu el navegador.</li>
				</ol>

				
	</div>
	

    </div>
</div>
</div>
</div>

<?php get_footer(); ?>

