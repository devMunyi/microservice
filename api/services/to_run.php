<?php
//Headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once("../../php_functions/functions.php");
include_once("../../configs/conn.inc");


$ms = fetchtable("tbl_services", "DATE_FORMAT(r_timestamp, '%Y-%m-%d %H:%i') = '$thisfulldate' AND is_executed = 'No' AND status > 0", "id", "DESC", "100", "id, service_address, r_timestamp, unit, frequency, is_executed, added_at, status");
///----------Paging Option

$alltotal = countotal("tbl_services", "DATE_FORMAT(r_timestamp, '%Y-%m-%d %H:%i') = '$thisfulldate' AND is_executed = 'No' AND is_executed = 'No' AND status > 0");

if ($alltotal > 0) {
    //Service array 
    $services_arr = array("success" => true, "count" => $alltotal);
    $services_arr['data'] = array();

    while ($row = mysqli_fetch_array($ms)) {
        extract($row);
        $ch = curl_init($service_address);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        //check for status code to determined whether failed on executed
        if($httpcode == "200"){
            $log = "Success";
        }else{
            $log = "Failed with code $httpcode";
        }

        $fds = array('log', 'service_id');
        $vals = array("$log", "$id");
        addtodb('tbl_logs', $fds, $vals);

        //update the availabe services table accordingly 
        if ($unit == "1" && $frequency > 0) {
            //update next run time 
            $r_timestamp_ = date_create($r_timestamp);
            date_modify($r_timestamp_, "$frequency minutes");
            $next_r_timestamp_ =  date_format($r_timestamp_, "Y-m-d H:i:s");

            updatedb('tbl_services', "r_timestamp='$next_r_timestamp_'", "id= $id");
        } elseif ($unit == "2" && $frequency > 0) {
            //update next run time 
            $r_timestamp_ = date_create($r_timestamp);
            date_modify($r_timestamp_, "$frequency hours");
            $next_r_timestamp_ =  date_format($r_timestamp_, "Y-m-d H:i:s");

            updatedb('tbl_services', "r_timestamp='$next_r_timestamp_'", "id= $id");
        } elseif ($unit == "3" && $frequency > 0) {
            //update next run time 
            $r_timestamp_ = date_create($r_timestamp);
            date_modify($r_timestamp_, "$frequency days");
            $next_r_timestamp_ =  date_format($r_timestamp_, "Y-m-d H:i:s");

            updatedb('tbl_services', "r_timestamp='$next_r_timestamp_'", "id= $id");
        } elseif ($unit == "4" && $frequency > 0) {
            //update next run time 
            $r_timestamp_ = date_create($r_timestamp);
            date_modify($r_timestamp_, "$frequency weeks");
            $next_r_timestamp_ =  date_format($r_timestamp_, "Y-m-d H:i:s");

            updatedb('tbl_services', "r_timestamp='$next_r_timestamp_'", "id= $id");
        } elseif ($unit == "5" && $frequency > 0) {
            //update next run time 
            $r_timestamp_ = date_create($r_timestamp);
            date_modify($r_timestamp_, "$frequency months");
            $next_r_timestamp_ =  date_format($r_timestamp_, "Y-m-d H:i:s");

            updatedb('tbl_services', "r_timestamp='$next_r_timestamp_'", "id= $id");
        } elseif ($unit == "6" && $frequency > 0) {
            //update next run time 
            $r_timestamp_ = date_create($r_timestamp);
            date_modify($r_timestamp_, "$frequency years");
            $next_r_timestamp_ =  date_format($r_timestamp_, "Y-m-d H:i:s");

            updatedb('tbl_services', "r_timestamp='$next_r_timestamp_'", "id= $id");
        } else {
            //implies not a repetitive service
            //update is_executed column to 'Yes'
            updatedb('tbl_services', "is_executed='Yes'", "id= $id");
        }

        $service_item = array(
            "service_address" => $service_address,
            "log" => $log
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