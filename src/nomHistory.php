<?php
	require_once('config.php');
	if(isset($ipWhiteList) && ($ipWhiteList == '' || strpos($_SERVER['REMOTE_ADDR'], $ipWhiteList) === 0)){
		$id = $_GET['id'];
		if(preg_match("/^[0-9]+$/", $id)){
			$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
			mysql_select_db($dbName);
			$query = "select name, exchangeTime from buypaylog join eat on eat.id = eatid where delta > 0 and eaterid = " . $id . " order by exchangeTime desc limit 5;";
			$result = mysql_query($query);
			$rows = array();
			while($row = mysql_fetch_array( $result )) {
				$rows[] = $row;
			}
			echo(json_encode($rows));
		}
	}

?>
