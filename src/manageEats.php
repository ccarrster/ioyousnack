<html>
<body>
<?php
$link = mysql_connect('localhost', 'root', 'F3ckth1s');
mysql_select_db('mysql');

if(isset($_POST['action']) && $_POST['action'] == 'createEat'){
	$name = $_POST['name'];
	$price = $_POST['price'];
	$picture = '';
	if(isset($_FILES["picture"])){
		move_uploaded_file($_FILES["picture"]["tmp_name"], "eats/" . $_FILES["picture"]["name"]);
		$picture = $_FILES["picture"]["name"];
	}
	$query = "insert into eat (name, picture, price) values('".$name."', '".$picture."', '".$price."');";
	mysql_query($query);
	echo('**Created Eat ' . $name . '**</br>');
} else if(isset($_POST['action']) && $_POST['action'] == 'updateEat'){
	$name = $_POST['name'];
	$price = $_POST['price'];
	$id = $_POST['id'];
	if(isset($_FILES["picture"]) && $_FILES["picture"]["name"] != ''){
		move_uploaded_file($_FILES["picture"]["tmp_name"], "eat/" . $_FILES["picture"]["name"]);
		$picture = $_FILES["picture"]["name"];
		$query = "update eat set name='".$name."', picture='".$picture."', price='".$price."' where id = ".$id.";";
	} else {
		$query = "update eat set name='".$name."', price='".$price."' where id = ".$id.";";
	}
	mysql_query($query);
	echo('**Updated Eat ' . $name . '**</br>');
} else if(isset($_POST['action']) && $_POST['action'] == 'deleteEat'){
	$id = $_POST['id'];
	$query = "delete from eat where id = ".$id.";";
	mysql_query($query);
	echo('**Deleted Eat ' . $id . '**</br>');
}
?>
Create Eat</br>
<form method="POST" enctype="multipart/form-data">
Name <input type="text" name="name"/></br>
Price(cents) <input type="text" name="price"/></br>
<input type="file" name="picture"/></br>
<input type="hidden" name="action" value="createEat"/>
<input type="submit"/></br>
</form>
<script language="javascript">
	var eats = new Array();

<?php
$result = mysql_query("select * from eat;");
$arrayIndex = 0;
while($row = mysql_fetch_array( $result )) {
	echo('var eat = new Object();');
	echo('eat.name="'.$row['name'].'";');
	echo('eat.price="'.$row['price'].'";');
	echo('eat.image="'.$row['picture'].'";');
	echo('eat.id="'.$row['id'].'";');
	echo('eats['.$arrayIndex++.']=eat;');
}
?>
for (index = 0; index < eats.length; ++index) {
	document.write('<div style="width:100px; border:thick solid #FFFFFF; float:left;">');
	document.write('<form method="POST" enctype="multipart/form-data">');
	document.write('<div>');
	document.write('<img src="eats/'+eats[index].image+'" style="width:100px; height:100px;"/>');
	document.write('<input type="file" name="picture"/>');
	document.write('</div>');
	document.write('Name <input type="text" name="name" value="'+eats[index].name+'"/></br>');
	document.write('Price <input type="text" name="price" value="'+eats[index].price+'"/></br>');
	document.write('<input type="hidden" name="id" value="'+eats[index].id+'"/>');
	document.write('<input type="hidden" name="action" value="updateEat"/>');
	document.write('<input type="submit"/></br>');
	document.write('</form>');
	document.write('<form method="post">');
	document.write('<input type="hidden" name="id" value="'+eats[index].id+'"/>');
	document.write('<input type="hidden" name="action" value="deleteEat"/>');
	document.write('<input type="submit" value="delete"/></br>');
	document.write('</form>');
	document.write('</div>');
}
</script>
<div style="clear:both;">
<a href="index.php">Buy/Pay</a> <a href="manageEaters.php">Manage Eaters</a> Manage Eats</br>
<a href="mailto:ccarrster@gmail.com">ccarrster@gmail.com</a>
</div>
</body>
</html>
