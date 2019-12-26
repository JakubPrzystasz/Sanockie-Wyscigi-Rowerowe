<?php

	$page_name = CATEGORIES; @require_once("header.php"); if(!is_admin()){set_notification(ERRNO_23,"warning");header("Location:login");exit;}
	
	$categoires  = $db->fetch_all("SELECT * FROM `categories`");
	
?>
		<div id="main">
			<div class="jumbotron" style="text-align:center;">
				<div class="form-group" style="max-width:450px;margin:auto;">
					<div class="panel panel-default">
						<div class="panel-body">
							<button type="button" class="btn btn-default" onclick='document.location=`edit_category`;'><?php echo ADD_CATEGORY;?></button>
							<table class="table table-hover table-condensed table-responsive">
								<thead>
									<tr>
										<th><?php echo CATEGORY_NAME;?></th>
										<th><?php echo DELETE;?></th>
										<th><?php echo EDIT;?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
										
										foreach($categoires as $key => $val)
										{
											echo "<tr><td>".$val['name']."</td><td><a href='#' onclick='if(confirm(`".U_RIGHT."`) == true){document.location=`index.php?site=delete&category_id=".$val['id']."`;}'>".DELETE."</a></td><td><a href='index.php?site=edit_category&category_id=".$val['id']."'>".EDIT."</a></td></tr>";
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>			
		</div>

<?php @require_once("footer.php"); ?>