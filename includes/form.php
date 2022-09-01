<?php

namespace GMMailchimpForm\includes\form;

require_once(dirname(__FILE__) . '/token.php');

/**
 * REST route for form submission.
 */
function form_callback(\WP_REST_Request $request)
{
  $tokenReal = \GMMailchimpForm\includes\token\getToken();
  // get token from form
  $token =  $request->get_param('token');
  // if robot, beer is not null
  $trap =  $request->get_param('beer');
  if ($token !== $tokenReal || $trap !== null) {
    return new \WP_Error('invalid_token', 'Invalid token', array('status' => 403));
  }

  // options for mailchimp
  $list_id =  get_option('gm_mailchimp_form_list_id');
  $authToken = get_option('gm_mailchimp_form_token');
  $url = get_option('gm_mailchimp_form_url');


  // data to save
  $postData = array(
    "email_address" => sanitize_email($request->get_param('email')),
    "status" => "subscribed",
    // "merge_fields" => array(
    //   "FNAME" => sanitize_text_field($request->get_param('firstname')),
    //   "LNAME" => sanitize_text_field($request->get_param('lastname'))
    // )
  );

  // Setup cURL
  $ch = curl_init($url . '/lists/' . $list_id . '/members/');
  curl_setopt_array($ch, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array(
      'Authorization: apikey ' . $authToken,
      'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => json_encode($postData)
  ));

  // Send the request
  $response = curl_exec($ch);
  // no response
  if (!$response) {
    return new \WP_Error('curl_error', curl_error($ch), array('status' => 500));
  }

  // decode response
  $res = json_decode($response);
  // email already exist
  if ($res && property_exists($res, 'title')) {
    return [
      'error' => true,
      'message' => $res->title === 'Forgotten Email Not Subscribed' ? 'USER_DELETED' : 'USER_EXIST'
    ];
  }

  // ok :)
  return [
    'error' => false,
    'message' => 'USER_ADDED'
  ];
}


function get_token(\WP_REST_Request $request)
{
  $tokenReal = \GMMailchimpForm\includes\token\getToken();
  return ['token' => $tokenReal];
}
