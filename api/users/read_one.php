<?php
session_start();
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header(
    'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'
);

include_once("../../php_functions/functions.php");
include_once("../../configs/conn.inc");

//Get ID 
$user_id = isset($_GET["uuid_v4"]) ? $_GET["uuid_v4"] : die(
    //json_encode(array("success" => false,"message" => "Id required"))
);

$ms = fetchonerow("tbl_users", "uuid_v4 = '$user_id'");
$alltotal = countotal("tbl_users", "uuid_v4 = '$user_id'");

if ($alltotal == 1) {
    //Service array  
    $user_arr = array("success" => true, "count" => $alltotal);
    extract($ms);
    
    $company_name = fetchrow('tbl_companies', "id='" . $company_id . "'", "name");
    $added_by_ = fetchrow('tbl_users', "id='" . $added_by . "'", "name");
    $user_item = array(
      "id" => $id,
      "uuid_v4" => $uuid_v4,
      "email" => $email,
      "name" => $name,
      "company_name" => $company_name, 
      "added_by" => $added_by_,
      "created_at" => $created_at,
      "status" => $status
    );

    $user_arr["data"] = $user_item;

    //Turn to JSON & output 
    exit(json_encode($user_arr));
} else {
    exit(json_encode(
        array("success" => false, "message" => "No user found")
    ));
}
?>