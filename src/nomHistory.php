<?php
	require_once('config.php');
	if(isset($ipWhiteList) && ($ipWhiteList == '' || strpos($_SERVER['REMOTE_ADDR'], $ipWhiteList) === 0)){
		$id = $_GET['id'];
		if(preg_match("/^[0-9]+$/", $id)){
			$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
			
			$query = "select 'id', 'name' from eat;";
			$result = mysql_query($query);
			$eatRows = array();
			while($row = mysql_fetch_array( $result )) {
				$eatRows[] = $row;
			}

			mysql_select_db($dbName);
			$query = "select eatid, delta, exchangeTime from buypaylog where eaterid = " . $id . " order by exchangeTime desc limit 5;";
			$result = mysql_query($query);
			$rows = array();
			while($row = mysql_fetch_array( $result )) {
				if($row['delta'] > 0){
					$row['name'] = $row['eatid'] . print_r($eatRows, true);
				} else {
					$row['name'] = 'Payed ' . $row['delta'];
				}
				$rows[] = $row;
			}
			echo(json_encode($rows));
		}
	}

?>
