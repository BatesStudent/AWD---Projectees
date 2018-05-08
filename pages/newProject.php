<?php
if(!isset($_SESSION['userid'])){
	echo "<script>window.location.assign('index.php?p=login');</script>";
	exit;
}

// get catergories for category select drop-down
$db = new DB();
$db = $db->getPDO();
$categories = $db->query("SELECT * FROM catChoice");
$categories = $categories->fetchAll(PDO::FETCH_OBJ);
?>

<section class="circle-bottom-section full-height center-align">
	<div class="container">
		<div>
			<div class="row introw">
				<h1>Start a project...</h1>
				<p>Ooooh, isn't this exciting! Fill out a few details below (be as specific as you can) and your on your way to completing that thing you've always thought about doing but just never got round to it. Until now!</p>
			</div>
			<div class="row center-align">
				<div class="col l2 m1 hide-on-small">
				</div>
				<form class="col l8 m10 s12 card" action="index.php?p=newProejct" method="post">
					<ul class="tabs tabs-fixed-width">
						<li class="tab"><a class="active" href="#required-details">Required Details</a></li>
						<li class="tab"><a href="#optional-details">Optional Info (improves your listing)</a></li>
				  	</ul>
					<div id="required-details" class="col s12">
						<div class="row">
							<div class="input-field col s12">
								 <i class="material-icons prefix">title</i>
								<input id="title" type="text" class="validate" name="title" placeholder="My Amazing Project Idea" required>
								<label for="title">Title *</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								 <i class="material-icons prefix">description</i>
								<textarea id="short" class="validate materialize-textarea" placeholder="Sell your project idea in 140 character or less..." name="short" data-length="140" required></textarea>
								<label for="short">Short Description *</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col m6 s12">
								<i class="material-icons prefix">group</i>
								<input id="capacity" type="number" max="99999" min="1" placeholder="6" class="validate" name="capacity" required>
								<label for="capacity">Capacity *</label>
							</div>
							<div class="input-field col m6 s12">
								<i class="material-icons prefix">date_range</i>
								<input name="startDate" type="text" class="startdatepicker" placeholder="<?= date('Y-m-d') ?>" required>								
								<label for="startDate">Project Start date *</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">								
								<i class="material-icons prefix select-prefix">toc</i>
								<select required>
									<?php 
										$prevParent = false;
										foreach($categories as $cat){
											if($prevParent === false){
												echo '<optgroup label="'.$cat->parent.'">';
											}
											else if($cat->parent != $prevParent){
												echo '</optgroup><optgroup label="'.$cat->parent.'">';
											}
											echo '<option value="'.$cat->id.'">'.$cat->subCat.'</option>';
											$prevParent = $cat->parent;
										}
									   echo '</optgroup>';
									?>
								</select>
								<label>Category *</label>
						  	</div>
						</div>
						<div class="row">
							<div class="col s12">
								<button id="project-submit" class="btn waves-effect waves-light" type="submit" name="newproject-action">Create project
									<i class="material-icons right">send</i>
								</button>
							</div>
						</div>
					</div>
					<div id="optional-details" class="col s12">
						<div class="row">
							<p>These details are optional but we highly recommend filling them in to improve the quality of your project listing and the chances of it being found by the right people!</p>
							<div class="input-field col s12">
								 <i class="material-icons prefix">email</i>
								<textarea id="long" class="validate materialize-textarea" name="long" required></textarea>
								<label for="long">Long Description</label>
								<span class="helper-text">Go into as much detail as you want to describe your project. What is it about, what will you be doing, who's doing what, who will benefit from your project and how?</span>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix">format_align_left</i>
								<textarea id="lookingFor" class="validate materialize-textarea" name="lookingFor" required></textarea>
								<label for="lookingFor">Who or what are you looking for?</label>
								<span class="helper-text">Tell fellow Projectees what your project needs: this might be specific role titles, skills or a general description of tasks that need completing.</span>
							</div>
						</div>
						<div class="row">
							<div class="file-field input-field col m6 s12">							
								<div class="btn">
									<span>Cover Picture</span>
									<input type="file" name="coverPicture" id="coverPicture">									
								</div>
								<div class="file-path-wrapper">
									<input class="file-path validate" type="text">									
								</div>
							</div>
							<div class="input-field col m6 s12">
								<i class="material-icons prefix">date_range</i>
								<input name="endDate" type="text" class="enddatepicker" placeholder="<?= date('Y-m-d') ?>" required>
								<label for="endDate">Project End date</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col m6 s12">
								Virtual only?
								<div class="switch">
									<label>
									  No
									  <input type="checkbox">
									  <span class="lever"></span>
									  Yes
									</label>
							  	</div>
							</div>
							<div class="input-field col m6 s12">
								Invite only?
								<div class="switch">
									<label>
									  No
									  <input type="checkbox">
									  <span class="lever"></span>
									  Yes
									</label>
							  	</div>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<button id="project-submit" class="btn waves-effect waves-light" type="submit" name="newproject-action">Create project
									<i class="material-icons right">send</i>
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>