<?php @require_once("core/core.php"); ?>
<!DOCTYPE HTML>
<html>
	<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="<?php author(); ?>">
		<meta name="description" content="<?php description(); ?>">
		<meta name="keywords" content="<?php keywords(); ?>">
		<meta name="application-name" content="<?php title(); ?>">
		
		<title><?php title(); ?></title>

		<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png">
		<link rel="stylesheet" href="<?php theme_dir(); ?>css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php theme_dir(); ?>css/style.css">
 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
  		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  		
  		<script src="<?php theme_dir(); ?>script.js"></script>

	</head>
	<body>
		
		<div class="container">
			<div class="page-header">
				<div class="row">
					 <div class="col-md-5">
					 	<h2> <?php full_title(); ?><br>
						<small><?php echo $page_name; ?></small></h2>
					</div>
					<div class="col-md-3">
						<img alt="logo" src="/img/logo.png" class="media-object" style="margin:auto;padding-top:25px;">
					</div>
					<div class="col-md-4" style="text-align:center;">
						<?php 
							if(is_logged())
							{
								$user = $db->fetch(sprintf("SELECT `login` FROM `users` WHERE `user_id` = '%s';",$_COOKIE['USER_ID']));
								echo "<h4>".GREETING."!</h4>".PHP_EOL;
								echo YOU_LOGGED_AS.": ".$user['login'];
							}
						?>
					</div>
				</div>
			</div>
			
 		<nav class="navbar navbar-inverse navbar-fixed-top">
 		
  			<div class="container-fluid">
    			<div class="navbar-header">
    			
         			<button type="button" data-target="#top_nav" class="navbar-toggle" data-toggle="collapse">
        				<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
      				</button>
      				<a data-target="#top_nav" data-toggle="collapse"  class="visible-xs navbar-brand" href="#">Menu</a>
      				
			    </div>
			    
    			<div class="collapse navbar-collapse" id="top_nav">
    			
     			 	<ul class="nav navbar-nav navbar-left">
     			 	<?php 
     			 	if($page_name == MAIN_PAGE)
     			 	{
     			 		echo "<li class='active'><a href='index' class='navbar-link'>".MAIN_PAGE."</a></li>";
     			 	}else{
     			 		echo "<li><a href='index' class='navbar-link'>".MAIN_PAGE."</a></li>";
     			 	}
     			 	
     			 	if($page_name == UPCOMING_EVENTS)
     			 	{
     			 		echo "<li class='active'><a href='upcoming' class='navbar-link'>".UPCOMING_EVENTS."</a></li>";
     			 	}else{
     			 		echo "<li><a href='upcoming' class='navbar-link'>".UPCOMING_EVENTS."</a></li>";
     			 	}
					if($page_name == RULES)
     			 	{
     			 		echo "<li class='active'><a href='rules' class='navbar-link'>".RULES."</a></li>";
     			 	}else{
     			 		echo "<li><a href='rules' class='navbar-link'>".RULES."</a></li>";
     			 	}
     			 	
     			 	if($page_name == SCORES)
     			 	{
     			 		echo "<li class='active'><a href='scores' class='navbar-link'>".SCORES."</a></li>";
     			 	}else{
     			 		echo "<li><a href='scores' class='navbar-link'>".SCORES."</a></li>";
     			 	}
					
     			 	if(is_admin())
     			 	{
     			 		$race = $db->num_rows("SELECT `url` FROM `races` WHERE `date` = CURDATE()");
     			 		if($race > 0)
     			 		{
     			 			setcookie("USER_ID",$_COOKIE['USER_ID'],time()+86400);
     			 			if($page_name == RACE_MANAGER)
     			 			{
     			 				echo "<li class='active'><a href='race_manager' class='navbar-link'>".RACE_MANAGER."</a></li>";
     			 			}else{
     			 				echo "<li><a href='race_manager' class='navbar-link' style='background:#575757'>".RACE_MANAGER."</a></li>";
     			 			}
     			 		}
     			 		if($page_name == ADMIN_PAGE)
     			 		{
     			 			echo "<li class='active'><a href='admin' class='navbar-link'>".ADMIN_PAGE."</a></li>";
     			 		}else{
     			 			echo "<li><a href='admin' class='navbar-link'>".ADMIN_PAGE."</a></li>";
     			 		}
     			 	}
     			 	
     			 	if(is_logged())
     			 	{
						if($page_name == SETTINGS)
     			 		{
     			 			echo "<li class='active'><a href='settings' class='navbar-link'>".SETTINGS."</a></li>";
     			 		}else{
     			 			echo "<li><a href='settings' class='navbar-link'>".SETTINGS."</a></li>";
     			 		}
     			 	}
     			 	?>
     				 </ul>
     			 
     		 		<div class="nav navbar-form navbar-right">
	     				<div class="form-group">
	        				<input data-toggle="popover" data-content="<?php echo TYPE_TEXT;?>" data-placement="bottom" type="text" id="search_box" class="form-control" placeholder="<?php echo SEARCH_PLACEHOLDER; ?>">
	      				</div>
	      				<button type="submit" id="search_button" class="btn btn-default">
	      					<i class="glyphicon glyphicon-search"></i> <?php echo SEARCH; ?>
	      				</button>
      				</div>
    			
     				<ul class="nav navbar-nav navbar-right">
     					<li>
     						<?php 
     							if(is_logged())
     							{
     								echo "<a href='logout' class='navbar-link'><span class='glyphicon glyphicon-log-out'></span> ".LOGOUT." </a>";
     							}
     							if(!is_logged())
     							{
     								echo "<a href='login' class='navbar-link'><span class='glyphicon glyphicon-log-in'></span> ".LOGIN." </a>";
     							}
     						?>
     					</li>
      				</ul>
      				
 		  		</div>
  			</div>
		</nav>
		
		<div class="modal fade" id="search_modal" role="dialog">
    		<div class="modal-dialog">
      			<div class="modal-content">
        			<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal">&times;</button>
         				<h4 class="modal-title" id="search_header"></h4>
        			</div>
        			<div class="modal-body" id="search_body">
        			</div>
        			<div class="modal-footer">
         				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CLOSE; ?></button>
        			</div>
      			</div>
   			 </div>
		</div>
		
