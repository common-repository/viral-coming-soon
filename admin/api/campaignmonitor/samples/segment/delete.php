<?php

require_once '../../csrest_segments.php';

$auth = array(
    'access_token' => 'your access token',
    'refresh_token' => 'your refresh token');
$wrap = new VCS_CS_REST_Segments('Segment ID', $auth);


$result = $wrap->delete();

echo "Result of DELETE /api/v3.1/segments/{ID}\n<br />";
if($result->was_successful()) {
    echo "Deleted with code\n<br />".$result->http_status_code;
} else {
    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
    var_dump($result->response);
    echo '</pre>';
}