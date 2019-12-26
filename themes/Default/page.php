<?php
	
 	
	if(!isset($_COOKIE['lang']))
	{
		$language = $_SESSION['language'];
	}
	if(isset($_COOKIE['lang']))
	{
		$language = $_COOKIE['lang'];
	}

	$url[] = "scores";
	$url[] = "signed";
	$url[] = "classification";
	
	$addr = explode('_',$_GET['site']);
	
	if(isset($addr[0]))
	{
		$rows = $db->num_rows(sprintf("SELECT * FROM `urls` WHERE `urls`.`url` = '%s';",$addr[0]));
		if($rows > 0)
		{
			$array = $db->fetch_all(sprintf("SELECT * FROM `urls` WHERE `urls`.`url` = '%s';",$addr[0]));
			foreach($array as $key => $val)
			{
				if(in_array("race",$array[$key]))
				{
					$data = $db->fetch(sprintf("SELECT * FROM `articles` WHERE `articles`.`url` = '%s' AND `language` = '".$language."';",$array[$key]['url']));
					if($data != NULL)
					{
						$type = "race_description"; 
						$page_name = $data['title']." - ".EVENT_DESCRIPTION;
					}
					if($data == NULL)
					{
						$type = "race_description";
						$page_name = EVENT_DESCRIPTION;
					}
					break;
				}
				else if(in_array("article",$array[$key]))
				{
					$data = $db->fetch(sprintf("SELECT * FROM `articles` WHERE `articles`.`url` = '%s' AND `language` = '".$language."';",$array[$key]['url']));
					if($data != NULL)
					{
						$type = "article";
						$page_name = $data['title'];
					}
					if($data == NULL)
					{
						@require_once("404.php");
						exit;
					}
					break;
				}
				else if(in_array("classification",$array[$key]))
				{
					$data = $db->fetch(sprintf("SELECT * FROM `classifications` WHERE `url` = '%s';",$addr[0]));
					if($data != NULL)
					{
						$type = "classification";
						$page_name = $data['name'];
					}
					if($data == NULL)
					{
						@require_once("404.php");
						exit;
					}
					break;
				}
			}
			if(isset($addr[1]))
			{
				if(in_array($addr[1],$url))
				{
					if($addr[1] == "scores")
					{
						$data = $db->fetch(sprintf("SELECT * FROM `races` WHERE `races`.`url` = '%s';",$addr[0]));
						$type = "scores";
						$page_name = $data['name']."<br><b>".SCORES."</b>";
					}
					if($addr[1] == "signed")
					{
						$data = $db->fetch(sprintf("SELECT * FROM `races` WHERE `races`.`url` = '%s';",$addr[0]));
						$type = "signed";
						$page_name = $data['name']."<br><b>".SIGNED_IN_LIST."</b>";
					}
					if($addr[1] == "classification")
					{
						$type = "classification";
						$page_name = GENERAL_CLASSIFICATION."<br><b>".$data['name']."</b>";
					}
				}else{
					@require_once("404.php");
					exit;
				}
				if(isset($addr[2]))
				{
					$categories = $db->fetch_all("SELECT `name` FROM `categories`");
					$cat = array();
					foreach($categories as $val => $key)
					{
						array_push($cat,$key['name']);
					}
					if(!in_array($addr[2], $cat))
					{
						@require_once("404.php");
						exit;
					}
				}
			}
		}else{
			@require_once("404.php");
			exit;
		}
	}else{
		@require_once("404.php");
		exit;
	}	

	@require_once("header.php");
?>
		
		<div id="main">
			<div class="jumbotron" style="text-align:center;margin:auto;">
				<?php 
				
					if($type == "article")
					{
						if($data['text'] != NULL)
						{
							echo $data['text'];
						}else{
							echo NO_DESC;
						}
					}
					
					if($type == "race_description")
					{
						echo '<div class="modal fade" id="signup_race_modal" role="dialog">
		    					<div class="modal-dialog">
		      						<div class="modal-content">
		        						<div class="modal-header">
		          							<button type="button" class="close" data-dismiss="modal">&times;</button>
		        						</div>
		        						<div class="modal-body" id="signup_race_modal_body">
		        						</div>
		        						<div class="modal-footer">
		         							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CLOSE; ?></button>
		        						</div>
		      						</div>
	   							</div>
							</div>';
						if($data['text'] != NULL)
						{
							echo $data['text'];
						}else{
							echo NO_DESC;
						}
						if(is_logged())
						{
							$array = $db->fetch(sprintf("SELECT `url_id` FROM `races` WHERE `url` = '%s'",$addr[0]));
							$race_id = $array['url_id'];
							$signed = "<a href='#' onclick='$(`#signup_race_modal`).modal(`show`);signup_race_modal(".$race_id.")'>".SIGN_UP."</a>";
						}
						echo "<div class='row'>
								<div class='col col-md-4'>
									<h4><a href='".$addr[0]."_signed'>".SIGNED_IN_LIST."</a></h4>
								</div>
								<div class='col col-md-4'>
									<h4>".$signed."</h4>
								</div>
								<div class='col col-md-4'>
									<h4><a href='".$addr[0]."_scores'>".SCORES."</a></h4>
								</div>
							</div>";
					}
					
					if($type == "signed")
					{
						$count = 0;
						$signed = $db->fetch_all(sprintf("SELECT * FROM race_%s",$data['url_id']));
						foreach($signed as $key=>$val)
						{
							$user = $db->fetch(sprintf("SELECT `name` FROM `users` WHERE `login` = '%s'",$signed[$key]['user_login']));
							if($user['name'] != "TEST")
							{
								$count++;
							}
						}
						if($count > 0)
						{
						 echo "<span><b>".SIGNED_IN_COUNT.": </b>".$count."</span>";
						}
						echo "<div id='signed_table' class='table-condensed table-hover table-responsive'></div>
								<script>
									get_signed(`".$data['url_id']."`);
							</script>";
					}
	
					if($type == "scores")
					{
						echo "<div id='scores_table' class='table-condensed table-hover table-responsive'></div>
								<script>
									get_scores(`".$data['url_id']."`,`".$addr[2]."`);
							</script>";
					}
					if($type == "classification")
					{
						echo "<div id='scores_table' class='table-condensed table-hover table-responsive'></div>
								<script>
									get_classification(`".$data['url']."`,`".$addr[2]."`);
							</script>";
					}
					
				?>
			</div>			
		</div>

<?php @require_once("footer.php"); ?>