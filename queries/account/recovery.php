<?php
  $password = rand(9999, 99999);
  $sql = "
  SELECT id, username, 1 AS role FROM users WHERE mobile=:mobile
  UNION ALL
  SELECT id, username, 2 AS role FROM teachers WHERE phone=:mobile AND status<>2
  ";
  $db->query($sql);
  $db->bind(":mobile", $_POST['mobile']);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    //____________________________________________________________________________
    $sql = "
            UPDATE users SET password=MD5(:password) WHERE mobile=:mobile;
            UPDATE teachers SET password=MD5(:password) WHERE phone=:mobile AND status<>2;
    ";
    $db->query($sql);
  	$db->bind(":mobile", $_POST['mobile']);
  	$db->bind(":password", $password);
    $changed = $db->execute();

    $text = "گذرواژه شما تغییر کرده است: \n";
    for($i = 0; $i <sizeof($data); $i++){
        $T = ($data[$i]->role==2) ? ' (مدرس) ' : "";
        $text .= "نام کاربری شما".$T." : " .$data[$i]->username;
        $text .= "گذرواژه شما : ".$password."\n";
        $text .= ($i+1 == sizeof($data)) ? "" : "_________________________________ \n";
    }
    $text .= " است. ";

    $arr = $text;
    $cod = 200;
    $txt = 'OK';
  }else{
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "mobile is not true";
  }
?>
