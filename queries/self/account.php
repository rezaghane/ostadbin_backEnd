<?php
// ---------------------------- role=1 -----------------------------------------
if($_POST['role']==1){
  $sql = "SELECT COUNT(*) AS cnt FROM users WHERE username=:username AND id!=:id";
  $db->query($sql);
  $db->bind(":id", $_POST['id']);
  $db->bind(":username", $_POST['username']);
  $data = $db->resultSet();
  $cnt = $data[0]->cnt;
  if($cnt==0 && $_POST['username']!='' && !empty($_POST['username']) && !is_null($_POST['username']) ) {
    // //**********************************************
    $sql = "UPDATE users SET fullname=:fullname, province=:province, county=:county, degrees=:degrees, field=:field, email=:email, username=:username, status=:status WHERE id =:id";
    $db->query($sql);
    $db->bind(":id", $_POST['id']);
    $db->bind(":fullname", $_POST['fullname']);
  	$db->bind(":username", $_POST['username']);
    $db->bind(":province", $_POST['province']);
    $db->bind(":degrees", $_POST['degrees']);
    $db->bind(":county", $_POST['county']);
    $db->bind(":field", $_POST['field']);
    $db->bind(":email", $_POST['email']);
    $db->bind(":status", $_POST['status']);
    $changed = $db->execute();

    $arr = $changed;
  	$cod = 200;
    $txt = 'OK';
  } else{
    // نام کاربری تکراری است
    $cod = 400;
    $txt = 'Bad Request';
    $msg = "Username is duplicate";
  }
}
// ---------------------------- role=2 -----------------------------------------
if($_POST['role']==2){
  $sql = "UPDATE teachers SET province=:province, status=:status, county=:county, email=:email, public_phone=:mobile, address=:address, address_teach=:address, about_me=:about_me WHERE id =:id";
  $db->query($sql);
  $db->bind(":id", $_POST['id']);
  $db->bind(":about_me", $_POST['about_me']);
  $db->bind(":province", $_POST['province']);
  $db->bind(":county", $_POST['county']);
  $db->bind(":mobile", $_POST['mobile']);
  $db->bind(":address", $_POST['address']);
  $db->bind(":email", $_POST['email']);
  $db->bind(":status", $_POST['status']);
  $changed = $db->execute();

  $arr = $changed;
  $cod = 200;
  $txt = 'OK';
}
?>
