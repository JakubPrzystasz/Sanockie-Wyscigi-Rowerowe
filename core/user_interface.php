<?php

function all_languages_selector()
{
	//look for directories
	$files = scandir("lang", 1);
	foreach($files as $val)
	{
		if($val != "." AND $val != ".." AND $val != "README.txt" AND file_exists("lang"."/".$val."/translation.php"))
		{
			echo
			"<button class='lang_button btn btn-default btn-sm' onclick='".$val."()'>
					<img class='lang_img' alt='".$val."' src=".lang_dir().$val."/icon.png />
				</button>
				<script type='text/javascript'>
					function ".$val."()
					{
	 					document.cookie = 'lang = ".$val."';
						location.reload(true);
					}
				</script>";
		}
	}
}


function language_selector($lang)
{
	$files = scandir("lang", 1);
	foreach($files as $val)
	{
		if($val != "." AND $val != ".." AND $val != "README.txt" AND $val == $lang)
		{
			echo
			"<button class='lang_button btn btn-default btn-sm' onclick='".$val."()'>
					<img class='lang_img' alt='".$val."' src=".lang_dir().$val."/icon.png />
				</button>
				<script type='text/javascript'>
					function ".$val."()
					{
	 					document.cookie = 'lang = ".$val."';
						location.reload(true);
					}
				</script>";
		}
	}
}



?>