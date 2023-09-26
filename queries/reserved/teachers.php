<?php
$data = array();
$_GET['n'] = (isset($_GET['n'])) ? $_GET['n'] : 5;
$_POST['search'] = (isset($_POST['search'])) ? $_POST['search'] : '';
$totalPages = 0;
$lmt = " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".( $_GET['n']);
//***************************** role == 1 ********************************
if($_POST['role']==1){
  $role = '2';
  $sql = "SELECT
  reserved.id,
  reserved.date_class,
  reserved.time_class,
  reserved.date,
  reserved.time,
  reserved.price,
  reserved.commission,
  discount.percentage AS discount,
  reserved.prdCod,
  teachers.id AS teachers_id,
  teachers.fullname AS teachers_fullname,
  '' AS teachers_fullname2,
  reserved_status.class AS status_class,
  reserved_status.id AS status_id,
  reserved_status.name AS status_name,
  knd_class.id AS knd_class_id,
  knd_class.name AS knd_class_name
  FROM `reserved`
  LEFT JOIN teachers ON teachers.id = reserved.teacher
  INNER JOIN reserved_status ON reserved_status.id = reserved.status
  INNER JOIN knd_class ON knd_class.id = reserved.knd_class
  LEFT JOIN discount ON discount.id = reserved.discount
  WHERE reserved.user=:user
  ORDER BY `reserved`.`id` DESC
  ".$lmt;
  //***************************** sql All **************************************
  $sqlALL = "SELECT * FROM `reserved`
  LEFT JOIN teachers ON teachers.id = reserved.teacher
  INNER JOIN reserved_status ON reserved_status.id = reserved.status
  INNER JOIN knd_class ON knd_class.id = reserved.knd_class
  WHERE reserved.user=:user";
}
//***************************** role == 2 ********************************
else if($_POST['role']==2){
  $role = '1';
  $sql = "SELECT
  reserved.id,
  reserved.date_class,
  reserved.time_class,
  reserved.date,
  reserved.time,
  reserved.price,
  reserved.commission,
  discount.percentage AS discount,
  reserved.prdCod,
  users.id AS teachers_id,
  users.fullname AS teachers_fullname,
  '' AS teachers_fullname2,
  reserved_status.class AS status_class,
  reserved_status.id AS status_id,
  reserved_status.name AS status_name,
  knd_class.id AS knd_class_id,
  knd_class.name AS knd_class_name
  FROM `reserved`
  INNER JOIN users ON users.id = reserved.user
  INNER JOIN reserved_status ON reserved_status.id = reserved.status
  INNER JOIN knd_class ON knd_class.id = reserved.knd_class
  LEFT JOIN discount ON discount.id = reserved.discount
  WHERE reserved.teacher=:user AND reserved.status=2
  ORDER BY `reserved`.`id` DESC
  ".$lmt;
  //***************************** sql All **************************************
  $sqlALL = "SELECT * FROM `reserved`
  INNER JOIN users ON users.id = reserved.user
  INNER JOIN reserved_status ON reserved_status.id = reserved.status
  INNER JOIN knd_class ON knd_class.id = reserved.knd_class
  WHERE reserved.teacher=:user AND reserved.status=2";
}
//***************************** role == 3 ********************************
else if($_POST['role']==3){
  $role = '1';
  $sql = "SELECT
  reserved.id,
  reserved.date_class,
  reserved.time_class,
  reserved.date,
  reserved.time,
  reserved.price,
  reserved.commission,
  discount.percentage AS discount,
  reserved.prdCod,
  users.id AS teachers_id,
  users.fullname AS teachers_fullname,
  teachers.fullname AS teachers_fullname2,
  reserved_status.class AS status_class,
  reserved_status.id AS status_id,
  reserved_status.name AS status_name,
  knd_class.id AS knd_class_id,
  knd_class.name AS knd_class_name
  FROM `reserved`
  INNER JOIN users ON users.id = reserved.user
  LEFT JOIN teachers ON teachers.id = reserved.teacher
  INNER JOIN reserved_status ON reserved_status.id = reserved.status
  INNER JOIN knd_class ON knd_class.id = reserved.knd_class
  LEFT JOIN discount ON discount.id = reserved.discount
  WHERE (users.fullname LIKE '%".$_POST['search']."%' OR teachers.fullname LIKE '%".$_POST['search']."%') AND
  (:user='' OR reserved.user=:user)
  ORDER BY `reserved`.`id` DESC
  ".$lmt;
  //***************************** sql All **************************************
  $sqlALL = "SELECT * FROM `reserved`
  LEFT JOIN teachers ON teachers.id = reserved.teacher
  INNER JOIN users ON users.id = reserved.user
  INNER JOIN reserved_status ON reserved_status.id = reserved.status
  INNER JOIN knd_class ON knd_class.id = reserved.knd_class
  WHERE (users.fullname LIKE '%".$_POST['search']."%' OR teachers.fullname LIKE '%".$_POST['search']."%') AND
  (:user='' OR reserved.user=:user)
  ";
}
$db->query($sql);
$db->bind(":user", $_POST['username']);
$data = $db->resultSet();
if(sizeof($data)>0){
  $DATA = array();
  //***************************** sqlALL ***************************************
  $db->query($sqlALL);
  $db->bind(":user", $_POST['username']);
  $dataALL = $db->resultSet();
  $rows_int = (int)(sizeof($dataALL) / $_GET['n']);
  $totalPages = ($rows_int == sizeof($dataALL) / $_GET['n']) ? $rows_int : $rows_int+1;

  for($i=0; $i<sizeof($data); $i++){
  //   //************************************************************************
    $data[$i]->time_class = ($data[$i]->time_class == null) ? '{"start":"","end":""}' : $data[$i]->time_class;
    $data[$i]->teachers_id = ($data[$i]->teachers_id == null) ? '0' : $data[$i]->teachers_id;
    $D = [
      "id"=> $data[$i]->id ,
      "date_class"=> $data[$i]->date_class ,
      "time_class"=> json_decode($data[$i]->time_class) ,
      "date"=> $data[$i]->date ,
      "price"=> $data[$i]->price ,
      "commission"=> $data[$i]->commission ,
      "discount"=> $data[$i]->discount ,
      "prdCod"=> ($data[$i]->prdCod==null) ? '' : (int)str_replace('A', '', $data[$i]->prdCod),
      "time"=> $data[$i]->time ,
      "teachers_id"=> $data[$i]->teachers_id ,
      "teachers_fullname"=> $data[$i]->teachers_fullname ,
      "teachers_fullname2"=> $data[$i]->teachers_fullname2 ,
      "status_id"=> $data[$i]->status_id ,
      "status_name"=> $data[$i]->status_name ,
      "status_class"=> $data[$i]->status_class ,
      "knd_class_id"=> $data[$i]->knd_class_id ,
      "knd_class_name"=> $data[$i]->knd_class_name ,
      "knd_class_name"=> $data[$i]->knd_class_name ,
      "img"=> imgFinder($data[$i]->teachers_id, $role),
    ];
    array_push($DATA,$D);
  }
  $arr = [
    "curPage" => $_GET['p'],
    "totalPages" => $totalPages,
    "totalItems" => sizeof($dataALL),
    "content" => $DATA,
    "search" => $_POST['search'],
  ];
  $cod = 200;
  $txt = 'OK';
}else{
  $cod = 400;
  $txt = 'Bad Request';
  $msg = "data not found";
  $msg = "";
}
?>
