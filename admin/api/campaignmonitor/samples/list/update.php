<?php

require_once '../../csrest_lists.php';

$auth = array(
    'access_token' => 'your access token',
    'refresh_token' => 'your refresh token');
$wrap = new VCS_CS_REST_Lists('List ID', $auth);

$result = $wrap->update(array(
    'Title' => 'List Title',
    'UnsubscribePage' => 'List unsubscribe page',
    'ConfirmedOptIn' => true,
    'ConfirmationSuccessPage' => 'List confirmation success page',
    'UnsubscribeSetting' => VCS_CS_REST_LIST_UNSUBSCRIBE_SETTING_ALL_CLIENT_LISTS,
    'AddUnsubscribesToSuppList' => true,
    'ScrubActiveWithSuppList' => true
));

echo "Result of PUT /api/v3.1/lists/{ID}\n<br />";
if($result->was_successful()) {
    echo "Updated with code\n<br />".$result->http_status_code;
} else {
    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
    var_dump($result->response);
    echo '</pre>';
}