<?php
if(isset($_POST['name']) && $_POST['role']==3){
  // $sql = "UPDATE `category` SET `name`=:name ,`status`=:status WHERE id=:id";
  // $db->query($sql);
  // $db->bind(":id", $wch);
  // $db->bind(":name", $_POST['name']);
  // $db->bind(":status", $_POST['status']);
  // $changed = $db->execute();
  // $arr = '';
  // $cod = 200;
  // $txt = 'OK';
}else{
  //***************************** SQL *******************************************
  $sql = "SELECT id, province, county, username,field, `degrees`, '' AS about_me, `address`, mobile, `email`, `status`, fullname, password  FROM users WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $wch);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $DATA = [
      "id" => $data[0]->id,
      "province" => $data[0]->province,
      "county" => $data[0]->county,
      "username" => $data[0]->username,
      "field" => $data[0]->field,
      "degrees" => $data[0]->degrees,
      "about_me" => $data[0]->about_me,
      "password" => $data[0]->password,
      "address" => json_decode($data[0]->address),
      "mobile" => $data[0]->mobile,
      "phone" => $data[0]->mobile,
      "email" => $data[0]->email,
      "status" => $data[0]->status,
      "fullname" => $data[0]->fullname,
      "img"=> imgFinder($data[0]->id, 1),
      "role" => 2,
    ];
    $arr = $DATA;
    $cod = 200;
    $txt = 'OK';
  }else{
    // تایید نشده
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "data not found";
  }
}
?>
