<?php

/**
 * ThreeCol
 *
 * Plugin to switch Roundcube to a three column layout
 *
 * @version 0.1
 * @author Philip Weir
 */
class threecol extends rcube_plugin
{
	public $task = 'mail|settings';
	private $driver;

	function init()
	{
		$rcmail = rcmail::get_instance();
		$no_override = array_flip($rcmail->config->get('dont_override', array()));
		$this->driver = $this->home .'/skins/'. $rcmail->config->get('skin') .'/func.php';

		if (is_readable($this->driver)) {
			if ($rcmail->task == 'mail' && $rcmail->action == '' && $rcmail->config->get('previewpane_layout', 'below') == 'right') {
					$this->add_hook('render_page', array($this, 'render'));
					$this->include_script($this->local_skin_path() .'/threecol.js');
					$this->include_stylesheet($this->local_skin_path() .'/threecol.css');
			}
			elseif ($rcmail->task == 'settings' && !isset($no_override['previewpane_layout'])) {
				$this->add_hook('preferences_list', array($this, 'show_settings'));
				$this->add_hook('preferences_save', array($this, 'save_settings'));
			}
		}
		else {
			raise_error(array(
				'code' => 600,
				'type' => 'php',
				'file' => __FILE__,
				'line' => __LINE__,
				'message' => "ThreeCol plugin: Unable to open driver file $this->driver"
				), true, false);
		}
	}

	function render($args)
	{
		include_once($this->driver);

		if (!function_exists('render_page')) {
			raise_error(array(
				'code' => 600,
				'type' => 'php',
				'file' => __FILE__,
				'line' => __LINE__,
				'message' => "ThreeCol plugin: Broken driver: $this->driver"
				), true, false);
		}

		$args = render_page($args);

		return $args;
	}

	function show_settings($args)
	{
		if ($args['section'] == 'mailbox') {
			$this->add_texts('localization/');

			$field_id = 'rcmfd_previewpane_layou';
			$select = new html_select(array('name' => '_previewpane_layout', 'id' => $field_id));
			$select->add(Q($this->gettext('threecol.below')), 'below');
			$select->add(Q($this->gettext('threecol.right')), 'right');

			// add new option at the top of the list
			$orig = $args['blocks']['main']['options'];
			$tmp['previewpane_layou'] = array(
				'title' => Q($this->gettext('threecol.title')),
				'content' => $select->show(rcmail::get_instance()->config->get('previewpane_layout')),
			);

			$args['blocks']['main']['options'] = array_merge($tmp, $orig);
		}

		return $args;
	}

	function save_settings($args)
	{
		if ($args['section'] == 'mailbox')
			$args['prefs']['previewpane_layout'] = isset($_POST['_previewpane_layout']) ? get_input_value('_previewpane_layout', RCUBE_INPUT_POST) : rcmail::get_instance()->config->get('previewpane_layout', 'below');

		return $args;
	}
}

?>