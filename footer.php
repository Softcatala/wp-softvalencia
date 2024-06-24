		</div>

<div id="footerhome">

<p>Softcatalà © <?php echo date('Y');?>   <a href="/contacte">Contacte</a>  |  <a href="/avis-legal">Avís legal</a>  |  <a href="https://www.softvalencia.org/guies/firefox-en-valencia/" title="Firefox en valencià">Firefox en valencià</a></p>

<p>Si no s'indica el contrari, el contingut text es troba disponible sota els termes d'una llicència <a href="http://creativecommons.org/licenses/by-sa/3.0/deed.ca">Atribució - CompartirIgual 3.0</a></p>

<div id="logospeu">El lloc web de <strong>Softvalencià</strong> funciona gràcies a <a href="http://ca.wordpress.org"><img src="/wp-content/themes/wp-softvalencia/imatges/wordpress.png" alt="WordPress" title="WordPress" /></a> <a href="http://www.phpbb.com"><img src="/wp-content/themes/wp-softvalencia/images/logo_phpBB_t.gif" alt="phpBB" title="phpBB" /></a> <a href="http://debian.cat"><img src="/wp-content/themes/wp-softvalencia/images/logo_debian_t.gif" alt="Debian" title="Debian" /></a> entre altre programari lliure.<span class="allotjament"> <strong>Allotjat a:</strong> <a href="http://www.udl.cat"><img src="/wp-content/themes/wp-softvalencia/images/logo_UdL_t.gif" alt="UDL" title="UDL" /></a></span></div>



    </div>



		<?php wp_footer(); ?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-15408482-1");
pageTracker._trackPageview();
} catch(err) {}</script>

<!-- Piwik -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://stats.softcatala.cat/" : "http://stats.softcatala.cat/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://stats.softcatala.cat/piwik.php?idsite=1" style="border:0" alt=""/></p></noscript>
<!-- End Piwik Tag -->

<script defer data-domain="softvalencia.org" src="https://t.softcatala.org/js/script.manual.pageview-props.js"></script>
<script>

	function sanitizeLanguage(lang) {
		if (lang.includes('-')) {
			return lang.split('-')[0].toLowerCase()
		}
		return lang.toLowerCase()
	}


	function getLanguages() {
		const exactLanguage = navigator.language.toLowerCase()
		const language =  sanitizeLanguage(navigator.language)

		const languages = {
			exactLanguage, language
		}

		let secondLanguage
		if (navigator.languages.length > 1) {
			secondLanguage = sanitizeLanguage(navigator.languages[1])
			languages.secondLanguage = secondLanguage
		}

		return languages
	}

	plausible('pageview', {
	props: {
		...getLanguages()
	}
})</script>


	</body>

</html>

