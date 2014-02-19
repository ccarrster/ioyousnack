<?php
require_once('config.php');
?>
<html>
<body>
<?php
			$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
			mysql_select_db($dbName);
			$query = "select HOUR(exchangeTime) as gmthour, count(*) as count from buypaylog group by HOUR(exchangeTime);";
			$result = mysql_query($query);
			$arrayIndex = 0;
			while($row = mysql_fetch_array( $result )) {
				echo($row['gmthour']);
				echo($row['count']);
				echo('<br/>');
			}
?>
</body>
</html>