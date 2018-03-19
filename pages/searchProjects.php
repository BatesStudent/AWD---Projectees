<section>
    <div class="container">
<?php
    if(isset($_SESSION['userid'])){
        $user = new User($_SESSION['userid']);
        if($user->profileCompletion() < 40){
            echo "<script>window.location.assign('index.php?p=createProfile');</script>";
            exit;
        }
        else if($user->profileCompletion() < 100){
            ?>

        <div class="progress">
            <div class="determinate" style="width: <?= $user->profileCompletion(); ?>%"></div>
        </div>        
        <div>Profile completion: <?= $user->profileCompletion(); ?>% <a href='index.php?p=createProfile'>You're missing parts of your profile! Fill them in to help people find you!</a></div>
<?php
        }
        else{
            
        }
    }
?>
    
    
    
    </div>
</section>