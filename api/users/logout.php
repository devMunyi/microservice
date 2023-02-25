<?php
session_start();
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header(
    'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'
);

include_once '../../php_functions/functions.php';
include_once '../../configs/conn.inc';

$token = $_SESSION['msu-token'];
$session_keydest = updatedb('tbl_tokens',"status=0, expiry_date='$current_fulldate'","token='$token'");
session_destroy();
unset($_SESSION['msu-token']);

http_response_code(200);
exit(json_encode(array("status" => "Ok", "message" => "Signed out successfully")));

?>