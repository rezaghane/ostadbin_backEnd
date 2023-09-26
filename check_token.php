<?php
jdate("Y/n/d");
$ip_user = (isset($_SERVER['HTTP_TRUE_CLIENT_IP'])) ? $_SERVER['HTTP_TRUE_CLIENT_IP'] : $_SERVER['REMOTE_ADDR'];

if(isset($_POST['token'])){
  if(isset($_POST['token']['token'])){
    $user_logs = base64_decode(base64_decode(base64_decode($_POST['token']['token'])));
	$user_logs_arr = explode("_", $user_logs);
    $token_user = $user_logs_arr[0];
    $token_role = $user_logs_arr[1];
    $token_ip   = $user_logs_arr[2];	
    // اگر ای‌پی تغییر کند
    $expiration = false;
	if($token_ip != $ip_user){
		$expiration = true;
	}else{
    // اگر کاربر بیش از 1 ساعت بیکار باشد
		$sql = "SELECT dat FROM ostadbin_ir_logs.`logs` WHERE user=:user AND role=:role AND ip_user=:ip_user  ORDER BY id DESC LIMIT 1;";
		$db->query($sql);
		$db->bind(":role", $token_role);
		$db->bind(":user", $token_user);
		$db->bind(":ip_user", $token_ip);
		$data = $db->resultSet();
		if(sizeof($data)>0){
			$dat = $data[0]->dat;
			$time_end_log = explode(":",explode(" ", $dat)[1]);
			$time_to_min_log = $time_end_log[0] * 60 + $time_end_log[1];
			$time_to_min_now = date("H") * 60 + date("i");
			
			// زمان فعال بودن توکن بر اساس دقیقه
			$act_token = 60;
			if($time_to_min_now > ($time_to_min_log + $act_token)){
				$expiration = true;
			}
		}
	}
		
		
	if($expiration){
      $cod = 401;
      $txt = ' Unauthorized HTTP';
      $msg = "Token expiration";
      require_once "echoJson.php";
      return;
	}
  }
}




?>
