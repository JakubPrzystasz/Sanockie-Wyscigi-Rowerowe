<?php $page_name = LOGIN_PAGE; @require_once("header.php"); if(is_logged()){header("Location:index");exit;}?>
		
		<div id="main">
			<div class="jumbotron  hoverable">
				
				<div class="row">
					<div class="col col-md-2"></div>
					<div class="col col-md-8">
						<?php notify();?>
						<ul class="nav nav-pills">
							<?php
							if(!isset($_COOKIE['tab']))
							{
								echo '<li class="active"><a data-toggle="pill" href="#login" onclick="document.cookie = `tab=login`;">'.LOGGING_IN.'</a></li>
    									<li><a data-toggle="pill" href="#register" onclick="document.cookie = `tab=register`;">'.REGISTERING.'</a></li>
    									<li><a data-toggle="pill" href="#recovery" onclick="document.cookie = `tab=recovery`;">'.PASSWORD_RECOVERING.'</a></li>';
							}else{
								if($_COOKIE['tab'] == "login")
								{
									echo '<li class="active"><a data-toggle="pill" href="#login" onclick="document.cookie = `tab=login`;">'.LOGGING_IN.'</a></li>
    									<li><a data-toggle="pill" href="#register" onclick="document.cookie = `tab=register`;">'.REGISTERING.'</a></li>
    									<li><a data-toggle="pill" href="#recovery" onclick="document.cookie = `tab=recovery`;">'.PASSWORD_RECOVERING.'</a></li>';
								}
								if($_COOKIE['tab'] == "register")
								{
									echo '<li><a data-toggle="pill" href="#login" onclick="document.cookie = `tab=login`;">'.LOGGING_IN.'</a></li>
    									<li class="active"><a data-toggle="pill" href="#register" onclick="document.cookie = `tab=register`;">'.REGISTERING.'</a></li>
    									<li><a data-toggle="pill" href="#recovery" onclick="document.cookie = `tab=recovery`;">'.PASSWORD_RECOVERING.'</a></li>';
								}
								if($_COOKIE['tab'] == "recovery")
								{
									echo '<li><a data-toggle="pill" href="#login" onclick="document.cookie = `tab=login`;">'.LOGGING_IN.'</a></li>
    									<li><a data-toggle="pill" href="#register" onclick="document.cookie = `tab=register`;">'.REGISTERING.'</a></li>
    									<li class="active"><a data-toggle="pill" href="#recovery" onclick="document.cookie = `tab=recovery`;">'.PASSWORD_RECOVERING.'</a></li>';
								}
							}
							?>
						</ul>
  						<div class="tab-content">
    						<?php 
    						if(!isset($_COOKIE['tab']))
    						{
    							echo '<div id="login" class="tab-pane fade in active">';
    						}else{
    							if($_COOKIE['tab'] == "login"){
    								echo '<div id="login" class="tab-pane fade in active">';
    							}else{
    								echo '<div id="login" class="tab-pane fade">';
    							}
    						}
    						?>   
      							<h3><?php echo LOGGING_IN; ?></h3>
     							<div class="login-form"  id="login-form">
 								<form method="post" class="form">
   									<div class="form-group">
										<div class="input-group">
   										 	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  										 	<input id="login_login" type="text" class="form-control" name="login_login" placeholder="<?php echo USER_NAME." "._OR." ".EMAIL; ?>">
  										</div>
  									</div>
   									<div class="form-group">
										<div class="input-group">
   								 			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
  											<input id="login_password" type="password" class="form-control" name="login_password" placeholder="<?php echo PASSWORD; ?>">
  										</div>
  									</div>
  									<div class="form-group">
  										<label><button type="submit" class="btn btn-default" name="login_submit" value="true"><?php echo LOGIN; ?></button></label>
  									</div>
								</form>
								</div>      
   							</div>
    						<?php 
    						if(!isset($_COOKIE['tab']))
    						{
    							echo '<div id="register" class="tab-pane fade">';
    						}else{
    							if($_COOKIE['tab'] == "register"){
    								echo '<div id="register" class="tab-pane fade in active">';
    							}else{
    								echo '<div id="register" class="tab-pane fade">';
    							}
    						}
    						?>   						
    				  			<h3><?php echo REGISTERING; ?></h3>
     							<div class="register-form"  id="register-form">
 								<form method="post" class="form">
  									<div class="form-group">
										<div class="input-group">
   											<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
  											<input id="register_email" type="text" class="form-control" name="register_email" placeholder="<?php echo EMAIL; ?>" value="<?php echo $_COOKIE['register']['mail']; ?>">
  											<span style="width:0%;" class="input-group-addon" id="info-register-email"></span>
  										</div>
  									</div>
   									<div class="form-group">
										<div class="input-group">
   										 	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  										 	<input id="register_login" type="text" class="form-control" name="register_login" placeholder="<?php echo USER_NAME; ?>" value="<?php echo $_COOKIE['register']['login']; ?>">
  											<span style="width:0%;" class="input-group-addon" id="info-register-login"></span>
  										</div>
  									</div>
   									<div class="form-group">
										<div class="input-group">
   								 			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
  											<input id="register_password" type="password" class="form-control" name="register_password" placeholder="<?php echo PASS_REQUIREMENT; ?>">
  											<span style="width:0%;" class="input-group-addon" id="info-register-password"></span>
  										</div>
  									</div>
  									<div class="form-group">
										<div class="input-group">
   								 			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
  											<input id="register_repeat_password" type="password" class="form-control" name="register_repeat_password" placeholder="<?php echo REPEAT_PASSWORD; ?>">
  											<span style="width:0%;" class="input-group-addon" id="info-register-repeat-password"></span>
  										</div>
  									</div>
  									<div class="form-group">
  									  	<div class="checkbox">
  											<label><input id="register_checkbox" type="checkbox" name="register_checkbox" value="true"/><a href="rules"><?php echo ACCEPT_RULES; ?></a></label>
  											<label id="info-register-checkbox" style="font-weight:bold;display:block;color:red;"><?php if(isset($_COOKIE['checkbox'])){echo $_COOKIE['checkbox'];}?></label>
  										</div>
  										<br>
  										<label><button type="submit" class="btn btn-default" name="register_submit" value="true"><?php echo REGISTER; ?></button></label>
  									</div>
								</form>
								</div>  
      								
    						</div>
    
   							<?php 
    						if(!isset($_COOKIE['tab']))
    						{
    							echo '<div id="recovery" class="tab-pane fade">';
    						}else{
    							if($_COOKIE['tab'] == "recovery"){
    								echo '<div id="recovery" class="tab-pane fade in active">';
    							}else{
    								echo '<div id="recovery" class="tab-pane fade">';
    							}
    						}
    						?>   
    								<h3><?php echo PASSWORD_RECOVERING; ?></h3>
    								
							<div class="login-form"  id="login-form">
 								<form method="post" class="form">
   									<div class="form-group">
										<div class="input-group">
   										 	<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
  										 	<input id="recovery_email" type="text" class="form-control" name="recovery_email" placeholder="<?php echo EMAIL; ?> ">
  										</div>
  									</div>
  									<div class="form-group">
  										<label><button type="submit" class="btn btn-default" name="recovery_submit" value="true"><?php echo RECOVERY_PASSWORD; ?></button></label>
  									</div>
								</form>
							</div>  
    								</div>
  							</div>
  							
					</div>	
				</div>
				<div class="col col-md-2"></div>
			</div>
		</div>			

<?php @require_once("footer.php"); ?>