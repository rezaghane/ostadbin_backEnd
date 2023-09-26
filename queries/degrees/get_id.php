<?php
if(isset($_POST['name']) && $_POST['role']==3){
  $sql = "UPDATE `degrees` SET `name`=:name ,`status`=:status WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $wch);
  $db->bind(":name", $_POST['name']);
  $db->bind(":status", $_POST['status']);
  $changed = $db->execute();
  $arr = '';
  $cod = 200;
  $txt = 'OK';
}else{
  //***************************** SQL *******************************************
  $sql = "SELECT id, name, status FROM degrees WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $wch);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $arr = $data[0];
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
