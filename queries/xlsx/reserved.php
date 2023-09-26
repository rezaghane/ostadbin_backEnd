<?php
$data = array();
$role = '1';
$sql = "SELECT
reserved.id,
reserved.date_class,
reserved.time_class,
reserved.date,
reserved.time,
reserved.price,
reserved.commission,
reserved.discount,
reserved.prdCod,
users.fullname AS user_fullname,
teachers.fullname AS teachers_fullname,
reserved_status.name AS status_name,
knd_class.name AS knd_class_name
FROM `reserved`
INNER JOIN users ON users.id = reserved.user
INNER JOIN teachers ON teachers.id = reserved.teacher
INNER JOIN reserved_status ON reserved_status.id = reserved.status
INNER JOIN knd_class ON knd_class.id = reserved.knd_class
WHERE date_class >= '".$_POST['from']."' AND date_class <= '".$_POST['to']."'
ORDER BY `reserved`.`date_class` DESC
";

$db->query($sql);
$data = $db->resultSet();
if(sizeof($data)>0){
  $DATA = array();
  for($i=0; $i<sizeof($data); $i++){
    //************************************************************************
    $D = [
      "id"=> $data[$i]->id ,
      "تاریخ شروع کلاس"=> $data[$i]->date_class ,
      "زمان کلاس"=> json_decode($data[$i]->time_class)->start." _ ".json_decode($data[$i]->time_class)->end ,
      "هزینه"=> $data[$i]->price ,
      "کمیسیون"=> $data[$i]->commission ,
      "تخفیف"=> $data[$i]->discount ,
      "کد پرداخت"=> $data[$i]->prdCod ,
      "تاریخ ثبت"=> $data[$i]->date ,
      "زمان ثبت"=> $data[$i]->time ,
      "نام کاربر"=> $data[$i]->user_fullname ,
      "نام مدرس"=> $data[$i]->teachers_fullname ,
      "وضعیت"=> $data[$i]->status_name ,
      "نوع کلاس"=> $data[$i]->knd_class_name ,
    ];
    array_push($DATA,$D);
  }
  $arr = $DATA;
  $cod = 200;
  $txt = 'OK';
}else{
  $cod = 400;
  $txt = 'Bad Request';
  $msg = "data not found";
}
?>
