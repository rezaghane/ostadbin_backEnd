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
  $sql = "SELECT * FROM teachers WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $wch);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $f = json_decode($data[0]->files, JSON_UNESCAPED_UNICODE);
    $files = [
      'f1' => (isset($f['f1'])) ? $f['f1'] : [],
      'f2' => (isset($f['f2'])) ? $f['f2'] : [],
    ];
    $DATA = [
      "id" => $data[0]->id,
      "fullname" => $data[0]->fullname,
      "mobile" => $data[0]->phone,
      "phone" => $data[0]->phone,
      "province" => $data[0]->province,
      "county" => $data[0]->county,
      "sex" => $data[0]->sex,
      "field" => $data[0]->field,
      "degrees" => $data[0]->degrees,
      "category" => $data[0]->cats,
      "public_phone" => $data[0]->public_phone,
      "address" => $data[0]->address,
      "about_me" => $data[0]->about_me,
      "email" => $data[0]->email,
      "username" => $data[0]->username,
      "password" => $data[0]->password,
      "commission" => $data[0]->commission,
      "status" => $data[0]->status,
      "files" => $files,
      "img"=> imgFinder($data[0]->id, 2),
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
