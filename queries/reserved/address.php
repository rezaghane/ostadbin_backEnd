<?php
  $sql = "UPDATE `reserved` SET `address`=:address WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $mod);
  $db->bind(":address", $_POST['address']);
  $changed = $db->execute();
  if($changed){
    $arr = $mod;
    $cod = 200;
    $txt = 'OK';
  }else{
    $cod = 400;
    $txt = "";
  }
?>
