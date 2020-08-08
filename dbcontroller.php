<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "cosmotics";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}

	function closeDB() {
		mysqli_close($this->conn);
	}
	
	function runQuery($query) {
		$resultset = [];
		$result = mysqli_query($this->conn,$query);
		while ($row = mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}

	function insert($query) {
		if ($stmt = mysqli_prepare($this->conn, $query)) {
            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else{
                return false;
            }
            mysqli_stmt_close($stmt);
        }
	}

}
?>