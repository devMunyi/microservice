<?php 
    //Headers 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 

    session_start();
    include_once ("../../php_functions/functions.php");
    include_once ("../../configs/conn.inc");

    //Get raw id data 
    $data = json_decode(file_get_contents("php://input"));

    //grab the service id to delete 
    $id = $data->service_id; 

    $unblocked_by = trim($data->service_creator_editor);
    $user_details = fetchonerow('tbl_users', "id='$unblocked_by'", '*');

    $update = updatedb('tbl_services', "status=1", "id = $id");
    if($update == 1)
    {
        $events = "Service unblocked or activated at [$current_fulldate] by [".$user_details['name']."{".$user_details['id']."}]";
        store_event('tbl_services', $unblocked_by, "$events");
        echo json_encode(array("success" => true, "message" => "Service was activated"));
    }
    else
    {
        echo json_encode(array("success" => false, "message" => "Service not activated"));
    }
?>