<?php
session_start();
session_unset();
session_destroy();
if(isset($_GET['c'])){
    $user = new User();
    if($user->activateAccount($_GET['c']) === true){
        echo "<script>window.location.assign('index.php?p=login&activated=y');</script>";
        exit;
    }
    else{
        echo "<script>M.toast({html:'Account not activated, is your link correct?'});</script>";
        require_once "register.php";
    }
}
?>