<?php

include_once('crud.php');
require_once('firebase.php');
require_once('push.php');
require_once('functions.php');


$fn = new functions;
class custom_functions
{
    protected $db;
    function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }


    function xss_clean_array($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->xss_clean($value);
            }
        } else {
            $array = $this->xss_clean($array);
        }
        return $array;
    }

    function xss_clean($data)
    {
        $data = trim($data);
        // Fix &entity\n;
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        // we are done...
        return $data;
    }
    public function get_configurations()
    {
        $sql = "SELECT value FROM system_settings WHERE `variable`='system_timezone'";
        $this->db->sql($sql);
        $res = $this->db->getResult();
        if (!empty($res)) {
            return json_decode($res[0]['value'], true);
        } else {
            return false;
        }
    }

    public function get_value($table,$col,$id)
    {
        $sql = "SELECT $col FROM $table WHERE `id`= $id";
        $this->db->sql($sql);
        $res = $this->db->getResult();
        if (!empty($res)) {
            return $res[0][$col];
        } else {
            return 0;
        }
    }
    public function get_code_per_cost($id)
    {
        $sql = "SELECT per_code_cost FROM users WHERE id=" . $id;
        $this->db->sql($sql);
        $res = $this->db->getResult();
        if (!empty($res) && isset($res[0]['per_code_cost'])) {
            return $res[0]['per_code_cost'];
        } else {
            return COST_PER_CODE;
        }
    }
    
    public function validate_image($file, $is_image = true)
    {
        if (function_exists('finfo_file')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $file['tmp_name']);
        } else if (function_exists('mime_content_type')) {
            $type = mime_content_type($file['tmp_name']);
        } else {
            $type = $file['type'];
        }
        $type = strtolower($type);
        if ($is_image == false) {
            if (in_array($type, array('text/plain', 'application/csv', 'application/vnd.ms-excel', 'text/csv'))) {
                return true;
            } else {
                return false;
            }
        } else {
            if (in_array($type, array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'application/octet-stream'))) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function get_settings($variable, $is_json = false)
    {
        if ($variable == 'logo' || $variable == 'Logo') {
            $sql = "select value from `settings` where variable='Logo' OR variable='logo'";
        } else {
            $sql = "SELECT value FROM `settings` WHERE `variable`='$variable'";
        }

        $this->db->sql($sql);
        $res = $this->db->getResult();
        if (!empty($res) && isset($res[0]['value'])) {
            if ($is_json)
                return json_decode($res[0]['value'], true);
            else
                return $res[0]['value'];
        } else {
            return false;
        }
    }
    public function send_notification_to_user($notify_user_id, $notify_post_id, $type, $category)
    {
        if($type == 'post'){
            $sql = "SELECT * FROM users WHERE id = '" . $notify_user_id . "'";
            $this->db->sql($sql);
            $res = $this->db->getResult();
            $sql = "SELECT * FROM posts WHERE id = '" . $notify_post_id . "'";
            $this->db->sql($sql);
            $postres = $this->db->getResult();
            $user_id = $postres[0]['user_id'];
            $user_name = $res[0]['name'];
            $title = $user_name .' '. $category . ' Your Post';
            $sql = "INSERT INTO notifications (`user_id`,`notify_user_id`,`notify_post_id`,`title`,`type`) VALUES ('$user_id','$notify_user_id','$notify_post_id','$title','$type')";
            $this->db->sql($sql);

        }
        else{
            $sql = "SELECT * FROM users WHERE id = '" . $notify_user_id . "'";
            $this->db->sql($sql);
            $res = $this->db->getResult();
            $user_name = $res[0]['name'];
            $title = $user_name .' Started Following You';
            $sql = "INSERT INTO notifications (`user_id`,`notify_user_id`,`title`,`type`) VALUES ('$notify_post_id','$notify_user_id','$title','$type')";
            $this->db->sql($sql);

        }

    }
    public function get_role($id)
    {
        $sql = "SELECT role FROM admin WHERE id=" . $id;
        $this->db->sql($sql);
        $res = $this->db->getResult();
        if (!empty($res) && isset($res[0]['role'])) {
            return $res[0]['role'];
        } else {
            return 0;
        }
    }
    public function get_permissions($id)
    {
        $sql = "SELECT permissions FROM admin WHERE id=" . $id;
        $this->db->sql($sql);
        $res = $this->db->getResult();
        if (!empty($res) && isset($res[0]['permissions'])) {
            return json_decode($res[0]['permissions'], true);
        } else {
            return 0;
        }
    }

}
// $this->db->disconnect();
