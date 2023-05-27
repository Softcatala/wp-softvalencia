<?php
/*
Template Name: Adaptador
*/
?>
<?php 
	get_header(); 
?>
<div id="pre_content">
	<div id="pre_content_esq">

		<h3>Adaptador de la variant general del català a la variant valenciana</h3>

		Introduïu el text que voleu adaptar a la variant valenciana en el camp de text de la dreta. Conforme escriviu, el text adaptat apareixerà en el quadre de sota.

		<br><br>

		<h3>Quant a aquest adaptador</h3>

		Esta pàgina permet adaptar textos de la variant general del català a la variant valenciana. Per fer l'adaptació, s'utilitzen uns criteris basats en <a href="http://www.softvalencia.org/proposta/">aquesta proposta</a>, que compta amb el suport dels serveis lingüístics de les universitats valencianes i de l'AVL. Cal tindre en compte que inicialment està dissenyat per a frases curtes amb terminologia informàtica.

		<div class="imatges_br">
			<a href="http://www.softcatala.org"><img src="https://www.softvalencia.org/wp-content/uploads/2010/03/sc-xic-e1269881754771.png"></a>
			<a href="http://www.escolavalenciana.org"><img src="https://www.softvalencia.org/wp-content/uploads/2010/03/ev-xic1.png"></a>
		</div>

		<br>
	</div>
	<div id="pre_content_dreta">
		<form method="post" action="#">
		<textarea name="text" class="text" id="text"></textarea>
		<div class="guide">
		Escriviu un text i serà automàticament adaptat
		</div>
		</form>
		<h3 id="text_h3" style="">Text adaptat</h3>	
		<div id="text_adaptat"><div class="text_adaptat">Este text eixirà o no</div></div>
	</div>
</div>
<div id="sidebar">
  <?php
	global $notfound;
	$notfound=1;
      get_sidebar();
  ?>
</div>

<script type="text/javascript">

jQuery('#text').keyup(function() {
    var keyed = jQuery(this).val().replace(/\n/g, '<br/>');

    loadUrl = 'https://api.softcatala.org/adaptador/v1/valencia';

	t = urlencode(keyed)

    jQuery.get(  
        loadUrl + "?original=" + keyed,
        function(data){  
            jQuery("#text_h3").show();
            jQuery("#text_adaptat").html('<div class="text_adaptat">'+data.adapted+'</div>');  
        },  
        "json"  
    );
});

</script>


<?php edit_post_link($link = 'Edita', $before = '<span class="setting editlink">', $after = '</span>'); ?>
</div>
</div>
</div>

<?php get_footer(); ?>
