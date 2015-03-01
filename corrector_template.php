<?php
/*
Template Name: Corrector
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
      <h2>Corrector de valencià</h2>
      <div class="post-entry">

	<?php 
		the_post();
		the_content('Continua llegint &raquo;'); 
	?>

<!--I GRID690 -->
<div class="ngrid690">
<br class="clearfloat" />
<!--i box corrector -->
<input type="hidden" name="variant" value="valencià" />
<div class="boxtraductor">
<form action="#">
  <textarea title="spellcheck_icons" accesskey="/lib/corrector/spell_checker.php?variant=valencia" id="spell_checker1" name="comment1" class="texte" cols="10" rows="10"><?php if ($_REQUEST['textc']) { echo strip_tags($_REQUEST['textc'], '<a> <em> <strong> <cite> <code> <ul> <ol> <li> <dl> <dt> <dd> <img /> <sup> <sub> <br /> <p> <b> <u> <sup> <sub>');} ?></textarea>
</form>
<br />
</div>
<!--f box corrector -->
<!--F GRID690 -->
<!--I GRID260 -->
<div class="ngrid260">


<!--F GRID690 -->
</div>
<div class="bloque">


</div>
<!-- F contingut central -->
</div>
</div>
</div>
</div>

<?php get_footer(); ?>
