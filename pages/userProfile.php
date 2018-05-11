<?php
// get the users profile
if(isset($_GET['username'])){
    if(isset($_SESSION['userid'])){
	   $user = new User($_SESSION['userid']);
    } else {
       $user = new User();
    }
    // check username exists
	if($user->checkUsername($_GET['username']) == false){
		if(isset($_SESSION['userid'])){
			$ownProfile = false;
			$editMode = false;
			if($user->username == $_GET['username']){
				// user is viewing their own profile
				$ownProfile = true;
				// get own profile and projects with all information
            	$profile = $user->getProfile(true);
				$projects = $user->getProjects();
				if($_GET['edit'] == "true"){
                    // user wants to edit profile
					$editMode = true;
                    if(isset($_POST['cover-upload-action'])){
                         if($_FILES['cover-photo']['tmp_name']){
                            //Let's add a random string of numbers to the start of the filename to make it unique!
                            $newFilename = md5(uniqid(rand(), true)).$_FILES['cover-photo']["name"];
                            $newDirName = './user_images/'.$user->uid . "_img/";
                            if(!file_exists($newDirName)){
                                $newDir = mkdir($newDirName);
                            }
                            $target_file = $newDirName . basename($newFilename);
                            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                            // Check if image file is a actual image or fake image
                            $check = getimagesize($_FILES['cover-photo']["tmp_name"]);
                            if($check === false) {
                                $error = "File is not an image!";
                            }

                            //Check file already exists - It really, really shouldn't!
                            if (file_exists($target_file)) {
                                $error = "Sorry, file already exists.";
                            }

                            // Check file size
                            if ($_FILES["cover-photo"]["size"] > 500000) {
                                $error = "Sorry, your file is too large.";
                            }

                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            }

                            // Did we hit an error?
                            if ($error) {
                                ?><script>M.toast({html:'<?=$error?>'});</script><?php
                            } else {
                                //Save file
                                if (move_uploaded_file($_FILES['cover-photo']["tmp_name"], $target_file)) {
                                    // success
                                    $user->setCoverPhoto($newFilename);
                                    $profile = $user->getProfile(true);
                                } else {
                                    echo "Sorry, there was an error uploading your file.";
                                }
                            }
                        }
                    }
                    if(isset($_POST['profile-upload-action'])){
                         if($_FILES['profile-photo']['tmp_name']){
                            //Let's add a random string of numbers to the start of the filename to make it unique!
                            $newFilename = md5(uniqid(rand(), true)).$_FILES['profile-photo']["name"];
                            $newDirName = './user_images/'.$user->uid . "_img/";
                            if(!file_exists($newDirName)){
                                $newDir = mkdir($newDirName);
                            }
                            $target_file = $newDirName . basename($newFilename);
                            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                            // Check if image file is a actual image or fake image
                            $check = getimagesize($_FILES['profile-photo']["tmp_name"]);
                            if($check === false) {
                                $error = "File is not an image!";
                            }

                            //Check file already exists - It really, really shouldn't!
                            if (file_exists($target_file)) {
                                $error = "Sorry, file already exists.";
                            }

                            // Check file size
                            if ($_FILES["profile-photo"]["size"] > 500000) {
                                $error = "Sorry, your file is too large.";
                            }

                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            }

                            // Did we hit an error?
                            if ($error) {
                                ?><script>M.toast({html:'<?=$error?>'});</script><?php
                            } else {
                                //Save file
                                if (move_uploaded_file($_FILES['profile-photo']["tmp_name"], $target_file)) {
                                    // success
                                    $user->setProfileImage($newFilename);
                                    $profile = $user->getProfile(true);
                                } else {
                                    echo "Sorry, there was an error uploading your file.";
                                }
                            }
                        }
                    }
				}
			} else {
				// we are NOT looking at own profile but we are logged in so get all information on user
				$profile = $user->getProfile(true, $_GET['username']);
				$viewedUser = new User($profile->id);
				$projects = $viewedUser->getProjects();
			}        
            // reference for age calculation: https://stackoverflow.com/questions/3776682/php-calculate-age
            $birthDate = $profile->dateOfBirth;            
            //explode the date to get month, day and year
			if(strlen($birthDate) > 1){
            	$birthDate = explode("-", $birthDate);			
            	//get age from date or birthdate
            	$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[0], $birthDate[1]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
			}
        } else {
			// not logged in so show limited profile information
            $profile = $user->getProfile(false, $_GET['username']);
			$projects = new User($profile->id);
			$projects = $projects->getProjects();
        }		
	}
	else{
		echo "<h1>No user found with that username!</h1>";
		return;
	}
}
else{
	echo "<h1>No username given!</h1>";
	return;
}

