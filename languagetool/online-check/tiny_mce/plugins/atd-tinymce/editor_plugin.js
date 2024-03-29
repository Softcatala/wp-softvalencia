/*
 * atd.core.js - A building block to create a front-end for AtD
 * Author      : Raphael Mudge, Automattic; Daniel Naber, LanguageTool.org
 * License     : LGPL
 * Project     : http://www.afterthedeadline.com/developers.slp
 * Contact     : raffi@automattic.com
 *
 * Note: this has been simplified for use with LanguageTool - it now assumes there's no markup 
 * anymore in the text field (not even bold etc)!
 */

/* EXPORTED_SYMBOLS is set so this file can be a JavaScript Module */
var EXPORTED_SYMBOLS = ['AtDCore'];

//
// TODO:
// 1. "ignore this error" only works until page reload
// 2. Ctrl-Z (undo) makes the error markers go away
//

String.prototype.insert = function (index, string) {
  if (index > 0)
    return this.substring(0, index) + string + this.substring(index, this.length);
  else
    return string + this;
};

function AtDCore() {
    /* Localized strings */
    this.i18n = {};
    /* We have to mis-use an existing valid HTML attribute to get our meta information
     * about errors in the text: */
    this.surrogateAttribute = "onkeypress";
    this.surrogateAttributeDelimiter = "---#---";
    this.ignoredRulesIds = [];
    this.ignoredSpellingErrors = [];
}

/*
 * Internationalization Functions
 */

AtDCore.prototype.getLang = function(key, defaultk) {
    if (this.i18n[key] == undefined)
        return defaultk;

    return this.i18n[key];
};

AtDCore.prototype.addI18n = function(localizations) {
    this.i18n = localizations;
};

/*
 * Setters
 */

AtDCore.prototype.processJSON = function(responseJSON) {
    var json = jQuery.parseJSON(responseJSON);
    var incompleteResults = json.warnings && json.warnings.incompleteResults;
    this.suggestions = [];
    for (var key in json.matches) {
        if (key == '______array') continue
        var match = json.matches[key];
        var suggestion = {};
        // I didn't manage to make the CSS break the text, so we add breaks with Javascript:
        suggestion["description"] = this._wordwrap(match.message, 50, "<br/>");
        /*if (match.rule.category.id === 'DNV_SECONDARY_FORM') {
            suggestion["description"] = "Forma secundària.";
        }
        if (match.rule.category.id === 'DNV_COLLOQUIAL') {
            suggestion["description"] = "Paraula o expressió col·loquial.";
        }*/
        suggestion["suggestions"] = [];
        var suggestions = [];
        for (var k = 0; k < match.replacements.length; k++) {
            var repl = match.replacements[k];
            if (repl.value) {
                suggestions.push(repl.value);
            } else {
                wrongString = match.context.text.substring(match.context.offset, match.context.offset + match.length);
                suggestions.push("<REMOVE>"+wrongString);
            }
        }
        suggestion["suggestions"] = suggestions.join("#");
        suggestion["offset"]      = match.offset;
        suggestion["errorlength"] = match.length;
        suggestion["type"]        = match.rule.category.name;
        suggestion["ruleid"]      = match.rule.id;
        suggestion["subid"]       = match.rule.subId || 0;
        suggestion["its20type"]   = match.rule.issueType;
        suggestion["context"]     = match.sentence;
        suggestion["contextoffset"] = match.context.offset;
        var urls = match.rule.urls;
        if (urls && urls.length > 0) {
          if (urls[0].value) {
             suggestion["moreinfo"] = urls[0].value;
          }
          /*var k = 0;
          var done = false;
          while (!done && k<urls.length) {
            if (urls[k].value.indexOf(".gva.es") !== -1) {  //show only info from gva.es websites
              suggestion["moreinfo"] = urls[k].value;
              done = true;
            };
            k++;
          }*/
        }
        this.suggestions.push(suggestion);
    }
    return {suggestions: this.suggestions, incompleteResults: incompleteResults};
};

// Wrapper code by James Padolsey
// Source: http://james.padolsey.com/javascript/wordwrap-for-javascript/
// License: "This is free and unencumbered software released into the public domain.",
// see http://james.padolsey.com/terms-conditions/
AtDCore.prototype._wordwrap = function(str, width, brk, cut) {
    brk = brk || '\n';
    width = width || 75;
    cut = cut || false;
    if (!str) { return str; }
    var regex = '.{1,' +width+ '}(\\s|$)' + (cut ? '|.{' +width+ '}|.+$' : '|\\S+?(\\s|$)');
    return str.match( new RegExp(regex, 'g') ).join( brk );
};
// End of wrapper code by James Padolsey

