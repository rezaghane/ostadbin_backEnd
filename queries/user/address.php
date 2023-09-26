<?php
$sql = "UPDATE users SET address=:address WHERE id=:id";
$db->query($sql);
$db->bind(":id", $_POST['username']);
$db->bind(":address", json_encode($_POST['address'], JSON_UNESCAPED_UNICODE));



$changed = $db->execute();
// // تایید شده است
if($changed){
  $arr = $db->insert_id();
  $cod = 200;
  $txt = 'OK';
}else{
  $cod = 400;
  $txt = "";
}
?>
