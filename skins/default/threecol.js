/**
 * ThreeCol plugin script
 */

function override_switch_preview_pane() {
	rcmail_ui.switch_preview_pane = function(elem)
	{
		var uid, prev_frm = $('#mailpreviewframe');

		if (elem.checked) {
			rcmail.env.contentframe = 'messagecontframe';
			if (mailviewsplit.layer) {
				mailviewsplit.resize();
				mailviewsplit.layer.elm.style.display = '';
			}
			else
				mailviewsplit.init();

			if (bw.opera) {
				$('#messagelistcontainer').css({width: ''});
			}
			prev_frm.show();

			if (uid = rcmail.message_list.get_single_selection())
				rcmail.show_message(uid, false, true);
		}
		else {
			prev_frm.hide();
			if (bw.ie6 || bw.ie7) {
				var fr = document.getElementById('mailcontframe');
				fr.style.right = 0;
				fr.style.width = parseInt(fr.parentNode.offsetWidth)+'px';
			}
			else {
				$('#mailcontframe').css({width: '100%'});
				if (bw.opera)
					$('#messagelistcontainer').css({width: '100%'});
			}
			if (mailviewsplit.layer)
				mailviewsplit.layer.elm.style.display = 'none';

			rcmail.env.contentframe = null;
			rcmail.show_contentframe(false);
		}

		rcmail.command('save-pref', {name: 'preview_pane', value: (elem.checked?1:0)});
	}
}