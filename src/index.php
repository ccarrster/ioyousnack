<?php
require_once('config.php');
?>
<style>
	.nomnom{
	animation:myfirst 5s;
	-webkit-animation:myfirst 5s; /* Safari and Chrome */
	}

	@keyframes myfirst
	{
	0%   {left:0px; top:0px;}
	25%  {left:0px; top:-6px;}
	30%  {left:0px; top:0px;}
	35%  {left:0px; top:-4px;}
	45%  {left:0px; top:0px;}
	50%  {left:0px; top:-2px;}
	75%  {left:1px; top:0px;}
	85%  {left:0px; top:-1px;}
	95%  {left:-1px; top:0px;}
	100% {left:0px; top:0px;}
	}

	@-webkit-keyframes myfirst /* Safari and Chrome */
	{
	0%   {left:0px; top:0px;}
	25%  {left:0px; top:-3px;}
	30%  {left:0px; top:0px;}
	35%  {left:0px; top:-4px;}
	45%  {left:0px; top:0px;}
	50%  {left:0px; top:-2px;}
	75%  {left:1px; top:0px;}
	85%  {left:0px; top:-1px;}
	95%  {left:-1px; top:0px;}
	100% {left:0px; top:0px;}
	}
</style>
<style id="customAnimation">

</style>
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
	if(userSelected != null){
		var element = document.getElementById(userSelected);
		element.style.border = "thick solid #FFFFFF";
		var historyElement = document.getElementById('nomHistory');
		historyElement.innerHTML = "Past Noms for " + id;
	} else {
		historyElement.innerHTML = "";
	}

 	userSelected = id;
	if(userSelected != null){
		for(i = 0; i < users.length; i++){
			if(i != id){
				var elementToHide = document.getElementById(i);
				elementToHide.style.display = "none";
			}
		}
		var element = document.getElementById(id);
		element.style.border = "thick solid #0000FF";
	} else {
		for(i = 0; i < users.length; i++){
			var elementToShow = document.getElementById(i);
			elementToShow.style.display = "initial";
		}
	}
 }
 
 function buy(id, retry){
 	if(userSelected != null){
 		omnomEats(id, userSelected);
 		omnom(userSelected);
		var selectedId = users[userSelected].id;
 		$.get( "persist.php?id="+selectedId+"&price="+eats[id].price+"&productid="+eats[id].id, function( data ) {
			if(data != ''){
				users[userSelected].debt = data;
				document.getElementById('debt' + userSelected).innerHTML = '$' + formatMoney(users[userSelected].debt);
				if(users[userSelected].debt <= 0){
					document.getElementById('debt' + userSelected).style.color = 'black';
				} else {
					document.getElementById('debt' + userSelected).style.color = 'red';
				}
			} else {
				alert('Transaction not complete');
			}
		}).fail(function() {
			if(retry){
				setTimeout("buy("+id+", false)", 1000);
			} else {
				alert( "error" );
			}
		});;
 	}
 }
 
  function pay(id, retry){
 	if(userSelected != null){
		var selectedId = users[userSelected].id;
		$.get( "persist.php?id="+selectedId+"&price=-"+money[id].price+"&productid="+id, function( data ) {
			if(data != ''){
				users[userSelected].debt = data;
				document.getElementById('debt' + userSelected).innerHTML = '$' + formatMoney(users[userSelected].debt);
				if(users[userSelected].debt <= 0){
					document.getElementById('debt' + userSelected).style.color = 'black';
				} else {
					document.getElementById('debt' + userSelected).style.color = 'red';
				}
			} else {
				alert('Transaction not complete');
			}
		}).fail(function() {
			if(retry){
				setTimeout("pay("+id+", false)", 1000);
			} else {
				alert( "error" );
			}
		});

 	}
 }

var nomToClear = new Array();
var foodToClear = new Array();
 
function omnom(nomIndex){
	var nomId = 'nomtop' + nomIndex;
	document.getElementById('nomtop' + nomIndex).className = "nomnom";
	nomToClear.push('nomtop' + nomIndex);
	setTimeout("clearOmnom()",6000);
}
function clearOmnom(){
	for(i = 0; i < nomToClear.length; i++){
		document.getElementById(nomToClear[i]).className = "";
	}
}
function clearFood(){
	for(i = 0; i < foodToClear.length; i++){
		document.getElementById(foodToClear[i]).className = "";
	}
}

function omnomEats(from, to){
	var elementFrom = document.getElementById('eat'+from);
	var rectFrom = elementFrom.getBoundingClientRect();
	var elementTo = document.getElementById(to);
	var rectTo = elementTo.getBoundingClientRect();
	var styleElement = document.getElementById('customAnimation');
	var yChange = rectTo.top - rectFrom.top;
	var xChange = rectTo.left - rectFrom.left;
	styleElement.innerHTML = '	.nomnomEat{\
	animation:mysecond 1s;\
	-webkit-animation:mysecond 1s; /* Safari and Chrome */\
	}\
\
	@keyframes mysecond\
	{\
	0%   {left:0px; top:0px;}\
	50%   {left:'+xChange+'px; top:'+yChange+'px;}\
	100% {left:0px; top:0px;}\
	}\
\
	@-webkit-keyframes mysecond /* Safari and Chrome */\
	{\
	0%   {left:0px; top:0px;}\
	50% {left:'+xChange+'px; top:'+yChange+'px;}\
	100% {left:0px; top:0px;}\
	}';
	document.getElementById('eat'+from).className = "nomnomEat";
	console.log(document.getElementById('eat'+from));
	eatFrom = from;
	foodToClear.push('eat'+eatFrom);
	setTimeout("clearFood()",1100);
}

