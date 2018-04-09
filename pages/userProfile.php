<?php

/* TODO:
- improve PDO
- mailgun
- form validation
- talk about the create profile thing in report
- get skills and show them on profile page/add them/remove them etc
*/


if(isset($_GET['username'])){
	$user = new User();
	if($user->checkUsername($_GET['username']) == false){
		$profile = $user->getProfile($_GET['username']);		
		// reference for age calculation: https://stackoverflow.com/questions/3776682/php-calculate-age
		$birthDate = $profile->dateOfBirth;
		//explode the date to get month, day and year
		$birthDate = explode("-", $birthDate);
		//get age from date or birthdate
		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
	}
	else{
	?>
		<h1>No user found with that username!</h1>
	<?
		return;
	}
}
else{
?>
	<h1>No user found with that username!</h1>
<?
	return;
}

?>
<section class="profile-head">
	<div class="row">
        <div class="col s12 cover-photo" <?php if(!empty($profile->coverPhoto)){?>style="background-image:url('user_images/<?=$profile->id?>_img/<?=$profile->coverPhoto?>')"<?php } ?>></div>
        <div class="container profile-user">
			<div class="row">
				<div class="profile-pic col s4">
					<div class="profile-pic-container z-depth-1">
					<img  <?php if(!empty($profile->profilePic)){?>src="user_images/<?=$profile->id?>_img/<?=$profile->profilePic?>"<?php } else { ?> src="img/default.jpg" <?php } ?> alt="profile-pic">
						</div>
				</div>
				<div class="profile-intro col l8 m8 s12 ">
					<h1 class="profile-name grey lighten-4 z-depth-1"><?= $profile->fName . ' ' . $profile->sName ?></h1>
					<p class="profile-quote"><?= (!empty($profile->intro)) ? $profile->intro : "Welcome to my profile page!" ?></p>
				</div>
				</div>
        </div>
    </div>
	</section>
	<section class="grey lighten-4 full-height profile-page">
		<div class="container">
            <div class="row">
                <div class="col l4 s12 ">
					<div class="card profile-info">
						<div class="card-content">
							<div>Occupation: <?= (!empty($profile->occupation)) ? $profile->occupation : "Undecided" ?></div>
							<div>Age: <?= (isset($_SESSION['userid'])) ? $age : "Login to see." ?></div>
							<div>Location: <?= (!empty($profile->location)) ? $profile->location : "Earth" ?></div>
							<div>Username: @<?= $profile->username ?></div>
							<div>LinkedIn: <?php if(!empty($profile->linkedin)){ ?><a href="<?= $profile->linkedin ?>">View Profile</a><?php } else { echo "Not given."; }?> </div>
						</div>
						<div class="card-action">
							<a class="waves-effect waves-light btn-large amber accent-3">Message</a>
						</div>
					</div>
                </div>
                <div class="col l8 m8 s12 profile-detail">
                    <h2>Description</h2>
                    <p><?= (!empty($profile->description)) ? $profile->description : "I am probably a real cool person, but I haven't written my description yet - d'oh!" ?></p>
                    <h2>Key Skills</h2>
                    <div class="chip">Web Development</div>
                    <div class="chip">Guitar</div>
                    <div class="chip">Blogging</div>
                    <div class="chip">Public Speaking</div>
                    <div class="chip">Creativity</div>					
					<h2>Recent Projects</h2>
					<div class="row">
						<div class="col s12 results">
							<div class="card project-card hoverable sticky-action left-align">
								<div class="cover-image grey lighten-3" style="background-image: url(https://www.headsetgo.online/ProjLogoG@0.5x.png)">
									<span class="project-capacity new badge amber" data-badge-caption="spaces">2</span>
									<a href="userProfile.html"><img class="z-depth-2" src="img/default.jpg"></a>
								</div>
								<div class="card-content activator">
									<p class="project-name activator">
										G.A.M.E.R. United
									</p>
								</div>
								<div class="card-reveal">
									<span class="card-title grey-text text-darken-4 project-name">G.A.M.E.R. United<small>by Bertie</small></span>
									<p class="project-desc">Contribute to the development of G.A.M.E.R. United - a side-scrolling RPG set in the future!</p>
									<div class="project-details">
										<div>
											<small>Members</small>
											<p>2/4</p>
										</div>
										<div>
											<small>Category</small>
											<p>Entertainment</p>
										</div>
										<div>
											<small>Start Date</small>
											<p>12/05/2018</p>
										</div>
									</div>
								</div>
								<div class="card-action right-align ">
									<a class="light-blue-text">More Info</a>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
	</section>