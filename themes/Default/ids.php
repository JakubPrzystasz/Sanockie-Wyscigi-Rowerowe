<?php

	$page_name = IDS; @require_once("header.php"); if(!is_admin()){set_notification(ERRNO_23,"warning");header("Location:login");exit;}
	$array = $db->fetch_all("SELECT * FROM `identificators`");
	if(isset($_POST['truncate']) AND $_POST['truncate'] == true)
	{
		$db->query("TRUNCATE identificators");
		exit;
	}
	if(isset($_POST['add_ids']) AND $_POST['add_ids'] == true)
	{
		$a = $db->fetch("SELECT MAX(id) FROM identificators;");
		$a = $a['MAX(id)'];
		if($a == NULL)
		{
			$a = 1;
		}else{
			$a++;
		}
		for($i;$_POST['count'] > $i;$i++)
		{
			$db->query(sprintf("INSERT INTO `identificators` (`id`, `uid`) VALUES (NULL, %s);",$a));
			$a++;
		}
		exit;
	}

?>
		<div id="main">
			<div class="jumbotron" style="text-align:center;">
				<div class="form-group" style="max-width:450px;margin:auto;">
					<?php
						
						$available_ids = $db->num_rows("SELECT * FROM `identificators`");
						echo "<b>".AVAILABLE_IDS.": </b>".$available_ids; 
					?>
					<div class="panel panel-default">
						<form method="post">
							<input type="text" name="name_id" class="form-control" placeholder="<?php echo ID_NAME;?>"/>
							<button type="submit" class="btn btn-default" value="true" name="add_id"><?php echo ADD_NEW;?></button>
						</form>
					</div>
					<div class="panel panel-default">
						<input type="text" id="count_ids" class="form-control" placeholder="<?php echo ID_COUNT;?>"/>
						<button class="btn btn-default" onclick="add_ids();"><?php echo APPLY;?></button>
					</div>
					<button type="button" class="btn btn-default" <?php echo "onclick='if(confirm(`".U_RIGHT."`)==true){truncate_ids();}'"?> ><?php echo TRUNCATE_IDS;?></button>
					<script>
						function truncate_ids(){
							var data = "truncate=true";
							$.ajax({
								type: "POST",
								data: data,
								cache: false,
								success: function(result){
									location.reload();
								}
							});
						}
						function add_ids(){
							var data = "add_ids=true&count="+$("#count_ids").val();
							$.ajax({
								type: "POST",
								data: data,
								cache: false,
								success: function(result){
									location.reload();
								}
							});
						}
					</script>
					<table class="table table-hover table-condensed table-responsive">
						<thead>
							<tr>
								<th><?php echo NUMBER; ?></th>
								<th><?php echo UID; ?></th>
								<th><?php echo DELETE; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								
								foreach($array as $key => $val)
								{
									echo "<tr>
											<td>".$array[$key]['id']."</td>
											<td>".$array[$key]['uid']."</td>
											<td style='cursor: pointer;'onclick='if(confirm(`".U_RIGHT."`)==true){window.document.location=`index.php?site=delete&id_id=".$array[$key]['id']."`;}'><a>".DELETE."</a></td>
										</tr>";
								}
								if($array == NULL)
								{
									echo "<tr><td>".NO_IDS."</td></tr>";
								}
								
							?>
						</tbody>
					</table>
				</div>
			</div>			
		</div>

<?php @require_once("footer.php"); ?>