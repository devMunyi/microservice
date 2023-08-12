<?php
    

    include_once("./php_functions/functions.php");
    include_once("./configs/conn.inc");

    // $current_fulldate

    $cur_date = $current_fulldate;
    $compar_date = "2023-08-14 08:10:30";
    $units = 1;
    $frequency = 1;
    $service_address = "";

    $cur_date_obj = new DateTime($cur_date);
    $compar_date_obj = new DateTime($compar_date);

    // minutes run
    if($units == 1){
        $interval = $cur_date_obj->diff($compar_date_obj);
        $totalMinutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

        if($totalMinutes >= $frequency){
            $result = serviceCaller($service_address);
            $http_code = $result['http_code'];
            $execution_time = $result['execution_time'];
        }
    }


    // hours run
    if($units == 2){
        $interval = $cur_date_obj->diff($compar_date_obj);
        $totalHours = ($interval->days * 24) + $interval->h + ($interval->i / 60);

        if($totalHours >= $frequency){
            $result = serviceCaller($service_address);
            $http_code = $result['http_code'];
            $execution_time = $result['execution_time'];
        }
    }


    // days run
    if($units == 3){
        $interval = $cur_date_obj->diff($compar_date_obj);
        $totalDays = $interval->days;

        if($totalDays >= $frequency){
            $result = serviceCaller($service_address);
            $http_code = $result['http_code'];
            $execution_time = $result['execution_time'];
        }
    }


/*


suppose in mysql table named customers I have a column added_date of type datetime
and have current_date = 2023-08-14 08:10:30

Will the following query be correct?
SELECT * FROM customers WHERE added_date < 'current_date';

*/


    // $date1 = "2023-08-13 08:10:10";
    // $date2 = "2023-08-13 08:10:40"; 
    // $date2 = substr($date2, 0, -3); // remove seconds portion

    $date1 = new DateTime("0000-00-00 00:00:00");
    $date2 = new DateTime("2023-08-13 08:10:30");


    $interval = $date1->diff($date2);

    $totalMinutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

    echo "Difference in minutes: " . $totalMinutes . " minutes";

    $totalHours = ($interval->days * 24) + $interval->h + ($interval->i / 60);

    echo "Difference in hours: " . $totalHours . " hours";

    $totalDays = $interval->days;

    echo "Difference in days: " . $totalDays . " days";
