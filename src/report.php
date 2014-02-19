<?php
require_once('config.php');
?>
<html>
<body>
<?php
			$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
			mysql_select_db($dbName);
			echo('Hour of Consumption Report<br/>');
			$query = "select HOUR(exchangeTime) as gmthour, count(*) as count from buypaylog group by HOUR(exchangeTime);";
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
				echo($i . ' ' . $hours[$i] . '<br/>');
			}
			for($i = 0; $i < 6; $i++){
				echo((19 + $i) . ' ' . $hours[$i] . '<br/>');
			}
?>
</body>
</html>