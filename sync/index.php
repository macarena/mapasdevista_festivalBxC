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

foreach($projetos as $projeto) {
	$id = $projeto[id];
	//$json = file_get_contents("http://199.127.227.146/bxc2013/colab!projetoMapa.action?codProjetoMysql=$id");
	$values = json_decode($json, true);
	$values = $values[values];
	$lugar = $values[nomLocal];
	
	$result2 = mysql_query("SELECT meta_id FROM `wp_postmeta` WHERE post_id LIKE '$id' AND meta_key LIKE '_mpv_location'");
	//print_r($result2);
	
	$row = mysql_num_rows($result2);
	
	if ($row > 0) echo "<input type=\"hidden\" name=\"projetos[$id][pin]\" value=\"true\">";
	
	echo "<input type=\"hidden\" name=\"projetos[$id][id]\" value=\"$id\">";
	echo "<input type=\"hidden\" name=\"projetos[$id][nome]\" value=\"$projeto[post_title]\">";
	echo "$id - $projeto[post_title] - $lugar<br />\n";
	echo "Lat: <input type=\"text\" name=\"projetos[$id][lat]\"> - Long: <input type=\"text\" name=\"projetos[$id][lng]\"><br />\n";
}
?>
 <button type="submit" formaction="sync.php" formmethod="post">Syncar!</button> 
</form>

</body>
