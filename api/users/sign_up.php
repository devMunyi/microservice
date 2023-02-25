<?php 
//Headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); 
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 

session_start();
include_once("../../php_functions/functions.php");
include_once("../../configs/conn.inc");

//Get raw added data 
$data = json_decode(file_get_contents("php://input"));

$uuid_v4 = gen_uuidv4();
$name = trim($data->name);
$email = trim($data->email);
$company_id = trim($data->company_id);
$password = trim($data->password);
$confirm_password = trim($data->confirm_password);

// validations
    
if((input_available($name)) == 0)
{
    exit(json_encode(array("status" => "Failed", "message" => "Name is required")));
}

if((input_available($email)) == 0)
{
    exit(json_encode(array("status" => "Failed", "message" => "Email is required")));
}

if((input_available($company_id)) == 0)
{
    exit(json_encode(array("status" => "Failed", "message" => "Select company")));
}

if((checkrowexists("tbl_users", "email='$email'")) == 1){
  exit(json_encode(array("status" => "Failed", "message" => "Email already exists")));
}

if((input_available($password)) == 0)
{
    exit(json_encode(array("status" => "Failed", "message" => "Password is required")));
}

if(strlen($password) < 6){
  exit(json_encode(array("status" => "Failed", "message" => "Password should be at least 6 characters")));
}

if((input_available($confirm_password)) == 0)
{
    exit(json_encode(array("status" => "Failed", "message" => "Confirm password is required")));
}

if($password != $confirm_password){
  exit(json_encode(array("status" => "Failed", "message" => "Passwords do not match")));
}

//////-----------End of validation

// encrypt the password
$encrypted_pass = encrypt_password($password);


$fds = array('uuid_v4', 'name', 'email', 'company_id', 'password');
$vals = array($uuid_v4, $name, $email, $company_id, $encrypted_pass);
$create = addtodb('tbl_users',$fds,$vals);

if ($create == 1) {
  http_response_code(200);
  exit(json_encode(array("status" => "Ok", "message" => "Signed up successfully")));
} else {
  http_response_code(400);
  exit(json_encode(array("status" => "Failed", "message" => "Sign up Failed")));
}

?>