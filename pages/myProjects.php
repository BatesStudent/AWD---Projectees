<?php 
if(!isset($_SESSION['userid'])){
	echo "<script>window.location.assign('index.php?p=login');</script>";
	exit;
} else {
	$user = new User($_SESSION['userid']);
	// get the projects of this user
	$projects = $user->getProjects();
}
?>
<section>
	<div class="container">
		<div class="row">
			<h1>My Projects</h1>
			<div class="col s12 results">
				<?php 
				// display all the projects
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
						<a href="index.php?p=userProfile&username=<?=$project->username?>">
							<img class="z-depth-2" <?php if(!empty($project->profilePic)){?>src="user_images/<?=$project->ownerID?>_img/<?=$project->profilePic?>"<?php } else { ?> src="img/default.jpg" <?php } ?> alt="user profile image">
						</a>
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
					// no results;
					echo "<p>None started just yet! <a href='index.php?p=newProject'>Start one now!</a></p>";
				}
				?>
			</div>
		</div>
	</div>
</section>