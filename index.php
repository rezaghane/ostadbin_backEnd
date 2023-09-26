<?php
//----------------------------------------
// DB Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTION");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Lang, X-Auth-Token");
header("Content-type: application/json; charset=utf-8");
require_once "./jdf.php";

//----------------------------------------
if(isset($_GET['url'])){
	$info_email = "info@tabibestan.ir.com";

	$url = $_GET['url'];
	$dta = explode("/",$url);
	$url = (isset($dta[0])) ? $dta[0] : '';
	$wch = (isset($dta[1])) ? $dta[1] : '';
	$mod = (isset($dta[2])) ? $dta[2] : '';
	$_GET['p'] = (isset($_GET['p'])) ? $_GET['p'] : 1;
	$_GET['n'] = (isset($_GET['n'])) ? $_GET['n'] : 10;
	@require_once "./queries/".$url."/".$url.".php";
}
?>
