<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Projectees |
		<?= ucwords($getTitle)?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel='stylesheet' href='materialize-src/sass/materialize.css'>
	<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
	<link rel="stylesheet" href="scss/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poiret+One&Roboto:300,400" rel="stylesheet">
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
	<script src='materialize-src/js/bin/materialize.min.js'></script>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
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
	// user is logged in, so show the full header
	$user = new User($_SESSION['userid']);
	?>
		<body class="grey lighten-4 side-nav-body">
			
			<div class="navbar-fixed">
				<ul id="notificationlist" class="dropdown-content">
				<?php $all = new Notification(false, $_SESSION['userid']); 
					$newCount = 0;
					foreach($all->all as $row){
						$newCount++;						
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
						<a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>						
						<a href="index.php?p=search" class="brand-logo">
							<img src="img/ProjCircleWhite@0.5x.png" alt="Projectees Logo">
						</a>
						<form class="search-form" method="post" action="index.php?p=search">
							<div class="input-field light-blue darken-3">
								<input id="search" name="search" type="search" placeholder="Search" required>
								<label class="label-icon" for="search"><i class="material-icons">search</i></label>
								<i class="material-icons">close</i>
							</div>
						</form>
						<ul id="nav-mobile" class="right">
							<li>
								<a id="notificationDrop" class="dropdown-trigger-n" href="#!" data-target="notificationlist">
								<?php if($newCount > 0){ ?>
									<span id="notificationBadge" class="new badge amber accent-4"><?= $newCount?></span>
									<?php } ?>
									<i class="material-icons left">notifications</i>
								</a>
							</li>
							<li><a href="index.php?p=newProject" class="btn-floating waves-effect waves-light amber accent-3 tooltipped" data-tooltip="New Project" data-direction="bottom"><i class="material-icons">add</i></a></li>
						</ul>
					</div>
				</nav>
			</div>
			<ul id="slide-out" class="sidenav sidenav-fixed">
				<li>
					<div class="user-view">
						<div class="background blue-grey darken-4">
							<?php if(isset($user->coverPhoto)){ ?>
							<img src="<?php if (strpos($user->coverPhoto, 'unsplash.com') === false) { ?>user_images/<?=$user->uid?>_img/<?=$user->coverPhoto?><?php } else { echo $user->coverPhoto; } ?>" alt="User cover image">
							<?php } else { ?>
							<img src="img/smallbg.jpg" alt="User cover picture">
							<?php } ?>
						</div>
						<a href="index.php?p=userProfile&username=<?= $user->username?>">
							<?php if(isset($user->profilePic)){ ?>
							<img class="circle" src="user_images/<?=$user->uid?>_img/<?=$user->profilePic?>" alt="User Profile picture">
							<?php } else { ?>
							<img class="circle" src="img/default.jpg" alt="User Profile picture">
							<?php } ?>
						</a>
						<a href="index.php?p=userProfile&username=<?= $user->username?>"><span class="white-text name"><?= $user->name; ?></span></a>
						<a href="index.php?p=userProfile&username=<?= $user->username?>"><span class="white-text">@<?= $user->username; ?></span></a>
					</div>
				</li>
				<li class="no-padding">
					<ul class="collapsible collapsible-accordion">
						<li class="active">
							<a class="collapsible-header">Projects<i class="material-icons right">arrow_drop_down</i></a>
							<div class="collapsible-body">
								<ul>
									<li data-active-title="searchProjects"><a href="index.php?p=search&target=p">Search Projects</a></li>
									<li data-active-title="userProjects"><a href="index.php?p=myProjects">My Projects</a></li>
									<li data-active-title="newProject"><a href="index.php?p=newProject">Create New Project<i class="material-icons right">add</i></a></li>
								</ul>
							</div>
						</li>
						<li>
							<a class="collapsible-header">Users<i class="material-icons right">arrow_drop_down</i></a>
							<div class="collapsible-body">
								<ul>
									<li data-active-title="searchUsers"><a href="index.php?p=search&target=u">Search Users</a></li>
									<li data-active-title="userProfile"><a href="index.php?p=userProfile&username=<?= $user->username?>">My Profile</a></li>
									<li><a href="index.php?p=deleteAccount" class="delete-account red-text text-darken-1"><i class="material-icons right">delete_forever</i>Delete Account</a></li>
									<li><a href="index.php?p=logout">Logout<i class="material-icons right">exit_to_app</i></a></li>
								</ul>
							</div>
						</li>
					</ul>
				</li>
			</ul>
			<?php } ?>