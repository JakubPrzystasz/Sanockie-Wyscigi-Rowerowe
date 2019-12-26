<?php
	
	$page_name = EDIT_RACE; @require_once("header.php"); if(!is_admin()){set_notification(ERRNO_23,"warning");header("Location:login");exit;}
	if(isset($_GET['race_id']) AND $_GET['race_id'] != NULL)
	{
		$array = $db->fetch(sprintf("SELECT * FROM `races` WHERE `races`.`url_id` = '%s';",$_GET['race_id']));
		if($array == null){ header("Location: admin");exit;}
	}
	
?>
		<div id="main">
			<div class="jumbotron" style="text-align:center;">
				<form method="post" style="max-width:700px;margin:auto;">
					<div class="form-group">
						<label for="race_title"><?php echo RACE_TITLE; ?></label>
						<input
							<?php 
							if(isset($_GET['race_id']) AND $_GET['race_id'] != NULL)
							{
								printf("value='%s'",$array['name']);							
							}
							?>
						type="text" class="form-control" id="race_name" name="race_name" placeholder="<?php echo RACE_TITLE;?>">
					</div>
					<div class="form-group">
						<label for="race_organizer"><?php echo RACE_ORGANIZER; ?></label>
						<input
							<?php 
							if(isset($_GET['race_id']) AND $_GET['race_id'] != NULL)
							{
								printf("value='%s'",$array['organizer']);							
							}
							?>
						type="text" class="form-control" id="race_organizer" name="race_organizer" placeholder="<?php echo RACE_ORGANIZER;?>">
					</div>
					<div class="form-group">
						<label for="race_url"><?php echo URL; ?></label>
						<div class="alert alert-warning">
							<?php echo RACE_URL_WARNING;?>
						</div>
						<input
							<?php 
							if(isset($_GET['race_id']) AND $_GET['race_id'] != NULL)
							{
								printf("disabled value='%s'",$array['url']);							
							}
							?>
						type="text" class="form-control" id="race_url" name="race_url" placeholder="<?php echo URL;?>">
					</div>
					<div class="form-group">
						<label for="race_url"><?php echo RACE_SIGNUP_LIMIT; ?></label>
						<input type="number" value="<?php $limit=$db->num_rows("SELECT `id` FROM `identificators`"); if(!isset($_GET['race_id'])){echo $limit;}else{if($array['signup_limit'] == NULL){echo $limit;}else{echo $array['signup_limit'];}}?>" min="0" max="<?php echo $limit;?>" step="1" name="race_signup_limit"/>
					</div>
					<div class="form-group" style="max-width:450px;margin:auto;">	
						<label for="race_date"><?php echo RACE_DATE; ?></label>
						<input
							<?php 
							if(isset($_GET['race_id']) AND $_GET['race_id'] != NULL)
							{
								printf("value='%s'",$array['date']);							
							}
							?>
						type="text" class="form-control" id="race_date" name="race_date" placeholder="<?php echo RACE_DATE." ".RACE_DATE_FORMAT;?>">
						<script>
 							$(function(){
    							$("#race_date").datepicker({
    								  dateFormat: "yy-mm-dd"
    							});
 							});
  						</script>
					</div>
					<div class="form-group">
						<?php
							if(isset($_GET['race_id']) AND $_GET['race_id'] != NULL)
							{
								echo "<button class='btn btn-default' onclick='window.open(`index.php?site=edit_article&race_id=".$_GET['race_id']."`, `_blank`);'>".ADD_DESCRIPTION."</button><br>";
							}
						?>
						<button type="submit" class="btn btn-default" name="race_submit" value="true"><?php echo APPLY; ?></button>
					</div>
				</form>		
			</div>			
		</div>

<?php @require_once("footer.php"); ?>