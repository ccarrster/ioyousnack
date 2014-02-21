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
	if(isset($_POST['action']) && $_POST['action'] == 'createEater'){
		$name = $_POST['name'];
		if(!preg_match("/^[a-z0-9 ]+$/i", $name)){
			$name = 'name fail';
		}
		$picture = '';
		if(isset($_FILES["picture"]) && $_FILES["picture"]["name"] != '' && preg_match("/^[a-z0-9 ._]+$/i", $_FILES["picture"]["name"])){
			move_uploaded_file($_FILES["picture"]["tmp_name"], "eaters/" . $_FILES["picture"]["name"]);
			$picture = $_FILES["picture"]["name"];
			if($siteUrl != ''){
				$mustachify = 'http://mustachify.me/?src=' . $siteUrl . '/';
				$stash = file_get_contents($mustachify.'eaters/'.$picture);
				file_put_contents('eaters/'.$picture, $stash);
			}
		}
		$query = "insert into eater (name, picture, debt) values('".$name."', '".$picture."', 0);";
		mysql_query($query);
		echo('**Created User ' . $name . '**</br>');
	} else if(isset($_POST['action']) && $_POST['action'] == 'updateEater'){
		$name = $_POST['name'];
		if(!preg_match("/^[a-z0-9 ]+$/i", $name)){
			$name = 'name fail';
		}
		$debt = $_POST['debt'];
		if(!preg_match("/^-?[0-9]+$/i", $debt)){
			$debt = 0;
		}
		$id = $_POST['id'];
		if(!preg_match("/^[0-9]+$/i", $id)){
			$id = -1;
		}
		if(isset($_FILES["picture"]) && $_FILES["picture"]["name"] != '' && preg_match("/^[a-z0-9 ._]+$/i", $_FILES["picture"]["name"])){
			move_uploaded_file($_FILES["picture"]["tmp_name"], "eaters/" . $_FILES["picture"]["name"]);
			$picture = $_FILES["picture"]["name"];
			if($siteUrl != ''){
				$mustachify = 'http://mustachify.me/?src=' . $siteUrl . '/';
				$stash = file_get_contents($mustachify.'eaters/'.$picture);
				file_put_contents('eaters/'.$picture, $stash);
			}
			$query = "update eater set name='".$name."', picture='".$picture."', debt='".$debt."' where id = ".$id.";";
		} else {
			$query = "update eater set name='".$name."', debt='".$debt."' where id = ".$id.";";
		}
		mysql_query($query);
		echo('**Updated User ' . $name . '**</br>');
	} else if(isset($_POST['action']) && $_POST['action'] == 'deleteEater'){
		$id = $_POST['id'];
		if(!preg_match("/^[0-9]+$/i", $id)){
			$id = -1;
		}
		$query = "delete from eater where id = ".$id.";";
		mysql_query($query);
		echo('**Deleted User ' . $id . '**</br>');
	}
} else {
	echo('Access from your IP Address is restricted - Changes will not persist</br>');
}
?>
Create User</br>
<form method="POST" enctype="multipart/form-data">
Name <input type="text" name="name"/></br>
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
	if($row['picture'] != ''){
		echo('user.image="'.$row['picture'].'";');
	} else {
		echo('user.image="human.jpg";');
	}
	echo('user.id="'.$row['id'].'";');
	echo('users['.$arrayIndex++.']=user;');
}
?>
for (index = 0; index < users.length; ++index) {
	document.write('<div style="width:200px; border:thick solid #FFFFFF; float:left;">');
	document.write('<form method="POST" enctype="multipart/form-data">');
	document.write('<div>');
	document.write('<img src="eaters/'+users[index].image+'" style="width:100px; height:100px;"/>');
	document.write('<input type="file" name="picture"/>');
	document.write('</div>');
	document.write('Name <input type="text" name="name" value="'+users[index].name+'"/></br>');
	document.write('Debt <input type="text" name="debt" value="'+users[index].debt+'"/></br>');
	document.write('<input type="hidden" name="id" value="'+users[index].id+'"/>');
	document.write('<input type="hidden" name="action" value="updateEater"/>');
	document.write('<input type="submit"/></br>');
	document.write('</form>');
	document.write('<form method="post">');
	document.write('<input type="hidden" name="id" value="'+users[index].id+'"/>');
	document.write('<input type="hidden" name="action" value="deleteEater"/>');
	document.write('<input type="submit" value="delete"/></br>');
	document.write('</form>');
	document.write('</div>');
}
</script>
<div style="clear:both;">
<a href="index.php">Buy/Pay</a> Manage Eaters <a href="manageEats.php">Manage Eats</a> <a href="report.php">Reports</a></br>
<a href="mailto:ccarrster@gmail.com">ccarrster@gmail.com</a>
</div>
<div>
	<img src="http://placekitten.com/800/150"/>
</div>
</body>
</html>
