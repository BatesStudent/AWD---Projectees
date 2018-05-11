<?php
spl_autoload_register(function ($class_name) {
    require_once '../classes/'.$class_name . '.class.php';
});
session_start();
if(isset($_POST['id']) && isset($_SESSION['userid'])){
	$project = new Project();	
	echo $project->newApplication($_POST['id'], $_SESSION['userid']);
}
?>