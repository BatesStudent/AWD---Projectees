<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Projectees | <?= $getTitle?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css'>
	<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
	<link rel="stylesheet" href="scss/style.css">	
	<link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
</head>

<body class="grey lighten-4">
	<?php if(!isset($_SESSION['uid'])){
	?>
		<nav>
			<div class="nav-wrapper light-blue">
				<a href="index.php" class="brand-logo"> <img src="../img/ProjCircleWhite@0.5x.png" alt="Projectees Logo"></a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li><a href="index.php?gp=login" class="waves-effect waves-light btn light-blue accent-4">Login</a></li>					
					<li><a href="index.php?gp=register" class="waves-effect waves-light btn light-blue accent-4">Register</a></li>
				</ul>
			</div>
		</nav>
	<?php
} ?>
	