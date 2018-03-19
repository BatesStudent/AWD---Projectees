<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Projectees | <?= $getTitle?></title>
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
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li><a href="index.php?p=login" class="waves-effect waves-light btn light-blue accent-4">Login</a></li>					
					<li><a href="index.php?p=register" class="waves-effect waves-light btn light-blue accent-4">Register</a></li>
				</ul>
			</div>
		</nav>
	<?php
} else{ ?>
    <body class="grey lighten-4 side-nav-body">
	<div class="navbar-fixed">
        <nav class="z-depth-1">
            <div class="nav-wrapper light-blue accent-4 greyText ">
                <a href="index.php?p=searchProjects" class="brand-logo"> <img src="img/ProjCircleWhite@0.5x.png" alt="Projectees Logo"></a>
                <form class="search-form">
                    <div class="input-field light-blue darken-3">
                        <input id="search" type="search" placeholder="Search" required>
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href=""><i class="material-icons">notifications</i></a></li>
                    <li><a href="index.php?p=userSettings" ><i class="material-icons">settings</i></a></li>
                    <li><a href="index.php?p=newProject" class="btn-floating waves-effect waves-light amber accent-3"><i class="material-icons">add</i></a></li>
                </ul>
            </div>
        </nav>
	</div>
	<ul id="slide-out" class="side-nav fixed">
        <li><div class="user-view">
      <div class="background">
        <img src="img/defaultCover.jpg">
      </div>
      <a href="userProfile.html"><img class="circle" src="img/default.jpg"></a>
      <a href="userProfile.html"><span class="white-text name">User Name</span></a>
      <a href="#!email"><span class="white-text email">user@email.co.uk</span></a>
    </div></li>
		 <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
              <li>
                <a class="collapsible-header active">Projects<i class="material-icons right">arrow_drop_down</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li class="active"><a href="searchProjects.html">Search Projects</a></li>
                    <li><a href="#!">My Projects</a></li>
                    <li><a href="#!">Create New Project<i class="material-icons right">add</i></a></li>
                  </ul>
                </div>
              </li>
                <li>
                <a class="collapsible-header">Users<i class="material-icons right">arrow_drop_down</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="searchUsers.html">Search Users</a></li>
                    <li><a href="userProfile.html">My Profile</a></li>
                  </ul>
                </div>
              </li>
            </ul>
          </li>
        <li><a href="#!"></a></li>
	</ul>
    <?php } ?>
	