AtDCore.prototype.findSuggestion = function(element) {
    var metaInfo = element.getAttribute(this.surrogateAttribute);
    var errorDescription = {};
    errorDescription["id"] = this.getSurrogatePart(metaInfo, 'id');
    errorDescription["subid"] = this.getSurrogatePart(metaInfo, 'subid');
    errorDescription["description"] = this.getSurrogatePart(metaInfo, 'description');
    errorDescription["coveredtext"] = this.getSurrogatePart(metaInfo, 'coveredtext');
    errorDescription["context"] = this.getSurrogatePart(metaInfo, 'context');
    errorDescription["contextoffset"] = this.getSurrogatePart(metaInfo, 'contextoffset');
    var suggestions = this.getSurrogatePart(metaInfo, 'suggestions');
    if (suggestions) {
        errorDescription["suggestions"] = suggestions.split("#");
    } else {
        errorDescription["suggestions"] = "";
    }
    var url = this.getSurrogatePart(metaInfo, 'url');
    if (url) {
        errorDescription["moreinfo"] = url;
    }
    return errorDescription;
};

/* 
 * code to manage highlighting of errors
 */
AtDCore.prototype.markMyWords = function() {
    var ed = tinyMCE.activeEditor;
    var textWithCursor = this.getPlainTextWithCursorMarker();
    var cursorPos = textWithCursor.indexOf("\ufeff");
    var newText = this.getPlainText();
  
    newText = newText.replace(/</g, "\ue001");
    newText = newText.replace(/>/g, "\ue002");
    
    var previousSpanStart = -1;
    // iterate backwards as we change the text and thus modify positions:
    for (var suggestionIndex = this.suggestions.length-1; suggestionIndex >= 0; suggestionIndex--) {
        var suggestion = this.suggestions[suggestionIndex];
        if (!suggestion.used) {
            var spanStart = suggestion.offset;
            var spanEnd = spanStart + suggestion.errorlength;
            if (previousSpanStart != -1 && spanEnd > previousSpanStart) {
                // overlapping errors - these are not supported by our underline approach,
                // as we would need overlapping <span>s for that, so skip the error:
                continue;
            }
            previousSpanStart = spanStart;
            
            var ruleId = suggestion.ruleid;
            if (this.ignoredRulesIds.indexOf(ruleId) !== -1) {
                continue;
            }
            var cssName;
            if (ruleId.indexOf("SPELLER_RULE") >= 0 || ruleId.indexOf("MORFOLOGIK_RULE") == 0 || ruleId == "HUNSPELL_NO_SUGGEST_RULE" || ruleId == "HUNSPELL_RULE") {
                cssName = "hiddenSpellError";
            } else if (suggestion.its20type === 'style' || suggestion.its20type === 'locale-violation' || suggestion.its20type === 'register') {
                cssName = "hiddenGreenError";
            } else {
                cssName = "hiddenGrammarError";
            }
            var delim = this.surrogateAttributeDelimiter;
            var coveredText = newText.substring(spanStart, spanEnd);
            if (this.ignoredSpellingErrors.indexOf(coveredText) !== -1) {
                continue;
            }
            var metaInfo = ruleId + delim + suggestion.subid + delim + suggestion.description + delim + suggestion.suggestions
              + delim + coveredText + delim + suggestion.context + delim + suggestion.contextoffset;;
            if (suggestion.moreinfo) {
                metaInfo += delim + suggestion.moreinfo;
            }
            metaInfo = metaInfo.replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/'/g, "&apos;")
                    .replace(/</g, "&lt;").replace(/>/g, "&gt;");  // escape HTML
            newText = newText.substring(0, spanStart)
                    + '<span ' + this.surrogateAttribute + '="' + metaInfo + '" class="' + cssName + '">'
                    + newText.substring(spanStart, spanEnd)
                    + '</span>'
                    + newText.substring(spanEnd);
            suggestion.used = true;
        }
    }
    
    // now insert a span into the location of the original cursor position,
    // only considering real text content of course:
    newText = this._insertCursorSpan(newText, cursorPos);
    
    newText = newText.replace(/^\n/, "");
    newText = newText.replace(/^\n/, "");
    newText = newText.replace(/\n/g, "<br/>");
    newText = newText.replace(/\ue001/g, '&lt;');
    newText = newText.replace(/\ue002/g, '&gt;');

    ed.setContent(newText);
    // now place the cursor where it was:
    ed.selection.select(ed.dom.select('span#caret_pos_holder')[0]);
    ed.dom.remove(ed.dom.select('span#caret_pos_holder')[0]);
};

AtDCore.prototype._insertCursorSpan = function(text, cursorPos) {
    var newTextParts = text.split(/([<>])/);
    var inTag = 0;
    var textPos = 0;
    var stringPos = 0;
    for (var i = 0; i < newTextParts.length; i++) {
        if (newTextParts[i] == "<" || newTextParts[i] == ">") {
            if (newTextParts[i] == "<") {
                inTag++;
            } else {
                inTag--;
            }
        } else if (inTag == 0) {
            var partLength = newTextParts[i].length;
            if (cursorPos >= textPos && cursorPos <= textPos + partLength) {
                var relativePos = cursorPos - textPos;
                text = text.insert(stringPos + relativePos, "<span id='caret_pos_holder'></span>");
                break;
            }
            textPos += partLength;
        }
        stringPos += newTextParts[i].length;
    }
    return text;
};

