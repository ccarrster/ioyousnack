<?php
	$id = $_GET['id'];
	$price = $_GET['price'];
	$link = mysql_connect('localhost', 'root', 'F3ckth1s');
	mysql_select_db('mysql');
	$query = "update eater set debt = debt + " . $price . " where id = " . $id;
	mysql_query($query);
?>
