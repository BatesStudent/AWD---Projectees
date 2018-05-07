<?php

/* TODO:
- improve PDO
- mailgun
- form validation
- talk about the create profile thing in report
- get skills and show them on profile page/add them/remove them etc
*/


if(isset($_GET['username'])){
    if(isset($_SESSION['userid'])){
	   $user = new User($_SESSION['userid']);
    } else {
        $user = new User();
    }
	if($user->checkUsername($_GET['username']) == false){
        if(isset($_SESSION['userid'])){
<<<<<<< HEAD
			$ownProfile = false;
			$editMode = false;
			if($user->uName == $_GET['username']){
				// user is viewing their own profile
				$ownProfile = true;
            	$profile = $user->getProfile(true);
				if($_GET['edit'] == "true"){
					$editMode = true;
				}
			} else {
				$profile = $user->getProfile(true, $_GET['username']);
			}
=======
            $profile = $user->getProfile(true, $_GET['username']);
>>>>>>> 2517351fcc9d4fcbe9e67390baae894662ee8972
            // reference for age calculation: https://stackoverflow.com/questions/3776682/php-calculate-age
            $birthDate = $profile->dateOfBirth;            
            //explode the date to get month, day and year
            $birthDate = explode("-", $birthDate);
            //get age from date or birthdate
            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
        } else {
            $profile = $user->getProfile(false, $_GET['username']);
        }		
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
	<h1>No username given!</h1>
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
							<div>Location: <?= (!empty($profile->location)) ? $profile->location : "Earth...probably." ?></div>
							<div>Username: @<?= $profile->username ?></div>
							<div>LinkedIn: <?php if(!empty($profile->linkedin) && isset($_SESSION['userid'])){ ?><a href="<?= $profile->linkedin ?>">View Profile</a><?php } else { echo "Login to see."; }?> </div>
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
<<<<<<< HEAD
					<div class="skill-chips">
					<?php foreach(explode(',', $profile->skillList) as $skill){ 
						if($editMode){
							?>
						<div class="chip" data-skill-name="<?= $skill ?>"><?= $skill ?><i class="material-icons right removeSkill">clear</i></div>
						<?php
						} else {
							?>
							<a href="index.php?search=users&query=<?= $skill ?>" class="chip"><?= $skill ?></a>
						<?php
						}
					} ?>
					</div>
					<?php
						if($editMode){
							?>
								<div class="row">
									<div class="col s12">
									  Add a skill:
									  <div class="input-field inline">
										  <input id="skills" type="text" class="validate" placeholder="e.g. Breakdancing">    
									  </div>
										<a class="btn waves-effect waves-light" id="skill-add">
											<i class="material-icons">check</i>
										</a>  
									</div>
								</div>
							<?php
						}
					?>
					
=======
                        <?php foreach(explode(',', $profile->skillList) as $skill){ ?> <div class="chip"><?= $skill ?></div> <?php } ?>
>>>>>>> 2517351fcc9d4fcbe9e67390baae894662ee8972
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
<?php if($ownProfile && !$editMode){
	?>
<div class="fixed-action-btn">
 	<a href="?p=userProfile&username=<?=$user->uName?>&edit=true" id="edit-tap" class="btn-floating btn-large amber darken-1 tooltipped" data-position="top" data-tooltip="Click to edit profile.">
		<i class="large material-icons">mode_edit</i>
  	</a>
</div>
<div class="tap-target amber darken-1" data-target="edit-tap">
    <div class="tap-target-content white-text ">
    	<h5>Edit profile</h5>
      	<p>Make changes to your profile at any time by clicking the edit icon!</p>
    </div>
</div>
<script>
	$(document).ready(function(){
		$('.tap-target').tapTarget();
		$('.tap-target').tapTarget('open');
		setTimeout(function(){ $('.tap-target').tapTarget('close'); }, 2500);		
	});
</script>
	<?php
} else if($editMode){
	?>
<div class="fixed-action-btn">
 	<a href="?p=userProfile&username=<?=$user->uName?>" id="edit-end-tap" class="btn-floating btn-large light-green darken-1 tooltipped" data-position="top" data-tooltip="Click to exit edit mode.">
		<i class="large material-icons">check</i>
  	</a>
</div>
<?php
} ?>