<?php

namespace GMMailchimpForm\includes\token;

/**
 * get the name of the token
 */
function getNameToken()
{
	return 'gm-mailchimp-token';
}

/**
 * generate, save and return a token
 */
function getToken()
{
	$token = openssl_random_pseudo_bytes(16);
	//Convert the binary data into hexadecimal representation.
	$_SESSION[getNameToken()] = $_SESSION[getNameToken()] ?? bin2hex($token);
	return $_SESSION[getNameToken()];
}

/**
 * init session
 */
add_action('init', function () {
	if (!session_id()) {
		session_start();
	}
});
