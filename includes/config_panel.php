<?php

namespace GMMailchimpForm\Includes;


function register_settings()
{
  add_option('gm_mailchimp_form_list_id', '');
  add_option('gm_mailchimp_form_token', '');
  add_option('gm_mailchimp_form_url', '');


  register_setting('gm_mailchimp_form_options_group', 'gm_mailchimp_form_list_id');
  register_setting('gm_mailchimp_form_options_group', 'gm_mailchimp_form_token');
  register_setting('gm_mailchimp_form_options_group', 'gm_mailchimp_form_url');
}


function register_options_page()
{
  add_options_page('Mailchimp Form', 'Mailchimp Form', 'manage_options', 'gm-mailchimp-form', __NAMESPACE__ . '\options_page');
}


function options_page()
{
?>
  <div>
    <h2>Mailchimp newsletter Form</h2>
    <form method="post" action="options.php">
      <?php settings_fields('gm_mailchimp_form_options_group'); ?>
      <table>
        <tr valign="top">
          <th scope="row"><label for="gm_mailchimp_form_list_id">List ID</label></th>
          <td><input type="text" id="gm_mailchimp_form_list_id" name="gm_mailchimp_form_list_id" value="<?php echo get_option('gm_mailchimp_form_list_id'); ?>" /></td>
          <td>In mailchimp dashboard > Audience > settings > Audiance name and default</td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="gm_mailchimp_form_token">Token</label></th>
          <td><input type="password" id="gm_mailchimp_form_token" name="gm_mailchimp_form_token" value="<?php echo get_option('gm_mailchimp_form_token'); ?>" /></td>
          <td>Create token API in your mailchimp dashboard</td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="gm_mailchimp_form_url">URL</label></th>
          <td><input type="text" id="gm_mailchimp_form_url" name="gm_mailchimp_form_url" value="<?php echo get_option('gm_mailchimp_form_url'); ?>" /></td>
          <td>(ex: https://us5.api.mailchimp.com/3.0/) us5 subdomain can change. Look url address in your mailchimp dashboard</td>
        </tr>

      </table>
      <?php submit_button(); ?>
    </form>
  </div>
<?php
}

add_action('admin_menu', __NAMESPACE__ . '\register_options_page');
add_action('admin_init', __NAMESPACE__ . '\register_settings');
