<?php
	@require_once("core/core.php");
	$db = new db();
	if(is_admin() == true)
	{
		$race = $db->fetch("SELECT * FROM `races` ORDER BY `races`.`date` DESC");
		echo "<h3>".$race['name']."</h3><br>";
		$scores = $db->fetch_all(sprintf("SELECT * FROM `race_%s` WHERE `score` IS NOT NULL AND `start` IS NOT NULL AND `finish` IS NOT NULL",$race['url_id']));
echo "<p>LOGIN | NUMER | START | STOP</p><hr>";
		foreach($scores as $key=>$val)
		{
			echo "<p>".$val['user_login']." | ".$val['user_id']." | ".$val['start']." | ".$val['finish']."</p><hr>";
		}
	}
?>
