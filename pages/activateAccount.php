<?php
	if(isset($_GET['c'])){
		$user = new User();
		if($user->activateAccount($_GET['c']) === true){
			
			echo "<script>window.location.assign('index.php?p=login&activated=y');</script>";
			exit;
		}
		else{
			echo "<script>Materialize.toast('Account not activated, is your link correct?',5000);</script>";
			require_once "register.php";
		}
	}

?>