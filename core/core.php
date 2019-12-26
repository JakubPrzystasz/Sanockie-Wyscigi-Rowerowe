<?php
	//start session
	@session_start();

	//load config 
	@require_once(dirname( __FILE__ )."/root.php");
	
	//require other files
	{
	@require_once(dirname(__FILE__)."/user_interface.php");
	@require_once(dirname(__FILE__)."/admin.php");
	}
	

	/* LOAD MODULES */
	{
	$module = explode(',',$GLOBALS['modules']);
	foreach($module as $val)
	{
		if(file_exists("modules/".$val."/config.ini"))
		{
			$config = parse_ini_file("modules/".$val."/config.ini");
			$includes = explode(',',$config['includes']);
			foreach($includes as $inc)
			{
				if(file_exists("modules/".$val."/".$inc))
				{
					@require_once("modules/".$val."/".$inc);				
				}
			}
		}
	}
	
	
	}	

	/* MULTI LANGUAGE SUPPORT */
	function load_language()
	{
	$base_dir = dirname(__DIR__);
	//default lang dir
	$default_lang_dir = $base_dir."/lang/".$_SESSION['language']."/translation.php";
	//custom lang dir
	if(isset($_COOKIE['lang'])) $custom_lang_dir = $base_dir."/lang/".$_COOKIE['lang']."/translation.php";
	//looking for cookie lang if not exists use default language
	if(file_exists($default_lang_dir))
	{
		if(!isset($_COOKIE['lang']))
		{ 
			@require_once($default_lang_dir);
		}
		//if cookie lang exists
		if(isset($_COOKIE['lang']))
		{ 
			if(file_exists($custom_lang_dir))
			{
				@require_once($custom_lang_dir);
			}
			if(!file_exists($custom_lang_dir))
			{
				@require_once($default_lang_dir);	
			}
		}
	}
	//translation files exists ?
	if(!file_exists($default_lang_dir))
	{
		echo $default_lang_dir;
		echo "<h1 style='color:red;'>CRITICAL ERROR! TRANSLATION FILES DOES NOT EXISTS!</h1>";
		exit;
	}
	
	}
	load_language();
	
	/* OTHER FUNCTIONS */
	function is_logged()
	{
		if(isset($_COOKIE['USER_ID']))
		{
			if($_COOKIE['USER_ID'] != "")
			{
				$db = new db();
				if(($db->num_rows(sprintf("SELECT `user_id` FROM `users` WHERE `user_id` = '%s'",$_COOKIE['USER_ID']))) != 0)
				{
					return  true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	
	function is_admin()
	{
		if(is_logged())
		{
			$db = new db();
			$array = $db->fetch(sprintf("SELECT `permissions_level` FROM `users` WHERE `users`.`user_id` = '%s'",$_COOKIE['USER_ID']));
			if($array['permissions_level'] == 1)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function make_url_id()
	{
		$random = rand(0,100000);
		return $random;
		$db = new db();
		$query = $db->num_rows(sprintf("SELECT `url_id` FROM `urls` WHERE `urls`.`url_id` = '%s';",$random));
		if($query != 0)
		{
			make_url_id();
		}else{
			return $random;
		}
	}
	
	{

	function title()
	{
		echo $_SESSION['title'];
	}
	function  full_title()
	{
		echo $_SESSION['full_name'];	
	}
	function  language()
	{
		echo $_SESSION['language'];	
	}
	function  theme()
	{
		echo $_SESSION['theme'];	
	}
	function  modules()
	{
		echo $_SESSION['modules'];	
	}
	function  author()
	{
		echo $_SESSION['author'];	
	}
	function  description()
	{
		echo $_SESSION['description'];	
	}
	function  keywords()
	{
		echo $_SESSION['keywords'];	
	}
	function  notify()
	{
		if(isset($_COOKIE['notification']))
		{
			echo "<div class='modal fade' id='notification' role='dialog'>
    				<div class='modal-dialog'>";
			$array = json_decode($_COOKIE['notification'], true);
			$notification_type = $array[1];
			$notification = $array[0];
			switch($notification_type)
				{
					case "success":
						printf("<div id='notification' class='alert alert-success alert-dismissable'>
  									<button class='close' data-dismiss='modal' aria-label='close'>&times;</button>
  									%s
								</div>",$notification);
						break;
					case "notification":
						printf("<div id='notification' class='alert alert-info alert-dismissable'>
  									<button class='close' data-dismiss='modal' aria-label='close'>&times;</button>
  									%s
								</div>",$notification);
						break;
					case "warning":
						printf("<div id='notification' class='alert alert-warning alert-dismissable'>
  									<button class='close' data-dismiss='modal' aria-label='close'>&times;</button>
  									%s
								</div>",$notification);
						break;
					case "danger":
						printf("<div id='notification' class='alert alert-danger alert-dismissable'>
  									<button class='close' data-dismiss='modal' aria-label='close'>&times;</button>
  									%s
								</div>",$notification);
						break;
					default:
						printf("<div id='notification' class='alert alert-info alert-dismissable'>
  									<button class='close' data-dismiss='modal' aria-label='close'>&times;</button>
  									%s
								</div>",$notification);
						break;
				}
				
			echo "</div>
				</div>
					
				<script>
					$('#notification').modal('show');						
					setTimeout(function(){ $('#notification').modal('hide'); },3000);	
					$('#notification').click(function(){
						$('#notification').modal('hide');
					});
				</script>";
			setcookie("notification","",time()-10);
		}
	}
	function set_notification($string,$type)
	{
		setcookie("notification",json_encode(array($string,$type)),time()+1);
	}
	function theme_dir()
	{
		echo "themes/".$GLOBALS['theme']."/";
	}
	function lang_dir()
	{
		return "lang/";
	}
	}
	
	function visits_count()
	{
		$db = new db();
		$array = $db->num_rows("SELECT * FROM `statistics` WHERE `date` = CURDATE() ");
		if($array < 1)
		{
			$db->query("INSERT INTO `statistics` (`id`, `unique_visits`, `visits`, `date`) VALUES (NULL, '0', '0', CURDATE());");
			if(isset($_COOKIE['visit']))
			{
				$db->query("UPDATE `statistics` SET `visits` = '1' WHERE `date` = CURDATE();");
			}else{
				setcookie("visit",1,time()+60*60*24*30);
				$db->query("UPDATE `statistics` SET `unique_visits` = '1' WHERE `date` = CURDATE();");
			}
		}else{
			$visits = $db->fetch("SELECT * FROM `statistics` WHERE `date` = CURDATE() ");
			if(isset($_COOKIE['visit']))
			{
				$visits['visits']++;
				$db->query(sprintf("UPDATE `statistics` SET `visits` = '%s' WHERE `date` = CURDATE();",$visits['visits']));
			}else{
				setcookie("visit",1,time()+60*60*24*30);
				$visits['unique_visits']++;
				$db->query(sprintf("UPDATE `statistics` SET `unique_visits` = '%s' WHERE `date` = CURDATE();",$visits['unique_visits']));
			}
		}
	}
	
	

?>
