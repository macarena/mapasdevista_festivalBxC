<head>
<title>Sync</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<form enctype="multipart/form-data">
<?php
ini_set('default_charset', 'UTF-8');

include_once '../colab/db.php';
mysql_connect($db_host,$db_username,$db_password);
mysql_select_db($db_name) or die(mysql_error());

//Listando todos os projetos por local
$result = mysql_query("SELECT id, post_title FROM `wp_posts` WHERE post_type LIKE 'post'");

while($row = mysql_fetch_assoc($result)) {
	$projetos[$row[id]] = $row;
}

//coloancando ids dos pins para cada categoria na mão (falta uma semana pro festival PORRA!)
$pin = array();
$pin[1] = array(1463,1464,1465,1466); //música
$pin[2] = array(1459,1460,1461,1462); //artes integradas
$pin[4] = array(1443,1444,1445,1446); //audio visual
$pin[5] = array(1483,1501,1502,1503); //teatro
$pin[6] = array(1472,1480,1481,1482); //performance
$pin[7] = array(1504,1505,1506,1507); //letras
$pin[8] = array(1455,1456,1457,1458); //encontros & passeios
$pin[9] = array(1451,1452,1453,1454); //dança
$pin[10] = array(1447,1448,1449,1450); //conversas, debates, laboratórios
$pin[11] = array(1508,1509,1510,1511); //cultura digital
$pin[12] = array(1512,1513,1514,1515); //oficinas

foreach($projetos as $projeto) {
	$id = $projeto[id];
	
	$result2 = mysql_query("SELECT term_taxonomy_id
							FROM `wp_term_relationships`
							WHERE `object_id` =$id");
	//print_r($result2);
	while($row2 = mysql_fetch_array($result2)) {
		if ($row2[0] < 13 and $row[0] != 3) {
			$category = $row2[0];
		}
	}
	$pin_id = $pin[$category][mt_rand(0, 3)];
	echo "<input type=\"hidden\" name=\"projetos[$id][id]\" value=\"$id\">";
	echo "<input type=\"hidden\" name=\"projetos[$id][nome]\" value=\"$projeto[post_title]\">";
	echo "<input type=\"hidden\" name=\"projetos[$id][pin]\" value=\"$pin_id\">";
	echo "$id - $projeto[post_title] - cat$category - $pin_id";
	echo "<br />\n";
}
?>
 <button type="submit" formaction="include_cat.php" formmethod="post">incluir!</button> 
</form>

</body>
