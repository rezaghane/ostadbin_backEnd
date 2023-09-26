<?php
if(isset($_POST['name']) && $_POST['role']==3){
  $sql = "SELECT COUNT(*) AS cnt FROM(
  SELECT username FROM users WHERE username=:username
  UNION ALL
  SELECT username FROM teachers WHERE username=:username
  UNION ALL
  SELECT username FROM admins WHERE username=:username AND id!=:id
  )A";
  $db->query($sql);
  $db->bind(":username", $_POST['username']);
  $db->bind(":id", $wch);
  $data = $db->resultSet();
  $cnt = $data[0]->cnt;
  if($cnt == 0){
    $sql = "UPDATE `admins` SET `username`=:username ,`password`=MD5(:password) ,`email`=:email ,`fullname`=:fullname ,`status`=:status WHERE id=:id";
    $db->query($sql);
    $db->bind(":id", $wch);
    $db->bind(":email", $_POST['email']);
    $db->bind(":status", $_POST['status']);
    $db->bind(":username", $_POST['username']);
    $db->bind(":password", $_POST['password']);
    $db->bind(":fullname", $_POST['name']);
    $changed = $db->execute();
    $arr = '';
    $cod = 200;
    $txt = 'OK';
  }else{
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "data not found";
  }
}else{
  //***************************** SQL *******************************************
  $sql = "SELECT * FROM admins WHERE id=:id";
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
