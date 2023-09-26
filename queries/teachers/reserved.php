<?php
$arr = array();

for($i=0; $i<sizeof($_POST['dateTime']); $i++){
  $time_class = array("start"=>$_POST['dateTime'][$i]['time'][0], "end"=>$_POST['dateTime'][$i]['time'][1]);

  $sql = "INSERT INTO `reserved`(`knd_class`, `user`, `teacher`, `date_class`, `time_class`, `degre`, `category`, `field`, `explain_user`, `address`, `date`, `time`, `price`, `commission`) SELECT :knd_class , :username , :teacher , :date_class , :time_class , :degre , :category , :field , :explain_user , :address , :date , :time , :price , commission FROM teachers where id = :teacher";
  //
  $db->query($sql);
  $db->bind(":knd_class", $_POST['dateTime'][$i]['typeTeaching']);
  $db->bind(":price", $_POST['dateTime'][$i]['price']);
  $db->bind(":teacher", $_POST['dateTime'][$i]['teacher']);
  $db->bind(":date_class", $_POST['dateTime'][$i]['date']);
  $db->bind(":time_class", json_encode($time_class));
  //
  $db->bind(":username", $_POST['username']);
  $db->bind(":degre", $_POST['degre']);
  $db->bind(":category", $_POST['category']);
  $db->bind(":field", $_POST['field']);
  $db->bind(":explain_user", $_POST['explain']);
  $db->bind(":address", $_POST['address']);
  $db->bind(":date", jdate("Y/n/d"));
  $db->bind(":time", date("H:i:s"));
  $changed = $db->execute();

  array_push($arr, $db->insert_id());
}
$arr = implode(',', $arr);
$cod = 200;
$txt = 'OK';

?>
