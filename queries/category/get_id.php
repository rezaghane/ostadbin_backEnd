<?php
if(isset($_POST['name']) && $_POST['role']==3){
  $sql = "UPDATE `category` SET `name`=:name ,`degrees`=:degrees ,`status`=:status WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $wch);
  $db->bind(":name", $_POST['name']);
  $db->bind(":status", $_POST['status']);
  $db->bind(":degrees", implode(",", $_POST['degrees']));
  $changed = $db->execute();
  $arr = implode(",", $_POST['degrees']);
  $cod = 200;
  $txt = 'OK';
}else{
  //***************************** SQL *******************************************
  $sql = "SELECT id, name, status, degrees FROM category WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $wch);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $arr = [
      "id"=> $data[0]->id,
      "name"=> $data[0]->name,
      "status"=> $data[0]->status,
      "degrees"=> explode("," , $data[0]->degrees),
    ];
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
