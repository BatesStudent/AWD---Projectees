<?php
if(!isset($_SESSION['userid'])){
	echo "<script>window.location.assign('index.php?p=login');</script>";
	exit;
}

    $user = new User($_SESSION['userid']);
    $profileDetails = $user->getProfile(true);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){        
        if(isset($_POST['location']) && !empty($_POST['location'])){
            $user->setLocation($_POST['location']);
        }
        if(isset($_POST['dob']) && !empty($_POST['dob'])){
            $user->setDOB($_POST['dob']);
        }
        if(isset($_POST['linkedin']) && !empty($_POST['linkedin'])){
            $user->setLinkedIn($_POST['linkedin']);
        }
        if(isset($_POST['quote']) && !empty($_POST['quote'])){
            $user->setIntro($_POST['quote']);
        }
        if(isset($_POST['pd']) && !empty($_POST['pd'])){
            $user->setDescription($_POST['pd']);
        }
        if(isset($_POST['role']) && !empty($_POST['role'])){
            $user->setOccupation($_POST['role']);
        }
        //Upload Image Here
        if($_FILES['profilePicture']['tmp_name']){
            //Let's add a random string of numbers to the start of the filename to make it unique!
            $newFilename = md5(uniqid(rand(), true)).$_FILES['profilePicture']["name"];
            $newDirName = './user_images/'.$user->uid . "_img/";
            if(!file_exists($newDirName)){
                $newDir = mkdir($newDirName);
            }
            $target_file = $newDirName . basename($newFilename);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['profilePicture']["tmp_name"]);
            if($check === false) {
                $error = "File is not an image!";
            }

            //Check file already exists - It really, really shouldn't!
            if (file_exists($target_file)) {
                $error = "Sorry, file already exists.";
            }

            // Check file size
            if ($_FILES["profile_image"]["size"] > 500000) {
                $error = "Sorry, your file is too large.";
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }

            // Did we hit an error?
            if ($error) {
                echo $error;
            } else {
                //Save file
                if (move_uploaded_file($_FILES['profilePicture']["tmp_name"], $target_file)) {
                    // success
                    $user->setProfileImage($newFilename);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        if($_FILES['coverPicture']['tmp_name']){
            //Let's add a random string of numbers to the start of the filename to make it unique!

            $newFilename = md5(uniqid(rand(), true)).$_FILES['coverPicture']["name"];
            $newDirName = './user_images/'.$user->uid . "_img/";
            if(!file_exists($newDirName)){
                $newDir = mkdir($newDirName);
            }
            $target_file = $newDirName . basename($newFilename);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['coverPicture']["tmp_name"]);
            if($check === false) {
                $error = "File is not an image!";
            }

            //Check file already exists - It really, really shouldn't!
            if (file_exists($target_file)) {
                $error = "Sorry, file already exists.";
            }

            // Check file size
            if ($_FILES["coverPicture"]["size"] > 500000) {
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
                if (move_uploaded_file($_FILES['coverPicture']["tmp_name"], $target_file)) {
                    // success
                    $user->setCoverPhoto($newFilename);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        $user = new User($_SESSION['userid']);
        $profileDetails = $user->getProfile(true);
    }
?>
<section>
    <div class="container">    
        <form class="prevent-enter-submit" method="post" action="index.php?p=createProfile" enctype="multipart/form-data">
            <div class="row">
            <h1>Let's finish that profile...</h1>
            <p>Don't worry, you don't have to fill in all these fields (typing fatigue is a real thing, you know) - just fill in as many as you can/want to. It's for your benefit as it means other people will know what you're all about!</p>
			<?php if(isset($profileDetails) && empty($profileDetails->profilePic)){?>
				<div class="file-field input-field col l6 s12">
					<div class="btn" >
						<span>Profile Picture</span>
						<input type="file" name="profilePicture" id="profilePicture">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text">
					</div>
				</div>
			<?php }
            if(isset($profileDetails) && empty($profileDetails->coverPhoto)){ ?>
            <div class="file-field input-field col l6 s12">
                <div class="btn">
                    <span>Cover Picture</span>
                    <input type="file" name="coverPicture" id="coverPicture">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
			<?php } ?>
        </div>
        <div class="row">
			<?php if(isset($profileDetails) && empty($profileDetails->location)){ ?>
            <div class="input-field col l6 s12 ">
                <input name="location" type="text" class="validate " placeholder="e.g. London, UK">
                <label for="location">Location <small>(Be as specific as you like)</small></label>
            </div>
			<?php } 
			if(isset($profileDetails) && empty($profileDetails->dateOfBirth)){
			?>
            <div class="input-field col l6 s12">
                <input name="dob" type="text" class="birthdatepicker" placeholder="1996-04-22">
                <label for="dob">Date of Birth</label>				
            </div>
			<?php } ?>
        </div>
        
        <div class="row">
			<?php if(isset($profileDetails) && empty($profileDetails->occupation)){ ?>
            <div class="input-field col l6 s12">
                <input name="role" type="text" class="validate" placeholder="e.g. Web Developer, Violinist, Gardener, Olympic Gymnast">
                <label for="role">Occupation <small>(Don't have one? That's okay, what's your dream job?)</small></label>
            </div>
			<?php }
			if(isset($profileDetails) && empty($profileDetails->linkedin)){
			?>
            <div class="input-field col l6 s12">
                <input name="linkedin" type="text" class="validate" placeholder="https://www.linkedin.com/in/YOUR_LINK">
                <label for="linkedin">LinkedIn Profile</label>
            </div>			
			<?php } ?>
        </div>
		<?php if(isset($profileDetails) && empty($profileDetails->intro)){ ?>
        <div class="row">
            <div class="input-field col s12">
                <textarea name="quote" class="materialize-textarea character-counter" data-length="140" placeholder="This will be the first thing people read on your profile page! Make it snappy!" ></textarea>
                <label for="quote">Introductory quote</label>
            </div>
        </div>	
		<?php } if(isset($profileDetails) && empty($profileDetails->description)){ ?>
        <div class="row">
            <div class="input-field col s12 ">
                <textarea name="pd" class="materialize-textarea " placeholder="You can go into as much or as little detail as you want here! Who are you, what makes you interesting, what are you looking for in a project?"></textarea>
                <label for="pd">Personal Description</label>
            </div>
        </div>
		<?php } ?>
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
        <div class="row">
            <div class="col s12">
                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>            
            </div>
        </div>        
        </form>
        <div class="row">
            <div class="progress">
              <div class="determinate" style="width: <?= $user->profileCompletion(); ?>%"></div>
            </div>        
            <div>Profile completion: <?= $user->profileCompletion(); ?>%</div>
        </div>
    </div>    
</section>