<?php
if(isset($_POST['val'])){
  $val = $_POST['val'];
  $time = [
      "start" => $val['ss'],
      "end" => $val['se'],
  ];
  $sql = "UPDATE reserved SET knd_class = :knd_class,user = :user,teacher = :teacher,date_class = :date_class,time_class = :time_class,degre = :degre,category = :category,field = :field,explain_user = :explain_user,address = :address,link = :link,price = :price,commission = :commission , status = :status WHERE id = :id";

  $db->query($sql);
  $db->bind(":id", $wch);
  $db->bind(":knd_class", $val['k']);
  $db->bind(":user", $val['u']);
  $db->bind(":teacher", $val['t']);
  $db->bind(":date_class", $val['date']);
  $db->bind(":degre", $val['d']);
  $db->bind(":category", $val['c']);
  $db->bind(":field", $val['f']);
  $db->bind(":explain_user", $val['e']);
  $db->bind(":address", $val['ad']);
  $db->bind(":link", $val['l']);
  $db->bind(":price", $val['p']);
  $db->bind(":commission", $val['cm']);
  $db->bind(":status", ($val['ap'] == '0') ? '2' : '5' );
  $db->bind(":time_class", json_encode($time, JSON_UNESCAPED_UNICODE));

  $changed = $db->execute();
  // $arr = $sql;
  $arr = ($val['ap'] == '0') ? '5' : '2';
  $cod = 200;
  $txt = 'OK';
}
// *****************************************************************************
else{
  if(!isset($_POST['role'])) $_POST['role'] = 1;
  $knd = 'u';
  //***************************** role == 1 ********************************
  if($_POST['role']==1){
    $role = '2';
    // $sql = "SELECT
    // teachers.id AS teachers_id,
    // '' AS teachers_id2,
    // teachers.fullname,
    // teachers.address_teach,
    // degrees.name AS degre,
    // category.name AS category,
    // field.name AS field,
    // field.id AS fieldId,
    // category.id AS categoryId,
    // degrees.id AS degreId,
    // knd_class.id AS knd_class_id,
    // knd_class.name AS knd_class,
    // reserved.date_class,
    // reserved.time_class,
    // reserved.explain_user,
    // reserved.grade,
    // reserved.commission,
    // reserved.address,
    // reserved.prdCod,
    // reserved.link,
    // reserved.price,
    // '' AS user_phone,
    // '' AS teachers_phone,
    // reserved.date,
    // reserved.time,
    // reserved_status.name AS reserved_status,
    // reserved_status.id AS reserved_status_id,
    // '[]' AS messege
    // FROM reserved
    // LEFT JOIN teachers ON teachers.id=reserved.teacher
    // INNER JOIN degrees ON degrees.id=reserved.degre
    // INNER JOIN category ON category.id=reserved.category
    // INNER JOIN knd_class ON knd_class.id=reserved.knd_class
    // INNER JOIN field ON field.id=reserved.field
    // INNER JOIN reserved_status ON reserved_status.id=reserved.status
    // WHERE reserved.id=:id";
    // $sql .= (isset($_POST['username'])) ? " AND reserved.user=".$_POST['username'] : '';

    $sql = "SELECT
    teachers.id AS teachers_id,
    '' AS teachers_id2,
    teachers.fullname,
    teachers.address_teach,
    degrees.name AS degre,
    category.name AS category,
    field.name AS field,
    field.id AS fieldId,
    category.id AS categoryId,
    degrees.id AS degreId,
    knd_class.id AS knd_class_id,
    knd_class.name AS knd_class,
    reserved.date_class,
    reserved.time_class,
    reserved.explain_user,
    reserved.grade,
    reserved.commission,
    reserved.address,
    reserved.prdCod,
    reserved.link,
    reserved.price,
    '' AS user_phone,
    '' AS teachers_phone,
    reserved.date,
    reserved.time,
    reserved_status.name AS reserved_status,
    reserved_status.id AS reserved_status_id,
    '[]' AS messege
    FROM reserved
    LEFT JOIN teachers ON teachers.id=reserved.teacher
    INNER JOIN degrees ON degrees.id=reserved.degre
    INNER JOIN category ON category.id=reserved.category
    INNER JOIN knd_class ON knd_class.id=reserved.knd_class
    INNER JOIN field ON field.id=reserved.field
    INNER JOIN reserved_status ON reserved_status.id=reserved.status
    WHERE reserved.id IN (".$wch.") ";
    $sql .= (isset($_POST['username'])) ? " AND reserved.user=".$_POST['username'] : '';
  }
  //***************************** role == 2 ********************************
  else if($_POST['role']==2){
    $role = '1';
    $sql = "SELECT
    users.id AS teachers_id,
    '' AS teachers_id2,
    users.fullname,
    teachers.address_teach,
    degrees.name AS degre,
    category.name AS category,
    field.name AS field,
    field.id AS fieldId,
    category.id AS categoryId,
    degrees.id AS degreId,
    knd_class.id AS knd_class_id,
    knd_class.name AS knd_class,
    reserved.date_class,
    reserved.time_class,
    reserved.explain_user,
    reserved.grade,
    reserved.commission,
    '' AS user_phone,
    '' AS teachers_phone,
    reserved.address,
    reserved.prdCod,
    reserved.link,
    reserved.price,
    reserved.date,
    reserved.time,
    reserved_status.name AS reserved_status,
    reserved_status.id AS reserved_status_id,
    '[]' AS messege
    FROM reserved
    INNER JOIN users ON users.id=reserved.user
    INNER JOIN teachers ON teachers.id=reserved.teacher
    INNER JOIN degrees ON degrees.id=reserved.degre
    INNER JOIN category ON category.id=reserved.category
    INNER JOIN knd_class ON knd_class.id=reserved.knd_class
    INNER JOIN field ON field.id=reserved.field
    INNER JOIN reserved_status ON reserved_status.id=reserved.status
    WHERE reserved.id IN (".$wch.") ";
    $sql .= (isset($_POST['username'])) ? " AND reserved.teacher=".$_POST['username'] : '';
  }
  //***************************** role == 3 ********************************
  else if($_POST['role']==3){
    $role = '1';
    $sql = "SELECT
    users.id AS teachers_id,
    teachers.id AS teachers_id2,
    users.mobile AS user_phone,
    teachers.phone AS teachers_phone,
    users.fullname,
    teachers.fullname AS teachers_fullname,
    teachers.address_teach,
    degrees.name AS degre,
    category.name AS category,
    field.name AS field,
    field.id AS fieldId,
    category.id AS categoryId,
    degrees.id AS degreId,
    knd_class.id AS knd_class_id,
    knd_class.name AS knd_class,
    reserved.date_class,
    reserved.time_class,
    reserved.explain_user,
    reserved.grade,
    reserved.commission,
    reserved.address,
    reserved.prdCod,
    reserved.link,
    reserved.price,
    reserved.date,
    reserved.time,
    reserved_status.name AS reserved_status,
    reserved_status.id AS reserved_status_id,
    IFNULL(chat.messege, '[]') AS messege
    FROM reserved
    INNER JOIN users ON users.id=reserved.user
    LEFT JOIN teachers ON teachers.id=reserved.teacher
    INNER JOIN degrees ON degrees.id=reserved.degre
    INNER JOIN category ON category.id=reserved.category
    INNER JOIN knd_class ON knd_class.id=reserved.knd_class
    INNER JOIN field ON field.id=reserved.field
    INNER JOIN reserved_status ON reserved_status.id=reserved.status
    LEFT JOIN chat ON chat.reserved=reserved.id
    WHERE reserved.id IN (".$wch.") ";
  }
  //**************************************************************************
  $db->query($sql);
  // $db->bind(":id", $wch);
  $data = $db->resultSet();

  if(sizeof($data)>0){
    $arr = array();
    for($i=0; $i<sizeof($data); $i++){
      $disable_link = 0;
      $data[$i]->time_class = ($data[$i]->time_class == null) ? '{"start":"","end":""}' : $data[$i]->time_class;
      $data[$i]->teachers_id = ($data[$i]->teachers_id == null) ? '0' : $data[$i]->teachers_id;
      $time_class = json_decode($data[$i]->time_class);
      if($data[$i]->knd_class_id != '2' || $data[$i]->link == ''){
          $disable_link = 1;
      }
      if(jdate("Y/n/d") != $data[$i]->date_class){
        $disable_link = 1;
      }
      if(date("H:i") <= $time_class->start){
        $disable_link = 1;
      }
      if(date("H:i") >= $time_class->end){
        $disable_link = 1;
      }
      // _______________________________________________________
      $endClass = 0;
      if(jdate("Y/n/d") >= $data[$i]->date_class && date("H:i") > $time_class->end){
        $endClass = 1;
      }
      // _______________________________________________________
      $DATA = [
        "id"=> $wch,
        "teachers_id"=> $data[$i]->teachers_id,
        "teachers_id2"=> $data[$i]->teachers_id2,
        "role"=> $_POST['role'],
        "fullname"=> $data[$i]->fullname,
        "teachers_fullname"=> (isset($data[$i]->teachers_fullname)) ? $data[$i]->teachers_fullname : '' ,
        "address_teach"=> $data[$i]->address_teach,
        "degre"=> $data[$i]->degre,
        "degre_id"=> $data[$i]->degreId,
        "category"=> $data[$i]->category,
        "category_id"=> $data[$i]->categoryId,
        "field"=> $data[$i]->field,
        "field_id"=> $data[$i]->fieldId,
        "commission"=> $data[$i]->commission,
        "knd_class_id"=> $data[$i]->knd_class_id,
        "knd_class"=> $data[$i]->knd_class,
        "date_class"=> $data[$i]->date_class,
        "time_class"=> $time_class,
        "endClass"=> $endClass,
        "messege"=> json_decode($data[$i]->messege),
        "explain_user"=> $data[$i]->explain_user,
        "grade"=> $data[$i]->grade,
        "address"=> $data[$i]->address,
        "prdCod"=> $data[$i]->prdCod,
        "link"=> $data[$i]->link,
        "price"=> $data[$i]->price,
        "date"=> $data[$i]->date,
        "time"=> $data[$i]->time,
        "user_phone"=> $data[$i]->user_phone,
        "teachers_phone"=> $data[$i]->teachers_phone,
        "reserved_status_id"=> $data[$i]->reserved_status_id,
        "reserved_status"=> $data[$i]->reserved_status,
        "img"=> imgFinder($data[$i]->teachers_id, $role),
        "img2"=> imgFinder($data[$i]->teachers_id2, '2'),
        "disable_link"=> $disable_link,
      ];
      array_push($arr, $DATA);
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
