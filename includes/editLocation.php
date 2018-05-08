<?php
spl_autoload_register(function ($class_name) {
    require_once '../classes/'.$class_name . '.class.php';
});
session_start();
if(isset($_SESSION['userid']) && isset($_POST['location'])){
    $location = trim(strip_tags($_POST['location']));
    if($location != ""){
        $u = new User($_SESSION['userid']);
        $result = $u->setLocation($location);
        if($result === true){
            echo "Location successfully changed!";
        } else if($result !== false) {
            echo $result;
        } else {
            echo "Oops, something went wrong for a scary technical reason - please contact us if the issue persists!";
        }
    }
}
?>