<?php
spl_autoload_register(function ($class_name) {
    require_once '../classes/'.$class_name . '.class.php';
});
$user = new User();
if($user->checkUsername($_POST['username']) == false){
	echo "Username already taken, sorry!";
}
?>