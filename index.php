<?php 
// http://php.net/manual/en/language.oop5.autoload.php
spl_autoload_register(function ($class_name) {
    require_once __DIR__.'/classes/'.$class_name . '.class.php';
});
session_start();

// if an application page has been specified and the user is loggedin...
if(isset($_GET["p"]) && isset($_SESSION['uid'])){
	$user = new User($_SESSION['uid']);
	$getTitle = $_GET["p"];
}
// if a general page has been specified it doesn't matter if the user is logged in (this covers pages like about, contact, log in, home etc.)
else if(isset($_GET["gp"])){
	$getTitle = $_GET["gp"];
}
// if a page is NOT specified but the user is logged in, go to the dashboard rather than the default home page
else if(isset($_SESSION['uid'])){
	$user = new User($_SESSION['uid']);
	$getTitle = "search";
}
// otherwise the user should be viewing the home page
else{
	$getTitle = "home";
}
require_once "elements/header.php";
require_once "pages/$getTitle.php";
require_once "elements/footer.php";
?>
