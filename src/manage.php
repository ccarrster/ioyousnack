<html>
<body>
<?php
$link = mysql_connect('localhost', 'root', 'F3ckth1s');
mysql_select_db('mysql');

if(isset($_POST['action']) && $_POST['action'] == 'createEater'){
	$name = $_POST['name'];
	$picture = '';
	if(isset($_FILES["picture"])){
		move_uploaded_file($_FILES["picture"]["tmp_name"], "eaters/" . $_FILES["picture"]["name"]);
		$picture = $_FILES["picture"]["name"];
	}
	$query = "insert into eater (name, picture, debt) values('".$name."', '".$picture."', 0);";
	mysql_query($query);
	echo('**Created User ' . $name . '**</br>');
}
if(isset($_POST['action']) && $_POST['action'] == 'updateEater'){
	$name = $_POST['name'];
	$debt = $_POST['debt'];
	$picture = '';
	//TODO blow away old picture
	if(isset($_FILES["picture"])){
		move_uploaded_file($_FILES["picture"]["tmp_name"], "eaters/" . $_FILES["picture"]["name"]);
		$picture = $_FILES["picture"]["name"];
	}
	$query = "update eater set name='".$name."', picture='".$picture."', debt='".$debt."';";
	mysql_query($query);
	echo('**Updated User ' . $name . '**</br>');
}
?>
Create User</br>
<form method="POST" enctype="multipart/form-data">
<input type="text" name="name"/></br>
<input type="file" name="picture"/></br>
<input type="hidden" name="action" value="createEater"/>
<input type="submit"/></br>
</form>
<script language="javascript">
	var users = new Array();

<?php
$result = mysql_query("select * from eater;");
$arrayIndex = 0;
while($row = mysql_fetch_array( $result )) {
	echo('var user = new Object();');
	echo('user.name="'.$row['name'].'";');
	echo('user.debt="'.$row['debt'].'";');
	echo('user.image="'.$row['picture'].'";');
	echo('user.id="'.$row['id'].'";');
	echo('users['.$arrayIndex++.']=user;');
}
?>
for (index = 0; index < users.length; ++index) {
	document.write('<div style="width:100px; border:thick solid #FFFFFF; float:left;">');
	document.write('<form method="POST" enctype="multipart/form-data">');
	document.write('<div>');
	document.write('<img src="eaters/'+users[index].image+'" style="width:100px; height:100px;"/>');
	document.write('<input type="file" name="picture"/>');
	document.write('</div>');
	document.write('Name <input type="text" name="name" value="'+users[index].name+'"/></br>');
	document.write('Debt <input type="text" name="name" value="'+users[index].debt+'"/></br>');
	document.write('<input type="hidden" name="updateId" value="'+users[index].id+'"/>');
	document.write('<input type="hidden" name="action" value="updateEater"/>');
	document.write('<input type="submit"/></br>');
	document.write('</form>');
	document.write('</div>');
}
</script>

</body>
</html>
