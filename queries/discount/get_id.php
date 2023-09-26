<?php
if(isset($_POST['val'])) {
    $sql = "UPDATE `discount` SET `status`=:status WHERE id=:id";
    $db->query($sql);
    $db->bind(":id", $wch);
    $db->bind(":status", $_POST['val']['status']);
    $changed = $db->execute();
    $arr = '';
    $cod = 200;
    $txt = 'OK';
}else{
  //***************************** SQL *******************************************
  $sql = "SELECT * FROM discount WHERE id=:id";
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
