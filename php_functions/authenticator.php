<?php
include_once ("../configs/conn.inc");
include_once ("functions.php");

$userd = session_details();
if($userd == null){
    echo "<meta http-equiv=\"refresh\" content= \"0, URL=login\" />";
    exit("Your session is invalid");
}

// $token = $_SESSION['msu-token'];
// $valid = validatetoken($token);
// if($valid == 0){
//     echo "<meta http-equiv=\"refresh\" content= \"0, URL=login\" />";
//     die("Your session is invalid");
// }
// else{
//     ////=======Good to go
// }