<?php
session_start();
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header(
    'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'
);

include_once '../../php_functions/functions.php';
include_once '../../configs/conn.inc';

//Get and set string query variable;
$where = isset($_GET["where_"]) ? $_GET["where_"] : 'id > 0';
$offset = isset($_GET["offset"]) ? $_GET["offset"] : 0;
$rpp = isset($_GET["rpp"]) ? $_GET["rpp"] : 10;
//$page_no = isset($_GET["page_no"]) ? $_GET["page_no"] : 1;
$orderby = isset($_GET["orderby"]) ? $_GET["orderby"] : "id";
$dir = isset($_GET["dir"]) ? $_GET["dir"] : "DESC";
$search = isset($_GET["search"]) ? $_GET["search"] : "";

$limit = "$offset, $rpp";


//company name lookup
$company_array = array();
$company_ = fetchtable2("tbl_companies", "name LIKE \"%$search%\"", "id", "asc", "id");
$company_count = mysqli_num_rows($company_);
if($company_count > 0){
    while($company_list = mysqli_fetch_array($company_)){
        $company_id_ = $company_list['id'];
        array_push($company_array, $company_id_);
    }
    $service_company_list = implode(", ", $company_array);
    $orservicecompany = " OR `company_name` IN ($service_company_list)";
}


if ((input_available($search)) == 1) {
    $andsearch = " AND (`name` LIKE \"%$search%\" OR email LIKE \"%$search%\" $orservicecompany)";
} else {
    $andsearch = "";
}

$ms = fetchtable('tbl_users', "$where $andsearch", "$orderby", "$dir", "$limit", "id, uuid_v4, name, email, created_at, company_id, status");

///----------Paging Option
$alltotal = countotal("tbl_users", "$where $andsearch");

if ($alltotal > 0) {
    //Service array 
    $users_arr = array("success" => true, "count" => $alltotal);
    $users_arr['data'] = array();

    while ($row = mysqli_fetch_array($ms)) {
        extract($row);
        $company_name = fetchrow('tbl_companies', "id='" . $company_id . "'", "name");
        $added_by_ = fetchrow('tbl_users', "id='" . $added_by . "'", "name");
        $user_item = array(
          "id" => $id,
          "uuid_v4" => $uuid_v4,
          "email" => $email,
          "name" => $name,
          "company_name" => $company_name,
          "added_by" => $added_by_, 
          "created_at" => $created_at,
          "status" => $status,
        );

        //push to "data" 
        array_push($users_arr["data"], $user_item);
    }
    //Turn to JSON & output 
    exit(json_encode($users_arr));
} else {
    exit(json_encode(
        array("success" => false, "message" => "No user found")
    ));
}

?>
    