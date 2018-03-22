<?php
	
class Notification{
	
	protected $db;
	public $nid;
	public $userid;
	public $text;
	public $link;
	public $created;
	public $readState;
	public $all = array();
	
	public function __construct($nid = false, $userid = false, $text = false, $link = NULL){
		$this->db = new DB();
		$this->db = $this->db->getPDO();
		
		if($nid != false && $userid == false){
			// we are retrieving a specific notification
			$stmt = $this->db->prepare("SELECT * FROM Notifications WHERE id = ?");
			$stmt->bindParam(1, $nid);
			
			try{
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_OBJ)){ 
					$this->nid = $nid;
					$this->userid = $row->userid;
					$this->text = $row->text;
					$this->link = $row->link;
					$this->created = $row->created;
					$this->readState = $row->readState;
				}
			}
			catch(Exception $e){
				return false;
			}
		}
		else if($nid == false && $userid != false && $text == false){
			// we are retrieving all notifications for a given user
			$stmt = $this->db->prepare("SELECT * FROM Notifications WHERE userid = ?");
			$stmt->bindParam(1, $userid);			
			try{
				$stmt->execute();
				$this->all = $stmt->fetchAll(PDO::FETCH_ASSOC);				
			}
			catch(Exception $e){
				return false;
			}
		}
		else if($nid == false && $userid != false && $text != false){
			// we are creating a new notification for a user
			$stmt = $this->db->prepare("INSERT INTO Notifications (userid, text, link) VALUES (?,?,?);");
			$stmt->bindParam(1, $userid);
			$stmt->bindParam(2, $text);
			$stmt->bindParam(3, $link);
			
			try{
				$stmt->execute();
				$this->nid = $this->db->lastInsertId();
				$this->userid = $userid;
				$this->text = $text;
				$this->link = $link;
				$this->created = date("Y-m-d H:i:s");
				$this->readState = 0;
			}
			catch(Exception $e){
				return false;
			}
		}
	}
	
}

?>