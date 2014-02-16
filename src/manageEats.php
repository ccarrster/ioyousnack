<?php
require_once('config.php');
?>
<html>
<head>
	<title><?php echo($appName); ?></title>
</head>
<body>
<?php
	$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
	mysql_select_db($dbName);
	if(isset($ipWhiteList) && ($ipWhiteList == '' || strpos($_SERVER['REMOTE_ADDR'], $ipWhiteList) === 0)){
		if(isset($_POST['action']) && $_POST['action'] == 'createEat'){
			$name = $_POST['name'];
			if(!preg_match("/^[a-z0-9 ]+$/i", $name)){
				$name = 'name fail';
			}
			$price = $_POST['price'];
			if(!preg_match("/^[0-9]+$/i", $price)){
				$price = 0;
			}
			if(isset($_POST['enabled'])){
				$enabled = true;
			} else {
				$enabled = false;
			}
			$picture = '';
			if(isset($_FILES["picture"]) && $_FILES["picture"]["name"] != '' && preg_match("/^[a-z0-9 ._]+$/i", $_FILES["picture"]["name"])){
				move_uploaded_file($_FILES["picture"]["tmp_name"], "eats/" . $_FILES["picture"]["name"]);
				$picture = $_FILES["picture"]["name"];
			}
			$query = "insert into eat (name, picture, price, enabled) values('".$name."', '".$picture."', '".$price."', '".$enabled."');";
			mysql_query($query);
			echo('**Created Eat ' . $name . '**</br>');
		} else if(isset($_POST['action']) && $_POST['action'] == 'updateEat'){
			$name = $_POST['name'];
			if(!preg_match("/^[a-z0-9 ]+$/i", $name)){
				$name = 'name fail';
			}
			$price = $_POST['price'];
			if(!preg_match("/^[0-9]+$/i", $price)){
				$price = 0;
			}
			var_dump($POST);
			if(isset($_POST['enabled'])){
				$enabled = true;
			} else {
				$enabled = false;
			}
			$id = $_POST['id'];
			if(!preg_match("/^[0-9]+$/i", $id)){
				$id = -1;
			}
			if(isset($_FILES["picture"]) && $_FILES["picture"]["name"] != '' && preg_match("/^[a-z0-9 ._]+$/i", $_FILES["picture"]["name"])){
				move_uploaded_file($_FILES["picture"]["tmp_name"], "eats/" . $_FILES["picture"]["name"]);
				$picture = $_FILES["picture"]["name"];
				$query = "update eat set enabled = '".$enabled."', name='".$name."', picture='".$picture."', price='".$price."' where id = ".$id.";";
			} else {
				$query = "update eat set enabled = '".$enabled."', name='".$name."', price='".$price."' where id = ".$id.";";
			}
			mysql_query($query);
			echo('**Updated Eat ' . $name . '**</br>');
		} else if(isset($_POST['action']) && $_POST['action'] == 'deleteEat'){
			$id = $_POST['id'];
			if(!preg_match("/^[0-9]+$/i", $id)){
				$id = -1;
			}
			$query = "delete from eat where id = ".$id.";";
			mysql_query($query);
			echo('**Deleted Eat ' . $id . '**</br>');
		}
	} else {
		echo('Access from your IP Address is restricted - Changes will not persist</br>');
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
	echo('eat.enabled="'.$row['enabled'].'";');
	if($row['picture'] != ''){
		echo('eat.image="'.$row['picture'].'";');
	} else {
		echo('eat.image="snacks.jpg";');
	}
	echo('eat.id="'.$row['id'].'";');
	echo('eats['.$arrayIndex++.']=eat;');
}
?>
for (index = 0; index < eats.length; ++index) {
	document.write('<div style="width:200px; border:thick solid #FFFFFF; float:left;">');
	document.write('<form method="POST" enctype="multipart/form-data">');
	document.write('<div>');
	document.write('<img src="eats/'+eats[index].image+'" style="width:100px; height:100px;"/>');
	document.write('<input type="file" name="picture"/>');
	document.write('</div>');
	document.write('Name <input type="text" name="name" value="'+eats[index].name+'"/></br>');
	document.write('Price <input type="text" name="price" value="'+eats[index].price+'"/></br>');
	if(eats[index].enabled == '' || eats[index].enabled == '1'){
		document.write('Enabled <input type="checkbox" checked="checked" name="enabled"/><br/>');
	} else {
		document.write('Enabled <input type="checkbox" name="enabled"/><br/>');
	}
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
<div>
	<img src="http://placekitten.com/800/150"/>
</div>
</body>
</html>
