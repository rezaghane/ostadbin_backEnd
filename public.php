<?php
require_once "connection.php";
require_once "check_token.php";
require_once "jdf.php";
require_once "logs.php";
require_once "imgFinder.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
}
$data = array();
$sql = "";
$date = jdate("Y/n/d");
session_start();
?>
