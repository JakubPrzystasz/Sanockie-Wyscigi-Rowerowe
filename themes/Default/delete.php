<?php

	@require_once(dirname(__DIR__)."/../core/core.php");

	if(!is_admin())
	{
		exit;
	}
	
	if(isset($_GET['reset_score']) AND $_GET['reset_score'] != "" AND $_GET['race_id_reset_score'] != "" AND isset($_GET['race_id_reset_score']))
	{
		$id = $db->fetch(sprintf("SELECT * FROM `identificators` WHERE `id` = '%s';",$_GET['reset_score']));
		$db->query(sprintf("UPDATE `race_%s` SET `score` = NULL, `finish` = NULL WHERE `user_id` = '%s';",$_GET['race_id_reset_score'],$id['id']));
		echo "<script>window.history.back();</script>";
	}
	
	if(isset($_POST['quick_delete_user_login']) AND is_admin())
	{
		$race = $db->fetch(sprintf("SELECT `url_id` FROM `races` WHERE `date` = CURDATE()"));
		$race = $race['url_id'];
		$db->query(sprintf("DELETE FROM `race_%s` WHERE `user_login` = '%s';",$race,$_POST['quick_delete_user_login']));
	}
	
	if(isset($_GET['user_id_race']) AND isset($_GET['sign_up_race_id']) AND is_admin())
	{
		$db->query(sprintf("DELETE FROM `race_%s` WHERE `race_%s`.`user_id` = '%s';",$_GET['sign_up_race_id'],$_GET['sign_up_race_id'],$_GET['user_id_race']));
		set_notification(CHANGES_SET,"success");
		echo "<script>window.history.back();</script>";
	}

	if(isset($_GET['article_id']) AND $_GET['article_id'] != NULL AND is_admin())
	{
		$db->query(sprintf("DELETE FROM `articles` WHERE `articles`.`url_id` = '%s'",$_GET['article_id']));
		$db->query(sprintf("DELETE FROM `urls` WHERE `urls`.`url_id` = '%s';",$_GET['article_id']));
		set_notification(CHANGES_SET,"success");
		header("Location:admin");
	}
	
	if(isset($_GET['user_id']) AND $_GET['user_id'] != NULL AND is_admin())
	{
		$db->query(sprintf("DELETE FROM `users` WHERE `users`.`id` = '%s';",$_GET['user_id']));
		set_notification(CHANGES_SET,"success");
		header("Location:admin");
	}
	
	if(isset($_GET['id_id']) AND $_GET['id_id'] != NULL AND is_admin())
	{
		$db->query(sprintf("DELETE FROM `identificators` WHERE `identificators`.`id` = '%s';",$_GET['id_id']));
		set_notification(CHANGES_SET,"success");
		header("Location:ids");
	}
	
	if(isset($_GET['category_id']) AND $_GET['category_id'] != NULL AND is_admin())
	{
		$db->query(sprintf("DELETE FROM `categories` WHERE `categories`.`id` = '%s';",$_GET['category_id']));
		set_notification(CHANGES_SET,"success");
		header("Location:categories");
	}
	
	if(isset($_GET['classification_id']) AND $_GET['classification_id'] != NULL AND is_admin())
	{
		$db->query(sprintf("DELETE FROM `classifications` WHERE `id` = '%s';",$_GET['classification_id']));
		set_notification(CHANGES_SET,"success");
		header("Location:classifications");
	}
	
	if(isset($_GET['race_id']) AND $_GET['race_id'] != NULL AND is_admin())
	{
		$array = $db->fetch(sprintf("SELECT `name`,`url_id` FROM `races` WHERE `races`.`url_id` = '%s';",$_GET['race_id']));
		$db->query(sprintf("DROP TABLE race_%s",$array['url_id']));
		$db->query(sprintf("DELETE FROM `urls` WHERE `urls`.`url_id` = '%s'",$_GET['race_id']));
		$db->query(sprintf("DELETE FROM `races` WHERE `races`.`url_id` = '%s';",$_GET['race_id']));
		set_notification(CHANGES_SET,"success");
		header("Location:admin");
	}
	
?>