var eatFrom;

 
 function formatMoney(pennies){
	 if(pennies < 0){
		 pennies = pennies * -1;
	 }
 	penniesString = pennies.toString();
 	while(penniesString.length < 3){
 		penniesString = "0" + penniesString;
 	}
 	penniesString = penniesString.substring(0, penniesString.length - 2) + "." + penniesString.substring(penniesString.length - 2);
	if(pennies < 0){
		penniesString = penniesString.substring(1);
	}
 	return penniesString;
 }
 
</script>
<head>
	<title><?php echo($appName); ?></title>
</head>
<body>
<?php
if(isset($ipWhiteList) && $ipWhiteList != '' && strpos($_SERVER['REMOTE_ADDR'], $ipWhiteList) !== 0){
	echo('Access from your IP Address is restricted - Changes will not persist');
}
?>
<script language="javascript">
<?php
$link = mysql_connect($dbUrl, $dbUser, $dbPassword);
mysql_select_db($dbName);
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

$result = mysql_query("select eat.*, (SELECT count(eatid) from buypaylog where buypaylog.eatid = eat.id group by eatid) as sold from eat;");
$arrayIndex = 0;
while($row = mysql_fetch_array( $result )) {
	echo('var eat = new Object();');
	echo('eat.name="'.$row['name'].'";');
	echo('eat.price="'.$row['price'].'";');
	echo('eat.enabled="'.$row['enabled'].'";');
	echo('eat.sold="'.$row['sold'].'";');
	if($row['picture'] != ''){
		echo('eat.image="'.$row['picture'].'";');
	} else {
		echo('eat.image="snacks.jpg";');
	}
	echo('eat.id="'.$row['id'].'";');
	echo('eats['.$arrayIndex++.']=eat;');

}
?>
eats.sort(function(a, b){
	if(a.sold == b.sold){
		return 0;
	} else if(a.sold < b.sold){
		return 1;
	} else {
		return -1;
	}
});

<?php

$result = mysql_query("select eatid, count(eatid) as count from buypaylog where delta > 0 group by eatid order by count desc;");
while($row = mysql_fetch_array( $result )) {
	$row['eatid'];
}
?>
</script>
<h1><?php echo($appName); ?></h1>
<div>
Click Your Face
</div>
<script language="javascript">
for (index = 0; index < users.length; ++index) {
	document.write('<div onclick="selectUser(this.id);" id="'+index+'" style="width:100px; border:thick solid #FFFFFF; float:left;">');
	
	document.write('<div style="position:relative;" width:100px; height:100px;">');
	document.write('<div id="nomtop'+index+'" style="position:absolute; width:100px; height:60px; background-image:url(\'eaters/'+users[index].image+'\'); top:0px; left:0px;"></div>');
	document.write('<div id="nombottom" style="position:absolute; width:100px; height:40px; background-image:url(\'eaters/'+users[index].image+'\'); background-position:0px -60px; top:60px; left:0px;"></div>');
	document.write('</div>');
	document.write('<div style="width:100px; height:100px;">');
	document.write('</div>');
	document.write('<div style="width:100px; text-align:center;">'+users[index].name+'</div>');
	var styleColor = 'color:red;';
	if(users[index].debt <= 0){
		styleColor = 'color:black;';
	}
	document.write('<div id="debt'+index+'" style="'+styleColor+' width:100px; text-align:center;">$'+formatMoney(users[index].debt)+'</div>');
	document.write('</div>');
}

</script>
<div>
<form>
				<input style="float:left;" type="button" value="Deselect" onclick="selectUser(null);"/>
</form>
	<div id="historyElement"></div>
</div>
<script language="javascript">

document.write('<div style="clear:both;">');
document.write('Click Your Yums');
document.write('</div>');

for (index = 0; index < eats.length; ++index) {
	if(eats[index].enabled == '' || eats[index].enabled == '1'){
		document.write('<div onclick="buy('+index+', true);" id="'+index+'" style="width:100px; float:left;">');
		document.write('<div style="position:relative;">');
		document.write('<img id="eat'+index+'" style="width:100px; height:100px; position:absolute;" src="eats/'+eats[index].image+'"/>');
		document.write('<div style="width:100px; height:100px;">');
		document.write('</div>');
		document.write('</div>');
		document.write('<div style="width:100px; text-align:center;">'+eats[index].name+'</div>');
		document.write('<div style="width:100px; text-align:center;">$'+formatMoney(eats[index].price)+'</div>');
		document.write('</div>');
	}
}

document.write('<div style="clear:both;">');
document.write('Pay your debts');
document.write('</div>');

for (index = 0; index < money.length; ++index) {
	document.write('<div onclick="pay(this.id, true);" id="'+index+'" style="width:100px; float:left;">');
	document.write('<div>');
	document.write('<img style="width:100px; height:100px;" src="money/'+money[index].image+'"/>');
	document.write('</div>');
	document.write('<div style="width:100px; text-align:center;">$'+formatMoney(money[index].price)+'</div>');
	document.write('</div>');
}
</script>
<div style="clear:both;">
Buy/Pay <a href="manageEaters.php">Manage Eaters</a> <a href="manageEats.php">Manage Eats</a> <a href="report.php">Reports</a></br>
<a href="mailto:ccarrster@gmail.com">ccarrster@gmail.com</a>
</div>
<div>
	<img src="http://placekitten.com/800/150"/>
</div>
</body>
</html>
