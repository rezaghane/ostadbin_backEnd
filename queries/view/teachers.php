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
  $wher .= " AND ( cats LIKE '%".$_GET['cat']."%' OR ".$_GET['cat']."=0 ) ";
  $wher .= " AND ( degrees LIKE '%".$_GET['deg']."%' OR ".$_GET['deg']."=0 ) ";
  $wher .= " AND ( field LIKE '%".$_GET['fldT']."%' OR ".$_GET['fldT']."=0 ) ";
  $wher .= " AND ( sex LIKE '%".$_GET['sex']."%' OR ".$_GET['sex']."=0 ) ";
  $wher .= " AND ( CONCAT(province,',',county) LIKE '".$_GET['loc']."' OR '".$_GET['loc']."'=0 ) ";
  if($_GET['knd'] > 0){
    $wher .= " AND id IN ( SELECT teacher FROM classes WHERE date_class>='".jdate("Y/n/d")."' AND knd_class = '".$_GET['knd']."' ) ";
  }

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
  $sqlALL = "SELECT * FROM teachers WHERE " . $sts . $wher;
  $rows = $db->rowsCount($sqlALL);
  $rows_int = (int)($rows / $_GET['n']);
  $totalPages = ($rows_int == $rows / $_GET['n']) ? $rows_int : $rows_int+1;
  //***************************** sql ******************************************
	$sql = "SELECT 
	teachers.`id`, teachers.`fullname`, 
	IF(teachers.`province`='', 0, teachers.`province`) AS province,
	IF(teachers.`county`='', 0, teachers.`county`) AS county,
	IF(teachers.`cats`='', 0, teachers.`cats`) AS cats,
	IF(teachers.`degrees`='', 0, teachers.`degrees`) AS degrees,
	IF(teachers.`field`='', 0, teachers.`field`) AS field,
	teachers.`in_person_teaching`, teachers.`online_teaching`, teachers.`teaching_home`, teachers.`about_me`, teachers.`address`, teachers.`phone`, teachers.`email`, teachers.`address_teach`, teachers.`sex`, teachers.`public_phone`, teachers.`commission`, teachers.`files`, teachers.`status`, teachers.`dat`, teachers.`tim`, teachers.`dattime`	
	, IF(A.grade IS NULL, 0, A.grade) AS grade FROM teachers
	LEFT JOIN (SELECT teacher , AVG(grade) AS grade FROM `reserved`WHERE grade>0)A ON A.teacher = teachers.id	
	WHERE ". $sts . $wher." ORDER BY ".$sort.$lmt;
  $db->query($sql);
  $data = $db->resultSet();

  if(sizeof($data)>0){
    for($i=0; $i<sizeof($data); $i++){
  
      //***************************** category *********************************
      $sqlC = "SELECT * FROM category WHERE status = '1' AND id IN (" . $data[$i]->cats . "); ";
      $db->query($sqlC);
      $cat = $db->resultSet();
      //***************************** province *********************************
      $sqlP = "SELECT * FROM province WHERE id IN (" . $data[$i]->province . "); ";
      $db->query($sqlP);
      $province = $db->resultSet();
      //***************************** county ***********************************
      $sqlCN = "SELECT * FROM county WHERE id IN ( " . $data[$i]->county . "); ";
      $db->query($sqlCN);
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
        "grade"=> ($data[$i]->grade == 0) ? 'جدید' : (((int)$data[$i]->grade * 100) / 100),
        "cats"=> $cat,
        "img"=> imgFinder($data[$i]->id, 2),
      ];
      array_push($DATA,$D);
    }

    $arr = [
      "curPage" => $_GET['p'],
      "wher2" => $wher2,
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
    $txt = $sql;
    $msg = "data not found";
  }
}
//__________________________________________/view/teachers/:id?knd_class=:knd_class_____________________________
else if(isset($_GET['knd_class'])){
  $sql = "SET SESSION group_concat_max_len = 100000000;";
  $db->query($sql);
  $changed = $db->execute();

  $sql ="SELECT `id`, `teacher`, `knd_class`, `date_class`,
CONCAT('[', GROUP_CONCAT(REPLACE(REPLACE(times_class, '[', ''), ']', '')) , ']') AS times_class
, `price`, `status`, `date`, `form`, `time`, `dattime` FROM `classes`
WHERE date_class>=:date AND knd_class=:knd_class AND teacher=:id
GROUP BY date_class
ORDER BY id DESC";
  $db->query($sql);
  $db->bind(":id", $mod);
  $db->bind(":date", jdate("Y/n/d"));
  $db->bind(":knd_class", $_GET['knd_class']);
  $data = $db->resultSet();
  if(sizeof($data)>0){
    $DATA = array();
    $DATE = array();
    for($i=0; $i<sizeof($data); $i++){
      $D = [
        "id"=> $data[$i]->id,
        "date_class"=> $data[$i]->date_class,
        "price"=> $data[$i]->price,
        "times_class"=> json_decode($data[$i]->times_class),
        // "times_class"=> json_decode($data[$i]->times_class),
      ];
      array_push($DATA, $D);
      array_push($DATE, $data[$i]->date_class);
    }
    $arr = [
      "flds"=> $DATA,
      "date"=> $DATE,
    ];
    $cod = 200;
    $txt = 'OK';
  }else{
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "data not found";
  }
}
//__________________________________________/view/teachers/:id__________________________________________________
else{
  $sql = "SELECT
  teachers.id,
  teachers.fullname,
  province.name AS province,
  county.name AS county,
  teachers.cats,
  teachers.degrees,
  teachers.field,
  teachers.in_person_teaching,
  teachers.online_teaching,
  teachers.teaching_home,
  teachers.about_me,
  teachers.address,
  teachers.phone,
  teachers.email,
  teachers.public_phone,
  teachers.files,
  teachers.address_teach,
  IF(A.grade IS NULL, 0, A.grade) AS grade
  FROM teachers
  INNER JOIN county ON county.id=teachers.county
  LEFT JOIN (SELECT teacher , AVG(grade) AS grade FROM `reserved`WHERE grade>0)A ON A.teacher = teachers.id	
  INNER JOIN province ON province.id=teachers.province
  WHERE teachers.id=:id";
  $db->query($sql);
  $db->bind(":id", $mod);
  $data = $db->resultSet();
  if(sizeof($data)>0){
      $sqlC ="SELECT COUNT(*) AS cnt FROM classes WHERE date_class>=:date AND knd_class=:knd_class AND teacher=:id";
      $db->query($sqlC);
      $db->bind(":id", $mod);
      $db->bind(":date", jdate("Y/n/d"));
      $db->bind(":knd_class", 1);
      $in_person_teaching_active = ($db->resultSet()[0]->cnt == 0) ? 0 : 1;

      $sqlC ="SELECT COUNT(*) AS cnt FROM classes WHERE date_class>=:date AND knd_class=:knd_class AND teacher=:id";
      $db->query($sqlC);
      $db->bind(":id", $mod);
      $db->bind(":date", jdate("Y/n/d"));
      $db->bind(":knd_class", 2);
      $online_teaching_active = ($db->resultSet()[0]->cnt == 0) ? 0 : 1;

      $sqlC ="SELECT COUNT(*) AS cnt FROM classes WHERE date_class>=:date AND knd_class=:knd_class AND teacher=:id";
      $db->query($sqlC);
      $db->bind(":id", $mod);
      $db->bind(":date", jdate("Y/n/d"));
      $db->bind(":knd_class", 3);
      $teaching_home_active = ($db->resultSet()[0]->cnt == 0) ? 0 : 1;

    //*****************************
    $sql = "SELECT * FROM category WHERE id IN (".$data[0]->cats.");";
    $db->query($sql);
    $cats = $db->resultSet();
    //*****************************
    $sql = "SELECT * FROM degrees WHERE id IN (".$data[0]->degrees.");";
    $db->query($sql);
    $degs = $db->resultSet();
    //*****************************
    $sql = "SELECT * FROM field WHERE id IN (".$data[0]->field.");";
    $db->query($sql);
    $fild = $db->resultSet();
    //*****************************
    $f = json_decode($data[0]->files, JSON_UNESCAPED_UNICODE);
    $files = (isset($f['f2'])) ? $f['f2'] : [];
    $arr = [
      "files"              => $files,
      "cats"               => $cats,
      "degs"               => $degs,
      "fild"               => $fild,
      "imgTypeMod"         => imgFinder($data[0]->id, 2),
      "id"                 => $data[0]->id,
      "fullname"           => $data[0]->fullname,
      "public_phone"       => ($data[0]->public_phone == '') ? '09903334817' : $data[0]->public_phone,
      "email"              => ($data[0]->email == '') ? 'info@ostadbin.ir' : $data[0]->email,
      "address" => ($data[0]->address == '') ? 'تهران، تقاطع بلوار کشاورز و کارگر جنب بانک ملی، پلاک 298، طبقه 5، واحد 10' : $data[0]->address,
      "phone"              => $data[0]->phone,
      "county"             => $data[0]->county,
      "province"           => $data[0]->province,
      "about_me"           => $data[0]->about_me,
      "teaching_home"      => $data[0]->teaching_home,
      "online_teaching"    => $data[0]->online_teaching,
      "in_person_teaching" => $data[0]->in_person_teaching,
      "in_person_teaching_active" => $in_person_teaching_active,
      "online_teaching_active" => $online_teaching_active,
      "teaching_home_active" => $teaching_home_active,
      "address_teach"      => $data[0]->address_teach,
      "grade"=> ($data[0]->grade == 0) ? 'جدید' : (((int)$data[0]->grade * 100) / 100),
    ];
    $cod = 200;
    $txt = 'OK';
  }else{
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "data not found";
  }
}
?>
