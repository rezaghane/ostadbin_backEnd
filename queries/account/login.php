<?php
$ip_user = (isset($_SERVER['HTTP_TRUE_CLIENT_IP'])) ? $_SERVER['HTTP_TRUE_CLIENT_IP'] : $_SERVER['REMOTE_ADDR'];
$sql = "
SELECT * FROM(
  SELECT id, fullname, province, county, field, status, degrees, email, mobile, '' AS about_me, address, 1 AS role, COUNT(*) AS cnt FROM users WHERE status=1 AND username=:username AND password = MD5(:password) UNION
  SELECT id, fullname, province, county, field, status, degrees, email, public_phone AS mobile, about_me, address, 2 AS role, COUNT(*) AS cnt FROM teachers WHERE username=:username AND password = MD5(:password) UNION
  SELECT id, fullname, '' AS province, '' AS county, '' AS field, '' AS status, '' AS degrees, email, '' AS mobile, '' AS about_me, '' AS address, 3 AS role, COUNT(*) AS cnt FROM admins WHERE username=:username AND password= MD5(:password)
)A WHERE id  IS NOT NULL";
$db->query($sql);
$db->bind(":username", $_POST['username']);
$db->bind(":password", $_POST['password']);
$data = $db->resultSet()[0];
if($data->cnt!=0){
  //************************************************************************
  if($data->role==1){
    $address = json_decode($data->address);
  }else if($data->role==2){
    $address = $data->address;
  }
  //***************************** data ************************************
  $DATA = [
    "id" => $data->id,
    "fullname" => $data->fullname,
    "province" => $data->province,
    "county" => $data->county,
    "username" => $_POST['username'],
    "field" => $data->field,
    "degrees" => $data->degrees,
    "email" => $data->email,
    "mobile" => $data->mobile,
    "status" => $data->status,
    "address" => $address,
    "about_me" => $about_me,
    "img"=> imgFinder($data->id, $data->role),
    "role" => $data->role,
    "status" => $data->status,	
	"ip" => $_SERVER['HTTP_TRUE_CLIENT_IP'],
  ];
  $arr = [
    "username" => $DATA,
    "token" => base64_encode(base64_encode(base64_encode($data->id."_".$data->role."_".$ip_user."_".jdate("Y/n/d"). " ".date("H:i"))))
  ];
  // تایید شده است
  $cod = 200;
  $txt = 'OK';
}else{
  // تایید نشده
  $cod = 400;
  $txt = 'Bad Request';
  $msg = "User not found";
}
?>
