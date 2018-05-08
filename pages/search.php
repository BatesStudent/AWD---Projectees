<?php

$target = ((isset($_GET['target'])) ? $_GET['target'] : "both");
$search = ((isset($_POST['search'])) ? $_POST['search'] : ((isset($_GET['search'])) ? $_GET['search'] : false));   
$error = false;
if($search !== false){
    // we have something to search
    if($target == "both"){
        // search projects AND users
        $db = new DB();
		$db = $db->getPDO();
        $stmtU = $db->prepare("SELECT CONCAT_WS(' ', fName, sName) AS name, occupation, profilePic, username, coverPhoto FROM userProfile_limited WHERE CONCAT_WS('',fName, sName, occupation, username, skillList) LIKE '%:search%' LIMIT 6");
        $stmtU->bindParam(':search', $search);
        try{
            $stmtU->execute();
            $userResults = $stmtU->fetchAll(PDO::FETCH_OBJ);
            // title, short desc, member count, cover, user profile, category, start, user name, 
            $stmtP = $db->prepare("SELECT id, CONCAT_WS(' ', fName, sName) AS name, occupation, profilePic, username, coverPhoto FROM Projects WHERE CONCAT_WS('',title, lookingFor, shortDescription) LIKE '%:search%' LIMIT 6");
            $stmtP->bindParam(':search', $search);
        } catch(Exception $e){
            
        }
    } else if($target == "u"){
        // search users
        $db = new DB();
		$db = $db->getPDO();
        $stmtU = $db->prepare("SELECT id, CONCAT_WS(' ', fName, sName) AS name, occupation, profilePic, username, coverPhoto FROM userProfile_limited WHERE CONCAT_WS('',fName, sName, occupation, username, skillList) LIKE ? LIMIT 9");
        $uSearch = "%".trim($search)."%";
        $stmtU->bindParam(1, $uSearch);
        try{
            $stmtU->execute();
            $userResults = $stmtU->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e){
            $error = "test";
        }
    } else if($target == "p"){
        // search projects
    }
} else {
    $error = "No search query entered";
}

?>
<section>
    <div class="row">
        <div class="col s12 results">
            <h1>Search results</h1>
            <?php if($error !== false){
                echo "<p>$error</p>";
            } else { 
                var_dump($userResults);
                if(sizeof($userResults) > 0){
                    echo "<h2>Users</h2>";
                    foreach($userResults as $user){
                        ?>
                        <div class="card user-card center-align">
                            <div class="cover-image grey lighten-3" <?php if(!empty($user->coverPhoto)){?>style="background-image:url('<?php if (strpos($user->coverPhoto, 'unsplash.com') === false) { ?>user_images/<?=$user->id?>_img/<?=$user->coverPhoto?><?php } else { echo $user->coverPhoto; } } ?>')">

                            </div>
                            <div class="avatar-image z-depth-2">
                                <img <?php if(!empty($user->profilePic)){?>src="user_images/<?=$user->id?>_img/<?=$user->profilePic?>"<?php } else { ?> src="img/default.jpg" <?php } ?> alt="profile pic">
                            </div>
                            <div class="card-content">
                                <p class="user-name"><?= $user->name ?>
                                </p>
                                <p class="user-role"><?= $user->occupation ?></p>
                            </div>
                            <div class="card-action right-align">
                                <a href="index.php?p=userProfile&username=<?=$user->username?>" class="light-blue-text">View Profile</a>
                            </div>
                        </div>
                        <?php
                    }
                }
            ?>
            
            <?php } ?>
        </div>
    </div>
</section>