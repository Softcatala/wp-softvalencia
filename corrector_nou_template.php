<?php
/*
Template Name: Corrector_nou
*/
?>
<?php 
	global $pg_corrector;
	$pg_corrector = true;
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
      <h1>Corrector de valencià</h1>
      <div class="post-entry">

	<?php 
		the_post();
		the_content('Continua llegint &raquo;'); 
	?>

<!--CORRECTOR WRAPPER -->

	<script type="text/javascript" src="/languagetool/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link type="text/css" rel="stylesheet" media="all" href="/languagetool/js/fancybox/jquery.fancybox-1.3.4.css" /> 
	<script type="text/javascript" src="/languagetool/online-check/tiny_mce/tiny_mce.js"></script> 
	<script type="text/javascript" src="/languagetool/online-check/tiny_mce/plugins/atd-tinymce/editor_plugin.js"></script>
	<script type="text/javascript" src="/languagetool/js/ZeroClipboard.js"></script>
	<script type="text/javascript" src="/languagetool/js/jquery.metacookie.js"></script>

	<script type="text/javascript" src="/languagetool/languagetool.js"></script>
	<link type="text/css" rel="stylesheet" media="all" href="/languagetool/languagetool.css" />


<style type="text/css">
<!--
.textcorrectorgram {
  margin-top:15px;
}
.textcorrectorgram p, .textcorrectorgram form {
    font: 13px/20px Verdana;
    margin: 3px 0px 13px 0px;
}
.textpetit {
   font-size: 10px;
}
.textexplicacions p {
    font: 12px/19px Verdana;
    margin: 3px 0px 13px 0px;
}
td {vertical-align:top;}
td img {vertical-align: top;}
.ngrid690 {
    width: 95% !important;
}

.ngrid260 {
    width: 30% !important;
}

.boxtit {
    width: 95% !important;
}

-->
</style>
<script language="javascript" type="text/javascript">
function insertDemoText()
{
   var myDemoText="Aquests frases servixen per a probar algun de les errades que detecta el corrector gramaticals. Proveu les variants de flexió verbal: penso, pense, pens. L'accentuació valenciana o general: café o cafè. Paraules errònies segons el context: Et menjaràs tots els canalons? Li va infringir un càstig sever. Errors de sintaxi: la persona amb la que vaig parlar. I algunes altres opcions: Quan es celebrarà la festa?";
   tinyMCE.activeEditor.setContent(myDemoText);   
}
</script>
<div id="corrector" class="ngrid690">


<div class="textcorrectorgram">

<div style="margin:5px 0px 5px 0px;">
<p>
Escriviu o enganxeu un text en el formulari i cliqueu en «Revisa».
</p>
</div>

<!-- comença el formulari -->
<div class="textcorrectorgram">
<form name="checkform" action="https://community.languagetool.org" method="post">
<div style="margin: 10px 0px 10px 10px; float: left; display:none;">
				Formes: 
				<input type="radio" name="formes" value="formes_generals" id="check_formes_generals">generals
				<input type="radio" name="formes" value="formes_valencianes" checked id="check_formes_valencianes">valencianes
				<input type="radio" name="formes" value="formes_balears" id="check_formes_balears">balears
			</div>
		<p id="checktextpara">
			<textarea spellcheck="false" id="checktext" class="lt" name="text" style="width: 100%" rows="6"></textarea>
		</p>
		<textarea id="copytextarea" name="copytextarea" style="width: 100%;display:none" rows="6" readonly="readonly"></textarea>

		<div style="margin-top:2px;position:relative;">
			<input type="hidden" name="lang" value="ca-ES-valencia"/>
                        <div style="margin-top:0px; display:block; float: right; text-align:right;">

				<input type="submit" id="submit" name="_action_checkText" value="Revisa">
