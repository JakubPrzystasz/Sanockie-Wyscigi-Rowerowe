<?php

	$page_name = EDIT; @require_once("header.php"); if(!is_admin()){set_notification(ERRNO_23,"warning");header("Location:login");exit;}
	if(isset($_GET['article_id']) AND $_GET['article_id'] != NULL)
	{
		$array = $db->fetch(sprintf("SELECT * FROM `articles` WHERE `articles`.`url_id` = '%s';",$_GET['article_id']));
	}
	
?>
		<script src="<?php theme_dir()?>ckeditor/ckeditor.js"></script>
		<div id="main">
			<div class="jumbotron" style="text-align:center;">
				<form method="post">
				<div style="max-width:700px;margin:auto;">
					<div class="form-group">
						<label for="article_title"><?php echo TITLE; ?></label>
						<input
							<?php 
							if(isset($_GET['article_id']) AND $_GET['article_id'] != NULL)
							{
								printf("value='%s'",$array['title']);							
							}
							?>
						type="text" class="form-control" id="article_title" name="article_title" placeholder="<?php echo TITLE;?>">
					</div>
					<div class="form-group">
						<label for="article_url"><?php echo URL; ?></label>
						<input
							<?php 
							if(isset($_GET['article_id']) AND $_GET['article_id'] != NULL)
							{
								printf("value='%s'",$array['url']);							
							}
							else if(isset($_GET['race_id']) AND $_GET['race_id'] != NULL)
							{
								$race = $db->fetch(sprintf("SELECT `url` FROM `races` WHERE `url_id` = '%s';",$_GET['race_id']));
								printf("value='%s'",$race['url']);							
							}
							?>
						type="text" class="form-control" id="article_url" name="article_url" placeholder="<?php echo URL;?>">
					</div>
					<div class="form-group">
						<label for="article_language"><?php echo LANGUAGE; ?></label><br>
						<?php 			
						$files = scandir("lang", 1);
						foreach($files as $val)
						{
								
							if($val != "." AND $val != ".." AND $val != "README.txt" AND file_exists("lang"."/".$val."/translation.php") AND file_exists("lang"."/".$val."/config.ini"))
							{
								if($array['language'] == $val)
								{
									echo '<label class="radio-inline"><input checked type="radio" name="article_language" value="'.$val.'">'.$val.'</label>';
								}else{
									echo '<label class="radio-inline"><input type="radio" name="article_language" value="'.$val.'">'.$val.'</label>';
									
								}
							}
						}		
						?>	
					</div>
					</div>
					<div class="form-group">
						<label><?php echo EDITOR_TYPE;?></label><br>
						<label class="radio-inline"><input checked type="radio" name="editor" value="simple"><?php echo SIMPLE;?></label>
						<label class="radio-inline"><input type="radio" name="editor" value="advanced"><?php echo ADVANCED;?></label>
						<textarea class="form-control" rows="15" id="editor" name="article_text" class="form-control">
							<?php 
							if(isset($_GET['article_id']) AND $_GET['article_id'] != NULL)
							{
								echo $array['text'];							
							}
							?>
						</textarea>
					</div>

					<script>
						$("input:radio[value='advanced']").click(function(){
							CKEDITOR.replace('editor');
						});
						$("input:radio[value='simple']").click(function(){
							CKEDITOR.instances.editor.destroy(true);
						});
					</script>
					
					<div class="from-group">
						<?php 
							if(isset($_GET['article_id']) AND $_GET['article_id'] != NULL)
							{
								echo '<button type="button" class="btn btn-default" onclick="if(confirm(`'.U_RIGHT.'`)==true){window.document.location=`index.php?site=delete&article_id='.$_GET['article_id'].'`;}">'.DELETE.'</button>';	
							}
						?>
						<input type="hidden" name="article_id" value="<?php echo $_GET['article_id']; ?>">
						<button type="submit" class="btn btn-default" name="article_submit" value="true"><?php echo APPLY; ?></button>
						<?php 
							if(isset($_GET['article_id']) AND $_GET['article_id'] != NULL)
							{
								echo '<button type="button" class="btn btn-default" onclick="window.document.location=`'.$array['url'].'`;">'.PREVIEW.'</button>';	
							}
						?>
					</div>
				</form>		
			</div>			
		</div>

<?php @require_once("footer.php"); ?>