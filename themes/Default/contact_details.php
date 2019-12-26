<?php
	if(!is_admin()){header("Location: index");set_notification(ERRNO_23,"warning");exit();}
	
	$page_name = RACE_MANAGER;
	
	@require_once("header.php");
	
	$array = $db->fetch(sprintf("SELECT `name`,`surname`,`ice`,`mobile`,`birth_date` FROM `users` WHERE `users`.`login` = '%s'",$_GET['user_login']));
	if($array['mobile'] == "")
	{
		$array['mobile'] = _EMPTY;
	}
	if($array['ice'] == "")
	{
		$array['ice'] = _EMPTY;
	}
	if($array['birth_date'] == "")
	{
		$array['birth_date'] = _EMPTY;
	}
?>
		<div id="main">
			<div class="jumbotron" style="text-align:center;margin:auto;">
				<?php
					echo "<h3>".CONTACT."</h3><br>";
					echo "<label>".NAME.": ".$array['name']."</label><br>";
					echo "<label>".SURNAME.": ".$array['surname']."</label><br>";
					echo "<label>".MOBILE.": ".$array['mobile']."</label><br>";
					echo "<label>".ICE.": ".$array['ice']."</label><br>";
					echo "<label>".DATE_OF_BIRTH."[YYYY-MM-DD]: ".$array['birth_date']."</label><br>";
					echo "<button type='button' class='btn btn-info' onclick='window.location = `race_manager`;'>".BACK."</button>";
				?>
			</div>			
		</div>
<?php @require_once("footer.php"); ?>