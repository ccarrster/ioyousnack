<?php
require_once('config.php');
$storeId = 1;
if(isset($_GET['storeId'])){
	$storeId = (int)$_GET['storeId'];
}
?>
<html>
<body>
Reports<br/>
<?php
			$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
			mysql_select_db($dbName);
			echo('Hour of Consumption Report<br/>');
			$query = "select HOUR(exchangeTime) as gmthour, count(*) as count from buypaylog where storeid = $storeId AND delta > 0 group by HOUR(exchangeTime);";
			$result = mysql_query($query);
			$arrayIndex = 0;
			$hours = array();
			for($i = 0; $i < 24; $i++){
				$hours[$i] = 0;
			}

			while($row = mysql_fetch_array( $result )) {
				$hours[$row['gmthour']] = $row['count'];
			}

			for($i = 5; $i < 24; $i++){
				echo($i - 5 . ' ' . $hours[$i] . '<br/>');
			}
			for($i = 0; $i < 5; $i++){
				echo((19 + $i) . ' ' . $hours[$i] . '<br/>');
			}
			echo('<br/>');
			echo('Hour of Collection Report<br/>');
			$query = "select HOUR(exchangeTime) as gmthour, count(*) as count from buypaylog where storeid = $storeId AND delta < 0 group by HOUR(exchangeTime);";
			$result = mysql_query($query);
			$arrayIndex = 0;
			$hours = array();
			for($i = 0; $i < 24; $i++){
				$hours[$i] = 0;
			}

			while($row = mysql_fetch_array( $result )) {
				$hours[$row['gmthour']] = $row['count'];
			}

			for($i = 5; $i < 24; $i++){
				echo($i - 5 . ' ' . $hours[$i] . '<br/>');
			}
			for($i = 0; $i < 5; $i++){
				echo((19 + $i) . ' ' . $hours[$i] . '<br/>');
			}
?>
<a href="index.php?storeId=<?php echo($storeId); ?>"/>Buy/Pay</a> <a href="manageEaters.php?storeId=<?php echo($storeId); ?>">Manage Eaters</a> <a href="manageEats.php?storeId=<?php echo($storeId); ?>">Manage Eats</a> Reports</br>
<a href="mailto:ccarrster@gmail.com">ccarrster@gmail.com</a>
</div>
</body>
</html>