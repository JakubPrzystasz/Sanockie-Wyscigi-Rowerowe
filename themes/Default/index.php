<?php 
	if(!isset($_COOKIE['lang']))
	{
		$language = $_SESSION['language'];
	}
	if(isset($_COOKIE['lang']))
	{
		$language = $_COOKIE['lang'];
	}
	$page_name = MAIN_PAGE; 
	@require_once("header.php");
?>
		
		<div id="main">
			<div class="jumbotron">
				<?php 
					notify();
					$array = $db->fetch(sprintf("SELECT * FROM `articles` WHERE `articles`.`language` = '%s' && `articles`.`url` = 'index' ",$language));
					echo $array['text'];
				?>				
			</div>			
		</div>

<?php @require_once("footer.php"); ?>