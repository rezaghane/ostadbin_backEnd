<?php
if(isset($_POST['chat'])){
  $messege = [];
  $sql = "SELECT * FROM chat WHERE reserved=:reserved";
  $db->query($sql);
  $db->bind(":reserved", $wch);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $messege = json_decode($data[0]->messege, JSON_UNESCAPED_UNICODE);
    $D = [
      "text"=> $_POST['chat'],
      "date"=> jdate("Y/n/d")." ".date("H:i:s"),
      "sender"=> $_POST['sender'],
    ];
    array_push($messege , $D);
    $sql = "UPDATE chat SET messege=:messege WHERE reserved=:reserved";
  }else{
    $D = [
      "text"=> $_POST['chat'],
      "date"=> jdate("Y/n/d")." ".date("H:i:s"),
      "sender"=> $_POST['sender'],
    ];
    array_push($messege , $D);
    $sql = "INSERT INTO chat (reserved, messege) VALUES (:reserved, :messege);";
  }
  $db->query($sql);
  $db->bind(":messege", json_encode($messege, JSON_UNESCAPED_UNICODE));
  $db->bind(":reserved", $wch);
  $changed = $db->execute();

  $arr = $messege;
  $cod = 200;
  $txt = 'OK';
}
//______________________________________________________________________________
else{
  $sql = "SELECT * FROM chat WHERE reserved=:reserved";
  $db->query($sql);
  $db->bind(":reserved", $wch);
  $data = $db->resultSet();

  if(sizeof($data)>0){
    $arr = json_decode($data[0]->messege);
    $cod = 200;
    $txt = 'OK';
  }else{
    $arr = [];
    $cod = 200;
    $txt = 'OK';
  }
}
?>
