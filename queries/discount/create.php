<?php
  $sql = "INSERT INTO discount(code, percentage, type, teachers, category, status, dat) VALUES (:code, :percentage, :type, :teachers, :category, :status, :dat)";
  $db->query($sql);
  $db->bind(":code", $_POST['val']['code']);
  $db->bind(":percentage", $_POST['val']['percentage']);
  $db->bind(":type", $_POST['val']['type']);
  $db->bind(":teachers", $_POST['val']['teachers']);
  $db->bind(":category", $_POST['val']['category']);
  $db->bind(":status", $_POST['val']['status']);
  $db->bind(":dat", jdate("Y/n/d"));
  $changed = $db->execute();
  $arr = '';
  $cod = 200;
  $txt = 'OK';
?>
