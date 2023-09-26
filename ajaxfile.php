<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
require_once "./jdf.php";
$data = array();
if(isset($_FILES['file']['name'])){
	$idImg = $_POST['idImg'];
	$idImg = str_replace("[DATE]", jdate("Y_n_d"), $idImg);
	$idImg = str_replace("[RANDOM]", rand(), $idImg);

	$filename = $_FILES['file']['name'];
	$file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$file_extension = strtolower($file_extension);
	$valid_ext = explode(",",$_POST['format']);
	$location = 'upload/'.$idImg.".".$file_extension;
	$response = 0;
	if(in_array($file_extension,$valid_ext) || in_array('*',$valid_ext)){
	  	if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
	    	$response = 1;
	  	}
	}
	$data = (object) [
		'response' => $response,
		'file_extension' => $file_extension,
		'uploadFileName' => $idImg.".".$file_extension,
		'filename' => $filename,
		];
		if(isset($_POST['oldImg'])) if($_POST['oldImg']!=''){
			if(file_exists("upload/".$_POST['oldImg'])) {
				unlink("upload/".$_POST['oldImg']);
			}
		}
	echo json_encode($data);
	exit;
}
?>