?>
<section class="profile-head">
	<div class="row">
        <div class="col s12 cover-photo" <?php if(!empty($profile->coverPhoto)){?>style="background-image:url('<?php if (strpos($profile->coverPhoto, 'unsplash.com') === false) { ?>user_images/<?=$profile->id?>_img/<?=$profile->coverPhoto?><?php } else { echo $profile->coverPhoto; } } ?>')">
            <?php if($editMode){ ?>
            <div class="row cover-photo-buttons">
                <a class="btn waves-effect waves-light upload-pic tooltipped modal-trigger" data-target="upload-chooser" data-position="top" data-tooltip="Upload.">
                    <i class="material-icons">file_upload</i>
                </a>
                <a class="btn waves-effect waves-light choose-unplash-pic tooltipped modal-trigger" data-target="unsplash-chooser" data-position="top" data-tooltip="Choose stock photo.">
                    <i class="material-icons">filter</i>
                </a>
            </div>
            <div id="upload-chooser" class="modal">
                <div class="modal-content">
                    <h4>Upload an image:</h4>
                    <form id="cover-upload" method="post" enctype="multipart/form-data">
                        <div class="file-field input-field">
                          <div class="btn">
                            <span>File</span>
                            <input type="file" name="cover-photo">
                          </div>
                          <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                          </div>
                        </div>
                        <button class="modal-close waves-effect btn-flat" type="submit" name="cover-upload-action">Save</button>
                    </form>
                </div>
            </div>
            <div id="unsplash-chooser" class="modal">
                <div class="modal-content">
                    <h4>Choose a stock image: <small>(click to choose)</small></h4>
                    <div class="slider">
                        <ul class="slides unsplash-images">
                            
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="modal-close waves-effect btn-flat">Close</a>
                </div>
            </div>
            <?php } ?>
        </div>
             
        <div class="container profile-user">
			<div class="row">
				<div class="profile-pic col l4 m12 s12">
					<div class="profile-pic-container z-depth-1">
					   <img <?php if(!empty($profile->profilePic)){?>src="user_images/<?=$profile->id?>_img/<?=$profile->profilePic?>"<?php } else { ?> src="img/default.jpg" <?php } ?> alt="profile-pic">
                        
                    </div>
                    <?php if($editMode){ ?>
                    <a class="btn waves-effect waves-light upload-pic tooltipped modal-trigger" data-target="upload-chooser-profile" data-position="top" data-tooltip="Upload">
                        <i class="material-icons">file_upload</i>
                    </a>
                    <div id="upload-chooser-profile" class="modal">
                        <div class="modal-content">
                            <h4>Upload an image:</h4>
                            <form id="profile-upload" method="post" enctype="multipart/form-data">
                                <div class="file-field input-field">
                                  <div class="btn">
                                    <span>File</span>
                                    <input type="file" name="profile-photo">
                                  </div>
                                  <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                  </div>
                                </div>
                                <button class="modal-close waves-effect btn-flat" type="submit" name="profile-upload-action">Save</button>
                            </form>
                        </div>
                    </div>
                    <? } ?>
				</div>
				<div class="profile-intro col l8 m12 s12 ">
					<h1 class="profile-name grey lighten-4 z-depth-1"><?= $profile->fName . ' ' . $profile->sName ?></h1>
                    <?php if($editMode){ ?>
                    <div class="input-field">
				        <textarea class="profile-quote materialize-textarea character-counter" data-length="140"><?= (!empty($profile->intro)) ? trim($profile->intro) : "Welcome to my profile page!" ?></textarea>
                        <label for="profile-quote">Intro quote</label>
                    </div>
                     <a class="btn waves-effect waves-light save-quote">
                        <i class="material-icons">check</i>
                    </a>
                    <?php } else { ?>
                    <p class="profile-quote"><?= (!empty($profile->intro)) ? $profile->intro : "Welcome to my profile page!" ?></p>
                    <?php } ?>
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
							<div>Occupation:
                                <?php if($editMode){ ?>
                                <div class="input-field inline">
                                    <input id="occupation-edit" type="text" class="validate" value="<?=(!empty($profile->occupation)) ? $profile->occupation : "Undecided"?>">
                                    <a class="btn waves-effect waves-light save-occupation right">
                                        <i class="material-icons">check</i>
                                    </a>
                                </div>
                                <?php } else { 
                                    echo (!empty($profile->occupation)) ? $profile->occupation : "Undecided";
                                } ?>
                            </div>
							<div>Age: <?= (isset($_SESSION['userid'])) ? ((isset($age)) ? $age : "Not given") : "Login to see." ?></div>
							<div>Location: 
                                <?php if($editMode){ ?>
                                <div class="input-field inline">
                                    <input id="location-edit" type="text" class="validate" value="<?=(!empty($profile->location)) ? $profile->location : "Earth...probably?"?>">
                                    <a class="btn waves-effect waves-light save-location right">
                                        <i class="material-icons">check</i>
                                    </a>
                                </div>
                                <?php } else { 
                                    echo (!empty($profile->location)) ? $profile->location : "Earth...probably?";
                                } ?>
                            </div>
							<div>Username: @<?= $profile->username ?></div>
							<div>LinkedIn: <?php if(!empty($profile->linkedin) && isset($_SESSION['userid'])){ ?><a href="<?= $profile->linkedin ?>">View Profile</a><?php } else { echo "Not given"; }?> </div>
						</div>
						<?php if(!$ownProfile && isset($_SESSION['userid'])){ ?>
						<div class="card-action right-aligned">
							<a class="waves-effect waves-light btn-large amber accent-3 invite-button" data-id="<?=$profile->id?>">Invite to apply</a>
						</div>
						<?php } ?>
					</div>
                </div>
                <div class="col l8 m12 s12 profile-detail">
                    <h2>Description</h2>                    
                    <?php if($editMode){ ?>
                    <div class="input-field">
                         <textarea class="edit-description materialize-textarea" name="edit-description"><?= (!empty($profile->description)) ? $profile->description : "I am probably a real cool person, but I haven't written my description yet - d'oh!" ?></textarea>
                        <label for="edit-description">Description (long)</label>
                    </div>
                    <a class="btn waves-effect waves-light save-description right">
                        <i class="material-icons">check</i>
                    </a>  
                    <?php } else {?>
                    <p class="justify-left"><?= (!empty($profile->description)) ? $profile->description : "I am probably a real cool person, but I haven't written my description yet - d'oh!" ?></p>
                    <?php } ?>
                    <h2>Key Skills</h2>
					<div class="skill-chips">
					<?php 
						if(sizeof($profile->skillList) > 0){
							foreach(explode(',', $profile->skillList) as $skill){ 
							if($editMode){
								?>
							<div class="chip" data-skill-name="<?= $skill ?>"><?= $skill ?><i class="material-icons right removeSkill">clear</i></div>
							<?php
							} else {
								?>
								<a href="index.php?p=search&search=<?= $skill ?>" class="chip"><?= $skill ?></a>
							<?php
							}
						} 
						} else { echo "<p>None right now!</p>";} ?>
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
			
					<h2 id="projects">Recent Projects</h2>
					<div class="row">
						<div class="col s12 results">
							<?php 
							if(sizeof($projects) > 0){
								foreach($projects as $p){
									$project = new Project();
									$project = $project->getCardDetails($p->id);
								?>
							
							<div class="card project-card hoverable sticky-action left-align">
								<div class="cover-image grey lighten-3" <?php if(!empty($project->coverPhoto)){?>style="background-image:url('<?php if (strpos($project->coverPhoto, 'unsplash.com') === false) { ?>user_images/<?=$project->ownerID?>_proj_img/<?=$project->coverPhoto?><?php } else { echo $project->coverPhoto; }?>')"<?php } ?>>
									<span class="project-capacity new badge amber" data-badge-caption="spaces">
										<?= $project->capacity - $project->currentMembers ?>
									</span>
									<a href="index.php?p=userProfile&username=<?=$project->username?>"><img class="z-depth-2" <?php if(!empty($project->profilePic)){?>src="user_images/<?=$project->ownerID?>_img/<?=$project->profilePic?>"<?php } else { ?> src="img/default.jpg" <?php } ?> alt="user profile image"></a>
								</div>
								<div class="card-content activator">
									<p class="project-name activator">
										<?= $project->title ?>
										<i class="material-icons right">more_vert</i>
									</p>
								</div>
								<div class="card-reveal">
									<span class="card-title grey-text text-darken-4 project-name"><?= $project->title ?><small>by <?= $project->fName . ' ' . $project->sName ?></small></span>
									<p class="project-desc"><?= $project->shortDescription ?></p>
									<div class="project-details">
										<div>
											<small>Members</small>
											<p><?= $project->currentMembers ?>/<?= $project->capacity ?></p>
										</div>
										<div>
											<small>Category</small>
											<p><?= $project->category ?></p>
										</div>
										<div>
											<small>Start Date</small>
											<p><?= $project->startDate ?></p>
										</div>
									</div>
								</div>
								<div class="card-action right-align ">
									<a href="index.php?p=projectView&id=<?=$project->id?>" class="light-blue-text">More Info</a>
								</div>
							</div>
							<?php
								}
							} else {
								echo "<p>None started just yet!</p>";
							}
							?>
						</div>
					</div>
                </div>
            </div>
        </div>
	</section>
<?php if($ownProfile && !$editMode){
	// user is viewing their own profile but not editing, so show the edit mode button
	?>
<div class="fixed-action-btn">
 	<a href="?p=userProfile&username=<?=$user->username?>&edit=true" id="edit-tap" class="btn-floating btn-large amber darken-1 tooltipped" data-position="top" data-tooltip="Click to edit profile.">
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
	// user is in editmode so show the end edit button
	?>
<div class="fixed-action-btn">
 	<a href="?p=userProfile&username=<?=$user->username?>" id="edit-end-tap" class="btn-floating btn-large light-green darken-1 tooltipped" data-position="top" data-tooltip="Click to exit edit mode.">
		<i class="large material-icons">check</i>
  	</a>
</div>
<?php
} ?>