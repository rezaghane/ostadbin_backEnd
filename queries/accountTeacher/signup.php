<?php
$ip_user = (isset($_SERVER['HTTP_TRUE_CLIENT_IP'])) ? $_SERVER['HTTP_TRUE_CLIENT_IP'] : $_SERVER['REMOTE_ADDR'];
$_POST['id'] = (isset($_POST['id'])) ? $_POST['id'] : 0;
$sql = "SELECT COUNT(*) AS cnt FROM(
SELECT username FROM users WHERE username=:username
UNION ALL
SELECT username FROM teachers WHERE username=:username AND id!=:id
UNION ALL
SELECT username FROM admins WHERE username=:username
)A";
$db->query($sql);
$db->bind(":username", $_POST['username']);
$db->bind(":id", $_POST['id']);
$data = $db->resultSet();
$cnt = $data[0]->cnt;
if(($cnt==0 && $_POST['username']!='' && !empty($_POST['username']) && !is_null($_POST['username'])) || $_POST['status']==2) {
// ********************************************************************************************
  if($_POST['id']==0){
    $sql = "INSERT INTO teachers(fullname, province, county, cats, degrees, field, about_me, address, phone, email, address_teach, sex, public_phone, username, password, dat, tim, status, commission, files) VALUES (:fullname, :province, :county, :category, :degrees, :field, :about_me, :address, :phone, :email, :address, :sex, :public_phone, :username, MD5(:password), :dat, :tim, :status, :commission, :files);";
	$db->query($sql);
  $db->bind(":about_me", $_POST['about_me']);
  $db->bind(":address", $_POST['address']);
  $db->bind(":category", $_POST['category']);
  $db->bind(":fullname", $_POST['fullname']);
  $db->bind(":phone", $_POST['phone']);
  $db->bind(":province", $_POST['province']);
  $db->bind(":county", $_POST['county']);
  $db->bind(":sex", $_POST['sex']);
  $db->bind(":degrees", $_POST['degrees']);
  $db->bind(":field", $_POST['field']);
  $db->bind(":public_phone", $_POST['public_phone']);
  $db->bind(":email", $_POST['email']);
  $db->bind(":username", $_POST['username']);
  $db->bind(":password", $_POST['password']);
  $db->bind(":status", $_POST['status']);
  $db->bind(":commission", $_POST['commission']);
  $db->bind(":files", json_encode($_POST['files'], JSON_UNESCAPED_UNICODE));
  $db->bind(":dat", jdate("Y/n/d"));
  $db->bind(":tim", date("H:i:s"));
  $changed = $db->execute();
  }else {
    $file = json_encode($_POST['files'], JSON_UNESCAPED_UNICODE);
    if($_POST['password']!=''){
      $sql = "UPDATE `teachers` SET fullname = '".$_POST['fullname']."', province = '".$_POST['province']."', county = '".$_POST['county']."', cats = '".$_POST['category']."', degrees = '".$_POST['degrees']."', field = '".$_POST['field']."', about_me = '".$_POST['about_me']."', address = '".$_POST['address']."', phone = '".$_POST['phone']."', email = '".$_POST['email']."', address_teach = '".$_POST['address']."', sex = '".$_POST['sex']."', public_phone = '".$_POST['public_phone']."', username = '".$_POST['username']."', password = MD5('".$_POST['password']."'), status = '".$_POST['status']."', commission = '".$_POST['commission']."', files = '".$file."' WHERE id=" . $_POST['id'];
    } else {
      $sql = "UPDATE `teachers` SET fullname = '".$_POST['fullname']."', province = '".$_POST['province']."', county = '".$_POST['county']."', cats = '".$_POST['category']."', degrees = '".$_POST['degrees']."', field = '".$_POST['field']."', about_me = '".$_POST['about_me']."', address = '".$_POST['address']."', phone = '".$_POST['phone']."', email = '".$_POST['email']."', address_teach = '".$_POST['address']."', sex = '".$_POST['sex']."', public_phone = '".$_POST['public_phone']."', username = '".$_POST['username']."', status = '".$_POST['status']."', commission = '".$_POST['commission']."', files = '".$file."' WHERE id=" . $_POST['id'];
    }
	$db->query($sql);
	$changed = $db->execute();
  }
  
	$DATA = [
    "id" => ($_POST['id']==0) ? $db->insert_id() : $_POST['id'],
    "fullname" => $_POST['fullname'],
    "email" => $_POST['email'],
    "mobile" => $_POST['phone'],
    "address" => $_POST['address'],
    "about_me" => $_POST['about_me'],
    "province" => $_POST['province'],
    "county" => $_POST['county'],
    "field" => $_POST['field'],
    "degrees" => $_POST['degrees'],
    "img"=> '',
    "status"=> '0',
    "role" => '2',
  ];

  $arr = [
    "username" => $DATA,
    "token" => base64_encode(base64_encode(base64_encode($db->insert_id()."_2"."_".$ip_user."_".jdate("Y/n/d"). " ".date("H:i"))))
  ];
	$cod = 200;
  $txt = 'OK';
} else{
  $cod = 400;
  $txt = 'Bad Request';
  $msg = "Username is duplicate";
}
?>
