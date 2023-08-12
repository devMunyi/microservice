<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);
date_default_timezone_set("Africa/Nairobi");

//db variables
$hostname = 'localhost'; 
$dbname   = 'microservice_db'; // Your database name.
$username = 'root';             // Your database username.
$password = '';


// Let's connect to host
$con=mysqli_connect($hostname,$username,$password,$dbname);
if(mysqli_connect_errno())
{
    printf('Error Establishing a database connection');
    exit();
}


$thismin = date('i');
$thishour = date('H');
$thisday = date('d');
$thisdayname = date('D');
$thismonth = date('m');
$thisyear = date('Y');
$current_fulldate = date('Y-m-d H:i:s');

?>