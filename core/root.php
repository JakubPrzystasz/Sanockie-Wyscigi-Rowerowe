<?php

	@session_start();
	//get configuration from database
	{
	$db = new db();
	$_SESSION = $db->fetch("SELECT title,full_name,language,author,description,keywords FROM `config` WHERE `id` = 1");
	$GLOBALS = $db->fetch("SELECT modules,theme FROM `config` WHERE `id` = 1");
	}

	/* DATABASE FUNCTIONS */
	class db
	{
		private function connect()
		{
			//load config
			$CONFIG = parse_ini_file(dirname( __FILE__ )."/config.ini");
			//sets new connection to database 
			$connection = @new mysqli($CONFIG['DB_SERVER'],$CONFIG['DB_USER'],$CONFIG['DB_PASSWORD'],$CONFIG['DB_NAME']);
				
			//if connection gives error, set error notification 
			if ($connection->connect_errno != 0)
			{
				echo "<h1 style='color:red;'>Critical error! Couldn't connect to database. Error code: ".$connection->connect_errno."</h1>";
				return false;
				exit();
			}else{
				$connection->set_charset("utf8");
				return $connection;
			}
		}
		
		public function query($question)
		{
			$connection = $this->connect();
			$result = $connection->query($question);
			$this->close($connection);
			if($result != false)
			{
				return  $result;
			}else{
				return NULL;
			}
		}

		public function fetch($question)
		{
			$query = $this->query($question);
			$result = $query->fetch_assoc();
			if($result != false)
			{
				return  $result;
			}else{
				return NULL;
			}
		}
		public function fetch_all($question)
		{
			$query = $this->query($question);
			$result = [];
			while($data = $query->fetch_assoc())
			{
				$result[] = $data;
			}
			if($result != false)
			{
				return  $result;
			}else{
				return NULL;
			}
		}
		public function num_rows($question)
		{
			$query = $this->query($question);
			$result = $query->num_rows;
			if($result != false)
			{
				return  $result;
			}else{
				return NULL;
			}
		}

		private function close($connection)
		{
			$connection->close();
		}
	}

	/* MISC */

	function sort_array(&$array,$key)
	{
		$temp = array();
		foreach($array as $k => $val)
		{
			$temp[$k] = $val[$key];
		}
		arsort($temp);
		$return = array();
		foreach($temp as $k => $val)
		{
			$return[$k] = $array[$k];
		}
		$array = $return;
	}

	function sort_key(&$array,&$keys)
	{
		$temp = array();
		$races = array();
		$user = array();
		foreach($array as $key => $val)
		{
			foreach($val as $k => $v)
			{
				if(in_array($k,$keys))
				{
					$races[$k] = $v;
				}else{
					$user[$k] = $v;
				}
				$temp[$key] = array_merge($races,$user);
			}
		}
		$array = $temp;
	}

?>
