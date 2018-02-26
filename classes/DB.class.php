<?php

class DB{

	private $host = 'localhost'; 
	private $db = 'rfhwrjiu_AWD';
	private $user = 'rfhwrjiu_AWD';
	private $pass = 'AWDonline1819';
	private $charset = 'utf8mb4';
	
	
	public function getPDO(){
		$dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";		
		$opt = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => true, ];
		return new PDO($dsn, $this->user, $this->pass, $opt);
	}
}
?>
