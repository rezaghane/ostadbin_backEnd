<?php
$sql = "INSERT INTO `charity`(money, nam, phone, exp, ip) VALUES (:money, :nam, :phone, :exp, :ip);";
$db->query($sql);
$db->bind(":money", $_POST['val']['money']);
$db->bind(":nam", $_POST['val']['nam']);
$db->bind(":phone", $_POST['val']['phone']);
$db->bind(":exp", $_POST['val']['exp']);
$db->bind(":ip", $_SERVER['REMOTE_ADDR']);
$changed = $db->execute();
$arr = $db->insert_id();
$cod = 200;
$txt = 'OK';  

?>
