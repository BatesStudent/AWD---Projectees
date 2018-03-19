<?php
    if(!isset($user)){
        $user = new User($_SESSION['userid']);
    }
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
    }
    else{
        $profileDetails = $user->getProfile();        
    }
?>
<section>
<div class="container">
    
    <form method="post" action="index.php?p=createProfile">
<div class="row">
    <h1>Let's finish that profile...</h1>
    <p>Don't worry, you don't have to fill in all these fields (typing fatigue is a real thing) - just fill in as many as you can/want to. It's for your benefit as it means other people will know what you're all about!</p>
        <div class="file-field input-field col l6 s12">
            <div class="btn">
                <span>Profile Picture</span>
                <input type="file" name="profilePicture">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
        <div class="file-field input-field col l6 s12">
            <div class="btn">
                <span>Cover Picture</span>
                <input type="file" name="coverPicture">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col l6 s12">
            <input name="location" type="text" class="validate" placeholder="e.g. London, UK" <?php if(isset($profileDetails) && !empty($profileDetails->location)){ ?> value="<?php echo $profileDetails->location ?>" <?php } ?>>
            <label for="location">Location <small>(Be as specific as you like)</small></label>
        </div>
        <div class="input-field col l6 s12">
            <input name="dob" type="text" class="datepicker" placeholder="1996-04-22" <?php if(isset($profileDetails) && !empty($profileDetails->dateOfBirth)){ ?> value="<?php echo $profileDetails->dateOfBirth ?>" <?php } ?>>
            <label for="dob">Date of Birth</label>
        </div>
    </div>
        
    <div class="row">
        
        <div class="input-field col l6 s12">
            <input name="role" type="text" class="validate" placeholder="e.g. Web Developer, Violinist, Gardener, Olympic Gymnast" <?php if(isset($profileDetails) && !empty($profileDetails->occupation)){ ?> value="<?php echo $profileDetails->occupation ?>" <?php } ?>>
            <label for="role">Occupation <small>(Don't have one? That's okay, what's your dream job?)</small></label>
        </div>
        <div class="input-field col l6 s12">
            <input name="linkedin" type="text" class="validate" placeholder="https://www.linkedin.com/in/YOUR_LINK" <?php if(isset($profileDetails) && !empty($profileDetails->linkedin)){ ?> value="<?php echo $profileDetails->linkedin ?>" <?php } ?>>
            <label for="linkedin">LinkedIn Profile</label>
        </div>
    </div>
    <div class="row">
        
        <div class="input-field col s12">
            <textarea name="quote" class="materialize-textarea" data-length="140" placeholder="This will be the first thing people read on your profile page! Make it snappy!" ><?php if(isset($profileDetails) && !empty($profileDetails->intro)){ echo $profileDetails->intro;  } ?></textarea>
            <label for="quote">Introductory quote</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <textarea name="pd" class="materialize-textarea" placeholder="You can go into as much or as little detail as you want here! Who are you, what makes you interesting, what are you looking for in a project?" ><?php if(isset($profileDetails) && !empty($profileDetails->description)){  echo $profileDetails->description;  } ?></textarea>
            <label for="pd">Personal Description</label>
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
    </div>    
</section>