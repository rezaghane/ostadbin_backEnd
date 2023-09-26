<?php
$ip_user = (isset($_SERVER['HTTP_TRUE_CLIENT_IP'])) ? $_SERVER['HTTP_TRUE_CLIENT_IP'] : $_SERVER['REMOTE_ADDR'];
$_POST['id'] = (isset($_POST['id'])) ? $_POST['id'] : 0;
$_POST['province'] = (isset($_POST['province'])) ? $_POST['province'] : 0;
$_POST['county'] = (isset($_POST['county'])) ? $_POST['county'] : 0;
$_POST['degrees'] = (isset($_POST['degrees'])) ? $_POST['degrees'] : 0;
$_POST['field'] = (isset($_POST['field'])) ? $_POST['field'] : 0;
$_POST['status'] = (isset($_POST['status'])) ? $_POST['status'] : 1;

$sql = "SELECT COUNT(*) AS cnt FROM(
SELECT username FROM users WHERE username=:username AND id!=:id
UNION ALL
SELECT username FROM teachers WHERE username=:username
UNION ALL
SELECT username FROM admins WHERE username=:username
)A";
$db->query($sql);
$db->bind(":username", $_POST['username']);
$db->bind(":id", $_POST['id']);
$data = $db->resultSet();
$cnt = $data[0]->cnt;
if($cnt==0 && $_POST['username']!='' && !empty($_POST['username']) && !is_null($_POST['username']) ) {
  //********************************************************************************************
  if($_POST['id']==0){
    $sql = "INSERT INTO users(`fullname`, `username`, `password`, `mobile`, `email`, `date`, `time`, province, county, degrees, field, status) VALUES (:fullname, :username, MD5(:password), :mobile, :email, :date, :time, :province, :county, :degrees, :field, :status);";
  }else{
    if($_POST['password'] != ''){
      $sql = "UPDATE `users` SET fullname='".$_POST['fullname']."', province='".$_POST['province']."', county='".$_POST['county']."', degrees='".$_POST['degrees']."', field='".$_POST['field']."', mobile='".$_POST['phone']."', email='".$_POST['email']."', username='".$_POST['username']."', password=MD5('".$_POST['password']."'), status='".$_POST['status']."'  WHERE id=".$_POST['id'];
    }
    if($_POST['password'] == ''){
      $sql = "UPDATE `users` SET fullname='".$_POST['fullname']."', province='".$_POST['province']."', county='".$_POST['county']."', degrees='".$_POST['degrees']."', field='".$_POST['field']."', mobile='".$_POST['phone']."', email='".$_POST['email']."', username='".$_POST['username']."', status='".$_POST['status']."'  WHERE id=".$_POST['id'];
    }
  }
  $db->query($sql);
	$db->bind(":username", $_POST['username']);
  $db->bind(":password", $_POST['password']);
  $db->bind(":fullname", $_POST['fullname']);
  $db->bind(":mobile", $_POST['mobile']);
  $db->bind(":email", $_POST['email']);
  $db->bind(":province", $_POST['province']);
  $db->bind(":county", $_POST['county']);
  $db->bind(":degrees", $_POST['degrees']);
  $db->bind(":field", $_POST['field']);
  $db->bind(":status", $_POST['status']);
	$db->bind(":date", jdate("Y/n/d"));
	$db->bind(":time", date("H:i:s"));
  $changed = $db->execute();
  $id = ($_POST['id']==0) ? $db->insert_id() : $_POST['id'];
  $DATA = [
    "id" => $id,
    "fullname" => $_POST['fullname'],
    "username" => $_POST['username'],
    "email" => $_POST['email'],
    "mobile" => $_POST['mobile'],
    "province" => 0,
    "county" => 0,
    "field" => 0,
    "degrees" => 0,
    "status" => 1,
    "address" => [],
    "about_me" => '',
    "img"=> '',
    "role" => 1,
  ];
  $arr = [
    "username" => $DATA,
    "token" => base64_encode(base64_encode(base64_encode($id."_1"."_".$ip_user."_".jdate("Y/n/d"). " ".date("H:i"))))
  ];
	$cod = 200;
  $txt = 'OK';
} else{
  // نام کاربری تکراری است
  $cod = 400;
  $txt = 'Bad Request';
  $msg = "Username is duplicate";
}
?>
