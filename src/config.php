<?php
$dbUrl = 'localhost';
$dbPassword = 'password';
$dbUser = 'root';
$dbName = 'mysql';
$appName = 'Snack Tracker';
$ipWhiteList = '';
$siteUrl = '';

$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
mysql_select_db($dbName);
$result = mysql_query("select ipwhitelist, name, url from store where id = $storeId;");
$arrayIndex = 0;
while($row = mysql_fetch_array( $result )) {
	$ipWhiteList = $row['ipwhitelist'];
	$appName = $row['name'];
	$siteUrl = $row['url'];
}
?>