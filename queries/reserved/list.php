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
$fltr = ['id', 'name', 'status', 'dat'];
for($i=0; $i<sizeof($fltr); $i++){
  if(isset($_GET['filter'][$fltr[$i]])){
    $wher = " AND ".$fltr[$i]."='".$_GET['filter'][$fltr[$i]]."' ";
  }
}
//***************************** LIMIT *******************************************
$lmt = " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".($_GET['p'] * $_GET['n']);
//***************************** SQL ALL *******************************************
$sqlALL = "SELECT * FROM degrees WHERE 1 ".$wher;
$rows = $db->rowsCount($sqlALL);
$rows_int = (int)($rows / $_GET['n']);
$totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
//***************************** SQL *******************************************
$sql = "SELECT `id`, `name`, `status` FROM degrees WHERE 1 ".$wher." ORDER BY ".$sort.$lmt;
$db->query($sql);
$data = $db->resultSet();
if(sizeof($data)>0){
  // تایید شده است
  $DATA = array();
  for($i=0; $i<sizeof($data); $i++){
    $D = [
      "id"=> $data[$i]->id,
      "status"=> $data[$i]->status,
      "name"=> $data[$i]->name,
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
