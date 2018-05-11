<?php


// get a users profile
if(isset($_GET['id'])){	
	$project = new Project();
	$projectProfile = $project->getProfile($_GET['id']);
	$members = $project->getMembers($_GET['id']);
	array_push($members, $projectProfile->ownerID);
    if(isset($_SESSION['userid'])){
	   	$user = new User($_SESSION['userid']);
		if($projectProfile !== false && $members !== false){
			$ownProject = false;
			$projectMember = false;
			$editMode = false;			
			if($projectProfile->ownerID == $user->uid){
				$applications = $project->getApplications($projectProfile->id);
				$ownProject = true;
				if($_GET['edit'] == "true"){
					$editMode = true;
					if(isset($_POST['cover-upload-action'])){
                         if($_FILES['cover-photo']['tmp_name']){
                            //Let's add a random string of numbers to the start of the filename to make it unique!
                            $newFilename = md5(uniqid(rand(), true)).$_FILES['cover-photo']["name"];
                            $newDirName = './user_images/'.$user->uid . "_proj_img/";
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
                            if ($_FILES["cover-photo"]["size"] > 5000000) {
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
                                    $project->setCoverPhoto($newFilename, $_GET['id']);
                                    $projectProfile = $project->getProfile($_GET['id']);
                                } else {
                                    echo "Sorry, there was an error uploading your file.";
                                }
                            }
                        }
                    }
				}
			} else if(in_array($user->uid, $members)){
				$projectMember = true;
			}
		} else {
			echo "<section><h1>Project not found!</h1></section>";
			return;
		}
	}
}
else{
	echo "<section><h1>No project to view!</h1></section>";
	return;
}

