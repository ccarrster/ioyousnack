<?php
require_once('config.php');
?>
<html>
<body>
Reports<br/>
<?php
			$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
			mysql_select_db($dbName);
			echo('Hour of Consumption Report<br/>');
			$query = "select HOUR(exchangeTime) as gmthour, count(*) as count from buypaylog where delta > 0 group by HOUR(exchangeTime);";
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
			$query = "select HOUR(exchangeTime) as gmthour, count(*) as count from buypaylog where delta < 0 group by HOUR(exchangeTime);";
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
<a href="index.php"/>Buy/Pay</a> <a href="manageEaters.php">Manage Eaters</a> <a href="manageEats.php">Manage Eats</a> Reports</br>
<a href="mailto:ccarrster@gmail.com">ccarrster@gmail.com</a>
</div>
<div>
	<img src="http://placekitten.com/800/150"/>
</div>
</body>
</html>