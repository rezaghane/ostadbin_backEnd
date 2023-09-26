<?php
$cats = (isset($_GET['cats'])) ? $_GET['cats'] : ',';
$wher = "";
if(isset($_GET['name'])){
    $wher = " AND fullname LIKE '%".$_GET['name']."%' ";
}
//__________________________________________/view/teachers/list__________________________________________________
if($mod=='list'){
  $sort = '';
  $wher = '';
  $DATA = array();
  //***************************** WHERE *******************************************

  $wher = " AND fullname LIKE '%".$_GET['filter']."%' ";
  // $wher .= " AND ( cats LIKE '%".$_GET['cat']."%' OR ".$_GET['cat']."=0 ) ";
  // $wher .= " AND ( degrees LIKE '%".$_GET['deg']."%' OR ".$_GET['deg']."=0 ) ";
  // $wher .= " AND ( field LIKE '%".$_GET['fldT']."%' OR ".$_GET['fldT']."=0 ) ";
  // $wher .= " AND ( sex LIKE '%".$_GET['sex']."%' OR ".$_GET['sex']."=0 ) ";
  // $wher .= " AND ( CONCAT(province,',',county) LIKE '".$_GET['loc']."' OR '".$_GET['loc']."'=0 ) ";
  // if($_GET['knd'] == '1'){
  //   $wher .= " AND ( in_person_teaching = 1 ) ";
  // } else if($_GET['knd'] == '2'){
  //   $wher .= " AND ( online_teaching = 1 ) ";
  // } else if($_GET['knd'] == '3'){
  //   $wher .= " AND ( teaching_home = 1 ) ";
  // }

  //***************************** LIMIT *******************************************
  $lmt = " LIMIT ".(($_GET['p']-1) * $_GET['n'])." , ".($_GET['n']);
  //***************************** SORT *****************************************
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
  //***************************** status ***************************************
  $sts = ( $_GET["role"] != 3 ) ? ' status!=0 ' : ' 1 ';
  //***************************** sqlALL ***************************************
  $sqlALL = "SELECT * FROM users WHERE " . $sts . $wher;
  $rows = $db->rowsCount($sqlALL);
  $rows_int = (int)($rows / $_GET['n']);
  $totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
  //***************************** sql ******************************************
  $sql = "SELECT * FROM users WHERE ". $sts . $wher." ORDER BY status, ".$sort.$lmt;
  $db->query($sql);
  $data = $db->resultSet();

  if(sizeof($data)>0){
    for($i=0; $i<sizeof($data); $i++){
      //***************************** field *********************************
      $sqlF = "SELECT * FROM field WHERE status = '1' AND id IN (" . $data[$i]->field . "); ";
      $db->query($sqlF);
      $F = $db->resultSet();
      //***************************** degrees *********************************
      $sqlD = "SELECT * FROM degrees WHERE status = '1' AND id IN (" . $data[$i]->degrees . "); ";
      $db->query($sqlD);
      $D = $db->resultSet();
      //***************************** province *********************************
      $sqlC = "SELECT * FROM province WHERE id IN (" . $data[$i]->province . "); ";
      $db->query($sqlC);
      $province = $db->resultSet();
      //***************************** county ***********************************
      $sqlC = "SELECT * FROM county WHERE id IN (" . $data[$i]->county . "); ";
      $db->query($sqlC);
      $county = $db->resultSet();
      //************************************************************************
      $D = [
        "id"=> $data[$i]->id,
        "fullname"=> $data[$i]->fullname,
        "status"=> $data[$i]->status,
        "county"=> $county[0]->name,
        "province"=> $province[0]->name,
        "dat"=> $data[$i]->dat,
        "tim"=> $data[$i]->tim,
        "dattime"=> $data[$i]->dattime,
        "field"=> $F[0]->name,
        "degrees"=> $D[0]->name,
        "img"=> imgFinder($data[$i]->id, 1),
        "grade" => 5,
      ];
      array_push($DATA,$D);
    }

    $arr = [
      "curPage" => $_GET['p'],
      "cat"     => $_GET['cat'],
      "deg"     => $_GET['deg'],
      "loc"     => $_GET['loc'],
      "kndClass"=> $_GET['knd'],
      "fldT"    => $_GET['fldT'],
      "sex"    => $_GET['sex'],
      "totalPages" => $totalPages,
      "totalItems" => $rows,
      "content" => $DATA,
      "filter" => $_GET['filter'],

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
// //__________________________________________/view/teachers/:id?knd_class=:knd_class_____________________________
// else if(isset($_GET['knd_class'])){
//   $sql ="SELECT * FROM classes WHERE date_class>:date AND knd_class=:knd_class AND teacher=:id";
//   $db->query($sql);
//   $db->bind(":id", $mod);
//   $db->bind(":date", jdate("Y/n/d"));
//   $db->bind(":knd_class", $_GET['knd_class']);
//   $data = $db->resultSet();
//   if(sizeof($data)>0){
//     $DATA = array();
//     $DATE = array();
//     for($i=0; $i<sizeof($data); $i++){
//       $D = [
//         "id"=> $data[$i]->id,
//         "date_class"=> $data[$i]->date_class,
//         "price"=> $data[$i]->price,
//         "times_class"=> json_decode($data[$i]->times_class),
//       ];
//       array_push($DATA, $D);
//       array_push($DATE, $data[$i]->date_class);
//     }
//     $arr = [
//       "flds"=> $DATA,
//       "date"=> $DATE,
//     ];
//     $cod = 200;
//     $txt = 'OK';
//   }else{
//     $cod = 400;
//     $txt = 'Bad Request';
//     $msg = "data not found";
//   }
// }
// //__________________________________________/view/teachers/:id__________________________________________________
// else{
//   $sql = "SELECT
//   teachers.id,
//   teachers.fullname,
//   province.name AS province,
//   county.name AS county,
//   teachers.cats,
//   teachers.degrees,
//   teachers.field,
//   teachers.in_person_teaching,
//   teachers.online_teaching,
//   teachers.teaching_home,
//   teachers.about_me,
//   teachers.address,
//   teachers.phone,
//   teachers.email,
//   teachers.address_teach
//   FROM teachers
//   INNER JOIN county ON county.id=teachers.county
//   INNER JOIN province ON province.id=teachers.province
//   WHERE teachers.id=:id";
//   $db->query($sql);
//   $db->bind(":id", $mod);
//   $data = $db->resultSet();
//   if(sizeof($data)>0){
//     //***************************** image ************************************
//     $img = false;
//     $imgTypeMod = "";
//     $imgType = ["jpg", "jpeg", "png", "gif", "svg", "ico"];
//     for($j=0; $j<sizeof($imgType); $j++){
//       if(file_exists("upload/t_".$data[0]->id.".".$imgType[$j])){
//         $imgTypeMod = "t_".$data[0]->id.".".$imgType[$j];
//       }
//     }
//     //*****************************
//     $sql = "SELECT * FROM category WHERE id IN (".$data[0]->cats.");";
//     $db->query($sql);
//     $cats = $db->resultSet();
//     //*****************************
//     $sql = "SELECT * FROM degrees WHERE id IN (".$data[0]->degrees.");";
//     $db->query($sql);
//     $degs = $db->resultSet();
//     //*****************************
//     $sql = "SELECT * FROM field WHERE id IN (".$data[0]->field.");";
//     $db->query($sql);
//     $fild = $db->resultSet();
//     //*****************************
//     $arr = [
//       "cats"               => $cats,
//       "degs"               => $degs,
//       "fild"               => $fild,
//       "imgTypeMod"         => $imgTypeMod,
//       "id"                 => $data[0]->id,
//       "fullname"           => $data[0]->fullname,
//       "email"              => $data[0]->email,
//       "phone"              => $data[0]->phone,
//       "address"            => $data[0]->address,
//       "county"             => $data[0]->county,
//       "province"           => $data[0]->province,
//       "about_me"           => $data[0]->about_me,
//       "teaching_home"      => $data[0]->teaching_home,
//       "online_teaching"    => $data[0]->online_teaching,
//       "in_person_teaching" => $data[0]->in_person_teaching,
//       "address_teach"      => $data[0]->address_teach,
//       "grade"              => 5,
//     ];
//     $cod = 200;
//     $txt = 'OK';
//   }else{
//     $cod = 400;
//     $txt = 'Bad Request';
//     $msg = "data not found";
//   }
// }
?>
