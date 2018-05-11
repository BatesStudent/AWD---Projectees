<?php
spl_autoload_register(function ($class_name) {
    require_once '../classes/'.$class_name . '.class.php';
});
session_start();
if(isset($_POST['userid']) && isset($_POST['projectid']) && isset($_POST['value']) && isset($_SESSION['userid'])){
	$project = new Project();
	if($project->respondToApplication($_POST['projectid'], $_POST['userid'], $_POST['value']) !== false){
		if($_POST['value'] == 1){
			$n = new Notification(false, $_POST['userid'], "Your application was accepted, yay!", "index.php?p=projectView&id=".$_POST['projectid']);
		} else if($_POST['value'] == -1){
			$n = new Notification(false, $_POST['userid'], "Your application was rejected, boo:(", "index.php?p=projectView&id=".$_POST['projectid']);
		}
		echo "success";
	} else {
		echo "failed";
	}	
} else {echo "whaaat";}
?>