AtDCore.prototype.getSurrogatePart = function(surrogateString, part) {
    var parts = surrogateString.split(this.surrogateAttributeDelimiter);
    if (part == 'id') {
        return parts[0];
    } else if (part == 'subid') {
        return parts[1];
    } else if (part == 'description') {
        return parts[2];
    } else if (part == 'suggestions') {
        return parts[3];
    } else if (part == 'coveredtext') {
        return parts[4];
    } else if (part == 'context') {
        return parts[5];
    } else if (part == 'contextoffset') {
        return parts[6];
    } else if (part == 'url' && parts.length >= 7) {
        return parts[7];
    }
    console.log("No part '" + part + "' found in surrogateString: " + surrogateString);
    return null;
};

AtDCore.prototype.getPlainTextWithCursorMarker = function() {
    return this._getPlainText(false);
};

AtDCore.prototype.getPlainText = function() {
    return this._getPlainText(true);
};

AtDCore.prototype._getPlainText = function(removeCursor) {
    var plainText = tinyMCE.activeEditor.getContent({ format: 'raw' })
            .replace(/<p>/g, "\n\n")
            .replace(/<br>/g, "\n")
            .replace(/<br\s*\/>/g, "\n")
            .replace(/<.*?>/g, "")
            .replace(/&amp;/g, "&")
            .replace(/&lt;/g, "<")
            // TODO: using '>' still gets converted to '&gt;' for the user - with this line the HTML gets messed up when '<' or '>' are used in the text to check:
            .replace(/&gt;/g, ">") // buggy?
            .replace(/&nbsp;/g, " ");  // see issue #10
    if (removeCursor) {
        plainText = plainText.replace(/\ufeff/g, "");  // feff = 65279 = cursor code
    }
    return plainText;
};

AtDCore.prototype.removeWords = function(node, w) {
    var count = 0;
    var parent = this;

    this.map(this.findSpans(node).reverse(), function(n) {
        if (n && (parent.isMarkedNode(n) || parent.hasClass(n, 'mceItemHidden') || parent.isEmptySpan(n)) ) {
            if (n.innerHTML == '&nbsp;') {
                var nnode = document.createTextNode(' '); /* hax0r */
                parent.replaceWith(n, nnode);
            } else if (!w || n.innerHTML == w) {
                parent.removeParent(n);
                count++;
            }
        }
    });

    return count;
};

AtDCore.prototype.removeWordsByRuleId = function(node, ruleId, coveredText) {
    var count = 0;
    var parent = this;

    this.map(this.findSpans(node).reverse(), function(n) {
        if (n && (parent.isMarkedNode(n) || parent.hasClass(n, 'mceItemHidden') || parent.isEmptySpan(n)) ) {
            if (n.innerHTML == '&nbsp;') {
                var nnode = document.createTextNode(' '); /* hax0r */
                parent.replaceWith(n, nnode);
            } else {
                var surrogate = n.getAttribute(parent.surrogateAttribute);
                var textIsRelevant = coveredText ? parent.getSurrogatePart(surrogate, 'coveredtext') == coveredText : true;
                if (textIsRelevant && (surrogate && parent.getSurrogatePart(surrogate, 'id') == ruleId)) {
                    parent.removeParent(n);
                    count++;
                }
            }
        }
    });

    return count;
};

AtDCore.prototype.isEmptySpan = function(node) {
    return (this.getAttrib(node, 'class') == "" && this.getAttrib(node, 'style') == "" && this.getAttrib(node, 'id') == "" && !this.hasClass(node, 'Apple-style-span') && this.getAttrib(node, 'mce_name') == "");
};

AtDCore.prototype.isMarkedNode = function(node) {
    return (this.hasClass(node, 'hiddenGrammarError') || this.hasClass(node, 'hiddenSpellError') || this.hasClass(node, 'hiddenGreenError'));
};

/*
 * Context Menu Helpers
 */
AtDCore.prototype.applySuggestion = function(element, suggestion) {
    if (suggestion == '(omit)') {
        this.remove(element);
    }
    else {
        var node = this.create(suggestion);
        this.replaceWith(element, node);
        this.removeParent(node);
    }
};

/* 
 * Check for an error
 */
AtDCore.prototype.hasErrorMessage = function(xmlr) {
    return (xmlr != undefined && xmlr.getElementsByTagName('message').item(0) != null);
};

AtDCore.prototype.getErrorMessage = function(xmlr) {
    return xmlr.getElementsByTagName('message').item(0);
};

