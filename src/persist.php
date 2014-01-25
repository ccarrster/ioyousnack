<?php
	require_once('config.php');
	$id = $_GET['id'];
	$price = $_GET['price'];
	if(preg_match("/^[0-9]+$/i", $id) && preg_match("/^-?[0-9]+$/i", $price)){
		$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
		mysql_select_db($dbName);
		$query = "update eater set debt = debt + " . $price . " where id = " . $id;
		mysql_query($query);
		$query = "insert into log (eater, change) values('" . $id . "', '" . $price . "');";
		error_log($query, 3, '/tmp/borken.log');
		mysql_query($query);
	}
?>
