<?php
/**
 * Created by hiran.
 * Date: 12/3/19
 * Time: 4:30 PM
 */
class database{
	private $conn;
	private $debug;

	function __construct(){
		$this->connect();
	}
	/**
	*
	*/
	private function connect() : void{
		$this->conn = new mysqli(
			"localhost",
			"test_usr",
			"root@V1nam",
			"User",
			3306
		);
		if (!$this->conn) {
			die($this->conn->connect_error);
		}
	}
	/**
	*@param:int $debug
	*/
	public function setdebug($debug) : void{
		$this->debug=$debug;
	}

	/**
	*@param:array $data
	*@return:int
	*/
	public function insert($data) : int{
		$sql = "insert into ".get_called_class()." SET ";
		foreach ($data as $key => $value) {
			if (array_key_exists($key, get_class_vars(get_called_class()))){
				$sql .= $key .' = "'. $value . '",';
			}
		}
		$sql = rtrim($sql,",");
		// if($this->debug==1)
		// 	echo "query :".$sql;
		return $this->conn->query($sql);
	}

	/**
	*@param:string $email
	*@return:int
	*/
	public function check_email_exist($email) : int{
		$result=array();
		$sql = 'select email from '.get_called_class(). ' where email = "'.$email.'"';
		 // if($this->debug==1)
		 // 	echo "query :".$sql;
		 $result = $this->conn->query($sql);
		if(mysqli_num_rows($result)) {
		    return 1;
		}
		else
			return 0;
	}
}
?>