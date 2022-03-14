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
    
    echo "Today's Date is => ".$thisdate;
    echo "<br>Substring of today's date => ".substr($thisdate, 8, 2);
    echo "<br>Substring of today's month => ".substr($thisdate, 5, 2);  
    echo "<br>The time is => ". $thistime;
    echo "<br>Today is on => ".$thisday;  
    echo "<br>Today is on => ".$thisdayname; 
    echo "<br>This is the month of => ".$thismonth; 
    echo "<br>This is the month of => ".$thismonthname; 
    echo "<br>This is the year => ".$thisyear;

    echo "<br>Time testing =>".time();
    echo "<br>Current secs =>".date('s');

    if("04" > "03"){
        echo "<br><br>Yes it true";
    }else{
        echo "<br><br>False it's not";
    }
    
    $fulldate_ = date_create($fulldate);
    //date_add($fulldate_, date_interval_create_from_date_string("1 minute"));
    date_modify($fulldate_, "+1 months");
    $nextfulldate =  date_format($fulldate_, "Y-m-d H:i:s");
    echo "<br>Current full date is =>".$fulldate;
    echo "<br>Current full date plus 1 month is =>".$nextfulldate;
    //2022-02-19 15:30:00
?>