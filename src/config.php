<?php
$dbUrl = 'localhost';
$dbPassword = 'F3ckth1s';
$dbUser = 'root';
$dbName = 'snack';
$appName = 'Snack Tracker';
$ipWhiteList = '';
$siteUrl = '';

$link = mysqli_connect($dbUrl, $dbUser, $dbPassword, $dbName);
$result = mysqli_query($link, "select ipwhitelist, name, url from store where id = $storeId;");
$arrayIndex = 0;
while($row = mysqli_fetch_array( $result )) {
	$ipWhiteList = $row['ipwhitelist'];
	$appName = $row['name'];
	$siteUrl = $row['url'];
}
?>