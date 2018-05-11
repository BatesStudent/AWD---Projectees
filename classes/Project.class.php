<?php

	class Project{
		
		public $pid;
		protected $db;
		
		public function __construct(){
			$this->db = new DB();
			$this->db = $this->db->getPDO();
		}
		
		public function getCardDetails($id){
			$stmt = $this->db->prepare("SELECT * FROM projectCards WHERE id = ? LIMIT 1;");
			// bind params
			$stmt->bindParam(1, $id);
			try{
				// attempt to execute the sql select statement
				$stmt->execute();
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			catch(Exception $e){
				return $e;
			}
		}
		
		public function newProject($title, $ownerID, $shortDescription, $categoryID, $capacity, $startDate, $virtualOnly, $coverPhoto, $longDescription, $lookingFor, $targetCompletionDate, $inviteOnly){
			// validate and sanitise 
			$title = trim(strip_tags($title));
			$shortDescription = trim(strip_tags($shortDescription));
			$longDescription = trim(strip_tags($longDescription));
			$lookingFor = trim(strip_tags($lookingFor));
			$coverPhoto = trim($coverPhoto);
			
			if(strlen($title) > 0 && strlen($shortDescription) > 0){
				if(strlen($longDescription) == 0){
					$longDescription = null;
				}
				if(strlen($lookingFor) == 0){
					$lookingFor = null;
				}
				if(strlen($targetCompletionDate) == 0){
					$targetCompletionDate = null;
				}
				if(strlen($coverPhoto) == 0){
					$coverPhoto = null;
				}
				$stmt = $this->db->prepare("INSERT INTO Projects (title, ownerID, shortDescription, categoryID, capacity, startDate, virtual, coverPhoto, longDescription, lookingFor, targetCompletionDate, inviteOnly) VALUES (:title, :ownerID, :shortDescription, :categoryID, :capacity, :startDate, :virtualOnly, :coverPhoto, :longDescription, :lookingFor, :targetCompletionDate, :inviteOnly)");
				$stmt->bindParam(':title', $title);
				$stmt->bindParam(':ownerID', $ownerID);
				$stmt->bindParam(':shortDescription', $shortDescription);
				$stmt->bindParam(':categoryID', $categoryID);
				$stmt->bindParam(':capacity', $capacity);
				$stmt->bindParam(':startDate', $startDate);
				$stmt->bindParam(':virtualOnly', $virtualOnly);
				$stmt->bindParam(':coverPhoto', $coverPhoto);
				$stmt->bindParam(':longDescription', $longDescription);
				$stmt->bindParam(':lookingFor', $lookingFor);
				$stmt->bindParam(':targetCompletionDate', $targetCompletionDate);
				$stmt->bindParam(':inviteOnly', $inviteOnly);
				try{
					$stmt->execute();
					$pid = $this->db->lastinsertid();
					$n = new Notification(false, $ownerID, "Project: $title is live!", "index.php?p=projectView&id=$pid");
					return $pid;
				} catch(Exception $e){	
					return $e;
				}
			} else {
				return false;
			}			
		}
		
		public function getProfile($id){
			$stmt = $this->db->prepare("SELECT * FROM projectProfiles WHERE id = ? LIMIT 1");			
			$stmt->bindParam(1, $id);
			try{
				$stmt->execute();
				return $stmt->fetch(PDO::FETCH_OBJ);
			}
			catch(Exception $e){
				return $e;
			}
		}
		
		public function getMembers($id){
			$stmt = $this->db->prepare("SELECT userID FROM Applications WHERE projectID = ? AND status > 0");
			$stmt->bindParam(1, $id);
			try{
				$stmt->execute();
				$idsArray = [];
				$rows =	$stmt->fetchAll(PDO::FETCH_OBJ);
				foreach($rows as $row){
					array_push($idsArray, $row->userID);
				}
				return $idsArray;
			}
			catch(Exception $e){
				return false;
			}
		}
		
		
        public function setCoverPhoto($new, $id){
            $stmt = $this->db->prepare("UPDATE Projects SET coverPhoto = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $id);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
		
		public function setShort($new, $id){
            $stmt = $this->db->prepare("UPDATE Projects SET shortDescription = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $id);
            try{
                $stmt->execute();				
				if($stmt->rowCount() > 0){
                	return true;
				} else {
					return "Description not changed.";
				}
            }
            catch(Exception $e){
                return false;
            }
        }
		
		public function setLong($new, $id){
            $stmt = $this->db->prepare("UPDATE Projects SET longDescription = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $id);
            try{
                $stmt->execute();
                if($stmt->rowCount() > 0){
                	return true;
				} else {
					return "Description not changed.";
				}
            }
            catch(Exception $e){
                return false;
            }
        }
		
		public function setLookingFor($new, $id){
            $stmt = $this->db->prepare("UPDATE Projects SET lookingFor = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $id);
            try{
                $stmt->execute();
                if($stmt->rowCount() > 0){
                	return true;
				} else {
					return "Looking For not changed.";
				}
            }
            catch(Exception $e){
                return false;
            }
        }
		
		public function setCapacity($new, $id){
            $stmt = $this->db->prepare("UPDATE Projects SET capacity = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $id);
            try{
                $stmt->execute();
                return true;
            }
            catch(Exception $e){
                return false;
            }
        }
		
		public function setEndDate($new, $id){
            $stmt = $this->db->prepare("UPDATE Projects SET targetCompletionDate = ? WHERE id = ?");
            $stmt->bindParam(1, $new);
            $stmt->bindParam(2, $id);
            try{
                $stmt->execute();
                if($stmt->rowCount() > 0){
                	return true;
				} else {
					return "End date not changed.";
				}
            }
            catch(Exception $e){
                return false;
            }
        }
		
		public function newApplication($id, $userid){
			$project = $this->getCardDetails($id);
			$stmt = $this->db->prepare("INSERT INTO Applications (userID, projectID) VALUES (:userID, :projectID)");
			$stmt->bindParam(':userID',$userid);
			$stmt->bindParam(':projectID',$id);
			if($project->currentMembers < $project->capacity){
				try{
					$stmt->execute();
					$n = new Notification(false, $project->ownerID, "Someone wants to help out with ".$project->title, "index.php?p=projectView&id=$id");
					return "Application made successfully!";
				} catch(Exception $e){
					return "Application failed do to a scary technical reason!";
				}
			} else {
				return "Oh no! It seems this project is full up!";
			}
		}
		
		public function getApplications($id){
			$stmt = $this->db->prepare("SELECT * FROM Applications WHERE projectID = ? AND status = 0");
			$stmt->bindParam(1, $id);
			try{
				$stmt->execute();
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			} catch(Exception $e){
				return false;
			}
		}
		
		public function respondToApplication($pid, $uid, $value){
			$stmt = $this->db->prepare("UPDATE Applications SET status = ? WHERE userID = ? AND projectID = ?");
			$stmt->bindParam(1, $value, PDO::PARAM_INT);
			$stmt->bindParam(2, $uid);
			$stmt->bindParam(3, $pid);
			try{
				$stmt->execute();
				if($stmt->rowCount() > 0){
					return true;
				} else {
					return false;
				}
			} catch(Exception $e){
				return false;
			}
		}
	}
?>