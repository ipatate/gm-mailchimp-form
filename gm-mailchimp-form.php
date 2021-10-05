<?php

namespace GMMailchimpForm;

/**
 * Plugin Name:       Gm Mailchimp Form
 * Description:       This plugin allows you to display a Block for newsletter form subscription.
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Faramaz Patrick <infos@goodmotion.fr>
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gm-mailchimp-form
 *
 * @package           goodmotion
 */

require_once(dirname(__FILE__) . '/includes/form.php');
require_once(dirname(__FILE__) . '/includes/config_panel.php');
require_once(dirname(__FILE__) . '/includes/token.php');
require_once(dirname(__FILE__) . '/includes/render_callback.php');


$PLUGIN_NAME = 'gm-mailchimp-form';
$VERSION = '0.0.1';


/**
 * Load the plugin text domain for translation.
 *
 */ function load_textdomain()
{
	load_plugin_textdomain(
		'gm-mailchimp-form',
		false,
		basename(dirname(__FILE__)) . '/languages'
	);
}

/**
 * load translations
 */
function set_script_translations()
{
	wp_set_script_translations('gm-mailchimp-form', 'gm-mailchimp-form', plugin_dir_path(__FILE__) . 'languages');
}

add_action('init', __NAMESPACE__ . '\load_textdomain');
add_action('init', __NAMESPACE__ . '\set_script_translations');

/**
 * block registration
 */
function block_init()
{
	register_block_type_from_metadata(__DIR__, [
		"render_callback" => __NAMESPACE__ . '\includes\renderCallback\render_callback',
	]);
}
add_action('init', __NAMESPACE__ . '\block_init');


/**
 * add api endpoint
 */
add_action(
	'rest_api_init',
	function () {
		register_rest_route('gm_mailchimp_form', '/action', array(
			'methods' => 'POST',
			'permission_callback' => '__return_true',
			'callback' => 'GMMailchimpForm\includes\form\form_callback'
		));
	}
);



/**
 * add script if block is in content
 */
add_action('wp_enqueue_scripts', function () use ($PLUGIN_NAME, $VERSION) {
	$id = get_the_ID();
	if (has_block('goodmotion/block-gm-mailchimp-form', $id)) {
		// add script only if shortcode is used
		$path = plugins_url() . '/' . $PLUGIN_NAME;
		wp_enqueue_script($PLUGIN_NAME, $path . '/assets/scripts.js', array(), $VERSION, true);
	}
});
