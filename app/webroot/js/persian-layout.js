// jkblayout.js (jQuery version of kblayout.js)
// Copyright (C) 2009 M. Mahdi Hasheminezhad (hasheminezhad at gmail dot com)
// Cross-Browser keyboard layout switcher with support of new layouts
// This source is licensed under Common Public License Version 1.0 (CPL) 
// History:
// 2009-08-30 First Public Release M. Mahdi Hasheminezhad (http://hasheminezhad.com)

var keyboardLayout = {};
var langCycle = [''];

(function($) {
    var k = null;
    var titleTimeout = null;

    function showLang(langIndex) {
        var langTitle = 'Language: ';
        for(var i=0;i<langCycle.length;i++) {
            var lang = getLangFromCycle(i) || 'default';
            langTitle += (i == langIndex ? '['+lang+']' : lang) + ' ';
        }

        if(titleTimeout) clearTimeout(titleTimeout);
        document.oldTitle = document.oldTitle || document.title;
        document.title = langTitle;
        titleTimeout = setTimeout(function() {
            document.title = document.oldTitle;
            document.oldTitle = undefined;
            titleTimeout = null;
        }, 1000);
    }

    function getLangFromCycle(i) {
        return langCycle[i].lang ? langCycle[i].lang : langCycle[i];
    }

    function getDirectionFromCycle(i) {
        return langCycle[i].direction ? langCycle[i].direction : '';
    }

    function getNextLangIndex (targetLang) {
        var nextIndex = langCycle.length ? 0 : -1;
        for(var i=0; i < langCycle.length; i++){
            if(getLangFromCycle(i) == targetLang){
                nextIndex = i < langCycle.length-1 ? i + 1 : 0;
            }
        }
        return nextIndex;
    }

    $('input[type=text]:not(".input-eng, #recaptcha_response_field"), textarea:not(".input-eng")').live('keydown', function (e) {
        k = e.which;
	var $this = $(this);
	
	lang = $this.attr('lang').match(/^[a-zA-Z]{2}/) || 'fa'; //lang is just two chars like: en, fa, ...
        if(!lang){
            if(!langCycle.length) return true;
            lang = getLangFromCycle(0);
        }
	
	// Ctrl+Shift changes language (just if there's any cycle available)
        if (e.ctrlKey && e.shiftKey && langCycle && langCycle.length > 1) {
            var nextLangIndex = getNextLangIndex(lang);
            if(nextLangIndex >= 0){
                showLang(nextLangIndex);
                $this.attr('lang', getLangFromCycle(nextLangIndex));
                $this.css('direction', getDirectionFromCycle(nextLangIndex));
            }
            e.preventDefault();
            return false;
        }
	
    }).live('keypress', function (e) {
        var $this = $(this);

        var layout = keyboardLayout[lang];
        if ((!layout) ||
            (e.ctrlKey || e.altKey || e.metaKey) ||
            (k != 0x0020 && k < 0x0030) ||  //fix for opera
            (e.which < 0x0020 || e.which > 0x007F))
            return true;

        var value =
            (e.which == 0x0020 && e.shiftKey && layout[0x005f]) ||  //Shift+Space may be defined in layout[0x5f]
            (layout[e.which - 0x0020]);

        value = typeof value=='string'?
            value:
            String.fromCharCode(value);

        var ds = document.selection,
            ss = this.selectionStart;

        if (typeof ss == 'number') { //standard browsers: http://www.w3.org/TR/html5/editing.html#dom-textarea-input-selectionstart
	        var sl = this.scrollLeft, st = this.scrollTop;  //fix for firefox
	        this.value = this.value.substring(0, ss) + value + this.value.substring(this.selectionEnd, this.value.length);
	        var sr = ss + value.length;
	        this.setSelectionRange(sr, sr);
            this.scrollLeft = sl;
            this.scrollTop = st;
        } else if (ds) { //IE: http://msdn.microsoft.com/en-us/library/ms535869(VS.85).aspx
	        var r = ds.createRange();
	        r.text = value;
            r.setEndPoint('StartToEnd', r);
            r.select();
        } else { //unknown browsers
	        this.value += value;
        }

        e.preventDefault();
    });
})(jQuery);


// kblayout.fa.js
// Standard farsi layout for kblayout.js
// M. Mahdi Hasheminezhad (hasheminezhad at gmail dot com)
keyboardLayout['fa'] = [
  0x0020, 0x0021, 0x061b, 0x066b, 0xfdfc, 0x066a, 0x060c, 0x06af, 0x0029, 0x0028, 0x002a, 0x002b, 0x0648, 0x002d, 0x002e, 0x002f,
  0x0030, 0x0031, 0x0032, 0x0033, 0x0034, 0x0035, 0x0036, 0x0037, 0x0038, 0x0039, 0x003a, 0x06a9, 0x003e, 0x003d, 0x003c, 0x061f,
  0x066c, 0x0624, 0x200c, 0x0698, 0x064a, 0x064d, 0x0625, 0x0623, 0x0622, 0x0651, 0x0629, 0x00bb, 0x00ab, 0x0621, 0x0654, 0x005d,
  0x005b, 0x0652, 0x064b, 0x0626, 0x064f, 0x064e, 0x0670, 0x064c, 0x0653, 0x0650, 0x0643, 0x062c, 0x005c, 0x0686, 0x00d7, 0x0640,
  0x200d, 0x0634, 0x0630, 0x0632, 0x06cc, 0x062b, 0x0628, 0x0644, 0x0627, 0x0647, 0x062a, 0x0646, 0x0645, 0x067e, 0x062f, 0x062e,
  0x062d, 0x0636, 0x0642, 0x0633, 0x0641, 0x0639, 0x0631, 0x0635, 0x0637, 0x063a, 0x0638, 0x007d, 0x007c, 0x007b, 0x00f7, 0x200C
];
langCycle.push({lang: 'fa', direction: 'rtl'});
langCycle.push({lang: 'en', direction: 'ltr'});
