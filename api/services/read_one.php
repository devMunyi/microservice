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

    $service_item = array(
        "id" => $id,
        "service_address" => $service_address,
        "run_timestamp" => $r_timestamp,
        "unit" => $unit,
        "frequency" => $frequency,
        "is_executed" => $is_executed,
        "added_at" => $added_at,
        "updated_at" => $updated_at,
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