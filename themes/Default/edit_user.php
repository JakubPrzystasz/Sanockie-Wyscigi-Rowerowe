<?php

	$array = $db->fetch(sprintf("SELECT `id`,`login`,`email`,`permissions_level`,`register_date`,`birth_date`,`ice`,`mobile` FROM `users` WHERE `users`.`id` = '%s';",$_GET['user_id']));

	$page_name = EDIT; @require_once("header.php"); if(!is_admin() OR !isset($_GET['user_id']) OR $_GET['user_id'] == NULL OR $array['id'] == NULL){set_notification(ERRNO_23, "warning");header("Location:login");exit;}
	
?>
		<div id="main">
			<div class="jumbotron" style="text-align:center;">
				<form method="post">
				<div class="row">
				<label><?php echo USER_NAME.": ".$array['login'];?></label><br>
				<label><?php echo EMAIL.": ".$array['email'];?></label><br>
				<label><?php echo REGISTER_DATE.": ".$array['register_date'];?></label><br>
				<label><?php echo DATE_OF_BIRTH.": ".$array['birth_date'];?></label><br>
				<label><?php echo MOBILE.": ".$array['mobile'];?></label><br>
				<label><?php echo ICE.": ".$array['ice'];?></label><br>
							<div class="form-group">
								<div class="checkbox">
									<label><input type="checkbox" value="true" name="edit_user_settings"><?php echo RESET_SETTINGS; ?></label>
								</div>
							</div>
							<div class="form-group">
								<div class="radio">
									<label class="radio-inline"><input <?php if($array['permissions_level'] == 0){echo "checked";}?> type="radio" name="edit_user_perrmissions" value="0"><?php echo USER; ?></label>
									<label class="radio-inline"><input <?php if($array['permissions_level'] == 1){echo "checked";}?> type="radio" name="edit_user_perrmissions" value="1"><?php echo ADMIN; ?></label>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-default" name="edit_user_submit" value="true"><?php echo APPLY; ?></button>
								<input type="hidden" value="<?php echo $_GET['user_id'];?>" name="user_id" />
							</div>
					</div>
				</form>
			</div>			
		</div>

<?php @require_once("footer.php"); ?>