/* this should always be an error, alas... not practical */
AtDCore.prototype.isIE = function() {
    return navigator.appName == 'Microsoft Internet Explorer';
};
/*
 * TinyMCE Writing Improvement Tool Plugin 
 * Original Author: Raphael Mudge (raffi@automattic.com)
 * Heavily modified by Daniel Naber for LanguageTool (http://www.languagetool.org)
 *
 * http://www.languagetool.org
 * http://www.afterthedeadline.com
 *
 * Distributed under the LGPL
 *
 * Derived from:
 *    $Id: editor_plugin_src.js 425 2007-11-21 15:17:39Z spocke $
 *
 *    @author Moxiecode
 *    @copyright Copyright (C) 2004-2008, Moxiecode Systems AB, All rights reserved.
 *
 *    Moxiecode Spell Checker plugin released under the LGPL with TinyMCE
 */

(function() 
{
   var JSONRequest = tinymce.util.JSONRequest, each = tinymce.each, DOM = tinymce.DOM;
   var maxTextLength = 30000;

   tinymce.create('tinymce.plugins.AfterTheDeadlinePlugin', 
   {
      getInfo : function() 
      {
         return 
         ({
            longname :  'After The Deadline / LanguageTool',
            author :    'Raphael Mudge, Daniel Naber',
            authorurl : 'http://blog.afterthedeadline.com',
            infourl :   'http://www.afterthedeadline.com',
            version :   tinymce.majorVersion + "." + tinymce.minorVersion
         });
      },

      /* initializes the functions used by the AtD Core UI Module */
      initAtDCore : function(editor, plugin)
      {
         var core = new AtDCore();

         core.map = each;

         core.getAttrib = function(node, key) 
         { 
            return editor.dom.getAttrib(node, key); 
         };

         core.findSpans = function(parent) 
         {
            if (parent == undefined)
               return editor.dom.select('span');
            else
               return editor.dom.select('span', parent);
         };

         core.hasClass = function(node, className) 
         { 
            return editor.dom.hasClass(node, className); 
         };
         
         core.contents = function(node) 
         { 
            return node.childNodes;  
         };

         core.replaceWith = function(old_node, new_node) 
         { 
            return editor.dom.replace(new_node, old_node); 
         };

         core.create = function(node_html) 
         { 
            return editor.dom.create('span', { 'class': 'mceItemHidden' }, node_html);
         };

         core.removeParent = function(node) 
         {
            editor.dom.remove(node, 1);
            return node;
         };

         core.remove = function(node) 
         { 
            editor.dom.remove(node); 
         };

         core.getLang = function(key, defaultk) 
         { 
             return editor.getLang("AtD." + key, defaultk);
         };

         return core;
      },
 
      /* called when the plugin is initialized */
      init : function(ed, url) 
      {
         var t = this;
         var plugin  = this;
         var editor  = ed;
         var core = this.initAtDCore(editor, plugin);

         this.url    = url;
         this.editor = ed;
         this.menuVisible = false;
         ed.core = core;

         /* add a command to request a document check and process the results. */
         editor.addCommand('mceWritingImprovementTool', function(languageCode, userOptions)
         {
            
            if (plugin.menuVisible) {
              plugin._menu.hideMenu();
            }

            /* checks if a global var for click stats exists and increments it if it does... */
            if (typeof AtD_proofread_click_count != "undefined")
               AtD_proofread_click_count++;

            /* create the nifty spinny thing that says "hizzo, I'm doing something fo realz" */
            plugin.editor.setProgressState(1);
            
            /* remove the previous errors */
            plugin._removeWords();

            /* send request to our service */
            var textContent = plugin.editor.core.getPlainText();
            plugin.sendRequest('', textContent, languageCode, userOptions, function(data, request, jqXHR)
            {
               /* turn off the spinning thingie */
               plugin.editor.setProgressState(0);
               document.checkform._action_checkText.disabled = false;

               jQuery('#feedbackErrorMessage').html("");  // no severe errors, so clear that error area

               var results = core.processJSON(jqXHR.responseText);

               if (results.suggestions.length == 0) {

                  var lang = plugin.editor.getParam('languagetool_i18n_current_lang')();
                  var noErrorsText = plugin.editor.getParam('languagetool_i18n_no_errors')[lang] || "No errors were found.";
                  jQuery('#feedbackErrorMessage').html(noErrorsText);
               }
               else {
                  plugin.markMyWords();
                  ed.suggestions = results.suggestions; 
               }
                if (results.incompleteResults) {
                    jQuery('#feedbackErrorMessage').html("<div class='severeError'>These results may be incomplete due to a server timeout.</div>");
                }
            });
         });

         /* load cascading style sheet for this plugin */
          editor.onInit.add(function() 
         {
            /* loading the content.css file, why? I have no clue */
            if (editor.settings.content_css !== false)
            {
               editor.dom.loadCSS(editor.getParam("languagetool_css_url", url + '/css/content.css?v4'));
            }
         });

         /* again showing a menu, I have no clue what */
         editor.onClick.add(plugin._showMenu, plugin);
         
         /* strip out the markup before the contents is serialized (and do it on a copy of the markup so we don't affect the user experience) */
         editor.onPreProcess.add(function(sender, object) 
         {
            var dom = sender.dom;

            each(dom.select('span', object.node).reverse(), function(n) 
            {
               if (n && (dom.hasClass(n, 'hiddenGrammarError') || dom.hasClass(n, 'hiddenSpellError') || dom.hasClass(n, 'hiddenGreenError') || dom.hasClass(n, 'mceItemHidden') || (dom.getAttrib(n, 'class') == "" && dom.getAttrib(n, 'style') == "" && dom.getAttrib(n, 'id') == "" && !dom.hasClass(n, 'Apple-style-span') && dom.getAttrib(n, 'mce_name') == ""))) 
               {
                  dom.remove(n, 1);
               }
            });
         });

         /* cleanup the HTML before executing certain commands */
         editor.onBeforeExecCommand.add(function(editor, command) 
         {
            if (command == 'mceCodeEditor')
            {
               plugin._removeWords();
            }
            else if (command == 'mceFullScreen')
            {
               plugin._done();
            }
         });
      },

      createControl : function(name, controlManager) 
      {
      },

      _trackEvent : function(val1, val2, val3)
      {
          if (typeof(_paq) !== 'undefined') {
              // Piwik tracking
              _paq.push(['trackEvent', val1, val2, val3]);
          }
          this._logEventLocally();
      },

      _logEventLocally : function()
      {
          if (localStorage) {
              var actionCount = localStorage.getItem('actionCount');
              if (actionCount == null) {
                  actionCount = 0;
                  try {
                      localStorage.setItem('firstUse', new Date());  // get it back using new Date(Date.parse(localStorage.getItem('firstUse')))
                  } catch (ex) {
                      console.log("Could not store 'firstUse' to localStorage: " + ex);
                  }
              } else {
                  actionCount = parseInt(actionCount);
              }
              actionCount++;
              try {
                  localStorage.setItem('actionCount', actionCount);
              } catch (ex) {
                  console.log("Could not store 'actionCount' to localStorage: " + ex);
              }
          }
      },

      _getUUID : function()
      {
          return (
              [1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g,
              c => (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16));
      },

     _logUserEvents : function(type, errorDescription, suggestion, suggestion_position)
      {
        /*
        if (sc_settings && sc_settings.log_corrector_user_events) {
            var SC_COOKIE_UUID = 'sc-languagetool-feedback-uuid';

            var value = jQuery.getCookie(SC_COOKIE_UUID);
            if (value !== 'undefined') {
                var uuid = value;
            } else {
                var uuid = this._getUUID();
                jQuery.setCookie(SC_COOKIE_UUID, uuid);
            }

            var data = {"type": type,
                        "user_uuid" : uuid,
                        "rule_id": errorDescription["id"],
                        "rule_sub_id": errorDescription["subid"],
                        "incorrect_text": errorDescription["coveredtext"],
                        "incorrect_position": errorDescription["contextoffset"],
                        "context": errorDescription["context"],
                        "suggestion": suggestion,
                        "suggestion_position": suggestion_position};
            jQuery.ajax({
                url: 'https://api.softcatala.org/sc-languagetool-feedback/v1/log',
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
            });
          }
        */
      },
       
      _removeWords : function(w) 
      {
         var ed = this.editor, dom = ed.dom, se = ed.selection, b = se.getBookmark();

         ed.core.removeWords(undefined, w);

         /* force a rebuild of the DOM... even though the right elements are stripped, the DOM is still organized
            as if the span were there and this breaks my code */

         dom.setHTML(dom.getRoot(), dom.getRoot().innerHTML);

         se.moveToBookmark(b);
      },

      _removeWordsByRuleId : function(ruleId, coveredText)
      {
         var ed = this.editor, dom = ed.dom, se = ed.selection, b = se.getBookmark();

         ed.core.removeWordsByRuleId(undefined, ruleId, coveredText);

         /* force a rebuild of the DOM... even though the right elements are stripped, the DOM is still organized
            as if the span were there and this breaks my code */

         dom.setHTML(dom.getRoot(), dom.getRoot().innerHTML);

         se.moveToBookmark(b);
      },

      markMyWords : function()
      {
         var ed  = this.editor;
         var se = ed.selection, b = se.getBookmark();

         ed.core.markMyWords();

         se.moveToBookmark(b);
      },

      _doNotShowMenu : function(ed, e) 
      {
        return tinymce.dom.Event.cancel(e);
      },
       
      _showMenu : function(ed, e) 
      {
        
         if (e.which == 3) {
            // ignore right mouse button
            return;
         }
         var t = this, ed = t.editor, m = t._menu, p1, dom = ed.dom, vp = dom.getViewPort(ed.getWin());
         var plugin = this;

         if (!m) 
         {
            p1 = DOM.getPos(ed.getContentAreaContainer());
            //p2 = DOM.getPos(ed.getContainer());

            m = ed.controlManager.createDropMenu('spellcheckermenu', 
            {
               offset_x : p1.x,
               offset_y : p1.y,
               'class' : 'mceNoIcons'
            });

            t._menu = m;
         }
         
         if (this.menuVisible) {
             // second click: close popup again
             m.hideMenu();
             this.menuVisible = false;
             return;
         }

         if (ed.core.isMarkedNode(e.target))
         {
            /* remove these other lame-o elements */
            m.removeAll();

            /* find the correct suggestions object */
            var errorDescription = ed.core.findSuggestion(e.target);
            var ruleId = errorDescription["id"];
            var lang = plugin.editor.getParam('languagetool_i18n_current_lang')();

            t._logUserEvents('OpenError', errorDescription, "", -1);

            if (errorDescription == undefined)
            {
               m.add({title : plugin.editor.getLang('AtD.menu_title_no_suggestions', 'No suggestions'), 'class' : 'mceMenuItemTitle'}).setDisabled(1);
            }
            else if (errorDescription["suggestions"].length == 0)
            {
               m.add({title : errorDescription["description"], 'class' : 'mceMenuItemTitle'}).setDisabled(1);
            }
            else
            {
               m.add({ title : errorDescription["description"], 'class' : 'mceMenuItemTitle' }).setDisabled(1);

               for (var i = 0; i < errorDescription["suggestions"].length; i++)
               {
                  if (i >= 10) { //max number of suggestions shown
                      break;
                  }
                  (function(sugg)
                   {
                      var iTmp = i;
                      var titlesugg = sugg;
                      if (sugg.startsWith("<REMOVE>")) {
                           titlesugg = '<span style="text-decoration-line: line-through;">&nbsp;'+sugg.slice(8)+'&nbsp;</span>';
                           sugg = "";
                       }

                      m.add({
                         title   : titlesugg, 
                         onclick : function() 
                         {
                            ed.core.applySuggestion(e.target, sugg);
                            //t._trackEvent('AcceptCorrection', lang, ruleId);
                            t._logUserEvents('AcceptCorrection', errorDescription, sugg, iTmp);
                            t._checkDone();
                         }
                      });
                   })(errorDescription["suggestions"][i]);
               }

               m.addSeparator();
            }
             
            var explainText = plugin.editor.getParam('languagetool_i18n_explain')[lang] || "Explain...";
            var ignoreThisText = plugin.editor.getParam('languagetool_i18n_ignore_once')[lang] || "Ignore this type of error";
            var editManually = plugin.editor.getParam('languagetool_i18n_edit_manually')[lang] || "Edit manually";
            var ruleExamples = "Examples...";
            if (plugin.editor.getParam('languagetool_i18n_rule_examples')) {
              ruleExamples = plugin.editor.getParam('languagetool_i18n_rule_examples')[lang] || "Examples...";
            }
            var noRuleExamples = "Sorry, no examples found for this rule.";
            if (plugin.editor.getParam('languagetool_i18n_rule_no_examples')) {
              noRuleExamples = plugin.editor.getParam('languagetool_i18n_rule_no_examples')[lang] || "Sorry, no examples found for this rule.";
            }
            var ruleImplementation = "Rule implementation...";
            if (plugin.editor.getParam('languagetool_i18n_rule_implementation')) {
              ruleImplementation = plugin.editor.getParam('languagetool_i18n_rule_implementation')[lang] || "Rule implementation...";
            }
            var suggestWord = "Suggest word for dictionary...";
            if (plugin.editor.getParam('languagetool_i18n_suggest_word')) {
              suggestWord = plugin.editor.getParam('languagetool_i18n_suggest_word')[lang] || "Suggest word for dictionary...";
            }
            var suggestWordUrl;
            if (plugin.editor.getParam('languagetool_i18n_suggest_word_url')) {
              suggestWordUrl = plugin.editor.getParam('languagetool_i18n_suggest_word_url')[lang];
            }
            var isSpellingRule = ruleId.indexOf("MORFOLOGIK_RULE") != -1 || ruleId.indexOf("SPELLER_RULE") != -1 ||
                                 ruleId.indexOf("HUNSPELL_NO_SUGGEST_RULE") != -1 || ruleId.indexOf("HUNSPELL_RULE") != -1;

            if (suggestWord && suggestWordUrl && isSpellingRule) {
              var newUrl = suggestWordUrl.replace(/{word}/, encodeURIComponent(errorDescription['coveredtext']));
              (function(url)
              {
                m.add({
                  title : suggestWord,
                  onclick : function() { window.open(newUrl, '_suggestWord'); }
                });
              })(errorDescription[suggestWord]);
              m.addSeparator();
            }

            if (errorDescription != undefined && errorDescription["moreinfo"] != null)
            {
               (function(url)
                {
                   m.add({
                     title : explainText,
                     onclick : function() { window.open(url, '_errorExplain'); }
                  });
               })(errorDescription["moreinfo"]);
               m.addSeparator();
            }

            m.add({
               title : editManually,
               onclick : function() 
               {
                  dom.remove(e.target, 1);
                  t._logUserEvents('EditManually', errorDescription, '', -1);
                  t._checkDone();
               }
            });

            m.add({
               title : ignoreThisText,
               onclick : function() 
               {
                  dom.remove(e.target, 1);
                  t._logUserEvents('IgnoreRule', errorDescription, '', -1);
                  t._checkDone();
               }
            });

             var langCode = jQuery('#lang').val();
             var subLangCode = jQuery('#subLang').val();
             if (subLangCode) {
                 langCode = langCode.replace(/-.*/, "") + "-" + subLangCode;
             }
            // NOTE: this link won't work (as of March 2014) for false friend rules:
            var ruleUrl = "http://community.languagetool.org/rule/show/" +
              encodeURI(errorDescription["id"]) + "?";
            if (errorDescription["subid"] && errorDescription["subid"] !== 'null' && errorDescription["subid"] !== "undefined") {
              ruleUrl += "subId=" + encodeURI(errorDescription["subid"]) + "&";
            }
            ruleUrl += "lang=" + encodeURI(langCode);
            /*var isLTServer = window.location.href.indexOf("languagetool.org") !== -1 || window.location.href.indexOf("languagetool.localhost") !== -1;  // will only work for lt.org because
            if (isLTServer && errorDescription["id"].indexOf("MORFOLOGIK_") !== 0 && errorDescription["id"] !== "HUNSPELL_NO_SUGGEST_RULE") {  // no examples available for spell checking rules
                m.addSeparator();
                m.add({
                    title : ruleExamples,
                    onclick : function() {
                        plugin.editor.setProgressState(1);
                        jQuery.getJSON("/online-check/tiny_mce/plugins/atd-tinymce/server/rule-proxy.php?lang="
                            + encodeURI(langCode) +"&ruleId=" + errorDescription["id"],
                            function(data) {
                                var ruleHtml = "";
                                var exampleCount = 0;
                                jQuery.each(data['results'], function(key, val) {
                                    if (val.sentence && val.status === 'incorrect' && exampleCount < 5) {
                                        ruleHtml += "<span class='example'>";
                                        ruleHtml += "<img src='/images/cancel.png'>&nbsp;" +
                                            val.sentence.replace(/<marker>(.*?)<\/marker>/, "<span class='error'>$1</span>") + "<br>";
                                        // if there are more corrections we cannot be sure they're all good, so don't show any:
                                        if (val.corrections && val.corrections.length === 1 && val.corrections[0] !== '') {
                                            var escapedCorr = jQuery('<div/>').text(val.corrections[0]).html();
                                            ruleHtml += "<img src='/images/check.png'>&nbsp;";
                                            ruleHtml += val.sentence.replace(/<marker>(.*?)<\/marker>/, escapedCorr) + "<br>";
                                        }
                                        ruleHtml += "</span>";
                                        ruleHtml += "<br>";
                                        exampleCount++;
                                    }
                                });
                                if (exampleCount === 0) {
                                    ruleHtml += "<p>" + noRuleExamples + "</p>";
                                    t._trackEvent('ShowExamples', 'NoExamples', ruleId);
                                }
                                ruleHtml += "<p><a target='_lt_rule_details' href='" + ruleUrl + "'>" + ruleImplementation + "</a></p>";
                                var $dialog = jQuery("#dialog");
                                $dialog.html(ruleHtml);
                                $dialog.dialog("open");
                            }).fail(function(e) {
                                var $dialog = jQuery("#dialog");
                                $dialog.html("Sorry, could not get rules. Server returned error code " + e.status + ".");
                                $dialog.dialog("open");
                                t._trackEvent('ShowExamples', 'ServerError');
                            }).always(function() {
                                plugin.editor.setProgressState(0);
                                t._trackEvent('ShowExamples', 'ShowExampleSentences', ruleId);
                            });
                    }
                });
            }*/

           /* show the menu please */
           ed.selection.select(e.target);
           p1 = dom.getPos(e.target);
           var xPos = p1.x;

           // moves popup a bit down to not overlap text:
           //TODO: why is this needed? why does the text (tinyMCE content) have a slightly lower start position in Firefox?
           var posWorkaround = 0;
           if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
             posWorkaround = 10;
           } else {
             posWorkaround = 2;
           }
           
           m.showMenu(xPos, p1.y + e.target.offsetHeight - vp.y + posWorkaround);
           this.menuVisible =  true;
           var menuDiv = jQuery('#menu_checktext_spellcheckermenu_co');
           if (menuDiv) {
               var menuWidth = menuDiv.width();
               var textBoxWidth = jQuery('#checktextpara').width();  // not sure why we cannot directly use the textarea's width
               if (xPos + menuWidth > textBoxWidth) {
                   // menu runs out of screen, move it to the left
                   var diff = xPos + menuWidth - textBoxWidth;
                   menuDiv.css({ left: '-' + diff + 'px' });
               } else {
                   menuDiv.css({ left: '0px' });
               }
           }

           return tinymce.dom.Event.cancel(e);
         } 
         else
         {
            m.hideMenu();
            this.menuVisible = false;
         }
      },

      /* loop through editor DOM, call _done if no mce tags exist. */
      _checkDone : function() 
      {
         var t = this, ed = t.editor, dom = ed.dom, o;

         this.menuVisible = false;
          
         each(dom.select('span'), function(n) 
         {
            if (n && dom.hasClass(n, 'mceItemHidden'))
            {
               o = true;
               return false;
            }
         });

         if (!o)
         {
            t._done();
         }
      },

      /* remove all tags, hide the menu, and fire a dom change event */
      _done : function() 
      {
         var plugin    = this;
         //plugin._removeWords();

         if (plugin._menu)
         {
            plugin._menu.hideMenu();
            this.menuVisible = false;
         }

         plugin.editor.nodeChanged();
      },

      sendRequest : function(file, data, languageCode, userOptions, success)
      {
         var url = this.editor.getParam("languagetool_rpc_url", "{backend}");
         var plugin = this;

         if (url == '{backend}') 
         {
            this.editor.setProgressState(0);
            document.checkform._action_checkText.disabled = false;
            alert('Please specify: languagetool_rpc_url');
            return;
         }

         var langParam = "";
         if (languageCode === "auto") {
             langParam = "&language=auto";
         } else {
             langParam = "&language=" + encodeURI(languageCode);
         }

         var t = this;
         // There's a bug somewhere in AtDCore.prototype.markMyWords which makes
         // multiple spaces vanish - thus disable that rule to avoid confusion: WHITESPACE_RULE,
         var postData = userOptions + "&" +
             "allowIncompleteResults=true&" + 
             "text=" + encodeURI(data).replace(/&/g, '%26').replace(/\+/g, '%2B').replace(/&gt;/g, '%3E') + langParam;

         jQuery.ajax({
            url:   url,
            type:  "POST",
            data:  postData,
            success: success,
            error: function(jqXHR, textStatus, errorThrown) {
                // try again
                //t._serverLog("Error on first try, trying again...");
                setTimeout(function() {
                    jQuery.ajax({
                        url:   url,
                        type:  "POST",
                        data:  postData,
                        success: success,
                        error: function(jqXHR, textStatus, errorThrown) {
                            plugin.editor.setProgressState(0);
                            document.checkform._action_checkText.disabled = false;
                            var errorText = jqXHR.responseText;
                            //if (!errorText) {
                            errorText = "Error: el servei no respon. Proveu més tard. " 
                              + "Consulteu: "
                              + "<a href=\"https://www.softcatala.org/tutorials/configuracio-dels-navegadors/problemes-amb-els-certificats-per-a-accedir-a-la-web-en-mode-segur/\">problemes amb els certificats</a> "
                              + " i <a href=\"https://www.softcatala.org/wiki/Projectes/LanguageTool/PMF\">preguntes més freqüents</a>.";
                            //}
                            if (data.length > maxTextLength) {
                                // Somehow, the error code 413 is lost in Apache, so we show that error here.
                                // This unfortunately means that the limit needs to be configured in the server *and* here.
                                errorText = "Error: el text és massa llarg (" + data.length + " caràcters). Màxim: " + maxTextLength + " caràcters.";
                            }
                            jQuery('#feedbackErrorMessage').html("<div class='severeError'>" + errorText + "</div>");
                            //t._trackEvent('CheckError', 'ErrorWithException', errorText);
                            //t._serverLog(errorText + " (second try)");
                        }
                    });
                }, 500);
            }
         });

         /* this causes an OPTIONS request to be send as a preflight - LT server doesn't support that,
         thus we're using jQuery.ajax() instead
         tinymce.util.XHR.send({
            url          : url,
            content_type : 'text/xml',
            type         : "POST",
            data         : "text=" + encodeURI(data).replace(/&/g, '%26').replace(/\+/g, '%2B')
                           + langParam
                           // there's a bug somewhere in AtDCore.prototype.markMyWords which makes
                           // multiple spaces vanish - thus disable that rule to avoid confusion:
                           + "&disabled=WHITESPACE_RULE",
            async        : true,
            success      : success,
            error        : function( type, req, o )
            {
               plugin.editor.setProgressState(0);
               document.checkform._action_checkText.disabled = false;
               var errorMessage = "<div id='severeError'>Error: Could not send request to\n" + o.url + "\nError: " + type + "\nStatus code: " + req.status + "\nPlease make sure your network connection works.</div>";
               jQuery('#feedbackErrorMessage').html(errorMessage);
            }
         });*/
      }
   });

   // Register plugin
   tinymce.PluginManager.add('AtD', tinymce.plugins.AfterTheDeadlinePlugin);
})();