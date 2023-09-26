<?php
//******************************************************************************
if(isset($_POST['phone'])){
  $sql = "SELECT SUM(cnt) AS cnt FROM (
  SELECT COUNT(*) AS cnt FROM users WHERE mobile=:phone UNION ALL
  SELECT COUNT(*) AS cnt FROM teachers WHERE phone=:phone ) A";
  $db->query($sql);
  $db->bind(":phone", $_POST['phone']);
  $data = $db->resultSet()[0]->cnt;
  $arr = $data;
  $cod = 200;
  $txt = 'OK';
}
//******************************************************************************
else if(isset($_POST['userPhone'])){
  $sql = "SELECT SUM(cnt) AS cnt FROM (SELECT COUNT(*) AS cnt FROM users WHERE mobile=:phone) A";
  $db->query($sql);
  $db->bind(":phone", $_POST['userPhone']);
  $data = $db->resultSet()[0]->cnt;
  $arr = $data;
  $cod = 200;
  $txt = 'OK';
}
//******************************************************************************
?>
