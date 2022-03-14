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

    $service_address = trim($data->service_address);
    $r_timestamp = trim($data->r_timestamp);
    $unit = trim($data->unit);
    $frequency = trim($data->frequency);

    ///////----------Validation
    if((input_available($service_address)) == 0)
    {
        die(json_encode(array("success" => false, "message" => "Service address is required")));
    }else{
        $address_exists = checkrowexists('tbl_services',"service_address='$service_address'");
        if($address_exists == 1){
            die(json_encode(array("success" => false, "message" => "Oops! Duplicate service address")));
        }
    }
    if((input_available($r_timestamp)) == 0)

    {
        die(json_encode(array("success" => false, "message" => "Date and time is required"))); 
    }else{
        if((input_length($r_timestamp, 16)) == 0){
            die(json_encode(array("success" => false, "message" => "Please enter a valid run time"))); 
        }
    }

    if($unit < 1){
        die(json_encode(array("success" => false, "message" => "Please select unit")));
    }

    if($frequency < 1){
        die(json_encode(array("success" => false, "message" => "Please select frequency")));
    }
    //////-----------End of validation


    $fds = array('service_address','r_timestamp','unit','frequency');
    $vals = array("$service_address","$r_timestamp","$unit","$frequency");
    $create = addtodb('tbl_services',$fds,$vals);

    if($create == 1)
    {
        echo json_encode(array("success" => true, "message" => "Record Added Successfully")); 

    }
    else
    {
        echo json_encode(array("success" => false, "message" => "Record was not added"));
    }

?>
