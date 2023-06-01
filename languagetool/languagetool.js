var SC_COOKIE = 'sc-languagetool';

(function($) {
  $(document).ready(function() {
    $("a.fancyboxImage").fancybox({
      'hideOnContentClick': true,
      'titlePosition': 'inside'
    });

    $("#mesopcions").click(function() {
      $("#mes_opcions").toggle($(this).is(':checked'));
    });

    $('#submit').click(function() {
      doit();
      return false;
    });

	$('#text_prova').click(function() {
		insertDemoText();
	});

    $('#check_formes_generals').click(function() {
      $('#opcions_valencia').hide();
    });

    $('#check_formes_valencianes').click(function() {
      $('#opcions_valencia').show();
    });

    $('#check_formes_balears').click(function() {
      $('#opcions_valencia').hide();
    });

    var clip = new ZeroClipboard($("#copyclip"), {
      moviePath: "/languagetool/js/ZeroClipboard.swf"
    });

    clip.on('mouseover', function(client, args) {
      clip.setText($.trim(tinymce.editors[0].core.getPlainText()));
    });

    read_cookie_status();
  });

  tinyMCE.init({
    mode: "specific_textareas",
    editor_selector: "lt",
    plugins: "AtD,paste",

    //Keeps Paste Text feature active until user deselects the Paste as Text button
    paste_text_sticky: true,
    //select pasteAsPlainText on startup
    setup: function(ed) {
      ed.onInit.add(function(ed) {
        ed.pasteAsPlainText = true;
      });
    },

    /* translations: */
    languagetool_i18n_no_errors: {
      // "No errors were found.":
      "ca": "No s\'ha trobat cap error",
      'ca-ES-valencia': 'No s\'ha trobat cap error'
    },
    languagetool_i18n_explain: {
      // "Explain..." - shown if there is an URL with a detailed description:
      'ca': 'Més informació…',
      'ca-ES-valencia': 'Més informació…'
    },
    languagetool_i18n_ignore_once: {
      // "Ignore this error":
      'ca': 'Crec que no hi ha error',
      'ca-ES-valencia': 'Crec que no hi ha error'
    },
    languagetool_i18n_edit_manually: {
        'ca': 'Edita manualment',
        'ca-ES-valencia': 'Edita manualment'
      },
    languagetool_i18n_ignore_all: {
      // "Ignore this kind of error":
      'ca': 'Ignora aquesta classe d\'errors',
      'ca-ES-valencia': 'Ignora aquesta classe d\'errors'
    },
    languagetool_i18n_rule_implementation: {
      // "Rule implementation":
      'ca': 'Informació sobre la regla...',
      'ca-ES-valencia': 'Informació sobre la regla...',
    },
    languagetool_i18n_edit_manually: {
      'ca': 'Edita manualment',
      'ca-ES-valencia': 'Edita manualment'
    },
    languagetool_i18n_suggest_word: {
      // "Suggest word for dictionary...": 
      // *** Also set languagetool_i18n_suggest_word_url below if you set this ***
      'ca': 'Suggereix una paraula per al diccionari...',
      'ca-ES-valencia': 'Suggereix una paraula per al diccionari...'
    },
    languagetool_i18n_suggest_word_url: {
      // "Suggest word for dictionary...":
      'ca': 'http://community.languagetool.org/suggestion?word={word}&lang=ca',
      'ca-ES-valencia': 'http://community.languagetool.org/suggestion?word={word}&lang=ca'
    },


    languagetool_i18n_current_lang: function() {
      return document.checkform.lang.value;
    },
    /* the URL of your proxy file: */
    //languagetool_rpc_url                 : "/languagetool/online-check/tiny_mce/plugins/atd-tinymce/server/proxy.php?url=",
    languagetool_rpc_url: "https://api.softcatala.org/corrector/v2/check",
    /* edit this file to customize how LanguageTool shows errors: */
    languagetool_css_url: "https://www.softvalencia.org/wp-content/themes/wp-softvalencia/languagetool/online-check/tiny_mce/plugins/atd-tinymce/css/content.css",
    /* this stuff is a matter of preference: */
    height: 300,
    theme: "advanced",
    theme_advanced_buttons1: "",
    theme_advanced_buttons2: "",
    theme_advanced_buttons3: "",
    theme_advanced_toolbar_location: "none",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom", // activated so we have a resize button
    theme_advanced_path: false, // don't display path in status bar
    theme_advanced_resizing: true,
    theme_advanced_resizing_use_cookie: false,
    /* disable the gecko spellcheck since AtD provides one */
    gecko_spellcheck: false
  });

  function doit() {
    if (tinyMCE.activeEditor.getContent().length > 50000) {
      var errorMsg = "Heu superat el l\u00EDmit de 50.000 car\u00E0cters.";
      alert(errorMsg);
    } else {

      var disabledRules = [];
      var enabledRules = [];
      var disabledCategories = [];

      // opcions general (ca-ES)
      var ca_disabledRules = [];
      var ca_enabledRules = []; 
      var ca_disabledCategories = []; 

      //Opcions de tipografia
      var typo_enabledRules = [];
      var typo_disabledRules = [];
      var typo_disabledCategories = [];

      // deshabilita algunes regles del mode "picky"
      typo_disabledRules.push("ESPAI_FI");
      typo_disabledRules.push("ADVERBIS_MENT");
      typo_disabledRules.push("TOO_LONG_SENTENCE");

      /* incoatius -eix/-ix */
      if (jQuery("input[name=incoatius]:checked").val() == "incoatius_ix") {
          enabledRules.push("EXIGEIX_VERBS_IX");
          disabledRules.push("EXIGEIX_VERBS_EIX");
      };
      /* incoatius -esc/-isc */
      if (jQuery("input[name=incoatius2]:checked").val() == "incoatius_esc") {
          enabledRules.push("EXIGEIX_VERBS_ESC");
          disabledRules.push("EXIGEIX_VERBS_ISC");
      };
      /* demostratius aquest/este */
      if (jQuery("input[name=demostratius]:checked").val() == "demostratius_este") {
          enabledRules.push("EVITA_DEMOSTRATIUS_AQUEST");
          disabledRules.push("EVITA_DEMOSTRATIUS_ESTE");
      };
      /* accentuació café /cafè */
      if (jQuery("input[name=accentuacio]:checked").val() == "accentuacio_general") {
          enabledRules.push("EXIGEIX_ACCENTUACIO_GENERAL");
          disabledRules.push("EXIGEIX_ACCENTUACIO_VALENCIANA");
      };

      if (jQuery("input[name=SE_DAVANT_SC]:checked").val()) {
          typo_disabledRules.push("SE_DAVANT_SC");
      }
      

      const langCode = "ca-ES-valencia";

      typo_disabledRules.push("WHITESPACE_RULE"); //disable always WHITESPACE_RULE 


      ca_enabledRules.push("EXIGEIX_VERBS_VALENCIANS","EXIGEIX_POSSESSIUS_U");
      ca_disabledRules.push("EXIGEIX_VERBS_CENTRAL","EVITA_DEMOSTRATIUS_EIXE","EXIGEIX_POSSESSIUS_V");
      pushArray(ca_enabledRules, enabledRules);
      pushArray(ca_disabledRules, disabledRules);
      pushArray(ca_disabledCategories, disabledCategories);

      pushArray(ca_enabledRules, typo_enabledRules);
      pushArray(ca_disabledRules, typo_disabledRules);
      pushArray(ca_disabledCategories, typo_disabledCategories);
      pushArray(enabledRules, typo_enabledRules);
      pushArray(disabledRules, typo_disabledRules);
      pushArray(disabledCategories, typo_disabledCategories);

      save_cookie_status();

      let userOptions="&level=picky";

      if (disabledRules.join()) { userOptions += "&disabledRules=" + disabledRules.join(); }
      if (enabledRules.join()) { userOptions += "&enabledRules=" + enabledRules.join(); }
      if (disabledCategories.join()) { userOptions += "&disabledCategories=" + disabledCategories.join(); }

      tinyMCE.activeEditor.execCommand('mceWritingImprovementTool', langCode, userOptions);
    }
  }

  
function pushArray(arr, arr2) {
    arr.push.apply(arr, arr2);
}


  function read_cookie_status() {
    if ($.getCookie('sc-languagetool')) {
      var formes = $.getMetaCookie('formes', SC_COOKIE);

      $('#check_' + formes).attr('checked', 'checked');
      if ($('#check_formes_valencianes').is(':checked')) {
        $('#opcions_valencia').show();
      } else {
        $('#opcions_valencia').hide();
      }

      var mesopcions = $.getMetaCookie('mesopcions', SC_COOKIE);
      if (mesopcions) {
        $('#mesopcions').attr('checked', 'checked');
        $("#mes_opcions").toggle($('#mesopcions').is(':checked'));
      }

      var regles_amb_checkbox = Array('SE_DAVANT_SC',
        'CA_UNPAIRED_QUESTION');

      $.each(regles_amb_checkbox, function(index, nom) {

        var regla = $.getMetaCookie(nom, SC_COOKIE);

        if (regla !== undefined) {
          if (regla > 0) {
            $('input[name=' + nom + ']').attr('checked', 'checked');
          } else {
            $('input[name=' + nom + ']').removeAttr('checked');
          }
        }
      });

      var regles_amb_radio = Array('accentuacio', 'incoatius', 'incoatius2',
        'demostratius');

      $.each(regles_amb_radio, function(index, nom) {

        var valor = $.getMetaCookie(nom, SC_COOKIE);

        if (valor !== undefined) {
          $('[type="radio"][name="' + nom + '"][value="' + valor + '"]')
            .attr('checked', 'checked');
        }
      });
    }
  }

  function save_cookie_status() {
    if (!$.getCookie(SC_COOKIE)) {
      $.setCookie(SC_COOKIE, '');
    }

    var formes = $("input[name=formes]:checked").val();
    var mesopcions = $('#mesopcions').is(':checked');
    var se_davant_sc = $('#SE_DAVANT_SC').is(':checked');


    $.setMetaCookie('formes', SC_COOKIE, formes);
    $.setMetaCookie('mesopcions', SC_COOKIE, mesopcions);

    var regles_amb_checkbox = Array('SE_DAVANT_SC', 'CA_UNPAIRED_QUESTION');

    $.each(regles_amb_checkbox, function(index, nom) {
      var valor = $('input[name=' + nom + ']:checked').val();

      if (valor) {
        $.setMetaCookie(nom, SC_COOKIE, 1);
      } else {
        $.setMetaCookie(nom, SC_COOKIE, -1);
      }
    });

    var regles_amb_radio = Array('accentuacio', 'incoatius', 'incoatius2',
      'demostratius');

    $.each(regles_amb_radio, function(index, nom) {
      var valor = $('[type="radio"][name="' + nom + '"]:checked').val();
      $.setMetaCookie(nom, SC_COOKIE, valor);
    });
  }
}(jQuery));

function insertDemoText()
{
   var myDemoText="Aquests frases servixen per a probar algun de les errades que detecta el corrector gramaticals. Proveu les variants de flexió verbal: penso, pense, pens. L'accentuació valenciana o general: café o cafè. Paraules errònies segons el context: Et menjaràs tots els canalons? Li va infringir un càstig sever. Errors de sintaxi: la persona amb la que vaig parlar. I algunes altres opcions: Quan es celebrarà la festa?";
   tinyMCE.activeEditor.setContent(myDemoText);
}
