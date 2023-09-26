<?php
if($_POST['role']==1){
  $sql = "UPDATE `reserved` SET `grade`=:grade WHERE id=:id";
  $db->query($sql);
  $db->bind(":id", $mod);
  $db->bind(":grade", $_POST['grade']);
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
?>
