<?php

require_once '../../csrest_lists.php';

$auth = array(
    'access_token' => 'your access token',
    'refresh_token' => 'your refresh token');
$wrap = new VCS_CS_REST_Lists('List ID', $auth);

/*
 * The DataType parameter must be one of
 * VCS_CS_REST_CUSTOM_FIELD_TYPE_TEXT
 * VCS_CS_REST_CUSTOM_FIELD_TYPE_NUMBER
 * VCS_CS_REST_CUSTOM_FIELD_TYPE_MULTI_SELECTONE
 * VCS_CS_REST_CUSTOM_FIELD_TYPE_MULTI_SELECTMANY
 * VCS_CS_REST_CUSTOM_FIELD_TYPE_DATE
 * VCS_CS_REST_CUSTOM_FIELD_TYPE_COUNTRY
 * VCS_CS_REST_CUSTOM_FIELD_TYPE_USSTATE
 *
 */
$result = $wrap->create_custom_field(array(
    'FieldName' => 'Custom field name',
    'DataType' => VCS_CS_REST_CUSTOM_FIELD_TYPE_MULTI_SELECTONE,
    'Options' => array('First option', 'Second Option')
));

echo "Result of POST /api/v3.1/lists/{ID}/customfields\n<br />";
if($result->was_successful()) {
    echo "Created with ID\n<br />".$result->response;
} else {
    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
    var_dump($result->response);
    echo '</pre>';
}