?>
<section class="project-head">
	<div class="row">
        <div class="col s12 cover-photo" <?php if(!empty($projectProfile->coverPhoto)){?>style="background-image:url('<?php if (strpos($projectProfile->coverPhoto, 'unsplash.com') === false) { ?>user_images/<?=$projectProfile->ownerID?>_proj_img/<?=$projectProfile->coverPhoto?><?php } else { echo $projectProfile->coverPhoto; } } ?>')">
            <?php if($editMode){ ?>
            <div class="row cover-photo-buttons">
                <a class="btn waves-effect waves-light upload-pic tooltipped modal-trigger" data-target="upload-chooser" data-position="top" data-tooltip="Upload.">
                    <i class="material-icons">file_upload</i>
                </a>
                <a class="btn waves-effect waves-light choose-unplash-pic-project tooltipped modal-trigger" data-target="unsplash-chooser" data-position="top" data-tooltip="Choose stock photo.">
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
                        <ul class="slides unsplash-images" data-project="<?=$projectProfile->id?>">
                            
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="modal-close waves-effect btn-flat">Close</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
	</section>
	<section class="grey lighten-4 full-height project-page">
		<div class="container">
            <div class="row">
                <div class="col l4 s12 ">
					<?php 
						if(sizeof($applications) > 0){
							echo "<h4>New Applications:</h4><ul>";
							foreach($applications as $a){
								$appUser = new User($a->userID);
								?>
								<li class="application"><a href="index.php?p=userProfile&username=<?=$appUser->username?>"><?=$appUser->name?></a><i class="material-icons right" data-user-id="<?=$appUser->uid?>" data-value="1" data-project-id="<?=$a->projectID?>">check</i><i class="material-icons right" data-user-id="<?=$appUser->uid?>" data-value="-1" data-project-id="<?=$a->projectID?>">close</i></li>
								<?php
							}
							echo "</ul>";
						}
					?>
					<div class="card profile-info">
						<div class="card-content">
							<div>Capacity: <?= $projectProfile->capacity ?></div>
							<div>Members: <?= sizeof($members) ?></div>
							<div>Start Date: <?= $projectProfile->startDate ?></div>
							<div>End Date:
                                <?php if($editMode){ ?>
                                <div class="input-field inline">
                                    <input id="endDate-edit" type="date" class="validate" value="<?=(!empty($projectProfile->targetCompletionDate)) ? $projectProfile->targetCompletionDate : "None"?>">
                                    <a class="btn waves-effect waves-light save-endDate right" data-project="<?=$projectProfile->id?>">
                                        <i class="material-icons">check</i>
                                    </a>
                                </div>
                                <?php } else { 
                                    echo (!empty($projectProfile->targetCompletionDate)) ? $projectProfile->targetCompletionDate : "No deadline.";
                                } ?>
                            </div>
							<div>Category: <?= $projectProfile->category ?>
                            </div>
							<div>Virtual Only: <?= ($projectProfile->virtual > 0) ? "Yes" : "No" ?></div>
							<div>Invite Only: <?= ($projectProfile->inviteOnly > 0) ? "Yes" : "No" ?></div>
						</div>
						<?php if($projectProfile->inviteOnly == 0 && sizeof($members) < $projectProfile->capacity && !$ownProject && !$projectMember){ ?>
						<div class="card-action">
							<a class="waves-effect waves-light btn-large amber accent-3 apply-button" data-id="<?=$projectProfile->id?>">Apply to join</a>
						</div>
						<?php } ?>
					</div>
                </div>
                <div class="col l8 m8 s12 profile-detail">
					<h1 class="project-title z-depth-1 grey lighten-4"><?= $projectProfile->title ?><small>by <?php $projectAuthor = new User($projectProfile->ownerID); echo $projectAuthor->name; ?></small></h1>                
                    <?php if($editMode){ ?>
                    <div class="input-field">
					 	<textarea class="edit-short materialize-textarea character-counter" name="edit-short" data-length="140"><?= $projectProfile->shortDescription ?></textarea>
                        <label for="edit-short">Short description</label>
                    </div>
                    <a class="btn waves-effect waves-light save-short right" data-project="<?=$projectProfile->id?>">
                        <i class="material-icons">check</i>
                    </a>  
                    <?php } else {?>
                    <p class="justify-left"><?= $projectProfile->shortDescription ?></p>
                    <?php } ?>
                    <h2>Description</h2>                    
                    <?php if($editMode){ ?>
                    <div class="input-field">
                         <textarea class="edit-long materialize-textarea" name="edit-long"><?= (!empty($projectProfile->longDescription)) ? $projectProfile->longDescription : "None provided." ?></textarea>
                        <label for="edit-long">Description (long)</label>
                    </div>
                    <a class="btn waves-effect waves-light save-long right" data-project="<?=$projectProfile->id?>">
                        <i class="material-icons">check</i>
                    </a>  
                    <?php } else {?>
                    <p class="justify-left"><?= (!empty($projectProfile->longDescription)) ? $projectProfile->longDescription : "None provided." ?></p>
                    <?php } ?>
					
                    <h2>Looking for</h2>                    
                    <?php if($editMode){ ?>
                    <div class="input-field">
                         <textarea class="edit-lookingFor materialize-textarea" name="edit-lookingFor"><?= (!empty($projectProfile->lookingFor)) ? $projectProfile->lookingFor : "None provided." ?></textarea>
                        <label for="edit-lookingFor">Looking for</label>
                    </div>
                    <a class="btn waves-effect waves-light save-lookingFor right" data-project="<?=$projectProfile->id?>">
                        <i class="material-icons">check</i>
                    </a>  
                    <?php } else {?>
                    <p class="justify-left"><?= (!empty($projectProfile->lookingFor)) ? $projectProfile->lookingFor : "None provided." ?></p>
                    <?php } ?>
			
					<h2>Team Members</h2>
					<div class="row">
						<div class="col s12 results">
						<?php foreach($members as $m){
							$user = new User($m);
						?>
						<div class="card user-card center-align">
							<div class="cover-image grey lighten-3" <?php if(!empty($user->coverPhoto)){?>style="background-image:url('<?php if (strpos($user->coverPhoto, 'unsplash.com') === false) { ?>user_images/<?=$user->uid?>_img/<?=$user->coverPhoto?><?php } else { echo $user->coverPhoto; } } ?>')">
							</div>
							<div class="avatar-image z-depth-2">
								<a href="index.php?p=userProfile&username=<?=$user->username?>">
									<img <?php if(!empty($user->profilePic)){?>src="user_images/<?=$user->uid?>_img/<?=$user->profilePic?>"<?php } else { ?> src="img/default.jpg" <?php } ?> alt="profile pic">
								</a>
							</div>
							<div class="card-content">
								<p class="user-name"><?= $user->name ?>
								</p>
								<p class="user-role"><?= $user->occupation ?></p>
							</div>
							<div class="card-action right-align">
								<a href="index.php?p=userProfile&username=<?=$user->username?>" class="light-blue-text">View Profile</a>
							</div>
						</div>	
						<?php } ?>
						</div>
					</div>
                </div>
            </div>
        </div>
	</section>
<?php if($ownProject && !$editMode){
	?>
<div class="fixed-action-btn">
 	<a href="?p=projectView&id=<?=$projectProfile->id?>&edit=true" id="edit-tap" class="btn-floating btn-large amber darken-1 tooltipped" data-position="top" data-tooltip="Click to edit project.">
		<i class="large material-icons">mode_edit</i>
  	</a>
</div>
	<?php
} else if($editMode){
	?>
<div class="fixed-action-btn">
 	<a href="?p=projectView&id=<?=$projectProfile->id?>" id="edit-end-tap" class="btn-floating btn-large light-green darken-1 tooltipped" data-position="top" data-tooltip="Click to exit edit mode.">
		<i class="large material-icons">check</i>
  	</a>
</div>
<?php
} ?>