<?php
// Headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once("../../php_functions/functions.php");
include_once("../../configs/conn.inc");

$loop_expiry_time = time() + 60;

while (time() < $loop_expiry_time) {
    $ms = fetchtable("tbl_services", "DATE_FORMAT(next_run_datetime, '%Y-%m-%d %H:%i:%s') = '$current_fulldate' AND is_executed = 'No' AND status > 0", "id", "DESC", "100", "id, service_title, service_address, last_run_datetime, next_run_datetime, unit, frequency, is_executed, repeated");
    ///----------Paging Option
    
    $alltotal = countotal("tbl_services", "DATE_FORMAT(next_run_datetime, '%Y-%m-%d %H:%i:%s') = '$current_fulldate' AND is_executed = 'No' AND is_executed = 'No' AND status > 0");
    
    if ($alltotal > 0) {
        //Service array 
        $services_arr = array("success" => true, "count" => $alltotal);
        $services_arr['data'] = array();
    
        while ($row = mysqli_fetch_array($ms)) {
            extract($row);
            $ch = curl_init($service_address);
            $options = array(
                CURLOPT_HEADER         => true,
                CURLOPT_NOBODY         => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 0,
                CURLOPT_TIMEOUT        => 10, // set timeout as 10 seconds
            );
            curl_setopt_array($ch, $options);
            
            // Measure the start time
            $start_time = microtime(true);
    
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
            // Measure the end time
            $end_time = microtime(true);
    
            // Calculate the execution time
            $execution_time = $end_time - $start_time;
    
            curl_close($ch);
    
            //check for status code to determined whether failed on executed
            if($httpcode == "200"){
                $log = "Success with an execution time of $execution_time seconds";
            }else{
                $log = "Failed with code $httpcode and execution time of $execution_time seconds";
            }
    
            $fds = array('log', 'service_id');
            $vals = array("$log", "$id");
            addtodb('tbl_logs', $fds, $vals);
    
            //update the availabe services table accordingly 
            if ($repeated == 'No') {
                //update is_executed column to 'Yes'
                updatedb('tbl_services', "is_executed='Yes', last_run_datetime='$next_run_datetime', next_run_datetime='0000-00-00 00:00'", "id= $id");
            } elseif ($unit == "1") {
                //update last run time 
                $current_run_datetime = date_create($next_run_datetime);
                $last_run_datetime = date_format($current_run_datetime, "Y-m-d H:i:s");
    
                //update next run time
                date_modify($current_run_datetime, "$frequency seconds");
                $next_run_datetime =  date_format($current_run_datetime, "Y-m-d H:i:s");
    
                $updatefds = "last_run_datetime='$last_run_datetime', next_run_datetime='$next_run_datetime'";
                $update = updatedb('tbl_services',"$updatefds","id= $id");
            } elseif ($unit == "2") {
               //update last run time 
               $current_run_datetime = date_create($next_run_datetime);
               $last_run_datetime = date_format($current_run_datetime, "Y-m-d H:i:s");
    
               //update next run time
               date_modify($current_run_datetime, "$frequency minutes");
               $next_run_datetime =  date_format($current_run_datetime, "Y-m-d H:i:s");
    
               $updatefds = "last_run_datetime='$last_run_datetime', next_run_datetime='$next_run_datetime'";
               $update = updatedb('tbl_services',"$updatefds","id= $id");
            } elseif ($unit == "3") {
                //update last run time 
                $current_run_datetime = date_create($next_run_datetime);
                $last_run_datetime = date_format($current_run_datetime, "Y-m-d H:i:s");
    
                //update next run time
                date_modify($current_run_datetime, "$frequency hours");
                $next_run_datetime =  date_format($current_run_datetime, "Y-m-d H:i:s");
    
                $updatefds = "last_run_datetime='$last_run_datetime', next_run_datetime='$next_run_datetime'";
                $update = updatedb('tbl_services',"$updatefds","id= $id");
            } elseif ($unit == "4") {
                //update last run time 
                $current_run_datetime = date_create($next_run_datetime);
                $last_run_datetime = date_format($current_run_datetime, "Y-m-d H:i:s");
    
                //update next run time
                date_modify($current_run_datetime, "$frequency days");
                $next_run_datetime =  date_format($current_run_datetime, "Y-m-d H:i:s");
    
                $updatefds = "last_run_datetime='$last_run_datetime', next_run_datetime='$next_run_datetime'";
                $update = updatedb('tbl_services',"$updatefds","id= $id");
    
            } elseif ($unit == "5") {
                //update last run time 
                $current_run_datetime = date_create($next_run_datetime);
                $last_run_datetime = date_format($current_run_datetime, "Y-m-d H:i:s");
    
                //update next run time
                date_modify($current_run_datetime, "$frequency weeks");
                $next_run_datetime =  date_format($current_run_datetime, "Y-m-d H:i:s");
    
                $updatefds = "last_run_datetime='$last_run_datetime', next_run_datetime='$next_run_datetime'";
                $update = updatedb('tbl_services',"$updatefds","id= $id");
            } elseif ($unit == "6") {
                //update last run time 
                $current_run_datetime = date_create($next_run_datetime);
                $last_run_datetime = date_format($current_run_datetime, "Y-m-d H:i:s");
    
                //update next run time
                date_modify($current_run_datetime, "$frequency months");
                $next_run_datetime =  date_format($current_run_datetime, "Y-m-d H:i:s");
    
                $updatefds = "last_run_datetime='$last_run_datetime', next_run_datetime='$next_run_datetime'";
                $update = updatedb('tbl_services',"$updatefds","id= $id");
            } elseif ($unit == "7") {
                //update last run time 
                $current_run_datetime = date_create($next_run_datetime);
                $last_run_datetime = date_format($current_run_datetime, "Y-m-d H:i:s");
    
                //update next run time
                date_modify($current_run_datetime, "$frequency years");
                $next_run_datetime =  date_format($current_run_datetime, "Y-m-d H:i:s");
    
                $updatefds = "last_run_datetime='$last_run_datetime', next_run_datetime='$next_run_datetime'";
                $update = updatedb('tbl_services',"$updatefds","id= $id");
            } 
    
            $service_item = array(
                "service_title" => $service_title,
                "service_address" => $service_address,
                "log" => $log
            );
    
            //push to "data" 
            array_push($services_arr["data"], $service_item);
        }
        // Turn to JSON & output 
        echo json_encode($services_arr);

    } else {
        exit(json_encode(
            array("success" => false, "message" => "No service found")
        ));
    }  

    sleep(1);
}

?>