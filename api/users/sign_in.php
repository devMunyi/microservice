<?php
session_start();
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header(
    'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'
);

include_once '../../php_functions/functions.php';
include_once '../../configs/conn.inc';

//Get raw added data
$data = json_decode(file_get_contents('php://input'));
$email = trim($data->email);
$password = trim($data->password);
$deviceid = trim($data->deviceId);
$browsername = trim($data->browserName);
$IPAddress = trim($data->ipAddress);
$OS = trim($data->OS);

/// ============ validating inputs

$email_valid = emailOk($email);
$password_valid = input_length($password, 6);

if((input_available($email)) == 0)
{
    exit(json_encode(array("status" => "Failed", "message" => "Email is required")));
}

if ($email_valid == 0) {
  exit(json_encode(array("status" => "Failed", "message" => "Email is invalid")));
}

if ($password_valid == 0) {
  exit(json_encode(array("status" => "Failed", "message" => "Password is invalid")));
}

if ($password_valid == 1) {
    $userrecord = fetchonerow(
        'tbl_users',
        "email='$email'",
        'id, status, password'
    );
    $userid = $userrecord['id'];
    $status = $userrecord['status'];
    if ($userid > 0) {
        if ($status == 0) {
            exit(json_encode(array("status" => "Failed", "message" => "Account is disabled. Please contact us")));
        }elseif($status == 2) {
            exit(json_encode(array("status" => "Failed", "message" => "Please wait for your account approval by admin to continue")));
        }else {
            /////======== Password verification
            $encrypted_password = $userrecord['password'];

            if (decrypt_password($password ,$encrypted_password)) {
                $token = generateToken(
                    $userid,
                    $deviceid,
                    $browsername,
                    $IPAddress,
                    $OS
                );

                // echo "TOKEN => $token";

                if (strlen($token) == 64) {
                    $details_ = $token;
                    $_SESSION['msu-token'] = $token;
                    exit(json_encode(array("status" => "Ok", "message" => "Success! we are taking you to the dashboard...")));
                    // echo "<meta http-equiv=\"refresh\" content=\"2; URL=index.php\"/>";
                } else {
                    exit(json_encode(array("status" => "Failed", "message" => "Unable to generate a security token. Please click login again => $token")));
                }
            } else {
              exit(json_encode(array("status" => "Failed", "message" => "Password mismatch")));
            }
        }
    } else {
        exit(json_encode(array("status" => "Failed", "message" => "Email does not exist.")));
    }
}
