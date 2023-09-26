<?php
$sql = "UPDATE `".$_POST['knd']."` SET `read`=0 WHERE id=:id AND `read`!=:role";
$db->query($sql);
$db->bind(":id", $_POST['id']);
$db->bind(":role", $_POST['role']);
$changed = $db->execute();
$arr = $_POST['id'];
$cod = 200;
$txt = 'OK';
?>
