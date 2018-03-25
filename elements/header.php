<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Projectees |
		<?= $getTitle?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css'>
	<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
	<link rel="stylesheet" href="scss/style.css">
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js'></script>
	<link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
</head>


<?php if(!isset($_SESSION['userid'])){
	?>

<body class="grey lighten-4">
	<nav>
		<div class="nav-wrapper light-blue">
			<a href="index.php" class="brand-logo"> <img src="img/ProjCircleWhite@0.5x.png" alt="Projectees Logo"></a>
			<ul id="nav-mobile" class="right ">
				<li><a href="index.php?p=login" class="waves-effect waves-light btn light-blue accent-4">Login</a></li>
				<li class="hide-on-med-and-down"><a href="index.php?p=register" class="waves-effect waves-light btn light-blue accent-4">Register</a></li>
			</ul>
		</div>
	</nav>
	<?php
} else{ 
	$user = new User($_SESSION['userid']);
	?>

		<body class="grey lighten-4 side-nav-body">
			
			<div class="navbar-fixed">
				<ul id="notificationlist" class="dropdown-content">
				<?php $all = new Notification(false, $_SESSION['userid']); 
					$newCount = 0;
					foreach($all->all as $row){
						if($row['readState'] == 0){
							$newCount++;
						}
						?>
					<li class="n <?php if($row['readState'] == 1){ echo 'read';} ?>" data-nid="<?= $row['id'] ?>">
						<?php
							if($row['link'] != NULL){
								?>
						<a href="<?= $row['link'] ?>"><?= $row['text'] ?></a>
								<?php
							}
							else {
							?>
							<?= $row['text'] ?>
						<?php
							}
						?>
					</li>
						<?php
					}
				?>
			</ul>
				<nav class="z-depth-1">
					<div class="nav-wrapper light-blue accent-4 greyText ">
						<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
						<a href="index.php?p=searchProjects" class="brand-logo"> <img src="img/ProjCircleWhite@0.5x.png" alt="Projectees Logo"></a>
						<form class="search-form">
							<div class="input-field light-blue darken-3">
								<input id="search" type="search" placeholder="Search" required>
								<label class="label-icon" for="search"><i class="material-icons">search</i></label>
								<i class="material-icons">close</i>
							</div>
						</form>
						<ul id="nav-mobile" class="right">
							<li><a id="notificationDrop" class="dropdown-button" href="#!" data-activates="notificationlist"><?php if($newCount > 0){ ?><span id="notificationBadge" class="new badge amber accent-4"><?= $newCount?></span><?php } ?><i class="material-icons left">notifications</i></a></li>
							<li class="hide-on-med-and-down"><a href="index.php?p=userSettings"><i class="material-icons">settings</i></a></li>
							<li><a href="index.php?p=newProject" class="btn-floating waves-effect waves-light amber accent-3"><i class="material-icons">add</i></a></li>
						</ul>
					</div>
				</nav>
			</div>
			<ul id="slide-out" class="side-nav fixed">
				<li>
					<div class="user-view">
						<div class="background blue-grey darken-4">
							<?php if(isset($user->coverPhoto)){ ?>
							<img src="user_images/<?=$user->uid?>_img/<?=$user->coverPhoto?>" alt="User cover image">
							<?php } else { ?>
							<img src="img/smallbg.jpg" alt="User cover picture">
							<?php } ?>
						</div>
						<a href="userProfile.html">
							<?php if(isset($user->profilePic)){ ?>
							<img class="circle" src="user_images/<?=$user->uid?>_img/<?=$user->profilePic?>" alt="User Profile picture">
							<?php } else { ?>
							<img class="circle" src="img/default.jpg" alt="User Profile picture">
							<?php } ?>
						</a>
						<a href="userProfile.html"><span class="white-text name"><?= $user->name; ?></span></a>
						<a href="userProfile.html"><span class="white-text">@<?= $user->uName; ?></span></a>
						<a href="#!email"><span class="white-text email"><?=$user->email?></span></a>
					</div>
				</li>
				<li class="no-padding">
					<ul class="collapsible collapsible-accordion">
						<li>
							<a class="collapsible-header active">Projects<i class="material-icons right">arrow_drop_down</i></a>
							<div class="collapsible-body">
								<ul>
									<li class="active"><a href="index.php?p=search">Search Projects</a></li>
									<li><a href="#!">My Projects</a></li>
									<li><a href="#!">Create New Project<i class="material-icons right">add</i></a></li>
								</ul>
							</div>
						</li>
						<li>
							<a class="collapsible-header">Users<i class="material-icons right">arrow_drop_down</i></a>
							<div class="collapsible-body">
								<ul>
									<li><a href="#">Search Users</a></li>
									<li><a href="#">My Profile</a></li>
									<li><a href="index.php?p=logout">Logout</a></li>
								</ul>
							</div>
						</li>
					</ul>
				</li>
			</ul>
			<?php } ?>
