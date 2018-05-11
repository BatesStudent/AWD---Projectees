<?php
if(!isset($_SESSION['userid'])){
	echo "<script>window.location.assign('index.php?p=login');</script>";
	exit;
}
if(isset($_POST['newproject-action'])){
	$coverPhoto = null;
	if($_FILES['coverPicture']['tmp_name']){
		//Let's add a random string of numbers to the start of the filename to make it unique!
		$newFilename = md5(uniqid(rand(), true)).$_FILES['coverPicture']["name"];
		$newDirName = './user_images/'.$_SESSION['userid'] . "_proj_img/";
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
		if ($_FILES["coverPicture"]["size"] > 5000000) {
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
				$coverPhoto = $newFilename;
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	else {
		"test";
	}
	$project = new Project();
	$result = $project->newProject($_POST['title'], $_SESSION['userid'], $_POST['short'], $_POST['categoryID'], $_POST['capacity'], $_POST['startDate'], ((isset($_POST['virtualOnly'])) ? 1 : 0), $coverPhoto, $_POST['long'], $_POST['lookingFor'], $_POST['endDate'], ((isset($_POST['inviteOnly'])) ? 1 : 0) );
	/*if($result !== false){
		echo "<script>window.location.assign('index.php?p=projectView&id=$result');</script>";
	} else {
		echo "<script>M.toast({html:'Project not created, is your input correct?'});</script>";
	}*/
}


// get catergories for category select drop-down
$db = new DB();
$db = $db->getPDO();
$categories = $db->query("SELECT * FROM catChoice");
$categories = $categories->fetchAll(PDO::FETCH_OBJ);
?>

<section class="full-height center-align">
	<div class="container">
		<div>
			<div class="row introw">
				<h1>Start a project...</h1>
				<p>Ooooh, isn't this exciting! Fill out a few details below (be as specific as you can) and you're on your way to completing that thing you've always thought about doing but just never got round to it. Until now!</p>
			</div>
			<div class="row center-align">
				<div class="col l2 m1 hide-on-small">
				</div>
				<form class="col l8 m10 s12 card" action="index.php?p=newProject" method="post" enctype="multipart/form-data">
					<ul class="tabs tabs-fixed-width">
						<li class="tab"><a class="active" href="#required-details">Required Details</a></li>
						<li class="tab"><a href="#optional-details">Optional Info<span class="hide-on-small-only"> (improves your listing)</span></a></li>
				  	</ul>
					<div id="required-details" class="col s12">
						<div class="row">
							<div class="input-field col s12">
								<input id="title" type="text" class="validate character-counter" name="title" placeholder="My Amazing Project Idea" required data-length="140">
								<label for="title">Title *</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea id="short" class="validate materialize-textarea character-counter" placeholder="Sell your idea in 140 characters or less..." name="short" data-length="140" required></textarea>
								<label for="short">Short Description *</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input id="capacity" type="number" max="99999" min="1" placeholder="6" class="validate" name="capacity" required>
								<label for="capacity">Capacity *</label>
								<span class="helper-text">How many people, EXCLUDING yourself, do you need to make this project work?</span>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input name="startDate" type="text" class="startdatepicker" placeholder="<?= date('Y-m-d') ?>" required>								
								<label for="startDate">Project Start date *</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<select required name="categoryID">
									<?php 
										$prevParent = false;
										foreach($categories as $cat){
											if($prevParent === false){
												echo '<optgroup label="'.$cat->parent.'">';
											}
											else if($cat->parent != $prevParent){
												echo '</optgroup><optgroup label="'.$cat->parent.'">';
											}
											echo '<option value="'.$cat->id.'">'.$cat->subCat.'</option>';
											$prevParent = $cat->parent;
										}
									   echo '</optgroup>';
									?>
								</select>
								<label>Category *</label>
						  	</div>
						</div>
						<div class="row">
							<div class="col s12">
								<button id="project-submit" class="btn waves-effect waves-light" type="submit" name="newproject-action">Create project
									<i class="material-icons right">send</i>
								</button>
							</div>
						</div>
					</div>
					<div id="optional-details" class="col s12">
						<div class="row">
							<p>These details are optional but we highly recommend filling them in to improve the quality of your project listing and the chances of it being found by the right people!</p>
							<div class="input-field col s12">
								<textarea id="long" class="materialize-textarea" name="long"></textarea>
								<label for="long">Long Description</label>
								<span class="helper-text">Go into as much detail as you want to describe your project. What is it about, what will you be doing, who's doing what, who will benefit from your project and how?</span>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea id="lookingFor" class="materialize-textarea" name="lookingFor" ></textarea>
								<label for="lookingFor">Who or what are you looking for?</label>
								<span class="helper-text">Tell fellow Projectees what your project needs: this might be specific role titles, skills or a general description of tasks that need completing.</span>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input name="endDate" type="text" class="enddatepicker" placeholder="<?= date('Y-m-d') ?>" >
								<label for="endDate">Project End date</label>
							</div>
						</div>
						<div class="row">
							<div class="file-field input-field col s12">							
								<div class="btn">
									<span>Cover Picture</span>
									<input type="file" name="coverPicture" id="coverPicture">									
								</div>
								<div class="file-path-wrapper">
									<input class="file-path validate" type="text">									
								</div>
							</div>
						</div>
						<div class="row">
							<div class="input-field col m6 s12">
								Virtual only?
								<div class="switch">
									<label>
									  No
									  <input type="checkbox" name="virtualOnly" value="0">
									  <span class="lever"></span>
									  Yes
									</label>
							  	</div>
							</div>							
							<div class="input-field col m6 s12">
								Invite only?
								<div class="switch">
									<label>
									  No
									  <input type="checkbox" name="inviteOnly" value="0">
									  <span class="lever"></span>
									  Yes
									</label>
							  	</div>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<button id="project-submit" class="btn waves-effect waves-light" type="submit" name="newproject-action">Create project
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