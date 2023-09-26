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
//***************************** WHERE *******************************************
$wher .= " email LIKE '%".$_GET['search']."%' OR fullname LIKE '%".$_GET['search']."%' ";
//***************************** LIMIT *******************************************
$lmt = " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".($_GET['n']);
//***************************** SQL ALL *******************************************
$sqlALL = "SELECT * FROM admins WHERE ".$wher;
$rows = $db->rowsCount($sqlALL);
$rows_int = (int)($rows / $_GET['n']);
$totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
//***************************** SQL *******************************************
$sql = "SELECT * FROM admins WHERE ".$wher." ORDER BY ".$sort.$lmt;
$db->query($sql);
$data = $db->resultSet();
if(sizeof($data)>0){
  $DATA = array();
  for($i=0; $i<sizeof($data); $i++){
    $D = [
      "id" => $data[$i]->id,
      "status" => $data[$i]->status,
      "fullname" => $data[$i]->fullname,
      "email" => $data[$i]->email,
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
?>
