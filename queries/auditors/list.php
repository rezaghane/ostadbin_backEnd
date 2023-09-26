<?php
$sort = '';
$wher = '';
$_POST['role'] = (isset($_POST['role'])) ? $_POST['role'] : '0';
$_GET['search'] = (isset($_GET['search'])) ? $_GET['search'] : '';
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
  $sort = " id";
}
//***************************** WHERE *******************************************
$fltr = ['id', 'name', 'status', 'dat'];
$wher = ( $_POST['role'] ==3 ) ? " 1 " : ' status=1 ';
$wher .= " AND (name  LIKE '%".$_GET['search']."%' OR title  LIKE '%".$_GET['search']."%' OR about_me  LIKE '%".$_GET['search']."%') ";
//***************************** LIMIT *******************************************
$lmt = ( $_POST['role'] ==3 ) ? " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".($_GET['n']) : ' ';
//***************************** SQL ALL *******************************************
$sqlALL = "SELECT * FROM auditors WHERE ".$wher;
$rows = $db->rowsCount($sqlALL);
$rows_int = (int)($rows / $_GET['n']);
$totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
//***************************** SQL *******************************************
$sql = "SELECT * FROM auditors WHERE ".$wher." ORDER BY ".$sort.$lmt;
$db->query($sql);
$data = $db->resultSet();
if(sizeof($data)>0){
  $DATA = array();
  for($i=0; $i<sizeof($data); $i++){
    $D = [
      "id"=> $data[$i]->id,
      "name"=> $data[$i]->name,
      "title"=> $data[$i]->title,
      "image"=> $data[$i]->image,
      "about_me"=> $data[$i]->about_me,
      "status"=> $data[$i]->status,
    ];
    array_push($DATA,$D);
  }
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
