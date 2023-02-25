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

$profile_updated_by = trim($data->service_creator_editor);
$user_details = fetchonerow('tbl_users', "id='$profile_updated_by'", '*');


//// ===========End of auth check


////// ================Get raw added data 

$data = json_decode(file_get_contents("php://input"));
$name = trim($data->name);
$uuid_v4 = trim($data->uuid_v4);
$company_id = trim($data->company);

////// ================End of extracting raw added data



//// ================== validations
    
if((input_available($name)) == 0)
{
    exit(json_encode(array("status" => "Failed", "message" => "Name is required")));
}

if((input_available($uuid_v4)) == 0)
{
    exit(json_encode(array("status" => "Failed", "message" => "User uuid is required")));
}

if((input_available($company_id)) == 0)
{
    exit(json_encode(array("status" => "Failed", "message" => "Select company")));
}

//////======================End of validation


///// ===================== Update operation

$updatefds = "name=$name, company_id=$company_id";
$update = updatedb('tbl_users',"$updatefds","uuid_v4= '$uuid_v4'");


if($update == 1)
{
    $event = "Profile updated at [$current_fulldate] by [".$user_details['name']."{".$user_details['id']."}]";
    store_event('tbl_users', $user_details['id'],"$event");
    exit(json_encode(array("success" => true, "message" => "Record Updated Successfully"))); 

}
else
{
    exit(json_encode(array("success" => false, "message" => "Record was not updated")));
}

///// =====================End Update operation

?>