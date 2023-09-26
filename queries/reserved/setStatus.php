<?php
$sql = "SELECT * FROM reserved WHERE id=:id";
$db->query($sql);
$db->bind(":id", $_POST['id']);
$data = $db->resultSet();
if(sizeof($data)>0){
  $time_class = json_decode($data[0]->time_class);
  $date_class =  $data[0]->date_class;
  $teacher =  $data[0]->teacher;
  $knd_class =  $data[0]->knd_class;
  //________________________________________________________________
  $sqlR ="SELECT * FROM classes WHERE teacher='".$teacher."' AND knd_class='".$knd_class."' AND date_class='".$date_class."' AND (times_class LIKE '%".$time_class->start."%' AND times_class LIKE '%".$time_class->end."%'); ";
  $db->query($sqlR);
  $dataR = $db->resultSet()[0];
  $idR = $dataR->id;
  $times_classR = json_decode($dataR->times_class);
  for($i=0;$i<sizeof($times_classR);$i++){
    if($times_classR[$i]->start==$time_class->start && $times_classR[$i]->end==$time_class->end){
      $times_classR[$i]->reserved = '0';
    }
  }
  $sqlUR = "UPDATE `classes` SET `times_class`=:times_class WHERE id=:id";
  $db->query($sqlUR);
  $db->bind(":times_class", json_encode($times_classR));
  $db->bind(":id", $idR);
  $changed = $db->execute();

  $sqlB ="SELECT * FROM classes WHERE id!=:id AND teacher='".$teacher."' AND date_class='".$date_class."'; ";
  $db->query($sqlB);
  $db->bind(":id", $idR);
  $dataB = $db->resultSet();
  //________________________________________________________________
  for($j =0; $j <sizeof($dataB); $j++){
    $I = $dataB[$j]->id;
    $T = json_decode($dataB[$j]->times_class);
    $ts = $time_class->start;
    $te = $time_class->end;
    for($k =0; $k <sizeof($T); $k++){
      if(($ts >= $T[$k]->start && $ts <= $T[$k]->end ) || ($te >= $T[$k]->start && $te <= $T[$k]->end ) || ($ts <= $T[$k]->start && $te >= $T[$k]->end )){
          $T[$k]->status = 0;
      }
    }
    $sqlUB = "UPDATE `classes` SET `times_class`=:times_class WHERE id=:id";
    $db->query($sqlUB);
    $db->bind(":times_class", json_encode($T));
    $db->bind(":id", $I);
    $changed = $db->execute();
  }
  //________________________________________________________________
}
// $sql = "UPDATE `reserved` SET `status`=:status, address=:address WHERE id=:id";
// $db->query($sql);
// $db->bind(":status", $_POST['status']);
// $db->bind(":address", $_POST['address']);
// $db->bind(":id", $_POST['id']);
// $changed = $db->execute();
// // تایید شده است
if($changed){
  $arr = $_POST['id'];
  $cod = 200;
  $txt = 'OK';
}else{
  $cod = 400;
  $txt = "";
}
?>
