<?php
if(isset($_GET['activated'])){
	echo "<script>Materialize.toast('Account successfully activated, you may now log in!',5000);</script>";
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) && !empty(trim($_POST['password']))){
        // register the user
        $user = new User();
        if($user->login($_POST['email'], trim($_POST['password'])) == true){
            $_SESSION['userid'] = $user->uid;
            echo "<script>window.location.assign('index.php?p=searchProjects');</script>";
            exit;
        }
        else{
            echo "<script>Materialize.toast('Eek, login details did not match!',4000);</script>";
        }
    }
    else{
        echo "<script>Materialize.toast('Please fill in all required fields correctly!',4000);</script>";
    }
}
?>
<section class="circle-bottom-section full-height center-align">
	<div class="container">
		<div>
			<div class="row introw ">
				<h1>Login to Projectees...</h1>
				<p>Not got an account yet? What are you waiting for! <a href="index.php?p=register" class="light-blue-text">Register here.</a></p>
			</div>
			<div class="row center-align">
				<form class="col l6 s12 grey lighten-4 card offset-l3" action="index.php?p=login" method="post">
					<div class="row">
						<div class="input-field col s12">
							<i class="material-icons prefix">email</i>
							<input id="email" type="email" class="validate" name="email">
							<label for="email">Email</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<i class="material-icons prefix">lock</i>
							<input id="password" type="password" class="validate" name="password">
							<label for="password">Password</label>
						</div>
					</div>
					<div class="row">
						<div class="col s12">
							<button class="btn waves-effect waves-light amber accent-3" type="submit" name="action">Submit
								<i class="material-icons right">send</i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
