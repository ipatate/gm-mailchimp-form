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

require_once(dirname(__FILE__) . '/rest/form.php');
require_once(dirname(__FILE__) . '/options/config_panel.php');
require_once(dirname(__FILE__) . '/rest/token.php');

$PLUGIN_NAME = 'gm-mailchimp-form';
$VERSION = '0.0.1';


/**
 * block registration
 */
function block_init()
{
	register_block_type_from_metadata(__DIR__, [
		"render_callback" => __NAMESPACE__ . '\render_callback',
	]);
}
add_action('init', __NAMESPACE__ . '\block_init');


function render_callback($attributes, $content)
{
	$context['token'] = token\getToken();
	// render template
	return \Timber::compile('blocks/form.twig', $context);
}


/**
 * add api endpoint
 */
add_action(
	'rest_api_init',
	function () {
		register_rest_route('gm_mailchimp_form', '/action', array(
			'methods' => 'POST',
			'permission_callback' => '__return_true',
			'callback' => 'GMMailchimpForm\form\form_callback'
		));
	}
);



/**
 * add script if block is in content
 */
add_action('wp_enqueue_scripts', function () use ($PLUGIN_NAME, $VERSION) {
	$id = get_the_ID();
	var_dump(has_block('goodmotion/block-gm-mailchimp-form', $id));
	if (has_block('goodmotion/block-gm-mailchimp-form', $id)) {
		// add script only if shortcode is used
		$path = plugins_url() . '/' . $PLUGIN_NAME;
		wp_enqueue_script($PLUGIN_NAME, $path . '/assets/scripts.js', array(), $VERSION, true);
	}
});
