<?php
/*
Template Name: Traductor
*/
?>
<?php 
	global $pg_traductor;
	$pg_traductor = true;
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
      <h1>Traductor valencià</h1>
      <div class="post-entry">

        <?php

	// en manteniment
	$manteniment = false;

	if($manteniment) {
?>
	<br /><br /><div class="boxtraductor" style="font-size:2em;color:maroon;font-weight:bold">El traductor es troba en tasques de manteniment</div>
<?php
	} else {
?>

        <div class="boxtraductor">
          <form id="ftraductor">
              <textarea class="texte" cols="10" rows="10" id="sl" name="sl" maxlength="20000"></textarea>
		<div style="clear:both">
			<select id="langpair">
				<option value="es-ca_valencia">castellà » valencià</option>
				<option value="ca-es" selected="selected">valencià » castellà</option>
				<option value="fr-ca">francés » valencià (versió en proves)</option>
				<option value="ca-fr">valencià » francés (versió en proves)</option>
				<option value="en-ca">anglés » valencià (versió en proves)</option>
				<option value="ca-en">valencià » anglés (versió en proves)</option>
				<option value="pt-ca">portugués » valencià (versió en proves)</option>
				<option value="ca-pt">valencià » portugués (versió en proves)</option>
			</select>
			<span id="sp_unknown">
				<label for="unknown" style="display:inline">Marca les paraules desconegudes</label>
				<input type="checkbox" style="vertical-align:middle" id="unknown" name="unkwown" checked="checked"/>
			</span>
			<span id="sp_valencia" style="display:none">
				<label for="valencia" style="display:inline">Utilitza les variants valencianes</label>
				<input type="checkbox" style="vertical-align:middle" id="valencia" name="valencia" checked="checked"/>
			</span>
			<div style="float:right">
				<input type="submit" value="Tradueix" />
			<div>
		</div>
          </form>
        </div>
        
        <div id="dv_traduccio" style="display:none">
        <h3>Traducció<span id="trad_info"></span></h3>
        <div class="texte" id="traduccio" style="border:1px solid #666;"></div>

	<a id="lk_proposta" style="cursor:pointer">Teniu alguna traducció millor?</a>
	<div id="dv_proposta" style="display:none">
		<h3>La vostra proposta</h3>
		<small style="color:maroon">Abans d'enviar cap proposta, assegureu-vos que heu escrit el text original sense faltes d'ortografia.</small><br />
		<small>Tingueu en compte que s'enviarà el text original i la traducció automàtica, a més de les propostes que apunteu</small>
		<form id="form_proposta">
			<textarea class="texte" cols="10" rows="10" id="proposta" name="proposta"></textarea>
			<div style="clear:both">
				<small>Estes propostes serviran per a millorar la qualitat del traductor. Gràcies per la vostra col·laboració.</small>
				<div style="float:right">
					<input type="submit" value="Envia la proposta" />
				</div>
			</div>
		</form>
	</div>
     	</div>
<?php
	}
?>
	<div class="nota_traductor">
		<?php 
			the_post();
			the_content('Continua llegint &raquo;'); 
		?>
	</div>
      </div>
  </div>


<?php edit_post_link($link = 'Edita', $before = '<span class="setting editlink">', $after = '</span>'); ?>
</div>
</div>
</div>

<?php get_footer(); ?>
