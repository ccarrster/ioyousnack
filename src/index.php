<html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script language="javascript">
 var users = new Array();
 
 var eats = new Array();
 
 var money = new Array();
 var unit = new Object();
 unit.price="5";
 unit.image="nickel.jpg";
 money[0] = unit;
 
 var unit = new Object();
 unit.price="10";
 unit.image="dime.jpg";
 money[1] = unit;
 
 var unit = new Object();
 unit.price="25";
 unit.image="quarter.jpg";
 money[2] = unit;
 
 var unit = new Object();
 unit.price="100";
 unit.image="loonie.jpg";
 money[3] = unit;
 
 var unit = new Object();
 unit.price="200";
 unit.image="toonie.jpg";
 money[4] = unit;
 
 var unit = new Object();
 unit.price="500";
 unit.image="five.jpg";
 money[5] = unit;
 
 var unit = new Object();
 unit.price="1000";
 unit.image="ten.jpg";
 money[6] = unit;
 
 var unit = new Object();
 unit.price="2000";
 unit.image="twenty.jpg";
 money[7] = unit;
 
 var userSelected = null;
 function selectUser(id){
 	clearUserSelected();
 	userSelected = id;
 	var element = document.getElementById(id);
 	element.style.border = "thick solid #0000FF";
 }
 
 function clearUserSelected(){
 	if(userSelected != null){
 		var element = document.getElementById(userSelected);
 		element.style.border = "thick solid #FFFFFF";
 		userSelect = null;
 	}
 }
 
 function buy(id){
 	if(userSelected != null){
		var selectedId = users[userSelected].id;
 		$.get( "persist.php?id="+selectedId+"&price="+eats[id].price);
		users[userSelected].debt = parseFloat(users[userSelected].debt) + parseFloat(eats[id].price);
 		document.getElementById('debt' + userSelected).innerHTML = '$' + formatMoney(users[userSelected].debt); 
 		clearUserSelected();
 	}
 }
 
  function pay(id){
 	if(userSelected != null){
		var selectedId = users[userSelected].id;
 		$.get( "persist.php?id="+selectedId+"&price=-"+money[id].price);
		users[userSelected].debt = parseFloat(users[userSelected].debt) - parseFloat(money[id].price);
 		document.getElementById('debt' + userSelected).innerHTML = '$' + formatMoney(users[userSelected].debt); 
 		clearUserSelected();
 	}
 }
 
 function formatMoney(pennies){
 	penniesString = pennies.toString();
 	while(penniesString.length < 3){
 		penniesString = "0" + penniesString;
 	}
 	penniesString = penniesString.substring(0, penniesString.length - 2) + "." + penniesString.substring(penniesString.length - 2);
 	return penniesString;
 }
 
</script>
<body>
<script language="javascript">
<?php
$link = mysql_connect('localhost', 'root', 'F3ckth1s');
mysql_select_db('mysql');
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
</script>
<h1>Guess Wholip IO You Snacks</h1>
<div>
Click Your Face
</div>
<script language="javascript">
for (index = 0; index < users.length; ++index) {
	document.write('<div onclick="selectUser(this.id);" id="'+index+'" style="width:100px; border:thick solid #FFFFFF; float:left;">');
	document.write('<div>');
	document.write('<img src="eaters/'+users[index].image+'"/>');
	document.write('</div>');
	document.write('<div style="width:100px; text-align:center;">'+users[index].name+'</div>');
	document.write('<div id="debt'+index+'" style="color:red; width:100px; text-align:center;">$'+formatMoney(users[index].debt)+'</div>');
	document.write('</div>');
}

document.write('<div style="clear:both;">');
document.write('Click Your Yums');
document.write('</div>');

for (index = 0; index < eats.length; ++index) {
	document.write('<div onclick="buy('+index+');" id="'+index+'" style="width:100px; float:left;">');
	document.write('<div>');
	document.write('<img style="width:100px; height:100px;" src="eats/'+eats[index].image+'"/>');
	document.write('</div>');
	document.write('<div style="width:100px; text-align:center;">'+eats[index].name+'</div>');
	document.write('<div style="width:100px; text-align:center;">$'+formatMoney(eats[index].price)+'</div>');
	document.write('</div>');
}

document.write('<div style="clear:both;">');
document.write('Pay your debts');
document.write('</div>');

for (index = 0; index < money.length; ++index) {
	document.write('<div onclick="pay(this.id);" id="'+index+'" style="width:100px; float:left;">');
	document.write('<div>');
	document.write('<img style="width:100px; height:100px;" src="money/'+money[index].image+'"/>');
	document.write('</div>');
	document.write('<div style="width:100px; text-align:center;">$'+formatMoney(money[index].price)+'</div>');
	document.write('</div>');
}
</script>

</body>
</html>
