<?php

namespace GMMailchimpForm\Includes;

function render_callback(): string
{
  $token = \GMMailchimpForm\Includes\get_token();

  return     '<script type="text/javascript">
	var gmMailchimpFormSuccessMessage =
		"' .   __("You are subscribed to the list of newsletters. Thank you", "gm-mailchimp-form")  . ' ";
	var gmMailchimpFormErrorMessageAlreadySubsribed =
		"' .   __("Oh ! A user already exist with this email 😱", "gm-mailchimp-form")  . ' ";
	var gmMailchimpFormErrorMessageDeleted =
		"' .   __("This email was deleted from list and it's not possible to resubscribe 😱", "gm-mailchimp-form")  . ' ";
</script>
<div class="gm-mailchimp-form">
	<form action="#" id="gm-mailchimp-form">
		<input type="hidden" name="token" value="" />
		<label for="email"
			><span>' .   __("Email", "gm-mailchimp-form")  . '</span>
			<input type="email" name="email" id="email" value="" placeholder="' . __
    ("Email", "gm-mailchimp-form"). '" required />
		</label>
		<label for="accept" class="inline-field"
			><span>' .
    __("You agree to subscribe to our newsletter", "gm-mailchimp-form")  . ' </span>
			<input type="checkbox" name="accept" id="accept" required />
		</label>
		<label for="beer" class="inline-field beer-field"
			>' .   __("Don't check this box, it's for robot", "gm-mailchimp-form")  . '
			<input type="checkbox" name="beer" id="beer" />
		</label>
		<input
			type="submit"
			id="gm-mailchimp-form-submit"
			value="' .   __("Subscribe", "gm-mailchimp-form")  . ' "
		/>
		<div
			id="gm-mailchimp-form-status"
			class="gm-mailchimp-form-status gm-mailchimp-form-status-hidden"
		>
			<div
				id="gm-mailchimp-form-success"
				class="gm-mailchimp-form-success gm-mailchimp-form-modal gm-mailchimp-form-modal-hidden"
			>
				<span class="gm-message"></span>
			</div>
			<div
				id="gm-mailchimp-form-error"
				class="gm-mailchimp-form-error gm-mailchimp-form-modal gm-mailchimp-form-modal-hidden"
			>
				<span class="gm-message"></span>
			</div>
		</div>
	</form>
</div>';
}
