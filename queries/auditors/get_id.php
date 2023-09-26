<?php
if(isset($_POST['val']) && $_POST['role']==3){
  $sql = "UPDATE `auditors` SET `name`=:name ,`status`=:status, about_me=:about_me, title=:title, image=:image WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $wch);
  $db->bind(":name", $_POST['val']['name']);
  $db->bind(":status", $_POST['val']['status']);
  $db->bind(":about_me", $_POST['val']['about_me']);
  $db->bind(":title", $_POST['val']['title']);
  $db->bind(":image", $_POST['val']['image']);
  $changed = $db->execute();
  $arr = '';
  $cod = 200;
  $txt = 'OK';
}else{
  //***************************** SQL *******************************************
  $sql = "SELECT * FROM auditors WHERE id=:id";
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
