<?php
	if(!is_admin()){header("Location: index");set_notification(ERRNO_23,"warning");exit();}
	$array = $db->fetch("SELECT `url`,`url_id`,`signup_limit` FROM `races` WHERE `date` = CURDATE()");
	if($array == NULL)
	{
		exit;
	}
	
	$page_name = RACE_MANAGER;

	@require_once("header.php");
?>		
		<div id="main">
			<div class="jumbotron" style="text-align:center;margin:auto;">
				<p>
					<a href="<?php echo $array['url'];?>_scores"><button type="button" class="btn btn-primary"><?php echo SCORES;?></button></a>
					<a href="#" onclick="location.reload();"><button type="button" class="btn btn-primary"><?php echo REFRESH;?></button></a>
				</p>
				<ul class="nav nav-pills nav-justified">
					<li <?php if(isset($_COOKIE['race_manager']) AND $_COOKIE['race_manager'] == "start"){echo ' class="active"';}?>><a data-toggle="pill" href="#start" onclick='update();document.cookie = "race_manager=start";'>Start</a></li>
					<li <?php if(isset($_COOKIE['race_manager']) AND $_COOKIE['race_manager'] == "stop"){echo ' class="active"';}?>><a data-toggle="pill" href="#stop" onclick='update();document.cookie = "race_manager=stop";'>Stop</a></li>
				</ul>
				<div class="tab-content" style="padding:15px;">
					<div id="start" class="tab-pane fade <?php if(isset($_COOKIE['race_manager']) AND $_COOKIE['race_manager'] == "start"){echo 'in active';}?>">
						<label><?php echo ALREADY_STARTED;?></label>
						<div id="start_bar" class="progress" style="width:80%;margin:auto;"></div>
						<button type="button" class="btn btn-default" onclick="if(confirm(`<?php echo U_RIGHT ?>`)==true)
							{
								var data = `ALL`;
								$.ajax({
								type: `POST`,
								url: `time.php`,
								data: data,
								cache: false
							});}">
							<?php echo START_ALL ?>
						</button>
						<br>
						<label><?php echo AVAILABLE_TICKETS.": "; ?><span id="free_tickets"></span></label>
						<br>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#quick_register_modal"><?php echo QUICK_REGISTER; ?></button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#quick_signup_modal"><?php echo QUICK_SIGNUP; ?></button>
						<div id="race_start"></div>
					</div>
					<div id="stop" class="tab-pane fade <?php if(isset($_COOKIE['race_manager']) AND $_COOKIE['race_manager'] == "stop"){echo 'in active';}?>">
						<label><?php echo ALREADY_FINISHED;?></label>
						<div id="stop_bar" class="progress" style="width:80%;margin:auto;"></div>
						<div id="race_stop"></div>
					</div>
				</div>
			</div>			
		</div>
		
		<div id="quick_register_modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><?php echo QUICK_REGISTER; ?></h4>
					</div>
					<div class="modal-body" style="text-align:center;">
						<div class="alert" id="quick_register_notification" style="display:none;">
						</div>
						<form method="post" class="form" id="quick_register_form">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i
										class="glyphicon glyphicon-user"></i></span>
										<input
											id="quick_register_name" type="text" class="form-control"
											placeholder="<?php echo NAME; ?>">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i
										class="glyphicon glyphicon-user"></i></span>
										<input
											id="quick_register_surname" type="text" class="form-control"
											placeholder="<?php echo SURNAME; ?>">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i
										class="glyphicon glyphicon-envelope"></i></span>
										<input
											id="quick_register_email" type="text" class="form-control"
											placeholder="<?php echo EMAIL; ?>">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i
										class="glyphicon glyphicon-phone"></i></span>
										<input
											id="quick_register_ice" type="text" class="form-control"
											placeholder="<?php echo ICE."(".OPTIONALLY.")"; ?>">
								</div>
							</div>
							<div class="form-group">
								<label><?php echo SEX; ?></label>
									<br>
								<label class="radio-inline">
									<input 
										type="radio" name="quick_register_sex" value="women"><?php echo WOMEN;?>
								</label>
								<label class="radio-inline">
									<input
										type="radio" name="quick_register_sex" value="man"><?php echo MAN; ?>
								</label>
							</div>
							<div class="form-group">
								<label><?php echo DATE_OF_BIRTH; ?></label>
							</div>
							<div>
								<div class="form-group ">
										<label for="quick_register_bday"><?php echo DAY; ?></label>
										<select
											class="form-control"
											name="quick_register_bday">
											<option disabled selected><?php echo DAY; ?></option>
											<?php
												for($i = 1; $i < 32; $i ++) {
													echo "<option value='" . $i . "' >" . $i . "</option>";
												}
											?>
		  								</select>
								</div>
								<div class="form-group">
									<label for="quick_register_bmonth"><?php echo MONTH; ?></label>
										<select
											class="form-control"
											name="quick_register_bmonth">
											<option disabled selected><?php echo MONTH; ?></option>
											<?php
												echo "<option value='1'>" . MONTH_1 . "</option>";
												echo "<option value='2'>" . MONTH_2 . "</option>";
												echo "<option value='3'>" . MONTH_3 . "</option>";
												echo "<option value='4'>" . MONTH_4 . "</option>";
												echo "<option value='5'>" . MONTH_5 . "</option>";
												echo "<option value='6'>" . MONTH_6 . "</option>";
												echo "<option value='7'>" . MONTH_7 . "</option>";
												echo "<option value='8'>" . MONTH_8 . "</option>";
												echo "<option value='9'>" . MONTH_9 . "</option>";
												echo "<option value='10'>" . MONTH_10 . "</option>";
												echo "<option value='11'>" . MONTH_11 . "</option>";
												echo "<option value='12'>" . MONTH_12 . "</option>";
											?>
										</select>
								</div>
								<div class="form-group">
										<label for="quick_register_byear"><?php echo YEAR; ?></label>
										<select
											class="form-control"
											name="quick_register_byear">
											<option disabled selected><?php echo YEAR; ?></option>
											<?php			
												for($i = 1900; $i <= date ( "Y" ); $i ++) {
													echo "<option value='" . $i . "'>" . $i . "</option>";
												}
											?>
										</select>
								</div>
							</div>
							<div class="form-group">
								<label><button type="reset" class="btn btn-default" id="quick_register_reset">Reset</button></label>
								<label><button type="button" class="btn btn-default" id="quick_register_submit" value="true"><?php echo APPLY; ?></button></label>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CLOSE; ?></button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="quick_signup_modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><?php echo QUICK_SIGNUP; ?></h4>
					</div>
					<div class="modal-body" style="text-align:center;">
						<div class="alert" id="quick_signup_notification" style="display:none;"></div>
  							<div class="panel-body">
  								<div class="input-group">
    								<input id="quick_signup_user_name" type="text" class="form-control" placeholder="<?php echo SEARCH_USER_PLACEHOLDER;?>">
    								<div class="input-group-btn">
     									<button class="btn btn-default" type="submit" id="quick_signup_search_user">
    										<i class="glyphicon glyphicon-search"></i>
      									</button>
    								</div>
  								</div>
  								<table class="table table-hover table-condensed table-responsive">
									<thead>
									    <tr>
									      <th><?php echo USER_NAME; ?></th>
									      <th><?php echo NAME; ?></th>
										  <th><?php echo SURNAME; ?></th>
									      <th><?php echo QUICK_SIGNUP_BTN; ?></th> 
										</tr>
									</thead>
  									<tbody id="quick_signup_user_table"></tbody>
								</table>	
  							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo CLOSE; ?></button>
					</div>
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="<?php theme_dir()?>admin.js"></script>
		
		<script type="text/javascript">

			$('#quick_signup_modal').on('hidden.bs.modal', function () {
				$("#quick_signup_notification").html("");
				$("#quick_signup_notification").hide();
			});	

			$("#quick_register_submit" ).click(function(){
				var data = "name="+$("#quick_register_name").val()+"&surname="+$("#quick_register_surname").val()+"&email="+
				$("#quick_register_email").val()+"&ice="+$("#quick_register_ice").val()+
				"&sex="+$("input[name='quick_register_sex']:checked").val()+
				"&bday="+$("select[name='quick_register_bday'] option:selected").val()+
				"&bmonth="+$("select[name='quick_register_bmonth'] option:selected").val()+
				"&byear="+$("select[name='quick_register_byear'] option:selected").val();
				$.ajax({
					type: "POST",
					url: "/modules/race/quick_register.php",
					data: data,
					cache: false,
					success: function(result){
						var result = JSON.parse(result);
						$("#quick_register_notification").html(result.content);
						$("#quick_register_notification").removeClass();
						$("#quick_register_notification").addClass(result.type);
						$("#quick_register_notification").show("fast");
						if(result.type == 'alert alert-success')
						{
							$("#quick_register_reset").click();
						}
					}
				});
			});

			$('#quick_register_modal').on('hidden.bs.modal', function () {
				$("#quick_register_notification").html("");
				$("#quick_register_notification").hide();
			});	
			var d = new Date();
			var n = d.getTime()/1000;
			function stop_user_time(user){
				 document.cookie = "stop_"+user+"="+n+"; expires=Thu, 31 Dec 2020 12:00:00 UTC"; 
			}
			function start_user_time(user){
				 document.cookie = "start_"+user+"="+n+"; expires=Thu, 31 Dec 2020 12:00:00 UTC"; 
			}
			
			function disable_row(user_id){
				$("#"+user_id).fadeOut( "slow", function() {
					$("#"+user_id).hide();
				});
			}
			
			function delete_user_race(user_login){
				var data = "quick_delete_user_login="+user_login;
				$.ajax({
					type: "POST",
					url: "/themes/Default/delete.php",
					data: data,
					cache: false
				});
			}
			
			function quick_signup(user_id){
				var data = "quick_signup_user_id="+user_id;
				$.ajax({
					type: "GET",
					url: "signup_race.php",
					data: data,
					cache: false,
					success: function(result){
						var result = JSON.parse(result);
						$("#quick_signup_notification").html(result.content);
						$("#quick_signup_notification").removeClass();
						$("#quick_signup_notification").addClass(result.type);
						$("#quick_signup_notification").show("fast");
					}
				});
			}
			
			function send_user(user_id){
				var data = "MODE=time&UID="+user_id;
				$.ajax({
					type: "POST",
					url: "time.php",
					data: data,
					cache: false
				});
			}

			function dnf_user(user_id){
				var data = "dnf_user_id="+user_id;
				$.ajax({
					type: "POST",
					url: "/modules/race/ajax.php",
					data: data,
					cache: false
				});
			}
			
			function update_start_bar(){
				var data = "start_bar=NULL";
				$.ajax({
					type: "POST",
					url: "/modules/race/ajax.php",
					data: data,
					cache: false,
					success: function(result){
						$("#start_bar").html(result);
					}
				});
			}
			function race_start(){
				var data = "race_start=NULL";
				$.ajax({
					type: "POST",
					url: "/modules/race/ajax.php",
					data: data,
					cache: false,
					success: function(result){
						$("#race_start").html(result);
					}
				});
			}
			function update_stop_bar(){
				var data = "stop_bar=NULL";
				$.ajax({
					type: "POST",
					url: "/modules/race/ajax.php",
					data: data,
					cache: false,
					success: function(result){
						$("#stop_bar").html(result);
					}
				});
			}
			function race_stop(){
				var data = "race_stop=NULL";
				$.ajax({
					type: "POST",
					url: "/modules/race/ajax.php",
					data: data,
					cache: false,
					success: function(result){
						$("#race_stop").html(result);
					}
				});
			}

			function free_tickets(){
				var data = "count_free_tickets=1";
				$.ajax({
					type: "POST",
					url: "/modules/race/ajax.php",
					data: data,
					cache: false,
					success: function(result){
						$("#free_tickets").html(result);
					}
				});
			}
			function update(){
				//load progress bars
				update_start_bar();
				update_stop_bar();
				//load tables
				race_start();
				race_stop();
				free_tickets();
			}
			update();
		</script>

<?php @require_once("footer.php"); ?>
