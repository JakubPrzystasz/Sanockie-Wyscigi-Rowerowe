<?php
		
//	function sort_array(&$array,$key)
//	{
//		$temp = array();
//		foreach($array as $k => $val)
//		{
//			$temp[$k] = $val[$key];
//		}
//		arsort($temp);
//		$return = array();
//		foreach($temp as $k => $val)
//		{
//			$return[$k] = $array[$k];
//		}
//		$array = $return;
//	}
//
//	function sort_key(&$array,&$keys)
//	{
//		$temp = array();
//		$races = array();
//		$user = array();
//		foreach($array as $key => $val)
//		{
//			foreach($val as $k => $v)
//			{
//				if(in_array($k,$keys))
//				{
//					$races[$k] = $v;
//				}else{
//					$user[$k] = $v;
//				}
//				$temp[$key] = array_merge($races,$user);
//			}
//		}
//		$array = $temp;
//	}
	
	if(isset($_SERVER['HTTP_REFERER']))
	{
		if(isset($_POST['race_id']))
		{
			@require_once(dirname( __FILE__ )."/core/core.php");
			$db = new db();
			
			if($_POST['table'] == "signed")
			{
				$race = $db->fetch(sprintf("SELECT `categories` FROM `races` WHERE `url_id` = '%s'",$_POST['race_id']));
				$race = explode(',',$race['categories']);
				foreach($race as $key=>$val){
                    $categories[] = $db->fetch(sprintf("SELECT * FROM `categories` WHERE `name` = '%s'",$val));
				};
				unset($race);
				$rows = $db->num_rows(sprintf("SELECT * FROM `race_%s`",$_POST['race_id']));
				if($rows > 0)
				{
					if(is_admin())
					{
                        $array = $db->fetch_all(sprintf("SELECT `user_login`,`user_id` FROM `race_%s`;",$_POST['race_id']));
                        echo "<table class='table table-responsive table-condensed table-hover'>
							<thead>
								<tr>
									<th>".NAME."</th>
									<th>".SURNAME."</th>
									<th>".NUMBER."</th>
									<th>".CATEGORIES."</th>
								</tr>
							</thead>
							<tbody>
							";
                        foreach($array as $key => $val)
                        {
                            $user = $db->fetch(sprintf("SELECT `name`,`surname`,`birth_date`,`sex` FROM `users` WHERE `users`.`login` = '%s';",$array[$key]['user_login']));
                            $user['birth_date'] = date_create_from_format('Y-m-d', $user['birth_date']);
                            $user['age'] = date('Y')-$user['birth_date']->format("Y");
                            unset($user['birth_date']);
                            foreach ($categories as $key2=>$val){
                                if($val['age_begin'] <= $user['age'] && $val['age_end'] >= $user['age'] && (($user['sex'] == $val['sex']) || $val['sex'] == "both")){
                                    $cats[] = $val['name'];
                                }
                            }
                            $user['category'] = implode(',',$cats);
                            unset($cats);
                            $id = $db->fetch(sprintf("SELECT `id` FROM `identificators` WHERE `identificators`.`uid` = '%s';",$array[$key]['user_id']));
                            echo "<tr>
								<td>".$user['name']."</td>
								<td>".$user['surname']."</td>
								<td>".$id['id']."</td>
								<td>".$user['category']."</td>
							</tr>";
                        }
                        echo "</tbody>
						</table>";
					}else{
						$array = $db->fetch_all(sprintf("SELECT `user_login`,`user_id` FROM `race_%s`;",$_POST['race_id']));
						echo "<table class='table table-responsive table-condensed table-hover'>
							<thead>
								<tr>
									<th>".NAME."</th>
									<th>".SURNAME."</th>
									<th>".NUMBER."</th>
									<th>".CATEGORIES."</th>
								</tr>
							</thead>
							<tbody>
							";
						foreach($array as $key => $val)
						{
							$user = $db->fetch(sprintf("SELECT `name`,`surname`,`birth_date`,`sex` FROM `users` WHERE `users`.`login` = '%s';",$array[$key]['user_login']));
                            $user['birth_date'] = date_create_from_format('Y-m-d', $user['birth_date']);
                            $user['age'] = date('Y')-$user['birth_date']->format("Y");
                            unset($user['birth_date']);
                            foreach ($categories as $key2=>$val){
                            	if($val['age_begin'] <= $user['age'] && $val['age_end'] >= $user['age'] && (($user['sex'] == $val['sex']) || $val['sex'] == "both")){
                            		$cats[] = $val['name'];
								}
							}
                            $user['category'] = implode(',',$cats);
                            unset($cats);
							if($user['name'] != "TEST")
							{
								$id = $db->fetch(sprintf("SELECT `id` FROM `identificators` WHERE `identificators`.`uid` = '%s';",$array[$key]['user_id']));
								echo "<tr>
									<td>".$user['name']."</td>
									<td>".$user['surname']."</td>
									<td>".$id['id']."</td>
									<td>".$user['category']."</td>
								</tr>";
							}
						}
						echo "</tbody>
						</table>";
					}
				}else{
					echo "<h2>".ERRNO_34."</h2>";
				}
			}
			if($_POST['table'] == "scores")
			{
				$race = $db->fetch(sprintf("SELECT `categories`,`url`,`hidden_scores` FROM `races` WHERE `url_id` = '%s'",$_POST['race_id']));
				if($race['hidden_scores'] > 0 && is_admin() == false)
				{
					echo "<h2>Wyniki nie są jeszcze dostępne</h2>";
					exit;
				}
                $all_categories = $db->fetch_all(sprintf("SELECT `name` FROM `categories`"));
				$race_categories = explode(',',$race['categories']);
				$all_cat = array();
				foreach($all_categories as $val => $key)
				{
					array_push($all_cat, $key['name']);
				}
				foreach($race_categories as $val => $key)
				{
					if(in_array($key, $all_cat))
					{ 
						echo " <a href='".$race['url']."_"."scores"."_".$key."'><button type='button' class='btn btn-default'>".$key."</button></a> ";
					}
				}
				
				if($_POST['category'] != NULL)
				{
					$category = $db->fetch(sprintf("SELECT * FROM `categories` WHERE `name` = '%s'",$_POST['category']));
					$category['year_begin'] = date('Y') - $category['age_begin'];
					$category['year_end'] = date('Y') - $category['age_end'];

					$array = $db->fetch_all(sprintf("SELECT * FROM `race_%s` WHERE `score` != '0' AND `finish` > 0 ORDER BY `score` ASC",$_POST['race_id']));
					
					$comp = array();
					if(!isset($array)){echo "<br><h2>".NO_RESULTS."</h2>";exit;}
					foreach($array as $key => $val)
					{
						$user = $db->fetch(sprintf("SELECT `name`,`surname`,`sex`,`birth_date` FROM `users` WHERE `users`.`login` = '%s';",$array[$key]['user_login']));
						if(is_admin() == true)
						{
							$byear = explode('-',$user['birth_date']);
							$now = new DateTime();
							$now = $now->format('Y');
							$age = $now - $byear[0];
							$id = $db->fetch(sprintf("SELECT `id` FROM `identificators` WHERE `identificators`.`uid` = '%s';",$array[$key]['user_id']));
							$time = DateTime::createFromFormat('U.u', number_format($array[$key]['score'], 6, '.', ''));
							$first = $time->format("H:i:s.");
							$second = $time->format("u");
							$second = str_split($second, 3);
							$formatted_time = $first.$second[0];

							if(!isset($comp[0]))
							{
								$loss = "+00:00:00.000";
							}else{
								$diff = $array[$key]['score'] - $comp[0][6];
								$time = DateTime::createFromFormat('U.u', number_format($diff, 6, '.', ''));
								$first = $time->format("+H:i:s.");
								$second = $time->format("u");
								$second = str_split($second, 3);
								$loss = $first.$second[0];
							}
							$sex = false;
							if($category['sex'] == "both"){$sex = true;}
							else if($category['sex'] == $user['sex']){$sex = true;}
							if($age >= $category['age_begin'] AND $age <= $category['age_end'] AND $sex == true)
							{
                                $index = count($comp);
                                $index = $index - 1;
                                if ($comp == NULL) {
									$points = 50;
								}elseif (count($comp) == 1){
                                  	$points = 46;
                                }elseif (count($comp) > 1 && count($comp) < 6){
                                    $points = $comp[$index][5]-3;
								}elseif (count($comp) > 5 && count($comp) < 15){
									$points = $comp[$index][5]-2;
								}elseif (count($comp) == 15){
                                   	$points = 15;
								}elseif (count($comp) > 15 && count($comp) < 31){
                                   	$points = $comp[$index][5]-1;
                                }else{
                                   	$points = 0;
								}
								$position = count($comp) + 1;
								$comp[] = array($user['name'],$user['surname'],$id['id'],$loss,$formatted_time,$points,$array[$key]['score'],$position);
							}
						}else{
							if($user['name'] != "TEST")
							{
								$byear = explode('-',$user['birth_date']);
								$now = new DateTime();
								$now = $now->format('Y');
								$age = $now - $byear[0];

								$id = $db->fetch(sprintf("SELECT `id` FROM `identificators` WHERE `identificators`.`uid` = '%s';",$array[$key]['user_id']));
								$time = DateTime::createFromFormat('U.u', number_format($array[$key]['score'], 6, '.', ''));
								$first = $time->format("H:i:s.");
								$second = $time->format("u");
								$second = str_split($second, 3);
								$formatted_time = $first.$second[0];

								if(!isset($comp[0]))
								{
									$loss = "+00:00:00.000";
								}else{
									$diff = $array[$key]['score'] - $comp[0][6];
									$time = DateTime::createFromFormat('U.u', number_format($diff, 6, '.', ''));
									$first = $time->format("+H:i:s.");
									$second = $time->format("u");
									$second = str_split($second, 3);
									$loss = $first.$second[0];
								}
								$sex = false;
								if($category['sex'] == "both"){$sex = true;}
								else if($category['sex'] == $user['sex']){$sex = true;}
								if($age >= $category['age_begin'] AND $age <= $category['age_end'] AND $sex == true) {
                                    $index = count($comp);
                                    $index = $index - 1;
                                    if ($comp == NULL) {
                                        $points = 50;
                                    }elseif (count($comp) == 1){
                                    	$points = 46;
                                	}elseif (count($comp) > 1 && count($comp) < 6){
                                        $points = $comp[$index][5]-3;
									}elseif (count($comp) > 5 && count($comp) < 15){
										$points = $comp[$index][5]-2;
									}elseif (count($comp) == 15){
                                    	$points = 15;
									}elseif (count($comp) > 15 && count($comp) < 31){
                                    	$points = $comp[$index][5]-1;
                                	}else{
                                    	$points = 0;
									}
									$position = count($comp) + 1;
									$comp[] = array($user['name'],$user['surname'],$id['id'],$loss,$formatted_time,$points,$array[$key]['score'],$position);
								}
							}
						}
					}
					
					$array = $db->fetch_all(sprintf("SELECT * FROM `race_%s` WHERE `score` IS NULL && `finish` = '0' ORDER BY `score` ASC",$_POST['race_id']));
					if($array != NULL)
					{
						$dnf_comp = array();
						foreach($array as $key => $val)
						{
							$user = $db->fetch(sprintf("SELECT `name`,`surname`,`sex`,`birth_date` FROM `users` WHERE `users`.`login` = '%s';",$array[$key]['user_login']));
							$id = $db->fetch(sprintf("SELECT `id` FROM `identificators` WHERE `identificators`.`uid` = '%s';",$array[$key]['user_id']));
							$sex = false;
							if($category['sex'] == "both"){$sex = true;}
							else if($category['sex'] == $user['sex']){$sex = true;}
							if($age >= $category['age_begin'] AND $age <= $category['age_end'] AND $sex == true)
							{
								$dnf_comp[] = array($user['name'],$user['surname'],$id['id']);
							}
						}
					}
					$sex = $category['sex'];
					if($sex == "both"){$sex = UNISEX;}
					if($sex == "man"){$sex = MANS;}
					if($sex == "women"){$sex = WOMENS;}
					
					echo "<p><b>".CATEGORY_NAME.":</b> ".$_POST['category']."</p>";
					echo "<p><span><b>".$sex." ".IN_AGE.": </b>".$category['age_begin']." - ".$category['age_end']." ".YEARS."</span></p>";
                    echo "<p><span><b>".YEARS_.": </b>".$category['year_end']." - ".$category['year_begin']."</span></p>";

					if(is_admin())
					{
						$admin = "<th>Reset</th>";
					}else{
						$admin = NULL;
					}
					if(isset($comp) AND $comp != NULL)
					{
						echo "<p><b>".SCORES_COUNT.":</b> ".count($comp)."</p>";
		
						echo "<table class='table table-responsive table-condensed table-hover'>
								<thead>
									<tr>
										<th>".POSITION."</th>
										<th>".NAME."</th>
										<th>".SURNAME."</th>
										<th>".NUMBER."</th>
										<th>".LOSS." <small>".TIME_FORMAT."</small>"."</th>
										<th>".TIME." <small>".TIME_FORMAT."</small>"."</th>
										<th>".POINTS."</th>
										".$admin."
									</tr>
								</thead>
							<tbody>";
						$is_admin = is_admin();
						if(isset($comp) AND $comp != "")
						{
							foreach($comp as $comp => $key)
							{
								if($is_admin == true)
								{
									if($admin != NULL)
									{
										$admin = "<td><button style='width:100%;' type='button' class='btn btn-success' onclick='if(confirm(`".U_RIGHT." Zresetujesz wynik zawodnikowi z numerem: ".$key[2]."`) == true){document.location=`index.php?site=delete&race_id_reset_score=".$_POST['race_id']."&reset_score=".$key[2]."`;}'>RESET</button></td>";
									}
									echo "<tr>
											<td>".$key[7]."</td>
											<td>".$key[0]."</td>
											<td>".$key[1]."</td>
											<td>".$key[2]."</td>
											<td>".$key[3]."</td>
											<td>".$key[4]."</td>
											<td>".$key[5]."</td>
											".$admin."
										</tr>";
								}else{
									if($key[0] != "TEST")
									{
										echo "<tr>
											<td>".$key[7]."</td>
											<td>".$key[0]."</td>
											<td>".$key[1]."</td>
											<td>".$key[2]."</td>
											<td>".$key[3]."</td>
											<td>".$key[4]."</td>
											<td>".$key[5]."</td>
										</tr>";
									}
								}
							}
						}
						
						if(isset($dnf_comp) AND $dnf_comp != "")
						{
							foreach($dnf_comp as $dnf_comp => $key)
							{
								if($is_admin == true)
								{
                                    if($admin != NULL)
                                    {
                                        $admin = "<td><button style='width:100%;' type='button' class='btn btn-success' onclick='if(confirm(`".U_RIGHT." Zresetujesz wynik zawodnikowi z numerem: ".$key[2]."`) == true){document.location=`index.php?site=delete&race_id_reset_score=".$_POST['race_id']."&reset_score=".$key[2]."`;}'>RESET</button></td>";
                                    }
									echo "<tr style='background-color:rgba(255, 68, 68, 0.3);'>
											<td>DNF</td>
											<td>".$key[0]."</td>
											<td>".$key[1]."</td>
											<td>".$key[2]."</td>
											<td></td>
											<td></td>
											<td></td>
											".$admin."
									</tr>";
								}else{
									if($key[0] != "TEST")
									{
										echo "<tr style='background-color:rgba(255, 68, 68, 0.3);'>
											<td>DNF</td>
											<td>".$key[0]."</td>
											<td>".$key[1]."</td>
											<td>".$key[2]."</td>
											<td></td>
											<td></td>
											<td></td>
									</tr>";
									}
								}
							}
						}
							echo "</tbody>
								</table>";
					}else{
						echo "<h2>".ERRNO_35."</h2>";
						exit;
					}
					}else{
						echo "<h2>".CHOOSE_CATEGORY."</h2>";
						exit;
					}
			}
			if($_POST['table'] == "classification")
			{
				$classification = $db->fetch(sprintf("SELECT * FROM `classifications` WHERE `url` = '%s'",$_POST['race_id']));
				$all_categories = $db->fetch_all(sprintf("SELECT * FROM `categories`"));
				$all_cat = array();
				$categories = explode(',', $classification['categories']);
				foreach($all_categories as $key => $val)
				{
					array_push($all_cat,$val);
				}
				$all_categories = array();
				foreach($all_cat as $key => $val)
				{
					if(in_array($val['name'],$categories))
					{
						echo " <a href='".$_POST['race_id']."_classification"."_".$val['name']."'><button type='button' class='btn btn-default'>".$val['name']."</button></a> ";
						array_push($all_categories,$val);
					}
				}
				echo "<br>";
				$all_cat = NULL;
				$categories = $all_categories;
				$all_categories = NULL;
				$flag = false;
				foreach($categories as $key => $val)
				{
					if($val['name'] == $_POST['category'])
					{
						$flag = true;
					}
				}
				if($_POST['category'] != NULL AND $flag == true)
				{
					$category = $db->fetch(sprintf("SELECT * FROM `categories` WHERE `name` = '%s'",$_POST['category']));
                    $category['year_begin'] = date('Y') - $category['age_begin'];
                    $category['year_end'] = date('Y') - $category['age_end'];
					$races = explode(',',$classification['races']);
					$all_races = $db->fetch_all("SELECT `url_id` FROM `races` ORDER BY `date` ASC");
					$race = array();
					foreach($all_races as $key => $val)
					{
						if(in_array($val['url_id'],$races) == true)
						{
							$data = $db->fetch(sprintf("SELECT `short_name`,`url_id` FROM `races` WHERE `url_id` = '%s';",$val['url_id']));
							$race[] = [$data['url_id'] => $data['short_name']]; 
						}
					}
					$race_flag = false;
					$scores = array();
					foreach($race as $key => $val)
					{
						$eee = key($race[$key]);
						$hidden = $db->fetch("SELECT `hidden_scores` FROM `races` WHERE `url_id` = ".$eee);
                        if($hidden['hidden_scores'] > 0){continue;}
                        $score = $db->fetch_all(sprintf("SELECT `score`,`user_login` FROM race_%s WHERE `score` IS NOT NULL AND `finish` IS NOT NULL ORDER BY `score` ASC",key($race[$key])));
						if(!is_null($score)){
							$index = 0;
                            foreach($score as $score_key => $score_val)
                            {
                                $user = $db->fetch(sprintf("SELECT `name`,`surname`,`birth_date`,`sex` FROM `users` WHERE `login` = '%s'",$score_val['user_login']));
                                $byear = explode('-',$user['birth_date']);
                                $now = new DateTime();
                                $now = $now->format('Y');
                                $age = $now - $byear[0];
                                $sex = false;
                                if($category['sex'] == "both"){$sex = true;}
                                else if($category['sex'] == $user['sex']){$sex = true;}
                                if($age >= $category['age_begin'] AND $age <= $category['age_end'] AND $sex == true)
                                {
                                	//compute score for each competitor in category
									if($index == 0){
										$points = 50;
									}elseif ($index == 1){
										$points = 46;
									}elseif ($index > 1 && $index < 6){
										$z = $index - 1;
										$points = 46 - (3*$z);
									}elseif ($index > 5 && $index < 15){
										$z = $index - 5;
                                        $points = 34 - (2*$z);
									}elseif ($index == 15){
                                        $z = $index - 15;
                                        $points = 15;
									}elseif ($index > 15 && $index < 31){
                                        $z = $index - 15;
                                        $points = 15 - (1*$z);
									}else{
										$points = 0;
									}
                                    if(isset($scores[$score_val['user_login']]))
                                    {
                                        $scores[$score_val['user_login']][$val[key($race[$key])]] = $points;
                                    }else{
                                        $scores[$score_val['user_login']] = array("name"=>$user['name'],"surname"=>$user['surname'],$val[key($race[$key])]=>$points);
                                    }
                                    $index++;
                                }
                            }
						}
					}
					$temp = array();
					foreach($race as $key => $val)
					{
						foreach($val as $val)
						{
							$temp[] = $val;
						}
					}
					$race = $temp;
					unset($temp);
					foreach($scores as $key => $val)
					{
						$temp = array();
						foreach($val as $vkey => $vval)
						{
							if($vkey != "name" AND  $vkey != "surname" AND $vkey != "score")
 							{
								array_push($temp,$vval);
 							}
						}
						rsort($temp);
						$scores[$key]['score'] = 0;
						for($i = 0;$i<3;$i++) {
							if(isset($temp[$i]) && $temp[$i] != NULL) {
								$scores[$key]['score'] += $temp[$i];
							}
						}
						unset($temp);
					}
					foreach($race as $key => $val)
					{
						foreach($scores as $k => $v)
						{
							if(!isset($v[$val]) OR $v[$val] == NULL)
							{
								$scores[$k][$val] = 0;
							}
						}
					}
					//sort by score
					sort_array($scores,"score");
					unset($score,$user,$byear,$now,$age,$sex);
					if($scores != NULL){$race_flag = true;}
					if($race_flag == true)
					{
						$sex = $category['sex'];
						if($sex == "both"){$sex = UNISEX;}
						if($sex == "man"){$sex = MANS;}
						if($sex == "women"){$sex = WOMENS;}
						echo "<p><b>".CATEGORY_NAME.":</b> ".$_POST['category']."</p>";
						echo "<p><span><b>".$sex." ".IN_AGE.": </b>".$category['age_begin']." - ".$category['age_end']." ".YEARS."</span></p>";
                        echo "<p><span><b>".YEARS_.": </b>".$category['year_end']." - ".$category['year_begin']."</span></p>";
						echo "<p><b>".CLASSIFIED.": </b>".count($scores)."</p>";
						
						echo "<table class='table table-responsive table-condensed table-hover'>
								<thead>
									<tr>
										<th>".POSITION."</th>
										<th>".NAME."</th>
										<th>".SURNAME."</th>";
								$i = 1;
								foreach($race as $key => $val)
								{
									echo "<th>#".$i." ".$val."</th>";
									$i++;
								}
						echo			"<th>".SUM."</th>
									</tr>
								</thead>
							<tbody>";
						$position = 0;
						$is_admin = is_admin();
						foreach($scores as $key => $val)
						{
							if($is_admin == true)
							{
								$position++;
								echo "<tr>
										<td>".$position."</td>
										<td>".$val['name']."</td>
										<td>".$val['surname']."</td>";
								for($z = 0;$z<count($race);$z++)
								{
									echo "<td>".$val[$race[$z]]."</td>";
								}
								echo "<td>".$val['score']."</td>";
								echo "</tr>";
							}else{
								if($val['name'] != "TEST")
								{
									$position++;
									echo "<tr>
											<td>".$position."</td>
											<td>".$val['name']."</td>
											<td>".$val['surname']."</td>";
									for($z = 0;$z<count($race);$z++)
									{
										echo "<td>".$val[$race[$z]]."</td>";
									}
									echo "<td>".$val['score']."</td>";
									echo "</tr>";	
								}
							}							
						}
						echo "</tbody>
							</table>";
					}else{
						echo "<h2>".NO_RESULTS."</h2>";
					}
				}else{
					echo "<h2>".CHOOSE_CATEGORY."</h2>";
					exit;
				}
			}
		}
	}
	
?>
