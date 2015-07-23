<?php
	$storeId = 1;
	if(isset($_GET['storeId'])){
		$storeId = (int)$_GET['storeId'];
	}
	require_once('config.php');
	if(isset($ipWhiteList) && ($ipWhiteList == '' || strpos($_SERVER['REMOTE_ADDR'], $ipWhiteList) === 0)){
		$id = $_GET['id'];
		$productid = $_GET['productid'];
		$price = $_GET['price'];
		if(preg_match("/^[0-9]+$/", $id) && preg_match("/^-?[0-9]+$/", $price) && preg_match("/^[0-9]+$/", $productid)){
			$link = mysqli_connect($dbUrl, $dbUser, $dbPassword, $dbName);
			$query = "update eater set debt = debt + " . $price . " where storeid = $storeId AND id = " . $id;
			mysqli_query($link, $query);
			$query = "select debt from eater where storeid = $storeId AND id = " . $id;
			$result = mysqli_query($link, $query);
			$arrayIndex = 0;
			while($row = mysqli_fetch_array( $result )) {
				$debt = $row['debt'];
			}
			$query = "insert into buypaylog (eaterid, eatid, delta, debt, exchangeTime, storeid) values('" . $id . "', '" . $productid . "', '" . $price . "', '" . $debt . "', now(), $storeId);";
			mysqli_query($link, $query);
			echo($debt);
		}
	}

?>
