<?php
function imgFinder($id=1, $role =1){
  $imgTypeMod = "";
  $imgType = ["jpg", "jpeg", "png", "gif", "svg", "ico"];
  for($j=0; $j<sizeof($imgType); $j++){
    if($role == 1) $knd='u';
    else if($role == 2) $knd='t';
    else if($role == 3) $knd='a';
    if(file_exists("upload/".$knd."_".$id.".".$imgType[$j])){
      $imgTypeMod = $knd."_".$id.".".$imgType[$j];
    }
  }
  return $imgTypeMod;
}
?>
