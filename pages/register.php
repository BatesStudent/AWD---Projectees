
	<section class="circle-bottom-section full-height center-align">
		<div class="container">
			<div>
				<div class="row introw">
					<h1>Join Projectees...</h1>
					<p>Already have an account? Well, what are you doing here then!? <a href="index.php?gp=login" class="light-blue-text">Log in here.</a></p>
				</div>
				<div class="row center-align">
					<form class="col l6 s12 grey lighten-4 card offset-l3">
						<div class="col s12 hide-on-med-and-down">
							<ul class="tabs tabs-fixed-width">
								<li class="tab "><a class="active" href="#tab1">Login Details</a></li>
								<li class="tab "><a href="#tab2">Profile Creation</a></li>
								<li class="tab"><a href="#tab3">Done and dusted</a></li>
							</ul>
						</div>
						<div id="tab1" class="col s12">
							<div class="row">
								<div class="input-field col m6 s12">
                                     <i class="material-icons prefix">person</i>
									<input id="fName" type="text" class="validate">
									<label for="fName">First Name</label>
								</div>
								<div class="input-field col m6 s12">
									<input id="lName" type="text" class="validate">
									<label for="lName">Last name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
                                    <i class="material-icons prefix">face</i>
									<input id="uName" type="text" class="validate">
									<label for="uName">Username</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
							         <i class="material-icons prefix">email</i>
									<input id="email" type="email" class="validate">
									<label for="email">Email</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col l6 m6 s12">
                                    <i class="material-icons prefix">lock</i>
									<input id="password" type="password" class="validate">
									<label for="password">Password</label>
								</div>
								<div class="input-field col l6 m6 s12">
                                    <i class="material-icons prefix">enhanced_encryption</i>
									<input id="passwordConfirmation" type="password" class="validate">
									<label for="passwordConfirmation">Password Confirmation</label>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<a id="toTab2" class="btn waves-effect waves-light amber accent-3">1/3<i class="material-icons right">send</i></a>
								</div>
							</div>
						</div>
						<div id="tab2" class="col s12">
							<div class="row">
								<div class="file-field input-field col s12">
									<div class="btn">
										<span>Profile Picture</span>
										<input type="file">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="file-field input-field col s12">
									<div class="btn">
										<span>Cover Picture</span>
										<input type="file">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="role" type="text" class="validate" placeholder="Web Developer">
									<label for="role">Occupation <small>(Don't have one? That's okay, what's your dream job?)</small></label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<textarea id="quote" class="materialize-textarea" data-length="140" placeholder="This will be the first thing people read on your profile page! Make it snappy!"></textarea>
									<label for="quote">Introductory quote</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<textarea id="pd" class="materialize-textarea" placeholder="You can go into as much or as little detail as you want here! Who are you, what makes you interesting, what are you looking for in a project?"></textarea>
									<label for="pd">Personal Description</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="dob" type="text" class="datepicker">
									<label for="dob">Date of Birth</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="linkedin" type="text" class="validate">
									<label for="linkedin">LinkedIn Profile</label>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<a id="toTab3" class="btn waves-effect waves-light amber accent-3">2/3<i class="material-icons right">send</i></a>
								</div>
							</div>
						</div>
						<div id="tab3" class="col s12">Test 2</div>
					</form>
				</div>
			</div>
		</div>
	</section>

	<script>
		$(document).ready(function() {
			$('ul.tabs').tabs();
			$('ul.tabs').tabs('select_tab', 'tab1');
			$('#toTab2').on('click', function() {
				$('ul.tabs').tabs('select_tab', 'tab2');
			});
			$('#toTab3').on('click', function() {
				$('ul.tabs').tabs('select_tab', 'tab3');
			});
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
