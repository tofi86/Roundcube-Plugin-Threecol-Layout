<?php

/**
 * ThreeCol Classic driver
 * @version 1.0
 * @author Philip Weir
 */
function render_page($args)
{
	$patterns = array();
	$patterns[0] = '/#mailcontframe \{ height: [0-9]+px; \}/';
	$patterns[1] = '/#mailpreviewframe { top: [0-9]+px;/';
	$patterns[2] = '/height: expression\(\(parseInt\(this.parentNode.offsetHeight\)\-[0-9]+\)\+\'px\'\);/';
	$patterns[3] = '/rcube_init_mail_ui\(\)/';
	$patterns[4] = '/rcube_splitter\(\{id:\'mailviewsplitter\', p1: \'mailcontframe\', p2: \'mailpreviewframe\', orientation: \'h\', relative: true, start: 205\}\)/';

	$replacements = array();
	$replacements[0] = '#mailcontframe { width: ' . (!empty($_COOKIE['mailviewsplittertc']) ? $_COOKIE['mailviewsplittertc']-5 . 'px' : '100%') . '; }';
	$replacements[1] = '#mailpreviewframe { ' . (rcmail::get_instance()->output->browser->ie ? ('width: expression((parseInt(this.parentNode.offsetHeight)-'.(!empty($_COOKIE['mailviewsplittertc']) ? $_COOKIE['mailviewsplittertc'] + 25 : 645).')+\\\'px\\\');') : '');
	$replacements[2] = '';
	$replacements[3] = 'rcube_init_mail_ui(); override_switch_preview_pane()';
	$replacements[4] = 'rcube_splitter({id:\'mailviewsplittertc\', p1: \'mailcontframe\', p2: \'mailpreviewframe\', orientation: \'v\', relative: true, start: 700});';

	$args['content'] = preg_replace($patterns, $replacements, $args['content']);

	return $args;
}

?>