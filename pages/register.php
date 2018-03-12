<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty(trim($_POST['fName'])) && !empty(trim($_POST['lName'])) && !empty(trim($_POST['uName'])) && !empty(trim($_POST['email'])) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) && !empty(trim($_POST['password'])) && !empty(trim($_POST['passwordC']))){
            if($_POST['password'] === $_POST['passwordC']){
                // register the user
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
					<p>Already have an account? Well, what are you doing here then!? <a href="index.php?gp=login" class="light-blue-text">Log in here.</a></p>
				</div>
				<div class="row center-align">
                    <div class="col l2 m1 hide-on-small">
                    </div>
					<form class="col l8 m10 s12 grey lighten-4 card" action="index.php?gp=register" method="post">
						<div class="col s12">
							<div class="row">
								<div class="input-field col m6 s12">
                                     <i class="material-icons prefix">person</i>
									<input id="fName" type="text" class="validate">
									<label for="fName">First Name *</label>
								</div>
								<div class="input-field col m6 s12">
									<input id="lName" type="text" class="validate">
									<label for="lName">Last name *</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col m6 s12">
							         <i class="material-icons prefix">email</i>
									<input id="uName" type="text" class="validate">
									<label for="uName">Username *</label>
								</div>
								<div class="input-field col m6 s12">
									<input id="email" type="email" class="validate">
									<label for="email">Email *</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col l6 m6 s12">
                                    <i class="material-icons prefix">lock</i>
									<input id="password" type="password" class="validate">
									<label for="password">Password *</label>
								</div>
								<div class="input-field col l6 m6 s12">
									<input id="passwordConfirmation" type="password" class="validate">
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
