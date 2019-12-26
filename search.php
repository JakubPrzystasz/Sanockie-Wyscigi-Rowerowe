<?php

	@require_once(dirname( __FILE__ )."/core/core.php");
	
	if(isset($_POST['search_race']) AND $_POST['search_race'] != "")
	{
		if(!is_admin()){header("Location:login");set_notification(ERRNO_23, "warning");exit;}
	
		$db = new db();
		$array = $db->fetch_all("SELECT * FROM `races` WHERE `name` COLLATE utf8_general_ci LIKE '%".$_POST['search_race']."%' OR `organizer` COLLATE utf8_general_ci LIKE '%".$_POST['search_race']."%' OR `date` LIKE '%".$_POST['search_race']."%';","MYSQLI_NUM");
		if($array)
		{
			foreach($array as $key => $val)
			{
				$array['date'] = DateTime::createFromFormat('Y-m-d', $array[$key]['date']);
				$array['date'] = $array['date']->format('d-m-Y');
				echo "<tr>
						<td>".$array[$key]['name']."</td>
						<td>".$array['date']."</td>
						<td style='cursor:pointer;' onclick='if(confirm(`".U_RIGHT."`)==true){window.document.location=`index.php?site=delete&race_id=".$array[$key]['url_id']."`;}'><a>".DELETE."</a></td>
						<td style='cursor:pointer;' onclick='window.document.location=`index.php?site=edit_race&race_id=".$array[$key]['url_id']."`;'><a>".EDIT."</a></td>
					   	</tr>";
			}
		}else{
			echo NO_RESULTS;
		}
	}
	
	if(isset($_POST['search_user_name']) AND $_POST['search_user_name'] != "")
	{
		if(!is_admin()){header("Location:login");set_notification(ERRNO_23, "warning");exit;}
	
		$db = new db();
		$array = $db->fetch_all("SELECT `login`,`id`,`name`,`surname` FROM `users` WHERE `login` COLLATE utf8_general_ci LIKE '%".$_POST['search_user_name']."%' OR `email` COLLATE utf8_general_ci LIKE '%".$_POST['search_user_name']."%' OR `name` COLLATE utf8_general_ci LIKE '%".$_POST['search_user_name']."%' OR `surname` COLLATE utf8_general_ci LIKE '%".$_POST['search_user_name']."%' ","MYSQLI_NUM");
		if($array)
		{
			foreach($array as $key => $val)
			{
				echo "<tr>
						<td>".$array[$key]['login']."</td>
						<td>".$array[$key]['name']."</td>
						<td>".$array[$key]['surname']."</td>
						<td style='cursor:pointer;' onclick='if(confirm(`".U_RIGHT."`)==true){window.document.location=`index.php?site=delete&user_id=".$array[$key]['id']."`;}'><a>".DELETE."</a></td>
						<td style='cursor:pointer;' onclick='window.document.location=`index.php?site=edit_user&user_id=".$array[$key]['id']."`;'><a>".EDIT."</a></td>
					   	</tr>";
			}
		}else{
			echo NO_RESULTS;
		}
	}
	
	if(isset($_POST['quick_signup_search_user_name']) AND $_POST['quick_signup_search_user_name'] != "")
	{
		if(!is_admin()){header("Location:login");set_notification(ERRNO_23, "warning");exit;}
	
		$db = new db();
		$array = $db->fetch_all("SELECT `login`,`id`,`name`,`surname` FROM `users` WHERE `login` COLLATE utf8_general_ci LIKE '%".$_POST['quick_signup_search_user_name']."%' OR `email` COLLATE utf8_general_ci LIKE '%".$_POST['quick_signup_search_user_name']."%' OR `name` COLLATE utf8_general_ci LIKE '%".$_POST['quick_signup_search_user_name']."%' OR `surname` COLLATE utf8_general_ci LIKE '%".$_POST['quick_signup_search_user_name']."%' ","MYSQLI_NUM");
		if($array)
		{
			foreach($array as $key => $val)
			{
				echo "<tr>
						<td>".$array[$key]['login']."</td>
						<td>".$array[$key]['name']."</td>
						<td>".$array[$key]['surname']."</td>
						<td style='cursor:pointer;' onclick='quick_signup(`".$array[$key]['id']."`)'><a>".QUICK_SIGNUP_BTN."</a></td>
					</tr>";
			}
		}else{
			echo NO_RESULTS;
		}
	}
	
	if(isset($_POST['search_article']) AND $_POST['search_article'] != "")
	{
		if(!is_admin()){header("Location:login");set_notification(ERRNO_23, "warning");exit;}
	
		$db = new db();
		$array = $db->fetch_all("SELECT * FROM `articles` WHERE `title` COLLATE utf8_general_ci LIKE '%".$_POST['search_article']."%' OR `text` COLLATE utf8_general_ci LIKE '%".$_POST['search_article']."%' OR `author` COLLATE utf8_general_ci LIKE '%".$_POST['search_article']."%' OR `language` COLLATE utf8_general_ci LIKE '%".$_POST['search_article']."%' OR `url` COLLATE utf8_general_ci LIKE '%".$_POST['search_article']."%' OR `date` LIKE '%".$_POST['search_article']."%' ORDER BY `articles`.`date` DESC;","MYSQLI_NUM");
		if($array)
		{
			foreach($array as $key => $val)
			{
				$author = $db->fetch(sprintf("SELECT `login` FROM `users` WHERE `login` = '%s';",$array[$key]['author']));
				echo "<tr style='cursor:pointer;' onclick='window.document.location=`index.php?site=edit_article&article_id=".$array[$key]['url_id']."`;'>
						<td>".$array[$key]['title']."</td>
						<td>".$author['login']."</td>
						<td>".$array[$key]['language']."</td>
						<td>".$array[$key]['date']."</td>
					</tr>";
			}
		}else{
			echo NO_RESULTS;
		}
	}
	
	if(isset($_POST['search']) AND $_POST['search'] != "")
	{
		if(!isset($_COOKIE['lang']))
		{
			$language = $_SESSION['language'];
		}
		if(isset($_COOKIE['lang']))
		{
			$language = $_COOKIE['lang'];
		}
		$_POST['search'] = htmlentities($_POST['search'], ENT_QUOTES);
		$db = new db();
		$question = "SELECT `title`,`text`,`language`,`url` FROM `articles` WHERE `title` COLLATE utf8_general_ci LIKE '%".$_POST['search']."%' OR `text` COLLATE utf8_general_ci LIKE '%".$_POST['search']."%' AND `language` = '".$language."';";
		$articles_rows = $db->num_rows($question);
		$articles_array = $db->fetch_all($question,"MYSQLI_NUM");
	
		if($articles_rows == 0 OR $_POST['search'] == "")
		{
			echo "<h2>".NO_RESULTS."</h2>";
		}else{
			echo "<h4>".FOUND.": ".$articles_rows."</h4>";
			foreach($articles_array as $key => $val)
			{
				echo "<h5>".ARTICLE." - <a href='".$articles_array[$key]['url']."'>".$articles_array[$key]['title']."</a></h5>";
			}
		}
	}

?>