<?php
$sql = "INSERT INTO `comment` (`text`, `email`, `mobile`, `fullname`, `date`, `time`) VALUES (:txt, :email, :mobile, :fullname, :date, :time);";
$db->query($sql);
$db->bind(":email", $_POST['email']);
$db->bind(":fullname", $_POST['fullname']);
$db->bind(":mobile", $_POST['mobile']);
$db->bind(":txt", $_POST['text']);
$db->bind(":date", jdate("Y/n/d"));
$db->bind(":time", date("H:i:s"));



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
