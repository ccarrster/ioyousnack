<?php
	$storeId = 1;
	if(isset($_GET['storeId'])){
		$storeId = (int)$_GET['storeId'];
	}
	require_once('config.php');
	if(isset($ipWhiteList) && ($ipWhiteList == '' || strpos($_SERVER['REMOTE_ADDR'], $ipWhiteList) === 0)){
		$id = $_GET['id'];
		if(preg_match("/^[0-9]+$/", $id)){
			$link = mysqli_connect($dbUrl, $dbUser, $dbPassword, $dbName);

			$query = "select id, name from eat WHERE storeid = $storeId;";
			$result = mysqli_query($link, $query);
			$eatRows = array();
			while($row = mysqli_fetch_array( $result )) {
				$eatRows[$row['id']] = $row['name'];
			}

			$query = "select eatid, delta, exchangeTime from buypaylog where storeid = $storeId AND eaterid = " . $id . " order by exchangeTime desc limit 5;";
			$result = mysqli_query($link, $query);
			$rows = array();
			while($row = mysqli_fetch_array( $result )) {
				if($row['delta'] > 0){
					$row['name'] = $eatRows[$row['eatid']];
				} else {
					$row['name'] = 'Paid ' . $row['delta'];
				}
				$rows[] = $row;
			}
			echo(json_encode($rows));
		}
	}

?>
