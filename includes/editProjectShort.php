<?php
spl_autoload_register(function ($class_name) {
    require_once '../classes/'.$class_name . '.class.php';
});
session_start();
if(isset($_SESSION['userid']) && isset($_POST['short']) && isset($_POST['projectid'])){
    $desc = trim(strip_tags($_POST['short']));
    if($desc != ""){
		$p = new Project();
		$project = $p->getCardDetails($_POST['projectid']);
		if($project->ownerID == $_SESSION['userid']){
			$result = $p->setShort($desc, $_POST['projectid']);
			if($result === true){
				echo "Description successfully changed!";
			} else if($result !== false) {
				echo $result;
			} else {
				echo "Oops, something went wrong for a scary technical reason - please contact us if the issue persists!";
			}
		} else {
			echo "You do not own this project.";
		}
    }
}
?>