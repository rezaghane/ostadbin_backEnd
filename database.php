<?php
/*
* PDO Database Class
* Connect to database
* Create prepared statements
* Bind values
* Return rows and results
* Also provide raw queries
*/
class Database {
	private $dbhost = DB_HOST;
	private $dbuser = DB_USER;
	private $dbpass = DB_PASS;
	private $dbname = DB_NAME;
	private $dbchar = DB_CHAR;

	private $dbh;
	private $dbl;
	private $stmt;
	private $error;
	//------------------------------------
	public function __construct(){
		// Set DSN
		$dsn = 'mysql:host=' . $this->dbhost . ';dbname=' . $this->dbname;
		$options = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_USE_BUFFERED_QUERY  => true
		);

		// Create PDO instance
		try{
			$this->dbh = new PDO($dsn, $this->dbuser, $this->dbpass, $options);
			$this->dbh->query("SET NAMES ".$this->dbchar);
		} catch(PDOException $e){
			$this->error = $e->getMessage();
			echo $this->error;
		}

		// Create raw connection for none-PDO queries
		$this->db_link = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
		mysqli_set_charset($this->db_link, $this->dbchar);
	}
	//------------------------------------
	// Prepare statement with query
	public function query($sql){
		$this->stmt = $this->dbh->prepare($sql);
	}
	//------------------------------------
  // Prepare statement with transaction query
	public function trans_query($sql){
		$sql.="START TRANSACTION;".$sql.";COMMIT;";
	  $this->stmt = $this->dbh->prepare($sql);
	}
	//------------------------------------
	// Bind values
	public function bind($param, $value, $type = null){
	  if(is_null($type)){
		switch(true){
		  case is_int($value):
			$type = PDO::PARAM_INT;
			break;
		  case is_bool($value):
			$type = PDO::PARAM_BOOL;
			break;
		  case is_null($value):
			$type = PDO::PARAM_NULL;
			break;
		  default:
			$type = PDO::PARAM_STR;
		}
	  }
	  $this->stmt->bindValue($param, $value, $type);
	}
	//------------------------------------
	// Execute the prepared statement
	public function execute(){
		return $this->stmt->execute();
	}
	//------------------------------------
	// Get result set as array of objects
	public function resultSet(){
	  $this->execute();
	  return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}
	//------------------------------------
	// Get single record as object
	public function single(){
	  $this->execute();
	  return $this->stmt->fetch(PDO::FETCH_OBJ);
	}
	//------------------------------------
	// Get row count
	public function rowCount(){
	  return $this->stmt->rowCount();
	}
	//------------------------------------
	// Get column count
	public function columnCount(){
	  return $this->stmt->columnCount();
	}
	//------------------------------------
	// Prepare statement with query
	public function insert_id(){
	  return $this->dbh->lastInsertId();
	}
	//------------------------------------
	// Prepare statement with query
	public function affected_rows(){
	  return $this->dbh->affected_rows();
	}
	//------------------------------------
	// Run any commnand for raw queries
	public function runCommand($query) {
		$runCmd = $this->db_link->query($query);
		if ($runCmd) {
			return $runCmd;
		} else {
			echo "اجرای فرمان ناموفق<br>$query";
			return false;
		}
	}
	//------------------------------------
	// Fetch Results
	public function fetch($res, $typ=MYSQLI_NUM) {
		return mysqli_fetch_array($res, $typ);
	}
	//------------------------------------
	// Fetch All Results
	public function fetchall($res, $typ=MYSQLI_NUM) {
		$resAll = array();
		while ($row = $this->fetch($res, $typ)) {
			$resAll[] = $row;
		}
    return $resAll;
  }

	//------------------------------------
	// Get and fetch All Results
	public function getandfetchall($qry,$typ) {
		$res = $this->select($qry);
		$resAll = array();
		while ($row = $this->fetch($res, $typ)) {
			$resAll[] = $row;
		}
        return $resAll;
    }
	//------------------------------------
	// Go to specific record
	public function gotorec($res, $rec) {
		mysqli_data_seek($res, $rec);
	}
	//------------------------------------
	// Eelect raw query
	public function select($query) {
		$select = $this->db_link->query($query);
		if ($select) {
			return $select;
		} else {
			return false;
		}
	}
	//------------------------------------
	// Insert raw query
	public function insert($query) {
		$insert = $this->db_link->query($query);
		if (!$insert)
			echo "ثبت اطلاعات ناموفق!<br>$query";
	}
	//------------------------------------
	// Update raw query
	public function update($query) {
		$update = $this->db_link->query($query);
		if (!$update)
			echo "بروزرسانی اطلاعات ناموفق!<br>$query";
	}
	//------------------------------------
	// Delete raw query
	public function delet($query) {
		$delete = $this->db_link->query($query);
		if (!$delete)
			echo "حذف طلاعات ناموفق!<br>$query";
	}
	//------------------------------------
	// Truncate entire table
    public function trnct($table) {
        $trnct = $this->db_link->query("TRUNCATE TABLE `$table`");
        if (!$trnct)
            echo "حذف جدول ناموفق! <br> $table";
    }
	//------------------------------------
	// Counts table fields
	public function fldCount($query) {
		$fldcount = $this->db_link->query($query);
		if ($fldcount) {
			return $fldcount->field_count;
		} else  {
			return 0;
		}
	}
	//------------------------------------
	public function rowsCount($query) {
		$rowscount = $this->db_link->query($query);
		if ($rowscount) {
			return $rowscount->num_rows;
		} else  {
			return 0;
		}
	}
	//------------------------------------
	// Create raw connection for none-PDO queries
	public function reConnect($newDbName) {
		$this->db_link = mysqli_connect($this->host, $this->user, $this->pass, $newDbName);
		mysqli_set_charset($this->db_link, 'utf8');
	}
	//------------------------------------
	public function fileLog($logData) {
		$fileName = PUBROOT.'/error.log';
		$fh = fopen($fileName, 'a+');
		if (is_array($logData)) {
			$logData = print_r($logData, 1);
		}
		$status = fwrite($fh, $logData);
		fclose($fh);
		return ($status) ? true : false;
	}
	//------------------------------------
	function showError($message){
		$_SESSION['err_message'] = $message;
		echo "<script>window.open('".URLROOT."/Basics/errHandler','_parent');</script>";
	}
	//------------------------------------
}
