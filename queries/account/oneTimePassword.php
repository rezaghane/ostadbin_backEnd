<?php
$ip_user = (isset($_SERVER['HTTP_TRUE_CLIENT_IP'])) ? $_SERVER['HTTP_TRUE_CLIENT_IP'] : $_SERVER['REMOTE_ADDR'];
if(isset($_POST['username']) ){
  $sql = "SELECT * FROM(
    SELECT id, fullname, province, county, field, status, degrees, email, mobile, '' AS about_me, address, 1 AS role, COUNT(*) AS cnt FROM users WHERE status=1 AND username=:username
     UNION
    SELECT id, fullname, province, county, field, status, degrees, email, public_phone AS mobile, about_me, address, 2 AS role, COUNT(*) AS cnt FROM teachers WHERE username=:username
  )A WHERE id  IS NOT NULL";
  $db->query($sql);
  $db->bind(":username", $_POST['username']);
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
    ];
    $arr = [
      "username" => $DATA,
      "token" => base64_encode(base64_encode(base64_encode($data->id."_".$data->urole."_".$ip_user."_".jdate("Y/n/d"). " ".date("H:i"))))
    ];
    // تایید شده است
    $cod = 200;
    $txt = 'OK';
  }
}
//******************************************************************************
else if(isset($_POST['mobile'])){
  $sql = "
  SELECT id, username, 1 AS role FROM users WHERE mobile=:mobile
  UNION ALL
  SELECT id, username, 2 AS role FROM teachers WHERE phone=:mobile
  ";
  $db->query($sql);
  $db->bind(":mobile", $_POST['mobile']);
  $data = $db->resultSet();
  $DATA = array();
  if(sizeof($data)>0){
    //____________________________________________________________________________
    $text = "رمز یکبار مصرف شما برابر است با: \n";
    for($i = 0; $i <sizeof($data); $i++){
      $password = rand(9999, 99999);
        $T = ($data[$i]->role==2) ? ' مدرس ' : "دانش آموز ";
        $text .= "با کاربری: ".$T." \n ";
        $text .= "رمز یکبار مصرف شما : ".$password."\n";
        $text .= ($i+1 == sizeof($data)) ? "" : "_________________________________ \n";
        $D = [
          "username"=> $data[$i]->username,
          "password"=> $password,
        ];
        array_push($DATA, $D);
    }
    $text .= " است. ";

    $arr = [
      "text" => $text,
      "DATA" => $DATA,
    ];
    $cod = 200;
    $txt = 'OK';
  }else{
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "mobile is not true";
  }
}
?>
