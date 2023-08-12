<?php
// Headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once("../../php_functions/functions.php");
include_once("../../configs/conn.inc");

$ms = fetchtable("tbl_services", "next_run_datetime < '$current_fulldate' AND is_executed = 'No' AND status > 0", "id", "DESC", "100", "id, service_title, service_address, last_run_datetime, next_run_datetime, unit, frequency, is_executed, repeated");
///----------Paging Option

$alltotal = countotal("tbl_services", "next_run_datetime < '$current_fulldate' AND is_executed = 'No' AND status > 0");


if ($alltotal > 0) {
    //Service array 
    $services_arr = array("success" => true, "count" => $alltotal);
    $services_arr['data'] = array();

    while ($row = mysqli_fetch_array($ms)) {
        $id = $row['id'] ?? 0;
        $service_title = $row['service_title'] ?? '';
        $service_address = $row['service_address'] ?? '';
        $last_run_datetime = $row['last_run_datetime'] ?? '0000-00-00 00:00:00';
        $next_run_datetime = $row['next_run_datetime'] ?? '0000-00-00 00:00:00';
        $unit = $row['unit'];
        $frequency = $row['frequency'];
        $is_executed = $row['is_executed'];
        $repeated = $row['repeated'];

        if ($id > 0 && $service_address != '') {
            $result = serviceCall($current_fulldate, $last_run_datetime, $unit, $frequency, $service_address);

            $http_code = $result['http_code'];
            $execution_time = $result['execution_time'];

            if ($http_code != null && $execution_time != null) {
                //check for status code to determined whether failed on executed
                if ($http_code == "200") {
                    $log = "Success with an execution time of $execution_time seconds unit: $unit";
                } else {
                    $log = "Failed with code $http_code and execution time of $execution_time seconds unit: $unit";
                }

                // store service run logs
                $fds = array('log', 'service_id');
                $vals = array("$log", "$id");
                addtodb('tbl_logs', $fds, $vals);

                // get the service ready for the next run
                updateService($repeated, $unit, $frequency, $current_fulldate, $id);

                $service_item = array(
                    "service_title" => $service_title,
                    "service_address" => $service_address,
                    "log" => $log
                );

                //push to "data" 
                array_push($services_arr["data"], $service_item);
            }
        }
    }
    // Turn to JSON & output 
    echo json_encode($services_arr);
} else {
    exit(json_encode(
        array("success" => false, "message" => "No service found")
    ));
}
