<?php
if($_POST['role']==3){
  $sql = "UPDATE `reserved` SET `link`=:link WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $mod);
  $db->bind(":link", $_POST['link']);
  $changed = $db->execute();
  if($changed){
    $arr = $mod;
    $cod = 200;
    $txt = 'OK';
  }else{
    $cod = 400;
    $txt = "";
  }
}
// $arr = $_POST;
// $cod = 200;
// $txt = 'OK';
?>
