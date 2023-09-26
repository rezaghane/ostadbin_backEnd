<?php
if(isset($_POST['val']) && $_POST['role']==3){
  $sql = "INSERT INTO `auditors`(name, status, title, about_me, image) VALUES (:name, :status, :title, :about_me, :image)";
  $db->query($sql);
  $db->bind(":name", $_POST['val']['name']);
  $db->bind(":status", $_POST['val']['status']);
  $db->bind(":title", $_POST['val']['title']);
  $db->bind(":about_me", $_POST['val']['about_me']);
  $db->bind(":image", $_POST['val']['image']);
  $changed = $db->execute();
  $arr = '';
  $cod = 200;
  $txt = 'OK';
}
?>
