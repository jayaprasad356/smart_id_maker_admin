<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/crud.php');

$db = new Database();
$db->connect();
include_once('../includes/functions.php');
$fn = new functions;
$fn->monitorApi('register');
date_default_timezone_set('Asia/Kolkata');

if (empty($_POST['email'])) {
    $response['success'] = false;
    $response['message'] = "Email Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['mobile'])) {
    $response['success'] = false;
    $response['message'] = "Mobilenumber is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = "Password is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['dob'])) {
    $response['success'] = false;
    $response['message'] = "Date of Birth is Empty";
    print_r(json_encode($response));
    return false;
}

$dob = $db->escapeString($_POST['dob']);
$mobile = $db->escapeString($_POST['mobile']);
$email = $db->escapeString($_POST['email']);
$password = $db->escapeString($_POST['password']);

$sql = "SELECT * FROM users WHERE mobile='$mobile' AND email='$email' AND dob='$dob'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $sql_query = "UPDATE users SET password='$password' WHERE mobile = '$mobile' AND email='$email'";
    $db->sql($sql_query);
    $response['success'] = true;
    $response['message'] ="Password Changed Successfully";
    print_r(json_encode($response));
    return false;
}
else{
    $response['success'] = false;
    $response['message'] = "Invalid Credentials";
    print_r(json_encode($response));


}

?>