<br/><a class="textpetit" href="javascript:void(0)" onclick="javascript:insertDemoText();">Insereix un text de prova</a>
                        </div> 

                                
			<div style="margin: 3px 0px 10px 10px; display:block; float: left;">
				<input type="checkbox" id="mesopcions" value="mesopcions">Més opcions 
				<div id="mes_opcions" style="margin: 10px 0px 10px 0px; display:none; background-color:#F0F0EE;">
					<input type="checkbox" name="SE_DAVANT_SC" value="SE_DAVANT_SC" checked>Exigeix 'se' (se sap, se celebra)<br/>
					<input type="checkbox" name="CA_UNPAIRED_QUESTION" value="CA_UNPAIRED_QUESTION">Exigeix signe d'interrogació inicial (¿)<br/>

					<div id="opcions_valencia" style="margin-top:0px; display:block; background-color:#F0F0EE; float: left;display:none;" >   	
						<table summary="" border="0">
							<tr>
								<td>Accentuació:</td>
								<td><input type="radio" name="accentuacio" value="accentuacio_general">general (cafè)</td>
								<td><input type="radio" name="accentuacio" value="accentuacio_valenciana" checked>valenciana (café)</td>
							</tr>
							<tr>
								<td>Verbs incoatius:</td>
								<td><input type="radio" name="incoatius" value="incoatius_eix" checked>-eix (serveix)</td>
								<td><input type="radio" name="incoatius" value="incoatius_ix">-ix (servix)</td>
							</tr>
							<tr>
							<td></td>
								<td><input type="radio" name="incoatius2" value="incoatius_esc">-esc (servesc)</td>
								<td><input type="radio" name="incoatius2" value="incoatius_isc" checked>-isc (servisc)</td>
							</tr>
							<tr>
								<td>Demostratius:</td>
								<td><input type="radio" name="demostratius" value="demostratius_aquest" checked>aquest</td>
								<td><input type="radio" name="demostratius" value="demostratius_este">este</td>
						</tr>
						</table>  
					</div>
				</div>
			</div>
			<div style="clear:both"> </div>
		</div>

	</form>
</div>
<!-- acaba el formulari-->
<br/>
<div class="textexplicacions">
<table summary="">
<tr>
<td>
<p>
<strong>Resultats</strong>. Apareixeran subratllats
<span class="hiddenSpellError">errors ortogràfics</span>,
<span class="hiddenGrammarError">errors gramaticals o tipogràfics</span> i
<span class="hiddenGreenError">recomanacions d'estil</span>. 
Fent clic en les paraules assenyalades, obtindreu suggeriments de correcció, si n'hi ha. Els resultats són orientatius i en cap cas poden substituir una revisió experta.
</p>
</td>
</tr>
<tr>
<td><p><strong>Crèdits</strong>. Este servei està basat en el programari lliure <a href="http://languagetool.org/ca/">LanguageTool</a>, i s'ha desenvolupat gràcies a <a href="http://riuraueditors.cat/web/content/12-eines" title="Riurau Editors">Riurau Editors</a> i <a href="http://www.softcatala.org/wiki/Projectes/LanguageTool">Softcatalà</a>.</p></td>
<td><p><strong>Contacte</strong>. Per a qualsevol suggeriment, escriviu-nos a <a href="mailto:corrector@softcatala.org">corrector@softcatala.org</a>.</p></td>
</tr>
<tr><td><a href="http://www.languagetool.org/ca" title="LanguageTool"><img alt="LangueageTool" src="https://www.softcatala.org/w/images/f/fa/LanguageToolBig.png" /></a>
<a style="margin-left:30px;" href="http://riuraueditors.cat/web/content/12-eines" title="Riurau Editors"><img alt="Riurau Editors" src="https://www.softcatala.org/w/images/c/c9/Logo_riuraueditors.png" /></a>
</td>
<td>

</td>
</tr>
</table> 
</div>
</div>




<!--CORRECTOR WRAPPER -->
</div>
<div class="bloque">


</div>
<!-- F contingut central -->
</div>
</div>
</div>
</div>

<?php get_footer(); ?>
