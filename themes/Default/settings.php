<?php
	$page_name = SETTINGS;
	@require_once("header.php");
	if(!is_logged()){set_notification(ERRNO_18, "warning");header("Location:login");exit;}
	$array = $db->fetch(sprintf("SELECT `login`, `email`,`name`,`surname`,`sex`,`birth_date`,`mobile`,`ice` FROM `users` WHERE `users`.`user_id` = '%s'",$_COOKIE['USER_ID']));
	$bday = explode('-', $array['birth_date']);
	$year = $bday[0];
	$month = $bday[1];
	$day = $bday[2];
?>
		
		<div id="main">
			<div class="jumbotron">
				<?php notify();?>
				<div id="notification" class="alert alert-info">
					<?php echo SETTINGS_GREETER; ?>
				</div>
				<div class="row">
					<div class="col col-lg-6">
						<div class="panel panel-default">
  							<div class="panel-heading"><?php echo LOGIN_DATA; ?></div>
  							<div class="panel-body">
     							<div id="user-settings-form">
 								<form method="post" class="form">
 								   	<div class="form-group">
										<div class="input-group">
   										 	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  										 	<input disabled value="<?php echo $array['login']; ?>" id="user_settings_login" type="text" class="form-control" name="user_settings_login" placeholder="<?php echo USER_NAME; ?>">
  										</div>
  									</div>
  									<div class="form-group">
										<div class="input-group">
   											 <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
  											 <input value="<?php echo $array['email']; ?>" id="user_settings_email" type="text" class="form-control" name="user_settings_email" placeholder="<?php echo EMAIL; ?> ">
  										</div>
  									</div>
   									<div class="form-group">
										<div class="input-group">
   								 			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
  											<input id="user_settings_password" type="password" class="form-control" name="user_settings_password" placeholder="<?php echo PASSWORD; ?>">
  										</div>
  									</div>
  									<div class="form-group">
										<div class="input-group">
   								 			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
  											<input id="user_settings_repeat_password" type="password" class="form-control" name="user_settings_repeat_password" placeholder="<?php echo REPEAT_PASSWORD; ?>">
  										</div>
  									</div>
  									<div class="form-group">
  										<label><button type="submit" class="btn btn-default" name="user_settings_submit" value="true"><?php echo APPLY; ?></button></label>
  									</div>
								</form>
								</div>
								<div class="alert alert-info">
  									<strong><?php echo ATTENTION;?></strong><br><?php echo PROFILE_LANG; ?>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col col-lg-6">
						<div class="panel panel-default">
							<div class="panel-heading"><?php echo ADDINATIONAL_DATA; ?></div>
							<div class="panel-body">
								<div class="alert alert-danger">
  									<strong><?php echo ATTENTION;?></strong><br><?php echo PROFILE_COMPLETING; ?>
								</div>
									<div id="user-settings-form">
 									<form method="post" class="form">
 										<div class="form-group">
											<div class="input-group">
   								 				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  												<input <?php if($array['name'] != NULL){echo "value='".$array['name']."' disabled readonly";} ?> id="user_settings_name" type="text" class="form-control" name="user_settings_name" placeholder="<?php echo NAME; ?>">
  											</div>
  										</div>
  										<div class="form-group">
  											<div class="input-group">
   								 				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  												<input <?php if($array['surname'] != NULL){echo "value='".$array['surname']."' disabled readonly";} ?> id="user_settings_surname" type="text" class="form-control" name="user_settings_surname" placeholder="<?php echo SURNAME; ?>">
  											</div>
										</div>
										<div class="form-group">
											<label><?php echo SEX; ?></label><br>
											<label class="radio-inline"><input <?php if($array['sex'] != NULL){if($array['sex'] == "women"){echo "checked disabled readonly";}else{echo "disabled readonly";}} ?> type="radio" name="user_settings_sex" value="women"><?php echo WOMEN;?></label>
											<label class="radio-inline"><input <?php if($array['sex'] != NULL){if($array['sex'] == "man"){echo "checked disabled readonly";}else{echo "disabled readonly";}} ?> type="radio" name="user_settings_sex" value="man"><?php echo MAN; ?></label>
										</div>
										<div class="form-group">
											<label><?php echo DATE_OF_BIRTH; ?></label>
										</div>
										<div class="hidden-xs">
                      						<div class="form-group ">
                  								<div class="col-xs-1"></div>
                         						<div class="col-xs-3">
                        							<label for="user_settings_bday"><?php echo DAY; ?></label> 
                        							<select <?php if($array['birth_date'] != NULL){echo "disabled";}?> class="form-control" id="user_settings_bday" name="user_settings_bday">
														<option disabled selected><?php echo DAY; ?></option>
														<?php 
														if($array['birth_date'] == NULL)
														{for($i=1;$i<32;$i++){echo "<option value='".$i."' >".$i."</option>";}}
														else{echo "<option selected>".$day."</option>";}
														?>
  													</select>
                       							</div>
                      						</div>
                      						<div class="form-group">
												 <div class="col-xs-4">
													<label for="user_settings_bmonth"><?php echo MONTH; ?></label> 
                        							<select <?php if($array['birth_date'] != NULL){echo "disabled";}?> class="form-control" id="user_settings_bmonth" name="user_settings_bmonth">
														<option disabled selected><?php echo MONTH; ?></option>
														<?php 
															if($array['birth_date'] == NULL)
															{
																echo "<option value='1'>".MONTH_1."</option>";
																echo "<option value='2'>".MONTH_2."</option>";
																echo "<option value='3'>".MONTH_3."</option>";
																echo "<option value='4'>".MONTH_4."</option>";
																echo "<option value='5'>".MONTH_5."</option>";
																echo "<option value='6'>".MONTH_6."</option>";
																echo "<option value='7'>".MONTH_7."</option>";
																echo "<option value='8'>".MONTH_8."</option>";
																echo "<option value='9'>".MONTH_9."</option>";
																echo "<option value='10'>".MONTH_10."</option>";
																echo "<option value='11'>".MONTH_11."</option>";
																echo "<option value='12'>".MONTH_12."</option>";
															}else{
																switch ($month)
																{
																	case 1:
																		$month = MONTH_1;
																		break;
																	case 2:
																		$month = MONTH_2;
																		break;
																	case 3:
																		$month = MONTH_3;
																		break;
																	case 4:
																		$month = MONTH_4;
																		break;
																	case 5:
																		$month = MONTH_5;
																		break;
																	case 6:
																		$month = MONTH_6;
																		break;
																	case 7:
																		$month = MONTH_7;
																		break;
																	case 8:
																		$month = MONTH_8;
																		break;
																	case 9:
																		$month = MONTH_9;
																		break;
																	case 10:
																		$month = MONTH_10;
																		break;
																	case 11:
																		$month = MONTH_11;
																		break;
																	case 12:
																		$month = MONTH_12;
																		break;
																}
																echo "<option selected>".$month."</option>";
															}?>
													</select>
                      							</div>
                      						</div>
                      						<div class="form-group">
                         						<div class="col-xs-3">
                       								<label for="user_settings_byear"><?php echo YEAR; ?></label> 
                        							<select <?php if($array['birth_date'] != NULL){echo " disabled ";}?> class="form-control" id="user_settings_byear" name="user_settings_byear">
														<option disabled selected><?php echo YEAR; ?></option>
														<?php
															if($array['birth_date'] == NULL)
															{for($i=1950;$i<=date("Y");$i++){echo "<option value='".$i."'>".$i."</option>";}}
															else{echo "<option selected>".$year."</option>";}
														?>
													</select>
                        						</div>
                        						<div class="col-xs-1"></div>
                      						</div>
                      					</div>
                      					<div class="visible-xs">
                      						<div class="form-group ">
                        						<label for="user_settings_bday"><?php echo DAY; ?></label> 
                        						<select <?php if($array['birth_date'] != NULL){echo "disabled";}?> class="form-control" id="user_settings_bday" name="user_settings_bday">
													<option disabled selected><?php echo DAY; ?></option>
													<?php 
													if($array['birth_date'] == NULL)
													{for($i=1;$i<32;$i++){echo "<option value='".$i."' >".$i."</option>";}}
													else{echo "<option selected>".$day."</option>";}
													?>
  												</select>
                       						</div>
                      						<div class="form-group">
												<label for="user_settings_bmonth"><?php echo MONTH; ?></label> 
                        						<select <?php if($array['birth_date'] != NULL){echo "disabled";}?> class="form-control" id="user_settings_bmonth" name="user_settings_bmonth">
													<option disabled selected><?php echo MONTH; ?></option>
													<?php 
														if($array['birth_date'] == NULL)
														{
															echo "<option value='1'>".MONTH_1."</option>";
															echo "<option value='2'>".MONTH_2."</option>";
															echo "<option value='3'>".MONTH_3."</option>";
															echo "<option value='4'>".MONTH_4."</option>";
															echo "<option value='5'>".MONTH_5."</option>";
															echo "<option value='6'>".MONTH_6."</option>";
															echo "<option value='7'>".MONTH_7."</option>";
															echo "<option value='8'>".MONTH_8."</option>";
															echo "<option value='9'>".MONTH_9."</option>";
															echo "<option value='10'>".MONTH_10."</option>";
															echo "<option value='11'>".MONTH_11."</option>";
															echo "<option value='12'>".MONTH_12."</option>";
														}else{
															switch ($array['birth_month'])
															{
																case 1:
																	$month = MONTH_1;
																	break;
																case 2:
																	$month = MONTH_2;
																	break;
																case 3:
																	$month = MONTH_3;
																	break;
																case 4:
																	$month = MONTH_4;
																	break;
																case 5:
																	$month = MONTH_5;
																	break;
																case 6:
																	$month = MONTH_6;
																	break;
																case 7:
																	$month = MONTH_7;
																	break;
																case 8:
																	$month = MONTH_8;
																	break;
																case 9:
																	$month = MONTH_9;
																	break;
																case 10:
																	$month = MONTH_10;
																	break;
																case 11:
																	$month = MONTH_11;
																	break;
																case 12:
																	$month = MONTH_12;
																	break;
															}
															echo "<option selected>".$month."</option>";
														}?>
												</select>
                      						</div>
                      						<div class="form-group">
                       							<label for="user_settings_byear"><?php echo YEAR; ?></label> 
                        						<select <?php if($array['birth_date'] != NULL){echo " disabled ";}?> class="form-control" id="user_settings_byear" name="user_settings_byear">
													<option disabled selected><?php echo YEAR; ?></option>
													<?php
														if($array['birth_date'] == NULL)
														{for($i=1950;$i<=date("Y");$i++){echo "<option value='".$i."'>".$i."</option>";}}
														else{echo "<option selected>".$year."</option>";}
													?>
												</select>
                      						</div>
                      					</div>
                      					<label><?php echo ADDINATIONAL_INFO; ?></label>
                      					<div class="form-group">
                      						<label for="user_settings_mobile"><?php echo MOBILE; ?></label>
                      						<div class="input-group">
   								 				<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
  												<input <?php if($array['mobile'] != NULL){echo "value='".$array['mobile']."'";}?> id="user_settings_mobile" type="text" class="form-control" name="user_settings_mobile" placeholder="<?php echo MOBILE; ?>">
  											</div>
                      					</div>
                      				    <div class="form-group">
                      				    	<label for="user_settings_ice"><?php echo ICE; ?></label>
                      						<div class="input-group">
   								 				<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
  												<input <?php if($array['ice'] != NULL){echo "value='".$array['ice']."'";}?> id="user_settings_ice" type="text" class="form-control" name="user_settings_ice" placeholder="<?php echo ICE; ?>">
  											</div>
  											<a href="ice"><label><?php echo MORE_INFO_ICE; ?></label></a>
                      					</div>
                      					<div class="form-group">
  											<label><button type="submit" class="btn btn-default" name="user_complete_submit" value="true"><?php echo APPLY; ?></button></label>
  										</div>
                      				</form>
                 					</div>
  								</div>
  							</div>
							</div>
						</div>
					</div>
				</div>	
			</div>			
		</div>

<?php @require_once("footer.php"); ?>