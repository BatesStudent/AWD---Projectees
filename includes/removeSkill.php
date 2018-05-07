<?php
spl_autoload_register(function ($class_name) {
    require_once '../classes/'.$class_name . '.class.php';
});
session_start();
if(isset($_SESSION['userid']) && isset($_POST['skill'])){
    $skill = trim(strip_tags($_POST['skill']));
    if($skill != ""){
        $u = new User($_SESSION['userid']);
        $result = $u->removeSkill($skill);
        if($result === true){
            echo "Skill successfully removed!";
        } else if($result !== false) {
            echo $result;
        } else {
            echo "Oops, skill not removed for a scary technical reason - please contact us if the issue persists!";
        }
    }
}
?>