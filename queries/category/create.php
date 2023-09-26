<?php
if(isset($_POST['name']) && $_POST['role']==3){
  $sql = "INSERT INTO `category`(name, status) VALUES (:name, :status)";
  $db->query($sql);
  $db->bind(":name", $_POST['name']);
  $db->bind(":status", $_POST['status']);
  $changed = $db->execute();
  $arr = '';
  $cod = 200;
  $txt = 'OK';
}
?>
