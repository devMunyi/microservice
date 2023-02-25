<?php 
    //Headers 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 

    session_start();
    include_once("../../php_functions/functions.php");
    include_once("../../configs/conn.inc");

    // $user_details = session_details();
    // if($user_details == null){
    //     exit(json_encode(array("success" => false, "message" => "Your session is invalid. Please re-login")));
    // }


    //Get raw added data 
    $data = json_decode(file_get_contents("php://input"));


    $company_id = trim($data->company_id);
    $service_title = trim($data->service_title);
    $service_address = trim($data->service_address);
    $next_run_datetime = trim($data->next_run);
    $unit = trim($data->unit);
    $frequency = trim($data->frequency);
    $repeated = trim($data->repeated);
    $added_by = trim($data->service_creator_editor);

    $user_details = fetchonerow('tbl_users', "id='$added_by'", '*');

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
        $address_exists = checkrowexists('tbl_services',"service_address='$service_address' AND unit=$unit AND frequency=$frequency AND company_id = '$company_id'");
        if($address_exists == 1){
            exit(json_encode(array("success" => false, "message" => "Oops! Duplicate service address")));
        }
    }

    $thisfulldate_=date('Y-m-d H:i');
    if((input_available($next_run_datetime)) == 0)
    {
        exit(json_encode(array("success" => false, "message" => "The next run date and time is required"))); 
    }else if($next_run_datetime <= $thisfulldate_)
    {
        exit(json_encode(array("success" => false, "message" => "The next run must be greater than ".$thisfulldate_))); 
    }
    else{
        if((input_length($next_run_datetime, 16)) == 0){
            exit(json_encode(array("success" => false, "message" => "Please enter a valid entry for next run date and time"))); 
        }
    }

    if($unit < 1){
        exit(json_encode(array("success" => false, "message" => "Please select unit")));
    }

    if($frequency < 1){
        exit(json_encode(array("success" => false, "message" => "Please select frequency")));
    }

    if((input_available($repeated)) == 0){
        exit(json_encode(array("success" => false, "message" => "Please select repeated value")));
    }
    //////-----------End of validation


    $fds = array('company_id', 'service_title', 'service_address','next_run_datetime','unit','frequency', 'repeated', 'added_by');
    $vals = array($company_id,"$service_title", "$service_address","$next_run_datetime", $unit, $frequency, "$repeated", $added_by);
    $create = addtodb('tbl_services',$fds,$vals);

    if($create == 1)
    {
        $events = "Service added at [$current_fulldate] by [".$user_details['name']."{".$user_details['id']."}]";
        store_event('tbl_services', $user_details['id'],"$events");
        exit(json_encode(array("success" => true, "message" => "Record Added Successfully"))); 

    }
    else
    {
        exit(json_encode(array("success" => false, "message" => "Record was not added")));
    }

?>
