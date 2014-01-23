<html>
<body>
<?php
if(isset($_POST['action']) && $_POST['action'] == 'createEater'){
	$name = $_POST['name'];
	$picture = '';
	if(isset($_FILES["picture"])){
		move_uploaded_file($_FILES["picture"]["tmp_name"], "eaters/" . $_FILES["picture"]["name"]);
		$picture = $_FILES["picture"]["name"];
	}
	$link = mysql_connect('localhost', 'root', 'F3ckth1s');
	mysql_select_db('mysql');
	$query = "insert into eater (name, picture, debt) values('".$name.", '".$picture."', 0);";
	mysql_query($query);
	echo('**Created User ' . $name . '**</br>');
}
?>
Create User</br>
<form method="POST" enctype="multipart/form-data">
<input type="text" name="name"/></br>
<input type="file" name="picture"/></br>
<input type="hidden" name="action" value="createEater"/>
<input type="submit"/></br>
</form>
</body>
</html>
