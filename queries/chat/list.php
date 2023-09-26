<?php
$sort = '';
$wher = '';
$data = [];
//***************************** SORT *******************************************
if(isset($_GET['sort'])){
  if($_GET['sort']!=''){
    $sort = str_replace(":", " ", $_GET['sort']);
    $sort = str_replace("dsc", " DESC ", $sort);
    $sort = str_replace("asc", " ASC ", $sort);
  }else{
    $sort = " id DESC";
  }
}else{
  $sort = " id DESC";
}
// //***************************** WHERE *******************************************
$wher .= " users_fullname  LIKE '%".$_POST['search']."%' OR teachers_fullname LIKE '%".$_POST['search']."%' OR users_mobile LIKE '%".$_POST['search']."%' OR teachers_mobile LIKE '%".$_POST['search']."%'  OR date_class LIKE '%".$_POST['search']."%' ";
// //***************************** LIMIT *******************************************
$lmt = " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".($_GET['n']);
// //***************************** SQL ALL *******************************************
$sqlALL = "SELECT * FROM(
  SELECT
  chat.reserved AS id,
  users.fullname AS users_fullname,
  users.mobile AS users_mobile,
  teachers.fullname AS teachers_fullname,
  teachers.phone AS teachers_mobile,
  knd_class.name AS knd_class,
  reserved.date_class,
  chat.messege AS text,
  reserved.time_class
  FROM `chat`
  INNER JOIN reserved ON reserved.id=chat.reserved
  INNER JOIN teachers ON teachers.id=reserved.teacher
  INNER JOIN users ON users.id=reserved.user
  INNER JOIN knd_class ON knd_class.id=reserved.knd_class
)A
WHERE ".$wher;
$rows = $db->rowsCount($sqlALL);
$rows_int = (int)($rows / $_GET['n']);
$totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
// //***************************** SQL *******************************************
$sql = "SELECT * FROM(
  SELECT
  chat.reserved AS id,
  users.fullname AS users_fullname,
  users.mobile AS users_mobile,
  teachers.fullname AS teachers_fullname,
  teachers.phone AS teachers_mobile,
  knd_class.name AS knd_class,
  reserved.date_class,
  chat.messege AS text,
  reserved.time_class
  FROM `chat`
  INNER JOIN reserved ON reserved.id=chat.reserved
  INNER JOIN teachers ON teachers.id=reserved.teacher
  INNER JOIN users ON users.id=reserved.user
  INNER JOIN knd_class ON knd_class.id=reserved.knd_class
)A
WHERE ".$wher." ORDER BY ".$sort.$lmt;
$db->query($sql);
$data = $db->resultSet();

if(sizeof($data)>0){
  $DATA = array();
  for($i=0; $i<sizeof($data); $i++){
    $D = [
      "id"=> $data[$i]->id,
      "date_class"=> $data[$i]->date_class,
      "knd_class"=> $data[$i]->knd_class,
      "teachers_mobile"=> $data[$i]->teachers_mobile,
      "teachers_fullname"=> $data[$i]->teachers_fullname,
      "users_fullname"=> $data[$i]->users_fullname,
      "users_mobile"=> $data[$i]->users_mobile,
      "time_class"=> json_decode($data[$i]->time_class),
      "text"=> json_decode($data[$i]->text),
    ];
    array_push($DATA,$D);
  }
  //_________________________________ SORT WITH PHP ______________________________
  usort($DATA, function($a, $b){
    return ($a->date > $b->date) ? -1 : 1;
  });
  //______________________________________________________________________________
  $arr = [
    "content"=> $DATA,
    "totalPages"=> $totalPages,
    "curPage"=> $_GET['p'],
    "search" => $_POST['search']
  ];
  $cod = 200;
  $txt = 'OK';
}else{
  // تایید نشده
  $cod = 400;
  $txt = 'Bad Request';
  $msg = "data not found";
}
?>
