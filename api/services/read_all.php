<?php
//Headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

session_start();
include_once("../../php_functions/functions.php");
include_once("../../configs/conn.inc");


//Get and set string query variable;
$offset = isset($_GET["offset"]) ? $_GET["offset"] : 0;
$rpp = isset($_GET["rpp"]) ? $_GET["rpp"] : 10;
$page_no = isset($_GET["page_no"]) ? $_GET["page_no"] : 1;
$orderby = isset($_GET["orderby"]) ? $_GET["orderby"] : "r_timestamp";
$dir = isset($_GET["dir"]) ? $_GET["dir"] : "DESC";
$search = isset($_GET["search"]) ? $_GET["search"] : "";

$limit = "$offset, $rpp";


if ((input_available($search)) == 1) {
    $andsearch = " AND (service_address LIKE \"%$search%\" OR r_timestamp LIKE \"%$search%\" OR unit LIKE \"%$search%\" OR frequency LIKE \"%$search%\")";
} else {
    $andsearch = "";
}

$ms = fetchtable('tbl_services', "id >= 1 $andsearch", "$orderby", "$dir", "$limit", "id, service_address, r_timestamp, unit, frequency, is_executed, added_at, status");

///----------Paging Option
$alltotal = countotal("tbl_services", "id > 0 $andsearch");

if ($alltotal > 0) {
    //Service array 
    $services_arr = array("success" => true, "count" => $alltotal, "page_no" => $page_no);
    $services_arr['data'] = array();

    while ($row = mysqli_fetch_array($ms)) {
        extract($row);
        $service_item = array(
            "id" => $id,
            "service_address" => $service_address,
            "run_timestamp" => $r_timestamp,
            "unit" => $unit,
            "frequency" => $frequency,
            "is_executed" => $is_executed,
            "added_at" => $added_at,
            "status" => $status,
        );

        //push to "data" 
        array_push($services_arr["data"], $service_item);
    }
    //Turn to JSON & output 
    echo json_encode($services_arr);
} else {
    echo json_encode(
        array("success" => false, "message" => "No service found")
    );
}

?>
    
