<?php $page_name = SCORES; @require_once("header.php");?>
		
		<div id="main">
			<div class="jumbotron">			
				<?php
					$array = $db->fetch_all("SELECT * FROM `classifications`");
					if($array != NULL)
					{
						echo "<h3><b>".GENERAL_CLASSIFICATION."</b></h3>";
						echo "<table class='table table-responsive table-condensed table-hover'>
								<thead>
									<tr>
										<th>".RACE_NAME."</th>
									</tr>
								</thead>
							<tbody>";
						foreach($array as $key => $val)
						{
							echo "<tr style='cursor:pointer;' onclick='window.document.location=`".$array[$key]['url']."_classification`;'>
									<td><a href='".$array[$key]['url']."_classification'>".$array[$key]['name']."</a></td>
								</tr>";
						}
						echo "</tbody>
							</table>";
					}else{
						echo "<h3 style='text-align:center;'>"."</h3>";
					}
				?>		
				<h3><b><?php echo SINGLE_RACES;?></b></h3>
				<?php
					notify();
					$array = $db->fetch_all("SELECT * FROM `races` WHERE `races`.`date` <= CURDATE() ORDER BY `races`.`date` DESC ");
					if($array != NULL)
					{
						echo "<table class='table table-responsive table-condensed table-hover'>
								<thead>
									<tr>
										<th>".RACE_NAME."</th>
										<th>".RACE_ORGANIZER."</th>
										<th>".DATE."</th>
										</tr>
									</thead>
								<tbody>";
						foreach($array as $key => $val)
						{
							$array[$key]['date'] = DateTime::createFromFormat('Y-m-d',$array[$key]['date']);
							$array[$key]['date'] = $array[$key]['date']->format('d-m-Y');
							echo "<tr style='cursor:pointer;' onclick='window.document.location=`".$array[$key]['url']."`;'>
									<td><a href='".$array[$key]['url']."'>".$array[$key]['name']."</a></td>
									<td>".$array[$key]['organizer']."</td>
									<td>".$array[$key]['date']."</td>
								</tr>";
						}
						echo "</tbody>
							</table>";
					}else{
						echo "<h3 style='text-align:center;'>".NO_SCORES."</h3>";
					}
				?>		
			</div>			
		</div>

<?php @require_once("footer.php"); ?>