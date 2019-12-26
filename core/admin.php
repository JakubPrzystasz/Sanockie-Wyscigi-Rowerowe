<?php


function default_language_selector()
{

	//get language from db
	$db = new db();
	$db->query("SELECT `language` FROM `config` WHERE `id` = 1");

	//print form
	echo "<form method='post'>
					<div class='form-group'>
  						<label><h4>".DEFAULT_LANGAUGE_SELECTOR_TITLE."</h4></label>";
	$files = scandir("lang", 1);
	foreach($files as $val)
	{
			
		if($val != "." AND $val != ".." AND $val != "README.txt" AND file_exists("lang"."/".$val."/translation.php") AND file_exists("lang"."/".$val."/config.ini"))
		{
			$config = parse_ini_file("lang"."/".$val."/config.ini");
			if($_SESSION['language'] == $val)
			{
				echo "<div class='radio'>
  								<label><input type='radio' name='lang' value='".$val."' checked /> ".$val." ".TRANSLATIONS_AUTHOR.": ".$config['author']."</label>
							</div>";
			}

			if($_SESSION['language'] != $val)
			{
				echo "<div class='radio'>
  								<label><input type='radio' name='lang' value='".$val."'  /> ".$val." ".TRANSLATIONS_AUTHOR.": ".$config['author']."</label>
  							</div>";
			}

		}
			
	}


	echo "</div>
  				<button type='submit' class='btn btn-default' name='language_sent' value='true'>".APPLY."</button>
			</form>";
	if(isset($_POST['language_sent']) AND is_admin() AND $_POST['language_sent'] == "true")
	{

		//set new value in database
		$db = new db();
		$result = $db->query(sprintf("UPDATE `config` SET `language` = '%s' WHERE `config`.`id` = 1;",$_POST['lang']));
		if($result)
		{
			set_notification(CHANGES_SET,"success");
			unset($_POST);
			echo "<script>window.document.location = 'admin';</script>";
		}
		if(!$result)
		{
			set_notification(DB_CONNECTION_ERROR,"danger");
			unset($_POST);
			echo "<script>window.document.location = 'admin';</script>";
		}
			
	}

}

function default_theme_selector()
{
	//get theme name  from db
	$db = new db();
	$db->query("SELECT `theme` FROM `config` WHERE `id` = 1");


	//print form
	echo "
				<form method='post'>
					<div class='form-group'>
  						<label><h4>".DEFAULT_THEME_SELECTOR_TITLE."</h4></label>";

	$files = scandir("themes", 1);
	foreach($files as $val)
	{
			
		if($val != "." AND $val != ".." AND $val != "README.txt" AND file_exists("themes"."/".$val."/config.ini"))
		{
			$array = parse_ini_file("themes"."/".$val."/config.ini");

			if($GLOBALS['theme'] == $val)
			{
				echo "<div class='radio'>
  								<label><input type='radio' name='theme' value='".$array['dir']."' checked />".$array['name']." - ".AUTHOR.": ".$array['author']."</label>
  							</div>";
			}

			if($GLOBALS['theme'] != $val)
			{
				echo "<div class='radio'>
  								<label><input type='radio' name='theme' value='".$array['dir']."'/>".$array['name']." - ".AUTHOR.": ".$array['author']."</label>
  							</div>";
			}

		}
			
	}


	echo "</div>
  				<button type='submit' class='btn btn-default' name='theme_sent' value='true'>".APPLY."</button>
			</form>";
	if(isset($_POST['theme_sent']) AND is_admin() AND $_POST['theme_sent'] == "true")
	{

		//set new value in database
		$db = new db();
		$result = $db->query(sprintf("UPDATE `config` SET `theme` = '%s' WHERE `config`.`id` = 1;",$_POST['theme']));
		if($result)
		{
			set_notification(CHANGES_SET,"success");
			echo "<script>window.document.location = 'admin';</script>";
		}
		if($result == false)
		{
			set_notification(DB_QUERY_ERROR,"danger");
			echo "<script>window.document.location = 'admin';</script>";
		}
		unset($_REQUEST);
		unset($_POST);
	}

}

