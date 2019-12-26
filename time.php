<?php

	@require_once(dirname( __FILE__ )."/core/core.php");
	
	$db = new db();
	if((is_admin() OR $_POST["USER_ID"] == "AfwosBFH") AND isset($_POST["UID"]) AND $_POST["MODE"] == "time")
	{
		$rows = $db->num_rows("SELECT * FROM `races` WHERE `date` = CURDATE()");
		if($rows > 0)
		{
			$rows = $db->num_rows(sprintf("SELECT * FROM `identificators` WHERE `uid` = '%s';",$_POST['UID']));
			if($rows > 0)
			{
				$array = $db->fetch(sprintf("SELECT * FROM `races` WHERE `date` = CURDATE()"));
				$race = $db->fetch(sprintf("SELECT * FROM `race_%s` WHERE `race_%s`.`user_id` = '%s';",$array['url_id'],$array['url_id'],$_POST['UID']));
				$time = microtime(true);
				if($race['start'] == NULL)
				{
					$db->query(sprintf("UPDATE `race_%s` SET `start` = '%s' WHERE `race_%s`.`user_id` = '%s';",$array['url_id'],$time,$array['url_id'],$_POST['UID']));
				}else{
					if($race['finish'] == NULL)
					{
						$db->query(sprintf("UPDATE `race_%s` SET `finish` = '%s' WHERE `race_%s`.`user_id` = '%s';",$array['url_id'],$time,$array['url_id'],$_POST['UID']));
						$times = $db->fetch(sprintf("SELECT `start`,`finish` FROM `race_%s` WHERE `race_%s`.`user_id` = '%s';",$array['url_id'],$array['url_id'],$_POST['UID']));
						$score = $times['finish'] - $times['start'];
						$db->query(sprintf("UPDATE `race_%s` SET `score` = '%s' WHERE `race_%s`.`user_id` = '%s';",$array['url_id'],$score,$array['url_id'],$_POST['UID']));
					}
				}
				
			}
		}
	}
	if((is_admin() OR $_POST["USER_ID"] == "AfwosBFH") AND isset($_POST["UID"]) AND $_POST["MODE"] == "id")
	{
		$rows = $db->num_rows(sprintf("SELECT * FROM `identificators` WHERE `uid` = '%s'",$_POST["UID"]));
		if($rows < 1)
		{
			$db->query(sprintf("INSERT INTO `identificators` (`id`, `uid`) VALUES (NULL, '%s');",$_POST["UID"]));
		}
	}
	
	if(isset($_POST['ALL']) AND is_admin())
	{
		$rows = $db->num_rows("SELECT * FROM `races` WHERE `date` = CURDATE()");
		if($rows > 0)
		{
			$race = $db->fetch("SELECT * FROM `races` WHERE `date` = CURDATE()");
			$array = $db->fetch_all(sprintf("SELECT `id` FROM `race_%s`",$race['url_id']));
			$time = $_SERVER['REQUEST_TIME_FLOAT'];
			foreach($array as $key => $val)
			{
				$db->query(sprintf("UPDATE `race_%s` SET `start` = '%s' WHERE `race_%s`.`id` = '%s';",$race['url_id'],$time,$race['url_id'],$array[$key]['id']));
			}
		}
	}
	
	unset($_POST);
	unset($_REQUEST);

?>