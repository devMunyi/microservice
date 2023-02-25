<?php 
session_start(); ///=======start session

///// ===========Headers 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); 
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 

///// ===========End of Headers 


///// ===============include external files for reusable functions

include_once("../../php_functions/functions.php");
include_once("../../configs/conn.inc");

///// ===============End of include external files for reusable functions

//// ===========auth check

$changed_by = trim($data->service_creator_editor);
$user_details = fetchonerow('tbl_users', "id='$changed_by'", '*');

//// ===========End of auth check


////// ================Get raw added data 

$data = json_decode(file_get_contents("php://input"));
$old_password = trim($data->old_password);
$new_password = trim($data->new_password);
$confirm_new_password = trim($data->confirm_new_password);
$uuid_v4 = trim($data->uuid_v4);

////// ================End of extracting raw added data



//// ================== validations

if((input_available($uuid_v4)) == 0)
{
    die(json_encode(array("status" => "Failed", "message" => "User uuid is required")));
}
    
if((input_available($old_password)) == 0)
{
    die(json_encode(array("status" => "Failed", "message" => "Old password is required")));
}else {
  if((checkrowexists("tbl_users", "uuid_v4='$uuid_v4'")) == 0){
    die(json_encode(array("status" => "Failed", "message" => "Invalid user id")));
  }
}

if((input_available($new_password)) == 0)
{
    die(json_encode(array("status" => "Failed", "message" => "New password is required")));
}


if(strlen($new_password) < 6){
  die(json_encode(array("status" => "Failed", "message" => "Password should be at least 6 characters")));
}

if((input_available($confirm_new_password)) == 0)
{
    die(json_encode(array("status" => "Failed", "message" => "New password confirmation is required")));
}


if($new_password != $confirm_new_password){
  die(json_encode(array("status" => "Failed", "message" => "Passwords do not match")));
}

if((input_available($company_id)) == 0)
{
    die(json_encode(array("status" => "Failed", "message" => "Select company")));
}

//////======================End of validation


///// ===================== Update operation
$updatefds = "name=$name, company_id=$company_id";
$update = updatedb('tbl_users',"$updatefds","uuid_v4= '$uuid_v4'");


if($update == 1)
{
    $events = "Password changed at [$current_fulldate] by [".$user_details['name']."{".$user_details['id']."}]";
    store_event('tbl_users', $user_details['id'],"$events");
    exit(json_encode(array("success" => true, "message" => "Record Updated Successfully"))); 

}
else
{
    echo json_encode(array("success" => false, "message" => "Record was not updated"));
}

///// =====================End Update operation

?>