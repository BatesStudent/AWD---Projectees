<?php 
// http://php.net/manual/en/language.oop5.autoload.php
spl_autoload_register(function ($class_name) {
    require_once __DIR__.'/classes/'.$class_name . '.class.php';
});
session_start();

// if an application page has been specified
if(isset($_GET["p"])){
	$getTitle = $_GET["p"];
}
// if a page is NOT specified but the user IS logged in
// go to the search screen rather than the default home page
else if(isset($_SESSION['userid'])){
	$user = new User($_SESSION['userid']);
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
