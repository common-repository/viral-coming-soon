<?php

require_once '../../csrest_lists.php';

$auth = array(
    'access_token' => 'your access token',
    'refresh_token' => 'your refresh token');
$wrap = new VCS_CS_REST_Lists('List ID', $auth);

$result = $wrap->get();

echo "Result of GET /api/v3.1/lists/{ID}\n<br />";
if($result->was_successful()) {
    echo "Got list details\n<br /><pre>";
    var_dump($result->response);
} else {
    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
    var_dump($result->response);
}
echo '</pre>';