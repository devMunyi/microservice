<?php
    date_default_timezone_set("Africa/Nairobi");

   $thisdate=date('Y-m-d');
    //$date2=date('Y-M-D');
    $fulldate=date('Y-m-d H:i:s');
    $thisec = date('s');
    $thismin = date('i');
    $thistime = date('H:i');
    //$thistime_ = substr($thistime, 0, 5);
    //$thishour = date('H');
    $thisyear=date('Y');
    $thismonth=date('m');
    $thismonthname=date('M');
    $thisday=date('d');
    $thisdayname=date('D');
    
   echo "Current datetime is =>".$fulldate;
?>