<?php
if(!isset($_SESSION['userid'])){
	echo "<script>window.location.assign('index.php?p=login');</script>";
	exit;
}

    $user = new User($_SESSION['userid']);
    $profileDetails = $user->getProfile();

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
                ?><script>Materialize.toast('<?=$error?>',4000);</script><?php
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
        $profileDetails = $user->getProfile();
    }
    else{
                
    }
?>
<section>
<div class="container">
    
    <form method="post" action="index.php?p=createProfile"  enctype="multipart/form-data">
<div class="row">
    <h1>Let's finish that profile...</h1>
    <p>Don't worry, you don't have to fill in all these fields (typing fatigue is a real thing) - just fill in as many as you can/want to. It's for your benefit as it means other people will know what you're all about!</p>
        <div class="file-field input-field col l6 s12 <?php if(isset($profileDetails) && empty($profileDetails->profilePic)){ echo "amber lighten-5"; } ?>">
            <div class="btn" <?php if(isset($profileDetails) && !empty($profileDetails->profilePic)){ echo 'disabled'; }?> >
                <span>Profile Picture</span>
                <input type="file" name="profilePicture" id="profilePicture" <?php if(isset($profileDetails) && !empty($profileDetails->profilePic)){ echo 'disabled style="opacity:0.2"'; } ?>>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
        <div class="file-field input-field col l6 s12 <?php if(isset($profileDetails) && empty($profileDetails->coverPhoto)){ echo "amber lighten-5"; } ?>">
            <div class="btn" <?php if(isset($profileDetails) && !empty($profileDetails->coverPhoto)){ echo 'disabled'; }?> >
                <span>Cover Picture</span>
                <input type="file" name="coverPicture" id="coverPicture" <?php if(isset($profileDetails) && !empty($profileDetails->coverPhoto)){ echo 'disabled style="opacity:0.2"'; } ?>>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col l6 s12 <?php if(isset($profileDetails) && empty($profileDetails->location)){ echo "amber lighten-5"; } ?>">
            <input name="location" type="text" class="validate " placeholder="e.g. London, UK" <?php if(isset($profileDetails) && !empty($profileDetails->location)){ ?> value="<?php echo $profileDetails->location ?>" <?php echo 'disabled style="opacity:0.2"'; } ?>>
            <label for="location">Location <small>(Be as specific as you like)</small></label>
        </div>
        <div class="input-field col l6 s12 <?php if(isset($profileDetails) && empty($profileDetails->dateOfBirth)){ echo "amber lighten-5"; } ?>">
            <input name="dob" type="text" class="datepicker" placeholder="1996-04-22" <?php if(isset($profileDetails) && !empty($profileDetails->dateOfBirth)){ ?> value="<?php echo $profileDetails->dateOfBirth ?>" <?php echo 'disabled style="opacity:0.2"'; } ?>>
            <label for="dob">Date of Birth</label>
        </div>
    </div>
        
    <div class="row">
        
        <div class="input-field col l6 s12 <?php if(isset($profileDetails) && empty($profileDetails->occupation)){ echo "amber lighten-5"; } ?>">
            <input name="role" type="text" class="validate" placeholder="e.g. Web Developer, Violinist, Gardener, Olympic Gymnast" <?php if(isset($profileDetails) && !empty($profileDetails->occupation)){ ?> value="<?php echo $profileDetails->occupation ?>" <?php echo 'disabled style="opacity:0.2"'; } ?>>
            <label for="role">Occupation <small>(Don't have one? That's okay, what's your dream job?)</small></label>
        </div>
        <div class="input-field col l6 s12 <?php if(isset($profileDetails) && empty($profileDetails->linkedin)){ echo "amber lighten-5"; } ?>">
            <input name="linkedin" type="text" class="validate" placeholder="https://www.linkedin.com/in/YOUR_LINK" <?php if(isset($profileDetails) && !empty($profileDetails->linkedin)){ ?> value="<?php echo $profileDetails->linkedin ?>" <?php echo 'disabled style="opacity:0.2"'; } ?>>
            <label for="linkedin">LinkedIn Profile</label>
        </div>
    </div>
    <div class="row <?php if(isset($profileDetails) && empty($profileDetails->intro)){ echo "amber lighten-5"; } ?>">
        
        <div class="input-field col s12">
            <textarea name="quote" class="materialize-textarea" data-length="140" placeholder="This will be the first thing people read on your profile page! Make it snappy!" <?php if(isset($profileDetails) && !empty($profileDetails->intro)){ echo 'disabled style="opacity:0.2"'; }?> ><?php if(isset($profileDetails) && !empty($profileDetails->intro)){ echo $profileDetails->intro;  } ?></textarea>
            <label for="quote">Introductory quote</label>
        </div>
    </div>
    <div class="row <?php if(isset($profileDetails) && empty($profileDetails->description)){ echo "amber lighten-5"; } ?>">
        <div class="input-field col s12 ">
            <textarea name="pd" class="materialize-textarea " placeholder="You can go into as much or as little detail as you want here! Who are you, what makes you interesting, what are you looking for in a project?" <?php if(isset($profileDetails) && !empty($profileDetails->description)){ echo 'disabled style="opacity:0.2"'; }?>><?php if(isset($profileDetails) && !empty($profileDetails->description)){  echo $profileDetails->description;  } ?></textarea>
            <label for="pd">Personal Description</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
          Add a skill:
          <div class="input-field inline">
            <input id="skills" type="text" class="validate" placeholder="e.g. Breakdancing">    
          </div>
            <a class="btn waves-effect waves-light">
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