<?php $page_name = UPCOMING_EVENTS; @require_once("header.php");?>
		
		<div id="main">
			<div class="jumbotron" style="text-align:center;margin:auto;">
				<ul class="nav nav-pills nav-justified">
			 		<li class="active"><a data-toggle="pill" href="#upcoming"><?php echo UPCOMING_EVENTS;?></a></li>
			  		<li><a data-toggle="pill" href="#my_events"><?php echo MY_EVENTS;?></a></li>
				</ul>
				<div class="modal fade" id="signup_race_modal" role="dialog">
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
				</div>
				<div class="tab-content">
				<div id="upcoming" class="tab-pane fade in active">
				<?php 
						$array = $db->fetch_all(sprintf("SELECT * FROM `races` WHERE `date` >= CURDATE() ORDER BY `races`.`date` ASC"));
						if($array != NULL)
						{
							
							echo "<div class='table-responsive'>
									<table class='table table-responsive table-condensed table-hover'>
									<thead>
										<tr>
											<th>".RACE_NAME."</th>
											<th>".RACE_ORGANIZER."</th>
											<th>".DATE."</th>
											<th>".SIGNED_IN_LIST."</th>
											<th>".SIGN_UP."</th>
										</tr>
									</thead>
									<tbody>";
						}else{
							echo "<h2>".NO_EVENTS."</h2>";
						}
						
			 			foreach($array as $key => $val)
			 			{
			 				if(is_logged())
			 				{
								$signed = "<td><a href='#' onclick='$(`#signup_race_modal`).modal(`show`);signup_race_modal(`".$array[$key]['url_id']."`)'>".SIGN_UP."</a></td>";
				 			}else{
								$signed = "<td>".ERRNO_39."</td>";
							}
							 		
							 $array[$key]['date'] = DateTime::createFromFormat('Y-m-d',$array[$key]['date']);
							 $array[$key]['date'] = $array[$key]['date']->format('d-m-Y');
							 echo "<tr>
								<td><a href='".$array[$key]['url']."'>".$array[$key]['name']."</a></td>
								<td>".$array[$key]['organizer']."</td>
								<td>".$array[$key]['date']."</td>
								<td><a href='".$array[$key]['url']."_signed'>".SIGNED_IN_LIST."</a></td>
								".$signed."
								</tr>";
						}
						if($array != NULL)
						{
							echo "</tbody>
							 	</table>
								</div>";
						}
					?>
  				</div>
  				<div id="my_events" class="tab-pane fade">
					<?php 
						if(!is_logged()){echo "<h2>".LOGGED_GOODS."</h2>";}
						if(is_logged())
						{
							$array = $db->fetch_all(sprintf("SELECT * FROM `races` ORDER BY `races`.`date` DESC"));
							if($array != NULL)
							{
								foreach($array as $key => $val)
								{
									$user = $db->fetch(sprintf("SELECT `login` FROM `users` WHERE `user_id` = '%s';",$_COOKIE['USER_ID']));
									$rows = $db->num_rows(sprintf("SELECT * FROM `race_%s` WHERE `race_%s`.`user_login` = '%s';",$array[$key]['url_id'],$array[$key]['url_id'],$user['login']));
									if($rows > 0)
									{
										$race[] = $db->fetch(sprintf("SELECT * FROM `race_%s` WHERE `race_%s`.`user_login` = '%s';",$array[$key]['url_id'],$array[$key]['url_id'],$user['login']));
									}
								}
								
								$race_num = count($race);
								
								if($race_num > 0)
								{	
								echo '<div class="table-responsive">
									<table class="table table-responsive table-condensed table-hover">
										<thead>
											<tr>
												<th>'.RACE_NAME.'</th>
												<th>'.RACE_ORGANIZER.'</th>
												<th>'.DATE.'</th>
			 									<th>'.SIGNED_IN_LIST.'</th>
												<th>'.SCORES.'</th>
											</tr>
										</thead>
										<tbody>';
								
								foreach($array as $key => $val)
								{
									$user = $db->fetch(sprintf("SELECT `login`,`user_id` FROM `users` WHERE `user_id` = '%s';",$_COOKIE['USER_ID']));
									$race = $db->fetch(sprintf("SELECT * FROM `race_%s` WHERE `race_%s`.`user_login` = '%s';",$array[$key]['url_id'],$array[$key]['url_id'],$user['login']));
									if($race != NULL)
									{
										$array[$key]['date'] = DateTime::createFromFormat('Y-m-d',$array[$key]['date']);
										$array[$key]['date'] = $array[$key]['date']->format('d-m-Y');
										$signed = "<td><a href='#' onclick='$(`#signup_race_modal`).modal(`show`);signup_race_modal(`".$array[$key]['url_id']."`)'>".$signed."</a></td>";
										echo "<tr>
												<td><a href='".$array[$key]['url']."'>".$array[$key]['name']."</a></td>
												<td>".$array[$key]['organizer']."</td>
												<td>".$array[$key]['date']."</td>
												<td><a href='".$array[$key]['url']."_signed'>".SIGNED_IN_LIST."</a></td>
												<td><a href='".$array[$key]['url']."_scores'>".SCORES."</a></td>
							 				</tr>";
									}
								}
								echo "</tbody>
								</table>
								</div>";
								}
								if($race_num < 1)
								{
									echo "<h2>".NO_SIGNED_EVENTS."</h2>";
								}
							}
						}
					?>
					</div>
				</div>
			</div>			
		</div>

<?php @require_once("footer.php"); ?>