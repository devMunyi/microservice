<?php 
    session_start();
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 

    include_once ("../../php_functions/functions.php");
    include_once ("../../configs/conn.inc");

    //// ===========auth check

    $blocked_by = trim($data->service_creator_editor);
    $user_details = fetchonerow('tbl_users', "id='$blocked_by'", '*');


    //// ===========End of auth check


    // Get raw id data 
    $data = json_decode(file_get_contents("php://input"));

    //grab the user id to delete 
    $uuid_v4 = $data->uuid_v4; 

    $update = updatedb('tbl_users', "status=0", "uuid_v4 = '$uuid_v4'");
    if($update == 1)
    {
        $event = "User blocked at [$current_fulldate] by [".$user_details['name']."{".$user_details['id']."}]";
        store_event('tbl_users', $user_details['id'],"$event");
        exit(json_encode(array("success" => true, "message" => "User was deleted")));
    }
    else
    {
        exit(json_encode(array("success" => false, "message" => "User not deleted")));
    }
?>