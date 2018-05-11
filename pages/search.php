<?php

$target = ((isset($_GET['target'])) ? $_GET['target'] : "both");
$search = ((isset($_POST['search'])) ? trim(strip_tags($_POST['search'])) : ((isset($_GET['search'])) ? trim(strip_tags($_GET['search'])) : false));   
$error = false;
if($search !== false){
    // we have something to search
    if($target == "both"){
        // search projects AND users
        $db = new DB();
		$db = $db->getPDO();
        $stmtU = $db->prepare("SELECT id, CONCAT_WS(' ', fName, sName) AS name, occupation, profilePic, username, coverPhoto FROM userProfile_limited WHERE CONCAT_WS('',fName, sName, occupation, username, skillList) LIKE :search LIMIT 8");
		$search = "%".trim($search)."%";
        $stmtU->bindParam(':search', $search);
        try{
            $stmtU->execute();
            $userResults = $stmtU->fetchAll(PDO::FETCH_OBJ);
            // now get projects
            $stmtP = $db->prepare("SELECT id FROM Projects WHERE CONCAT_WS('',title, lookingFor, shortDescription) LIKE ? LIMIT 6");
            $stmtP->bindParam(1, $search);
			$stmtP->execute();
			$projectResults = $stmtP->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e){
            $error = "Eek! Server issue! Please report this to an administrator.";            
        }
    } else if($target == "u"){
        // search users
        $db = new DB();
		$db = $db->getPDO();
        $stmtU = $db->prepare("SELECT id, CONCAT_WS(' ', fName, sName) AS name, occupation, profilePic, username, coverPhoto FROM userProfile_limited WHERE CONCAT_WS('',fName, sName, occupation, username, skillList) LIKE ? LIMIT 12");
        $uSearch = "%".trim($search)."%";
        $stmtU->bindParam(1, $uSearch);
        try{
            $stmtU->execute();
            $userResults = $stmtU->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e){
            $error = "Eek! Server issue! Please report this to an administrator.";
        }
    } else if($target == "p"){
        // search projects
        $db = new DB();
		$db = $db->getPDO();
        $stmtP = $db->prepare("SELECT id FROM Projects WHERE CONCAT_WS('',title, lookingFor, shortDescription) LIKE :search LIMIT 6");		
        $pSearch = "%".trim($search)."%";
		$stmtP->bindParam(':search', $pSearch);
        try{
            $stmtP->execute();
            $projectResults = $stmtP->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e){
            $error = "Eek! Server issue! Please report this to an administrator.";
        }
    }
} else {
	if($target == "both"){
        // search projects AND users
        $db = new DB();
		$db = $db->getPDO();        
        try{
            $stmtU = $db->query("SELECT id, CONCAT_WS(' ', fName, sName) AS name, occupation, profilePic, username, coverPhoto FROM userProfile_limited ORDER BY id DESC LIMIT 8");
            $userResults = $stmtU->fetchAll(PDO::FETCH_OBJ);
            // now get projects
            $stmtP = $db->query("SELECT id FROM Projects ORDER BY creationDate DESC LIMIT 6");
			$projectResults = $stmtP->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e){
            $error = "Eek! Server issue! Please report this to an administrator.";            
        }
    } else if($target == "u"){
        // search users
        $db = new DB();
		$db = $db->getPDO();
		try{
            $stmtU = $db->query("SELECT id, CONCAT_WS(' ', fName, sName) AS name, occupation, profilePic, username, coverPhoto FROM userProfile_limited ORDER BY id DESC LIMIT 12");
            $userResults = $stmtU->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e){
            $error = "Eek! Server issue! Please report this to an administrator.";
        }
    } else if($target == "p"){
		  // No query has been entered so show the most recent projects
		$db = new DB();
		$db = $db->getPDO();
		try{
			$stmtP = $db->query("SELECT id FROM Projects ORDER BY creationDate DESC LIMIT 6");
			$projectResults = $stmtP->fetchAll(PDO::FETCH_OBJ);
		} catch(Exception $e){
			$error = "Eek! Server issue! Please report this to an administrator.";
		}
    }	
}

?>
<section>
	<div class="container">
		<?php
		$user = new User($_SESSION['userid']);
        if($user->profileCompletion() < 40){
            echo "<script>window.location.assign('index.php?p=createProfile');</script>";
            exit;
        }
        else if($user->profileCompletion() < 100){
            ?>
		<div class="row">
        <div class="progress">
            <div class="determinate" style="width: <?= $user->profileCompletion(); ?>%"></div>
        </div>        
        <div>Profile completion: <?= $user->profileCompletion(); ?>% <a href='index.php?p=createProfile'>You're missing parts of your profile! Fill them in to help people find you!</a></div>
		</div>
<?php
        } ?>
		<div class="row introw">
			<div class="col s12">
				<?php if($search !== false){ ?>
				<h1>Search results - "<?=str_replace("%","",$search)?>"</h1>				
				<?php } if($error !== false){
					echo "<p>$error</p>";
				} else { 
					if(sizeof($userResults) > 0){
						echo "<h2>Users</h2>";
						echo "<div class='results'>";
						foreach($userResults as $user){
							?>
							<div class="card user-card center-align">
								<div class="cover-image grey lighten-3" <?php if(!empty($user->coverPhoto)){?>style="background-image:url('<?php if (strpos($user->coverPhoto, 'unsplash.com') === false) { ?>user_images/<?=$user->id?>_img/<?=$user->coverPhoto?><?php } else { echo $user->coverPhoto; } } ?>')">

								</div>
								<div class="avatar-image z-depth-2">
									<a href="index.php?p=userProfile&username=<?=$user->username?>">
										<img <?php if(!empty($user->profilePic)){?>src="user_images/<?=$user->id?>_img/<?=$user->profilePic?>"<?php } else { ?> src="img/default.jpg" <?php } ?> alt="profile pic">
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
							<?php
						}
						echo "</div>";
					}
					if(sizeof($projectResults) > 0){
						echo "<h2>Projects</h2>";
						echo "<div class='results'>";
						foreach($projectResults as $project){
							$p = new Project();
							$project = $p->getCardDetails($project->id);
							?>
				
							<div class="card project-card hoverable sticky-action left-align">
								<div class="cover-image grey lighten-3" <?php if(!empty($project->coverPhoto)){?>style="background-image:url('<?php if (strpos($project->coverPhoto, 'unsplash.com') === false) { ?>user_images/<?=$project->ownerID?>_proj_img/<?=$project->coverPhoto?><?php } else { echo $project->coverPhoto; }?>')"<?php } ?>>
									<span class="project-capacity new badge amber" data-badge-caption="spaces">
										<?= $project->capacity - $project->currentMembers ?>
									</span>
									<a href="index.php?p=userProfile&username=<?=$project->username?>"><img class="z-depth-2" <?php if(!empty($project->profilePic)){?>src="user_images/<?=$project->ownerID?>_img/<?=$project->profilePic?>"<?php } else { ?> src="img/default.jpg" <?php } ?>></a>
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
						echo "</div>";
					}
				} ?>
			</div>
		</div>
	</div>
</section>