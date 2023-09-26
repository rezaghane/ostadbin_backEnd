<?php
//______________________________________________________________________________
if(isset($_POST['times_class'])){
  $sql = "UPDATE classes SET times_class=:times_class, status=:status,dattime=dattime WHERE id=:id AND (teacher=:teacher OR :role=3)";
  $db->query($sql);
  $db->bind(":id", $wch);
  $db->bind(":teacher", $_POST['teacher']);
  $db->bind(":status", $_POST['status']);
  $db->bind(":times_class", json_encode($_POST['times_class']));
  $db->bind(":role", $_POST['role']);
  $changed = $db->execute();
  $arr = $_POST;
  $cod = 200;
  $txt = 'OK';
}
//______________________________________________________________________________
else{
  $sql = "SELECT * FROM classes WHERE id=:id AND (teacher=:teacher OR :role=3)";
  $db->query($sql);
  $db->bind(":id", $wch);
  $db->bind(":teacher", $_POST['teacher']);
  $db->bind(":role", $_POST['role']);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $arr = [
      "id" => $data[0]->id,
      "date" => $data[0]->date,
      "date_class" => $data[0]->date_class,
      "dattime" => $data[0]->dattime,
      "knd_class" => $data[0]->knd_class,
      "price" => $data[0]->price,
      "status" => $data[0]->status,
      "teacher" => $data[0]->teacher,
      "time" => $data[0]->time,
      "times_class" => json_decode($data[0]->times_class),
      "form" => json_decode($data[0]->form),
    ];
    $cod = 200;
    $txt = 'OK';
  }else{
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "data not found";
  }
}
?>
