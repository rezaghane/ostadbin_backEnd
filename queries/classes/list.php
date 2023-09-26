<?php
if($_POST['role']==1 || $_POST['role']==2 || $_POST['role']==3){
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
  // //***************************** LIMIT *******************************************
  $lmt = " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".($_GET['p'] * $_GET['n']);
  // //***************************** SQL ALL *******************************************
  $sqlALL = "SELECT * FROM classes WHERE teacher='".$_POST['teacher']."' ";
  $CNT = $db->rowsCount($sqlALL);
  $rows_int = (int)($CNT / $_GET['n']);
  $totalPages = ($rows_int == $CNT / $_GET['n']) ? $rows_int : $rows_int+1;
  //***************************** SQL *******************************************
  $sql = "SELECT * FROM classes WHERE teacher='".$_POST['teacher']."' ORDER BY ".$sort.$lmt;
  $db->query($sql);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    // تایید شده است
    $DATA = array();
    for($i=0; $i<sizeof($data); $i++){
      $times = json_decode($data[$i]->times_class);
      $cnt_reserved=0;
      for($j=0; $j<sizeof($times); $j++){
        if($times[$j]->reserved==0) $cnt_reserved = $cnt_reserved+1;
      }
      $timeRange = [
        "start" => $times[0]->start,
        "end" => $times[sizeof($times)-1]->start,
      ];
      $D = [
        "id"=> $data[$i]->id,
        "status"=> $data[$i]->status,
        "date_class"=> $data[$i]->date_class,
        "times_class"=> $times,
        "cnt_reserved"=> $cnt_reserved,
        "cnt_class"=> sizeof($times),
        "timeRange"=>$timeRange,
      ];
      array_push($DATA,$D);
    }
    $arr = [
      "curPage" => $_GET['p'],
      "totalPages" => $totalPages,
  		"totalItems" => $CNT,
      "content" => $DATA,
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
?>
