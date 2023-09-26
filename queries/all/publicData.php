<?php
// _____________________________________________________________________________
$sql = "SELECT * FROM category WHERE status=1";
$db->query($sql);
$data = $db->resultSet();
$C = [];
if(sizeof($data)>0){
  for($i=0; $i<sizeof($data); $i++){
    $D =[
      "id"=> $data[$i]->id,
      "name"=> $data[$i]->name,
    ];
    array_push($C,$D);
  }
}
// _____________________________________________________________________________
$sql = "SELECT * FROM teachers WHERE status=1";
$db->query($sql);
$data = $db->resultSet();
$T = [];
if(sizeof($data)>0){
  for($i=0; $i<sizeof($data); $i++){
    $D =[
      "id"=> $data[$i]->id,
      "name"=> $data[$i]->fullname,
      "address"=> $data[$i]->address,
    ];
    array_push($T,$D);
  }
}
// _____________________________________________________________________________
$sql = "SELECT * FROM users WHERE status=1";
$db->query($sql);
$data = $db->resultSet();
$U = [];
if(sizeof($data)>0){
  for($i=0; $i<sizeof($data); $i++){
    $address = json_decode($data[$i]->address);
    $D_A = [];
    for($j=0; $j<sizeof($address); $j++){
      $D_a = [
        "id"=> $j,
        "name"=> $address[$j],
        "address"=> json_decode($data[$i]->address),
      ];
      array_push($D_A, $D_a);
    }
    $D = [
      "id"=> $data[$i]->id,
      "name"=> $data[$i]->fullname,
      "address"=> $D_A,
    ];
    array_push($U,$D);
  }
}
// _____________________________________________________________________________
$sql = "SELECT * FROM knd_class";
$db->query($sql);
$data = $db->resultSet();
$K = [];
if(sizeof($data)>0){
  for($i=0; $i<sizeof($data); $i++){
    $D =[
      "id"=> $data[$i]->id,
      "name"=> $data[$i]->name,
    ];
    array_push($K, $D);
  }
}
// _____________________________________________________________________________
$sql = "SELECT * FROM social_network";
$db->query($sql);
$SN = $db->resultSet();
// _____________________________________________________________________________
$A = [
  "teacher" => $T,
  "user" => $U,
  "knd_class" => $K,
  "category" => $C,
  "social_network" => $SN,
];
$arr = $A;
$cod = 200;
$txt = '';
$msg = "";
?>
