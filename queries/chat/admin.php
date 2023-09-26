<?php
if(isset($_POST['chat'])){
    $messege = [];
    if($_POST['role']!=3){
      $sql = "SELECT * FROM chat_admin WHERE user=:user AND role=:role";
      $db->query($sql);
      $db->bind(":user", $_POST['username']);
      $db->bind(":role", $_POST['role']);
    }else{
      $sql = "SELECT * FROM chat_admin WHERE id=:user";
      $db->query($sql);
      $db->bind(":user", $_POST['username']);
    }
    $data = $db->resultSet();
    if(sizeof($data)>0){
      $messege = json_decode($data[0]->messege, JSON_UNESCAPED_UNICODE);
      $D = [
        "text"=> $_POST['chat'],
        "date"=> jdate("Y/n/d")." ".date("H:i:s"),
        "sender"=> $_POST['sender'],
      ];
      array_push($messege , $D);
      if($_POST['role']!=3){
        $sql = "UPDATE chat_admin SET messege=:messege, `read`=:role WHERE user=:user AND role=:role";
      }else{
        $sql = "UPDATE chat_admin SET messege=:messege, `read`=:role WHERE id=:user";
      }
    }else{
      $D = [
        "text"=> $_POST['chat'],
        "date"=> jdate("Y/n/d")." ".date("H:i:s"),
        "sender"=> $_POST['sender'],
      ];
      array_push($messege , $D);
      $sql = "INSERT INTO chat_admin (user, messege,role, `read`) VALUES (:user, :messege, :role, :role);";
    }
    $db->query($sql);
    $db->bind(":messege", json_encode($messege, JSON_UNESCAPED_UNICODE));
    $db->bind(":user", $_POST['username']);
    $db->bind(":role", $_POST['role']);
    $changed = $db->execute();

    $arr = $messege;
    $cod = 200;
    $txt = 'OK';
}
//______________________________________________________________________________
else{
  if($_POST['role']!=3){
    $sql = "SELECT * FROM chat_admin WHERE user=:user AND role=:role";
  }else{
    $sql = "SELECT * FROM chat_admin WHERE id=".$_POST['id'];
  }
  $db->query($sql);
  $db->bind(":role", $_POST['role']);
  $db->bind(":user", $_POST['username']);
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
