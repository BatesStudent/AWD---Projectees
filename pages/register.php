<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty(trim($_POST['fName'])) && !empty(trim($_POST['lName'])) && !empty(trim($_POST['uName'])) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) && !empty(trim($_POST['password'])) && !empty(trim($_POST['passwordConfirmation']))){
        if($_POST['password'] === $_POST['passwordConfirmation']){
            // register the user
            $user = new User();
            if($user->register($_POST['email'], trim($_POST['password']), trim($_POST['fName']), trim($_POST['lName']),trim($_POST['uName'])) == true){
                echo "<script>Materialize.toast('Successfully registered, you may now log in!',4000);</script>";
                require_once "pages/login.php";
            }
            else{
                echo "<script>Materialize.toast('Eek, we were unable to create your account!',4000);</script>";
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
					<form class="col l8 m10 s12 grey lighten-4 card" action="index.php?p=register" method="post">
						<div class="col s12">
							<div class="row">
								<div class="input-field col m6 s12">
                                     <i class="material-icons prefix">person</i>
									<input id="fName" type="text" class="validate" name="fName">
									<label for="fName">First Name *</label>
								</div>
								<div class="input-field col m6 s12">
									<input id="lName" type="text" class="validate" name="lName">
									<label for="lName">Last name *</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m6 s12">
							         <i class="material-icons prefix">email</i>
									<input id="uName" type="text" class="validate" name="uName">
									<label for="uName">Username *</label>
								</div>
								<div class="input-field col m6 s12">
									<input id="email" type="email" class="validate" name="email">
									<label for="email">Email *</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col l6 m6 s12">
                                    <i class="material-icons prefix">lock</i>
									<input id="password" type="password" class="validate" name="password">
									<label for="password">Password *</label>
								</div>
								<div class="input-field col l6 m6 s12">
									<input id="passwordConfirmation" type="password" name="passwordConfirmation">
									<label for="passwordConfirmation">Password Confirmation *</label>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
                                    <button id="register-submit" class="btn waves-effect waves-light amber accent-3" type="submit" name="action">Register
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

	<script>
		$(document).ready(function() {
			$('.datepicker').pickadate({
				selectMonths: true, // Creates a dropdown to control month
				selectYears: 15, // Creates a dropdown of 15 years to control year,
				today: 'Today',
				clear: 'Clear',
				close: 'Ok',
				closeOnSelect: false // Close upon selecting a date,
			});

		});
	</script>
</body>

</html>
