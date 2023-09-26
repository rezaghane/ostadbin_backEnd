<?php
if($_POST['role']==2 || $_POST['role']==3){
  for($i=0; $i<sizeof($_POST['knd_class']); $i++){
    $sql = "INSERT INTO `classes`(`teacher`, `knd_class`, `date_class`, `times_class`, `price`, `form`, `date`, `time`) VALUES (:teacher, :knd_class, :date_class, :times_class, :price, :form, :date, :time)";
    $db->query($sql);
    $db->bind(":teacher", $_POST['teacher']);
    $db->bind(":knd_class", $_POST['knd_class'][$i]);
    $db->bind(":date_class", $_POST['date_class']);
    $db->bind(":times_class", json_encode($_POST['times_class'], JSON_UNESCAPED_UNICODE));
    $db->bind(":price", $_POST['price'][((int)$_POST['knd_class'][$i])-1]);
    $db->bind(":form", json_encode($_POST['form'], JSON_UNESCAPED_UNICODE));
    $db->bind(":date", jdate("Y/n/d"));
  	$db->bind(":time", date("H:i:s"));
    $changed = $db->execute();
  }
  $arr = 1;
  $cod = 200;
  $txt = 'OK';
}
?>
