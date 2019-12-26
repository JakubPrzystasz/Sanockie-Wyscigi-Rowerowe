<?php
	if (! isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == 'off' ) {
	    $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    header("Location: $redirect_url");
	    exit();
	}

	@require_once(dirname( __FILE__ )."/core/core.php");
	
	visits_count();
	
	if(isset($_GET['site']))
	{
		if(file_exists(dirname( __FILE__ )."/themes/".$GLOBALS['theme']."/".$_GET['site'].".php"))
		{
			@require_once (dirname( __FILE__ )."/themes/".$GLOBALS['theme']."/".$_GET['site'].".php");
		}else{
			$addr = explode('_',$_GET['site']);
			$db = new db();
			if($db->num_rows(sprintf("SELECT `url` FROM `urls` WHERE `urls`.`url` = '%s'",$addr[0])) != 0)
			{
				@require_once (dirname( __FILE__ )."/themes/".$GLOBALS['theme']."/page.php");
			}else{
				@require_once (dirname( __FILE__ )."/themes/".$GLOBALS['theme']."/404.php");
			}
		}
	}else{
		@require_once (dirname( __FILE__ )."/themes/".$GLOBALS['theme']."/index.php");
	}

?>
