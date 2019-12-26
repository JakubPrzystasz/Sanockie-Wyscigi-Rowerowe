<?php

	require_once("core/core.php");
	if(is_logged())
	{
		$data = $db->fetch(sprintf("SELECT * FROM `races` WHERE url_id = %s;",$_POST['race_id']));
		$user = $db->fetch(sprintf("SELECT `login`,`sex`,`birth_date` FROM `users` WHERE `user_id` = '%s'",$_COOKIE['USER_ID']));
		$user_data = $db->fetch(sprintf("SELECT `insurance`,`user_id` FROM `race_%s` WHERE `user_login` = '%s' ",$_POST['race_id'],$user['login']));
		if($data != NULL)
		{
			$categories = $db->fetch_all("SELECT * FROM `categories`");
			$all_cat = array();
			foreach($categories as $key => $val)
			{
				array_push($all_cat, $val);
			}
			$race_cat = explode(',',$data['categories']);
			$categories = array();
			foreach($race_cat as $key => $val)
			{
				foreach($all_cat as $key2 => $val2)
				{
					if(in_array($val,$val2))
					{
						array_push($categories,$val2);
					}
				}
			}
			$race_cat = NULL;
			$all_cat = NULL;
			$user['categories'] = array();
			foreach($categories as $key => $val)
			{
				$byear = explode('-',$user['birth_date']);
				$now = new DateTime();
				$now = $now->format('Y');
				$age = $now - $byear[0];
				$byear = NULL; $now = NULL;
				$sex = false;
				if($val['sex'] == "both"){$sex = true;}
				if($val['sex'] == $user['sex']){$sex = true;}
				if($age >= $val['age_begin'] AND $age <= $val['age_end'] AND $sex == true)
				{
					array_push($user['categories'], $val['name']);
				}
			}
			$categories = NULL;
			if($user_data != NULL)
			{
				if($user_data['insurance'] == 1)
				{
					$checked = "checked";
				}
				if($user_data['insurance'] == 0)
				{
					$checked = "";
				}
				$APPLY = APPLY;
				$ALREADY = ALREADY_SIGNED."<br>".YOUR_NUMBER.": ".$user_data['user_id'];
			}else{
				$ALREADY = "";
				$checked = "";
				$APPLY = SIGN_UP;
			}
			$now = new DateTime("today");
			$race_date = new DateTime($data['date']);
			$difference = $race_date->diff($now);
			$signed = 0;
			if($now <= $race_date)
			{
				$temp = $db->fetch_all(sprintf("SELECT * FROM `race_%s`;",$_POST['race_id']));
				if($temp != NULL) {
					foreach($temp as $key => $val)
					{
						$usr = $db->fetch(sprintf("SELECT `name` FROM `users` WHERE `login` = '%s'",$temp[$key]['user_login']));
						if($usr['name'] != "TEST")
						{
							$signed++;
						}
					}
				} else {
					$signed = 0;
				}
				unset($usr);
				unset($temp);
				if($data['signup_limit'] == NULL){$tickets = $db->num_rows("SELECT `id` FROM `identificators`")-$signed;}
				else{
					$tickets = $data['signup_limit'] - $signed;
				}
				echo "<p><b><h3>".$ALREADY."</h3></b></p>";
				echo "<p><b>".RACE_NAME.":</b> ".$data['name']."<p>";
				echo "<p><b>".RACE_ORGANIZER.":</b> ".$data['organizer']."<p>";
				echo "<p><b>".RACE_DATE.":</b> ".$data['date']." (".IN_FUTURE." ".$difference->format('%a')." ".DAYS.")<p>";
				echo "<p><b>".AVAILABLE_TICKETS.": </b>".$tickets."</p>";
				echo "<p><b>".CATEGORIES_SIGNUP_LIST.":</b><br>";
				foreach($user['categories'] as $key => $val)
				{
					echo "<span style='font-size:15px;'> ".$val." </span>";
				}
				echo "<p><a class='btn btn-primary' onclick='var insurance = 0; if($(`#insurance`).is(`:checked`)){var insurance = 1;}window.location = `signup_race.php?race_id=".$data['url_id']."&insurance=`+insurance;'>".$APPLY."</a></p>";
			}else{
				echo ERRNO_36;
			}
		}else{
			echo ERRNO_38;
		}
	}else{
		header("Location: login");
		set_notification(ERRNO_18, "warning");
		exit;
	}
?>
