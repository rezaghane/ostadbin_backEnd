<?php
$sql = "INSERT INTO `reserved`(user, `degre`, `category`, `field`, `explain_user`, `address`, `date`, `time`, `status`) VALUES (:user, :degre, :category, :field, :explain_user, :address, :date, :time, 7)";
$db->query($sql);
$db->bind(":user", $_POST['user']);
$db->bind(":degre", $_POST['degre']);
$db->bind(":category", $_POST['category']);
$db->bind(":field", $_POST['field']);
$db->bind(":explain_user", $_POST['explain']);
$db->bind(":address", $_POST['address']);
$db->bind(":date", jdate("Y/n/d"));
$db->bind(":time", date("H:i:s"));

$changed = $db->execute();
if($changed){
  $arr = $db->insert_id();
  $cod = 200;
  $txt = 'OK';
}else{
  $cod = 400;
  $txt = "";
}
?>
