<?php

class DB{

	private $host = 'localhost'; 
	private $db = 'projectees_db';
	private $user = 'projectees_web';
	private $pass = 'P0Nl1ne_user1';
	private $charset = 'utf8mb4';
	
	
	public function getPDO(){
		$dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";		
		$opt = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => true, ];
		return new PDO($dsn, $this->user, $this->pass, $opt);
	}
}
?>
