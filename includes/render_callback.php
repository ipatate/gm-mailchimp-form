<?php

namespace GMMailchimpForm\includes\renderCallback;

function render_callback($attributes, $content)
{
	$token = \GMMailchimpForm\includes\token\getToken();

	return 	'<script type="text/javascript">
	var gmMailchimpFormSuccessMessage =
		"' .   __("You are subscribed to the list of newsletters. Thank you", "gm-mailchimp-form")  . ' ";
	var gmMailchimpFormErrorMessageAlreadySubsribed =
		"' .   __("Oh ! A user already exist with this email 😱", "gm-mailchimp-form")  . ' ";
	var gmMailchimpFormErrorMessageDeleted =
		"' .   __("This email was deleted from list and it's not possible to resubscribe 😱", "gm-mailchimp-form")  . ' ";
</script>
<div class="gm-mailchimp-form">
	<form action="#" id="gm-mailchimp-form">
		<input type="hidden" name="token" value="' .  $token  . '" />
		<label for="email"
			>' .   __("Email", "gm-mailchimp-form")  . '
			<input type="email" name="email" id="email" value="" required />
		</label>
		<label for="firstname"
			>' .   __("Firstname", "gm-mailchimp-form")  . '
			<input type="text" name="firstname" id="firstname" value="" required />
		</label>
		<label for="lastname"
			>' .   __("Lastname", "gm-mailchimp-form")  . '
			<input type="text" name="lastname" id="lastname" value="" required />
		</label>
		<label for="accept" class="inline-field"
			><span>' .
		__("You agree to subscribe to our newsletter", "gm-mailchimp-form")  . ' </span>
			<input type="checkbox" name="accept" id="accept" required />
		</label>
		<label for="beer" class="inline-field beer-field"
			>' .   __("Don't check this box, it's for robot", "gm-mailchimp-form")  . '
			<input type="checkbox" name="beer" />
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
				' . file_get_contents(dirname(__FILE__) . "/../assets/check.svg")  . '
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
