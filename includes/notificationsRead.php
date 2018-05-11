<?php
spl_autoload_register(function ($class_name) {
    require_once '../classes/'.$class_name . '.class.php';
});
session_start();
if(isset($_SESSION['userid']) && isset($_POST['nid'])){
	$notification = new Notification($_POST['nid']);
	var_dump($notification->markRead());
}
?>