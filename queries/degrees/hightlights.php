<?php
//***************************** SQL *******************************************
$sql = "SELECT COUNT(*) AS cnt, degrees.* FROM `degrees`
INNER JOIN teachers ON CONCAT(',',teachers.degrees,',') LIKE CONCAT('%,',degrees.id,',%')
WHERE degrees.status = 1
GROUP BY degrees.id
ORDER BY `cnt`  DESC
LIMIT 4";
$db->query($sql);
$data = $db->resultSet();
if(sizeof($data)>0){
  $DATA = [];
  for ($i=0; $i < sizeof($data) ; $i++) {
    $sqlC = "SELECT COUNT(*) AS cnt, category.* FROM `category`
    INNER JOIN teachers ON CONCAT(',',teachers.cats,',') LIKE CONCAT('%,',category.id,',%')
    WHERE category.status = 1 AND CONCAT(',',teachers.degrees,',') LIKE CONCAT('%,',1,',%')
    GROUP BY category.id
    ORDER BY `cnt`  DESC
    LIMIT 7";
    $db->query($sqlC);
    $dataC = $db->resultSet();

    $D = [
      "id"=> $data[$i]->id,
      "name"=> $data[$i]->name,
      "category"=> $dataC,
    ];
    array_push($DATA,$D);
  }
  $arr = $DATA;
  $cod = 200;
  $txt = 'OK';
}else{
  // تایید نشده
  $cod = 400;
  $txt = 'Bad Request';
  $msg = "data not found";
}
?>
