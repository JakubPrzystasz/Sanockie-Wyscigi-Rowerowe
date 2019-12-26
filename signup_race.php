<?php
		
	@require_once("core/core.php");
	
	if(is_logged())
	{
		if(isset($_GET['race_id']) AND !isset($_GET['quick_signup_user_id']))
		{
			$rows = $db->num_rows(sprintf("SELECT * FROM `races` WHERE `races`.`url_id` = '%s';",$_GET['race_id']));
			if($rows > 0)
			{
				$array = $db->fetch(sprintf("SELECT * FROM `races` WHERE `races`.`url_id` = '%s';",$_GET['race_id']));
				$user = $db->fetch(sprintf("SELECT `login`,`complete` FROM `users` WHERE `users`.`user_id` = '%s';",$_COOKIE['USER_ID']));
				$rows = $db->num_rows(sprintf("SELECT * FROM `race_%s` WHERE `race_%s`.`user_login` = '%s';",$array['url_id'],$array['url_id'],$user['login']));
				if($rows < 1)
				{
					if($user['complete'] != 0)
					{
						$today = DateTime::createFromFormat('U',time());
						$today = $today->format('Y-m-d');
						if($array['date'] >= $today)
						{
							$temp = $db->fetch_all(sprintf("SELECT * FROM `race_%s`;",$array['url_id']));
							$signed = 0;
							foreach($temp as $key => $val)
							{
								$us = $db->fetch(sprintf("SELECT `name` FROM `users` WHERE `login` = '%s'",$temp[$key]['user_login']));
								if($us['name'] != "TEST")
								{
									$signed++;
								}
							}
							if($array['signup_limit'] == NULL){$array['signup_limit'] = 1000000;}
							if($array['signup_limit'] > $signed)
							{
								$ids = $db->fetch_all(sprintf("SELECT * FROM `identificators` WHERE `id` <= %s",$array['signup_limit']));
								foreach($ids as $key => $val)
								{
									$row = $db->num_rows(sprintf("SELECT `id`,`user_id` FROM `race_%s` WHERE `race_%s`.`user_id` = '%s';",$array['url_id'],$array['url_id'],$ids[$key]['uid']));
									if($row < 1)
									{
										$available_id=$ids[$key]['uid'];
										$available_id_id=$ids[$key]['id'];
										break;
									}
								}
								if($available_id[0] != NULL)
								{
									$db->query(sprintf("INSERT INTO `race_%s` (`id`, `user_login`, `user_id`, `score`, `start`, `finish`, `insurance`) VALUES (NULL, '%s', '%s', NULL, NULL, NULL,%s);",$array['url_id'],$user['login'],$available_id,$_GET['insurance']));
									set_notification(SIGNED_DONE." ".YOUR_NUMBER.": ".$available_id,"success");
									header("Location: index");
								}else{
									set_notification(ERRNO_32, "danger");
									header("Location: index");
								}
							}else{
								set_notification(ERRNO_32, "danger");
								header("Location: index");
							}
						}else{
							set_notification(ERRNO_36,"warning");
							header("Location: index");
						}
					}else{
						set_notification(ERRNO_33, "warning");
						header("Location: index");
					}
				}else{
					$db->query(sprintf("UPDATE `race_%s` SET `insurance` = '%s' WHERE `user_login` = '%s';",$_GET['race_id'],$_GET['insurance'],$user['login']));
					set_notification(CHANGES_SET, "success");
					header("Location: index");
				}
			}else{
				set_notification(ERRNO_30, "danger");
				header("Location: index");
			}
		}
		if(isset($_GET['quick_signup_user_id']) AND !isset($_GET['race_id']) AND is_admin())
		{
			$array = $db->fetch("SELECT `url_id`,`signup_limit` FROM `races` WHERE `date` = CURDATE()");
			if($array != NULL)
			{
				$rows = $db->num_rows(sprintf("SELECT `id` FROM `race_%s`",$array['url_id']));
				$temp = $db->fetch_all(sprintf("SELECT * FROM `race_%s`;",$array['url_id']));
				$signed = 0;
				foreach($temp as $key => $val)
				{
					$us = $db->fetch(sprintf("SELECT `name` FROM `users` WHERE `login` = '%s'",$temp[$key]['user_login']));
					if($us['name'] != "TEST")
					{
						$signed++;
					}
				}
				if($array['signup_limit'] == NULL){$array['signup_limit'] = 1000000;}
				if($array['signup_limit'] > $signed)
				{
					$user = $db->fetch(sprintf("SELECT `login`,`complete` FROM `users` WHERE `id` = '%s'",$_GET['quick_signup_user_id']));
					$user_signed = $db->fetch(sprintf("SELECT `id` FROM `race_%s` WHERE `user_login` = '%s'",$array['url_id'],$user['login']));
					if($user_signed['id'] == NULL)
					{
						if($user['complete'] == 1)
						{
							$ids = $db->fetch_all(sprintf("SELECT * FROM `identificators` WHERE `id` <= %s",$array['signup_limit']));
							foreach($ids as $key => $val)
							{
								$row = $db->num_rows(sprintf("SELECT `id`,`user_id` FROM `race_%s` WHERE `race_%s`.`user_id` = '%s';",$array['url_id'],$array['url_id'],$ids[$key]['uid']));
								if($row < 1)
								{
									$available_id=$ids[$key]['uid'];
									$available_id_id=$ids[$key]['id'];
									break;
								}
							}
							if($available_id[0] != NULL)
							{
								$db->query(sprintf("INSERT INTO `race_%s` (`id`, `user_login`, `user_id`, `score`, `start`, `finish`, `insurance`) VALUES (NULL, '%s', '%s', NULL, NULL, NULL,NULL);",$array['url_id'],$user['login'],$available_id));
								$message = QUICK_SIGNUP_DONE."<br>".REGISTER_NUMBER.": ".$available_id_id;
								echo json_encode(array('content' => $message, 'type' => 'alert alert-success'));
							}else{
								echo json_encode(array('content' => ERRNO_32, 'type' => 'alert alert-danger'));
							}
						}else{
							echo json_encode(array('content' => "<a href='index.php?site=edit_user&user_id=".$_GET['quick_signup_user_id']."'>".INCOMPLETE_ALERT."</a>", 'type' => 'alert alert-danger'));
						}
					}else{
						echo json_encode(array('content' => ERRNO_47, 'type' => 'alert alert-danger'));
					}
				}else{
					echo json_encode(array('content' => ERRNO_32, 'type' => 'alert alert-danger'));
				}
			}else{
				echo json_encode(array('content' => ERRNO_30, 'type' => 'alert alert-danger'));
			}
		}else{
			header("Location:index");
		}
	}else{
		set_notification(ERRNO_18, "warning");
		header("Location: login");
	}
?>