<?php
if(isset($_POST['value']) && isset($_POST['mod']) && $_POST['role']==3){
  $sql = "UPDATE `settings` SET `".$_POST['mod']."`=:value  WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $wch);
  $db->bind(":value", $_POST['value']);
  $changed = $db->execute();
  $arr = "";
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
