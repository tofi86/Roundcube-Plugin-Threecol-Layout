<?php

/**
 * ThreeCol Larry driver
 * @version 1.0
 * @author Philip Weir
 */
function render_page($args)
{
	$patterns = array();
	$patterns[0] = '/#mailview-top \{ height: [0-9]+px; \}/';
	$patterns[1] = '/#mailview-bottom \{ top: [0-9]+px; height: auto; \}/';
	$patterns[2] = '/id="mailview-top"/';
	$patterns[3] = '/id="mailview-bottom"/';
	$patterns[4] = '/<div id="message" class="statusbar"><\/div>/';
	$patterns[5] = '/<\/div><\!\-\- end mailview\-top \-\->/';
	$patterns[6] = '/UI.init\(\);/';

	$replacements = array();
	$replacements[0] = '#mailview-tc-mid { width: ' . (!empty($_COOKIE['mailviewsplittertc']) ? $_COOKIE['mailviewsplittertc']-5 : 700) . 'px; }';
	$replacements[1] = '#mailview-tc-right { left: ' . (!empty($_COOKIE['mailviewsplittertc']) ? $_COOKIE['mailviewsplittertc']+7 : 700) . 'px; display: block; }';
	$replacements[2] = 'id="mailview-tc-mid"';
	$replacements[3] = 'id="mailview-tc-right"';
	$replacements[4] = '';
	$replacements[5] = '<div id="message" class="statusbar"></div></div><!-- end mailview-top -->';
	$replacements[6] = 'UI.init(); init_threecol_splitter();';

	$args['content'] = preg_replace($patterns, $replacements, $args['content']);

	return $args;
}

?>