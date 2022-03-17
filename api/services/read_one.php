<?php
//Headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

session_start();
include_once("../../php_functions/functions.php");
include_once("../../configs/conn.inc");

//Get ID 
$service_id = isset($_GET["id"]) ? $_GET["id"] : die(
    //json_encode(array("success" => false,"message" => "Id required"))
);

$ms = fetchonerow("tbl_services", "id = $service_id");
$alltotal = countotal("tbl_services", "id = $service_id");

if ($alltotal == 1) {
    //Service array  
    $service_arr = array("success" => true, "count" => $alltotal);
    extract($ms);

    $company_name_ = fetchrow('tbl_companies', "id='" . $company_name . "'", "name");
    $unit_ = fetchrow('tbl_units', "id='" . $unit . "'", "name");
    $service_item = array(
        "id" => $id,
        "company_name" => $company_name_,
        "service_title" => $service_title, 
        "service_address" => $service_address,
        "last_run_datetime" => $last_run_datetime,
        "next_run_datetime" => $next_run_datetime,
        "unit" => $unit_,
        "frequency" => $frequency,
        "added_at" => $added_at,
        "status" => $status,
    );

    $service_arr["data"] = $service_item;

    //Turn to JSON & output 
    echo json_encode($service_arr);
} else {
    echo json_encode(
        array("success" => false, "message" => "No service found")
    );
}
?>