<?php

	$page_name = EDIT_CATEGORIES; @require_once("header.php"); if(!is_admin()){set_notification(ERRNO_23,"warning");header("Location:login");exit;}
	if(isset($_GET['category_id']))
	{
		$category = $db->fetch(sprintf("SELECT * FROM `categories` WHERE `id` = '%s';",$_GET['category_id']));
		if($category == NULL)
		{
			header("Location: admin");
			set_notification(ERRNO_48, "danger");
			exit;
		}
	}
	
?>
		<div id="main">
			<div class="jumbotron" style="text-align:center;">
				<div class="form-group" style="max-width:450px;margin:auto;">
					<div class="panel panel-default">
						<div class="panel-body">
							<form method="post">
								<div class="form-group">
									<label for="category_name"><?php echo CATEGORY_NAME;?>:</label>
									<input type="text" class="form-control" id="category_name" <?php if(isset($_GET['category_id'])){echo "value='".$category['name']."'";}?>>
								</div>
								<div class="form-group">
									<label for="category_age_begin"><?php echo CATEGORY_AGE_BEGIN;?>:</label>
									<input type="number" value="<?php if(isset($_GET['category_id'])){echo $category['age_begin'];}else{echo "0";}?>" min="0" max="255" step="1" name="category_age_begin"/>
									
								</div>
								<div class="form-group">
									<label for="category_age_end"><?php echo CATEGORY_AGE_END;?></label>
									<input type="number" value="<?php if(isset($_GET['category_id'])){echo $category['age_end'];}else{echo "0";}?>" min="0" max="255" step="1" name="category_age_end"/>
								</div>
								<div class="radio">
									<label class="radio-inline"><input type="radio" name="category_sex" value="man" <?php if($category['sex'] == "man"){echo "checked";}?>><?php echo MANS;?></label>
									<label class="radio-inline"><input type="radio" name="category_sex" value="women" <?php if($category['sex'] == "women"){echo "checked";}?>><?php echo WOMENS;?></label>
									<label class="radio-inline"><input type="radio" name="category_sex" value="both" <?php if($category['sex'] == "both"){echo "checked";}?>><?php echo BOTH;?></label>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-default" name="category_submit" value="<?php echo APPLY;?>"/>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>			
		</div>

<?php @require_once("footer.php"); ?>