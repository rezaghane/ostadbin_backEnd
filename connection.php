<?php
//----------------------------------------
// DB Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//----------------------------------------
// DB Params
//$config = parse_ini_file("$_SERVER[DOCUMENT_ROOT]/../UTadris/dbConfig.conf", true);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8');
define('DB_NAME', 'tabibest_u_tadris');
define('USR_SMS', 'hossainakbari');
define('PAS_SMS', '142519001557');
define('PHN_SMS', '50002210001075');
//----------------------------------------
// DB Class
require_once "database.php";
//----------------------------------------
// DB Instance
$db = new database();
?>
