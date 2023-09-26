<?php
  $sql = "SELECT * FROM discount WHERE status=1 AND code=:code";
  $db->query($sql);
  $db->bind(":code", $_POST['val']['discutCode']);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $discount = $data[0];
    // **********************************************************
    $sql = "SELECT * FROM reserved WHERE id=:id";
    $db->query($sql);
    $db->bind(":id", $_POST['val']['reservedId']);
    $data = $db->resultSet();
    $reserved = $data[0];
    // **********************************************************
    if($discount->type == 1 || ($discount->type == 2 && $reserved->teacher == $discount->teachers) || ($discount->type == 3 && $reserved->category == $discount->category)){
      $arr = $discount;
      $cod = 200;
      $txt = 'OK';
    }else{
      $cod = 400;
      $txt = 'Bad Request';
      $msg = "data not found";
    }
  }else{
    // تایید نشده
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "data not found";
  }
?>
