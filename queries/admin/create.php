<?php
if(isset($_POST['username']) && $_POST['role']==3){
  $sql = "SELECT COUNT(*) AS cnt FROM(
  SELECT username FROM users WHERE username=:username
  UNION ALL
  SELECT username FROM teachers WHERE username=:username
  UNION ALL
  SELECT username FROM admins WHERE username=:username
  )A";
  $db->query($sql);
  $db->bind(":username", $_POST['username']);
  $data = $db->resultSet();
  $cnt = $data[0]->cnt;

  if($cnt == 0){
    $sql = "INSERT INTO `admins`(fullname, username, password, email, status) VALUES (:name, :username, MD5(:password), :email, :status)";
    $db->query($sql);
    $db->bind(":name", $_POST['name']);
    $db->bind(":username", $_POST['username']);
    $db->bind(":password", $_POST['password']);
    $db->bind(":email", $_POST['email']);
    $db->bind(":status", $_POST['status']);
    $changed = $db->execute();
    $arr = '';
    $cod = 200;
    $txt = 'OK';
  }else{
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "data not found";
  }
}
?>
