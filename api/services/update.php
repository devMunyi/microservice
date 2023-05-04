<?php 
    //Headers 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 


    session_start();
    include_once("../../php_functions/functions.php");
    include_once("../../configs/conn.inc");

    //// ======= Get raw added data 
    $data = json_decode(file_get_contents("php://input"));

    $company_id = trim($data->company_id);
    $service_title = trim($data->service_title);
    $service_address = trim($data->service_address);
    $next_run_datetime = trim($data->next_run);
    $unit = trim($data->unit);
    $frequency = trim($data->frequency);
    $repeated = trim($data->repeated);
    $is_executed = trim($data->is_executed);
    $id = trim($data->service_id);
    $updated_by = trim($data->service_creator_editor);

    $user_details = fetchonerow('tbl_users', "id='$updated_by'", '*');

    ///////----------Validation
    if($company_id < 1){
        exit(json_encode(array("success" => false, "message" => "Please select company name")));
    } 

    
    if((input_available($service_title)) == 0)
    {
        exit(json_encode(array("success" => false, "message" => "Service title is required")));
    }

    if((input_available($service_address)) == 0)
    {
        exit(json_encode(array("success" => false, "message" => "Service address is required")));
    }else{
        $address_exists = checkrowexists('tbl_services',"service_address = '$service_address' AND unit=$unit AND frequency=$frequency AND company_id = '$company_id' AND id != $id");
        if($address_exists == 1){
            exit(json_encode(array("success" => false, "message" => "Oops! Duplicate service address")));
        }
    }

    if((input_available($next_run_datetime)) == 0)
    {
        exit(json_encode(array("success" => false, "message" => "The next run date and time is required"))); 
    }else if($next_run_datetime <= $current_fulldate)
    {
        exit(json_encode(array("success" => false, "message" => "The next run must be greater than ".timeConversion12Hours($current_fulldate)))); 
    }else{
        if((input_length($next_run_datetime, 16)) == 0){
            exit(json_encode(array("success" => false, "message" => "Please enter a valid entry for next run date and time"))); 
        }
    }

    if($unit < 1){
        exit(json_encode(array("success" => false, "message" => "Please select unit")));
    }

    if($frequency < 0){
        exit(json_encode(array("success" => false, "message" => "Please select frequency")));
    }

    if((input_available($repeated)) == 0){
        exit(json_encode(array("success" => false, "message" => "Please select repeated value")));
    }

    if((input_available($is_executed)) == 0){
        exit(json_encode(array("success" => false, "message" => "Please select is executed value")));
    }

    //////-----------End of validation
    $updatefds = "company_id=$company_id, service_title='$service_title', service_address='$service_address', next_run_datetime='$next_run_datetime', unit=$unit, frequency=$frequency, repeated='$repeated', frequency=$frequency, is_executed='$is_executed'";
    $update = updatedb('tbl_services',"$updatefds","id= $id");

    if($update == 1)
    {
        $event = "Service updated at [$current_fulldate] by [".$user_details['name']."{".$user_details['id']."}]";
        store_event('tbl_services', $user_details['id'],"$event");
        exit(json_encode(array("success" => true, "message" => "Record Updated Successfully"))); 
    }
    else
    {
        exit(json_encode(array("success" => false, "message" => "Record was not updated")));
    }
