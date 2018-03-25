<?php
if(isset($_POST['register-action'])){
    if(!empty(trim($_POST['fName'])) && !empty(trim($_POST['lName'])) && !empty(trim($_POST['uName'])) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) && !empty(trim($_POST['password'])) && !empty(trim($_POST['passwordConfirmation']))){
        if($_POST['password'] === $_POST['passwordConfirmation']){
            // register the user
            $user = new User();
			if($user->checkUsername($_POST['uName'])){			
			
				if($user->register($_POST['email'], trim($_POST['password']), trim($_POST['fName']), trim($_POST['lName']),trim($_POST['uName'])) == true){
					// inform the user they must verify their account before logging in and present login page
					echo "<script>Materialize.toast('Successfully registered, you must verify your account before you can log in (check your email for a link)!',10000);</script>";
					require_once "pages/login.php";
					return;
				}
				else{
					echo "<script>Materialize.toast('Eek, we were unable to create your account! Maybe you already have an account with that email address?',4000);</script>";
				}
			}
			else{
				echo "<script>Materialize.toast('That username is already taken, sorry!',4000);</script>";
			}
        }
        else{
            echo "<script>Materialize.toast('Passwords do not match!',4000);</script>";
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
				<div class="row introw">
					<h1>Join Projectees...</h1>
					<p>Already have an account? Well, what are you doing here then!? <a href="index.php?p=login" class="light-blue-text">Log in here.</a></p>
				</div>
				<div class="row center-align">
                    <div class="col l2 m1 hide-on-small">
                    </div>
					<form class="col l8 m10 s12 card" action="index.php?p=register" method="post">
						<div class="col s12">
							<div class="row">
								<div class="input-field col m6 s12">
                                     <i class="material-icons prefix">person</i>
									<input id="fName" type="text" class="validate" name="fName" required>
									<label for="fName">First Name *</label>
								</div>
								<div class="input-field col m6 s12">
									<input id="lName" type="text" class="validate" name="lName" required>
									<label for="lName">Last name *</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m6 s12">
							         <i class="material-icons prefix">email</i>
									<input id="uName" type="text" class="validate" name="uName" required>
									<label for="uName">Username *</label>
								</div>
								<div class="input-field col m6 s12">
									<input id="email" type="email" class="validate" name="email" required>
									<label for="email">Email *</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col l6 m6 s12">
                                    <i class="material-icons prefix">lock</i>
									<input id="password" type="password" class="validate" name="password" required>
									<label for="password">Password *</label>
								</div>
								<div class="input-field col l6 m6 s12">
									<input id="passwordConfirmation" type="password" name="passwordConfirmation" required>
									<label for="passwordConfirmation">Password Confirmation *</label>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
                                    <button id="register-submit" class="btn waves-effect waves-light amber accent-3" type="submit" name="register-action">Register
                                        <i class="material-icons right">send</i>
                                    </button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

