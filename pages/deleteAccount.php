<?php
if(!isset($_SESSION['userid'])){
	echo "<script>window.location.assign('index.php?p=login');</script>";
	exit;
} else if(isset($_POST['action'])) {
	if(trim($_POST['delete']) == "DELETE"){
		$user = new User($_SESSION['userid']);
		$result = $user->deleteAccount($_POST['password']);
		if($result === true){
			require_once "pages/logout.php";
			echo "<script>window.location.assign('index.php');</script>";
		} else {
			echo '<script>M.toast({html:"Please enter your password correctly."});</script>';
		}
	} else {
		echo '<script>M.toast({html:"Please enter DELETE in capital letters"});</script>';
	}
}
?>
<section>
	<div class="container">
		<div class="row introw">
			<div class="col s12">
				<h1>Are you sure you want to do this?</h1>
				<p>You have complete control over your account so we won't try to stop you from leaving. A quick head's up though:</p>
				<div class="card-panel red darken-2 white-text">
					<p><strong>If you decide to delete your account we will remove all your user data.</strong> This means you won't be able to return to the app and reclaim your information - you will have to start afresh.</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col s12">
				<form action="index.php?p=deleteAccount" method="post">					
				  <div class="row">
					<div class="input-field col s12">
					  <input id="password" type="password" class="validate" name="password">
					  <label for="password">Password</label>
					</div>
				  </div>
					<div class="row">						
						<div class="input-field col s12">
						  <input id="delete" type="text" class="validate" name="delete">
						  <label for="delete">Type the word 'DELETE' in all caps:</label>
						</div>
						  <button class="btn waves-effect waves-light red darken-2" type="submit" name="action">Delete account forever
							<i class="material-icons right">warning</i>
						  </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>