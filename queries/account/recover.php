<?php
//__________________________________________/account/recover/request__________________________________________________
if($mod=="request"){
  if(isset($_POST["usr"])){
    $key = random_int(1, 9).random_int(0, 9).random_int(1, 9).random_int(0, 9).random_int(1, 9).random_int(0, 9);

    $sql = "INSERT INTO recover_pwd (usr, e_key) VALUES (:usr, :e_key);";
    $db->query($sql);
    $db->bind(":usr", $_POST['usr']);
    $db->bind(":e_key", $key);
    $changed = $db->execute();
    $path = "./email-templates/reset/";
    $cod = ["code" => $key];
    $mail->addAddress($_POST["usr"]);
		$mail->CharSet = 'UTF-8';
		$mail->ContentType = 'text/html';
		$mail->Subject = 'طبیبستان؛ تغییر گذرواژه';
		$mail->msgHTML(email_template($path, $lng, $cod));
		$mail->send();

    $cod = 200;
    $txt = 'OK';
  } else{
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "user name is not Post to backend";
  }
}
//__________________________________________/account/recover/reset__________________________________________________
else if($mod=="reset"){
  $sql = "SELECT * FROM recover_pwd WHERE usr=:usr ORDER BY id DESC LIMIT 1;";
  $db->query($sql);
  $db->bind(":usr", $_POST['usr']);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $id = $data[0]->id;
    $opt = $data[0]->opt;
    $e_key = $data[0]->e_key;
    if($opt>0){
      if(intval($e_key) == intval($_POST['code'])){
        $sql = "UPDATE users SET pwd=MD5(:pwd) WHERE email=:email;";
        $db->query($sql);
        $db->bind(":email", $_POST['usr']);
        $db->bind(":pwd", $_POST['pwd']);
        $changed = $db->execute();
        if($changed){
          $cod = 200;
          $txt = 'OK';
        }else{
          $cod = 400;
          $txt = 'Bad Request';
        }
      }else{
        $sql = "UPDATE recover_pwd SET opt=(opt-1) WHERE id=".$id;
        $db->query($sql);
        $changed = $db->execute();
        $cod = 400;
        $txt = 'Bad Request';
        $msg = "Wrong Code";
      }
    }else{
      $cod = 400;
      $txt = 'Bad Request';
      $msg = "The number of errors is more than 5";
    }
  } else {
    $cod = 400;
    $txt = 'Bad Request';
  }
}
?>
