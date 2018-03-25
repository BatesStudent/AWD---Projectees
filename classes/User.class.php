<?php

	class User{

		public $name;
		public $uName;
		public $profilePic;
		public $coverPhoto;
		public $uid;
		public $email;
		protected $db;
		
		public function __construct($id = false){
			$this->db = new DB();
			$this->db = $this->db->getPDO();
			
			// if the ID is not false, we want to create a User using the provided ID.
			// In doing so, we only get publicly available information (i.e. this does not log the user in).
			if($id != false){
				$stmt = $this->db->prepare("SELECT email, fName, username, profilePic, coverPhoto FROM Users WHERE id = ? LIMIT 1;");
				// bind params
				$stmt->bindParam(1, $id);
				try{
					// attempt to execute the sql select statement
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
						$this->uid = $id;
						$this->name = $row->fName;
						$this->email = $row->email;
						$this->uName = $row->username;
						$this->profilePic = $row->profilePic;
						$this->coverPhoto = $row->coverPhoto;
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
				$stmt = $this->db->prepare("SELECT id, password, fName, activated FROM Users WHERE email = ? LIMIT 1;");
				// bind params
				$stmt->bindParam(1, $email);
				try{
					// attempt to execute the sql select statement
					$stmt->execute();
					// if there is a row with a matching email AND the passwords match, log the user in
					while ($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
						if($row->activated != 1){
							return false;
						}
						else if(password_verify($password, $row->password)){
							$this->uid = $row->id;
							$this->name = $row->fName;
							return true;
						}
						else{
							return false;
						}
					}
				}
				catch(Exception $e){
					return false;
				}
				return false;
			}
		}
		public function getProfile($username = false){
			
			if($username == false){
				$stmt = $this->db->prepare("SELECT id, fName, sName, email, linkedin, profilePic, username, dateOfBirth, searching, location, virtualOnly, occupation, coverPhoto, description, intro FROM Users WHERE id = $this->uid");
				try{
					$stmt->execute();
					return $stmt->fetch(PDO::FETCH_OBJ);
				}
				catch(Exception $e){
					return $e;
				}
			}
			else{
				$stmt = $this->db->prepare("SELECT id, fName, sName, email, linkedin, profilePic, username, dateOfBirth, searching, location, virtualOnly, occupation, coverPhoto, description, intro FROM Users WHERE username = ?");
				$stmt->bindParam(1, $username);
				try{
					$stmt->execute();
					return $stmt->fetch(PDO::FETCH_OBJ);
				}
				catch(Exception $e){
					return $e;
				}
			}
		}
        public function setLinkedIn($new){
            $stmt = $this->db->prepare("UPDATE Users SET linkedin = ? WHERE id = $this->uid");
            $stmt->bindParam(1, $new);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setDOB($new){
            $stmt = $this->db->prepare("UPDATE Users SET dateOfBirth = ? WHERE id = $this->uid");
            $stmt->bindParam(1, $new);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setLocation($new){
            $stmt = $this->db->prepare("UPDATE Users SET location = ? WHERE id = $this->uid");
            $stmt->bindParam(1, $new);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setOccupation($new){
            $stmt = $this->db->prepare("UPDATE Users SET occupation = ? WHERE id = $this->uid");
            $stmt->bindParam(1, $new);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setDescription($new){
            $stmt = $this->db->prepare("UPDATE Users SET description = ? WHERE id = $this->uid");
            $stmt->bindParam(1, $new);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setIntro($new){
            $stmt = $this->db->prepare("UPDATE Users SET intro = ? WHERE id = $this->uid");
            $stmt->bindParam(1, $new);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setProfileImage($new){
            $stmt = $this->db->prepare("UPDATE Users SET profilePic = ? WHERE id = $this->uid");
            $stmt->bindParam(1, $new);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setCoverPhoto($new){
            $stmt = $this->db->prepare("UPDATE Users SET coverPhoto = ? WHERE id = $this->uid");
            $stmt->bindParam(1, $new);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
		public function profileCompletion(){
            $stmt = $this->db->query("SELECT linkedin, profilePic, dateOfBirth, searching, location, virtualOnly, occupation, coverPhoto, description, intro FROM Users WHERE id = $this->uid");
            $rows = $stmt->fetch(PDO::FETCH_OBJ);
            $completion = 0;
            foreach($rows as $key=>$value){
                if($value != NULL){
                    $completion = $completion + 10;
                }
            }
            
			return $completion;
		}
		
		public function register($email, $password, $fName, $sName = null, $uName){
			// generate random activation code
			$activationCode = md5($uName);
			
			// hash password
			$password = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $this->db->prepare("INSERT INTO Users (fName, sName, email, password, username, activationCode) VALUES (?,?,?,?,?,?)");
				
			$stmt->bindParam(1, $fName);
			$stmt->bindParam(2, $sName);
			$stmt->bindParam(3, $email);
			$stmt->bindParam(4, $password);
            $stmt->bindParam(5, $uName);
			$stmt->bindParam(6, $activationCode);
			try{				
				$stmt->execute();
				// check account was created and send activation email
				// a common reason for the account not creating is duplicate email addresses (only 1 account per email is allowed)
				if($stmt->rowCount() > 0){
					
					mail($email, "Welcome to Projectees!","Hi, $uName!<br><br>Thank you for registering an account with Projectees, we hope you enjoy using the platform and mostly importantly <strong>get stuff done</strong>!<br><br>Please click the link to verify your account, allowing you to log in:<br><a href='http://".$_SERVER['HTTP_HOST']."/projectees/index.php?p=activateAccount&c=$activationCode' target='_blank'>Verify</a><br><br>Thanks, we look forward to seeing what you create - Projectees","From: noreply@projectees.com\r\nMIME-Version: 1.0\r\nContent-type:text/html;charset=UTF-8");
					// create welcome notification 
					new Notification(false, $this->db->lastInsertId(),"Thank you for joining the Projectees Community!");					
					return true;
				} else {
					return false;
				}
			}
			catch(Exception $e){				
				return false;
			}
		}
		
		public function activateAccount($code){
			$stmt = $this->db->prepare("UPDATE Users SET activated = 1 WHERE activationCode = ?");
			$stmt->bindParam(1, $code);
			try{
				$stmt->execute();
				if($stmt->rowCount() > 0){
					// check an account was actually updated
					return true;
				}
				else{
					return false;
				}
			}
			catch(Exception $e){
				return false;
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
		
		// function to check if a username already exists
		public function checkUsername($username){
			$username = trim($username);
			$stmt = $this->db->prepare("SELECT id FROM Users WHERE username = ?");
			$stmt->bindParam(1, $username);
			try{
				$stmt->execute();
				if($stmt->rowCount() > 0){
					return false;
				}
				else{
					return true;
				}				
			}
			catch(Exception $e){
				return false;
			}
		}
	}
			
?>
