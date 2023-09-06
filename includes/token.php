<?php

namespace GMMailchimpForm\Includes;

/**
 * get the name of the token
 */
function get_name_token()
{
  return 'gm-mailchimp-token';
}

/**
 * generate, save and return a token
 */
function get_token()
{
  $token = openssl_random_pseudo_bytes(16);
  //Convert the binary data into hexadecimal representation.
  if(get_transient(get_name_token()) === false){
    set_transient(get_name_token(), bin2hex($token), 60 * 60 * 24);
  }
  return get_transient(get_name_token());
}

