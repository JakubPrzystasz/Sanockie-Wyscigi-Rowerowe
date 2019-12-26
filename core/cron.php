<?php

	$CONFIG = parse_ini_file(dirname( __FILE__ )."/config.ini");
	$file_dir = "/home/jhmp/domains/swr.hostmc.pl/private_html/database/";
		
	$time = date("Y-m-d_H-i-s");                   
	exec(sprintf("mysqldump --user=%s --password=%s --host=%s %s > %s".$time.".sql",$CONFIG['DB_USER'],$CONFIG['DB_PASSWORD'],$CONFIG['DB_SERVER'],$CONFIG['DB_NAME'],$file_dir));
	
	echo "Backup done";
	
?>