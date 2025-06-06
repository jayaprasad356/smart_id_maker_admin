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

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['level'])) {
    $response['success'] = false;
    $response['message'] = "Level is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);
$level = $db->escapeString($_POST['level']);


$sql_user = "SELECT refer_code FROM users WHERE id = $user_id";
$db->sql($sql_user);
$res_user = $db->getResult();
$num = $db->numRows($res_user);
if ($num >= 1) {
    $refer_code = $res_user[0]['refer_code'];

    if ($level === 'b') {
        $sql = "SELECT *, DATE(joined_date) AS joined_date, CONCAT(SUBSTRING(mobile, 1, 2), '******', SUBSTRING(mobile, LENGTH(mobile)-1, 2)) AS mobile FROM users WHERE referred_by = '$refer_code' ORDER BY id DESC";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
    
        if ($num >= 1) {
            foreach ($res as $key => $user) {
                $user_id = $user['id'];
                $sql_plan = "SELECT * FROM outsource_user_plan WHERE user_id = $user_id AND joined_date >= '2025-01-01' AND plan_id != 5";
                $db->sql($sql_plan);
                $res_plan = $db->getResult();
                if (empty($res_plan)) {
                    unset($res[$key]);
                }
            }
            $res = array_values($res); // Reindex array after unsetting elements
            $num = count($res);
            if ($num >= 1) {
                $response['success'] = true;
                $response['message'] = "Users Listed Successfully";
                $response['count'] = $num;
                $response['data'] = $res;
                print_r(json_encode($response));
            } else {
                $response['success'] = false;
                $response['message'] = "No Users found with the specified refer_code and plan";
                print_r(json_encode($response));
            }
        } else {
            $response['success'] = false;
            $response['message'] = "No Users found with the specified refer_code";
            print_r(json_encode($response));
        }
    } 
    if ($level === 'c') {
        $sql = "SELECT *, DATE(joined_date) AS joined_date, CONCAT(SUBSTRING(mobile, 1, 2), '******', SUBSTRING(mobile, LENGTH(mobile)-1, 2)) AS mobile FROM users WHERE c_referred_by = '$refer_code' ORDER BY id DESC";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
    
        if ($num >= 1) {
            foreach ($res as $key => $user) {
                $user_id = $user['id'];
                $sql_plan = "SELECT * FROM outsource_user_plan WHERE user_id = $user_id AND joined_date >= '2025-01-01' AND plan_id != 5";
                $db->sql($sql_plan);
                $res_plan = $db->getResult();
                if (empty($res_plan)) {
                    unset($res[$key]);
                }
            }
            $res = array_values($res); // Reindex array after unsetting elements
            $num = count($res);
            if ($num >= 1) {
                $response['success'] = true;
                $response['message'] = "Users Listed Successfully";
                $response['count'] = $num;
                $response['data'] = $res;
                print_r(json_encode($response));
            } else {
                $response['success'] = false;
                $response['message'] = "No Users found with the specified refer_code and plan";
                print_r(json_encode($response));
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Not Found";
            print_r(json_encode($response));
        }
    } 
} else {
    $response['success'] = false;
    $response['message'] = "User Not found";
    print_r(json_encode($response));
}

?>
