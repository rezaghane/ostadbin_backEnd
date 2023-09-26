<?php
  $sql = "SELECT COUNT(*) AS cnt FROM(
  SELECT username FROM users WHERE username=:username
  UNION ALL
  SELECT username FROM teachers WHERE username=:username
  )A";
  $db->query($sql);
  $db->bind(":username", $_POST['username']);
  $data = $db->resultSet();
  $cnt = $data[0]->cnt;
  $arr = $cnt;
  $cod = 200;
  $txt = 'OK';
?>
