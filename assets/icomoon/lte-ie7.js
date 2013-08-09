/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-search' : '&#xf002;',
			'icon-envelope' : '&#xf003;',
			'icon-heart' : '&#xf004;',
			'icon-star' : '&#xf005;',
			'icon-star-empty' : '&#xf006;',
			'icon-user' : '&#xf007;',
			'icon-ok' : '&#xf00c;',
			'icon-remove' : '&#xf00d;',
			'icon-home' : '&#xf015;',
			'icon-time' : '&#xf017;',
			'icon-tag' : '&#xf02b;',
			'icon-tags' : '&#xf02c;',
			'icon-map-marker' : '&#xf041;',
			'icon-pencil' : '&#xf040;',
			'icon-chevron-left' : '&#xf053;',
			'icon-chevron-right' : '&#xf054;',
			'icon-pause' : '&#xf04c;',
			'icon-play' : '&#xf04b;',
			'icon-step-backward' : '&#xf048;',
			'icon-fast-backward' : '&#xf049;',
			'icon-backward' : '&#xf04a;',
			'icon-stop' : '&#xf04d;',
			'icon-forward' : '&#xf04e;',
			'icon-fast-forward' : '&#xf050;',
			'icon-step-forward' : '&#xf051;',
			'icon-facebook' : '&#xf09a;',
			'icon-twitter' : '&#xf099;',
			'icon-calendar' : '&#xf073;',
			'icon-chevron-up' : '&#xf077;',
			'icon-chevron-down' : '&#xf078;',
			'icon-thumbs-up' : '&#xf087;',
			'icon-thumbs-down' : '&#xf088;',
			'icon-comments' : '&#xf086;',
			'icon-google-plus' : '&#xf0d5;',
			'icon-lightbulb' : '&#xf0eb;',
			'icon-linkedin' : '&#xf0e1;',
			'icon-sort-down' : '&#xf0dd;',
			'icon-envelope-alt' : '&#xf0e0;',
			'icon-sort-up' : '&#xf0de;',
			'icon-sort' : '&#xf0dc;',
			'icon-caret-right' : '&#xf0da;',
			'icon-caret-left' : '&#xf0d9;',
			'icon-caret-up' : '&#xf0d8;',
			'icon-caret-down' : '&#xf0d7;',
			'icon-angle-left' : '&#xf104;',
			'icon-angle-right' : '&#xf105;',
			'icon-angle-up' : '&#xf106;',
			'icon-angle-down' : '&#xf107;',
			'icon-double-angle-down' : '&#xf103;',
			'icon-double-angle-left' : '&#xf100;',
			'icon-double-angle-right' : '&#xf101;',
			'icon-paper-clip' : '&#xf0c6;',
			'icon-circle-arrow-left' : '&#xf0a8;',
			'icon-circle-arrow-right' : '&#xf0a9;',
			'icon-circle-arrow-up' : '&#xf0aa;',
			'icon-circle-arrow-down' : '&#xf0ab;',
			'icon-globe' : '&#xf0ac;',
			'icon-quote-left' : '&#xf10d;',
			'icon-quote-right' : '&#xf10e;',
			'icon-spinner' : '&#xf110;',
			'icon-arrow-left' : '&#xf060;',
			'icon-arrow-right' : '&#xf061;',
			'icon-arrow-up' : '&#xf062;',
			'icon-arrow-down' : '&#xf063;',
			'icon-plus' : '&#xf067;',
			'icon-minus' : '&#xf068;',
			'icon-ok-sign' : '&#xf058;',
			'icon-remove-sign' : '&#xf057;',
			'icon-minus-sign' : '&#xf056;',
			'icon-plus-sign' : '&#xf055;',
			'icon-question-sign' : '&#xf059;',
			'icon-info-sign' : '&#xf05a;',
			'icon-ban-circle' : '&#xf05e;',
			'icon-comment' : '&#xf075;',
			'icon-gift' : '&#xe000;',
			'icon-apply' : '&#xe001;',
			'icon-iphone' : '&#xe003;',
			'icon-wse-email' : '&#xe002;',
			'icon-external' : '&#xe004;',
			'icon-youtube' : '&#xe005;',
			'icon-circle' : '&#xf111;',
			'icon-circle-blank' : '&#xf10c;',
			'icon-radio-unchecked' : '&#xe006;',
			'icon-world' : '&#xe007;',
			'icon-profile' : '&#xe008;',
			'icon-mortarboard' : '&#xe009;',
			'icon-backarrow' : '&#xe00a;',
			'icon-info' : '&#xe00b;',
			'icon-part-time' : '&#xe00c;',
			'icon-double-angle-up' : '&#xf102;',
			'icon-file-pdf' : '&#xe00d;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};