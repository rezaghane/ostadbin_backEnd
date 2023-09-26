<?php
$get_logs = json_encode($_GET, JSON_UNESCAPED_UNICODE);
$post_logs = json_encode($_POST, JSON_UNESCAPED_UNICODE);
$ip_logs = (isset($_SERVER['HTTP_TRUE_CLIENT_IP'])) ? $_SERVER['HTTP_TRUE_CLIENT_IP'] : $_SERVER['REMOTE_ADDR'];
$url_logs = $_SERVER['REQUEST_URI'];
$role_logs = (isset($_POST['role'])) ? $_POST['role'] : '0';

$user_logs = "";
if(isset($_POST['token'])){
  if(isset($_POST['token']['token'])){
    $user_logs = base64_decode(base64_decode(base64_decode($_POST['token']['token'])));
    $user_logs = explode("_", $user_logs)[0];
  }
}


$sql = "INSERT INTO ostadbin_ir_logs.logs(role, url, post_data, get_data, user, ip_user, dat) VALUES (:role, :url, :post_data, :get_data, :user, :ip_user, :dat)";
$db->query($sql);

$db->bind(":role", $role_logs);
$db->bind(":user", $user_logs);
$db->bind(":ip_user", $ip_logs);
$db->bind(":post_data", $post_logs);
$db->bind(":get_data", $get_logs);
$db->bind(":url", $url_logs);
$db->bind(":dat", jdate("Y/n/d"). " ".date("H:i"));



$data = $db->resultSet();


?>
