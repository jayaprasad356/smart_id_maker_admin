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
date_default_timezone_set('Asia/Kolkata');


if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['account_num'])) {
    $response['success'] = false;
    $response['message'] = "Account Number is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['holder_name'])) {
    $response['success'] = false;
    $response['message'] = "Holder Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['bank'])) {
    $response['success'] = false;
    $response['message'] = "Bank is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['branch'])) {
    $response['success'] = false;
    $response['message'] = "Branch is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['ifsc'])) {
    $response['success'] = false;
    $response['message'] = "IFSC is Empty";
    print_r(json_encode($response));
    return false;
}

$ifsc = $db->escapeString($_POST['ifsc']);
if (!preg_match("/^[A-Z]{4}0[A-Z0-9]{6}$/", $ifsc)) {
    $response['success'] = false;
    $response['message'] = "IFSC code 11 digits - 5th Digit Is Always ZERO";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$account_num = $db->escapeString($_POST['account_num']);
$holder_name = $db->escapeString($_POST['holder_name']);
$bank = $db->escapeString($_POST['bank']);
$branch = $db->escapeString($_POST['branch']);

$sql = "SELECT * FROM bank_details WHERE user_id = $user_id ";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $bank_details_id = $res[0]['id'];
    $sql = "UPDATE `bank_details` SET `user_id` = '$user_id',`account_num` = '$account_num',`holder_name` = '$holder_name',`bank` = '$bank',`branch` = '$branch',`ifsc` = '$ifsc' WHERE `id` = $bank_details_id";
    $db->sql($sql);
}
else{
    $sql = "INSERT INTO bank_details (`user_id`,`account_num`,`holder_name`,`bank`,`branch`,`ifsc`)VALUES('$user_id','$account_num','$holder_name','$bank','$branch','$ifsc')";
    $db->sql($sql);

}
$sql = "SELECT * FROM bank_details WHERE user_id = $user_id";
$db->sql($sql);
$res = $db->getResult();

$response['success'] = true;
$response['message'] = "Bank Details Updated Successfully";
$response['data'] = $res;
print_r(json_encode($response));


?>