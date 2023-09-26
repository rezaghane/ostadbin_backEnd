<?php
$sort = '';
$wher = '';
$data = [];
// //***************************** WHERE *******************************************
$wher .= " fullname  LIKE '%".$_GET['search']."%' OR email LIKE '%".$_GET['search']."%' OR mobile LIKE '%".$_GET['search']."%' ";
// //***************************** LIMIT *******************************************
$lmt = " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".($_GET['n']);
// //***************************** SQL ALL *******************************************
$sqlALL = "SELECT * FROM(
SELECT
comment.id,
comment.text,
comment.email,
comment.mobile,
comment.fullname,
comment.read,
comment.date,
comment.time,
1 AS role,
'comment' AS knd
FROM comment
UNION
SELECT
chat_admin.id,
chat_admin.messege AS text,
IF(chat_admin.role=1, users.email, teachers.email) AS email,
IF(chat_admin.role=1, users.mobile, teachers.phone) AS mobile,
IF(chat_admin.role=1, users.fullname, teachers.fullname) AS fullname,
chat_admin.read,
'' AS date,
'' AS time,
chat_admin.role,
'chat_admin' AS knd
FROM chat_admin
LEFT JOIN users ON users.id = chat_admin.user AND chat_admin.role=1
LEFT JOIN teachers ON teachers.id = chat_admin.user AND chat_admin.role=2
)A
WHERE ".$wher;
$rows = $db->rowsCount($sqlALL);
$rows_int = (int)($rows / $_GET['n']);
$totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
// //***************************** SQL *******************************************
$sql = "SELECT * FROM(
SELECT
comment.id,
comment.text,
comment.email,
comment.mobile,
comment.fullname,
'' AS username,
comment.read,
comment.datetime,
comment.date,
comment.time,
1 AS role,
'comment' AS knd
FROM comment
UNION
SELECT
chat_admin.id,
chat_admin.messege AS text,
IF(chat_admin.role=1, users.email, teachers.email) AS email,
IF(chat_admin.role=1, users.mobile, teachers.phone) AS mobile,
IF(chat_admin.role=1, users.fullname, teachers.fullname) AS fullname,
IF(chat_admin.role=1, users.username, teachers.username) AS username,
chat_admin.read,
chat_admin.datetime,
'' AS date,
'' AS time,
chat_admin.role,
'chat_admin' AS knd
FROM chat_admin
LEFT JOIN users ON users.id = chat_admin.user AND chat_admin.role=1
LEFT JOIN teachers ON teachers.id = chat_admin.user AND chat_admin.role=2
)A
WHERE ".$wher." ORDER BY datetime DESC ".$lmt;
$db->query($sql);
$data = $db->resultSet();

if(sizeof($data)>0){
  // تایید شده است
  $DATA = array();
  for($i=0; $i<sizeof($data); $i++){
    if($data[$i]->knd == 'comment'){
      $textD = $data[$i]->text;
      $dateD = $data[$i]->date . " ". $data[$i]->time;
    }else{
      $textD = json_decode($data[$i]->text);
      $dateD = $textD[sizeof($textD)-1]->date;
    }
    $D = [
      "id"=> $data[$i]->id,
      "text"=> $textD,
      "email"=> $data[$i]->email,
      "mobile"=> $data[$i]->mobile,
      "fullname"=> $data[$i]->fullname,
      "read"=> $data[$i]->read,
      "date"=> $dateD,
      "knd"=> $data[$i]->knd,
      "role"=> $data[$i]->role,
      "username"=> $data[$i]->username,
    ];
    array_push($DATA,$D);
  }
  // //_________________________________ SORT WITH PHP ______________________________
  // function sortByAge($a, $b) {
  //   return $a['dateD'] > $b['dateD'];
  // }
  // usort($DATA, 'sortByAge');
  //______________________________________________________________________________
  $arr = [
    "content"=> $DATA,
    "totalPages"=> $totalPages,
    "curPage"=> $_GET['p'],
    "search" => $_GET['search']
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
