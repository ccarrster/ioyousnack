<?php
require_once('config.php');
if(isset($_FILES['face'])){
	move_uploaded_file($_FILES["face"]["tmp_name"], 'eaters/' . $_FILES["face"]["name"]);
	$fileName = 'eaters/' . $_FILES["face"]["name"];
}
?>
<html>
<body>
<?php
if(isset($fileName)){
	$mustachify = 'http://mustachify.me/?src=' . $siteUrl . '/';
	$stash = file_get_contents($mustachify.$fileName);
	file_put_contents($fileName, $stash);
	echo('<img src="'.$fileName.'"/>');
}
?>
<form enctype="multipart/form-data" method="post">
	<input type="file" name="face">
	<input type="submit"/>
</form>
</body>
</html>