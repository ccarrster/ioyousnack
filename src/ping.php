<?php
	require_once('config.php');
	if(isset($ipWhiteList) && ($ipWhiteList == '' || strpos($_SERVER['REMOTE_ADDR'], $ipWhiteList) === 0)){
			$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
			mysql_select_db($dbName);
			$query = "select id from eater";
			$result = mysql_query($query);
			var_dump($result);
	}

?>
