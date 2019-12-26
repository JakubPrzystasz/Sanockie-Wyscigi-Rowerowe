<?php

	$page_name = CLASSIFICATIONS; @require_once("header.php"); if(!is_admin()){set_notification(ERRNO_23,"warning");header("Location:login");exit;}
	
	$classifications  = $db->fetch_all("SELECT * FROM `classifications`");

?>
		<div id="main">
			<div class="jumbotron" style="text-align:center;">
				<div class="form-group" style="max-width:450px;margin:auto;">
					<div class="panel panel-default">
						<div class="panel-body">
							<button type="button" class="btn btn-default" onclick='document.location=`edit_classification`;'><?php echo ADD_CLASSIFICATION;?></button>
							<table class="table table-hover table-condensed table-responsive">
								<thead>
									<tr>
										<th><?php echo CLASSIFICATION_NAME;?></th>
										<th><?php echo DELETE;?></th>
										<th><?php echo EDIT;?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
										
										foreach($classifications as $key => $val)
										{
											echo "<tr><td>".$val['name']."</td><td><a href='#' onclick='if(confirm(`".U_RIGHT."`) == true){document.location=`index.php?site=delete&classification_id=".$val['id']."`;}'>".DELETE."</a></td><td><a href='index.php?site=edit_classification&classification_id=".$val['id']."'>".EDIT."</a></td></tr>";
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