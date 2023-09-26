<?php
$sort = '';
$wher = '';
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
//***************************** LIMIT *******************************************
$lmt = " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".($_GET['n']);
//_________________________________________________________________________________
if(isset($_POST['id'])){
  //***************************** WHERE *******************************************
  $wher .= " users LIKE '%".$_GET['search']."%' OR teachers LIKE '%".$_GET['search']."%' OR date LIKE '%".$_GET['search']."%' OR time LIKE '%".$_GET['search']."%' OR price LIKE '%".$_GET['search']."%' OR percentage LIKE '%".$_GET['search']."%' ";
  //***************************** SQL ALL *******************************************
  $sqlALL = "
  SELECT * FROM(
  SELECT
  reserved.id,
  users.fullname AS users,
  teachers.fullname AS teachers,
  reserved.date,
  reserved.time,
  reserved.price,
  reserved.prdCod,
  discount.percentage
  FROM `reserved`
  INNER JOIN users ON users.id=reserved.user
  INNER JOIN teachers ON teachers.id=reserved.teacher
  INNER JOIN discount ON discount.id=reserved.discount
  WHERE discount.id=".$_POST['id'].")A WHERE ".$wher;
  $rows = $db->rowsCount($sqlALL);
  $rows_int = (int)($rows / $_GET['n']);
  $totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
  //***************************** SQL *******************************************
  $sql = "SELECT * FROM(SELECT
  reserved.id,
  users.fullname AS users,
  teachers.fullname AS teachers,
  reserved.date,
  reserved.time,
  reserved.price,
  reserved.prdCod,
  discount.percentage,
  discount.code
  FROM `reserved`
  INNER JOIN users ON users.id=reserved.user
  INNER JOIN teachers ON teachers.id=reserved.teacher
  INNER JOIN discount ON discount.id=reserved.discount
  WHERE discount.id=".$_POST['id'].")A WHERE ".$wher." ORDER BY ".$sort.$lmt;
  $db->query($sql);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $DATA = array();
    for($i=0; $i<sizeof($data); $i++){
      $D = [
        "id" => $data[$i]->id,
        "users" => $data[$i]->users,
        "teachers" => $data[$i]->teachers,
        "date" => $data[$i]->date,
        "time" => $data[$i]->time,
        "price" => $data[$i]->price,
        "prdCod" => $data[$i]->prdCod,
        "percentage" => $data[$i]->percentage,
      ];
      array_push($DATA,$D);
    }
    $arr = [
      "code" => $data[0]->code,
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
}
//______________________________________________________________________________
else{
  //***************************** WHERE *******************************************
  $wher .= " code LIKE '%".$_GET['search']."%' OR percentage LIKE '%".$_GET['search']."%' OR dat LIKE '%".$_GET['search']."%' ";
  //***************************** SQL ALL *******************************************
  $sqlALL = "SELECT * FROM discount WHERE ".$wher;
  $rows = $db->rowsCount($sqlALL);
  $rows_int = (int)($rows / $_GET['n']);
  $totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
  //***************************** SQL *******************************************
  $sql = "SELECT discount.id, discount.code, discount.type, discount_type.dsc AS discount_type, discount.percentage, discount.status,discount.dat,  IF(A.cnt IS NULL, 0, A.cnt) AS cnt FROM discount
  LEFT JOIN (SELECT `discount`, COUNT(*) AS cnt FROM reserved WHERE `discount`<>0 GROUP BY discount ORDER BY `reserved`.`discount` ASC ) A ON discount.id = A.discount
  INNER JOIN discount_type ON discount_type.id=discount.type
  WHERE ".$wher." ORDER BY ".$sort.$lmt;
  $db->query($sql);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $DATA = array();
    for($i=0; $i<sizeof($data); $i++){
      $D = [
        "id" => $data[$i]->id,
        "status" => $data[$i]->status,
        "type" => $data[$i]->type,
        "dat" => $data[$i]->dat,
        "code" => $data[$i]->code,
        "cnt" => $data[$i]->cnt,
        "percentage" => $data[$i]->percentage,
        "discount_type" => $data[$i]->discount_type,
      ];
      array_push($DATA,$D);
    }
    if( $_POST['role'] ==3 ){
      $arr = [
        "content"=> $DATA,
        "totalPages"=> $totalPages,
        "curPage"=> $_GET['p'],
        "search" => $_GET['search']
      ];
    }else{
      $arr = $DATA;
    }
    $cod = 200;
    $txt = 'OK';
  }else{
    // تایید نشده
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "data not found";
  }
}
?>
