<?php
  $table = ($_POST['role']==1) ? 'users' : 'teachers';
  //**********************************************
  $sql = "UPDATE ".$table." SET password=:password WHERE password=MD5(:cur) AND id=:id";
  $db->query($sql);
  $db->bind(":id", $_POST['id']);
  $db->bind(":cur", $_POST['cur']);
	$db->bind(":password", $_POST['password']);
  $changed = $db->execute();
  //*******************
  $sqlCnt = "SELECT COUNT(*) AS cnt FROM ".$table." WHERE password=MD5(:password) AND id=:id";
  $db->query($sqlCnt);
  $db->bind(":id", $_POST['id']);
	$db->bind(":password", $_POST['password']);
  $data = $db->resultSet()[0];

  $arr = $data->cnt;
	$cod = 200;
  $txt = 'OK';
?>
