<?php

	$page_name = EDIT_CLASSIFICATION; @require_once("header.php"); if(!is_admin()){set_notification(ERRNO_23,"warning");header("Location:login");exit;}
	if(isset($_GET['classification_id']))
	{
		$classification = $db->fetch(sprintf("SELECT * FROM `classifications` WHERE `id` = '%s';",$_GET['classification_id']));
		if($classification == NULL)
		{
			header("Location: admin");
			set_notification(ERRNO_48, "danger");
			exit;
		}
		//print_r($classification);
	}

?>
		<div id="main">
			<div class="jumbotron" style="text-align:center;">
				<div class="form-group" style="max-width:450px;margin:auto;">
					<div class="panel panel-default">
						<div class="panel-body">
							<form method="post">
								<div class="form-group">
									<label for="classification_name"><?php echo CLASSIFICATION_NAME;?>:</label>
									<input type="text" class="form-control" id="classification_name" <?php if(isset($_GET['classification_id'])){echo "value='".$classification['name']."'";}?>>
								</div>
								<div class="form-group">
									<label for="classification_url"><?php echo CLASSIFICATION_URL;?>:</label>
									<input type="text" class="form-control" id="classification_url" <?php if(isset($_GET['classification_id'])){echo "value='".$classification['url']."'";}?>>
								</div>
								<div class="form-group">
									<label for="classification_races"><?php echo CLASSIFICATION_RACES;?></label>
								  	<select multiple class="form-control" name="classification_races">
								   		<option>1</option>
								    	<option>2</option>
									</select>
								</div>
								<div class="form-group">
									<label for="classification_categories"><?php echo CLASSIFICATION_CATEGORIES;?></label>
								  	<select multiple class="form-control" name="classification_categories">
								   		<option>1</option>
								    	<option>2</option>
									</select>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-default" name="classification_submit" value="<?php echo APPLY;?>"/>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>			
		</div>

<?php @require_once("footer.php"); ?>
