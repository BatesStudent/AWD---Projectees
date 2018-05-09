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
				$stmt = $this->db->prepare("UPDATE Users SET email = :email WHERE id = :uid;");
				// bind params
				$stmt->bindParam(':email', $email);
                $stmt->bindParam(':uid', $this->uid);
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
				$stmt = $this->db->prepare("UPDATE Users SET password = ? WHERE id = ?;");
				// bind params
				$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
				$stmt->bindParam(1, $newPassword);
                $stmt->bindParam(2, $this->uid);
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
				return "Please fill in all fields.";
			}
			// check if the submitted email address is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return "Please enter a valid email address";
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
                            $error = "Hmm... Have you activated your account? (Check your emails!)";
							return $error;
						}
						else if(password_verify($password, $row->password)){
							$this->uid = $row->id;
							$this->name = $row->fName;
							return true;
						}
						else{
							return "Credentials do not match!";
						}
					}
				}
				catch(Exception $e){
					return "Something went wrond on our end, please get in touch if the problem persists.";
				}
				return false;
			}
		}
        
		public function getProfile($allinfo = false, $username = false){
			if($username == false){
                if($allinfo){
				    $stmt = $this->db->prepare("SELECT * FROM userProfile_all WHERE id = ? LIMIT 1");
                } else {
                    $stmt = $this->db->prepare("SELECT * FROM userProfile_limited WHERE id = ? LIMIT 1");
                }
                $stmt->bindParam(1, $this->uid);
				try{
					$stmt->execute();
					return $stmt->fetch(PDO::FETCH_OBJ);
				}
				catch(Exception $e){
					return false;
				}
			}
			else{
                if($allinfo){
				    $stmt = $this->db->prepare("SELECT * FROM userProfile_all WHERE username = ?");
                } else {
                    $stmt = $this->db->prepare("SELECT * FROM userProfile_limited WHERE username = ?");
                }
				$stmt->bindParam(1, $username);
				try{
					$stmt->execute();
					return $stmt->fetch(PDO::FETCH_OBJ);
				}
				catch(Exception $e){
					return false;
				}
			}
		}
        
        public function setLinkedIn($new){
            $stmt = $this->db->prepare("UPDATE Users SET linkedin = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $this->uid);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        
        public function setDOB($new){
            $stmt = $this->db->prepare("UPDATE Users SET dateOfBirth = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $this->uid);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setLocation($new){
            $stmt = $this->db->prepare("UPDATE Users SET location = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $this->uid);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setOccupation($new){
            $stmt = $this->db->prepare("UPDATE Users SET occupation = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $this->uid);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setDescription($new){
            $stmt = $this->db->prepare("UPDATE Users SET description = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $this->uid);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setIntro($new){
            $stmt = $this->db->prepare("UPDATE Users SET intro = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $this->uid);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setProfileImage($new){
            $stmt = $this->db->prepare("UPDATE Users SET profilePic = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $this->uid);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
        public function setCoverPhoto($new){
            $stmt = $this->db->prepare("UPDATE Users SET coverPhoto = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $this->uid);
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
					$stmt = $this->db->prepare("DELETE FROM Users WHERE id = ?;");
                    $stmt->bindParam(1, $this->uid);
                    $stmt->execute();
                    if($stmt->rowCount() > 0){
					   // check an account was actually updated
					   return true;
                    }
                    else{
                        return false;
                    }
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
			$stmt = $this->db->prepare("SELECT password FROM Users WHERE id = ? LIMIT 1");
            $stmt->bindParam(1, $this->uid);
            try{
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
                    if(password_verify($password, $row->password)){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
            } catch(Exception $e){
                return false;
            }			
		}
		
		// function to check if a username already exists
		public function checkUsername($username){
			$username = trim($username);
			$stmt = $this->db->prepare("SELECT id FROM Users WHERE username = ? LIMIT 1");
			$stmt->bindParam(1, $username);
			try{
				$stmt->execute();
				if($stmt->rowCount() > 0){
                    // if a user already exists with that username, the call is failed
					return false;
				}
				else{
                    // if the username is available, return true
					return true;
				}				
			}
			catch(Exception $e){
				return false;
			}
		}
        
        public function addSkill($skill){
            // does user already have this skill?
            $stmt = $this->db->prepare("SELECT name FROM usersSkills WHERE userID = ? AND name = ?");
            $stmt->bindParam(1, $this->uid);
            $stmt->bindParam(2, $skill);
            try{
                $stmt->execute();
                if($stmt->rowCount() > 0){
					return "You already have this skill!";
				}
                else {
                    // does this skill already exist?
                    $stmt = $this->db->prepare("SELECT id FROM Skills WHERE name = ?");
                    $stmt->bindParam(1, $skill);
                    try{
                        $stmt->execute();
                        if($stmt->rowCount() > 0){
                            // the skill does exist so no need to add it, just link to its ID
                            $row = $stmt->fetch(PDO::FETCH_OBJ);
                            $skillID = $row->id;
                            $stmt = $this->db->prepare("INSERT INTO UserSkills (userID, skillID) VALUES (?, ?)");
                            $stmt->bindParam(1, $this->uid);
                            $stmt->bindParam(2, $skillID);
                            try{
                                $stmt->execute();
                                return true;
                            }
                            catch (Exception $e){
                                return false;
                            }
                        } else {
                            // we need to add the skill to the skills table first
                            $stmt = $this->db->prepare("INSERT INTO Skills (name) VALUES (?)");
                            $stmt->bindParam(1, $skill);
                            try{
                                $stmt->execute();
                                $skillID = $this->db->lastInsertId();
                                $stmt = $this->db->prepare("INSERT INTO UserSkills (userID, skillID) VALUES (?,?)");
                                $stmt->bindParam(1, $this->uid);
                                $stmt->bindParam(2, $skillID);
                                try{
                                    $stmt->execute();
                                    return true;
                                }
                                catch (Exception $e){
                                    return false;
                                }
                            }
                            catch (Exception $e){
                                return false;
                            }
                        }
                    }
                    catch (Exception $e){
                        return false;
                    }
                }
            }
            catch (Exception $e){
                return false;
            }
        }
		
		public function removeSkill($skill){
			// get skill ID from skill name
			$stmt = $this->db->prepare("SELECT id FROM Skills WHERE name = ? LIMIT 1");
			$stmt->bindParam(1, $skill);
			try{
				$stmt->execute();
				if($stmt->rowCount() > 0){
					$row = $stmt->fetch(PDO::FETCH_OBJ);
					$skillID = $row->id;
					$stmt = $this->db->prepare("DELETE FROM UserSkills WHERE userID = ? AND skillID = ?");
					$stmt->bindParam(1, $this->uid);
					$stmt->bindParam(2, $skillID);
					try{
						$stmt->execute();
						return true;
					} catch(Exception $e){
						return false;
					}
				} else {
					return false;
				}
			} catch(Exception $e) {
				return false;
			}
		}
		
	}

?>