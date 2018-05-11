<?php
spl_autoload_register(function ($class_name) {
    require_once '../classes/'.$class_name . '.class.php';
});
session_start();
if(isset($_POST['id']) && isset($_SESSION['userid'])){
	$inviter = new User($_SESSION['userid']);
	$name = $inviter->username;
	$n = new Notification(false, $_POST['id'], "$name has invited you to apply to their projects! Check them out!", "index.php?p=userProfile&username=$name#projects");
}
?>