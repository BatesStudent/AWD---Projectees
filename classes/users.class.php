<?php

/* TODO


*/
	class Users{

		public $name;
		public $uid;
		public $email;
		public $db;
		
		public function __construct($id = false, $login = false){
			$this->db = new DB();
			$this->db = $this->db->getPDO();
			
			// if the ID is not false, we want to create a User using the provided ID.
			// In doing so, we only get publicly available information (i.e. this does not log the user in).
			if($id != false && $login == false){
				$stmt = $this->db->prepare("SELECT email, fName FROM Users WHERE id = ? LIMIT 1;");
				// bind params
				$stmt->bindParam(1, $id);
				try{
					// attempt to execute the sql select statement
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
						$this->uid = $id;
						$this->name = $row->fName;
						$this->email = $row->email;
					}
				}
				catch(Exception $e){
					return $e;
				}
			}
		}
		
		public function setEmail($email,$password){
			if($this->verifyPassword($password) && filter_var($email, FILTER_VALIDATE_EMAIL)){
				// prepare statement
				$stmt = $this->db->prepare("UPDATE Users SET email = ? WHERE id = $this->uid;");
				// bind params
				$stmt->bindParam(1, $email);
				try{
					// attempt to execute the sql statement
					$stmt->execute();
					$this->email = $email;
					return true;
				}
				catch(Exception $e){
					return false;
				}
			}
			else{
				return false;
			}
		}
		
		public function updatePassword($password, $newPassword){
			if($this->verifyPassword($password)){
				// prepare statement
				$stmt = $this->db->prepare("UPDATE Users SET password = ? WHERE id = $this->uid;");
				// bind params
				$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
				$stmt->bindParam(1, $newPassword);
				try{
					// attempt to execute the sql statement
					$stmt->execute();
					return true;
				}
				catch(Exception $e){
					return $e;
				}
			}
			else{
				return false;
			}
		}
		
		public function logIn($email, $password){
			if(empty($email) || empty($password)){
				return false;
			}
			// check if the submitted email address is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return false;
			}
			else{
				// prepare select statement
				$stmt = $this->db->prepare("SELECT id, password, fName FROM Users WHERE email = ? LIMIT 1;");
				// bind params
				$stmt->bindParam(1, $email);
				try{
					// attempt to execute the sql select statement
					$stmt->execute();
					// if there is a row with a matching email AND the passwords match, log the user in
					while ($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
						if(password_verify($password, $row->password)){
							$this->uid = $row->id;
							$this->name = $row->fName;
							$this->db->query("UPDATE Users SET lastLogin = CURRENT_TIMESTAMP WHERE id = $row->id;");
							return true;
						}
						else{
							return false;
						}
					}
				}
				catch(Exception $e){
					return $e;
				}
				return false;
			}
		}		
		public function logOut(){
			$this->name = null;
			$this->uid = null;
			$this->email = null;
		}
		public function getName(){
			return $this->name;
		}
		public function getID(){
			return $this->uid;
		}
		public function getEmail(){
			return $this->email;
		}
		
		public function register($email, $password, $passwordConfirm, $fName, $sName){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password) || empty($fName) || strlen($password) < 4 || $password != $passwordConfirm){
				return false;
			}
			$password = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $this->db->prepare("INSERT INTO Users (fName, sName, email, password) VALUES (?,?,?,?)");
				
			$stmt->bindParam(1, $fName);
			$stmt->bindParam(2, $sName);
			$stmt->bindParam(3, $email);
			$stmt->bindParam(4, $password);
			try{
				$this->db->beginTransaction();
				$stmt->execute();
				$userid = $this->db->lastInsertId();
				$this->db->query("INSERT INTO UserPreferences (userid) VALUES ($userid)");
				$this->db->commit();
				return true;
			}
			catch(Exception $e){
				$this->db->rollBack();
				return $e;
			}
		}
		
		public function deleteAccount($password, $confirmation){
			if($confirmation === "DELETE" && $this->verifyPassword($password)){				
				try{
					$this->db->query("DELETE FROM Users WHERE id = ".$this->uid.";");
					$this->logOut();
					return true;
				}
				catch(Exception $e){
					return false;
				}
			}
			else{
				return false;
			}

		}
				
	 	// function for checking password of user
		private function verifyPassword($password){
			$stmt = $this->db->query("SELECT password FROM Users WHERE id = $this->uid;");			
			while ($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
				if(password_verify($password, $row->password)){
					return true;
				}
				else{
					return false;
				}
			}
		}
	}
			
?>
