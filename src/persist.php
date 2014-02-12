<?php
	require_once('config.php');
	if(isset($ipWhiteList) && ($ipWhiteList == '' || strpos($_SERVER['REMOTE_ADDR'], $ipWhiteList) === 0)){
		$id = $_GET['id'];
		$productid = $_GET['productid'];
		$price = $_GET['price'];
		if(preg_match("/^[0-9]+$/", $id) && preg_match("/^-?[0-9]+$/", $price) && preg_match("/^[0-9]+$/", $productid)){
			$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
			mysql_select_db($dbName);
			$query = "update eater set debt = debt + " . $price . " where id = " . $id;
			mysql_query($query);
			$query = "select debt from eater where id = " . $id;
			$result = mysql_query("select debt from eater;");
			$arrayIndex = 0;
			while($row = mysql_fetch_array( $result )) {
				$debt = $row['debt'];
			}
			$query = "insert into buypaylog (eaterid, eatid, delta, debt, exchangeTime) values('" . $id . "', '" . $productid . "', '" . $price . "', '" . $debt . "', now());";
			mysql_query($query);
			echo($debt);
		}
	}

?>