function modules_selector()
{
	$db = new db();
	$db->query("SELECT `modules` FROM `config` WHERE `id` = 1");

	//print form
	echo "
				<form method='post'>
					<div class='form-group'>
  						<label><h4>".MODULES_SELECTOR_TITLE."</h4></label><br>
  						<label style='color:red;'>".RED_MODULE."</label><br>
  						<label style='color:green;'>".GREEN_MODULE."</label><br>
  						<label style='color:#005081;'>".STANDARD_MODULE."</label>
  					";

	$files = scandir("modules", 1);
	foreach($files as $val)
	{
		if($val != "." AND $val != ".." AND $val != "README.txt" AND file_exists("modules/".$val."/config.ini"))
		{
			$modules = explode(',',$GLOBALS['modules']);
			$array = parse_ini_file("modules/".$val."/config.ini");
			if(in_array($val, $modules))
			{
				if($array['priority'] == 3)
				{
					echo "<div class=checkbox'>
  									<label style='color:red;'><input type='checkbox' name='modules[]' value='".$val."' checked /> ".$array['name']." ".AUTHOR.": ".$array['author']."</label>
  									</div>";
				}
				if($array['priority'] == 2)
				{
					echo "<div class=checkbox'>
  									<label style='color:green;'><input type='checkbox' name='modules[]' value='".$val."' checked /> ".$array['name']." ".AUTHOR.": ".$array['author']."</label>
  								</div>";
				}
				if($array['priority'] == 1)
				{
					echo "<div class=checkbox'>
  									<label style='color:#005081;'><input type='checkbox' name='modules[]' value='".$val."' checked /> ".$array['name']." ".AUTHOR.": ".$array['author']."</label>
  								</div>";
				}
			}

			if(!in_array($val, $modules))
			{
				if($array['priority'] == 3)
				{
					echo "<div class=checkbox'>
  									<label style='color:red;'><input type='checkbox' name='modules[]' value='".$val."' /> ".$array['name']." ".AUTHOR.": ".$array['author']."</label>
  								</div>";
				}
				if($array['priority'] == 2)
				{
					echo "<div class='checkbox'>
  									<label style='color:green;'><input type='checkbox' name='modules[]' value='".$val."' /> ".$array['name']." ".AUTHOR.": ".$array['author']."</label>
  								</div>";
				}
				if($array['priority'] == 1)
				{
					echo "<div class='checkbox'>
  									<label style='color:#005081;'><input type='checkbox' name='modules[]' value='".$val."' /> ".$array['name']." ".AUTHOR.": ".$array['author']."</label>
  								</div>";
				}
			}
		}
	}

	echo "</div>
  				<button type='submit' class='btn btn-default' name='modules_sent' value='true'>".APPLY."</button>
			</form>";



	if(isset($_POST['modules_sent']) AND is_admin() AND $_POST['modules_sent'] == "true")
	{
		if(!empty($_POST['modules']) AND $_POST['modules'] != NULL)
		{
			$modules = implode(',',$_POST['modules']);
			$result = $db->query("UPDATE `config` SET `modules` = '".$modules."' WHERE `config`.`id` = 1");
			if($result == false)
			{
				set_notification(DB_QUERY_ERROR,"danger");
				echo "<script>window.document.location = 'admin';</script>";
			}else{
				set_notification(CHANGES_SET,"success");
				echo "<script>window.document.location = 'admin';</script>";
			}
		}else{
			$db->query("UPDATE `config` SET `modules` = '' WHERE `config`.`id` = 1");
			set_notification(CHANGES_SET,"success");
			echo "<script>window.document.location = 'admin';</script>";
		}
		unset($_REQUEST);
		unset($_POST);
	}
}

?>
