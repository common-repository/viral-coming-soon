<?php

require_once '../../csrest_subscribers.php';

$auth = array(
    'access_token' => 'your access token',
    'refresh_token' => 'your refresh token');
$wrap = new VCS_CS_REST_Subscribers('Your list ID', $auth);
$result = $wrap->unsubscribe('Email Address');

echo "Result of GET /api/v3.1/subscribers/{list id}/unsubscribe.{format}\n<br />";
if($result->was_successful()) {
    echo "Unsubscribed with code ".$result->http_status_code;
} else {
    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
    var_dump($result->response);
    echo '</pre>';
}