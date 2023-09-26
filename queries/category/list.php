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
  $sort = " id DESC";
}
//***************************** WHERE *******************************************
$fltr = ['id', 'name', 'status', 'dat'];
$wher = ( $_POST['role'] ==3 ) ? " 1 " : ' status=1 ';
$wher .= " AND ( name  LIKE '%".$_GET['search']."%' OR degrees  LIKE '%".$_GET['search']."%' ) ";
//***************************** LIMIT *******************************************
$lmt = ( $_POST['role'] ==3 ) ? " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".($_GET['n']) : ' ';
//***************************** SQL ALL *******************************************
$sqlALL = "SELECT * FROM ( SELECT category.`id`, category.`name`, category.`status`, GROUP_CONCAT(degrees.name) AS degrees FROM category
LEFT JOIN degrees ON CONCAT(',' , category.degrees , ',') LIKE CONCAT('%,' , degrees.id , ',%')
GROUP BY category.id ) A WHERE ".$wher;
$rows = $db->rowsCount($sqlALL);
$rows_int = (int)($rows / $_GET['n']);
$totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
//***************************** SQL *******************************************
$sql = "SELECT * FROM ( SELECT category.`id`, category.`name`, category.`status`, GROUP_CONCAT(degrees.name) AS degrees FROM category
LEFT JOIN degrees ON CONCAT(',' , category.degrees , ',') LIKE CONCAT('%,' , degrees.id , ',%')
GROUP BY category.id ) A WHERE ".$wher." ORDER BY ".$sort.$lmt;


$db->query($sql);
$data = $db->resultSet();
if(sizeof($data)>0){
  $DATA = array();
  for($i=0; $i<sizeof($data); $i++){
    $sqlT = "SELECT COUNT(*) AS cnt FROM teachers WHERE CONCAT(',' , cats , ',') LIKE '%,".$data[$i]->id.",%' ";
    $db->query($sqlT);
    $teacherC = $db->resultSet();
    $D = [
      "id"=> $data[$i]->id,
      "status"=> $data[$i]->status,
      "name"=> $data[$i]->name,
      "degrees"=> str_replace(",", "، ", $data[$i]->degrees),
      "count_teacher"=> $teacherC[0]->cnt,
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
