<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/crud.php');
date_default_timezone_set('Asia/Kolkata');
include_once('../includes/functions.php');
$fn = new functions;
$fn->monitorApi('settings');
$db = new Database();
$db->connect();
$sql = "SELECT chat_support FROM `settings`";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $response['success'] = true;
    $response['message'] = "Settings listed Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Data Found";
    print_r(json_encode($response));

}

?>