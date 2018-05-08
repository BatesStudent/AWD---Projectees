<?php
spl_autoload_register(function ($class_name) {
    require_once '../classes/'.$class_name . '.class.php';
});
session_start();
if(isset($_SESSION['userid']) && isset($_POST['quote'])){
    $intro = trim(strip_tags($_POST['quote']));
    if($intro != ""){
        $u = new User($_SESSION['userid']);
        $result = $u->setIntro($intro);
        if($result === true){
            echo "Intro quote successfully changed!";
        } else if($result !== false) {
            echo $result;
        } else {
            echo "Oops, something went wrong for a scary technical reason - please contact us if the issue persists!";
        }
    }
}
?>