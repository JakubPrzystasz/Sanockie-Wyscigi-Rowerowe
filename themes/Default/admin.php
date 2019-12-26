<?php 
	$page_name = ADMIN_PAGE;
	@require_once("header.php"); 
	if(!is_admin()){set_notification(ERRNO_23, "warning");header("Location:login");exit;}
?>
		
		<div id="main">
			<div class="jumbotron">
			
				<?php notify(); ?>
				
				<div class="row">
 					<div class="col-md-3">
 						<ul class="nav nav-pills nav-stacked">
   							<li><a data-toggle="pill" href="#basic"><?php echo BASIC_CONFIG;?></a></li>
    						<li><a data-toggle="pill" href="#user"><?php echo USER_MANAGE;?></a></li>
 							<li><a data-toggle="pill" href="#page"><?php echo PAGE_MANAGE;?></a></li>
 							<li><a data-toggle="pill" href="#race"><?php echo RACE_MANAGE;?></a></li>
 							<li><a data-toggle="pill" href="#module"><?php echo MODULE_MANAGE;?></a></li>
 							<li><a data-toggle="pill" href="#theme"><?php echo THEME_MANAGE;?></a></li>
 							<li><a data-toggle="pill" href="#language"><?php echo LANGUAGES; ?></a></li>
 							<li><a data-toggle="pill" href="#statistics"><?php echo STATISTICS; ?></a></li>
 						</ul>
 					</div>
  					<div class="col-md-9" style="text-align:center;">
  					
  						<div class="tab-content">
						<div id="basic" class="tab-pane fade in active panel panel-default">
  							<div class="panel-heading"><?php echo BASIC_CONFIG; ?></div>
  							<div class="panel-body">
  								
								 <form method="post">
  									<div class="form-group">
   										<label for="site_title"><?php echo SITE_TITLE; ?></label>
    									<input value="<?php echo $_SESSION['title']?>" type="text" class="form-control" id="site_title" name="site_title" placeholder="<?php echo SITE_TITLE; ?>">
  									</div>
									<div class="form-group">
										<label for="site_full_title"><?php echo SITE_FULL_TITLE; ?></label>
										<input value="<?php echo $_SESSION['full_name'];?>" type="text" class="form-control" id="site_full_title" name="site_full_title" placeholder="<?php echo SITE_FULL_TITLE; ?>">
									</div>
									<div class="form-group">
										<label for="site_author"><?php echo SITE_AUTHOR; ?></label>
										<input value="<?php echo $_SESSION['author']?>" type="text" class="form-control" id="site_author" name="site_author" placeholder="<?php echo SITE_AUTHOR; ?>">
									</div>
									<div class="form-group">
										<label for="site_description"><?php echo SITE_DESCRIPTION; ?></label>
										<input value="<?php echo $_SESSION['description']?>" type="text" class="form-control" id="site_description" name="site_description" placeholder="<?php echo SITE_DESCRIPTION; ?>">
									</div>
									<div class="form-group">
										<label for="site_keywords"><?php echo SITE_KEYWORDS; ?></label>
										<input value="<?php echo $_SESSION['keywords']?>" type="text" class="form-control" id="site_keywords" name="site_keywords" placeholder="<?php echo SITE_KEYWORDS; ?>">
									</div>
									<div class="from-group">
										<button type="submit" class="btn btn-default" name="basic_submit" value="true"><?php echo APPLY; ?></button>
									</div>
								</form>
  								
  							</div>
						</div>
						
						<div id="user" class="tab-pane fade panel panel-default">
  							<div class="panel-heading"><?php echo USER_MANAGE; ?></div>
  							<div class="panel-body">
  								<label><?php echo SEARCH_USER; ?></label>
  									<div class="input-group">
    									<input id="user_name" type="text" class="form-control" placeholder="<?php echo SEARCH_USER_PLACEHOLDER;?>">
    									<div class="input-group-btn">
     										<button class="btn btn-default" type="submit" id="search_user">
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
									      <th><?php echo DELETE; ?></th>
									      <th><?php echo EDIT; ?></th>   
										</tr>
									</thead>
  									<tbody id="user_table"></tbody>
								</table>	
  							</div>
						</div>
						<div id="page" class="tab-pane fade panel panel-default">
  							<div class="panel-heading"><?php echo PAGE_MANAGE; ?></div>
  							<div class="panel-body">
  							<button type="button" class="btn btn-default" onclick="window.document.location=`index.php?site=edit_article`;"><?php echo ADD_NEW_ARTICLE; ?></button>
  								<div class="alert alert-info">
  									<?php echo EDIT_ARTICLE_INFO; ?>
  								</div>
  								<label><?php echo SEARCH_ARTICLE; ?></label>
  									<div class="input-group">
    									<input id="article_name" type="text" class="form-control" placeholder="<?php echo SEARCH_ARTICLE_PLACEHOLDER;?>">
    									<div class="input-group-btn">
     										<button class="btn btn-default" type="submit" id="search_article">
    											<i class="glyphicon glyphicon-search"></i>
      										</button>
    									</div>
  									</div>
  								<table class="table table-hover table-condensed table-responsive">
									<thead>
									    <tr>
									      <th><?php echo TITLE; ?></th>
									      <th><?php echo LAST_EDITOR; ?></th>
									      <th><?php echo LANGUAGE; ?></th>
									      <th class="col-md-1"><?php echo LAST_EDIT; ?></th>   
										</tr>
									</thead>
  									<tbody id="article_table"></tbody>
								</table>	
							</div>
						</div>
						
						<div id="race" class="tab-pane fade panel panel-default">
  							<div class="panel-heading"><?php echo RACE_MANAGE; ?></div>
  							<div class="panel-body">
  								<div class="row">
									<button type="button" class="btn btn-default" onclick="window.document.location='edit_race';"><?php echo ADD_RACE; ?></button>
									<button type="button" class="btn btn-default" onclick="window.document.location='ids';"><?php echo IDS; ?></button>
									<button type="button" class="btn btn-default" onclick="window.document.location='categories';"><?php echo CATEGORIES; ?></button>
									<button type="button" class="btn btn-default" onclick="window.document.location='classifications';"><?php echo CLASSIFICATIONS; ?></button>								
								</div>
  								<label><?php echo SEARCH_RACE; ?></label>
  									<div class="input-group">
    									<input id="race_name" type="text" class="form-control" placeholder="<?php echo SEARCH_RACE_PLACEHOLDER;?>">
    									<div class="input-group-btn">
     										<button class="btn btn-default" type="submit" id="search_race">
    											<i class="glyphicon glyphicon-search"></i>
      										</button>
    									</div>
  									</div>
								<div class="row">
									<table class="table table-hover table-condensed table-responsive">
										<thead>
											<tr>
												<th><?php echo RACE_NAME;?></th>
												<th><?php echo DATE_FORMAT;?></th>
												<th><?php echo DELETE; ?></th>
												<th><?php echo EDIT; ?></th>
											</tr>
										</thead>
										<tbody id="race_table"></tbody>
									</table>
								</div>
							</div>
						</div>
						
						<div id="module" class="tab-pane fade panel panel-default">
  							<div class="panel-heading"><?php echo MODULE_MANAGE; ?></div>
  							<div class="panel-body"><?php modules_selector(); ?></div>
						</div>
						
						<div id="theme" class="tab-pane fade panel panel-default">
  							<div class="panel-heading"><?php echo THEME_MANAGE; ?></div>
  							<div class="panel-body"><?php default_theme_selector(); ?></div>
						</div>
						
						<div id="language" class="tab-pane fade panel panel-default">
  							<div class="panel-heading"><?php echo LANGUAGES; ?></div>
  							<div class="panel-body"><?php default_language_selector(); ?></div>
						</div>
						<div id="statistics" class="tab-pane fade panel panel-default">
  							<div class="panel-heading"><?php echo STATISTICS; ?></div>
  							<div class="panel-body">
								<?php 
									$v_today = $db->fetch("SELECT `visits`,`unique_visits` FROM `statistics` WHERE `date` = CURDATE()");
									$v_yesterday = $db->fetch("SELECT `visits`,`unique_visits` FROM `statistics` WHERE `date` = DATE_ADD(CURDATE(), INTERVAL -1 DAY)");
									$all = $db->fetch_all("SELECT `visits`,`unique_visits` FROM `statistics`");
									foreach($all as $key => $val)
									{
										$all_visits+=$val['visits'];
										$all_uvisits+=$val['unique_visits'];
									}
									$registred_a = $db->fetch("SELECT COUNT(*) FROM `users`;");
									$registred_t = $db->fetch("SELECT COUNT(*) FROM `users` WHERE `register_date` > CURRENT_DATE()");
									$registred_y = $db->fetch("SELECT COUNT(*) FROM `users` WHERE `register_date` > DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY) AND `register_date` < CURRENT_DATE()");
									foreach($registred_a as $key => $val)
									{
										$registred_a[] = $val;
									}
									foreach($registred_t as $key => $val)
									{
										$registred_t[] = $val;
									}
									foreach($registred_y as $key => $val)
									{
										$registred_y[] = $val;
									}
									echo '<div class="row">
											<div class="col col-md-6">
												<div class="panel panel-default">
													<div class="panel-heading"><b>'.V_TODAY.'</b></div>
													<div class="panel-body">
														<p><b>'.VISITS.': </b>'.$v_today['visits'].'</p>
														<p><b>'.UNIQUE_VISITS.': </b>'.$v_today['unique_visits'].'</p>
														<p><b>'.REGISTRED_USERS.': </b>'.$registred_t[0].'</p>
													</div>
												</div>
											</div>
											<div class="col col-md-6">
												<div class="panel panel-default">
													<div class="panel-heading"><b>'.V_YESTERDAY.'</b></div>
													<div class="panel-body">
														<p><b>'.VISITS.': </b>'.$v_yesterday['visits'].'</p>
														<p><b>'.UNIQUE_VISITS.': </b>'.$v_yesterday['unique_visits'].'</p>
														<p><b>'.REGISTRED_USERS.': </b>'.$registred_y[0].'</p>
														</div>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading" style="background-color:#ffb69b;"><b>'.ALL_VISITS.'</b></div>
											<div class="panel-body">
												<p><b>'.VISITS.': </b>'.$all_visits.'</p>
												<p><b>'.UNIQUE_VISITS.': </b>'.$all_uvisits.'</p>
												<p><b>'.REGISTRED_USERS.': </b>'.$registred_a[0].'</p>
											</div>
										</div>';
								?>
							</div>
						</div>
						</div>
						
					</div>
				</div>
			</div>			
		</div>
		
		<script type="text/javascript" src="<?php theme_dir()?>admin.js"></script>
		
<?php @require_once("footer.php"); ?>