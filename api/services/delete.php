<?php 
    //Headers 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 

    session_start();
    include_once ("../../php_functions/functions.php");
    include_once ("../../configs/conn.inc");

    //Get raw id data 
    $data = json_decode(file_get_contents("php://input"));

    $blocked_by = trim($data->service_creator_editor);

    $user_details = fetchonerow('tbl_users', "id='$blocked_by'", '*');

    //grab the service id to delete 
    $id = $data->service_id; 

    $update = updatedb('tbl_services', "status=0", "id = $id");
    if($update == 1)
    {
        $events = "Service blocked/deleted at [$current_fulldate] by [".$user_details['name']."{".$user_details['id']."}]";
        store_event('tbl_services', $user_details['id'],"$events");
        exit(json_encode(array("success" => true, "message" => "Service was deleted")));
    }
    else
    {
        exit(json_encode(array("success" => false, "message" => "Service not deleted")));
    }
?>